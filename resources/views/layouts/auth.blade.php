<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    </html><title>@yield('title') - GlowUp</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-r from-indigo-50 to-purple-50 min-h-screen">
    <!-- Contenu de la page -->
    <main class="flex items-center justify-center min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-gray-600">
        &copy; {{ date('Y') }} GlowUp. Tous droits réservés.
    </footer>
</body>
