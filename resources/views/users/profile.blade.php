<x-app-layout>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<section class="mt-10 pb-10 lg:pb-20">
						<div class="container mx-auto">
							<div class="flex justify-center">
								<div class="flex-col">
									<img src="{{ $user->image_path }}" alt="{{ $user->name }}" class="mx-auto max-w-50 h-auto rounded-full">
	
									<div class="mt-6 text-center">
										<h1>{{ $user->name }}</h1>
										Website <br>
										Github
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

											<div class="md:ml-5">
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
			</div>
		</div>
	</div>
</x-app-layout>