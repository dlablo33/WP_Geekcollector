@extends('layouts.app')

@section('content')
    <style>
        /* Fix tournament title */
        .trn-col-sm-3 {
            max-width: 100% !important;
        }
    </style>
    @include('partials.trn-menu')
    @php
        $tournament_id = get_query_var('id');

        $tournament = trn_get_tournament($tournament_id);
        if (is_null($tournament)) {
            wp_safe_redirect(trn_route('tournaments.archive'));
            exit();
        }

        $one_competitor_per_tournament_rule = new \Tournamatch\Rules\One_Competitor_Per_Tournament($tournament->tournament_id, get_current_user_id());
        $can_register = $one_competitor_per_tournament_rule->passes();

        $competitor_type = $tournament->competitor_type;
        if ('teams' === $tournament->competitor_type) {
            $teams = trn_get_user_owned_teams(get_current_user_id());
        }

    @endphp

    <div class="mx-auto mt-10 flex min-h-[50vh] md:min-h-[70vh] items-center justify-center text-white">
        <div>
            <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Register', 'tournamatch') }}</h1>
            <div class="flex min-h-[30vh] w-full min-w-[40vh] md:min-w-[50vh] flex-col items-center justify-center rounded-lg bg-[#1a1a1a] p-6 !text-center shadow-lg">

                @if (!$can_register)
                    <div class="trn-alert trn-alert-info">
                        {{ esc_html_e('You have already registered for this tournament.', 'tournamatch') }}
                    </div>
                @else
                    <div id="trn-tournament-join-response"></div>
                    <form id="trn-tournament-join-form" class="form-horizontal" action="#" method="post">
                        <div class="trn-form-group flex flex-col items-center gap-2">
                            <div><label class="trn-col-sm-3 text-2xl font-semibold" for="tournament_id">{{ esc_html_e('Tournament', 'tournamatch') }}:</label></div>
                            <div class="trn-col-sm-3 text-3xl font-bold">
                                <div class="trn-form-control-static">{{ esc_html($tournament->name) }}</div>
                                <input type="hidden" name="tournament_id" id="tournament_id" value="{{ intval($tournament->tournament_id) }}">
                            </div>
                        </div>
                        @if (trn_is_plugin_active('trn-mycred'))
                            @if (0 < intval($tournament->mycred_entry_fee))
                                <div class="trn-form-group">
                                    <label class="trn-col-sm-3" for="mycred_entry_fee">{{ esc_html_e('Entry Fee', 'tournamatch') }}:</label>
                                    <div class="trn-col-sm-4">
                                        <div class="trn-form-control-static">
                                            @php
                                                printf(esc_html__('%d Tokens', 'tournamatch'), intval($tournament->mycred_entry_fee));
                                            @endphp
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- Equipos -->
                        @if ('teams' === $tournament->competitor_type)
                            <div class="trn-form-group">
                                <label class="trn-col-sm-3" for="competitor_id">{{ esc_html_e('Team', 'tournamatch') }}:</label>
                                @if (0 < count($teams))
                                    <div class="trn-col-sm-4">
                                        <select id="competitor_id" name="competitor_id" class="trn-form-control">
                                            @foreach ($teams as $team)
                                                <option value="{{ intval($team->team_id) }}">{{ esc_html($team->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="trn-col-sm-12">
                                        <div>
                                            {{ esc_html_e('This is a teams tournament and you do not currently own any teams.', 'tournamatch') }}
                                            @php
                                                printf(
                                                    esc_html__('You may create one %1$shere%2$s.', 'tournamatch'),
                                                    '<a href="' . esc_url(trn_route('teams.single.create')) . '">',
                                                    '</a>',
                                                );
                                            @endphp
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <!-- Reglas -->
                        @if (0 < strlen($tournament->rules))
                            <div class="trn-form-group">
                                <label for="rules" class="trn-col-sm-3">{{ esc_html_e('Rules', 'tournamatch') }}:</label>
                                <div class="trn-col-sm-12">
                                    <div>{!! wp_kses_post($tournament->rules) !!}</div>
                                </div>
                            </div>
                        @endif
                        <!-- Boton -->
                        <div class="trn-form-group flex items-center justify-center">
                            <div class="trn-col-sm-offset-3">
                                @if ('players' === $tournament->competitor_type)
                                    <input type="hidden" name="competitor_id" id="competitor_id" value="{{ intval(get_current_user_id()) }}">
                                @endif
                                <input type="hidden" name="competitor_type" id="competitor_type" value="{{ esc_html($competitor_type) }}">
                                <input type="submit" class="trn-button" id="trn-register-button" value="{{ esc_html_e('Register', 'tournamatch') }}"
                                    {{ isset($teams) && 0 === count($teams) ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </form>
                @endif
                @php
                    $options = [
                        'api_url' => site_url('wp-json/tournamatch/v1/'),
                        'rest_nonce' => wp_create_nonce('wp_rest'),
                        'redirect_link' => trn_route('tournaments.single.registered', ['id' => $tournament_id]),
                        'language' => [
                            'success' => esc_html__('Success', 'tournamatch'),
                            'failure' => esc_html__('Error', 'tournamatch'),
                            'petition' => esc_html__('Your request has been recorded. You will be registered after an admin approves your request.', 'tournamatch'),
                        ],
                    ];
                    wp_register_script('trn-tournament-register', plugins_url('/tournamatch/dist/js/tournament-register.js'), ['tournamatch'], '3.28.0', true);
                    wp_localize_script('trn-tournament-register', 'trn_tournament_register_options', $options);
                    wp_enqueue_script('trn-tournament-register');
                @endphp
            </div>

        </div>
    </div>
@endsection
