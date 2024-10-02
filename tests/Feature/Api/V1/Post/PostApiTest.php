<?php

namespace Tests\Feature\Api\V1\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        // Load data in db
        $posts = Post::factory(10)->create();
        $postIds = $posts->map(fn ($post) => $post->id);

        // Call index endpoint
        $response = $this->json('get', '/api/v1/posts');

        // Assert status
        $response->assertStatus(200);

        // Verify records
        dump($response->json());

        $data = $response->json('data');
        collect($data)->each(fn ($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));
        dump($data);
    }
}
