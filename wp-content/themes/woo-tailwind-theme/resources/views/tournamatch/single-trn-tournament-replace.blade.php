@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    @php

        if (!current_user_can('manage_tournamatch')) {
            wp_safe_redirect(trn_route('tournaments.archive'));
            exit();
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $match_id = isset($_GET['match_id']) ? intval($_GET['match_id']) : null;

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $competitor_id = isset($_GET['competitor_id']) ? intval($_GET['competitor_id']) : null;

        $match = trn_get_match($match_id);
        $tournament = trn_get_tournament($match->competition_id);
        $opponent_id = intval($match->one_competitor_id) === $competitor_id ? $match->two_competitor_id : $match->one_competitor_id;
        $opponent = 'players' === $tournament->competitor_type ? trn_get_player($opponent_id) : trn_get_team($opponent_id);
        $competitors = trn_get_registered_competitors($tournament->tournament_id);
        $competitors = array_filter($competitors, function ($competitor) use ($opponent_id) {
            return intval($opponent_id) !== intval($competitor->competitor_id);
        });

    @endphp
    <div class="ml-auto mt-10 min-h-[70vh] max-w-7xl text-white">
        <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Select New Competitor', 'tournamatch') }}</h1>
        <div class="flex w-full max-w-2xl flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <div>
                <form action="{{ esc_url(admin_url('admin-post.php')) }}" method="post">
                    <div class="trn-form-group trn-row">
                        <label class="trn-col-sm-4 trn-col-lg-3">{{ esc_html_e('Tournament', 'tournamatch') }}:</label>
                        <div class="trn-col-sm-6 trn-col-lg-4">
                            <div class="trn-form-control-static">{{ esc_html($tournament->name) }}</div>
                        </div>
                    </div>
                    <div class="trn-form-group trn-row">
                        <label class="trn-col-sm-4 trn-col-lg-3">{{ esc_html_e('Opponent', 'tournamatch') }}:</label>
                        <div class="trn-col-sm-6 trn-col-lg-4">
                            @if (isset($opponent))
                                <div class="trn-form-control-static">{{ esc_html($opponent->name) }} </div>
                            @else
                                <div class="trn-form-control-static">{{ esc_html_e('Undecided', 'tournamatch') }} </div>
                            @endif

                        </div>
                    </div>
                    <div class="trn-form-group trn-row">
                        <label for="new_competitor_id" class="trn-col-sm-4 trn-col-lg-3">{{ esc_html_e('Competitor', 'tournamatch') }}:</label>
                        <div class="trn-col-sm-4">
                            <select id="new_competitor_id" name="new_competitor_id" class="trn-form-control">
                                @foreach ($competitors as $competitor)
                                    <option value="{{ intval($competitor->competitor_id) }}" {{ intval($competitor->competitor_id) === $competitor_id ? 'selected' : '' }}>
                                        {{ esc_html($competitor->competitor_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="trn-form-group trn-row">
                        <div class="trn-col-sm-offset-4 trn-col-lg-offset-3 trn-col-sm-6">
                            {!! wp_nonce_field('tournamatch-replace-tournament-competitor') !!}
                            <input type="hidden" name="match_id" value="{{ intval($match_id) }}">
                            <input type="hidden" name="competitor_id" value="{{ intval($competitor_id) }}">
                            <input type="hidden" name="action" value="trn-replace-tournament-competitor">
                            <input type="submit" class="trn-button" value="Update">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
