<?php
namespace App\Actions;

use App\Models\Post;
use App\Models\Comment;

class CreateComment
{
	public function handle(int $user, int $post, string $content): void
	{
		$comment = Comment::create([
			'user_id' => $user,
			'post_id' => $post,
			'content' => $content
		]);
	}
}