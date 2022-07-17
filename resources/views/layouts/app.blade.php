<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <header class="bg-white shadow">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    @include('layouts.navigation')
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

		<script>
			(function() {
				var toolbar = `undo redo | formatselect | bold italic | foreColor | alignleft aligncenter alignright alignjustify |
								indent outdent | bullist numlist | blockquote | code | image | table`;
				tinymce.init({
					selector: '.tinymce', // Replace this CSS selector to match the placeholder element for TinyMCE
					plugins: 'image code table lists',
					toolbar: toolbar
				});
			})();
		</script>
    </body>
</html>
