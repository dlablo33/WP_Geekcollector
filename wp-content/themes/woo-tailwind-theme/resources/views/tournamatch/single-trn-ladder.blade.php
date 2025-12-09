@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-nav-link {
            padding: 1rem 1.5rem;
            background: #252525;
            color: #ccc;
            border-radius: 6px 6px 0 0;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid #333;
            border-bottom: none;
        }

        .trn-nav-link:hover,
        .trn-nav-link.active {
            background: #ff7700;
            color: #000;
            transform: translateY(-2px);
        }

        .dataTables_processing,
        .trn-card {
            color: black;
        }

        td {
            text-align: center;
        }

        .trn-ladder-standings-table-name {
            display: flex !important;
            flex-direction: row;
            align-items: center;
            gap: 5px;
        }

        .trn-ladder-standings-table-name img {
            width: 18px;
            height: 12px;
        }

        /* Mobile */
        @media (max-width: 767px) {

            /* Numero de items */
            .dataTables_length {
                display: none !important;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
                margin-top: 10px;
            }
        }
    </style>

    @php
        $ladder_id = get_query_var('id');

        $ladder = trn_get_ladder($ladder_id);
        $ladder = trn_the_ladder($ladder);
        if (is_null($ladder)) {
            wp_safe_redirect(trn_route('ladders.archive'));
            exit();
        }

        $competitor_type = $ladder->competitor_type;
        $can_join = is_user_logged_in() && 'active' === $ladder->status;
        $can_report = false;
        $can_leave = false;
        $competitor = null;

        if (is_user_logged_in()) {
            $competitor = trn_get_user_ladder(get_current_user_id(), $ladder_id);

            if (trn_get_option('can_leave_ladder')) {
                $can_leave = !is_null($competitor);
            }

            if (!is_null($competitor)) {
                $can_report = 'active' === $ladder->status;
                $can_join = false;
            }
        }

        $image_directory = trn_upload_url() . '/images';
        $game_avatar_source = $image_directory . '/games/' . (is_null($ladder->game_thumbnail) ? 'blank.gif' : $ladder->game_thumbnail);

    @endphp

    <div class="trn-competition-header" {!! trn_header_banner_style($ladder->banner_id, $ladder->game_id) !!}>
        <div class="trn-competition-details">
            <h1 class="trn-competition-name">{{ esc_html($ladder->name) }}</h1>
            <span class="trn-competition-game">{{ esc_html($ladder->game_name) }}</span>
        </div>
        <ul class="trn-competition-list">
            <li class="trn-competition-list-item members">
                @php
                    printf(esc_html(_n('%s Competitor', '%s Competitors', intval($ladder->competitors), 'tournamatch')), intval($ladder->competitors));
                @endphp
            </li>
            <li class="trn-competition-list-item ranking">
                {{ esc_html($ladder->ranking_mode_label) }}
            </li>
            <li class="trn-competition-list-item competitor-type">
                @if ('players' === $ladder->competitor_type)
                    {{ esc_html_e('Singles', 'tournamatch') }}
                @else
                    @php
                        printf(esc_html__('Teams (%1$d vs %1$d)', 'tournamatch'), intval($ladder->team_size));
                    @endphp
                @endif

            </li>
            @if (trn_is_plugin_active('trn-mycred'))
                <li class="trn-competition-list-item entry-fee">
                    {{ intval($ladder->mycred_entry_fee) }}
                </li>
            @endif
        </ul>
    </div>

    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl text-white">
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <div class="w-full">
                <?php
		
			$views = array(
				'standings' => array(
					'heading' => __( 'Standings', 'tournamatch' ),
					'content' => function ( $ladder ) {
						if ( 'active' !== $ladder->status ) {
							echo '<p>' . esc_html__( 'This ladder is no longer active.', 'tournamatch' ) . '</p>';
						} else {
							echo do_shortcode( '[trn-ladder-standings-list-table ladder_id="' . intval( $ladder->ladder_id ) . '"]' );
						}
					},
				),
				'rules'     => array(
					'heading' => __( 'Rules', 'tournamatch' ),
					'content' => function ( $ladder ) {
						if ( strlen( $ladder->rules ) > 0 ) {
							echo wp_kses_post( stripslashes( $ladder->rules ) );
						} else {
							echo '<p class="trn-text-center">';
							esc_html_e( 'No rules to display.', 'tournamatch' );
							echo '</p>';
						}
					},
				),
				'matches'   => array(
					'heading' => __( 'Matches', 'tournamatch' ),
					'content' => function ( $ladder ) {
						if ( 'active' !== $ladder->status ) {
							echo '<p>' . esc_html__( 'This ladder is no longer active.', 'tournamatch' ) . '</p>';
						} else {
							echo do_shortcode( '[trn-ladder-matches-list-table ladder_id="' . intval( $ladder->ladder_id ) . '"]' );
						}
					},
				),
			);
		
			if ( $can_join ) {
				$views = array_merge(
					$views,
					array(
						'join' => array(
							'heading' => __( 'Join', 'tournamatch' ),
							'href'    => trn_route( 'ladders.single.join', array( 'id' => $ladder->ladder_id ) ),
						),
					)
				);
			}
		
			if ( $can_report ) {
				$views = array_merge(
					$views,
					array(
						'report' => array(
							'heading' => __( 'Report', 'tournamatch' ),
							'href'    => trn_route( 'matches.single.create', array( 'ladder_id' => $ladder->ladder_id ) ),
						),
					)
				);
			}
		
			if ( ( $can_report ) && ( 'enabled' === $ladder->direct_challenges ) ) {
				$views = array_merge(
					$views,
					array(
						'challenge' => array(
							'heading' => __( 'Challenge', 'tournamatch' ),
							'href'    => trn_route( 'challenges.single.create', array( 'ladder_id' => $ladder->ladder_id ) ),
						),
					)
				);
			}
		
			if ( $can_leave ) {
				$views = array_merge(
					$views,
					array(
						'leave' => array(
							'heading' => function ( $ladder ) use ( $competitor ) {
								?>
                <a class="trn-nav-link trn-confirm-action-link trn-leave-ladder-link" id="trn-leave-ladder-link" href="#leave"
                    data-competitor-id="{{ intval($competitor->ladder_entry_id) }}" data-confirm-title="{{ esc_html_e('Leave Ladder', 'tournamatch') }}"
                    data-confirm-message="{{ esc_html_e('Are you sure you want to leave this ladder?', 'tournamatch') }}" data-modal-id="leave-ladder">
                    {{ esc_html_e('Leave', 'tournamatch') }}
                </a>
                <?php
							},
						),
					)
				);
		
		
				$options = array(
					'api_url'    => site_url( 'wp-json/tournamatch/v1/' ),
					'rest_nonce' => wp_create_nonce( 'wp_rest' ),
					'language'   => array(
						'failure' => esc_html__( 'Error', 'tournamatch' ),
					),
				);
		
				wp_register_script(
					'leave-ladder',
					plugins_url( '/tournamatch/dist/js/leave-ladder.js' ),
					array(
						'tournamatch',
					),
					'4.3.5',
					true
				);
				wp_localize_script( 'leave-ladder', 'trn_leave_ladder_options', $options );
				wp_enqueue_script( 'leave-ladder' );
			}
			?>
                @php
                    $views = apply_filters('trn_single_ladder_views', $views, $ladder);
                    trn_single_template_tab_views($views, $ladder);
                @endphp
            </div>
        </div>
    </div>
@endsection
