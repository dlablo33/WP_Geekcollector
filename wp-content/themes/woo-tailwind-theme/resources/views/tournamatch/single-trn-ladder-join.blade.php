@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    @php
        $ladder_id = get_query_var('id');

        if (!is_user_logged_in()) {
            wp_safe_redirect(wp_login_url(trn_route('ladders.single.join', ['id' => $ladder_id])));
            exit();
        }

        $ladder = trn_get_ladder($ladder_id);

        if (is_null($ladder)) {
            wp_safe_redirect(trn_route('ladders.archive'));
            exit();
        }

        $one_competitor_per_ladder_rule = new \Tournamatch\Rules\One_Competitor_Per_Ladder($ladder->ladder_id, get_current_user_id());
        $can_join = $one_competitor_per_ladder_rule->passes();

        $competitor_type = $ladder->competitor_type;
        if ('teams' === $ladder->competitor_type) {
            $teams = trn_get_user_owned_teams(get_current_user_id());
        }

    @endphp

    <div class="ml-auto mt-10 flex min-h-[70vh] items-center justify-center text-white">
        <div>
            <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Join Ladder', 'tournamatch') }}</h1>
            @if (!$can_join)
                <div class="trn-alert trn-alert-info">
                    {{ esc_html_e('You are already participating on this ladder.', 'tournamatch') }}
                </div>
            @else
                <div id="trn-ladder-join-response"></div>
                <form id="trn-ladder-join-form" class="form-horizontal" action="#" method="post">
                    <div class="trn-form-group">
                        <label class="trn-col-sm-3" for="ladder_id">{{ esc_html_e('Ladder', 'tournamatch') }}:</label>
                        <div class="trn-col-sm-4">
                            <div class="trn-form-control-static">{{ esc_html($ladder->name) }}</div>
                            <input type="hidden" name="ladder_id" id="ladder_id" value="{{ intval($ladder->ladder_id) }}">
                        </div>
                    </div>
                    @if (trn_is_plugin_active('trn-mycred'))
                        @if (0 < intval($ladder->mycred_entry_fee))
                            <div class="trn-form-group">
                                <label class="trn-col-sm-3" for="mycred_entry_fee">{{ esc_html_e('Entry Fee', 'tournamatch') }}:</label>
                                <div class="trn-col-sm-4">
                                    <div class="trn-form-control-static">
                                        @php
                                            printf(esc_html__('%d Tokens', 'tournamatch'), intval($ladder->mycred_entry_fee));
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ('teams' === $ladder->competitor_type)
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
                                        {{ esc_html_e('This is a teams ladder and you do not currently own any teams.', 'tournamatch') }}
                                        {{ printf(esc_html__('You may create one %1$shere%2$s.', 'tournamatch'), '<a href="' . esc_url(trn_route('teams.single.create')) . '">', '</a>') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if (0 < strlen($ladder->rules))
                        <div class="trn-form-group">
                            <label for="rules" class="trn-col-sm-3"> {{ esc_html_e('Rules', 'tournamatch') }}:</label>
                            <div class="trn-col-sm-6">
                                <div>
                                    {{ wp_kses_post($ladder->rules) }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="trn-form-group">
                        <div class="trn-col-sm-offset-3 trn-col-sm-9">
                            @if ('players' === $ladder->competitor_type)
                                <input type="hidden" name="competitor_id" id="competitor_id" value="{{ intval(get_current_user_id()) }}">
                            @endif
                            <input type="hidden" name="competitor_type" id="competitor_type" value="{{ esc_html($competitor_type) }}">
                            <input type="submit" class="trn-button" id="trn-join-button" value="{{ esc_html_e('Join', 'tournamatch') }}"
                                {{ isset($teams) && 0 === count($teams) ? 'disabled' : '' }}>
                        </div>
                    </div>
                </form>
            @endif
            @php
                $options = [
                    'api_url' => site_url('wp-json/tournamatch/v1/'),
                    'rest_nonce' => wp_create_nonce('wp_rest'),
                    'redirect_link' => trn_route('ladders.single.standings', ['id' => $ladder_id]),
                    'language' => [
                        'success' => esc_html__('Success', 'tournamatch'),
                        'failure' => esc_html__('Error', 'tournamatch'),
                        'petition' => esc_html__('Your request has been recorded. You will appear on the ladder after an admin approves your request.', 'tournamatch'),
                    ],
                ];
                wp_register_script('trn-ladder-join', plugins_url('/tournamatch/dist/js/ladder-join.js'), ['tournamatch'], '3.28.0', true);
                wp_localize_script('trn-ladder-join', 'trn_ladder_join_options', $options);
                wp_enqueue_script('trn-ladder-join');
            @endphp
        </div>
    </div>
@endsection
