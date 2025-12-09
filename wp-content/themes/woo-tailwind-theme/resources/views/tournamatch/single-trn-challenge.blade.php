@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    @php

        $challenge_id = get_query_var('id');

        $challenge = trn_get_challenge($challenge_id);

        if (is_null($challenge)) {
            wp_safe_redirect(trn_route('challenges.archive'));
            exit();
        }

        if ('direct' === $challenge->challenge_type || 'accepted' === $challenge->accepted_state) {
            $challenge->can_see_challenger = true;
        } elseif ('players' === $challenge->competitor_type) {
            $challenge->can_see_challenger = absint($challenge->challenger_id) === get_current_user_id();
        } else {
            $teams = array_column(trn_get_user_teams(get_current_user_id()), 'id');
            $challenge->can_see_challenger = in_array($challenge->challenger_id, $teams, true);
        }
    @endphp

    <div class="mx-auto mb-2 mt-10 flex min-h-[70vh] flex-col justify-center px-6 text-white md:w-1/2">
        <div>
            <div class="mb-5 text-center text-4xl">{{ esc_html_e('Challenge', 'tournamatch') }}</div>

            <div class="flex flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
                <div class="mb-2 flex justify-center gap-3">
                    <div>{{ esc_html_e('Ladder', 'tournamatch') }}:</div>
                    <div>{{ esc_html($challenge->ladder_name) }}</div>
                </div>
                <div class="mb-2 flex flex-col justify-center text-center md:flex-row md:gap-3">

                    <div>{{ esc_html_e('Match Time', 'tournamatch') }}:</div>
                    <div>
                        <span class="capitalize">{{ esc_html(date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($challenge->match_time)))) }}</span>
                        {{ esc_html(date_i18n(get_option('time_format'), strtotime(get_date_from_gmt($challenge->match_time)))) }}
                    </div>
                </div>
                <div class="mb-2 flex justify-center gap-3">
                    <div>{{ esc_html_e('Challenger', 'tournamatch') }}:</div>
                    <div id="trn-challenge-challenger">
                        @if ($challenge->can_see_challenger)
                            {{ esc_html($challenge->challenger_name) }}
                        @else
                            {{ esc_html_e('(hidden)', 'tournamatch') }}
                        @endif
                    </div>
                </div>
                <div class="mb-2 flex justify-center gap-3">

                    <div>{{ esc_html_e('Challengee', 'tournamatch') }}:</div>
                    <div id="trn-challenge-challengee">
                        @if (is_null($challenge->challengee_id))
                            {{ esc_html_e('(open)', 'tournamatch') }}
                        @else
                            {{ esc_html($challenge->challengee_name) }}
                        @endif
                    </div>
                </div>
                @if (trn_is_plugin_active('trn-mycred'))
                    <div class="mb-2 flex justify-center gap-3">
                        <div>{{ esc_html_e('Wager', 'tournamatch') }}:</div>
                        <div>{{ printf(esc_html__('%d Tokens', 'tournamatch'), intval($challenge->mycred_wager_amount)) }}</div>
                    </div>
                @endif
                <div class="mb-2 mb-5 flex justify-center gap-3">
                    <div>{{ esc_html_e('Status', 'tournamatch') }}:</div>
                    <div id="trn-challenge-status">{{ esc_html(trn_get_localized_challenge_state($challenge->accepted_state)) }}</div>
                </div>

                <div id="trn-challenge-success-response"></div>
                <div id="trn-challenge-failure-response"></div>
                <div class="trn-text-center">
                    @if (trn_can_accept_challenge(get_current_user_id(), $challenge->challenge_id))
                        {!! do_shortcode('[trn-accept-challenge-button id="' . intval($challenge->challenge_id) . '"]') !!}
                    @endif
                    @if (trn_can_decline_challenge(get_current_user_id(), $challenge->challenge_id))
                        {!! do_shortcode('[trn-decline-challenge-button id="' . intval($challenge->challenge_id) . '"]') !!}
                    @endif
                    @if (trn_can_delete_challenge(get_current_user_id(), $challenge->challenge_id))
                        {!! do_shortcode('[trn-delete-challenge-button id="' . intval($challenge->challenge_id) . '"]') !!}
                    @endif
                </div>
                @php
                    $options = [
                        'api_url' => site_url('wp-json/tournamatch/v1/'),
                        'rest_nonce' => wp_create_nonce('wp_rest'),
                        'challenge_list_link' => trn_route('challenges.archive'),
                        'language' => [
                            'failure' => esc_html__('Error', 'tournamatch'),
                            'success' => esc_html__('Success', 'tournamatch'),
                            'accepted' => esc_html__('Accepted', 'tournamatch'),
                            'acceptedMessage' => esc_html__('The challenge was accepted.', 'tournamatch'),
                            'declined' => esc_html__('Declined', 'tournamatch'),
                            'declinedMessage' => esc_html__('The challenge was declined.', 'tournamatch'),
                        ],
                    ];
                    wp_register_script('trn_single_challenge', plugins_url('/tournamatch/dist/js/single-challenge.js'), ['tournamatch'], '3.27.0', true);
                    wp_localize_script('trn_single_challenge', 'trn_single_challenge_options', $options);
                    wp_enqueue_script('trn_single_challenge');
                @endphp
            </div>
        </div>
    </div>
@endsection
