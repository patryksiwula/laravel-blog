@extends('layouts.app')

@section('content')
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="py-16 px-10 sm:px-16 lg:px-28 border-b border-gray-200">
						@yield('page_title')
						@yield('page_content')
					</div>
				</div>
			</div>
		</div>
@endsection