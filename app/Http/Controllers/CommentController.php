<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CommentController extends Controller
{	
	public function edit(Comment $comment): View
	{
		return view('posts.comments.edit', [
			'comment' => $comment
		]);
	}

    public function store(Request $request): void
	{
		# code...
	}

	public function update(Request $request, Comment $comment): void
	{
		# code...
	}

	public function destroy(Comment $comment): void
	{
		# code...
	}
}
