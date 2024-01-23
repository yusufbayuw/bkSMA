<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
 
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>{{ config('app.name') }}</title>
 
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
 
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
 
    <body class="antialiased">
        <div class="font-sans bg-gray-100">

            <div class="container mx-auto mt-8">
                <div class="max-w-xl mx-auto bg-white p-6 rounded-md shadow-md">
            
                    <h2 class="text-2xl font-bold mb-4">Konsultasi a.n. {{ $event->users->name }}</h2>
            
                    <p class="text-gray-700 mb-4">Salam hormat,</p>
            
                    <p class="text-gray-700 mb-4">Kami dengan senang hati memberitahukan kepada Anda bahwa kami memiliki jadwal konsultasi</p>
            
                    <div class="bg-blue-100 p-4 mb-4 font-bold">
                        <p class="text-blue-800 font-semibold">{{ $event->users->name }} kelas {{ $event->users->kelas }}</p>
                        <p class="text-blue-700">pada {{ Carbon\Carbon::parse($event->start_date)->translatedFormat('l, d M Y') }} pukul {{ $event->start_time }}</p>
                    </div>
            
                    <p class="text-gray-700 mb-4">Terima kasih atas perhatiannya.</p>
            
                    <p class="text-gray-700">Salam,<br> Sibeta</p>
                </div>
            </div>
        </div>
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>