@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-item-wrapper {
            background: #1a1a1a;
        }

        .trn-item-wrapper:hover,
        .trn-item-wrapper.active {
            background: #ff7700;
            color: #000;
            transform: translateY(-2px);
        }
    </style>
    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl text-white">
        @php
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $game_id = isset($_GET['game_id']) ? intval($_GET['game_id']) : null;
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $platform = isset($_GET['platform']) ? sanitize_text_field(wp_unslash($_GET['platform'])) : null;
            $image_directory = trn_upload_url() . '/images';
            $tournaments = trn_get_tournaments($game_id, $platform);
            $is_admin = current_user_can('manage_tournamatch');
            $my_tournaments = [];
            if (is_user_logged_in()) {
                $my_tournaments = array_column(trn_get_user_tournaments(get_current_user_id()), 'tournament_id');
            }
        @endphp

        <div class="px-4 md:px-0">
            <div class="mb-10">
                <h1 class="trn-mb-4 text-4xl">
                    {{ esc_html_e('Tournaments', 'tournamatch') }}
                </h1>
            </div>
            <!-- Tab navigation -->
            <div class="mb-10">
                <ul class="trn-nav trn-mb-sm flex-column flex-sm-row tournament-filter">
                    <li role="presentation" class="trn-nav-item flex-sm" aria-controls="all" data-filter="all">
                        <a class="trn-nav-link trn-nav-active" href="#">
                            <span>{{ esc_html_e('All', 'tournamatch') }}</span>
                        </a>
                    </li>
                    <li role="presentation" class="trn-nav-item flex-sm" aria-controls="upcoming" data-filter="upcoming">
                        <a class="trn-nav-link" href="#">
                            <span>{{ esc_html_e('Upcoming', 'tournamatch') }}</span>
                        </a>
                    </li>
                    <li role="presentation" class="trn-nav-item flex-sm" aria-controls="in_progress" data-filter="in_progress">
                        <a class="trn-nav-link" href="#">
                            <span>{{ esc_html_e('In Progress', 'tournamatch') }}</span>
                        </a>
                    </li>
                    <li role="presentation" class="trn-nav-item flex-sm" aria-controls="complete" data-filter="complete">
                        <a class="trn-nav-link" href="#">
                            <span>{{ esc_html_e('Finished', 'tournamatch') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="w-3/4 mx-auto md:w-full">
            <div class="trn-row">
                @foreach ($tournaments as $tournament)
                    @php
                        $tournament->id = $tournament->tournament_id;
                        if (in_array($tournament->status, ['created', 'open'], true)) {
                            $filter = 'upcoming';
                        } else {
                            $filter = $tournament->status;
                        }
                        // Can current user sign up?
                        $can_register = false;
                        if (is_user_logged_in()) {
                            if (!in_array((string) $tournament->tournament_id, $my_tournaments, true) && in_array($tournament->status, ['open'], true)) {
                                $can_register = intval($tournament->bracket_size) === 0 || $tournament->competitors < $tournament->bracket_size;
                            }
                        }
                    @endphp
                    <div class="trn-col-sm-6 tournament" data-filter="{{ esc_html($filter) }}" id="trn-tournament-{{ intval($tournament->id) }}-details">
                        <div class="trn-item-wrapper" onclick="window.location.href = '{{ trn_esc_route_e('tournaments.single', ['id' => intval($tournament->id)]) }}'">
                            <div class="trn-item-group">
                                <div class="trn-item-thumbnail">
                                    {!! trn_game_thumbnail($tournament) !!}
                                </div>
                                <div class="trn-item-info">
                                    <span class="trn-item-title">{{ esc_html($tournament->name) }}</span>
                                    <span
                                        class="trn-item-meta capitalize">{{ esc_html(date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($tournament->start_date)))) }}</span>
                                    <span
                                        class="trn-item-meta">{{ esc_html(date_i18n(get_option('time_format'), strtotime(get_date_from_gmt($tournament->start_date)))) }}</span>
                                </div>
                            </div>
                            <ul class="trn-item-list">
                                <li class="trn-item-list-item members">
                                    {{ intval($tournament->competitors) }}/{{ $tournament->bracket_size > 0 ? intval($tournament->bracket_size) : '&infin;' }}
                                </li>
                                <li class="trn-item-list-item info">
                                    {{ esc_html(trn_get_localized_tournament_status($tournament->status)) }}
                                </li>
                                <li class="trn-item-list-item competitor-type">
                                    @if ('players' === $tournament->competitor_type)
                                        {{ esc_html_e('Singles', 'tournamatch') }}
                                    @else
                                        {{ printf(esc_html__('Teams (%1$d vs %1$d)', 'tournamatch'), intval($tournament->team_size)) }}
                                    @endif
                                </li>
                                @if (trn_is_plugin_active('trn-mycred'))
                                    @if (0 < intval($tournament->mycred_entry_fee))
                                        <li class="trn-item-list-item entry-fee">
                                            {{ intval($tournament->mycred_entry_fee) }}
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            @php
                wp_register_script('tournaments', plugins_url('/tournamatch/dist/js/tournaments.js'), [], '3.25.0', true);
                wp_enqueue_script('tournaments');
            @endphp
        </div>
    </div>
@endsection
