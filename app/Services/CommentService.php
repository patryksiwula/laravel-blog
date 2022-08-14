<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentService
{
	public function createComment(int $user, int $post, string $content, ?int $parent_id): Comment
	{
		$comment = Comment::create([
			'user_id' => $user,
			'commentable_id' => $post,
			'commentable_type' => 'App\Models\Post',
			'parent_id' => $parent_id,
			'content' => $content
		]);

		return $comment;
	}
	
	public function generateCommentTree(int $post): Collection
	{
		$commentTree = Comment::with(['user', 'commentable', 'parent'])->where('commentable_id', $post)->get();
		$commentsById = new Collection();

		foreach ($commentTree as $comment)
			$commentsById->put($comment->id, $comment);

		foreach ($commentTree as $key => $comment)
		{
			$commentsById->get($comment->id)->replies = new Collection();
			
			if ($comment->parent != null)
			{
				$commentsById->get($comment->parent->id)->replies->push($comment);
				unset($commentTree[$key]);
			}
		}

		return $commentTree;
	}
}