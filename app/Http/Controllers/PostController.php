<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
		$posts = Post::with('user')->paginate(9);

        return view('posts.posts', [
			'posts' => $posts
		]);
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePostRequest $request, PostService $postService): RedirectResponse
    {
        $post = $postService->createPost(
			$request->input('post_title'),
			$request->input('post_content'),
			$request->file('post_image')
		);

		return redirect()
			->route('posts.show', ['post' => $post])
			->with('action', 'post_created');
    }
  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Post $post, CommentService $commentService): View
    {
		$comments = $commentService->generateCommentTree($post->id);

        return view('posts.single-post', [
			'post' => $post,
			'comments' => $comments
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Post $post): View
    {
		$this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post, PostService $postService): RedirectResponse
    {
		$this->authorize('update', $post);

		$postService->updatePost(
			$post->id, 
			$request->input('post_title'), 
			$request->input('post_content'), 
			$request->file('post_image')
		);

		return redirect()
			->route('posts.show', ['post' => $post])
			->with('action', 'post_updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
		$this->authorize('delete', $post);
        $post->delete();
		
		return redirect()
			->route('posts.index')
			->with('action', 'post_deleted');
    }
}
