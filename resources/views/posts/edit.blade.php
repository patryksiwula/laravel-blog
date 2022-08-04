@extends('layouts.content')

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Editing of a post') }}
	</h2>
@endsection

@section('page_content')
	<div class="mt-10">
		<form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
		
			<div class="block">
				<label for="post_title" class="font-bold text-base text-black block mb-3">
					{{ __('Title') }}
				</label>
				<input type="text" name="post_title" value="{{ $post->title }}" placeholder=" {{ __('Post title') }}" class="w-full border-[1.5px]
					border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary
					active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
			</div>
		
			<div class="mt-8">
				<label for="post_content" class="font-bold text-base text-black block mb-3">
					{{ __('Content') }}
				</label>
				<textarea class="tinymce" id="post-content" name="post_content">{!! $post->content !!}</textarea>
			</div>

			<div class="mt-8 w-full">
				<label for="post_category" class="font-bold text-base text-black block mb-3">
					{{ __('Category') }}
				</label>
				<select name="post_category" id="post-category" class=" w-full border-[1.5px] border-form-stroke rounded-lg py-3 px-5 font-medium
					text-body-color outline-none focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default
					appearance-none">

					@foreach ($categories as $category)
						<option value="{{ $category->id }}" @selected($category->id == $post->category_id)>{{ $category->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="w-full mt-8">
				<label for="post_image" class="font-bold text-base text-black block mb-3">
					{{ __('Post image') }}
				</label>
				<input type="file" name="post_image" value="{{ $post->image_path }}" class="w-full border-[1.5px] border-form-strokerounded-lg font-medium text-body-color placeholder-body-color outline-none
					focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default cursor-pointer file:bg-[#F5F7FD]
					file:border-0 file:border-solid file:border-r file:border-collapse file:border-form-stroke file:py-3 file:px-5 file:mr-5 file:text-body-color
					file:cursor-pointer file:hover:bg-primary file:hover:bg-opacity-10">
			</div>

			<input type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-xl bg-lime-500
				hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">							
		</form>
	</div>
@endsection