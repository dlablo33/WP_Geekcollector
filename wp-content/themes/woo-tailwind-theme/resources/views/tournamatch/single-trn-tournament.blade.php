@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    @php
        $tournament_id = get_query_var('id');
        $image_directory = trn_upload_url() . '/images';

        global $wpdb;

        $tournament = trn_get_tournament($tournament_id);

        if (is_null($tournament)) {
            wp_safe_redirect(trn_route('tournaments.archive'));
            exit();
        }

        $my_tournaments = array_column(trn_get_user_tournaments(get_current_user_id()), 'tournament_id');
        $register_conditions = trn_get_tournament_register_conditions($tournament->tournament_id, get_current_user_id());
        $competitors = trn_get_tournament_competitors($tournament_id);
        $registered = trn_get_registered_competitors($tournament_id);
    @endphp

    <style>
        /* Estilos personalizados para el tema oscuro con acentos naranjas */
        .trn-competition-header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), var(--trn-header-bg);
            background-size: cover;
            background-position: center;
            color: white;
            border-bottom: 3px solid #ff7700;
            box-shadow: 0 5px 15px rgba(255, 119, 0, 0.3);
            transition: all 0.3s ease;
        }

        .trn-competition-header:hover {
            box-shadow: 0 8px 25px rgba(255, 119, 0, 0.5);
            transform: translateY(-2px);
        }

        .trn-competition-name {
            font-size: 2.5rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            color: #fff;
            transition: all 0.3s ease;
        }

        .trn-competition-game {
            font-size: 1.2rem;
            color: #ff7700;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .trn-competition-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            padding: 1.5rem 0;
        }

        .trn-competition-list-item {
            background: rgba(30, 30, 30, 0.8);
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            border-left: 3px solid #ff7700;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #e0e0e0;
        }

        .trn-competition-list-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(255, 119, 0, 0.3);
            background: rgba(40, 40, 40, 0.9);
        }

        .trn-competition-list-item:before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 12px;
            /* background: #ff7700; */
            border-radius: 50%;
            margin-right: 8px;
        }

        /* .trn-competition-list-item.joined:before {
            background-color: #4CAF50;
        }

        .trn-competition-list-item.members:before {
            background: #2196F3;
        }

        .trn-competition-list-item.info:before {
            background: #ff7700;
        }

        .trn-competition-list-item.format:before {
            background: #9C27B0;
        }

        .trn-competition-list-item.competitor-type:before {
            background: #FF9800;
        }

        .trn-competition-list-item.entry-fee:before {
            background: #E91E63;
        } */
        /* Estilos para las pestañas */
        .trn-views {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border: 1px solid #333;
            overflow-x: auto;
        }

        .trn-tab-content .trn-tab-pane#brackets.trn-tab-active {
            width: fit-content;
        }

        .trn-nav-tabs {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 2px solid #333;
            margin-bottom: 2rem;
            gap: 0.5rem;
        }

        .trn-nav-link {
            padding: 1rem 1.5rem;
            background: #252525;
            color: #ccc;
            border-radius: 6px 6px 0 0;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid #333;
            border-bottom: none;
        }

        .trn-nav-link:hover,
        .trn-nav-link.active {
            background: #ff7700;
            color: #000;
            transform: translateY(-2px);
        }

        /* Estilos para la sección de registrados */
        .trn-tournament-registered-item {
            background: linear-gradient(145deg, #252525, #1e1e1e);
            border: 1px solid #333;
            border-radius: 10px;
            padding: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            animation: fadeIn 0.5s ease-out;
        }

        .trn-tournament-registered-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 119, 0, 0.25);
            border-color: #ff7700;
        }

        .trn-tournament-registered-item-avatar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #ff7700;
            box-shadow: 0 0 10px rgba(255, 119, 0, 0.5);
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .trn-tournament-registered-item:hover .trn-tournament-registered-item-avatar img {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(255, 119, 0, 0.7);
        }

        .trn-tournament-registered-item a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .trn-tournament-registered-item a:hover {
            color: #ff7700;
            text-shadow: 0 0 8px rgba(255, 119, 0, 0.5);
        }

      

        /* Estilos mejorados para los brackets */
        .trn-brackets-container {
            background: #1a1a1a;
            border-radius: 12px;
            padding: 2rem;
            margin-top: 1rem;
        }

        .bracket-match {
            background: linear-gradient(145deg, #252525, #1e1e1e);
            border: 1px solid #333;
            border-radius: 8px;
            padding: 1rem;
            margin: 0.5rem 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bracket-match:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(255, 119, 0, 0.25);
            border-color: #ff7700;
        }

        .bracket-match.winner {
            background: linear-gradient(145deg, #2d5016, #223d10);
            border-color: #4CAF50;
        }

        .bracket-player {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            margin: 0.25rem 0;
            border-radius: 4px;
            background: rgba(40, 40, 40, 0.6);
            transition: all 0.2s ease;
        }

        .bracket-player:hover {
            background: rgba(50, 50, 50, 0.8);
        }

        .bracket-player.winner {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            font-weight: bold;
        }

        .bracket-vs {
            text-align: center;
            margin: 0.5rem 0;
            color: #ff7700;
            font-weight: bold;
            font-size: 1.1rem;
        }

        #trn-tournament-matches-table_wrapper {
            min-width: 100% !important;
        }

        /* Contenedor Principal */
        .trn-brackets-container {
            width: 100%;
            overflow: visible;
            margin-bottom: 1rem;
        }

        /* Subcontenedor del principal */
        .trn-brackets {
            max-width: 100%;
            overflow: visible;
        }

        /* Header de rondas */
        .trn-brackets-round-header-container {
            display: flex;
            justify-content: space-between;
            gap: 5rem;
            padding: 0 3rem;
            width: max-content;
            min-width: 100%;
        }

        /* Rondas en header */
        .trn-brackets-round-header {
            flex: 1 0 200px;
            text-align: center;
            padding-block: 5px;
            background-color: oklch(70.5% 0.213 47.604);
        }

        /* Linea divisora de bajo de header */
        .trn-brackets-progress {
            min-width: 100%;
        }

        /* Contenedor de bracket */
        .trn-brackets-round-body-container {
            display: flex;
            max-width: 100%;
            align-items: center;
        }

        /* Subcontenedor de bracket */
        .trn-brackets-round-body {
            width: !important auto;
            position: static;
            z-index: 1;
        }

        /* Lineas en bracket */
        .trn-brackets-vertical-line,
        .trn-brackets-horizontal-line,
        .trn-brackets-top-half,
        .trn-brackets-bottom-half,
        .trn-brackets-winners-line {
            filter: invert(1);
        }

        /* Match container en bracket */
        .trn-brackets-match {}

        /* Contenido de match */
        .trn-brackets-match-body {
            margin: 2rem 4rem 2rem 4rem;
            padding: 0.5rem 15px 0.5rem 15px;
        }

        /* Competidor dentro de match */
        .trn-brackets-competitor {
            padding: 3px 15px 3px 15px;
            border-radius: 0 0 5px 5px
        }

        /* Hover de competidor */
        .trn-brackets-competitor-highlight {
            background-color: #6b6b6b;
        }

        .trn-brackets-round-body {
            padding: 2rem;
            width: 100%;
        }

        .trn-brackets-dropdown-content {
            left: auto !important;
            z-index: 9999;
            transform: translate(0, 0);
            transition: transform 0.2s ease;
        }

        .trn-brackets-dropdown:hover .trn-brackets-dropdown-content {
            display: block;
            transform: translate(-100%, -50%);
        }

        .bracket-round {
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(30, 30, 30, 0.7);
            border-radius: 8px;
            border-left: 4px solid #ff7700;
        }

        .bracket-round-title {
            color: #ff7700;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #333;
            padding-bottom: 0.5rem;
        }

        .bracket-connector {
            position: relative;
            height: 40px;
            margin: 0.5rem 0;
            border-left: 2px solid #ff7700;
            margin-left: 50%;
        }

        .bracket-connector:before {
            content: '';
            position: absolute;
            top: 50%;
            left: -2px;
            width: 20px;
            height: 2px;
            background: #ff7700;
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

        @keyframes highlight {
            0% {
                background-color: rgba(255, 119, 0, 0.1);
            }

            50% {
                background-color: rgba(255, 119, 0, 0.3);
            }

            100% {
                background-color: rgba(255, 119, 0, 0.1);
            }
        }

        .highlight-animation {
            animation: highlight 2s ease;
        }

        /* Estilos para el contenido de reglas */
        .trn-rules-content {
            background: #1e1e1e;
            padding: 2rem;
            border-radius: 10px;
            border-left: 4px solid #ff7700;
            color: #e0e0e0;
            line-height: 1.6;
        }

        .trn-rules-content p {
            margin-bottom: 1rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .trn-brackets-container {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {

            /* Numero de items */
            .dataTables_length {
                display: none !important;
            }

            .trn-competition-list {
                flex-direction: column;
                align-items: center;
            }

            .trn-competition-list-item {
                width: 100%;
                max-width: 300px;
            }

            .trn-nav-tabs {
                flex-direction: column;
            }

            .trn-tournament-registered-item {
                flex-direction: column;
                text-align: center;
            }

            .trn-brackets-container {
                padding: 1rem;
            }

            .trn-brackets-round-header-container {
                width: 100%;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .trn-brackets-container {
                padding: 1rem;
            }
        }
    </style>

    <div class="trn-competition-header w-full" {!! trn_header_banner_style($tournament->banner_id, $tournament->game_id) !!}>
        <div class="trn-competition-details">
            <h1 class="trn-competition-name">{{ esc_html($tournament->name) }}</h1>
            <span class="trn-competition-game">{{ esc_html($tournament->game_name) }}</span>
        </div>

        <ul class="trn-competition-list">
            <div class="flex gap-2">
                <li class="trn-competition-list-item joined">
                    <span class="capitalize">{{ esc_html(date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($tournament->start_date)))) }}</span>
                    {{ esc_html(date_i18n(get_option('time_format'), strtotime(get_date_from_gmt($tournament->start_date)))) }}
                </li>
            </div>
            <li class="trn-competition-list-item members">
                {{ intval($tournament->competitors) }}/{{ $tournament->bracket_size > 0 ? intval($tournament->bracket_size) : '∞' }}
            </li>
            <li class="trn-competition-list-item info">
                {{ esc_html(trn_get_localized_tournament_status($tournament->status)) }}
            </li>
            <li class="trn-competition-list-item format">
                {{ __('Single Elimination', 'tournamatch') }}
            </li>
            <li class="trn-competition-list-item competitor-type">
                @if ($tournament->competitor_type === 'players')
                    {{ __('Singles', 'tournamatch') }}
                @else
                    {{ sprintf(__('Teams (%1$d vs %1$d)', 'tournamatch'), intval($tournament->team_size)) }}
                @endif
            </li>
            @if (trn_is_plugin_active('trn-mycred'))
                <li class="trn-competition-list-item entry-fee">
                    {{ intval($tournament->mycred_entry_fee) }}
                </li>
            @endif
        </ul>
    </div>

    {{-- Tabs de vistas --}}
    <div class="trn-views mt-6">
        <?php
            // Definir las vistas básicas primero
            $views = [
                'rules' => [
                    'heading' => __('Rules', 'tournamatch'),
                    'content' => function ($tournament) {
                        if (strlen($tournament->rules) > 0) {
                            echo '<div class="trn-rules-content">';
                            echo wp_kses_post(stripslashes($tournament->rules));
                            echo '</div>';
                        } else {
                            echo '<div class="text-center py-8"><div class="text-gray-500 text-lg">'.esc_html__('No rules to display.', 'tournamatch').'</div></div>';
                        }
                    },
                ],
                'matches' => [
                    'heading' => __('Matches', 'tournamatch'),
                    'content' => function($tournament) {
                        echo '<div class="text-white rounded-lg p-4 shadow-lg">';
                        echo do_shortcode('[trn-tournament-matches-list-table tournament_id="'.intval($tournament->tournament_id).'"]');
                        echo '</div>';
                    },
                ],
                'registered' => [
                    'heading' => __('Registered', 'tournamatch'),
                    'content' => function ($tournament) use ($registered) {
                        ?>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3" id="trn-tournament-registered">
            <?php foreach ($registered as $competitor): ?>
            <div class="trn-tournament-registered-item">
                <div class="trn-tournament-registered-item-avatar">
                    <?php trn_display_avatar($competitor->competitor_id, $competitor->competitor_type, $competitor->avatar); ?>
                </div>
                <div class="flex-grow">
                    <a href="<?php trn_esc_route_e("{$competitor->competitor_type}.single", ['id' => $competitor->competitor_id]); ?>" class="font-medium text-gray-800 hover:text-indigo-600">
                        <?php echo esc_html($competitor->competitor_name); ?>
                    </a>
                    <?php if ('teams' === $tournament->competitor_type): ?>
                    <div class="mt-1 text-sm text-orange-400"><?php echo intval($competitor->members); ?>/<?php echo intval($tournament->team_size); ?> members</div>
                    <?php endif; ?>
                </div>
                <?php if (current_user_can('manage_tournamatch') && in_array($tournament->status, ['created', 'open'], true)): ?>
                <a class="text-red-500 transition-colors hover:text-red-700" href="<?php trn_esc_route_e('admin.tournaments.remove-entry', [
                    'tournament_entry_id' => $competitor->tournament_entry_id,
                    '_wpnonce' => wp_create_nonce('tournamatch-remove-tournament-entry'),
                ]); ?>">
                    <i class="fa fa-times-circle text-xl"></i>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
                    },
                ],
            ];

            // Agregar pestañas adicionales según condiciones
            if (in_array($tournament->status, ['in_progress', 'complete'], true)) {
                $views = array_merge([
                    'brackets' => [
                        'heading' => __('Brackets', 'tournamatch'),
                        'content' => function($tournament) {
                            echo '<div class="trn-brackets-container">';
                            echo do_shortcode('[trn-brackets tournament_id="' . intval($tournament->tournament_id) . '"]');
                            echo '</div>';
                        },
                    ],
                ], $views);
            }

            if (($tournament->status === 'in_progress') && in_array((int) $tournament->tournament_id, $my_tournaments, true)) {
                $views['report'] = [
                    'heading' => __('Report', 'tournamatch'),
                    'href' => trn_route('report.page'),
                ];
            }

            if ($register_conditions['can_register']) {
                $views['register'] = [
                    'heading' => __('Sign Up', 'tournamatch'),
                    'href' => trn_route('tournaments.single.register', ['id' => $tournament->tournament_id]),
                ];
            }

            if ($register_conditions['can_unregister']) {
                $views['unregister'] = [
                    'heading' => function() use ($register_conditions, $tournament) {
                        ?>
        <a class="trn-nav-link trn-tournament-unregister-button bg-red-600 hover:bg-red-700" href="#" data-tournament-registration-id="<?php echo intval($register_conditions['id']); ?>"
            id="tournament-<?php echo intval($tournament->tournament_id); ?>-unregister-link">
            <i class="fa fa-user-times mr-2"></i><?php esc_html_e('Unregister', 'tournamatch'); ?>
        </a>
        <?php
                    },
                ];

                $options = [
                    'api_url' => site_url('wp-json/tournamatch/v1/'),
                    'rest_nonce' => wp_create_nonce('wp_rest'),
                    'refresh_url' => trn_route('tournaments.single.registered', ['id' => $tournament->tournament_id]),
                    'language' => [
                        'failure' => esc_html__('Error', 'tournamatch'),
                        'success' => esc_html__('Success', 'tournamatch'),
                        'failure_message' => esc_html__('Unable to unregister from this tournament at this time.', 'tournamatch'),
                    ],
                ];

                wp_register_script('tournament-unregister', plugins_url('/tournamatch/dist/js/tournament-unregister.js'), ['tournamatch'], '3.24.0', true);
                wp_localize_script('tournament-unregister', 'trn_tournament_unregister_options', $options);
                wp_enqueue_script('tournament-unregister');
            }

            // Aplicar filtros de WordPress al final
            $views = apply_filters('trn_single_tournament_views', $views, $tournament);
        ?>

        {!! trn_single_template_tab_views($views, $tournament) !!}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación para los elementos al cargar la página
            const items = document.querySelectorAll('.trn-competition-list-item, .trn-tournament-registered-item');
            items.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
            });

            // Efecto hover mejorado para las pestañas
            const tabs = document.querySelectorAll('.trn-nav-link');
            tabs.forEach(tab => {
                tab.addEventListener('mouseenter', () => {
                    tab.style.transform = 'translateY(-3px)';
                    tab.style.boxShadow = '0 5px 15px rgba(255, 119, 0, 0.4)';
                });
                tab.addEventListener('mouseleave', () => {
                    if (!tab.classList.contains('active')) {
                        tab.style.transform = 'translateY(0)';
                        tab.style.boxShadow = 'none';
                    }
                });
            });

            // Mejorar la visualización de los brackets
            setTimeout(function() {
                const bracketMatches = document.querySelectorAll('.bracket-game');
                if (bracketMatches.length > 0) {
                    bracketMatches.forEach(match => {
                        match.classList.add('bracket-match');

                        // Encontrar y mejorar jugadores
                        const competitors = match.querySelectorAll('.competitor');
                        competitors.forEach((competitor, index) => {
                            competitor.classList.add('bracket-player');

                            // Detectar ganadores
                            if (competitor.classList.contains('winner')) {
                                competitor.classList.add('winner');
                            }

                            // Añadir separador VS entre jugadores
                            if (index === 0 && competitors.length > 1) {
                                const vsDiv = document.createElement('div');
                                vsDiv.className = 'bracket-vs';
                                vsDiv.textContent = 'VS';
                                competitor.parentNode.insertBefore(vsDiv, competitor.nextSibling);
                            }
                        });
                    });

                    // Agrupar por rondas
                    const rounds = document.querySelectorAll('.round');
                    rounds.forEach(round => {
                        round.classList.add('bracket-round');

                        // Añadir título a la ronda
                        const roundTitle = round.querySelector('h3') || round.querySelector('h4') || round.querySelector('.round-title');
                        if (!roundTitle) {
                            const title = document.createElement('div');
                            title.className = 'bracket-round-title';
                            title.textContent = 'Round ' + (document.querySelectorAll('.round').length > 0 ?
                                Array.from(document.querySelectorAll('.round')).indexOf(round) + 1 : '');
                            round.insertBefore(title, round.firstChild);
                        } else {
                            roundTitle.classList.add('bracket-round-title');
                        }
                    });
                }
            }, 500);
        });
    </script>
@endsection
