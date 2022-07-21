<x-app-layout>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
					<h1 class="font-bold">{{ __('Users list') }}</h1>
					<section class="mt-10 pb-10 lg:pb-20">
						<div class="container mx-auto">
							<table class="min-w-full leading-normal">
								<thead>
									<tr>
										<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
											{{ __('ID') }}
										</th>
										<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
											{{ __('Name') }}
										</th>
										<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
											{{ __('E-Mail') }}
										</th>
										<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
											{{ __('Admin') }}
										</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($users as $user)
										<tr>
											<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
												<p class="text-gray-900 whitespace-no-wrap">
													{{ $user->id }}
												</p>
											</td>
											<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
												<div class="flex items-center">
													<div class="flex-shrink-0">
														<a href="{{ route('users.show', ['user' => $user]) }}" class="block relative">
															@if ($user->image_path == 'https://via.placeholder.com/200x200.png/CCCCCC?text=User')
																<img alt="{{ $user->name }}" src="https://via.placeholder.com/200x200.png/CCCCCC?text=User"
																class="mx-auto object-cover rounded-full h-10 w-10 "/>
															@else
																<img alt="{{ $user->name }}" src="{{ asset('storage/uploads/profiles/thumbnails_xs/' . $user->thumbnail_xs_path) }}"
																class="mx-auto object-cover rounded-full h-10 w-10 "/>
															@endif
														</a>
													</div>
													<div class="ml-3">
														<p class="text-gray-900 whitespace-no-wrap">
															<a href="{{ route('users.show', ['user' => $user]) }}">
																{{ $user->name }}
															</a>
														</p>
													</div>
												</div>
											</td>
											<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
												<p class="text-gray-900 whitespace-no-wrap">
													{{ $user->email }}
												</p>
											</td>
											<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
												<p class="text-gray-900 whitespace-no-wrap">
													<label class="flex items-center space-x-3 mb-3">
														@if ($user->is_admin)
															<input checked type="checkbox" name="checked-demo" class="form-tick appearance-none bg-white bg-check h-6 w-6
																border border-gray-300 rounded-md checked:bg-gray-500 checked:border-transparent focus:outline-none"/>
														@else
															<input type="checkbox" name="checked-demo" class="form-tick appearance-none bg-white bg-check h-6 w-6
																border border-gray-300 rounded-md checked:bg-gray-500 checked:border-transparent focus:outline-none"/>
														@endif
													</label>
												</p>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>