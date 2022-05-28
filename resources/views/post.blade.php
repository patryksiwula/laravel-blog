@extends('layouts.main')

@section('content')

<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>

<a href="/posts"><u>Back</u></a>

@endsection