@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-item-wrapper {
            background: #1a1a1a;
        }

        .trn-item-wrapper:hover {
            background: #ff7700 !important;
            color: #000 !important;
            transform: translateY(-2px) !important;
        }
    </style>
    @php

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $game_id = isset($_GET['game_id']) ? intval($_GET['game_id']) : null;

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $platform = isset($_GET['platform']) ? sanitize_text_field(wp_unslash($_GET['platform'])) : null;

        $ladders = trn_get_ladders($game_id, $platform);

    @endphp
    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl text-white">
        <div class="px-4 md:px-0">
            <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Ladders', 'tournamatch') }}</h1>
        </div>
        <div class="w-3/4 mx-auto md:w-full">
            <div class="trn-row" id="ladders">
                @foreach ($ladders as $ladder)
                    @php
                        $ladder = trn_the_ladder($ladder);
                    @endphp
                    <div class="trn-col-sm-6">
                        <div class="trn-item-wrapper" onclick="window.location.href = '<?php trn_esc_route_e('ladders.single', ['id' => $ladder->ladder_id]); ?>'">
                            <div class="trn-item-group">
                                <div class="trn-item-thumbnail">
                                    {!! trn_game_thumbnail($ladder) !!}
                                </div>
                                <div class="trn-item-info" style="float: left; margin-left: 10px">
                                    <span class="trn-item-title">{{ esc_html($ladder->name) }}</span>
                                </div>
                            </div>
                            <ul class="trn-item-list">
                                <li class="trn-item-list-item members">
                                    @php
                                        printf(
                                            esc_html(_n('%s Competitor', '%s Competitors', intval($ladder->competitors), 'tournamatch')),
                                            intval($ladder->competitors),
                                        );
                                    @endphp
                                </li>
                                <li class="trn-item-list-item ranking">
                                    {{ esc_html($ladder->ranking_mode_label) }}
                                </li>
                                <li class="trn-item-list-item competitor-type">
                                    @if ('players' === $ladder->competitor_type)
                                        {{ esc_html_e('Singles', 'tournamatch') }}
                                    @else
                                        @php
                                            printf(esc_html__('Teams (%1$d vs %1$d)', 'tournamatch'), intval($ladder->team_size));
                                        @endphp
                                    @endif
                                </li>
                                @if (trn_is_plugin_active('trn-mycred'))
                                    @if (0 < intval($ladder->mycred_entry_fee))
                                        <li class="trn-item-list-item entry-fee">
                                            {{ intval($ladder->mycred_entry_fee) }}
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
