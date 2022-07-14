<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$posts = Post::with('user')->paginate(9);

        return view('posts.posts', [
			'posts' => $posts
		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
		$this->createThumbnail($thumbnailPath, 368, 240);

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
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.single-post', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
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
 	 * Create a thumbnail of specified size
 	 *
 	 * @param string $path path of thumbnail
 	 * @param int $width
 	 * @param int $height
 	 */
	public function createThumbnail($path, $width, $height)
	{
    	$img = Image::make($path)->resize($width, $height)
			->save($path);
	}
}
