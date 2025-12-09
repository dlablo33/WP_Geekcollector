@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-confirm-results-table {
            margin-top: 10px;
        }

        td {
            text-align: center;
        }

        .trn-table.trn-table-striped.trn-scheduled-matches-table,
        .trn-report-results-table {
            margin-top: 20px;
        }

        select.trn-form-control {
            margin-top: 10px;
        }
    </style>
    @php

        // Add backwards compatibility for old email match confirmation URLs (3.x and <= 4.3.4).
        if ('confirm_e_results' === get_query_var('mode')) {
            wp_safe_redirect(trn_route('magic.match-confirm-result', ['reference_id' => get_query_var('mrf')]));
            exit();
        }

        if (!is_user_logged_in()) {
            wp_safe_redirect(wp_login_url(trn_route('report.page')));
            exit();
        }

        $user_id = get_current_user_id();
        $can_confirm_matches = get_can_confirm_matches($user_id);
        $reported_matches = get_reported_matches($user_id);

    @endphp

    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl px-6 text-white">
        <div class="px-4 md:px-0">
            <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Results Dashboard', 'tournamatch') }}</h1>
        </div>
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 text-center shadow-lg">
            <div>
                <section class="mb-5">
                    <h4 class="trn-text-center">{{ esc_html_e('Confirm Results', 'tournamatch') }}</h4>
                    <div id="trn-dispute-match-response">
                        @if (isset($_GET['dispute_match_id']))
                            <div class="trn-alert trn-alert-success"><strong>{{ esc_html_e('Success', 'tournamatch') }}
                                    :</strong> {{ esc_html_e('The match dispute has been logged and an admin notified.', 'tournamatch') }}
                            </div>
                        @endif
                    </div>

                    @if (isset($_GET['confirmed_match']))
                        <div id="trn-confirm-match-response">
                            <div class="trn-alert trn-alert-success">
                                <strong>{{ esc_html_e('Success', 'tournamatch') }}:</strong>
                                {{ esc_html_e('The match has been confirmed.', 'tournamatch') }}
                            </div>
                        </div>
                    @endif

                    @if (0 < count($can_confirm_matches))
                        <div>
                            @php
                                printf(
                                    esc_html(
                                        _n(
                                            'You have %d match waiting for your confirmation.',
                                            'You have %d matches waiting for your confirmation.',
                                            count($can_confirm_matches),
                                            'tournamatch',
                                        ),
                                    ),
                                    count($can_confirm_matches),
                                );
                            @endphp
                        </div>
                        <table class="trn-table trn-table-striped trn-confirm-results-table" id="confirm-results-list">
                            <tr>
                                <th class="trn-confirm-results-table-event">{{ esc_html_e('Event', 'tournamatch') }}</th>
                                <th class="trn-confirm-results-table-name">{{ esc_html_e('Name', 'tournamatch') }}</th>
                                <th class="trn-confirm-results-table-result">{{ esc_html_e('Information', 'tournamatch') }}</th>
                                <th class="trn-confirm-results-table-action">&nbsp;</th>
                            </tr>
                            @foreach ($can_confirm_matches as $match)
                                <tr>
                                    <td class="trn-confirm-results-table-event">{{ esc_html(trn_get_localized_competition_type($match->competition_type)) }}</td>
                                    <td class="trn-confirm-results-table-name">
                                        <a href="{{ trn_esc_route_e("{$match->competition_type}.single", ['id' => $match->competition_id]) }}">
                                            {{ esc_html($match->name) }}
                                        </a>
                                    </td>
                                    <td class="trn-confirm-results-table-result">
                                        @php
                                            $match_date = date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($match->match_date)));

                                            $opponent = 0 < strlen($match->one_result) ? 'one_competitor_name' : 'two_competitor_name';

                                            if ('players' === $match->competitor_type) {
                                                if ('won' === $match->one_result || 'won' === $match->two_result) {
                                                    /* translators: First is opponent; second is date and time. */
                                                    printf(
                                                        esc_html__('%1$s reported that you lost on %2$s', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                } elseif ('draw' === $match->one_result || 'draw' === $match->two_result) {
                                                    /* translators: First is opponent; second is date and time. */
                                                    printf(
                                                        esc_html__('%1$s reported a draw against you on %2$s', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                } else {
                                                    /* translators: First is opponent; second is date and time. */
                                                    printf(
                                                        esc_html__('%1$s reported that you won on %2$s', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                }
                                            } elseif ('won' === $match->one_result || 'won' === $match->two_result) {
                                                /* translators: First is opponent; second is date and time. */
                                                printf(
                                                    esc_html__('Team %1$s reported that your team lost on %2$s', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            } elseif ('draw' === $match->one_result || 'draw' === $match->two_result) {
                                                /* translators: First is opponent; second is date and time. */
                                                printf(
                                                    esc_html__('Team %1$s reported a draw against your team on %2$s', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            } else {
                                                /* translators: First is opponent; second is date and time. */
                                                printf(
                                                    esc_html__('Team %1$s reported that your team won on %2$s', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            }
                                        @endphp
                                    </td>
                                    <td class="action-link-cell trn-confirm-results-table-action">
                                        <a class="trn-button trn-button-sm trn-button-success"
                                            href="{{ trn_esc_route_e('matches.single.confirm', ['id' => $match->match_id]) }}">
                                            {{ esc_html_e('Confirm', 'tournamatch') }}
                                        </a>
                                        &nbsp;
                                        {!! do_shortcode('[trn-dispute-match-button id="' . intval($match->match_id) . '"]') !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div class='trn-text-center'>
                            {{ esc_html_e('There are no results waiting for your confirmation.', 'tournamatch') }}
                        </div>
                    @endif
                </section>

                <section class="mb-5">
                    <h4 class='trn-text-center'>{{ esc_html_e('Your Reported Results', 'tournamatch') }}</h4>
                    @if (0 < count($reported_matches))
                        <div><?php printf(esc_html(_n('You are waiting on %d match to be confirmed.', 'You are waiting on %d matches to be confirmed.', count($reported_matches), 'tournamatch')), count($reported_matches)); ?></div>
                        <table class="trn-table trn-table-striped trn-report-results-table" id="reported-results-list">
                            <tr>
                                <th class="trn-report-results-table-event">{{ esc_html_e('Event', 'tournamatch') }} </th>
                                <th class="trn-report-results-table-name">{{ esc_html_e('Name', 'tournamatch') }} </th>
                                <th class="trn-report-results-table-result">{{ esc_html_e('Information', 'tournamatch') }} </th>
                                <th class="trn-report-results-table-action">{{ esc_html_e('Details', 'tournamatch') }} </th>
                            </tr>
                            @foreach ($reported_matches as $match)
                                <tr>
                                    <td class="trn-report-results-table-event">{{ esc_html(trn_get_localized_competition_type($match->competition_type)) }}</td>
                                    <td class="trn-report-results-table-name">
                                        <a href="{{ trn_esc_route_e("{$match->competition_type}.single", ['id' => $match->competition_id]) }}">
                                            {{ esc_html($match->name) }}
                                        </a>
                                    </td>
                                    <td class="trn-report-results-table-result">
                                        @php
                                            $match_date = date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($match->match_date)));

                                            $opponent = 0 < strlen($match->one_result) ? 'two_competitor_name' : 'one_competitor_name';

                                            if ('players' === $match->competitor_type) {
                                                if ('won' === $match->one_result || 'won' === $match->two_result) {
                                                    /* translators: First is name of the opponent, second is the date and time. */
                                                    printf(
                                                        esc_html__('You reported that you defeated %1$s on %2$s.', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                } elseif ('draw' === $match->one_result || 'draw' === $match->two_result) {
                                                    /* translators: First is name of the opponent, second is the date and time. */
                                                    printf(
                                                        esc_html__('You reported a draw against %1$s on %2$s.', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                } else {
                                                    /* translators: First is name of the opponent, second is the date and time. */
                                                    printf(
                                                        esc_html__('You reported that you lost to %1$s on %2$s.', 'tournamatch'),
                                                        esc_html($match->$opponent),
                                                        esc_html($match_date),
                                                    );
                                                }
                                            } elseif ('won' === $match->one_result || 'won' === $match->two_result) {
                                                /* translators: First is name of the opponent, second is the date and time. */
                                                printf(
                                                    esc_html__('You reported that you defeated team %1$s on %2$s.', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            } elseif ('draw' === $match->one_result || 'draw' === $match->two_result) {
                                                /* translators: First is name of the opponent, second is the date and time. */
                                                printf(
                                                    esc_html__('You reported a draw against team %1$s on %2$s.', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            } else {
                                                /* translators: First is name of the opponent, second is the date and time. */
                                                printf(
                                                    esc_html__('You reported that you lost to team %1$s on %2$s.', 'tournamatch'),
                                                    esc_html($match->$opponent),
                                                    esc_html($match_date),
                                                );
                                            }
                                        @endphp
                                    </td>
                                    <td class="action-link-cell trn-report-results-table-action">
                                        <a class="trn-button trn-button-sm trn-button-danger trn-confirm-action-link trn-delete-match-action" href="#"
                                            data-match-id="{{ intval($match->match_id) }}" data-confirm-title="{{ esc_html_e('Delete Match', 'tournamatch') }}"
                                            data-confirm-message="{{ esc_html_e('Are you sure you want to delete this match?', 'tournamatch') }}"
                                            data-modal-id="delete-match">
                                            {{ esc_html_e('Delete', 'tournamatch') }}
                                        </a>
                                        @if ('test' === TOURNAMATCH_ENV)
                                            <input type="hidden" id="trn_match_id[{{ intval($match->match_id) }}]" name="trn_match_id[{{ intval($match->match_id) }}]"
                                                value="{{ intval($match->match_id) }}">
                                            <input type="hidden" id="trn_match_reference[{{ intval($match->match_id) }}]"
                                                name="trn_match_reference[{{ intval($match->match_id) }}]" value="{{ esc_html($match->confirm_hash) }}">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div class='trn-text-center'>
                            {{ esc_html_e('There are no results you\'re waiting on for confirmation.', 'tournamatch') }}
                        </div>
                    @endif
                </section>

                <section>
                    <div class="trn-row">
                        <div class="trn-col-sm-12">
                            <h4 class="trn-text-center">{{ esc_html_e('Your Scheduled Matches', 'tournamatch') }}</h4>
                            @php
                                $scheduled_matches = trn_get_scheduled_matches($user_id);
                            @endphp

                            <div>
                                {{ esc_html(sprintf(_n('You have %s match scheduled that has not been reported.', 'You have %s matches scheduled that have not been reported.', count($scheduled_matches), 'tournamatch'), count($scheduled_matches))) }}
                            </div>
                            {!! scheduled_matches_table($scheduled_matches) !!}

                        </div>
                    </div>
                    <br>
                    <div class="flex items-center justify-center">
                        @if (trn_get_option('open_play_enabled'))
                            <div class="trn-col-md-6">
                                <h4 class="trn-text-center">{{ esc_html__('Report Ladder Results', 'tournamatch') }}</h4>
                                @php
                                    $ladders = trn_get_user_open_play_ladders($user_id);
                                @endphp
                                <?php
                                if (0 < count($ladders)) {
                                ?>
                                <form id="report-ladder-form" class="form-inline trn-text-center" action="<?php trn_esc_route_e('matches.single.create'); ?>" method="post">
                                    <div class="trn-form-group">
                                        <label for="ladder_id" class="control-label"> {{ esc_html_e('Select Ladder', 'tournamatch') }} </label>
                                        <select id="ladder_id" class="trn-form-control mx-sm-3" name='ladder_id'>
                                            @foreach ($ladders as $ladder)
                                                <option value="{{ intval($ladder->ladder_id) }}">{{ esc_html($ladder->name) }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <button class="trn-button trn-button-sm" type='submit' id="report-ladder-button"><?php esc_html_e('Report', 'tournamatch'); ?></button>
                                </form>
                                <?php
                                } else {
                                    echo '<div class="trn-text-center">' . esc_html__('You are not participating in any active ladders.', 'tournamatch') . '</div>';
                                }
                                ?>
                            </div>
                        @endif
                    </div>
                </section>
                @php
                    $options = [
                        'api_url' => site_url('wp-json/tournamatch/v1/'),
                        'rest_nonce' => wp_create_nonce('wp_rest'),
                        'redirect_link' => trn_route('report.page'),
                        'language' => [
                            'failure' => esc_html__('Error', 'tournamatch'),
                        ],
                    ];
                    wp_enqueue_script('trn-delete-match');
                    wp_register_script('trn-report-dashboard', plugins_url('/tournamatch/dist/js/report-dashboard.js'), ['tournamatch'], '4.3.5', true);
                    wp_localize_script('trn-report-dashboard', 'trn_report_dashboard_options', $options);
                    wp_enqueue_script('trn-report-dashboard');
                @endphp
            </div>
        </div>
    </div>
@endsection
