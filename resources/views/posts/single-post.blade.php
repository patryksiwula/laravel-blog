@extends('layouts.content')

@section('page_content')
	<div class="mt-10">
		<div class="w-full flex justify-center">
			@if ($post->image_path === 'https://via.placeholder.com/860x300.png/CCCCCC?text=Post')
				<img src="{{ $post->image_path }}" alt="{{ __('image') }}" class="object-contain">
			@else
				<img src="{{ asset('storage/uploads/' . $post->image_path) }}" alt="{{ __('image') }}" class="object-contain">
			@endif
		</div>
		
		<div class="w-full flex items-center align-middle mt-10">
			@if ($post->user->thumbnail_xs_path === 'https://via.placeholder.com/40x40.png/CCCCCC?text=User')
				<img src="{{ $post->user->thumbnail_xs_path }}" alt="" class="float-left rounded-full">
			@else
				<img src="{{ asset('storage/uploads/profiles/thumbnails_xs/' . $post->user->thumbnail_xs_path) }}" alt="" class="float-left rounded-full">
			@endif
			<span class="block float-left rounded px-0 font-semibold leading-none ml-2 text-xl">
				{{ $post->user->name }}
			</span>
		</div>

		<div class="mt-6">
			<h1 class="font-semibold">{{ $post->title }}</h1>

			<p class="mt-5">
				{!! $post->content !!}
			</p>
		</div>
		
		<div class="mt-6">
			@can('update', $post)
				<a href="{{ route('posts.edit', ['post' => $post]) }}" class="py-2 px-4 inline-flex items-center justify-center text-center
					text-white text-lg bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
					{{ __('Edit post') }}
				</a>
			@endcan

			@can('delete', $post)
				<form method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}" class="inline-flex items-center justify-center">
					@csrf
					@method('DELETE')

					<input type="submit" value="{{ __('Delete post') }}" class="py-2 px-4 text-center text-white text-lg bg-red-600
						hover:bg-opacity-90 font-normal rounded-md cursor-pointer">
				</form>
			@endcan
		</div>

		<div class="mt-6 text-right text-sm">
			{{ __('Created') . ': ' . $post->created_at->format('d.m.Y, h:i') }}

			@if ($post->updated_at != $post->created_at)
				<br>
				{{ __('Last updated') . ': ' . $post->updated_at->format('d.m.Y, h:i') . ' ' . __('by') . ': ' }}
				<a href="{{ route('users.show', ['user' => $post->updatedByUser]) }}">{{ $post->updatedByUser->name }}</a> 
			@endif
		</div>

		<div class="w-full mt-10">
			<div class="flex items-center">
				<h1 class="">{{ _('Comments') }}</h1> 
				@auth
					<a href="{{ route('posts.comments.create', ['post' => $post]) }}" class="ml-3 py-2 px-4 items-center justify-center text-center text-white
						text-lg bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
						{{ __('Add comment') }}
					</a>
				@endauth
			</div>
			
			@if (!empty($comments))
				@include('posts.comments.comment', ['post' => $post, 'comments' => $comments])
			@endif
		</div>
	</div>
@endsection