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
									{{ __('User\'s posts') }}
								</h1>

								<div class="mt-3">
									@foreach ($user->posts as $post)
										<a href="{{ route('posts.show', ['post' => $post]) }}">
											<h2>{{ $post->title }}</h2>
										</a>

										<br>
									@endforeach
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>