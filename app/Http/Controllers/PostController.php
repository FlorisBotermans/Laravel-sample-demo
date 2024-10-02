<?php

namespace App\Http\Controllers;

use App\Exceptions\GeneralJsonException;
use App\Http\Requests\StorepostRequest;
use App\Http\Requests\UpdatepostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Rules\IntegerArray;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
     * @param StorepostRequest $request
     * @return PostResource
     */
    public function store(Request $request, PostRepository $repository)
    {
        $payload = $request->only([
            'title',
            'body',
            'user_ids'
        ]);

        // Validation using request class. Better approach because won't pollute our controller.
        // $created = $repository->create($payload);

        // Validation using validator. Can use for more flexibility because it has a lot more helper functions.
        $validator = Validator::make($payload, [
            'title' => ['string', 'required'],
            'body' => ['string', 'required'],
            'user_ids' => [
                'array', 
                'required',
                // We can create custom validation rule either by closure or a dedicated rule class.
                new IntegerArray(),
            ]
        ], [
            'body.required' => "Please enter a value for body.",
            'title.string' => 'HEYYYY use a string.',
        ], [
            'user_ids' => 'USER IDDDD'
        ]);

        // The validator has a lot of helper functions.
        // $errors = $validator->errors();
        // dd($validator->fails());

        $validator->validate();

        $created = $repository->create($payload);


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
