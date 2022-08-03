<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentService
{
	public function generateCommentTree(int $post): Collection
	{
		$comments = Comment::with(['user', 'parent'])->where('commentable_id', $post)->get();
		$commentsTree = new Collection();

		foreach ($comments as $comment)
			$commentsTree->put($comment->id, $comment);

		foreach ($comments as $key => $comment)
		{
			$commentsTree->get($comment->id)->replies = new Collection();
			
			if ($comment->parent != null)
			{
				$commentsTree->get($comment->parent->id)->replies->push($comment);
				unset($comments[$key]);
			}
		}
		
		//dd($commentsTree);

		return $comments;
	}
}