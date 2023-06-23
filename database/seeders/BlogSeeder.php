<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
                'title' => 'This is title 1',
                'content' => 'Something something description 1',
            ],
            [
                'title' => 'This is title 2',
                'content' => 'Something something description 2',
            ],
            [
                'title' => 'This is title 3',
                'content' => 'Something something description 3',
            ],
            [
                'title' => 'This is title 4',
                'content' => 'Something something description 4',
            ],
            [
                'title' => 'This is title 5',
                'content' => 'Something something description 5',
            ],
        ]);
    }
}
