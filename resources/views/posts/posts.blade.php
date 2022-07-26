@extends('layouts.content')

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Posts') }}
	</h2>
@endsection

@section('page_content')
	<section class="mt-10 pb-10 lg:pb-20">
		<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
			@each('posts.post-card', $posts, 'post')
		</div>
	</section>

	{{ $posts->links() }}
@endsection