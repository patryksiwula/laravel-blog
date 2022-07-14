<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Create new post') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<form method="POST" action="{{ route('logout') }}">
						@csrf

						<div class="block">
							<label for="title" class="font-bold text-base text-black block mb-3">
								{{ __('Title') }}
							</label>
							<input type="text" name="title" placeholder="{{ __('Post title') }}" class="w-full border-[1.5px] border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
						</div>

						<div class="mt-8">
							<label class="font-bold text-base text-black block mb-3">
								{{ __('Content') }}
							</label>
							<x-tinymce.tinymce-editor />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>