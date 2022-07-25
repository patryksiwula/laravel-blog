<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Post') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<div class="w-full flex justify-center">
						@if ($post->image_path === 'https://via.placeholder.com/860x300.png/CCCCCC?text=Post')
							<img src="{{ $post->image_path }}" alt="{{ __('image') }}" class="object-contain">
						@else
							<img src="{{ asset('storage/uploads/' . $post->image_path) }}" alt="{{ __('image') }}" class="object-contain">
						@endif
					</div>
					
					<div class="w-full flex items-center align-middle mt-10">
						<img src="{{ asset('storage/uploads/profiles/thumbnails_xs/' . $post->user->thumbnail_xs_path) }}" alt="" class="float-left rounded-full">
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
						<h1>Comments</h1>

						<div class="w-full flex mt-5">
							<img src="http://localhost:8000/storage/uploads/profiles/thumbnails_xs/thumbnail_xs_21_07_2022_19_11test_imagexd.png" alt="" class="rounded-full 
								float-left h-10">

							<div class="ml-3 bg-gray-200 p-3 rounded-lg">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis tortor quis felis luctus iaculis. Nulla nec erat id enim pharetra congue. Nullam laoreet augue quis sodales tristique. Phasellus vel tortor quis ligula iaculis facilisis ut dapibus sapien. Etiam eget orci semper, efficitur ipsum eget, eleifend mi. Proin nec tincidunt mauris, nec volutpat ligula. Vivamus sed ornare mauris.
							</div>
						</div>

						<div class="w-full flex mt-5">
							<img src="http://localhost:8000/storage/uploads/profiles/thumbnails_xs/thumbnail_xs_21_07_2022_19_11test_imagexd.png" alt="" class="rounded-full 
								float-left h-10">

							<div class="ml-3 bg-gray-200 p-3 rounded-lg">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis tortor quis felis luctus iaculis. Nulla nec erat id enim pharetra congue. Nullam laoreet augue quis sodales tristique. Phasellus vel tortor quis ligula iaculis facilisis ut dapibus sapien. Etiam eget orci semper, efficitur ipsum eget, eleifend mi. Proin nec tincidunt mauris, nec volutpat ligula. Vivamus sed ornare mauris.
							</div>
						</div>

						<div class="w-full flex mt-5">
							<img src="http://localhost:8000/storage/uploads/profiles/thumbnails_xs/thumbnail_xs_21_07_2022_19_11test_imagexd.png" alt="" class="rounded-full 
								float-left h-10">

							<div class="ml-3 bg-gray-200 p-3 rounded-lg">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce iaculis tortor quis felis luctus iaculis. Nulla nec erat id enim pharetra congue. Nullam laoreet augue quis sodales tristique. Phasellus vel tortor quis ligula iaculis facilisis ut dapibus sapien. Etiam eget orci semper, efficitur ipsum eget, eleifend mi. Proin nec tincidunt mauris, nec volutpat ligula. Vivamus sed ornare mauris.
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>