<?php

namespace App\Services;

use \App\Actions\GenerateThumbnail;
use \App\Models\Post;
use \Illuminate\Http\UploadedFile;
use \Illuminate\Support\Str;

class PostService
{			
	/**
	 * Constructor method
	 *
	 * @param  \App\Actions\GenerateThumbnail $generateThumbnail
	 */
	public function __construct(private GenerateThumbnail $generateThumbnail) { }

	/**
	 * Create a new post
	 *
	 * @param  string $title
	 * @param  string $content
	 * @param  \Illuminate\Http\UploadedFile $file
	 * @param  int $user
	 * @return Post
	 */
	public function createPost(string $title, string $content, UploadedFile $file, int $user): Post
	{
		// Upload image
		$image = $file;
		$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
		$thumbnail = 'thumbnail_' . $fileName;
		$image->storeAs('public/uploads', $fileName);
		$image->storeAs('public/uploads/thumbnails', $thumbnail);
		
		// Generate thumbnail
		$thumbnailPath = public_path('storage/uploads/thumbnails/' . $thumbnail);
		$this->generateThumbnail->handle($thumbnailPath, 368, 240);

		$post = Post::create([
			'title' => $title,
			'slug' => Str::slug($title),
			'content' => $content,
			'image_path' => $fileName,
			'thumbnail_path' => $thumbnail,
			'user_id' => $user
		]);

		return $post;
	}
	/**
	 * Update the post
	 *
	 * @param  int $id
	 * @param  string $title
	 * @param  string $content
	 * @param  \Illuminate\Http\UploadedFile|null $file
	 * @return void
	 */
	public function updatePost(int $id, string $title, string $content, ?UploadedFile $file, int $updatedBy): void
	{
		$post = Post::find($id);

		// Only update the fields in the database if they have been changed
		if ($post->title !== $title)
			$post->title = $title;
		
		if ($post->content !== $content)
			$post->content = $content;

		if ($file)
		{
			$image = $file;
			$fileName = date('d_m_Y_H_i') . $image->getClientOriginalName();
			$thumbnail = 'thumbnail_' . $fileName;
			$image->storeAs('public/uploads', $fileName);
			$image->storeAs('public/uploads/thumbnails', $thumbnail);
			
			// Generate thumbnail
			$thumbnailPath = public_path('storage/uploads/thumbnails/' . $thumbnail);
			$this->generateThumbnail->handle($thumbnailPath, 368, 240);

			$post->image_path = $fileName;
			$post->thumbnail_path = $thumbnail;
		}

		$post->updated_by = $updatedBy;
		$post->save();
	}
}