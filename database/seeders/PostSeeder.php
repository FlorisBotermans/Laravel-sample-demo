<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncate('posts');

        $posts = Post::factory(200)
            // Has creates 3 comments for each post. This has as side effect which mean that not only it creates records in the Comment table but also in the Post table.
            // ->has(Comment::factory(3), 'comments')
            ->untitled()
            ->create();

        $posts->each(function (Post $post){
            // We can use sync() method to generate many to many relation records.
            $post->users()->sync([FactoryHelper::getRandomModelId(User::class)]);
        });

        $this->enableForeignKeys();
    }
}
