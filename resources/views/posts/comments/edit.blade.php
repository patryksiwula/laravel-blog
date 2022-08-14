@extends('layouts.content')

@section('title', __('Editing a comment'))

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Editing a comment') }}
	</h2>
@endsection

@section('page_content')
	<div class="mt-10">
		<form method="POST" action="{{ route('posts.comments.update', ['post' => $post, 'comment' => $comment]) }}" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
		
			<div class="block">
				<label for="comment_content" class="font-bold text-base text-black block mb-3">
					{{ __('Content') }}
				</label>
				<textarea class="tinymce" id="post-content" name="comment_content">{!! $comment->content !!}</textarea>
			</div>

			<input type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-xl bg-lime-500
				hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">							
		</form>
	</div>
@endsection