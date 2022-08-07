@extends('layouts.content')

@section('page_title')
	<h2 class="font-semibold text-2xl text-gray-800 leading-tight">
		{{ __('Categories list') }}
	</h2>
@endsection

@section('page_content')
	<div class="mt-10">
		@can('create', App\Category::class)
			<a href="{{ route('categories.create') }}" class="py-2 px-4 inline-flex items-center justify-center text-center
				text-white text-lg bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
				{{ __('Add category') }}
			</a>
		@endcan

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
								{{ __('Slug') }}
							</th>
							<th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
								{{ __('Action') }}
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($categories as $category)
							<tr>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{ $category->id }}
									</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{ $category->name }}
									</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
										{{ $category->slug }}
									</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<a href="{{ route('posts.index', ['categories' => $category->id]) }}" class="py-1 px-2 inline-flex items-center
										justify-center text-center text-white text-sm bg-blue-500 hover:bg-opacity-90 font-normal rounded-md">
										{{ __('Show posts') }}
									</a>

									@can('update', $category)
										<a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="py-1 px-2 inline-flex items-center
											justify-center text-center text-white text-sm bg-lime-500 hover:bg-opacity-90 font-normal rounded-md">
											{{ __('Edit') }}
										</a>
									@endcan

									@can('delete', $category)
										<form action="{{ route('categories.destroy', ['category' => $category]) }}" method="POST" class="inline-flex">
											@csrf
											@method('DELETE')

											<button type="submit" class="py-1 px-2 inline-flex items-center justify-center text-center text-white
												text-sm bg-red-500 hover:bg-opacity-90 font-normal rounded-md">
												{{ __('Delete') }}
											</button>
										</form>
									@endcan
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>
@endsection