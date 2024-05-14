<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('head')
    </head>
    <body>
        @include('navbar')
        <main class="container my-5">
            <div class="row">
              <div class="col-md-6 offset-md-3">
                <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
              </div>      
            </div>
        </main>
        @include('footer')
    </body>
</html>
