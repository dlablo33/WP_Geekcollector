@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        label {
            font-size: x-large;
        }

        .trn-form-control {
            width: 200%;
        }

        @media (max-width: 768px) {
            .trn-form-control {
                width: 100%;
            }
        }
    </style>
    @php

        $match_id = get_query_var('id');

        if (!trn_can_report_match(get_current_user_id(), $match_id)) {
            wp_safe_redirect(trn_route('matches.single', ['id' => $match_id]));
            exit();
        }

        $user_id = get_current_user_id();
        $match = trn_get_match($match_id);

        // competition data.
        if ('ladders' === $match->competition_type) {
            $competition = trn_get_ladder($match->competition_id);
            $competition_type = 'ladder';
            $competition_slug = 'ladder_id';
        } else {
            $competition = trn_get_tournament($match->competition_id);
            $competition_type = 'tournament';
            $competition_slug = 'tournament_id';
        }

        // user and opponent data.
        if ('players' === $competition->competitor_type) {
            $competitor_id = $user_id;
            $opponent_id = intval($user_id) === intval($match->one_competitor_id) ? $match->two_competitor_id : $match->one_competitor_id;
            $opponent = trn_get_player($opponent_id);
        } else {
            if ('ladders' === $match->competition_type) {
                $my_teams = trn_get_user_ladder_teams($user_id, $match->competition_id);
            } else {
                $my_teams = trn_get_user_tournament_teams($user_id, $match->competition_id);
            }
            $my_teams = array_column($my_teams, 'team_id');
            $competitor_id = in_array($match->one_competitor_id, $my_teams, true) ? $match->one_competitor_id : $match->two_competitor_id;
            $opponent_id = $competitor_id === $match->one_competitor_id ? $match->two_competitor_id : $match->one_competitor_id;
            $opponent = trn_get_team($opponent_id);
        }

        $opponent = [
            'competitor_id' => $opponent_id,
            'competitor_name' => $opponent->name,
        ];

        $args = [
            'competition_id' => $match->competition_id,
            'competition_type' => $competition_type,
            'competition_name' => $competition->name,
            'competition_slug' => $competition_slug,
            'opponents' => $opponent,
            'competitor_id' => $competitor_id,
            'competitor_type' => $competition->competitor_type,
            'uses_draws' => trn_get_option('uses_draws'),
            'match_id' => $match_id,
            'one_competitor_id' => $match->one_competitor_id,
            'mode' => 'save',
        ];

        if ('teams' === $competition->competitor_type) {
            if ('ladders' === $match->competition_type) {
                $args['my_teams'] = trn_get_user_ladder_teams($user_id, $match->competition_id);
            } else {
                $args['my_teams'] = trn_get_user_tournament_teams($user_id, $match->competition_id);
            }
        }

    @endphp

    <div class="mx-auto mt-10 min-h-[70vh] w-full max-w-7xl px-6 text-white md:w-1/2 md:px-0">
        <h1 class="trn-mb-4 text-4xl text-white">{{ esc_html_e('Report', 'tournamatch') }}</h1>
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">

            {!! match_form($args) !!}

        </div>
    </div>
@endsection
