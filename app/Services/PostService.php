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
	 * @param  int $category
	 * @param  int $user
	 * @return Post
	 */
	public function createPost(string $title, string $content, UploadedFile $file, int $category, int $user): Post
	{
		$upload = $this->uploadImage($file, 368, 240);

		$post = Post::create([
			'title' => $title,
			'slug' => Str::slug($title),
			'content' => $content,
			'image_path' => $upload['fileName'],
			'thumbnail_path' => $upload['thumbnail'],
			'user_id' => $user,
			'category_id' => $category
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
	 * @param  int $category
	 * @return void
	 */
	public function updatePost(int $id, string $title, string $content, ?UploadedFile $file, int $category, int $updatedBy): Post
	{
		$post = Post::find($id);

		// Only update the fields in the database if they have been changed
		if ($post->title !== $title)
		{
			$post->title = $title;
			$post->slug = Str::slug($title);
		}
		
		if ($post->content !== $content)
			$post->content = $content;

		if ($file)
		{
			$upload = $this->uploadImage($file, 368, 240);
			$post->image_path = $upload['fileName'];
			$post->thumbnail_path = $upload['thumbnail'];
		}

		if ($post->category_id !== $category)
			$post->category_id = $category;

		$post->updated_by = $updatedBy;
		$post->save();

		return $post;
	}

	private function uploadImage(UploadedFile $file, int $thumbnaiWidth, int $thumbnailHeight): array
	{
		// Upload image
		$fileName = date('d_m_Y_H_i') . $file->getClientOriginalName();
		$thumbnail = 'thumbnail_sm_' . $fileName;
		$file->storeAs('public/uploads', $fileName);
		$file->storeAs('public/uploads/thumbnails', $thumbnail);
		
		// Generate thumbnail
		$thumbnailPath = public_path('storage/uploads/thumbnails/' . $thumbnail);
		$this->generateThumbnail->handle($thumbnailPath, $thumbnaiWidth, $thumbnailHeight);

		return [
			'fileName' => $fileName,
			'thumbnail' => $thumbnail
		];
	}
}