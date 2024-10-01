<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
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
        $this->truncate('comments');
        $posts = Comment::factory(3)
            // For creates a post for each comment. This has as side effect which mean that not only it creates records in the Post table but also in the Comment table.
            // ->for(Post::factory(1), 'post')
            ->create();
        $this->enableForeignKeys();
    }
}
