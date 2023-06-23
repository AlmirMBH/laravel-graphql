<?php

namespace App\GraphQL\Mutations;
use App\Models\Blog;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateBlogMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createBlog',
    ];

    public function type(): Type
    {
        return GraphQL::type('Blog');
    }
    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'name' => 'title',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'name' => 'content',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $blog = new Blog();
        $blog -> fill($args);
        $blog -> save();
        return $blog;
    }
}
