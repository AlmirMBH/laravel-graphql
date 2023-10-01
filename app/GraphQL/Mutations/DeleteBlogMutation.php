<?php
namespace App\GraphQL\Mutations;

use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteBlogMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteBlog',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args): bool
    {
        return Blog::findOrFail($args['id'])->delete();
    }
}
