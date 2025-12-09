@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-form-control,
        input.trn-form-control {
            width: 200%;
        }

        .trn-form-control-file,
        input.trn-form-control-file {
            background: black;
            padding: 10px 5px;
            border-radius: 8px;
            width: fit-content;
        }

        @media (max-width: 767px) {

            .trn-form-control,
            input.trn-form-control {
                width: 100%;
            }
        }
    </style>
    @php
        $team_id = intval(get_query_var('id'));
        $team = trn_get_team($team_id);
        if (is_null($team)) {
            wp_safe_redirect(trn_route('teams.archive'));
            exit();
        }

        $can_edit = false;
        if (current_user_can('manage_tournamatch') && 0 !== $team_id) {
            $can_edit = true;
        } elseif (is_user_logged_in()) {
            $team_owner = trn_get_team_owner($team_id);
            $can_edit = intval($team_owner->id) === get_current_user_id();
        }

        if (!$can_edit) {
            wp_safe_redirect(trn_route('teams.archive'));
            exit();
        }

        $form_fields = [
            'name' => [
                'id' => 'name',
                'label' => __('Team Name', 'tournamatch'),
                'required' => true,
                'type' => 'text',
                'value' => isset($team->name) ? $team->name : '',
            ],
            'tag' => [
                'id' => 'tag',
                'label' => __('Team Tag', 'tournamatch'),
                'required' => true,
                'type' => 'text',
                'maxlength' => 5,
                'value' => isset($team->tag) ? $team->tag : '',
            ],
            'flag' => [
                'id' => 'flag',
                'label' => __('Country Flag', 'tournamatch'),
                'type' => 'select',
                'value' => isset($team->flag) ? $team->flag : 'blank.gif',
                'options' => trn_get_flag_options(),
            ],
            'avatar' => [
                'id' => 'avatar',
                'label' => __('Avatar', 'tournamatch'),
                'type' => 'thumbnail',
                'description' => __('Only choose file if you wish to change your avatar.', 'tournamatch'),
                'value' => isset($team->avatar) ? $team->avatar : '',
                'thumbnail' => function ($context) {
                    trn_display_avatar($context->team_id, 'teams', $context->avatar);
                },
            ],
            'banner' => [
                'id' => 'banner',
                'label' => __('Banner', 'tournamatch'),
                'type' => 'thumbnail',
                'description' => __('Only choose file if you wish to change your banner.', 'tournamatch'),
                'value' => isset($team->banner) ? $team->banner : '',
                'thumbnail' => function ($context) {
                    if (0 < strlen($context->banner)) {
                        echo '<img width="400" height="100" class="trn-profile-edit-banner" src="' .
                            esc_attr(trn_upload_url() . '/images/avatars/' . $context->banner) .
                            '"/>';
                    }
                },
            ],
        ];

        $form = [
            'attributes' => [
                'id' => 'trn-edit-team-profile-form',
                'action' => '#',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'data-team-id' => intval($team_id),
            ],
            'fields' => $form_fields,
            'submit' => [
                'id' => 'trn-save-button',
                'content' => __('Save', 'tournamatch'),
            ],
        ];

    @endphp

    <div class="mx-auto mt-10 flex max-w-7xl flex-col items-center justify-center p-6 text-white">
        <div>
            <h1 class="trn-mb-4 text-4xl">{{ esc_html_e('Edit Team Profile', 'tournamatch') }}</h1>
            <div class="flex flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
                <div>
                    {!! trn_user_form($form, $team) !!}
                    <div id="trn-update-response"></div>
                    @php
                        $options = [
                            'api_url' => site_url('wp-json/tournamatch/v1/'),
                            'rest_nonce' => wp_create_nonce('wp_rest'),
                            'avatar_upload_path' => trn_upload_url() . '/images/avatars/',
                            'language' => [
                                'failure' => esc_html__('Error', 'tournamatch'),
                                'failure_message' => esc_html__('Could not update team profile.', 'tournamatch'),
                                'success' => esc_html__('Success', 'tournamatch'),
                                'success_message' => esc_html__('Team profile updated.', 'tournamatch'),
                            ],
                        ];
                        wp_register_script('update-team-profile', plugins_url('/tournamatch/dist/js/update-team-profile.js'), ['tournamatch'], '3.16.0', true);
                        wp_localize_script('update-team-profile', 'trn_team_profile_options', $options);
                        wp_enqueue_script('update-team-profile');
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
