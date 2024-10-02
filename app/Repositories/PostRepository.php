<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);

            // if(!$created) {
            //     throw new GeneralJsonException('Failed to create post.')
            // };

            // Helper class to create conditional exception.
            throw_if(!$created, GeneralJsonException::class, 'Failed to create.');
            
            if($userIds = data_get($attributes, 'user_ids')){
                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

    public function update($post, array $attributes)
    {
        return DB::transaction(function () use($post, $attributes){
            $updated = $post->update([
                'title' => data_get($attributes, 'title', $post->title),
                'body' => data_get($attributes, 'body', $post->body)
            ]);
    
            // if(!$updated){
            //     throw new \Exception('Failed to update post');
            // }

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update.');
    
            if($userIds = data_get($attributes, 'user_ids')){
                $post->users()->sync($userIds);
            }
    
            return $post;
        });
    }

    public function forceDelete($post)
    {
        return DB::transaction(function () use($post) {
            $deleted = $post->forceDelete();

            // if(!$deleted){
            //     throw new \Exception('cannot delete post.');
            // }

            throw_if(!$deleted, GeneralJsonException::class, 'Failed to delete.');

            return $deleted;
        });
    }
}