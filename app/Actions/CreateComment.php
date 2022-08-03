<?php
namespace App\Actions;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class CreateComment
{
	public function handle(int $user, int $post, string $content, ?int $parent_id): void
	{
		$comment = new Comment();
		$comment->user()->associate(User::find($user));
		$comment->content = $content;

		if ($parent_id)
			$comment->parent_id = $parent_id;

		$post = Post::find($post);
		$post->comments()->save($comment);
	}
}