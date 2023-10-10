<?php

declare(strict_types = 1);

return [
    'route' => [
        'prefix' => 'graphql', // The prefix for routes; do NOT use a leading slash!
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@query', // The controller/method to use in GraphQL request, supports arrays: `[\Rebing\GraphQL\GraphQLController::class, 'query']`
        'middleware' => [], // Any middleware for the graphql route group will apply to all schemas
        'group_attributes' => [], // Additional route group attributes, for example: 'group_attributes' => ['guard' => 'api']
    ],

    'default_schema' => 'default', // Name of the default schema; used when the route group is directly accessed
    'batching' => [
        'enable' => true, // Whether to support GraphQL batching or not, see https://www.apollographql.com/blog/batching-client-graphql-queries-a685f5bcd41b/ for more details
    ],

    'schemas' => [
        'default' => [
            'query' => [
                'blog' => App\GraphQL\Queries\BlogQuery::class,
                'blogs' => App\GraphQL\Queries\BlogsQuery::class,
                'user' => App\GraphQL\Queries\UserQuery::class,
                'users' => App\GraphQL\Queries\UsersQuery::class,
                'friends' => App\GraphQL\Queries\FriendsQuery::class,
                'UserWithFriends' => App\GraphQL\Queries\UserWithFriendsQuery::class,
            ],
            'mutation' => [
                'createBlog' => App\graphql\Mutations\CreateBlogMutation::class,
                'updateBlog' => App\graphql\Mutations\UpdateBlogMutation::class,
                'deleteBlog' => App\graphql\Mutations\DeleteBlogMutation::class,
            ],
            'types' => [
                'Blog' => App\GraphQL\Types\BlogType::class,
                'User' => App\GraphQL\Types\UserType::class,
                'Friend' => App\GraphQL\Types\FriendType::class
            ],

            'middleware' => null, // Laravel HTTP middleware
            'method' => ['GET', 'POST'], // Which HTTP methods to support; must be given in UPPERCASE!
            'execution_middleware' => null, // An array of middlewares, overrides the global ones
        ],
    ],

    'types' => [ // The global types available to all schemas. You can then access it from the facade like this: GraphQL::type('user')
        'Blog' => App\GraphQL\Types\BlogType::class,
        'User' => App\GraphQL\Types\UserType::class,
        'Friend' => App\GraphQL\Types\FriendType::class
        // ExampleType::class,
        // ExampleRelationType::class,
        // \Rebing\GraphQL\Support\UploadType::class,
    ],

    'lazyload_types' => true, // The types will be loaded on demand. Default is to load all types on each request. Presupposes the config type key to match the type class name property
    'error_formatter' => [\Rebing\GraphQL\GraphQL::class, 'formatError'], // This callable will be passed the Error object for errors that GraphQL catches. It returns an array representing the error. For example, ['message' => '', 'locations' => []]
    'errors_handler' => [\Rebing\GraphQL\GraphQL::class, 'handleErrors'], // Custom Error Handling. The expected handler signature is: function (array $errors, callable $formatter): array. The default handler will pass exceptions to laravel Error Handling mechanism
    'security' => [ // Options to limit the query complexity and depth. See https://webonyx.github.io/graphql-php/security for details. Disabled by default.
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class, // You can define your own pagination type. Reference \Rebing\GraphQL\Support\PaginationType::class
    'simple_pagination_type' => \Rebing\GraphQL\Support\SimplePaginationType::class, // You can define your own simple pagination type. Reference \Rebing\GraphQL\Support\SimplePaginationType::class

    'graphiql' => [ // Config for GraphiQL (see (https://github.com/graphql/graphiql).
        'prefix' => 'graphiql', // Do NOT use a leading slash
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],

    /**
     * Overrides the default field resolver, see http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver for more details. For example,
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */

    'defaultFieldResolver' => null,
    'headers' => [], // Any headers that will be added to the response returned by the default controller
    'json_encoding_options' => 0, // Any JSON encoding options when returning a response from the default controller, see http://php.net/manual/function.json-encode.php for the full list of options

    /**
     * Automatic Persisted Queries (APQ), see https://www.apollographql.com/docs/apollo-server/performance/apq/.
     * Note 1: this requires the `AutomaticPersistedQueriesMiddleware` being enabled
     * Note 2: even if APQ is disabled per configuration and, according to the "APQ specs" (see above),
     *         to return a correct response in case it's not enabled, the middleware needs to be active.
     *         Of course if you know you do not have a need for APQ, feel free to remove the middleware completely.
     */
    'apq' => [
        'enable' => env('GRAPHQL_APQ_ENABLE', false), // Enable/Disable APQ - See https://www.apollographql.com/docs/apollo-server/performance/apq/#disabling-apq
        'cache_driver' => env('GRAPHQL_APQ_CACHE_DRIVER', config('cache.default')), // The cache driver used for APQ
        'cache_prefix' => config('cache.prefix') . ':graphql.apq',
        'cache_ttl' => 300, // The cache ttl in seconds - See https://www.apollographql.com/docs/apollo-server/performance/apq/#adjusting-cache-time-to-live-ttl
    ],

    'execution_middleware' => [
        \Rebing\GraphQL\Support\ExecutionMiddleware\ValidateOperationParamsMiddleware::class,
        // AutomaticPersistedQueriesMiddleware listed even if APQ is disabled, see the docs for the `'apq'` configuration
        \Rebing\GraphQL\Support\ExecutionMiddleware\AutomaticPersistedQueriesMiddleware::class,
        \Rebing\GraphQL\Support\ExecutionMiddleware\AddAuthUserContextValueMiddleware::class,
        // \Rebing\GraphQL\Support\ExecutionMiddleware\UnusedVariablesMiddleware::class,
    ],

    // SCHEMAS EXAMPLE
    // The schemas for query and/or mutation. It expects an array of schemas to provide both the 'query' fields and the 'mutation' fields.
    // You can also provide a middleware that will only apply to the given schema
    //
    // Example:
    //
    //  'schemas' => [
    //      'default' => [
    //          'controller' => MyController::class . '@method',
    //          'query' => [
    //              App\GraphQL\Queries\UsersQuery::class,
    //          ],
    //          'mutation' => [
    //
    //          ]
    //      ],
    //      'user' => [
    //          'query' => [
    //              App\GraphQL\Queries\ProfileQuery::class,
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //      'user/me' => [
    //          'query' => [
    //              App\GraphQL\Queries\MyProfileQuery::class,
    //          ],
    //          'mutation' => [
    //
    //          ],
    //          'middleware' => ['auth'],
    //      ],
    //  ]
    //
];
