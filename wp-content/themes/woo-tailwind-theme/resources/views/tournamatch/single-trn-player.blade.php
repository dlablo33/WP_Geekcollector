@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
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

        .trn-header-avatar {
            object-fit: cover;
        }

        @media (max-width: 540px) {

            /* Table Overflow */
            .trn-table.trn-table-striped.trn-player-team-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-ladder-competitions-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-tournament-competitions-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-match-history-table.dataTable.no-footer {
                width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                display: block !important;
                white-space: nowrap;
            }

            /* Apply flex to rows, including thead */
            .trn-player-team-table tr,
            .trn-ladder-competitions-table tr,
            .trn-tournament-competitions-table tr,
            .trn-match-history-table tr {
                display: flex !important;
                width: 100% !important;
                text-align: start !important;
                align-content: space-between !important;
            }

            /* Make headers and cells behave consistently */
            .trn-player-team-table th,
            .trn-player-team-table td,
            .trn-ladder-competitions-table th,
            .trn-ladder-competitions-table td,
            .trn-tournament-competitions-table th,
            .trn-tournament-competitions-table td,
            .trn-match-history-table th,
            .trn-match-history-table td {
                flex: 1 1 0 !important;
                min-width: 150px;
                padding: 0.5rem;
                box-sizing: border-box;
                overflow: visible !important;
                text-overflow: ellipsis;
                text-align: start;
            }

            /* Mostrar headers en mobile */
            .trn-player-team-table .trn-player-team-table-rank,
            .trn-player-team-table .trn-player-team-table-joined {
                display: block;
            }

            /* Mas espacio resultados */
            td.trn-match-history-result  {
                margin-inline-end: 5rem;9o0'
            }

            /* Icons de sort abajo */
            table.trn-table.dataTable thead .sorting::before {
                right: 4.5em !important;
                top: 0.5em !important;
            }

            /* Icons de sort arriba */
            table.trn-table.dataTable thead .sorting::after {
                right: 5em !important;
                top: 0.5em !important;
            }

            /* Borde superior de td (no cabe) */
            table.trn-table.dataTable td {
                border-top: 0;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
                margin-top: 10px;
            }

            .trn-profile-details {
                padding-block-start: 1rem;
            }
        }
    </style>

    @php
        $user_id = (int) get_query_var('id');
        $player = trn_get_player($user_id);
        $player = trn_the_player($player);
    @endphp
    <div class="mx-auto mt-10 max-w-7xl">
        <div class="trn-profile-header"<?php trn_competitor_header_banner_style($player->banner); ?>>
            <div class="trn-profile-avatar">
                {!! trn_display_avatar($player->user_id, 'players', $player->avatar, 'trn-header-avatar') !!}
            </div>
            <div class="trn-profile-details text-white font-semibold">
                <h1 class="trn-profile-name">{{ esc_html($player->name) }}</h1>
                @if (trn_is_plugin_active('trn-profile-social-icons'))
                    @php
                        $social_icons = trn_get_player_icon_fields();
                    @endphp
                    @if (is_array($social_icons) && 0 < count($social_icons))
                        <ul class="trn-list-inline">
                            @foreach ($social_icons as $icon => $data)
                                @php
                                    $key = 'psi_icon_' . $icon;
                                @endphp
                                @if (isset($player->$key) && 0 < strlen($player->$key))
                                    <li class="trn-list-inline-item">
                                        <a href="{{ esc_url($player->$key) }}" target="_blank">
                                            <i class="{{ esc_attr($data['icon']) }}"></i>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endif
                <span class="trn-profile-record">{!! do_shortcode('[trn-career-record competitor_type="players" competitor_id="' . intval($player->user_id) . '"]') !!}
                </span>
            </div>
            <div class="trn-profile-actions">
                @if (is_user_logged_in())
                    @if (get_current_user_id() === $user_id)
                        <a class="trn-button trn-button-sm"
                            href="{{ esc_url(trn_route('players.single.edit', ['id' => $user_id])) }}">{{ esc_html_e('Edit Profile', 'tournamatch') }}</a>
                    @else
                        {!! do_shortcode('[trn-invite-player-to-team user_id="' . intval($user_id) . '"]') !!}
                    @endif
                @endif
            </div>
            <ul class="trn-profile-list">
                <li class="trn-profile-list-item joined capitalize">
                    {{ esc_html(date_i18n(get_option('date_format'), strtotime(get_date_from_gmt(get_user_by('id', $user_id)->data->user_registered)))) }}
                </li>
                @if (0 < strlen($player->location))
                    <li class="trn-profile-list-item location">
                        {{ esc_html($player->location) }}
                    </li>
                @endif
            </ul>
        </div>
        <div class="px-4">
            <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 text-center shadow-lg">

                <div id="trn-send-invite-response"></div>
                <div class="trn-views">
                    @php
                        $views = [
                            'teams' => [
                                'heading' => __('Teams', 'tournamatch'),
                                'content' => function ($player) {
                                    echo '<div class="rounded-lg p-4 text-white shadow-lg">';
                                    echo do_shortcode('[trn-player-teams-list-table player_id="' . intval($player->user_id) . '"]');
                                    echo '</div>';
                                },
                            ],
                            'ladders' => [
                                'heading' => __('Ladders', 'tournamatch'),
                                'content' => function ($player) {
                                    echo '<div class="rounded-lg p-4 text-white shadow-lg">';
                                    echo do_shortcode('[trn-competitor-ladders-list-table competitor_type="players" competitor_id="' . intval($player->user_id) . '"]');
                                    echo '</div>';
                                },
                            ],
                            'tournaments' => [
                                'heading' => __('Tournaments', 'tournamatch'),
                                'content' => function ($player) {
                                    echo '<div class="rounded-lg p-4 text-white shadow-lg">';
                                    echo do_shortcode(
                                        '[trn-competitor-tournaments-list-table competitor_type="players" competitor_id="' . intval($player->user_id) . '"]',
                                    );
                                    echo '</div>';
                                },
                            ],
                            'matches' => [
                                'heading' => __('Match History', 'tournamatch'),
                                'content' => function ($player) {
                                    echo '<div class="rounded-lg p-4 text-white shadow-lg">';
                                    echo do_shortcode('[trn-competitor-match-list-table competitor_type="players" competitor_id="' . intval($player->user_id) . '"]');
                                    echo '</div>';
                                },
                            ],
                            // 'about' => [
                            //     'heading' => __('About', 'tournamatch'),
                            //     'content' => function ($player) {
                            //         echo '<div class="rounded-lg p-4 text-white shadow-lg">';
                            //         echo wp_kses_post($player->profile);
                            //         echo '</div>';
                            //     },
                            // ],
                        ];
                        $views = apply_filters('trn_single_player_views', $views, $player);
                        trn_single_template_tab_views($views, $player);
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
