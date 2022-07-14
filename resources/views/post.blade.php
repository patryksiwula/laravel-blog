<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Post') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-28 border-b border-gray-200">
					<div class="w-full flex justify-center">
						<img src="{{ $post->image_path }}" alt="{{ __('image') }}" class="object-contain">
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
							{{ $post->content }}
						</p>
					</div>

					<div class="mt-6 text-right text-sm">
						{{ __('Created') }}: {{ $post->created_at->format('d.m.Y, h:i:s') }}
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>