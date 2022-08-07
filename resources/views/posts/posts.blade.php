@extends('layouts.content')

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Posts') }}
	</h2>

	<form action="" method="GET" class="mt-5">
		<label for="categories" class="font-bold text-base text-black block">{{ __('Filter by category') }}</label>

		<select name="categories" id="categories" class="w-full border-[1.5px] border-form-stroke rounded-lg py-3 px-5 font-medium
			text-body-color outline-none focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default
			appearance-none">

			<option value="" @selected(!isset(request()->categories))>
				{{ __('Display all posts') }}
			</option>

			@foreach ($categories as $category)
				<option value="{{ $category->id }}" @selected($category->id == request()->categories)>
					{{ __($category->name) }}
				</option>
			@endforeach
		</select>

		<button type="submit" class="mt-2 py-2 px-4 lg:px-4 xl:px-4 inline-flex items-center justify-center text-center text-white text-xl bg-lime-500
		hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">
			{{ __('Filter') }}
		</button>
	</form>
@endsection

@section('page_content')
	<section class="mt-10 pb-10 lg:pb-20">
		<div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
			@each('posts.post-card', $posts, 'post')
		</div>
	</section>

	{{ $posts->links() }}
@endsection