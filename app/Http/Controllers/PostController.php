<?php

namespace App\Http\Controllers;

use App\Actions\GenerateThumbnail;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function store(Request $request, PostService $postService, GenerateThumbnail $generateThumbnail): RedirectResponse
    {
		$validate = $request->validate([
			'post_title' => 'required|max:255',
			'post_content' => 'required',
			'post_image' => 'required|image|mimes:png,jpg,bmp,gif'
		]);

        $post = $postService->createPost(
			$request->input('post_title'),
			$request->input('post_content'),
			$request->file('post_image'),
			$generateThumbnail
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
    public function show(Post $post): View
    {
        return view('posts.single-post', ['post' => $post]);
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
    public function update(Request $request, Post $post, PostService $postService, GenerateThumbnail $generateThumbnail): RedirectResponse
    {
		$this->authorize('update', $post);

        $validate = $request->validate([
			'post_title' => 'min:6|max:255',
			'post_image' => 'image|mimes:png,jpg,bmp,gif'
		]);

		$postService->updatePost(
			$post->id, 
			$request->input('post_title'), 
			$request->input('post_content'), 
			$request->file('post_image'),
			$generateThumbnail
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
