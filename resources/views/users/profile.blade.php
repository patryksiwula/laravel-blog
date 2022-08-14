@extends('layouts.content')

@section('title', $user->name . ' - ' . __('Profile'))

@section('page_content')
	<div class="mt-10">
		<section class="mt-10 pb-10 lg:pb-20">
			<div class="container mx-auto">
				<div class="flex justify-center">
					<div class="flex-col">
						@if ($user->image_path == 'https://via.placeholder.com/200x200.png/CCCCCC?text=User')
							<img src="{{ $user->image_path }}" alt="{{ $user->name }}" class="mx-auto max-w-50 h-auto rounded-full">
						@else
							<img src="{{ asset('storage/uploads/profiles/' . $user->image_path) }}" alt="{{ $user->name }}" class="mx-auto max-w-50 h-auto rounded-full">
						@endif
							
						<div class="mt-6 text-center">
							<h1>{{ $user->name }}</h1>

							@if ($user->website)
								<a href="{{ $user->website }}" target="_blank">
									{{ __('Website') }}
								</a>
								<br>
							@endif

							@if ($user->github)
								<a href="{{ $user->github }}" target="_blank">
									{{ __('Github') }}
								</a>
							@endif

							<div class="flex mt-5">
								@can('update', $user)
									<a href="{{ route('users.edit', ['user' => $user]) }}" class="flex-inline mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center
										justify-center text-center text-white text-xl bg-lime-600 hover:bg-opacity-90 font-normal rounded-md
										hover:cursor-pointer">
										{{ __('Edit profile') }}
									</a>
								@endcan

								@can('delete', $user)
									<form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}" class="ml-2">
										@csrf
										@method('DELETE')

										<input type="submit" value="{{ __('Delete user') }}" class="flex-inline mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex
											items-center justify-center text-center text-white text-xl bg-red-800 hover:bg-opacity-90 font-normal
											rounded-md hover:cursor-pointer">
									</form>
								@endcan
							</div>
						</div>
					</div>
				</div>
				
				<div class="mt-10">
					<h1 class="font-bold">
						{{ __('Posts') }}
					</h1>

					<div class="mt-3">
						@foreach ($posts as $post)
							<div class="flex flex-col md:flex-row w-full px-5 py-10 border-2 rounded-3xl mb-5 last:mb-0 shadow-md">
								@if ($post->thumbnail_path === 'https://via.placeholder.com/368x240.png/CCCCCC?text=Post')
									<img src="{{ $post->thumbnail_path }}" alt="{{ $post->title }}" class="w-full md:w-auto max-h-full md:max-h-48 rounded-3xl">
								@else
									<img src="{{ asset('storage/uploads/thumbnails/' . $post->thumbnail_path) }}" alt="{{ $post->title }}" class="w-full md:w-auto max-h-full md:max-h-48 rounded-3xl">
								@endif

								<div class="md:ml-5 w-full">
									<a href="{{ route('posts.show', ['post' => $post]) }}">
										<h1 class="mt-5 md:mt-0 text-2xl font-semibold">{{ $post->title }}</h1>
									</a>

									<div class="mt-5">
										@if (substr($post->content, 239, 240) === '.')
											{!! substr($post->content, 0, 240) . '..' !!}
										@else
											{!! substr($post->content, 0, 240) . '...' !!}
										@endif

										<a href="{{ route('posts.show', ['post' => $post]) }}">
											<h2 class="mt-5">{{ __('Continue reading') . '...' }}</h2>
										</a>

										<div class="mt-5 text-right text-xs">
											{{ __('Created by') . ': ' . $post->user->name }}
											<br>
											{{ $post->created_at->format('d.m.Y, h:i') }}
										</div>
									</div>
								</div>

								<br>
							</div>
						@endforeach
					</div>

					<div class="mt-10">
						{{ $posts->links() }}
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection