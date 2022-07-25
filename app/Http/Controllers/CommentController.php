<?php

namespace App\Http\Controllers;

use App\Actions\CreateComment;
use App\Http\Requests\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{	
	public function edit(Post $post, Comment $comment): View
	{
		$this->authorize('update', $comment);

		return view('posts.comments.edit', [
			'post' => $post,
			'comment' => $comment
		]);
	}

    public function store(CommentRequest $request, Post $post, CreateComment $createComment): RedirectResponse
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

	public function update(CommentRequest $request, Post $post, Comment $comment): RedirectResponse
	{
		$this->authorize('update', $comment);

		$comment->content = $request->input('comment_content');
		$comment->save();

		return redirect()->route('posts.show', [
			'post' => $post
		])->withMessage('action', 'comment_updated');
	}

	public function destroy(Post $post, Comment $comment): RedirectResponse
	{
		$this->authorize('delete', $post, $comment);

		$comment->delete();

		return redirect()->route('posts.show', [
			'post' => $post
		])->withMessage('action', 'comment_deleted');
	}
}
