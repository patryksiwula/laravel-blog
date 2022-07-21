<x-app-layout>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<h1 class="font-bold">{{ __('Editing profile') }}</h1>
					<section class="mt-10 pb-10 lg:pb-20">
						<div class="container mx-auto">
							<div class="w-full">
								<form method="POST" action="{{ route('users.update', ['user' => $user]) }}" enctype="multipart/form-data">
									@csrf
									@method('PATCH')

									<div class="w-full">
										<label for="user_image" class="font-bold text-base text-black block mb-3">
											{{ __('Profile image') }}
										</label>
										<input type="file" name="user_image" class="w-full border-[1.5px] border-form-strokerounded-lg font-medium text-body-color placeholder-body-color outline-none
											focus:border-primary active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default cursor-pointer file:bg-[#F5F7FD]
											file:border-0 file:border-solid file:border-r file:border-collapse file:border-form-stroke file:py-3 file:px-5 file:mr-5 file:text-body-color
											file:cursor-pointer file:hover:bg-primary file:hover:bg-opacity-10">
									</div>

									<div class="w-full mt-8">
										<label for="user_name" class="font-bold text-base text-black block mb-3">
											{{ __('Name') }}
										</label>
										<input type="text" name="user_name" value="{{ $user->name }}" placeholder=" {{ __('Name') }}" class="w-full border-[1.5px]
											border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary
											active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
									</div>
								
									<div class="w-full mt-8">
										<label for="user_website" class="font-bold text-base text-black block mb-3">
											{{ __('Website') }}
										</label>
										<input type="text" name="user_website" value="{{ $user->website }}" placeholder=" {{ __('Website') }}" class="w-full border-[1.5px]
											border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary
											active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
									</div>

									<div class="w-full mt-8">
										<label for="user_github" class="font-bold text-base text-black block mb-3">
											{{ __('Github') }}
										</label>
										<input type="text" name="user_github" value="{{ $user->github }}" placeholder=" {{ __('Github') }}" class="w-full border-[1.5px]
											border-form-stroke rounded-lg py-3 px-5 font-medium ext-body-color placeholder-body-color outline-none focus:border-primary
											active:border-primary transition disabled:bg-[#F5F7FD] disabled:cursor-default">
									</div>
			
									<input type="submit" class="mt-8 py-4 px-10 lg:px-8 xl:px-10 inline-flex items-center justify-center text-center text-white text-base text-xl bg-lime-500
										hover:bg-opacity-90 font-normal rounded-md hover:cursor-pointer">
								</form>

								@if ($errors->any())
									@foreach ($errors->all() as $error)
										{{ $error }}
									@endforeach
								@endif
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>