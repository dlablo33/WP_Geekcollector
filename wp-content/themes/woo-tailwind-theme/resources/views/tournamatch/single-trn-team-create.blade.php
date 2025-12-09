@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .form-horizontal {
            justify-content: center;
        }
    </style>
    <div class="flex min-h-[70vh] items-center px-6 justify-center text-white">

        @php
            if (!is_user_logged_in()) {
                wp_safe_redirect(wp_login_url(trn_route('teams.single.create')));
                exit();
            }
            if ('1' === trn_get_option('one_team_per_player')) {
                $limit_rule = new Tournamatch\Rules\One_Team_Per_User($user_id);
                $can_create = $limit_rule->passes();
            } else {
                $can_create = true;
            }
        @endphp

        <div class="w-full max-w-md rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <h1 class="trn-mb-4 text-center text-4xl">
                {{ esc_html_e('Create Team', 'touranmatch') }}
            </h1>
            @if (!$can_create)
                <div>
                    {{ esc_html_e('You may not create another team until you leave your current team.', 'tournamatch') }}
                </div>
            @else
                <form class="form-horizontal needs-validation space-y-4" id="trn-create-team-form" novalidate>
                    <div class="trn-form-group px-2">
                        <label for="trn-team-name" class="">{{ esc_html_e('Team Name', 'tournamatch') }}:</label>
                        <div class="w-ull">
                            <input type="text" id="trn-team-name" name="trn-team-name" class="trn-form-control w-full rounded px-3 py-2 text-black" maxlength="25" required>
                            <div class="trn-invalid-feedback" id="trn-team-name-error">
                                {{ esc_html_e('Team name is required.', 'tournamatch') }}</div>
                        </div>
                    </div>
                    <div class="trn-form-group">
                        <label for="trn-team-tag" class="">{{ esc_html_e('Team Tag', 'tournamatch') }}:</label>
                        <div class="">
                            <input type="text" id="trn-team-tag" name="trn-team-tag" class="trn-form-control w-full rounded px-3 py-2 text-black" maxlength="5" required>
                            <div class="trn-invalid-feedback" id="trn-team-tag-error">
                                {{ esc_html_e('Team tag is required.', 'tournamatch') }}</div>
                        </div>
                    </div>
                    <div class="trn-form-group">
                        <button type="submit" class="trn-button" id="trn-create-team-button">{{ esc_html_e('Create Team', 'tournamatch') }}</button>
                    </div>
                </form>
                @php
                    $options = [
                        'api_url' => site_url('wp-json/tournamatch/v1/teams/'),
                        'rest_nonce' => wp_create_nonce('wp_rest'),
                        'team_name_required_message' => esc_html__('Team name is required.', 'tournamatch'),
                        'team_name_duplicate_message' => esc_html__('Team name already exists', 'tournamatch'),
                    ];
                    wp_register_script('trn_create_team', plugins_url('tournamatch/dist/js/create-team.js'), ['tournamatch'], '3.21.1', true);
                    wp_localize_script('trn_create_team', 'trn_create_team_options', $options);
                    wp_enqueue_script('trn_create_team');
                @endphp
            @endif
        </div>

    </div>
@endsection
