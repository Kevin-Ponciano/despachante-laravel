<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/img/logo3.png') }}" type="image/png"/>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Tabler CSS -->
    @vite('resources/css/tabler.min.css')
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <!-- Styles -->
    @livewireStyles
    <!-- Fonts -->
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>
<body class="font-sans antialiased">
<script src="{{asset('assets/js/theme.js')}}"></script>
<div class="page">
    <main>
        {{ $slot }}
    </main>
    <x-modal-novo/>
</div>

@stack('modals')

<!-- Vite Scripts -->
@vite(['resources/js/tabler.min.js'])
<!-- Imask -->
<script src="https://unpkg.com/imask"></script>
<script src="{{asset('assets/js/imask.config.js')}}"></script>
@vite([ 'resources/js/app.js'])
@livewireScripts
</body>
</html>
