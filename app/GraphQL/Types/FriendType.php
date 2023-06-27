<?php

namespace App\GraphQL\Types;

use App\Models\Friend;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FriendType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Friend',
        'description' => 'Collection of friends and their relations',
        'model' => Friend::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a specific friend',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of a friend',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of a friend',
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Email of a friend',
            ],
            'user_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of the user to whom the friend belongs',
            ],
        ];
    }
}
