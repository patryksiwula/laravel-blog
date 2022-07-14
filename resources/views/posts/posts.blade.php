<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Posts') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 border-b border-gray-200">
					<section class="pb-10 lg:pb-20">
						<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
							@foreach ($posts as $post)
								<a href="{{ route('posts.show', ['post' => $post]) }}">
									<div class="col-span-1 flex flex-col">
										<div class="max-w-[370px] mx-auto mb-10 border shadow-lg rounded">
											<div class="rounded overflow-hidden">
												<img src="{{ $post->thumbnail_path }}" alt="{{ __('image') }}" class="w-full h-60 object-cover" />
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