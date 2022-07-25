<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
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

    public function store(Request $request, Post $post): void
	{
		# code...
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
