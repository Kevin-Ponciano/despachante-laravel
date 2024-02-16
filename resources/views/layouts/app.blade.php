<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/img/logo3.png') }}" type="image/png"/>
    <title>{{ config('app.name')}}</title>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css">
    @vite(['resources/css/tabler-css.js','resources/js/app.js','resources/css/app.css'])

    <!-- Datatable CSS -->
    <link
        href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.5/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css"
        rel="stylesheet"/>
    <!-- Datatable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-1.13.5/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

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
<x-loading-page/>
<div class="page pb-2">
    @if(Auth::user()->isDespachante())
        <x-navbar-despachante/>
    @elseif(Auth::user()->isCliente())
        <x-navbar-cliente/>
    @endif
    <div class="page-wrapper">
        {{$slot}}
    </div>
    <x-footer/>
    <x-modal-novo/>
</div>

@stack('modals')
@livewireScripts
<!-- Imask -->
<script src="https://unpkg.com/imask"></script>
<script src="{{asset('assets/js/mask.config.js')}}"></script>
<!-- DataTable -->
<script src="{{asset('assets/js/datatable.config.js')}}"></script>
<!-- TomSelect -->
<script src="{{asset('assets/js/libs/tom-select/dist/js/tom-select.complete.min.js')}}"></script>
<script src="{{asset('assets/js/tomSelect.config.js')}}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/Toast.config.js')}}"></script>
<!-- Scripts -->
<script src="{{asset('assets/js/app.js')}}"></script>
@if(session()->has('error'))
    <script>
        error('{{session('error')}}')
    </script>
@elseif(session()->has('success'))
    <script>
        success('{{session('success')}}')
    </script>
@endif
</body>
</html>
