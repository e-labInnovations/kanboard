<?php

namespace Kanboard\Graphql\Middleware;

use GraphQL\Error\UserError;
use Kanboard\Auth\ApiAccessTokenAuth;
use Kanboard\Core\Base;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AuthenticationGraphqlMiddleware
 *
 * @package Kanboard\Graphql\Middleware
 * @author  Mohammed Ashad MM
 */
class AuthenticationMiddleware extends Base {
    /**
     * Execute Middleware
     *
     * @access public
     * @param  string $username
     * @param  string $password
     * @throws UserError
     */
    public function execute($username, $password) {
        $this->dispatcher->dispatch(new Event, 'app.bootstrap');
        session_set('scope', 'API');

        if ($this->isUserAuthenticated($username, $password)) {
            $this->userSession->initialize($this->userCacheDecorator->getByUsername($username));
        } elseif (! $this->isAppAuthenticated($username, $password)) {
            $this->logger->error('API authentication failure for ' . $username);
            throw new UserError('Wrong credentials');
        }
    }

    /**
     * Check user credentials
     *
     * @access public
     * @param  string  $username
     * @param  string  $password
     * @return boolean
     */
    private function isUserAuthenticated($username, $password) {
        if ($username === 'jsonrpc') {
            return false;
        }

        if ($this->userLockingModel->isLocked($username)) {
            return false;
        }

        if ($this->userModel->has2FA($username)) {
            $this->logger->info('This API user (' . $username . ') as 2FA enabled: only API keys are authorized');
            $this->authenticationManager->reset();
            $this->authenticationManager->register(new ApiAccessTokenAuth($this->container));
        }

        return $this->authenticationManager->passwordAuthentication($username, $password);
    }

    /**
     * Check administrative credentials
     *
     * @access public
     * @param  string  $username
     * @param  string  $password
     * @return boolean
     */
    private function isAppAuthenticated($username, $password) {
        return $username === 'jsonrpc' && $password === $this->getApiToken();
    }

    /**
     * Get API Token
     *
     * @access private
     * @return string
     */
    private function getApiToken() {
        if (defined('API_AUTHENTICATION_TOKEN')) {
            return API_AUTHENTICATION_TOKEN;
        }

        if (getenv('API_AUTHENTICATION_TOKEN')) {
            return getenv('API_AUTHENTICATION_TOKEN');
        }

        return $this->configModel->get('api_token');
    }
}
