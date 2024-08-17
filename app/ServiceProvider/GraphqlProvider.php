<?php

namespace Kanboard\ServiceProvider;

use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Kanboard\Graphql\Type\QueryType;
use Kanboard\Graphql\Type\MutationType;

/**
 * Class GraphqlProvider
 *
 * @package Kanboard\ServiceProvider
 * @author  Mohammed Ashad
 */
class GraphqlProvider implements ServiceProviderInterface {
  /**
   * Registers services on the given container.
   *
   * @param Container $container
   * @return Container
   */
  public function register(Container $container) {
    $queryType = new QueryType();
    $mutationType = new MutationType();

    $schema = new Schema(
      (new SchemaConfig())
        ->setQuery($queryType)
        ->setMutation($mutationType)
    );

    $rootValue = ['prefix' => 'Kanboard'];
    $server = new StandardServer([
      'schema' => $schema,
      'rootValue' => $rootValue,
      'context' => $this->buildContext($container),
    ]);

    $container['graphql'] = $server;
    return $container;
  }

  protected function buildContext(Container $container) {
    return ['container' => $container, 'serverVariable' => $_SERVER];
  }
}
