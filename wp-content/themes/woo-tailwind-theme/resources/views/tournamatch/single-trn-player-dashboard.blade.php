@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-card,
        .trn-card-header,
        .trn-card-body {
            background: #1a1a1a;
            color: white;
            border-color: white;
        }

        .trn-button:hover,
        .trn-button-group>.trn-button:not(:last-child):not(.trn-dropdown-toggle):hover,
        .trn-button-group>.trn-button:not(:first-child):hover {
            background: #ff7700;
            color: #000;
            transform: translateY(-2px);
        }

        @media (max-width: 767px) {
            .trn-button:not(:disabled):not(.trn-disabled) {
                padding: 10px 10px;
            }
        }
    </style>
    <div class="mx-auto max-w-7xl px-6">
        @php
            if (!is_user_logged_in()) {
                wp_safe_redirect(wp_login_url(trn_route('players.single.dashboard')));
                exit();
            }
            $user_id = get_current_user_id();
        @endphp

        <div class="mb-2">
            <h1 class="trn-mt-4 text-4xl text-white">{{ esc_html_e('Dashboard', 'tournamatch') }}</h1>
        </div>

        <div class="trn-row trn-mb-3">
            <div class="trn-col-sm-12 flex gap-2">
                <a class="trn-button" href="{{ trn_esc_route_e('report.page') }}">
                    {{ esc_html_e('Results', 'tournamatch') }}
                </a>
                <a class="trn-button" href="{{ trn_esc_route_e('teams.single.create') }}">
                    {{ esc_html_e('Create Team', 'tournamatch') }}
                </a>
                <div class="trn-button-group">
                    <a type="button" class="trn-button" href="{{ trn_esc_route_e('players.single', ['id' => $user_id]) }}">{{ esc_html_e('My Profile', 'tournamatch') }}</a>
                    <button type="button" class="trn-button trn-dropdown-toggle trn-dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">{{ esc_html_e('Toggle Dropdown', 'tournamatch') }}</span>
                    </button>
                    <div class="trn-dropdown-menu dropdown-menu-right">
                        <a class="trn-dropdown-item"
                            href="{{ trn_esc_route_e('players.single.edit', ['id' => $user_id]) }}">{{ esc_html_e('Edit My Profile', 'tournamatch') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="trn-row trn-mb-3">
            <div class="trn-col-sm-6">
                <div class="trn-card">
                    <div class="trn-card-header trn-text-center text-white">
                        {{ esc_html_e('Team Invitations Received', 'tournamatch') }}
                    </div>
                    <div class="trn-card-body">
                        {!! do_shortcode('[trn-my-team-invitations-list]') !!}
                    </div>
                </div>
            </div>
            <div class="trn-col-sm-6">
                <div class="trn-card">
                    <div class="trn-card-header trn-text-center">
                        {{ esc_html_e('Team Requests Sent', 'tournamatch') }}
                    </div>
                    <div class="trn-card-body">
                        {!! do_shortcode('[trn-my-team-requests-list]') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="trn-row trn-mb-3">
            <div class="trn-col-sm-12">
                <div class="trn-card">
                    <div class="trn-card-header trn-text-center">
                        {{ esc_html_e('My Challenges', 'tournamatch') }}
                    </div>
                    @php
                        $challenges = trn_get_user_challenges(get_current_user_id());
                    @endphp
                    @if (0 === count($challenges))
                        <div class="trn-card-body">
                            <p class="trn-text-center">{{ esc_html_e('No challenges to display.', 'tournamatch') }}
                            </p>
                        </div>
                    @else
                        <table class="trn-card-body trn-table trn-table-striped trn-challenges-table overflow-scroll" id="trn-my-challenges-table">
                            <thead>
                                <tr>
                                    <th class="trn-challenges-table-ladder">{{ esc_html_e('Ladder', 'tournamatch') }}</th>
                                    <th class="trn-challenges-table-challenger">{{ esc_html_e('Challenger', 'tournamatch') }}</th>
                                    <th class="trn-challenges-table-challengee">{{ esc_html_e('Challengee', 'tournamatch') }}</th>
                                    <th class="trn-challenges-table-match-time">{{ esc_html_e('Match Time', 'tournamatch') }}</th>
                                    <th class="trn-challenges-table-status">{{ esc_html_e('Status', 'tournamatch') }}</th>
                                    <th class="trn-challenges-table-action"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- display list of scheduled matches needing to be reported -->
                                @foreach ($challenges as $challenge)
                                    <tr data-challenge-id="{{ intval($challenge->challenge_id) }}" class="text-center">
                                        <td class="trn-challenges-table-ladder">
                                            <a href="{{ esc_url(trn_route('ladders.single.standings', ['id' => $challenge->ladder_id])) }}">
                                                {{ esc_html($challenge->ladder_name) }}
                                            </a>
                                        </td>
                                        <td class="trn-challenges-table-challenger">
                                            <a
                                                href="{{ esc_url(trn_route($challenge->competitor_slug, [$challenge->competitor_slug_argument => $challenge->challenger_id])) }}">
                                                {{ esc_html($challenge->challenger_name) }}
                                            </a>
                                        </td>
                                        <td class="trn-challenges-table-challengee">
                                            @if ('blind' === $challenge->challenge_type && is_null($challenge->challengee_id))
                                                {{ esc_html_e('(open)', 'tournamatch') }}
                                            @else
                                                <a
                                                    href="{{ esc_url(trn_route($challenge->competitor_slug, [$challenge->competitor_slug_argument => $challenge->challengee_id])) }}">
                                                    {{ esc_html($challenge->challengee_name) }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="trn-challenges-table-match-time">
                                            {{ esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime(get_date_from_gmt($challenge->match_time)))) }}
                                        </td>
                                        <td class="trn-challenges-table-status">
                                            {{ esc_html(trn_get_localized_challenge_state($challenge->accepted_state)) }}
                                        </td>
                                        <td class="trn-challenges-table-action">
                                            <div class="trn-pull-right">
                                                <a class="trn-button trn-button-sm" href="{{ trn_esc_route_e('challenges.single', ['id' => $challenge->challenge_id]) }}">
                                                    <i class="fa fa-info"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="trn-row">
            <div class="trn-col-sm-12">
                <div class="trn-card">
                    <div class="trn-card-header trn-text-center">
                        {{ esc_html_e('My Competitions', 'tournamatch') }}
                    </div>
                    @php
                        $competitions = trn_get_user_competitions(get_current_user_id());
                    @endphp

                    @if (0 === count($competitions))
                        <div class="trn-card-body">
                            <p class="trn-text-center">{{ esc_html_e('You are not currently competing in any events.', 'tournamatch') }}</p>
                        </div>
                    @else
                        <table class="trn-card-body trn-table trn-table-striped trn-my-competitions-table" id="trn-my-competitions-table">
                            <thead>
                                <tr>
                                    <th class="trn-my-competitions-table-event">{{ esc_html_e('Event', 'tournamatch') }}</th>
                                    <th class="trn-my-competitions-table-name">{{ esc_html_e('Name', 'tournamatch') }}</th>
                                    <th class="trn-my-competitions-table-game">{{ esc_html_e('Game', 'tournamatch') }}</th>
                                    <th class="trn-my-competitions-table-action"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- display list of scheduled matches needing to be reported -->
                                @foreach ($competitions as $competition)
                                    <tr data-competition-type="{{ esc_html($competition->competition_type) }}" data-competition-id="{{ intval($competition->id) }}">
                                        <td class="trn-my-competitions-table-event">
                                            {{ esc_html(trn_get_localized_competition_type($competition->competition_type, true)) }}
                                        </td>
                                        <td class="trn-my-competitions-table-name">
                                            <a href="{{ trn_esc_route_e($competition->route_name, ['id' => $competition->id]) }}">
                                                {{ esc_html($competition->name) }}
                                            </a>
                                        </td>
                                        <td class="trn-my-competitions-table-game">
                                            {{ esc_html($competition->game_name) }}
                                        </td>
                                        <td class="trn-my-competitions-table-action">
                                            @if ('ladder' === $competition->competition_type)
                                                <div class="trn-pull-right">
                                                    <a class="trn-button trn-button-sm"
                                                        href="{{ trn_esc_route_e('matches.single.create', ['ladder_id' => $competition->id]) }}">{{ esc_html_e('Report', 'tournamatch') }}</a>
                                                    <a class="trn-button trn-button-sm"
                                                        href="{{ trn_esc_route_e('ladders.single.standings', ['id' => $competition->id]) }}">{{ esc_html_e('Standings', 'tournamatch') }}</a>
                                                </div>
                                            @else
                                                @if (in_array($competition->status, ['in_progress', 'complete'], true))
                                                    <div class="trn-pull-right">
                                                        <a class="trn-button trn-button-sm"
                                                            href="{{ trn_esc_route_e('tournaments.single.brackets', ['id' => $competition->id]) }}">{{ esc_html_e('Brackets', 'tournamatch') }}</a>
                                                    </div>
                                                @else
                                                    <div class="trn-pull-right">
                                                        <a class="trn-button trn-button-sm"
                                                            href="{{ trn_esc_route_e('tournaments.single.rules', ['id' => $competition->id]) }}">{{ esc_html_e('Rules', 'tournamatch') }}</a>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
