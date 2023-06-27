## GraphQL with Laravel

### Create a Laravel project
Create a Laravel project 
- composer create-project laravel/laravel NAME-OF-PROJECT

Add a Blog model and a seeder
- php artisan make:model -ms

Add data in the seeder
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


#### Create and Seed the Database 
Get into mysql (add password and change username if required):
- mysql -u root

Create database: 
- create schema graphql_test

Add database credentials in the .env file (adjust username and password, if necessary)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=graphql_test
DB_USERNAME=root
DB_PASSWORD=

Execute migrations
- php artisan migrate

Seed the database
- php artisan db:seed


### Test the Project
Start the project
- php artisan serve

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

- composer require rebing/graphql-laravel

Copy the rebing/graphql-library to the vendor by running the following command:

- php artisan vendor:publish --provider="Rebing\GraphQL\GraphQLServiceProvider"

If the publish is successful, you are going to get the following response:

Copied File [/vendor/rebing/graphql-laravel/config/config.php] To [/config/graphql.php]
Publishing complete.


## GraphQL Queries
Define a type for the Blog model, see app/GraphQL/Types/BlogType.php.
Create GET queries, see app/GraphQL/Queries/BlogQuery.php and app/GraphQL/Queries/BlogsQuery.php
Create POST queries (mutations), see app/GraphQL/Mutations/CreateBlogMutation.php, app/GraphQL/Mutations/UpdateBlogMutation.php and app/GraphQL/Mutations/DeleteBlogMutation.php.

## Register Custom Schema
Search for classes in config/graphql.php and see how they are added in the configuration.
Clear cache by running the following command: 
- php artisan optimize

Make sure that new files are included in the project (vendor etc.) by running the following command:
- composer dumpautoload


## Testing the queries
Start the server by running the following command: 
- php artisan serve

Open an API tool like Postman. Click cmd + N (mac) or ctrl + N (windows). Select GraphQl and type in your domain + /graphql. For example, http://localhost:8000/graphql. 
The following schemas will appear inside the postman: blog, blogs, createBlog, updateBlog, deleteBlog.
Click on any of them and, if necessary, add input data e.g. ID. Execute the query and the output should appear.