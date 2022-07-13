<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Posts') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 bg-white border-b border-gray-200">
					<section class="pb-10 lg:pb-20">
						<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
							@foreach ($posts as $post)
								<a href="{{ route('posts.show', ['post' => $post]) }}">
									<div class="col-span-1 flex flex-col">
										<div class="max-w-[370px] mx-auto mb-10 border shadow-lg rounded">
											<div class="rounded overflow-hidden">
												<img src="{{ $post->image_path }}" alt="image" class="w-full" />
											</div>
											<div class="w-full p-5">
												<div class="w-full flex justify-between">
													<span class="rounded px-0 text-xs leading-loose font-semibold mb-5">
														{{ __('Author') }}: {{ $post->user->name }}
													</span>
													<span class="rounded px-0 text-xs leading-loose font-semibold mb-5">
														{{ $post->created_at->toDateString() }}
													</span>
												</div>
												<div>
													<h3 class="font-semibold text-xl sm:text-2xl lg:text-xl xl:text-2xl mb-4 inline-block text-dark hover:text-primary">
														{{ $post->title }}
													</h3>
												</div>
												<div class="mt-auto text-base text-body-color">
													{{ substr($post->content, 0, 120) }}...
												</div>
											</div>
										</div>
									</div>
								</a>
							@endforeach
						</div>
					</section>

					{{ $posts->links() }}
				</div>
			</div>
		</div>
	</div>
</x-app-layout>