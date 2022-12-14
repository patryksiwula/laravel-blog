<a href="{{ route('posts.show', ['post' => $post]) }}">
	<div class="col-span-1 flex flex-col">
		<div class="max-w-[370px] mx-auto mb-10 border shadow-lg rounded">
			<div class="rounded overflow-hidden">
				@if ($post->thumbnail_path === 'https://via.placeholder.com/368x240.png/CCCCCC?text=Post')
					<img src="{{ $post->thumbnail_path }}" alt="{{ __('image') }}" class="w-full h-60 object-cover" />
				@else
					<img src="{{ asset('storage/uploads/thumbnails/' . $post->thumbnail_path) }}" alt="{{ __('image') }}" class="w-full h-60 object-cover" />
				@endif
			</div>
			<div class="w-full p-5">
				<div class="w-full flex justify-between items-center align-middle">
					<div>
						<img src="{{ $post->user->thumbnail_xs_path }}" alt="" class="float-left">
						<span class="block float-left rounded px-0 text-xs font-semibold leading-none mt-2 ml-2">
							{{ __('Author') }}: <br> {{ $post->user->name }}
						</span>
					</div>
					<span class="rounded px-0 text-xs leading-loose font-semibold mb-5">
						{{ $post->created_at->format('d.m.Y') }}
					</span>
				</div>
				<div>
					<h3 class="font-semibold text-xl sm:text-2xl lg:text-xl xl:text-2xl my-4 inline-block text-dark hover:text-primary">
						{{ $post->title }}
					</h3>
				</div>
				<div class="mt-auto text-base text-body-color">
					@if (substr($post->content, 119, 120) === '.')
						{!! substr($post->content, 0, 120) . '..' !!}
					@else
						{!! substr($post->content, 0, 120) . '...' !!}
					@endif
				</div>
			</div>
		</div>
	</div>
</a>