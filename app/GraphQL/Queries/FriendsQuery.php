<?php

namespace App\GraphQL\Queries;
use App\Models\Friend;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class FriendsQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Friend'));
    }

    public function resolve($root, $args)
    {
        return Friend::all();
    }
}

