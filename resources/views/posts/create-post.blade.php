<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Creation of a new post') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
						@csrf
					
						<div class="block">
							<label for="post_title" class="font-bold text-base text-black block mb-3">
								{{ __('Title') }}
							</label>
							<input required type="text" name="post_title" placeholder="{{ __('Post title') }}" class="w-full border-[1.5px] border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
						</div>
					
						<div class="mt-8">
							<label for="post_content" class="font-bold text-base text-black block mb-3">
								{{ __('Content') }}
							</label>
							<textarea class="tinymce" id="post-content" name="post_content"></textarea>
						</div>

						<div class="w-full mt-8">
							<label for="post_image" class="font-bold text-base text-black block mb-3">
								{{ __('Post image') }}
							</label>
							<input required type="file" name="post_image" class="w-full border-[1.5px] border-form-strokerounded-lg font-medium text-body-color placeholder-body-color outline-none
								focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default cursor-pointer file:bg-[#F5F7FD]
								file:border-0 file:border-solid file:border-r file:border-collapse file:border-form-stroke file:py-3 file:px-5 file:mr-5 file:text-body-color
								file:cursor-pointer file:hover:bg-primary file:hover:bg-opacity-10">
						</div>

						<input type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-base text-xl bg-lime-500
							hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">							
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>