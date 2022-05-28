@extends('layouts.main')

@section('content')

<h1>Posts</h1>

@foreach ($posts as $post)
	<h2>
		<a href="/posts/{{ $post['id'] }}">{{ $post['title'] }}</a>
	</h2>

	<p>{{ $post['content'] }}</p>
@endforeach

@endsection