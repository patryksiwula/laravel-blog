@extends('layouts.content')

@section('title', __('Editing a category'))

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Editing a category') }}
	</h2>
@endsection

@section('page_content')
	<div class="mt-10">
		<form method="POST" action="{{ route('categories.update', ['category' => $category]) }}" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
		
			<div class="block">
				<label for="name" class="font-bold text-base text-black block mb-3">
					{{ __('Name') }}
				</label>
				<input type="text" name="name" value="{{ $category->name }}" placeholder=" {{ __('Category name') }}" class="w-full border-[1.5px]
					border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary
					active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
			</div>

			<button type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-xl bg-lime-500
				hover:bg-opacity-90 font-normal rounded-md">
				{{ __('Create') }}
			</button>
		</form>
	</div>
@endsection