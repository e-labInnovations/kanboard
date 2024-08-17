<?php

declare(strict_types=1);

namespace Kanboard\Graphql;

use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\Type;

/**
 * A type registry for GraphQL types, lazily resolving and caching instances.
 */
final class TypeRegistry {
  /** @var array<class-string<Type&NamedType>, Type&NamedType> */
  private static array $types = [];

  /**
   * Returns a lazily resolved singleton of the given type class.
   *
   * @template T of Type&NamedType
   *
   * @param class-string<T> $classname
   *
   * @return \Closure(): T
   */
  public static function type(string $classname): \Closure {
    // @phpstan-ignore-next-line generic type matches
    return static fn() => self::$types[$classname] ??= new $classname();
  }
}
