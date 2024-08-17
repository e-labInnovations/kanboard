<?php

namespace Kanboard\Graphql\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Error\UserError;
use Kanboard\Api\Procedure\MeProcedure;
use Kanboard\Graphql\TypeRegistry;
use Kanboard\Graphql\Middleware\AuthenticationMiddleware;

class QueryType extends ObjectType {
  public function __construct() {
    parent::__construct([
      'name' => 'Query',
      'fields' => [
        'echo' => [
          'type' => Type::string(),
          'args' => [
            'message' => ['type' => Type::string()],
          ],
          'resolve' => function (array $rootValue, array $args, array $context): string {
            // throw new UserError("Authentication required");
            return $rootValue['prefix'] . $args['message'];
          },
        ],
        'getMe' => [
          'type' => Type::nonNull(TypeRegistry::type(UserType::class)()),
          'resolve' => function (array $rootValue, array $args, array $context) {
            $container = $context['container'];
            $username = $context['serverVariable']['PHP_AUTH_USER'] ?? '';
            $password = $context['serverVariable']['PHP_AUTH_PW'] ?? '';
            $authMiddleware = new AuthenticationMiddleware($container);
            $authMiddleware->execute($username, $password);

            $meProcedure = new MeProcedure($container);
            $me = $meProcedure->getMe();

            return $me;
          },
        ],
      ],
    ]);
  }
}
