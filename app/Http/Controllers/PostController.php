<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

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
     * @return \Illuminate\Http\RedirectResponse;
     */
    public function store(Request $request): RedirectResponse
    {
		$validate = $request->validate([
			'post_title' => 'required|max:255',
			'post_content' => 'required',
			'post_image' => 'required|image|mimes:png,jpg,bmp,gif'
		]);

        if (!$request->file('post_image'))
			return redirect()->route('posts.create', ['message' => 'no_image']);
		
		// Upload image
		$image = $request->file('post_image');
		$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
		$thumbnail = 'thumbnail_' . $fileName;
		$image->storeAs('public/uploads', $fileName);
		$image->storeAs('public/uploads/thumbnails', $thumbnail);
		
		// Generate thumbnail
		$thumbnailPath = public_path('storage/uploads/thumbnails/' . $thumbnail);
		$this->generateThumbnail($thumbnailPath, 368, 240);

		$post = new Post();
		$post->title = $request->input('post_title');
		$post->content = $request->input('post_content');
		$post->image_path = $fileName;
		$post->thumbnail_path = $thumbnail;
		$post->user_id = $request->user()->id;
		$post->save();

		return redirect()->route('posts.show', [
			'post' => $post,
			'message' => 'created'
		]);
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
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validate = $request->validate([
			'post_title' => 'min:6|max:255',
			'post_image' => 'image|mimes:png,jpg,bmp,gif'
		]);
		
		// Only update the fields in the database if they have been changed
		if ($post->title !== $request->input('post_title'))
			$post->title = $request->input('post_title');
		
		if ($post->content !== $request->input('post_content'))
			$post->content = $request->input('post_content');

		if ($request->file('post_image'))
		{
			$image = $request->file('post_image');
			$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
			$thumbnail = 'thumbnail_' . $fileName;
			$image->storeAs('public/uploads', $fileName);
			$image->storeAs('public/uploads/thumbnails', $thumbnail);
			
			// Generate thumbnail
			$thumbnailPath = public_path('storage/uploads/thumbnails/' . $thumbnail);
			$this->generateThumbnail($thumbnailPath, 368, 240);

			$post->image_path = $fileName;
			$post->thumbnail_path = $thumbnail;
		}

		$post->save();

		return redirect()->route('posts.show', [
			'post' => $post,
			'message' => 'updated'
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

	/**
	 * Generate a thumbnail of specified size
	 *
	 * @param  string $path path of thumbnail
	 * @param  int $width
	 * @param  int $height
	 * @return void
	 */	
	public function generateThumbnail(string $path, int $width, int $height): void
	{
    	$img = Image::make($path)->resize($width, $height)
			->save($path);
	}
}
