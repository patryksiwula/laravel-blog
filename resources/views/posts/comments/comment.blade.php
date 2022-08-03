@foreach ($comments as $comment)
	@empty($comment->parent)
		<div class="w-full mt-5">
	@else
		<div class="w-full mt-5 pl-10">
	@endempty
			<div class="w-full flex">
				<div class="flex w-full">
					<a href="{{ route('users.show', ['user' => $comment->user]) }}">
						@if ($comment->user->thumbnail_xs_path === 'https://via.placeholder.com/40x40.png/CCCCCC?text=User')
							<img src="{{ $comment->user->thumbnail_xs_path }}" alt="{{ $comment->user->name }}" class="rounded-full 
							float-left h-10 w-10">
						@else
							<img src="{{ asset('storage/uploads/profiles/thumbnails_xs/' . $comment->user->thumbnail_xs_path) }}" alt="" class="rounded-full 
							float-left h-10 w-10">
						@endif
					</a>

					<div class="w-full ml-3 bg-gray-200 p-3 rounded-lg">
						<p>
							<a href="{{ route('users.show', ['user' => $comment->user]) }}">
								<strong>{{ $comment->user->name }}</strong>
							</a>
						</p>

						{!! $comment->content !!}

						<div class="text-right text-sm">
							{{ $comment->created_at->format('d.m.Y, h:i') }}
						</div>
					</div>
				</div>
			</div>
			
			<div class="mt-1 mb-5 float-right">
				@can('update', $comment)
					<a href="{{ route('posts.comments.edit', ['post' => $comment->post, 'comment' => $comment]) }}" class="py-1 px-4 inline-flex
						items-center justify-center text-center text-white text-sm bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
						{{ __('Edit') }}
					</a>
				@endcan

				@can('delete', $comment->post)
					<form method="POST" action="{{ route('posts.comments.destroy', ['post' => $comment->post, 'comment' => $comment]) }}" class="inline-flex
						items-center justify-center">
						@csrf
						@method('DELETE')

						<input type="submit" value="{{ __('Delete') }}" class="py-1 px-4 text-center text-white text-sm bg-red-600
							hover:bg-opacity-90 font-normal rounded-md cursor-pointer">
					</form>
				@endcan
			</div>

			@if (!empty($comment->replies))
				@include('posts.comments.comment', ['post' => $comment->post, 'comments' => $comment->replies])
			@endif
		</div>
@endforeach