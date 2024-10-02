<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    public function test_create()
    {
        // 1. Define the goal
        // Test if create() will actually create a record in the DB

        // 2. Replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);

        // 3. Define the source of truth
        $payload = [
            'title' => 'heyaa',
            'body' => []
        ];

        // 4. Compare the result
        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title.');
    }

    public function test_update()
    {
        // Goal: make sure we can update a post using the update method

        // Env
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        // Source of truth
        $payload = [
            'title' => 'abc123',
        ];

        // Compare
        $updated = $repository->update($dummyPost, $payload);
        $this->assertSame($payload['title'], $updated->title, 'Post updated does not have the same title.');
    }

    public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exist()
    {
        // Env
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummy);
    }

    public function test_delete()
    {
        // Goal: test if forceDelete() is working

        // Env
        $repository = $this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->create()->first();

        // Compare
        $deleted = $repository->forceDelete($dummy);

        // Verify if it is deleted
        $found = Post::query()->find($dummy->id);

        $this->assertSame(null, $found, 'Post is not deleted');
    }
}
