<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowUp - @yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr pour le calendrier -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    @yield('styles')
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="" class="text-2xl font-bold text-pink-600">GlowUp</a>
                    </div>
                    <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}" class="border-transparent text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Accueil</a>
                        <a href="{{ route('services') }}" class="border-transparent text-gray-500 hover:border-pink-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Services</a>
                        <a href="" class="border-transparent text-gray-500 hover:border-pink-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Réservation</a>
                        <a href="" class="border-transparent text-gray-500 hover:border-pink-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Contact</a>
                    </nav>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <!-- <a href="{{ route('logout') }}" class="text-gray-500 hover:text-pink-600 mr-4">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span class="ml-2 text-sm font-medium">{{ Auth::user()->name }}</span>
                        </a> -->

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf 
                            <button type="submit" class="flex items-center text-gray-500 hover:text-pink-600 mr-4 transition duration-200 ease-in-out">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <span class="ml-2 text-sm font-medium">{{ Auth::user()->name }}</span>
                            </button>
                        </form>

                    @else
                        <div class="flex space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-pink-600 font-medium">Connexion</a>
                            <a href="{{ route('register') }}" class="bg-pink-600 text-white hover:bg-pink-700 px-4 py-2 rounded-md text-sm font-medium">Inscription</a>
                        </div>
                    @endauth
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-pink-500">
                        <span class="sr-only">Ouvrir le menu</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="bg-pink-50 border-pink-500 text-pink-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Accueil</a>
                <a href="{{ route('services') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Services</a>
                <a href="" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Réservation</a>
                <a href="" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Contact</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                @auth
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Mon espace</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Déconnexion</button>
                        </form>
                    </div>
                @else
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Connexion</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Inscription</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-pink-400 mb-4">GlowUp</h3>
                    <p class="text-gray-300">Votre salon de beauté dédié à votre bien-être et à votre éclat naturel.</p>
                    <div class="flex mt-4 space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-400">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-400">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-400">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-pink-400">Accueil</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-pink-400">Services</a></li>
                        <li><a href="" class="text-gray-300 hover:text-pink-400">Réservation</a></li>
                        <li><a href="" class="text-gray-300 hover:text-pink-400">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-pink-400"></i>
                            <span>123 Avenue de la Beauté, 75001 Paris</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2 text-pink-400"></i>
                            <span>+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-pink-400"></i>
                            <span>contact@glowup.fr</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} GlowUp. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/fr.min.js"></script>
    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
    @yield('scripts')
</body>
</html>