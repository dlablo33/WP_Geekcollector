{{--
  Template Name: Torneos Template
--}}
@extends('layouts.app')
@section('content')
    <script src=" https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js "></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Hero Section mejorada */
        .hero-banner {
            position: relative;
            height: 40vh;
            min-height: 300px;
            overflow: hidden;
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

        /* Calendario mejorado - RESPONSIVE FIXED */
        .calendar-container {
            position: relative;
            background: #1a1a1a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin-bottom: 3rem;
            transition: all 0.3s ease;
        }

        .calendar-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .fc {
            --fc-border-color: #333;
            --fc-page-bg-color: #1a1a1a;
            --fc-neutral-bg-color: #1a1a1a;
            --fc-list-event-hover-bg-color: #2a2a2a;
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .fc .fc-col-header-cell-cushion {
            color: #f97316;
            font-weight: 500;
            padding: 8px 4px;
            text-decoration: none;
        }

        .fc .fc-daygrid-day-number {
            color: white;
            font-weight: 400;
            padding: 8px;
            text-decoration: none;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(249, 115, 22, 0.15);
        }

        .fc .fc-daygrid-day-frame {
            transition: background-color 0.2s ease;
        }

        .fc .fc-daygrid-day-frame:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Eventos del calendario mejorados - RESPONSIVE FIXED */
        .fc-event {
            border: none;
            background: transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .fc-event:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        .event-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            z-index: 100;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
            max-width: 200px;
            text-align: center;
        }

        .fc-event:hover .event-tooltip {
            opacity: 1;
            bottom: 100%;
            margin-bottom: 5px;
        }

        /* FIX PARA ICONOS RESPONSIVOS */
        .fc-event-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .fc-daygrid-event {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .fc-event-main {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .event-icon-container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 2px;
        }

        .event-icon {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            border-radius: 4px;
        }

        /* Ajustes específicos para diferentes tamaños de pantalla */
        @media (max-width: 768px) {
            .event-icon-container {
                max-width: 40px;
                max-height: 40px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.2rem;
            }

            .fc .fc-col-header-cell-cushion {
                font-size: 0.8rem;
                padding: 4px 2px;
            }

            .fc .fc-daygrid-day-number {
                font-size: 0.8rem;
                padding: 4px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .event-icon-container {
                max-width: 50px;
                max-height: 50px;
            }
        }

        @media (min-width: 1025px) {
            .event-icon-container {
                max-width: 60px;
                max-height: 60px;
            }
        }

        /* Rankings mejorados */
        .leaderboard-item {
            transition: all 0.3s ease;
            background: linear-gradient(to right, #1a1a1a, #2a2a2a);
            border: 1px solid #333;
        }

        .leaderboard-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-color: #f97316;
        }

        /* Tabs mejorados */
        .hs-tab-active\:bg-orange-500.hs-tab-active {
            background-color: #f97316 !important;
        }

        [role="tab"] {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        [role="tab"]::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: #f97316;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        [role="tab"]:hover::after,
        .hs-tab-active::after {
            width: 80%;
        }

        /* Top 3 cards mejoradas */
        .top-player-card {
            transition: all 0.3s ease;
            background: linear-gradient(to bottom, #1a1a1a, #2a2a2a);
            border: 1px solid #333;
            position: relative;
            overflow: hidden;
        }

        .top-player-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #f97316;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .top-player-card:hover::before {
            transform: scaleX(1);
        }

        .top-player-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .avatar {
            width: 64px;
            height: 64px;
            object-fit: cover;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        /* Scroll personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1a1a;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }

        /* Efectos de hover en stats */
        .stat-box {
            transition: all 0.3s ease;
            background: #1a1a1a;
            border: 1px solid #333;
        }

        .stat-box:hover {
            background: #2a2a2a;
            border-color: #f97316;
            transform: translateY(-3px);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .top-players-container {
                flex-direction: column;
            }

            .top-player-card {
                margin-bottom: 1rem;
            }

            [role="tab"] {
                font-size: 0.875rem;
                padding: 0.75rem 0.5rem;
            }

            .fc .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <!-- Hero Section Mejorada -->
    <div class="-mt-2 overflow-hidden bg-black">
        <div class="hero-banner relative my-2 mb-10 aspect-[3/3] w-full overflow-hidden sm:aspect-[16/7] md:aspect-[16/6]">
            <img src="{{ asset('/resources/images/torneos3.png') }}" class="absolute h-full w-full object-cover object-center" alt="Banner principal" />
            <div class="absolute bottom-0 left-0 z-10 w-full p-6">
                <h1 class="mb-2 text-4xl font-bold text-white">Torneos</h1>
                <p class="text-xl text-orange-200">Compite y demuestra tu habilidad en nuestros eventos</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-2 py-4 sm:px-4">

        <!-- Calendario Mejorado -->
        <div class="calendar-container animate-fade-in">
            <div id="calendar" class="p-4 capitalize text-white md:p-6">
            </div>
        </div>

        <!-- Rankings Mejorados -->
        <div class="mb-10 grid grid-cols-1 gap-6 px-2 md:px-6 lg:grid-cols-3">
            <div class="col-span-1 px-4 py-2 md:col-span-1">
                <div class="mb-4 flex items-center text-2xl font-semibold text-orange-500">
                    <i class="fas fa-trophy mr-2 text-yellow-500"></i> Leaderboard
                </div>
                @php
                    $players = [
                        ['name' => 'Emma Johnson', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Liam Williams', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Olivia Brown', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Noah Jones', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Ava Garcia', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'William Miller', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Sophia Davis', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'James Rodriguez', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Isabella Martinez', 'nivel' => '0', 'pts' => '0'],
                        ['name' => 'Oliver Hernandez', 'nivel' => '0', 'pts' => '0'],
                    ];
                    $i = 1;
                @endphp
                <div class="custom-scrollbar max-h-[405px] overflow-y-auto">
                    @foreach ($players as $player)
                        @php
                            $user_id = 2;
                        @endphp
                        <div class="animate-fade-in delay-{{ ($i - 1) * 100 }} px-2 py-2">
                            <div class="leaderboard-item flex items-center justify-between rounded-lg p-3">
                                <div class="flex items-center gap-3">
                                    {!! get_avatar($user_id, 40, '', '', ['class' => 'w-10 h-10 rounded-full']) !!}
                                    <div>
                                        <p class="font-semibold text-white">{{ $player['name'] }}</p>
                                        <p class="text-xs text-gray-400">Nivel {{ $player['nivel'] }} </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-green-400">#{{ $i }}</p>
                                    <p class="text-xs text-gray-400"> {{ $player['pts'] }} pts</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            </div>

            <div class="col-span-2 mt-6 text-white lg:mt-0">
                <div class="py-2 pl-0 md:pl-8">
                    <div class="mb-4 flex items-center text-2xl font-semibold text-orange-500">
                        <i class="fas fa-chess-knight mr-2"></i> Categorías
                    </div>

                    <div class="overflow-hidden rounded-t-lg border-b border-gray-700">
                        <nav class="flex flex-col justify-between md:flex-row" aria-label="Tabs" role="tablist">
                            <button type="button"
                                class="active hs-tab-active:bg-orange-500 hs-tab-active:text-white w-full cursor-pointer bg-black py-3 text-lg font-semibold text-white"
                                id="tabs-item-1" aria-selected="false" data-hs-tab="#tabs-1" aria-controls="tabs-1" role="tab">
                                One Piece
                            </button>

                            <button type="button" class="w-full cursor-pointer bg-black py-3 text-lg font-semibold text-white" id="tabs-item-2" aria-selected="false"
                                data-hs-tab="#tabs-2" aria-controls="tabs-2" role="tab">
                                Pokemon
                            </button>
                            <button type="button" class="w-full cursor-pointer bg-black py-3 text-lg font-semibold text-white" id="tabs-item-3" aria-selected="false"
                                data-hs-tab="#tabs-3" aria-controls="tabs-3" role="tab">
                                Magic The Gathering
                            </button>

                            <button type="button" class="w-full cursor-pointer bg-black py-3 text-lg font-semibold text-white" id="tabs-item-4" aria-selected="false"
                                data-hs-tab="#tabs-4" aria-controls="tabs-4" role="tab">
                                Lorcana
                            </button>

                            <button type="button" class="w-full cursor-pointer bg-black py-3 text-lg font-semibold text-white" id="tabs-item-5" aria-selected="false"
                                data-hs-tab="#tabs-5" aria-controls="tabs-5" role="tab">
                                Star Wars
                            </button>
                        </nav>
                    </div>

                    @php
                        $tcgs = [['OnePiece' => 2], ['Pokemon' => 5], ['Magic' => 3], ['Lorcana' => 4], ['StarWars' => 1]];
                        $keys = array_reduce(
                            $tcgs,
                            function ($carry, $item) {
                                return array_merge($carry, array_keys($item));
                            },
                            [],
                        );

                        global $wpdb;
                        $ladder_id = 1;
                        $ladders_entries = $wpdb->prefix . 'trn_ladders_entries';
                        $tournaments_entries = $wpdb->prefix . 'trn_tournaments_entries';

                        foreach ($tcgs as $tcg) {
                            $ladder_id = current($tcg);
                            $tcg_name = key($tcg);

                            $rankings = $wpdb->get_results(
                                $wpdb->prepare(
                                    "
                                    SELECT competitor_id, points, wins
                                    FROM $ladders_entries
                                    WHERE ladder_id = %d
                                    ORDER BY points DESC
                                    LIMIT 3
                                    ",
                                    $ladder_id,
                                ),
                            );

                            $rank = $wpdb->get_col(
                                $wpdb->prepare(
                                    "
                                    SELECT competitor_id
                                    FROM $ladders_entries
                                    WHERE ladder_id = %d
                                    ORDER BY points DESC
                                    ",
                                    $ladder_id,
                                ),
                            );

                            $top[$tcg_name] = [];
                            foreach ($rankings as $ranking) {
                                $top[$tcg_name][] = [
                                    'user_id' => get_userdata($ranking->competitor_id),
                                    'name' => get_userdata($ranking->competitor_id)->display_name,
                                    'rank' => array_search($ranking->competitor_id, $rank) + 1,
                                    'pts' => $ranking->points,
                                    'torneos' => intval(
                                        $wpdb->get_var(
                                            $wpdb->prepare(
                                                "
                                                SELECT COUNT(DISTINCT tournament_id)
                                                FROM $tournaments_entries
                                                WHERE competitor_id = %d
                                                ",
                                                $ranking->competitor_id,
                                            ),
                                        ),
                                    ),
                                    'wins' => $ranking->wins,
                                ];
                            }
                        }

                        $i = 1;
                    @endphp

                    @foreach ($top as $tcg => $players)
                        <div class="mt-3">
                            <div id="tabs-{{ $i }}" class="{{ $i === 1 ? ' ' : 'hidden' }}" role="tabpanel" aria-labelledby="tabs-item-{{ $i }}">
                                <div class="mb-4 flex items-center justify-center gap-2 text-center text-2xl text-orange-400">
                                    <i class="fa-solid fa-medal text-yellow-500"></i>Top 3
                                </div>

                                <div class="max-h-380 px-3">
                                    <div class="top-players-container flex flex-col justify-between gap-4 text-white md:flex-row">
                                        @foreach ($players as $index => $player)
                                            <div class="top-player-card animate-fade-in delay-{{ $index * 100 }} flex h-full w-full flex-col items-center rounded-lg p-4">
                                                <div class="mb-3 grid min-w-full grid-cols-2 items-center">
                                                    <div class="flex justify-center">
                                                        {!! get_avatar($player['user_id']->ID, 64, '', '', ['class' => 'w-16 h-16 rounded-full border-2 border-orange-500']) !!}
                                                    </div>
                                                    <div class="flex justify-center text-center">
                                                        <div class="font-semibold leading-tight text-white">{{ $player['name'] }}</div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-3 text-center">
                                                    <div class="stat-box rounded-xl p-3">
                                                        <p class="text-2xl font-bold text-orange-500 md:text-3xl">{{ $player['rank'] }}</p>
                                                        <p class="mt-1 text-xs text-gray-300">Ranking Actual</p>
                                                    </div>
                                                    <div class="stat-box rounded-xl p-3">
                                                        <p class="text-2xl font-bold text-orange-500 md:text-3xl">{{ $player['pts'] }}</p>
                                                        <p class="mt-1 text-xs text-gray-300">Puntos Totales</p>
                                                    </div>
                                                    <div class="stat-box rounded-xl p-3">
                                                        <p class="text-2xl font-bold text-orange-500 md:text-3xl">{{ $player['torneos'] }}</p>
                                                        <p class="mt-1 text-xs text-gray-300">Torneos Jugados</p>
                                                    </div>
                                                    <div class="stat-box rounded-xl p-3">
                                                        <p class="text-2xl font-bold text-orange-500 md:text-3xl">{{ $player['wins'] }}</p>
                                                        <p class="mt-1 text-xs text-gray-300">Victorias Totales</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mapa Mejorado -->
        <section class="animate-fade-in mt-10 flex flex-col items-start justify-center overflow-hidden rounded-xl bg-black text-white shadow-xl lg:flex-row">
            <div class="py-30 flex h-auto w-full md:mx-10 md:px-20 lg:w-[45%]">
                <ul class="flex w-full flex-col items-start justify-start">
                    <li class="w-full font-bold">
                        <div class="flex w-full flex-row items-center">
                            <div class="mb-2 flex flex-col justify-center py-3">
                                <h2 class="text-4xl text-orange-500">Encuéntranos</h2>
                                <p class="mt-1 text-gray-300">Ven y únete a la comunidad</p>
                            </div>
                        </div>
                    </li>

                    <li class="w-full font-bold">
                        <div class="flex w-full flex-row items-center transition-colors duration-300 hover:text-orange-400">
                            <div class="mx-3 my-auto">
                                <img class="h-10 w-10" src="{{ get_template_directory_uri() . '/resources/images/nosotros/llamar.png' }}" alt="Ícono de Teléfono">
                            </div>
                            <div class="flex flex-col items-start justify-center py-3">
                                <h2 class="text-sm text-gray-400">TELÉFONO:</h2>
                                <p class="text-lg md:text-xl">+52 81 2080 2420</p>
                            </div>
                        </div>
                        <div class="h-[1px] w-full bg-gray-800"></div>
                    </li>
                    <li class="w-full font-bold">
                        <div class="flex w-full flex-row items-center transition-colors duration-300 hover:text-orange-400">
                            <div class="mx-3 my-auto">
                                <img class="h-10 w-10" src="{{ get_template_directory_uri() . '/resources/images/nosotros/localizacion.png' }}" alt="Ícono de Ubicación">
                            </div>
                            <div class="flex flex-col items-start justify-center py-3">
                                <h2 class="text-sm text-gray-400">UBICACIÓN:</h2>
                                <p class="text-lg md:text-xl">AVE. ALFONSO REYES 255</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="h-80 w-full lg:h-96 lg:w-[55%]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3596.8868565144835!2d-100.27947329999999!3d25.641880399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662bf99d30c3957%3A0x3492755f898822d6!2sAv.%20Alfonso%20Reyes%20255%2C%20Contry%2C%2064860%20Monterrey%2C%20N.L.!5e0!3m2!1ses-419!2smx!4v1755549626022!5m2!1ses-419!2smx"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    class="rounded-r-xl"></iframe>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            var calendarEl = document.getElementById('calendar');

            const response = await fetch('/wp-content/themes/woo-tailwind-theme/public/events/calendar.json');
            const events = await response.json();

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: 'prev,next today'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'short'
                },
                events: events,
                dayCellDidMount: function(arg) {
                    const cell = arg.el;
                    cell.classList.add('transition-colors', 'duration-200');
                },

                eventContent: function(arg) {
                    const event = arg.event;
                    const imageurl = event.extendedProps.imageurl;
                    const title = event.title;
                    const tipo = event.extendedProps.tipo;
                    console.log(tipo);
                    const container = document.createElement('div');
                    container.className = 'fc-event-container';

                    if (imageurl) {
                        const iconContainer = document.createElement('div');
                        iconContainer.className = 'event-icon-container';

                        const img = document.createElement('img');
                        img.src = imageurl;
                        img.className = 'event-icon';
                        img.alt = title;
                        img.title = title;

                        iconContainer.appendChild(img);
                        container.appendChild(iconContainer);
                    }

                    return {
                        domNodes: [container]
                    };
                },

                eventDidMount: function(arg) {
                    // Añadir tooltip con información del evento
                    const element = arg.el;
                    const event = arg.event;

                    element.setAttribute('data-bs-toggle', 'tooltip');
                    element.setAttribute('data-bs-placement', 'top');
                    element.setAttribute('title', event.title);
                },

            });

            calendar.render();

            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>

    <script>
        // Tabs bg
        const tabs = document.querySelectorAll('[role="tab"]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Poner todos los tabs bg-black
                tabs.forEach(t => t.classList.remove('bg-orange-500'));
                tabs.forEach(t => t.classList.add('bg-black'));

                // Poner bg a tab seleccionado
                tab.classList.add('bg-orange-500');
                tab.classList.remove('bg-black');
            });
        });

        // Primer tab seleccionado
        if (tabs.length > 0) {
            tabs[0].classList.add('bg-orange-500');
            tabs[0].classList.remove('bg-black');

        }

        // Animación de elementos al hacer scroll
        function checkScroll() {
            const elements = document.querySelectorAll('.animate-fade-in');

            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;

                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Ejecutar al cargar y al hacer scroll
        window.addEventListener('load', checkScroll);
        window.addEventListener('scroll', checkScroll);
    </script>
@endsection
