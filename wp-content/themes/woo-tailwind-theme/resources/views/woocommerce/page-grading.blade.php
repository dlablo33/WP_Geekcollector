{{--
  Template Name: Grading Template
--}}
@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        :root {
            --primary: #ea580c;
            --primary-dark: #c2410c;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        .hero-banner {
            position: relative;
            height: 60vh;
            min-height: 400px;
            overflow: hidden;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1612036782180-6f0b6cd846fe?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
            z-index: 1;
        }

        .hero-banner img {
            object-position: center 30%;
            transition: transform 0.5s ease;
        }

        .hero-banner:hover img {
            transform: scale(1.05);
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
        }

        .card {
            perspective: 1000px;
            will-change: transform;
            transition: transform 400ms cubic-bezier(0.03, 0.98, 0.52, 0.99);
            max-width: 310px;
            max-height: 365px;
            perspective: 1000px;
            border-radius: 2rem;
        }

        .card img {
            height: 100%;
            width: auto;
            object-fit: cover;
            transform: rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1);
            transform-style: preserve-3d;
            will-change: transform;
            border-radius: 1rem;
        }

        .gradient-text {
            background: linear-gradient(to right, #fbbf24, #ea580c, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-border {
            border: 2px solid transparent;
            background: linear-gradient(var(--dark), var(--dark)) padding-box,
                linear-gradient(to right, #fbbf24, #ea580c, #dc2626) border-box;
        }

        .stats-bar {
            height: 20px;
            background: linear-gradient(to right, #fbbf24, #ea580c, #dc2626);
            border-radius: 10px;
            margin: 5px 0;
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(234, 88, 12, 0.3);
        }

        /* Laptop */
        @media (max-width: 1536px) {
            .card {
                max-width: 280px;
                max-height: 330px;
            }
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .card {
                max-width: 240px;
                max-height: 285px;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .card {
                max-width: 296.4px;
                max-height: 351px;
            }

            .hero-banner {
                height: 50vh;
                min-height: 350px;
            }
        }
    </style>

    <div class="px-2 md:px-0">
        <!-- Hero Section Mejorada -->
        <section class="hero-banner relative flex items-center justify-center overflow-hidden bg-slate-900">
            <!-- 🎬 Video de fondo -->
            <video autoplay muted loop playsinline class="absolute inset-0 z-0 h-full w-full object-cover">
                <source src="<?php echo get_template_directory_uri(); ?>/resources/images/grading/valup.mp4" type="video/mp4">
            </video>

            <!-- 🎯 Capa oscura para contraste -->
            <div class="absolute inset-0 z-0 bg-black/60"></div>

            <!-- 💬 Contenido principal -->
            <div class="container relative z-10 mx-auto px-4 text-center">
                <h1 class="mb-4 text-4xl font-bold text-white md:text-6xl">
                    Aumenta el valor de tus cartas mientras las proteges
                </h1>

                <p class="mb-8 text-xl text-orange-200 md:text-2xl">
                    Protege • Gradúa • Valora
                </p>

                <p class="mx-auto mb-10 max-w-2xl text-lg text-orange-100 md:text-xl">
                    Protege tus cartas. Hazlas subir de nivel. O haz que tu colección brille y gane valor con
                    nuestro sistema de graduación premium.
                </p>

                <button
                    class="rounded-full bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 px-8 py-3 text-lg font-bold text-white transition-opacity hover:opacity-90">
                    Comenzar Ahora
                </button>
            </div>
        </section>

        <!-- Sección de Comparativa: Carta Normal vs Graduada -->
        <section class="relative overflow-hidden bg-black py-20">
            <!-- Fondo animado -->
            <div class="absolute inset-0 animate-pulse bg-[radial-gradient(circle_at_center,_rgba(255,255,255,0.05),_transparent_70%)] opacity-70"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 to-black"></div>

            <div class="container relative mx-auto px-6">
                <!-- Título -->
                <div class="mb-16 text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2 class="mb-4 text-5xl font-extrabold tracking-tight text-white md:text-6xl">
                        Transforma tu <span class="animate-gradient bg-gradient-to-r from-yellow-400 via-orange-500 to-red-600 bg-clip-text text-transparent">Inversión</span>
                    </h2>
                    <p class="mx-auto max-w-3xl text-xl leading-relaxed text-gray-400">
                        Descubre cómo la graduación profesional multiplica el valor de tus cartas y las protege para siempre
                    </p>
                </div>

                <!-- Comparativa Visual -->
                <div class="mb-20 grid grid-cols-1 gap-10 lg:grid-cols-2">
                    <!-- Carta Normal -->
                    <div class="rounded-2xl border border-slate-700 bg-slate-900/70 p-8 backdrop-blur-md transition-all duration-500 hover:scale-[1.02] hover:border-slate-500"
                        data-aos="fade-right">
                        <div class="mb-6 text-center">
                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-700 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-400">Carta Sin Graduar</h3>
                            <p class="italic text-gray-500">Vulnerable • Sin certificación • Valor incierto</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between rounded-lg bg-slate-800/70 p-4 transition hover:bg-slate-700">
                                <span class="text-gray-300">Valor de mercado</span>
                                <span class="text-lg font-bold text-gray-400">$800 - $1,200</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-800/70 p-4 transition hover:bg-slate-700">
                                <span class="text-gray-300">Protección</span>
                                <span class="animate-pulse text-red-400">❌ Limitada</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-800/70 p-4 transition hover:bg-slate-700">
                                <span class="text-gray-300">Autenticidad</span>
                                <span class="animate-pulse text-red-400">❌ No verificada</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-800/70 p-4 transition hover:bg-slate-700">
                                <span class="text-gray-300">Liquidez</span>
                                <span class="text-yellow-400">⚠️ Media</span>
                            </div>
                        </div>
                    </div>

                    <!-- Carta Graduada -->
                    <div class="rounded-2xl border border-yellow-600/30 bg-slate-900/80 p-8 shadow-[0_0_30px_rgba(255,170,50,0.2)] backdrop-blur-md transition-all duration-500 hover:scale-[1.03] hover:border-yellow-400"
                        data-aos="fade-left">
                        <div class="absolute right-4 top-4">
                            <span class="animate-pulse rounded-full bg-gradient-to-r from-yellow-500 to-orange-600 px-4 py-1 text-sm font-bold text-white shadow-md">
                                RECOMENDADO
                            </span>
                        </div>
                        <div class="mb-6 text-center">
                            <div
                                class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 shadow-[0_0_25px_rgba(255,200,100,0.5)]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Carta Graduada</h3>
                            <p class="italic text-orange-300">Protegida • Certificada • Valor garantizado</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 p-4 transition hover:scale-[1.02]">
                                <span class="text-white">Valor de mercado</span>
                                <span class="text-lg font-bold text-green-400">$2,500 - $4,000</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 p-4 transition hover:scale-[1.02]">
                                <span class="text-white">Protección</span>
                                <span class="text-green-400">✅ Máxima</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 p-4 transition hover:scale-[1.02]">
                                <span class="text-white">Autenticidad</span>
                                <span class="text-green-400">✅ Certificada</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-gradient-to-r from-slate-700 to-slate-600 p-4 transition hover:scale-[1.02]">
                                <span class="text-white">Liquidez</span>
                                <span class="text-green-400">✅ Alta</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incremento de Valor -->
                <div class="mb-20 rounded-2xl border border-slate-700 bg-slate-900/80 p-10 text-center shadow-inner backdrop-blur-xl" data-aos="zoom-in">
                    <h3 class="mb-10 text-3xl font-bold text-white">
                        Incremento Promedio de Valor: <span
                            class="animate-gradient bg-gradient-to-r from-green-400 via-lime-400 to-yellow-400 bg-clip-text text-transparent">+212%</span>
                    </h3>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <div class="transform transition hover:scale-105">
                            <div class="mb-2 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-5xl font-extrabold text-transparent">3.1x</div>
                            <p class="text-gray-300">Cartas Comunes</p>
                            <p class="text-sm text-gray-500">+210% promedio</p>
                        </div>
                        <div class="transform transition hover:scale-105">
                            <div class="mb-2 bg-gradient-to-r from-violet-400 to-fuchsia-400 bg-clip-text text-5xl font-extrabold text-transparent">4.5x</div>
                            <p class="text-gray-300">Cartas Raras</p>
                            <p class="text-sm text-gray-500">+350% promedio</p>
                        </div>
                        <div class="transform transition hover:scale-105">
                            <div class="mb-2 bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-5xl font-extrabold text-transparent">6.2x</div>
                            <p class="text-gray-300">Cartas Épicas</p>
                            <p class="text-sm text-gray-500">+520% promedio</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Final -->
                <div class="mt-20 text-center" data-aos="fade-up">
                    <div class="rounded-2xl border border-slate-700 bg-gradient-to-r from-slate-900 to-slate-800 p-10 shadow-[0_0_30px_rgba(255,255,255,0.05)]">
                        <h3 class="mb-4 text-3xl font-bold text-white">
                            ¿Listo para multiplicar el valor de tu colección?
                        </h3>
                        <p class="mb-8 text-lg text-gray-300">
                            Únete a miles de coleccionistas que ya han incrementado su <span class="font-semibold text-orange-400">Patrimonio</span>
                        </p>
                        <button
                            class="relative overflow-hidden rounded-full bg-gradient-to-r from-yellow-500 via-orange-500 to-red-600 px-14 py-4 text-lg font-bold text-white shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,150,50,0.6)]">
                            <span class="relative z-10">Empezar a Graduar</span>
                            <span class="absolute inset-0 animate-pulse bg-white/10 blur-xl"></span>
                        </button>
                        <p class="mt-4 text-sm text-gray-500">
                            Proceso 100% seguro • Envío protegido • Resultados en 7-10 días
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- AOS Library -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 1000,
                once: true
            });
        </script>

        <style>
            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient 5s ease infinite;
            }
        </style>

        <style>
            .swiper-button-next,
            .swiper-button-prev {
                color: #f59e0b;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 24px;
            }
        </style>

        <!-- Últimas Ventas Registradas -->
        <section class="relative overflow-hidden bg-black py-20">
            <!-- Elementos de fondo decorativos -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="animate-pulse-slow absolute left-1/4 top-0 h-40 w-40 rounded-full bg-gradient-to-r from-green-500/10 to-emerald-500/10 blur-3xl"></div>
                <div class="animate-pulse-slow absolute bottom-0 right-1/4 h-40 w-40 rounded-full bg-gradient-to-r from-blue-500/10 to-cyan-500/10 blur-3xl delay-1000">
                </div>
            </div>

            <div class="container relative z-10 mx-auto px-4">
                <div class="mb-12 text-center">
                    <div class="mb-4 inline-block">
                        <span class="animate-bounce-subtle rounded-full bg-gradient-to-r from-orange-500 to-orange-500 px-4 py-2 text-sm font-bold text-white">
                            💰 ÚLTIMAS VENTAS REGISTRADAS
                        </span>
                    </div>
                    <h2 class="animate-fade-in-up mb-4 text-4xl font-bold text-white md:text-5xl">
                        Ventas <span class="gradient-text-animated">Destacadas</span>
                    </h2>
                    <p class="animate-fade-in-up mx-auto max-w-2xl text-xl text-gray-300 delay-200">
                        Descubre las transacciones más importantes realizadas en nuestra plataforma
                    </p>
                </div>

                @php
                    $sales = [
                        [
                            'img' => 'grading_pokemon.PNG',
                            'name' => 'MEW EX',
                            'type' => 'Subasta',
                            'initial_price' => 9500,
                            'final_price' => 15685,
                            'increase_percent' => 65.11,
                            'rarity' => 'legendary',
                            'time_ago' => '2 horas',
                        ],
                        [
                            'img' => 'grading_lorcana.jpg',
                            'name' => 'PIKACHU WITH GREY FELT HAT',
                            'type' => 'Subasta',
                            'initial_price' => 1900,
                            'final_price' => 8900,
                            'increase_percent' => 368.42,
                            'rarity' => 'epic',
                            'time_ago' => '5 horas',
                        ],
                        [
                            'img' => 'grading_magic.jpg',
                            'name' => 'GRENINJA EX (JAPANESE)',
                            'type' => 'Subasta',
                            'initial_price' => 2000,
                            'final_price' => 7550,
                            'increase_percent' => 277.5,
                            'rarity' => 'rare',
                            'time_ago' => '8 horas',
                        ],
                        [
                            'img' => 'grading_onepiece.png',
                            'name' => 'CHARIZARD 1ST EDITION',
                            'type' => 'Venta Directa',
                            'initial_price' => 12000,
                            'final_price' => 25400,
                            'increase_percent' => 111.67,
                            'rarity' => 'mythic',
                            'time_ago' => '1 día',
                        ],
                        [
                            'img' => 'grading_yugioh.jpg',
                            'name' => 'BLUE-EYES WHITE DRAGON',
                            'type' => 'Subasta',
                            'initial_price' => 8500,
                            'final_price' => 18200,
                            'increase_percent' => 114.12,
                            'rarity' => 'ultra',
                            'time_ago' => '2 días',
                        ],
                    ];
                @endphp

                <!-- Slider Container -->
                <div class="group relative">
                    <div class="swiper salesSwiper pb-12">
                        <div class="swiper-wrapper">
                            @foreach ($sales as $sale)
                                <div class="swiper-slide">
                                    <div
                                        class="group/card h-full rounded-3xl border-2 border-gray-800 bg-gradient-to-br from-gray-900 to-gray-800 p-6 transition-all duration-500 hover:scale-105 hover:border-orange-500 hover:shadow-2xl hover:shadow-orange-500/10">
                                        <!-- Badge de rareza -->
                                        <div class="mb-4 flex items-start justify-between">
                                            <div class="rounded-full bg-gradient-to-r from-orange-500 to-orange-500 px-3 py-1 text-xs font-bold capitalize text-white">
                                                {{ $sale['rarity'] }}
                                            </div>
                                            <div class="flex items-center text-sm text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $sale['time_ago'] }}
                                            </div>
                                        </div>

                                        <!-- Contenedor de la carta con efecto de zoom -->
                                        <div class="card-zoom-container relative mb-6">
                                            <div class="relative mx-auto w-full max-w-xs">
                                                <!-- Efecto de brillo -->
                                                <div
                                                    class="absolute inset-0 rounded-2xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 opacity-0 blur-lg transition-all duration-500 group-hover/card:opacity-100 group-hover/card:blur-xl">
                                                </div>

                                                <!-- Carta con efecto de zoom -->
                                                <div
                                                    class="card-zoom-wrapper relative transform rounded-2xl bg-gradient-to-br from-orange-400 via-orange-500 to-orange-500 p-1 transition-all duration-500 group-hover/card:rotate-2">
                                                    <div class="card-zoom-inner relative overflow-hidden rounded-xl bg-black">
                                                        <img src="{{ asset('resources/images/grading/' . $sale['img']) }}" alt="{{ $sale['name'] }}"
                                                            class="card-zoom-image h-48 w-full rounded-xl object-cover transition-transform duration-700 ease-out">

                                                        <!-- Overlay para el efecto de zoom -->
                                                        <div
                                                            class="card-zoom-overlay absolute inset-0 flex items-end justify-center bg-gradient-to-t from-black/80 via-transparent to-transparent pb-4 opacity-0 transition-all duration-500 group-hover/card:opacity-100">
                                                            <span class="rounded-full bg-black/50 px-3 py-1 text-sm font-semibold text-white backdrop-blur-sm">
                                                                Ver detalles
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tipo de venta -->
                                                <div class="absolute -right-2 -top-2 z-10">
                                                    <div
                                                        class="rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 px-3 py-1 text-xs font-bold text-white shadow-lg">
                                                        {{ $sale['type'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Información de la venta -->
                                        <div class="mb-4 text-center">
                                            <h3 class="mb-2 text-xl font-bold text-white transition-colors duration-300 group-hover/card:text-green-400">
                                                {{ $sale['name'] }}
                                            </h3>
                                            <div class="mb-4 text-sm text-gray-400">{{ $sale['type'] }}</div>
                                        </div>

                                        <!-- Precios -->
                                        <div class="mb-4 space-y-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-300">Precio inicial:</span>
                                                <span class="font-semibold text-red-400 line-through">${{ number_format($sale['initial_price']) }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-300">Precio final:</span>
                                                <span class="text-lg font-bold text-green-400">${{ number_format($sale['final_price']) }}</span>
                                            </div>
                                        </div>

                                        <!-- Incremento -->
                                        <div class="rounded-xl border-2 border-gray-700 bg-gray-800 p-4 transition-all duration-300 group-hover/card:border-green-500/50">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-green-500 to-emerald-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="text-xl font-bold text-white">+{{ number_format($sale['increase_percent'], 1) }}%</div>
                                                        <div class="text-xs text-gray-400">Incremento</div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-lg font-bold text-yellow-400">+${{ number_format($sale['final_price'] - $sale['initial_price']) }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">Ganancia</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Barra de progreso del incremento -->
                                        <div class="mt-4">
                                            <div class="mb-1 flex justify-between text-xs text-gray-400">
                                                <span>Rendimiento de la inversión</span>
                                                <span class="text-green-400">Excelente</span>
                                            </div>
                                            <div class="h-2 w-full rounded-full bg-gray-700">
                                                <div class="h-2 rounded-full bg-gradient-to-r from-green-500 to-emerald-500 transition-all duration-1000 ease-out"
                                                    style="width: {{ min($sale['increase_percent'] / 5, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="swiper-pagination mt-8"></div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="swiper-button-next bg-black/80 opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100"></div>
                    <div class="swiper-button-prev bg-black/80 opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100"></div>
                </div>

                <!-- Estadísticas adicionales -->
                <div class="mt-12 grid grid-cols-2 gap-6 md:grid-cols-4">
                    <div class="group text-center">
                        <div
                            class="rounded-2xl border-2 border-gray-800 bg-gradient-to-br from-gray-900 to-gray-800 p-6 transition-all duration-500 hover:scale-105 hover:border-green-500">
                            <div class="text-3xl font-bold text-green-400">$68,835</div>
                            <div class="mt-2 text-sm text-gray-400">Volumen Total</div>
                        </div>
                    </div>
                    <div class="group text-center">
                        <div
                            class="rounded-2xl border-2 border-gray-800 bg-gradient-to-br from-gray-900 to-gray-800 p-6 transition-all duration-500 hover:scale-105 hover:border-yellow-500">
                            <div class="text-3xl font-bold text-yellow-400">+185%</div>
                            <div class="mt-2 text-sm text-gray-400">Promedio ROI</div>
                        </div>
                    </div>
                    <div class="group text-center">
                        <div
                            class="rounded-2xl border-2 border-gray-800 bg-gradient-to-br from-gray-900 to-gray-800 p-6 transition-all duration-500 hover:scale-105 hover:border-blue-500">
                            <div class="text-3xl font-bold text-blue-400">24/7</div>
                            <div class="mt-2 text-sm text-gray-400">Mercado Activo</div>
                        </div>
                    </div>
                    <div class="group text-center">
                        <div
                            class="rounded-2xl border-2 border-gray-800 bg-gradient-to-br from-gray-900 to-gray-800 p-6 transition-all duration-500 hover:scale-105 hover:border-purple-500">
                            <div class="text-3xl font-bold text-purple-400">98.7%</div>
                            <div class="mt-2 text-sm text-gray-400">Transacciones Exitosas</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* Efectos de zoom para las cartas */
            .card-zoom-container {
                perspective: 1000px;
            }

            .card-zoom-wrapper {
                transform-style: preserve-3d;
                transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .card-zoom-inner {
                transform-style: preserve-3d;
                transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            }

            .card-zoom-image {
                transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
                transform-origin: center center;
            }

            /* Efecto al hacer hover en la tarjeta completa */
            .group\/card:hover .card-zoom-wrapper {
                transform: rotateY(5deg) rotateX(5deg) scale(1.05);
                box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.25);
            }

            .group\/card:hover .card-zoom-image {
                transform: scale(1.15);
                filter: brightness(1.1) contrast(1.1);
            }

            .group\/card:hover .card-zoom-inner {
                transform: translateZ(20px);
            }

            /* Overlay mejorado */
            .card-zoom-overlay {
                background: linear-gradient(0deg,
                        rgba(0, 0, 0, 0.9) 0%,
                        rgba(0, 0, 0, 0.7) 30%,
                        rgba(0, 0, 0, 0.4) 60%,
                        transparent 100%);
                backdrop-filter: blur(2px);
            }

            /* Efecto de brillo dinámico */
            .group\/card:hover .card-zoom-wrapper::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                background: linear-gradient(45deg, #F97316, #EA580C, #C2410C, #F97316);
                background-size: 400% 400%;
                border-radius: 24px;
                z-index: -1;
                animation: gradient-border 3s ease infinite;
                opacity: 0.8;
            }

            @keyframes gradient-border {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            /* Estilos específicos para el slider de ventas */
            .swiper.salesSwiper {
                padding: 20px 10px;
            }

            .swiper-slide {
                height: auto;
            }

            .swiper-pagination-bullet {
                background: #4B5563;
                opacity: 0.5;
                width: 10px;
                height: 10px;
            }

            .swiper-pagination-bullet-active {
                background: linear-gradient(45deg, #F97316, , #EA580C);
                opacity: 1;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: #10B981;
                background: rgba(0, 0, 0, 0.8);
                width: 50px;
                height: 50px;
                border-radius: 50%;
                backdrop-filter: blur(10px);
                border: 2px solid #374151;
            }

            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 20px;
                font-weight: bold;
            }

            /* Asegurar que las animaciones existan */
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes pulse-slow {

                0%,
                100% {
                    opacity: 0.1;
                }

                50% {
                    opacity: 0.2;
                }
            }

            @keyframes bounce-subtle {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out forwards;
            }

            .animate-pulse-slow {
                animation: pulse-slow 4s ease-in-out infinite;
            }

            .animate-bounce-subtle {
                animation: bounce-subtle 2s ease-in-out infinite;
            }

            .gradient-text-animated {
                background: linear-gradient(45deg, #10B981, #059669, #047857);
                background-size: 300% 300%;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: gradient-shift 3s ease infinite;
            }

            @keyframes gradient-shift {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar Swiper para las ventas
                const salesSwiper = new Swiper('.salesSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                        1280: {
                            slidesPerView: 4,
                        },
                    },
                });

                // Efecto de parallax mejorado para las cartas
                const cards = document.querySelectorAll('.card-zoom-wrapper');

                cards.forEach(card => {
                    card.addEventListener('mousemove', (e) => {
                        const cardRect = card.getBoundingClientRect();
                        const x = e.clientX - cardRect.left;
                        const y = e.clientY - cardRect.top;

                        const centerX = cardRect.width / 2;
                        const centerY = cardRect.height / 2;

                        const rotateY = (x - centerX) / 25;
                        const rotateX = (centerY - y) / 25;

                        card.style.transform = `rotateY(${rotateY}deg) rotateX(${rotateX}deg) scale(1.05)`;
                    });

                    card.addEventListener('mouseleave', () => {
                        card.style.transform = 'rotateY(0) rotateX(0) scale(1)';
                    });
                });
            });
        </script>

        <?php
        // Ruta dinámica del modelo 3D
        $model_path = get_template_directory_uri() . '/resources/images/grading/plastic_card_holder.glb';
        ?>

        <section class="relative overflow-hidden bg-black py-24 text-white">
            <!-- Fondo de estrellas -->
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-30"></div>
            </div>

            <div class="container relative z-10 mx-auto px-6 text-center">
                <h2 class="mb-16 text-4xl font-extrabold text-yellow-300 drop-shadow-lg md:text-5xl">
                    Una Obra Maestra para Exhibición
                </h2>

                <div class="grid grid-cols-1 items-center gap-10 md:grid-cols-3">
                    <!-- Lado Izquierdo -->
                    <div class="space-y-8 text-left">
                        <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-[#0f172a] to-[#1e293b] p-6">
                            <h3 class="mb-2 text-lg font-bold text-yellow-400">Claridad Óptica Superior</h3>
                            <p class="text-sm text-gray-300">Visión cristalina de tu carta, sin distorsiones con un diseño limpio y minimalista.</p>
                        </div>

                        <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-[#0f172a] to-[#1e293b] p-6">
                            <h3 class="mb-2 text-lg font-bold text-yellow-400">Cierre Ultrasónico Seguro</h3>
                            <p class="text-sm text-gray-300">Sellado hermético a prueba de manipulaciones que protege del polvo y la humedad.</p>
                        </div>
                    </div>

                    <!-- Modelo 3D al centro -->
                    <div class="flex justify-center">
                        <model-viewer id="viewer3d" src="<?php echo esc_url($model_path); ?>" alt="Plastic Card Holder 3D" camera-controls auto-rotate shadow-intensity="1"
                            style="width:100%; max-width:400px; height:500px; border-radius:1rem; background:transparent;" autoplay ar
                            ar-modes="webxr scene-viewer quick-look" exposure="1"></model-viewer>
                    </div>

                    <!-- Lado Derecho -->
                    <div class="space-y-8 text-left">
                        <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-[#0f172a] to-[#1e293b] p-6">
                            <h3 class="mb-2 text-lg font-bold text-yellow-400">Holograma de Seguridad</h3>
                            <p class="text-sm text-gray-300">El holograma, por sí solo, incorpora seis elementos de seguridad.</p>
                        </div>

                        <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-[#0f172a] to-[#1e293b] p-6">
                            <h3 class="mb-2 text-lg font-bold text-yellow-400">Ajuste de Precisión</h3>
                            <p class="text-sm text-gray-300">Inmoviliza la carta para prevenir cualquier daño por movimiento interno.</p>
                        </div>

                        <div class="rounded-2xl border border-yellow-500/40 bg-gradient-to-br from-[#0f172a] to-[#1e293b] p-6">
                            <h3 class="mb-2 text-lg font-bold text-yellow-400">Logotipo en Relieve</h3>
                            <p class="text-sm text-gray-300">Fabricado exclusivamente para único y original.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Calculadora de Precios Premium -->
        <div class="relative overflow-hidden py-24">
            <!-- Fondo animado mejorado -->
            <div class="absolute inset-0 -z-10">
                <div class="animate-gradientMove absolute inset-0 bg-gradient-to-br from-slate-900 via-purple-900 to-black"></div>
                <div
                    class="animate-pulse-slow absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-orange-500/10 via-transparent to-transparent">
                </div>
                <!-- Partículas animadas -->
                <div class="absolute inset-0 opacity-30">
                    <div class="particles-container"></div>
                </div>
            </div>

            <!-- Efectos de luz -->
            <div class="animate-float absolute -right-1/2 -top-1/2 h-96 w-full rounded-full bg-orange-500/20 blur-3xl"></div>
            <div class="animate-float-delayed absolute -bottom-1/2 -left-1/2 h-96 w-full rounded-full bg-purple-500/20 blur-3xl"></div>

            <div
                class="container relative mx-auto mb-20 mt-10 max-w-6xl overflow-hidden rounded-3xl border border-orange-500/40 bg-gradient-to-br from-slate-900/80 to-slate-800/60 px-6 py-12 shadow-2xl shadow-orange-500/20 backdrop-blur-xl">

                <!-- Efecto de borde animado -->
                <div
                    class="animate-shine absolute inset-0 rounded-3xl bg-gradient-to-r from-transparent via-orange-500/10 to-transparent opacity-0 transition-opacity duration-1000 hover:opacity-100">
                </div>

                <!-- Título mejorado -->
                <div class="mb-12 text-center">
                    <h2 class="animate-glow-text bg-gradient-to-r from-yellow-300 via-orange-400 to-red-500 bg-clip-text text-5xl font-black uppercase text-transparent drop-shadow-2xl md:text-6xl"
                        data-aos="fade-down">
                        Gradúa con nosotros
                    </h2>
                    <p class="animate-fade-in mt-4 text-xl font-light text-gray-300" data-aos="fade-up" data-aos-delay="200">
                        Transforma tu colección con nuestro servicio premium
                    </p>
                </div>

                <!-- Grid de categorías mejorado -->
                <div class="mb-14 grid grid-cols-1 gap-6 px-2 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Tarjeta Hit -->
                    <div class="premium-card group" data-aos="flip-left" data-price="1000">
                        <div class="popular-badge">Más Popular</div>
                        <div class="card-icon">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="card-title">Hit</h3>
                        <p class="card-subtitle">1 Carta</p>
                        <div class="card-price">$450</div>
                        <p class="card-note">Por carta</p>
                        <div class="card-glow"></div>
                    </div>

                    <!-- Tarjeta Mini Set -->
                    <div class="premium-card group" data-aos="flip-left" data-aos-delay="100" data-price="400">
                        <div class="card-icon">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="card-title">Mini Set</h3>
                        <p class="card-subtitle">10 Cartas</p>
                        <div class="card-price">$400</div>
                        <p class="card-note">Por carta</p>
                        <div class="card-glow"></div>
                    </div>

                    <!-- Tarjeta Collection -->
                    <div class="premium-card group" data-aos="flip-left" data-aos-delay="200" data-price="350">
                        <div class="value-badge">Mejor Valor</div>
                        <div class="card-icon">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="card-title">Collection</h3>
                        <p class="card-subtitle">30 Cartas</p>
                        <div class="card-price">$350</div>
                        <p class="card-note">Por carta</p>
                        <div class="card-glow"></div>
                    </div>

                    <!-- Tarjeta Deck -->
                    <div class="premium-card group" data-aos="flip-left" data-aos-delay="300" data-price="250">
                        <div class="card-icon">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="card-title">Deck</h3>
                        <p class="card-subtitle">50 Cartas</p>
                        <div class="card-price">$250</div>
                        <p class="card-note">Por carta</p>
                        <div class="card-glow"></div>
                    </div>
                </div>

                <!-- Controles mejorados -->
                <div class="mb-10 px-4" data-aos="fade-up">
                    <div class="relative flex flex-col items-center gap-6 lg:flex-row lg:justify-between">
                        <!-- Display de cantidad -->
                        <div class="z-50 flex items-center gap-4">
                            <span class="min-w-32 text-xl font-semibold text-gray-300">Cantidad:</span>
                            <div class="quantity-display">
                                <span id="hs-pass-value-to-html-element-target" class="quantity-value">1</span>
                            </div>
                        </div>

                        <!-- Slider mejorado -->
                        <div class="max-w-2xl lg:flex-1">
                            <div id="hs-pass-value-to-html-element" class="--prevent-on-load-init"
                                data-hs-range-slider='{
                                  "start": 1,
                                  "connect": "lower",
                                  "range": {"min": 1, "max": 50},
                                  "formatter": "integer",
                                  "cssClasses": {
                                    "target": "relative h-3 rounded-full bg-slate-700/80 backdrop-blur-sm",
                                    "base": "size-full relative z-1",
                                    "origin": "absolute top-0 end-0 size-full origin-[0_0] rounded-full z-1",
                                    "handle": "absolute top-1/2 end-0 size-7 bg-white border-4 rounded-full cursor-grab translate-x-2/4 -translate-y-2/4 border-orange-500 shadow-lg hover:scale-125 transition-transform",
                                    "connects": "relative z-0 size-full rounded-full overflow-hidden",
                                    "connect": "absolute top-0 end-0 z-1 size-full origin-[0_0] bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 animate-connect-glow",
                                    "touchArea": "absolute -inset-2"
                                  }
                                }'>
                            </div>
                            <div class="mt-3 flex justify-between text-sm font-medium text-gray-400">
                                <span>1 carta</span>
                                <span>50 cartas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resultado premium -->
                <div class="calculation-result-premium" data-aos="zoom-in" data-aos-delay="100">
                    <div class="result-content">
                        <span id="cartasNum" class="result-number"></span>
                        <span class="result-label">cartas</span>
                        <span class="result-operator">x</span>
                        <span class="result-currency">$</span>
                        <span id="precio" class="result-number"></span>
                        <span class="result-operator">=</span>
                        <span class="result-currency-total">$</span>
                        <span id="resultado" class="result-total"></span>
                    </div>
                    <div class="result-glow"></div>
                </div>

                <!-- Botón premium -->
                <div class="mt-12 flex justify-center" data-aos="zoom-in" data-aos-delay="200">
                    <button class="premium-button group">
                        <span class="button-text">Graduar Ahora</span>
                        <div class="button-icon">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <div class="button-shine"></div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Estilos CSS Mejorados -->
        <style>
            /* Animaciones avanzadas */
            @keyframes gradientMove {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-20px) rotate(1deg);
                }
            }

            @keyframes floatDelayed {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(15px) rotate(-1deg);
                }
            }

            @keyframes glowText {

                0%,
                100% {
                    filter: drop-shadow(0 0 10px rgba(255, 165, 0, 0.5));
                    background-size: 100% 100%;
                }

                50% {
                    filter: drop-shadow(0 0 20px rgba(255, 165, 0, 0.8));
                    background-size: 200% 200%;
                }
            }

            @keyframes shine {
                0% {
                    transform: translateX(-100%) skewX(-15deg);
                }

                100% {
                    transform: translateX(200%) skewX(-15deg);
                }
            }

            @keyframes connectGlow {

                0%,
                100% {
                    filter: brightness(1) saturate(1);
                }

                50% {
                    filter: brightness(1.2) saturate(1.3);
                }
            }

            @keyframes pulseSlow {

                0%,
                100% {
                    opacity: 0.1;
                }

                50% {
                    opacity: 0.3;
                }
            }

            @keyframes cardHover {
                0% {
                    transform: translateY(0) scale(1);
                }

                100% {
                    transform: translateY(-8px) scale(1.02);
                }
            }

            @keyframes buttonShine {
                0% {
                    transform: translateX(-100%) rotate(45deg);
                }

                100% {
                    transform: translateX(200%) rotate(45deg);
                }
            }

            @keyframes particlesFloat {

                0%,
                100% {
                    transform: translateY(0) rotate(0deg);
                }

                33% {
                    transform: translateY(-30px) rotate(120deg);
                }

                66% {
                    transform: translateY(15px) rotate(240deg);
                }
            }

            /* Clases de animación */
            .animate-gradientMove {
                background-size: 200% 200%;
                animation: gradientMove 8s ease infinite;
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .animate-float-delayed {
                animation: floatDelayed 7s ease-in-out infinite;
            }

            .animate-glow-text {
                animation: glowText 3s ease-in-out infinite;
            }

            .animate-shine {
                animation: shine 3s ease-in-out;
            }

            .animate-connect-glow {
                animation: connectGlow 2s ease-in-out infinite;
            }

            .animate-pulse-slow {
                animation: pulseSlow 4s ease-in-out infinite;
            }

            /* Tarjetas premium */
            .premium-card {
                position: relative;
                background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
                border: 1px solid rgba(255, 165, 0, 0.3);
                border-radius: 1.5rem;
                padding: 2rem 1.5rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                overflow: hidden;
                backdrop-filter: blur(10px);
            }

            .premium-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255, 165, 0, 0.1), transparent 30%);
                opacity: 0;
                transition: opacity 0.4s ease;
            }

            .premium-card:hover::before {
                opacity: 1;
            }

            .premium-card:hover {
                animation: cardHover 0.6s ease forwards;
                border-color: rgba(255, 165, 0, 0.6);
                box-shadow:
                    0 20px 40px rgba(255, 100, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .premium-card.active {
                background: linear-gradient(145deg, rgba(255, 165, 0, 0.15), rgba(30, 41, 59, 0.9));
                border-color: rgba(255, 165, 0, 0.8);
                box-shadow:
                    0 25px 50px rgba(255, 100, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
            }

            /* Badges */
            .popular-badge,
            .value-badge {
                position: absolute;
                top: -8px;
                right: 1rem;
                padding: 0.4rem 1rem;
                border-radius: 1rem;
                font-size: 0.75rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                z-index: 10;
            }

            .popular-badge {
                background: linear-gradient(135deg, #f59e0b, #dc2626);
                color: white;
            }

            .value-badge {
                background: linear-gradient(135deg, #8b5cf6, #ec4899);
                color: white;
            }

            /* Iconos de tarjetas */
            .card-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 4rem;
                height: 4rem;
                background: rgba(255, 165, 0, 0.1);
                border-radius: 1rem;
                margin-bottom: 1rem;
                color: #f97316;
                transition: all 0.3s ease;
            }

            .premium-card:hover .card-icon {
                background: rgba(255, 165, 0, 0.2);
                transform: scale(1.1);
                color: #ff8c00;
            }

            .card-title {
                font-size: 1.5rem;
                font-weight: 800;
                color: white;
                margin-bottom: 0.5rem;
                transition: color 0.3s ease;
            }

            .card-subtitle {
                font-size: 0.9rem;
                color: #94a3b8;
                margin-bottom: 0.5rem;
            }

            .card-price {
                font-size: 2rem;
                font-weight: 900;
                background: linear-gradient(135deg, #fbbf24, #f97316);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 0.25rem;
            }

            .card-note {
                font-size: 0.8rem;
                color: #64748b;
            }

            /* Efecto de resplandor en tarjetas */
            .card-glow {
                position: absolute;
                inset: 0;
                border-radius: 1.5rem;
                box-shadow: inset 0 0 0 1px transparent;
                transition: box-shadow 0.4s ease;
                pointer-events: none;
            }

            .premium-card:hover .card-glow {
                box-shadow: inset 0 0 0 1px rgba(255, 165, 0, 0.4);
            }

            /* Display de cantidad */
            .quantity-display {
                min-width: 5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid rgba(255, 165, 0, 0.3);
                border-radius: 1rem;
                background: rgba(30, 41, 59, 0.8);
                padding: 0.75rem 1.5rem;
                font-weight: 800;
                color: white;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .quantity-display.active {
                border-color: rgba(255, 165, 0, 0.8);
                background: rgba(255, 165, 0, 0.1);
                box-shadow: 0 0 20px rgba(255, 165, 0, 0.3);
            }

            .quantity-value {
                font-size: 1.5rem;
                font-weight: 900;
            }

            /* Slider premium */
            .premium-slider {
                padding: 1.5rem 0;
            }

            /* Resultado premium */
            .calculation-result-premium {
                position: relative;
                background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
                border: 1px solid rgba(255, 165, 0, 0.3);
                border-radius: 1.5rem;
                padding: 2rem;
                margin: 2rem;
                text-align: center;
                backdrop-filter: blur(10px);
                overflow: hidden;
            }

            .result-content {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.75rem;
                font-size: 1.75rem;
                font-weight: 800;
                position: relative;
                z-index: 2;
            }

            .result-number {
                color: white;
                background: rgba(255, 165, 0, 0.15);
                padding: 0.5rem 1rem;
                border-radius: 0.75rem;
                min-width: 4rem;
                text-align: center;
            }

            .result-label {
                color: #94a3b8;
                font-size: 1.5rem;
            }

            .result-operator {
                color: #f97316;
                font-size: 2rem;
            }

            .result-currency {
                color: #fbbf24;
            }

            .result-currency-total {
                color: #fbbf24;
                font-size: 2rem;
            }

            .result-total {
                color: #f97316;
                font-size: 2.5rem;
                text-shadow: 0 0 20px rgba(255, 100, 0, 0.5);
            }

            .result-glow {
                position: absolute;
                inset: 0;
                border-radius: 1.5rem;
                box-shadow: inset 0 0 0 1px rgba(255, 165, 0, 0.2);
                animation: pulseSlow 3s ease-in-out infinite;
            }

            /* Botón premium */
            .premium-button {
                position: relative;
                display: inline-flex;
                align-items: center;
                gap: 1rem;
                background: linear-gradient(135deg, #fbbf24, #f97316, #dc2626);
                border: none;
                border-radius: 3rem;
                padding: 1.25rem 3rem;
                color: white;
                font-weight: 900;
                font-size: 1.5rem;
                cursor: pointer;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                overflow: hidden;
                box-shadow:
                    0 10px 30px rgba(255, 100, 0, 0.4),
                    0 0 0 1px rgba(255, 255, 255, 0.1);
            }

            .premium-button:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow:
                    0 20px 40px rgba(255, 100, 0, 0.6),
                    0 0 0 1px rgba(255, 255, 255, 0.2);
            }

            .premium-button:active {
                transform: translateY(-1px) scale(1.02);
            }

            .button-icon {
                transition: transform 0.3s ease;
            }

            .premium-button:hover .button-icon {
                transform: translateX(5px) scale(1.1);
            }

            .button-shine {
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg,
                        transparent 30%,
                        rgba(255, 255, 255, 0.1) 50%,
                        transparent 70%);
                transform: rotate(45deg);
                animation: buttonShine 3s ease-in-out infinite;
            }

            /* Partículas animadas */
            .particles-container {
                position: absolute;
                width: 100%;
                height: 100%;
            }

            .particles-container::before,
            .particles-container::after {
                content: '';
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(255, 165, 0, 0.6);
                border-radius: 50%;
                animation: particlesFloat 8s ease-in-out infinite;
            }

            .particles-container::before {
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }

            .particles-container::after {
                top: 60%;
                right: 15%;
                animation-delay: -2s;
            }

            .particles-container .particle {
                position: absolute;
                width: 3px;
                height: 3px;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                animation: particlesFloat 10s ease-in-out infinite;
            }

            .particles-container .particle:nth-child(1) {
                top: 30%;
                left: 20%;
                animation-delay: -1s;
            }

            .particles-container .particle:nth-child(2) {
                top: 70%;
                left: 80%;
                animation-delay: -3s;
            }

            .particles-container .particle:nth-child(3) {
                top: 40%;
                left: 70%;
                animation-delay: -5s;
            }

            .particles-container .particle:nth-child(4) {
                top: 80%;
                left: 30%;
                animation-delay: -7s;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .premium-card {
                    padding: 1.5rem 1rem;
                }

                .result-content {
                    font-size: 1.25rem;
                    gap: 0.5rem;
                }

                .result-total {
                    font-size: 1.75rem;
                }

                .premium-button {
                    padding: 1rem 2rem;
                    font-size: 1.25rem;
                }
            }
        </style>

        <!-- AOS Library -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 1000,
                once: true,
                offset: 50
            });
        </script>

        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                    const img = card.querySelector('img');
                    if (!img) return;

                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        const rotateX = ((y - centerY) / centerY) * 3; // Incrementar movimiento
                        const rotateY = ((x - centerX) / centerX) * -4;

                        img.style.transform = `
                        perspective(1000px)
                        rotateX(${rotateX}deg)
                        rotateY(${rotateY}deg)
                        scale3d(1.05, 1.05, 1.05)
                    `;
                    });

                    card.addEventListener('mouseleave', () => {
                        img.style.transform = `
                        perspective(1000px)
                        rotateX(0deg)
                        rotateY(0deg)
                        scale3d(1, 1, 1)
                    `;
                    });
                });

                window.addEventListener('load', () => {
                    (function() {
                        const range = document.querySelector('#hs-pass-value-to-html-element');
                        const rangeInstance = new HSRangeSlider(range);
                        const target = document.querySelector('#hs-pass-value-to-html-element-target');

                        const cartas = document.querySelector('#cartasNum');
                        const precio = document.querySelector('#precio');
                        const resultado = document.querySelector('#resultado');
                        const categoria = document.querySelectorAll('.premium-card');
                        let suma = 0;

                        range.noUiSlider.on('update', (values) => {
                            const value = Math.round(values[0]);
                            target.innerText = rangeInstance.formattedValue;
                            cartas.innerText = rangeInstance.formattedValue;

                            if (cartas.innerText >= 1 && cartas.innerText < 10) {
                                precio.innerText = '450'
                                suma = target.innerText * 450;
                                categoria.forEach(el => {
                                    el.style.boxShadow = 'none';
                                    el.classList.remove('active');
                                });
                                const selectedIndex = 0; // index
                                const selectedCategory = categoria[selectedIndex];
                                selectedCategory.style.boxShadow = '0 0 15px oklch(0.705 0.213 47.604)';
                                selectedCategory.classList.add("active");
                            } else if (cartas.innerText >= 10 && cartas.innerText < 30) {
                                precio.innerText = '400'
                                suma = target.innerText * 400;
                                categoria.forEach(el => {
                                    el.style.boxShadow = 'none';
                                    el.classList.remove('active');
                                });
                                const selectedIndex = 1; // index
                                const selectedCategory = categoria[selectedIndex];
                                selectedCategory.style.boxShadow = '0 0 15px oklch(0.705 0.213 47.604)';
                                selectedCategory.classList.add("active");
                            } else if (cartas.innerText >= 30 && cartas.innerText < 50) {
                                precio.innerText = '350'
                                suma = target.innerText * 350;
                                categoria.forEach(el => {
                                    el.style.boxShadow = 'none';
                                    el.classList.remove('active');
                                });
                                const selectedIndex = 2; // index
                                const selectedCategory = categoria[selectedIndex];
                                selectedCategory.style.boxShadow = '0 0 15px oklch(0.705 0.213 47.604)';
                                selectedCategory.classList.add("active");
                            } else {
                                precio.innerText = '250'
                                suma = target.innerText * 250;
                                categoria.forEach(el => {
                                    el.style.boxShadow = 'none';
                                    el.classList.remove('active');
                                });
                                const selectedIndex = 3; // index
                                const selectedCategory = categoria[selectedIndex];
                                selectedCategory.style.boxShadow = '0 0 15px oklch(0.705 0.213 47.604)';
                                selectedCategory.classList.add("active");
                            }
                            resultado.innerText = suma.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        });

                        const categoryStarts = [1, 10, 30, 50];

                        categoria.forEach((cat, index) => {
                            cat.addEventListener('click', () => {
                                // Move slider to category start
                                range.noUiSlider.set(categoryStarts[index]);

                                // Remove previous highlights
                                categoria.forEach(el => el.style.boxShadow = 'none');

                                // Highlight selected
                                cat.style.boxShadow = '0 0 15px oklch(70.5% 0.213 47.604)';
                            });
                        });
                    })();

                    let currentPrice = document.querySelector('#precio');
                    let currentQuantity = document.querySelector('#cartasNum');

                    // Efecto hover mejorado para el botón
                    const premiumButton = document.querySelector('.premium-button');
                    if (premiumButton) {
                        premiumButton.addEventListener('click', function() {
                            this.style.transform = 'scale(0.95)';
                            setTimeout(() => {
                                this.style.transform = '';
                            }, 150);

                            // Aquí iría la lógica de envío del formulario
                            alert(
                                `¡Excelente elección! ${currentQuantity.innerText} cartas por $${(currentPrice.innerText * currentQuantity.innerText).toLocaleString()}`);
                        });
                    }
                });

            });


            const swiperPost = new Swiper('.swiper-card', {
                // Optional parameters
                loop: true,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 20,
                initialSlide: 0,
                autoplay: {
                    delay: 2500,
                    pauseOnMouseEnter: true
                },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 5,
                        centeredSlides: false,
                        spaceBetween: 16
                    }
                }
            });
        </script>

        <script>
            // Inicializar swiper para el slider de comparativas
            const swiperComparativas = new Swiper('.swiper-card', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 20,
                centeredSlides: true,
                autoplay: {
                    delay: 3000,
                    pauseOnMouseEnter: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        centeredSlides: false,
                    },
                    1024: {
                        slidesPerView: 3,
                        centeredSlides: false,
                    }
                }
            });
        </script>

        <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    @endsection
