@extends('layouts.app')

@section('content')
    <section class="animate-fade-in min-h-screen px-2 md:px-4 py-10 sm:px-6 lg:px-8"
        style="background: url('/wp-content/themes/woo-tailwind-theme/resources/images/login/fondologin.jpg') center/cover no-repeat;">

        <!-- Efecto de partículas anime (opcional) -->
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="particle animate-float absolute rounded-full bg-orange-500 opacity-20"></div>
            <div class="particle animate-float-delay absolute rounded-full bg-red-500 opacity-20"></div>
            <div class="particle animate-float-delay-2 absolute rounded-full bg-blue-400 opacity-20"></div>
        </div>

        <div class="relative grid grid-cols-1 gap-8 rounded-xl border border-gray-700/50 bg-black/40 p-1 md:p-6 shadow-2xl shadow-orange-900/30 backdrop-blur-sm lg:grid-cols-4">

            {{-- Menú Lateral estilo anime --}}
            <aside class="lg:col-span-1">
                <div
                    class="transform overflow-hidden rounded-xl border-l-4 border-orange-500 bg-stone-700/80 shadow-lg transition-all duration-500 hover:shadow-yellow-400/50">
                    <div class="border-b border-stone-700 p-4">
                        <h2 class="flex items-center font-['Arial'] text-xl font-bold tracking-wider text-orange-400">
                            <svg class="mr-2 h-6 w-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                            MI CUENTA GEEK
                        </h2>
                        <p class="mt-1 text-sm text-white">Bienvenido,
                            @php
                                $current_user = wp_get_current_user();
                                if ($current_user->exists()) {
                                    echo '<span class="text-orange-400">' . esc_html($current_user->display_name) . '</span>';
                                } else {
                                    echo '<span class="text-orange-400">guerrero Z</span>';
                                }
                            @endphp
                        </p>
                    </div>

                    <nav class="anime-menu flex flex-col">
                        @php
                            ob_start();
                            do_action('woocommerce_account_navigation');
                            $menu = ob_get_clean();
                        @endphp
                        {!! str_replace(
                            '<li',
                            '<li class="px-5 py-3 border-b border-gray-800 hover:bg-gradient-to-r from-yellow-600/30 to-transparent group transition-all duration-300 cursor-pointer flex items-center"',
                            $menu,
                        ) !!}
                    </nav>

                </div>
            </aside>

            {{-- Contenido principal con estilo anime --}}
            <main class="space-y-6 lg:col-span-3">
                @php wc_print_notices() @endphp

                <div
                    class="anime-content transform rounded-xl border-l-4 border-orange-500 bg-gray-900/80 p-6 text-gray-200 shadow-lg transition duration-500 hover:shadow-yellow-500/30">
                    <div class="mb-4 flex items-center">
                        <svg class="mr-3 h-8 w-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        <h1 class="font-['Impact'] text-2xl font-bold tracking-wide text-orange-400">PANEL GEEK</h1>
                    </div>

                    <div class="anime-fade-in">
                        @php do_action('woocommerce_account_content') @endphp
                    </div>
                </div>

                <!-- Widget de anime recomendado -->

            </main>

        </div>
    </section>

    <style>
        /* Animaciones personalizadas */
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .anime-menu a {
            color: #a8a29e;
            /* Gris piedra exacto */
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .anime-menu a:before {
            content: "❯";
            @apply text-orange-500 mr-2 text-xs opacity-0 group-hover:opacity-100 transition-all duration-300;
        }

        .anime-menu li:hover {
            @apply translate-x-1;
        }

        .anime-content {
            animation: contentAppear 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }

        @keyframes contentAppear {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anime-fade-in {
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .particle {
            width: 5px;
            height: 5px;
        }

        .particle:nth-child(1) {
            top: 20%;
            left: 10%;
        }

        .particle:nth-child(2) {
            top: 60%;
            left: 80%;
        }

        .particle:nth-child(3) {
            top: 40%;
            left: 50%;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float 7s ease-in-out infinite 1s;
        }

        .animate-float-delay-2 {
            animation: float 5s ease-in-out infinite 2s;
        }
    </style>
@endsection
