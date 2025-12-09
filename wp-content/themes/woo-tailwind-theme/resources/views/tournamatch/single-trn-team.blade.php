@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-add-player-input-auto-complete-list,
        .trn-auto-complete-items {
            color: black;
        }

        .trn-team-roster-name {
            display: flex !important;
            flex-direction: row;
            align-items: center;
            gap: 5px;
        }

        .trn-team-roster-name img {
            width: 18px;
            height: 12px;
        }

        #trn-add-player-form {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        @media (max-width: 540px) {
            .trn-header-avatar {
                width: 100px;
                height: 100px;
            }

            /* Botones */
            .trn-profile-actions {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            /* Table Overflow */
            .trn-table.trn-table-striped.trn-match-history-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-ladder-competitions-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-tournament-competitions-table.dataTable.no-footer,
            .trn-table.trn-table-striped.trn-team-roster-table.dataTable.no-footer {
                width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                display: block !important;
                white-space: nowrap;
            }

            /* Apply flex to rows, including thead */
            .trn-match-history-table tr,
            .trn-ladder-competitions-table tr,
            .trn-tournament-competitions-table tr,
            .trn-team-roster-table tr {
                display: flex !important;
                width: 100% !important;
                text-align: start !important;
                align-content: space-between !important;
            }

            /* Make headers and cells behave consistently */
            .trn-match-history-table th,
            .trn-match-history-table td,
            .trn-ladder-competitions-table th,
            .trn-ladder-competitions-table td,
            .trn-tournament-competitions-table th,
            .trn-tournament-competitions-table td,
            .trn-team-roster-table th,
            .trn-team-roster-table td {
                flex: 1 1 0 !important;
                min-width: 150px;
                padding: 0.5rem;
                box-sizing: border-box;
                overflow: visible !important;
                text-overflow: ellipsis;
                text-align: start;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
                margin-top: 10px;
            }
        }
    </style>

    <div class="mx-auto mt-10 max-w-7xl text-white">
        @php
            $team_id = get_query_var('id');
            $team = trn_get_team($team_id);
            if (is_null($team)) {
                wp_safe_redirect(trn_route('teams.archive'));
                exit();
            }
            $team_owner = trn_get_team_owner($team_id);
        @endphp
        <div class="trn-profile-header" {!! trn_competitor_header_banner_style($team->banner) !!}>
            <div class="trn-profile-avatar">
                {!! trn_display_avatar($team->team_id, 'teams', $team->avatar, 'trn-header-avatar') !!}
            </div>
            <div class="trn-profile-details">
                <h1 class="trn-profile-name">{{ esc_html($team->name) }}</h1>
                @if (trn_is_plugin_active('trn-profile-social-icons'))
                    @php
                        $social_icons = trn_get_team_icon_fields();
                    @endphp
                    @if (is_array($social_icons) && 0 < count($social_icons))
                        <ul class="trn-list-inline">
                            @foreach ($social_icons as $icon => $data)
                                @php
                                    $key = 'psi_icon_' . $icon;
                                @endphp
                                @if (isset($team->$key) && 0 < strlen($team->$key))
                                    <li class="trn-list-inline-item">
                                        <a href="{{ esc_url($team->$key) }}" target="_blank">
                                            <i class="{{ esc_attr($data['icon']) }}"></i>
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    @endif
                @endif

                <span class="trn-profile-record">{!! do_shortcode('[trn-career-record competitor_type="teams" competitor_id="' . intval($team->team_id) . '"]') !!}</span>
            </div>
            <div class="trn-profile-actions pt-5 md:pt-0">
                @if (is_user_logged_in())
                    <a class="trn-button trn-button-sm" id="trn-edit-team-button" style="display:none" href="{{ trn_esc_route_e('teams.single.edit', ['id' => $team_id]) }}">
                        {{ esc_html_e('Edit Team', 'tournamatch') }}
                    </a>
                    <button class="trn-button trn-button-sm trn-button-danger" id="trn-delete-team-button" style="display:none">
                        {{ esc_html_e('Delete Team', 'tournamatch') }}
                    </button>
                    <button class="trn-button trn-button-sm" id="trn-leave-team-button" style="display:none">
                        {{ esc_html_e('Leave Team', 'tournamatch') }}
                    </button>
                    <button class="trn-button trn-button-sm" id="trn-join-team-button" style="display:none" data-team-id="{{ intval($team_id) }}"
                        data-user-id="{{ intval(get_current_user_id()) }}">
                        {{ esc_html_e('Join Team', 'tournamatch') }}
                    </button>
                @endif
            </div>
            <ul class="trn-profile-list">
                <li class="trn-profile-list-item joined capitalize">
                    {{ esc_html(date_i18n(get_option('date_format'), strtotime(get_date_from_gmt($team->joined_date)))) }}
                </li>
                <li class="trn-profile-list-item members">
                    {{ esc_html(sprintf(_n('%d Member', '%d Members', $team->members, 'tournamatch'), $team->members)) }}
                </li>
            </ul>
        </div>
        <div class="px-4">
            <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 text-center shadow-lg">
                <div>
                    <div id="trn-leave-team-response"></div>
                    <div id="trn-join-team-response"></div>
                    <div id="trn-delete-team-member-response"></div>
                    <?php
                    
                                $options = array(
                                    'api_url'         => site_url( 'wp-json/tournamatch/v1/' ),
                                    'rest_nonce'      => wp_create_nonce( 'wp_rest' ),
                                    'team_id'         => intval( $team_id ),
                                    'current_user_id' => get_current_user_id(),
                                    'is_logged_in'    => is_user_logged_in(),
                                    'teams_url'       => trn_route( 'teams.archive' ),
                                    'can_add'         => current_user_can( 'manage_tournamatch' ),
                                    'can_edit'        => current_user_can( 'manage_tournamatch' ),
                                    'language'        => array(
                                        'success'         => esc_html__( 'Success', 'tournamatch' ),
                                        'success_message' => esc_html__( 'Your request to join the team has been recorded. The team leader must accept your request.', 'tournamatch' ),
                                        'failure'         => esc_html__( 'Error', 'tournamatch' ),
                                        'failure_message' => esc_html__( 'Failed to add player to team.', 'tournamatch' ),
                                        'zero_members'    => esc_html__( 'No members to display.', 'tournamatch' ),
                                        'error_members'   => esc_html__( 'An error occurred.', 'tournamatch' ),
                                    ),
                                );
                                wp_register_script( 'trn_team_profile', plugins_url( '/tournamatch/dist/js/team-profile.js' ), array( 'tournamatch' ), '4.3.0', true );
                                wp_localize_script( 'trn_team_profile', 'trn_team_profile_options', $options );
                                wp_enqueue_script( 'trn_team_profile' );
                                
                                $views = array(
                                    'roster'        => array(
                                        'heading' => __( 'Team Roster', 'tournamatch' ),
                                        'content' => function ( $team ) use ( $team_owner ) {
                                            $team_id = $team->team_id;
                                            $user_id = get_current_user_id();
                                
                                            echo do_shortcode( '[trn-team-roster-table team_id="' . intval( $team_id ) . '"]' );
                                
                                            if ( current_user_can( 'manage_tournamatch' ) ) {
                            ?>
                    <div class="trn-float-right my-5">
                        <form autocomplete="on" class="form-inline" id="trn-add-player-form">
                            <label for="trn-add-player-input" class="sr-only"><?php esc_html_e('Player Name', 'tournamatch'); ?>:</label>
                            <div class="trn-auto-complete mr-sm-2">
                                <input type="text" id="trn-add-player-input" class="trn-form-control text-black" placeholder="<?php esc_html_e('Player name', 'tournamatch'); ?>" required>
                            </div>
                            <button id="trn-add-player-button" class="trn-button"><?php esc_html_e('Add Player', 'tournamatch'); ?></button>
                        </form>
                    </div>
                    <div class="trn-clearfix trn-mb-3"></div>
                    <?php
                                }
                            ?>
                    @if (intval($team_owner->id) === $user_id)
                        <div class="trn-row">
                            <div class="trn-col-md-6" id="invite-panel">
                                {!! do_shortcode('[trn-email-team-invitation-form team_id="' . intval($team_id) . '"]') !!}
                            </div>
                            <div class="trn-col-md-3" id="invitations-panel">
                                {!! do_shortcode('[trn-team-invitations-list team_id="' . intval($team_id) . '"]') !!}
                            </div>
                            <div class="trn-col-md-3" id="requests-panel">
                                {!! do_shortcode('[trn-team-requests-list team_id="' . intval($team_id) . '"]') !!}
                            </div>
                        </div>
                    @endif
                    <?php	
                            },
                        ),
                        'ladders'       => array(
                            'heading' => __( 'Ladders', 'tournamatch' ),
                            'content' => function ( $team ) {
                                echo do_shortcode( '[trn-competitor-ladders-list-table competitor_type="teams" competitor_id="' . intval( $team->team_id ) . '"]' );
                            },
                        ),
                        'tournaments'   => array(
                            'heading' => __( 'Tournaments', 'tournamatch' ),
                            'content' => function ( $team ) {
                                echo do_shortcode( '[trn-competitor-tournaments-list-table competitor_type="teams" competitor_id="' . intval( $team->team_id ) . '"]' );
                            },
                        ),
                        'match-history' => array(
                            'heading' => __( 'Match History', 'tournamatch' ),
                            'content' => function ( $team ) {
                                echo do_shortcode( '[trn-competitor-match-list-table competitor_type="teams" competitor_id="' . intval( $team->team_id ) . '"]' );
                            },
                        ),
                );
                ?>
                    @php
                        $views = apply_filters('trn_single_team_views', $views, $team);
                        trn_single_template_tab_views($views, $team);
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
