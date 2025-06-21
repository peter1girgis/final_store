<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>

        <script type="text/javascript" src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('message'))
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: '{{ session('message')['type'] }}',
                            text: '{{ session('message')['text'] }}'
                        }
                    }));
                @endif
            });
            window.addEventListener('toast', event => {
                const type = event.detail.type || 'info';
                const text = event.detail.text || 'No message';

                switch (type) {
                    case 'success':
                        toastr.success(text, 'Success!');
                        break;
                    case 'error':
                        toastr.error(text, 'Error!');
                        break;
                    case 'warning':
                        toastr.warning(text, 'Warning!');
                        break;
                    default:
                        toastr.info(text, 'Info');
                }
            });

</script>


    </body>
</html>
