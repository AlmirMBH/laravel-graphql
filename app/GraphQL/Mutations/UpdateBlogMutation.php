<?php

namespace App\GraphQL\Mutations;
use App\Models\Blog;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateBlogMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateBlog',
    ];
    public function type(): Type
    {
        return GraphQL::type('Blog');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'name' => 'id',
            ],
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
        $blog = Blog::findOrFail($args['id']);
        $blog->fill($args);
        $blog->save();
        return $blog;
    }
}
