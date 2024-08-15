<?php

namespace Kanboard\Graphql\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MutationType extends ObjectType {
  public function __construct() {
    parent::__construct([
      'name' => 'Mutation',
      'fields' => [
        'sum' => [
          'type' => Type::int(),
          'args' => [
            'x' => ['type' => Type::int()],
            'y' => ['type' => Type::int()],
          ],
          'resolve' => static fn(array $rootValue, array $args): int => $args['x'] + $args['y'],
        ],
      ],
    ]);
  }
}
