@extends('layouts.content')

@section('title', __('Users list'))

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Users list') }}
	</h2>
@endsection

@section('page_content')
	<div class="mt-10">
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

							@if (Auth::user()->is_admin)
								<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
									{{ __('Admin') }}
								</th>
							@endif
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

								@can('delete', $user)
									<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
										<livewire:set-admin :user="$user" />
									</td>
								@endcan
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>
@endsection