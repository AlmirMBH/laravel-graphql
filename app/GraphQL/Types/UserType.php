<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'Collection of users and their relations',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a specific user',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of a user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of a user',
            ],
            'friends' => [
                'type' => Type::listOf(GraphQL::type('Friend')),
                'description' => 'List of friends for the user',
                'resolve' => function ($root, $args) {
                    return $root->friends;
                },
            ],
        ];
    }
}
