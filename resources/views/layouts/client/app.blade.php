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
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
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
                        @auth
                            <a href="{{route('client.reservations')}}" class="border-transparent text-gray-500 hover:border-pink-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Mes réservations</a>
                        @endauth
                        <a href="#contact-section" class="border-transparent text-gray-500 hover:border-pink-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Contact</a>
                    </nav>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    @auth
                        <!-- Dropdown menu -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                @if(Auth::user()->photo)
                                    <img class="h-8 w-8 rounded-full object-cover" 
                                        src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                        alt="Photo de profil de {{ Auth::user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                @endif
                                    <span class="ml-2 text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down ml-1 text-xs text-gray-500"></i>
                                </button>
                            </div>
                            
                            <!-- Dropdown items -->
                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition ease-out duration-200 transform z-50" id="user-menu">
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Mon Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                    <div class="flex space-x-3">
    <a href="{{ route('login') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-medium shadow-sm">
        Connexion
    </a>
    <a href="{{ route('register') }}" class="bg-pink-600 text-white hover:bg-pink-700 px-4 py-2 rounded-md text-sm font-medium shadow-sm">
        Inscription
    </a>
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
                @auth
                     <a href="" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Mes Réservation</a>
                @endauth
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
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Mon Profil</a>
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
                        <li><a href="#contact-section" class="text-gray-300 hover:text-pink-400">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 id="contact-section" class="text-lg font-semibold text-white mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-pink-400"></i>
                            <span>123 Agadir Bay, 75001 Agadir</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2 text-pink-400"></i>
                            <span>+212 61 23 45 67 89</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2 text-pink-400"></i>
                            <span>contact@glowup.com</span>
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
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        document.getElementById('user-menu-button').addEventListener('click', function(event) {
            event.stopPropagation();
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('transform');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('opacity-100');
            menu.classList.toggle('scale-95');
            menu.classList.toggle('scale-100');
            
            const isExpanded = menu.classList.contains('hidden') ? 'false' : 'true';
            this.setAttribute('aria-expanded', isExpanded);
        });

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('user-menu');
            const button = document.getElementById('user-menu-button');
            
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>