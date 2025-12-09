@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-edit-player-profile-form {
            max-width: 75%;
            margin: 0 auto;
        }

        .trn-col-sm-3 {
            text-align: center;
        }

        input[type="text"] {
            width: 200%;
            /* make it wider */
        }

        @media (max-width: 767px) {
            input[type="text"] {
                width: 100%;
                /* make it wider */
            }
        }
    </style>
    <div class="mt-10 flex flex-col items-center justify-center px-6 text-white">
        <div>
            @php
                $user_id = get_query_var('id', null);
                if (is_user_logged_in() && (get_current_user_id() === intval($user_id) || is_null($user_id))) {
                    $user_id = get_current_user_id();
                } elseif (!current_user_can('manage_tournamatch')) {
                    wp_safe_redirect(trn_route('players.archive'));
                    exit();
                }
                $player = trn_get_player($user_id);
                if (is_null($player)) {
                    wp_safe_redirect(trn_route('players.archive'));
                    exit();
                }
                $form_fields = [
                    'display_name' => [
                        'id' => 'display_name',
                        'label' => __('Display Name', 'tournamatch'),
                        'required' => true,
                        'type' => 'text',
                        'value' => isset($player->display_name) ? $player->display_name : '',
                    ],
                    'location' => [
                        'id' => 'location',
                        'label' => __('Location', 'tournamatch'),
                        'type' => 'text',
                        'value' => isset($player->location) ? $player->location : '',
                    ],
                    'flag' => [
                        'id' => 'flag',
                        'label' => __('Country Flag', 'tournamatch'),
                        'type' => 'select',
                        'value' => isset($player->flag) ? $player->flag : 'blank.gif',
                        'options' => trn_get_flag_options(),
                        // ],
                        // 'avatar' => [
                        //     'id' => 'avatar',
                        //     'label' => __('Avatar', 'tournamatch'),
                        //     'type' => 'thumbnail',
                        //     'description' => __('Only choose file if you wish to change your avatar.', 'tournamatch'),
                        //     'value' => isset($player->avatar) ? $player->avatar : '',
                        //     'thumbnail' => function ($context) {
                        //         trn_display_avatar($context->user_id, 'players', $context->avatar);
                        //     },
                    ],
                    'banner' => [
                        'id' => 'banner',
                        'label' => __('Banner', 'tournamatch'),
                        'type' => 'thumbnail',
                        'description' => __('Only choose file if you wish to change your banner.', 'tournamatch'),
                        'value' => isset($player->banner) ? $player->banner : '',
                        'thumbnail' => function ($context) {
                            if (0 < strlen($context->banner)) {
                                echo '<img width="400" height="100" class="trn-profile-edit-banner" src="' .
                                    esc_attr(trn_upload_url() . '/images/avatars/' . $context->banner) .
                                    '"/>';
                            }
                        },
                    ],
                    'profile' => [
                        'id' => 'profile',
                        'label' => __('Profile', 'tournamatch'),
                        'type' => 'textarea',
                        'value' => isset($player->profile) ? $player->profile : '',
                    ],
                    // 'new_password' => [
                    //     'id' => 'new_password',
                    //     'label' => __('New password', 'tournamatch'),
                    //     'type' => 'password',
                    //     'description' => __('Only enter if you wish to change your password.', 'tournamatch'),
                    // ],
                    // 'confirm_password' => [
                    //     'id' => 'confirm_password',
                    //     'label' => __('Confirm password', 'tournamatch'),
                    //     'type' => 'password',
                    //     'description' => __('Only enter if you wish to change your password.', 'tournamatch'),
                    // ],
                ];
                $form = [
                    'attributes' => [
                        'id' => 'trn-edit-player-profile-form',
                        'action' => '#',
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'data-player-id' => intval($user_id),
                    ],
                    'fields' => $form_fields,
                    'submit' => [
                        'id' => 'trn-save-button',
                        'content' => __('Save', 'tournamatch'),
                    ],
                ];
            @endphp
            <div class="flex w-full max-w-2xl flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
                <div>
                    <h1 class="trn-mb-4 text-center text-2xl">{{ esc_html_e('Edit Profile', 'tournamatch') }}</h1>
                    <div class="ml-0">
                        {!! trn_user_form($form, $player) !!}
                    </div>
                </div>
            </div>
            <div id="trn-update-response"></div>
            @php
                $options = [
                    'api_url' => site_url('wp-json/tournamatch/v1/'),
                    'rest_nonce' => wp_create_nonce('wp_rest'),
                    'avatar_upload_path' => trn_upload_url() . '/images/avatars/',
                    'language' => [
                        'failure' => esc_html__('Error', 'tournamatch'),
                        'failure_message' => esc_html__('Could not update player profile.', 'tournamatch'),
                        'success' => esc_html__('Success', 'tournamatch'),
                        'success_message' => esc_html__('Player profile updated.', 'tournamatch'),
                    ],
                ];
                wp_register_script('update-player-profile', plugins_url('tournamatch/dist/js/update-player-profile.js'), ['tournamatch'], '3.16.0', true);
                wp_localize_script('update-player-profile', 'trn_player_profile_options', $options);
                wp_enqueue_script('update-player-profile');
            @endphp
        </div>
    </div>
@endsection
