<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Editing of a comment') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<form method="POST" action="{{ route('posts.comments.update', ['post' => $post, 'comment' => $comment]) }}" enctype="multipart/form-data">
						@csrf
						@method('PATCH')
					
						<div class="block">
							<label for="comment_content" class="font-bold text-base text-black block mb-3">
								{{ __('Content') }}
							</label>
							<textarea class="tinymce" id="post-content" name="comment_content">{!! $comment->content !!}</textarea>
						</div>

						<input type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-xl bg-lime-500
							hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">							
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>