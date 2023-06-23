<?php

namespace App\GraphQL\Queries;
use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Types\BlogType;

class BlogsQuery extends Query
{
    protected $attributes = [
        'name' => 'blogs',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Blog'));
    }

    public function resolve($root, $args)
    {
        return Blog::all();
    }
}

