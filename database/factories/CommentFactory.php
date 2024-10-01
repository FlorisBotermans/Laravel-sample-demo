<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

// Factories are used to generate consistent and realistic data for testing.
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $postId = FactoryHelper::getRandomModelId(Post::class);

        return [
            'body' => [],
            'user_id' => FactoryHelper::getRandomModelId(User::class),
            'post_id' => FactoryHelper::getRandomModelId(Post::class),
        ];
    }
}
