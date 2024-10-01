<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepostRequest;
use App\Http\Requests\UpdatepostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        // Query result with pagination.
        $pageSize = $request->page_size ?? 20;
        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);

        // return new JsonResponse([
        //     'data' => $posts
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, PostRepository $repository)
    {
        $created = $repository->create($request->only([
            'title',
            'body',
            'user_ids'
        ]));


        return new PostResource($created);

        // return new JsonResponse([
        //     'data' => $created
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);

        // return new JsonResponse([
        //     'data' => $post
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids'
        ]));

        // // The code below has the same functionality.
        // // $post->update($request->only(['title', 'body']));
        // $updated = $post->update([
        //     // If title doesn't change, keep the original value.
        //     'title' => $request->title ?? $post->title,
        //     'body' => $request->body ?? $post->body,
        // ]);
        // if(!$updated){
        //     return new JsonResponse([
        //         'errors' => [
        //             'Failed to update model.'
        //         ]
        //     ], 400);
        // }

        return  new PostResource($post);

        // return new JsonResponse([
        //     'data' => $post
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(post $post, PostRepository $repository)
    {
        $post = $repository->forceDelete($post);

        // $deleted = $post->forceDelete();

        // if(!$deleted){
        //     return new JsonResponse([
        //         'errors' => [
        //             'Could not delete resource.'
        //         ]
        //     ], 400);
        // }
        
        return new JsonResponse([
            'data' => 'success'
        ]);
    }
}
