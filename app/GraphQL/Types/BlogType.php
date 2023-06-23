<?php

namespace App\GraphQL\Types;
use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BlogType extends GraphQLType
{
    protected $attributes = [
        "name" => "Blog",
        "description" => "Collection of blog posts and their content",
        "model" => Blog::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                "type" => Type::nonNull(Type::int()),
                "description" => "Id of a specific blog post",
            ],
            "title" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "Title of a specific blog post",
            ],
            "content" => [
                "type" => Type::nonNull(Type::string()),
                "description" => "Content of a specific blog post",
            ],
        ];
    }
}
