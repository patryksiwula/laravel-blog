<?php

namespace App\Http\Controllers;

use App\Actions\CreateComment;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{	
	public function edit(Post $post, Comment $comment): View
	{
		return view('posts.comments.edit', [
			'post' => $post,
			'comment' => $comment
		]);
	}

    public function store(StoreCommentRequest $request, Post $post, CreateComment $createComment): RedirectResponse
	{
		$createComment->handle(
			auth()->id(),
			$post->id,
			$request->input('comment_content')
		);

		return redirect()->route('posts.show', [
			'post' => $post
		])->withMessage('action', 'comment_created');
	}

	public function update(Request $request, Post $post, Comment $comment): void
	{
		# code...
	}

	public function destroy(Post $post, Comment $comment): void
	{
		# code...
	}
}
