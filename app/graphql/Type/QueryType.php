<?php

namespace Kanboard\Graphql\Type;

use Pimple\Container;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Kanboard\Api\Procedure\MeProcedure;

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
          'resolve' => function (array $rootValue, array $args, Container $container): string {
            // $me = new MeProcedure($container);
            // $name = $me->getMe();
            // print_r($me);
            return $rootValue['prefix'] . $args['message'];
          },
        ],
      ],
    ]);
  }
}
