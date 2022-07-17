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
						<img src="{{ $post->user->thumbnail_xs_path }}" alt="" class="float-left">
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
					
					@if ($post->user->id == Auth::user()->id)
						<div class="mt-6">
							<a href="{{ route('posts.edit', ['post' => $post]) }}" class="py-2 px-4 inline-flex items-center justify-center text-center
								text-white text-lg bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
								{{ __('Edit post') }}
							</a>

							<a href="{{ route('posts.destroy', ['post' => $post]) }}" class="py-2 px-4 inline-flex items-center justify-center
								text-center text-white text-lg bg-red-600 hover:bg-opacity-90 font-normal rounded-md">
								{{ __('Delete post') }}
							</a>
						</div>
					@endif

					<div class="mt-6 text-right text-sm">
						{{ __('Created') }}: {{ $post->created_at->format('d.m.Y, h:i:s') }}
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>