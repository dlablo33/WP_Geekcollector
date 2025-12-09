@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-table.trn-table-striped.trn-scheduled-matches-table {
            text-align: center;
        }
    </style>
    @php
        if (!is_user_logged_in()) {
            wp_safe_redirect(wp_login_url(trn_route('matches.single.create')));
            exit();
        }

        global $wpdb;

        $user_id = get_current_user_id();

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $ladder_id = isset($_REQUEST['ladder_id']) ? intval($_REQUEST['ladder_id']) : 0;

        $ladder = trn_get_ladder($ladder_id);
        $user_id = get_current_user_id();

        // Verify this user is a member of this ladder.
        $competitor = trn_get_user_ladder($user_id, $ladder_id);
        if (is_null($competitor) || 'inactive' === $ladder->status) {
            wp_safe_redirect(trn_route('ladders.single', ['id' => $ladder_id]));
            exit();
        }

        $scheduled_matches = trn_get_scheduled_ladder_matches($user_id, $ladder_id);
        $opponents = trn_get_ladder_competitors($ladder_id);

        if ('players' === $ladder->competitor_type) {
            $opponents = array_filter($opponents, function ($opponent) use ($user_id) {
                return intval($opponent->competitor_id) !== intval($user_id);
            });
        } else {
            $my_teams = trn_get_user_ladder_teams(get_current_user_id(), $ladder_id);
            $my_teams = array_column($my_teams, 'team_id');
            $opponents = array_filter($opponents, function ($opponent) use ($my_teams) {
                return !in_array($opponent->competitor_id, $my_teams, true);
            });
        }

        $args = [
            'competition_id' => $ladder_id,
            'competition_type' => 'ladder',
            'competition_name' => $ladder->name,
            'competition_slug' => 'ladder_id',
            'opponents' => $opponents,
            'competitor_id' => $competitor->competitor_id,
            'competitor_type' => $ladder->competitor_type,
            'uses_draws' => trn_get_option('uses_draws'),
        ];

        if ('teams' === $ladder->competitor_type) {
            $args['my_teams'] = trn_get_user_ladder_teams(get_current_user_id(), $ladder_id);
        }
    @endphp

    <div class="mx-auto mt-10 px-4 text-white">
        <div class="mx-auto flex flex-col justify-center rounded-lg bg-[#1a1a1a] p-6 shadow-lg md:w-1/2">
            <div class="">
                <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Report Results', 'tournamatch') }}</h1>
                <section>
                    <h4>{{ esc_html_e('Scheduled Matches', 'tournamatch') }}</h4>
                    <div class="mt-2">{{ trn_get_template_part('partials/scheduled-matches-table', '', ['scheduled_matches' => $scheduled_matches]) }}</div>
                </section>
                @if (trn_get_option('open_play_enabled'))
                    <section>
                        <h4 class="mb-5 text-2xl">{{ esc_html_e('New Match', 'tournamatch') }}</h4>
                        {{ match_form($args) }}
                    </section>
                @endif
            </div>
        </div>
    </div>
@endsection
