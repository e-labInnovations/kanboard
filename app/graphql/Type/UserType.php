<?php

declare(strict_types=1);

namespace Kanboard\Graphql\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType {
  public function __construct() {
    parent::__construct([
      'name' => 'User',
      'description' => 'User details',
      'fields' => [
        'id' => [
          'type' => Type::id(),
          'description' => 'The unique identifier for the user',
        ],
        'username' => [
          'type' => Type::string(),
          'description' => 'The username of the user',
        ],
        'is_ldap_user' => [
          'type' => Type::boolean(),
          'description' => 'Indicates if the user is an LDAP user',
        ],
        'name' => [
          'type' => Type::string(),
          'description' => 'The name of the user',
        ],
        'email' => [
          'type' => Type::string(),
          'description' => 'The email address of the user',
        ],
        'google_id' => [
          'type' => Type::string(),
          'description' => 'The Google ID of the user',
        ],
        'github_id' => [
          'type' => Type::string(),
          'description' => 'The GitHub ID of the user',
        ],
        'notifications_enabled' => [
          'type' => Type::boolean(),
          'description' => 'Indicates if notifications are enabled',
        ],
        'timezone' => [
          'type' => Type::string(),
          'description' => 'The timezone of the user',
        ],
        'language' => [
          'type' => Type::string(),
          'description' => 'The language of the user',
        ],
        'disable_login_form' => [
          'type' => Type::boolean(),
          'description' => 'Indicates if the login form is disabled',
        ],
        'twofactor_activated' => [
          'type' => Type::boolean(),
          'description' => 'Indicates if two-factor authentication is activated',
        ],
        'twofactor_secret' => [
          'type' => Type::string(),
          'description' => 'The secret for two-factor authentication',
        ],
        'token' => [
          'type' => Type::string(),
          'description' => 'The API token for the user',
        ],
        'notifications_filter' => [
          'type' => Type::int(),
          'description' => 'The notifications filter setting',
        ],
        'nb_failed_login' => [
          'type' => Type::int(),
          'description' => 'The number of failed login attempts',
        ],
        'lock_expiration_date' => [
          'type' => Type::int(),
          'description' => 'The expiration date of the lock',
        ],
        'gitlab_id' => [
          'type' => Type::string(),
          'description' => 'The GitLab ID of the user',
        ],
        'role' => [
          'type' => Type::string(),
          'description' => 'The role of the user',
        ],
        'is_active' => [
          'type' => Type::boolean(),
          'description' => 'Indicates if the user is active',
        ],
        'avatar_path' => [
          'type' => Type::string(),
          'description' => 'The path to the user\'s avatar',
        ],
        'api_access_token' => [
          'type' => Type::string(),
          'description' => 'The API access token',
        ],
        'filter' => [
          'type' => Type::string(),
          'description' => 'The filter setting for the user',
        ],
        'theme' => [
          'type' => Type::string(),
          'description' => 'The theme setting for the user',
        ],
      ],
    ]);
  }
}
