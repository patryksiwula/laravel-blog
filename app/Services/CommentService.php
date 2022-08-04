<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentService
{
	public function generateCommentTree(int $post): Collection
	{
		$commentTree = Comment::with(['user', 'parent'])->where('commentable_id', $post)->get();
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