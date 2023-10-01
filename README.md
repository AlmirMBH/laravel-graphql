## GraphQL with Laravel

### Create a Laravel project
Create a Laravel project 
```
composer create-project laravel/laravel NAME-OF-PROJECT
```

Add a Blog model and a seeder
```
php artisan make:modelName -ms
```

The 'm' stands for model migration and 's' for model seeder.

Add data in the seeder
```
public function run(): void
    {
        Blog::insert([
            [
                'title' => 'This is title 1',
                'content' => 'Something something description 1',
            ],
            // add more data
        ]);
    }
```

#### Create and Seed the Database 
Get into mysql (add password and change username if required):
```
mysql -u root
```

Create database:
```
create schema graphql_test
```

Add database credentials in the .env file (adjust username and password, if necessary)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=graphql_test
DB_USERNAME=root
DB_PASSWORD=
```

Execute migrations
```
php artisan migrate
```

Seed the database
```
php artisan db:seed
```


### Test the Project
Start the project
```
php artisan serve
```

Open the browser and hit the following URL: http://localhost:8000/


### GraphQL
Here is a short list of GraphQL libraries that you can find on the GraphQL website that are most commonly used:
- webonyx/graphql-php
- wp-graphql/wp-graphql
- nuwave/lighthouse
- rebing/graphql-laravel

The rebing/graphql-laravel library is used in this project.


### GraphQL Setup
Install rebing/graphql-laravel by running the following command:
```
composer require rebing/graphql-laravel
```

Copy the rebing/graphql-library to the vendor by running the following command:
```
php artisan vendor:publish --provider="Rebing\GraphQL\GraphQLServiceProvider"
```

If the publishing is successful, you are going to get the following response:

Copied File [/vendor/rebing/graphql-laravel/config/config.php] To [/config/graphql.php]
Publishing complete.


## GraphQL Queries
Adding a GraphQL schema/query consists of three steps:
- Add a Type e.g. UserType
- Add a query (GET) or mutation (POST, PUT, PATCH, DELETE)
- Add the schema in the config file (config/graphql.php)

For example, if you want to add a query to get a User by ID, create a folder GraphQL and the following sub-folders:
- Mutations
- Queries
- Types

In the Type sub-folder, create a type for the User model, see app/GraphQL/Types/UserType.php. In the UserType
you need to specify properties that your User GraphQL model will have, including relationships (e.g. with
Friends model). The relationship with your Laravel model is specified in the '$attributes' array, see
UserType for more info.
Then, create GET schema/query for User, see app/GraphQL/Queries/UserQuery.php. In this query in the 'args'
method, you specify the required (input) fields, as well as the relationship between the UserQuery (GraphQL)
and your Laravel model (User). This is done in 'type' and 'resolve' methods. Bear in mind that returning
one instance of a User model is different from returning a collection (see 'type' method in UsersQuery).
Finally, you need to add your schema/query in the config/graphql.php:
```
'schemas' => [
    'default' => [
        'query' => [
            'user' => App\GraphQL\Queries\UserQuery::class,
            ...
```

Other schemas/queries for the User model (e.g. delete or update) are created in the same way.
See create, update or delete Blog mutations for more info.

## Register Custom Schema
Search for classes in config/graphql.php and see how they are added in the configuration.
Clear cache by running the following command: 
```
php artisan optimize
```

Make sure that new files are included in the project (vendor etc.) by running the following command:
```
composer dumpautoload
```

## Fetch related models
If you want to fetch related models (e.g. User and Friends), add regular relationship methods in User and Friend models (for the sake of simplicity one-to-many used in this project) and create a separate GraphQL query file e.g. UserWithFriendsQuery (no need to create a new Laravel model). Then, add the UserWithFriendsQuery in the config/graphql.php query list.
Finally, in the User type add the 'friends' field that will return the Friend data in the query.
```
'friends' => [
        'type' => Type::listOf(GraphQL::type('Friend')),
        'description' => 'List of friends for the user',
        'resolve' => function ($user, $args) {
            return $user->friends;
        },
    ],
```

## Testing the queries
Start the server by running the following command: 
```
php artisan serve
```

Open an API tool like Postman. Click cmd + N (mac) or ctrl + N (windows). Select GraphQl and type in your domain + /graphql. For example, http://localhost:8000/graphql. 

The following schemas, divided into Query and Mutation sections that you specified in the project (folder structure), will appear inside the postman: 
- blog
- blogs
- user
- users
- friends
- UserWithFriends
- createBlog
- updateBlog 
- deleteBlog
- 
Click on any of them and, if necessary, add input data e.g. ID. Execute the query and the output should appear.
For example, a GET user query should be like this:
```
query User {
    user(id: 1) {
        id
        name
        email
    }
}
```

and the response should look like this:
```
{
    "data": {
        "user": {
            "id": 1,
            "name": "Ms. Estell Brekke DVM",
            "email": "leon99@example.net"
        }
    }
}
```
