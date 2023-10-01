<?php

namespace App\GraphQL\Queries;

use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Collection;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class BlogsQuery extends Query
{
    protected $attributes = [
        'name' => 'blogs',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Blog'));
    }

    public function resolve(): Collection
    {
        return Blog::all();
    }
}

