@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-match-header-avatar {
            object-fit: cover !important;
        }
    </style>
    @php
        $match_id = get_query_var('id');

        $match = trn_get_match($match_id);
        if (is_null($match)) {
            wp_safe_redirect(trn_route('matches.archive'));
            exit();
        }

        $competition = 'ladders' === $match->competition_type ? trn_get_ladder($match->competition_id) : trn_get_tournament($match->competition_id);

        // Get match entrants.
        if ('players' === $competition->competitor_type) {
            $one_row = trn_get_player($match->one_competitor_id);
            $two_row = trn_get_player($match->two_competitor_id);
        } else {
            $one_row = trn_get_team($match->one_competitor_id);
            $two_row = trn_get_team($match->two_competitor_id);
        }

        $can_report = false;
        $can_delete = 'ladders' === $match->competition_type && current_user_can('manage_tournamatch');
        $can_clear = false;
        $can_confirm = false;
        $can_dispute = false;
    @endphp

    <div class="min-h-[70vh]">
        <div class="trn-match-header !flex flex-col items-center justify-center" {!! trn_header_banner_style($competition->banner_id, $competition->game_id) !!}>
            <div class="!flex items-center justify-evenly gap-2 md:gap-x-[80vh]">
                <div class="flex text-left flex-col md:flex-row-reverse">
                    <div class="trn-match-header-left-details mr-30">
                        <h1 class="trn-match-competitor">{{ esc_html($one_row->name) }}</h1>
                        @if ('confirmed' === $match->match_status)
                            <span class="trn-match-result">
                                @if ('won' === $match->one_result)
                                    {{ esc_html__('Winner', 'tournamatch') }}
                                @elseif('draw' === $match->one_result)
                                    {{ esc_html__('Draw', 'tournamatch') }}
                                @else
                                    {{ esc_html__('Loser', 'tournamatch') }}
                                @endif
                            </span>
                        @endif
                    </div>
                    <div class="trn-match-header-left-avatar">
                        {!! trn_display_avatar($match->one_competitor_id, $competition->competitor_type, $one_row->avatar, 'trn-match-header-avatar') !!}
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="trn-match-header-right-details">
                        <h1 class="trn-match-competitor">{{ esc_html($two_row->name) }}</h1>
                        @if ('confirmed' === $match->match_status)
                            <span class="trn-match-result">
                                @if ('won' === $match->two_result)
                                    {{ esc_html__('Winner', 'tournamatch') }}
                                @elseif('draw' === $match->two_result)
                                    {{ esc_html__('Draw', 'tournamatch') }}
                                @else
                                    {{ esc_html__('Loser', 'tournamatch') }}
                                @endif
                            </span>
                        @endif
                    </div>
                    <div class="trn-match-header-right-avatar">
                        {!! trn_display_avatar($match->two_competitor_id, $competition->competitor_type, $two_row->avatar, 'trn-match-header-avatar') !!}
                    </div>
                </div>
            </div>
            <div class="trn-match-actions">
                <div class="trn-pull-right">
                    @if ($can_confirm)
                        <a class="trn-button"
                            href="{{ trn_esc_route_e('matches.single.confirm', ['id' => $match->match_id]) }}">{{ esc_html_e('Confirm', 'tournamatch') }}</a>
                    @endif
                    @if ($can_dispute)
                        {!! do_shortcode('[trn-dispute-match-button id="' . intval($match->match_id) . '"]') !!}
                    @endif
                    @if ($can_report)
                        <a class="trn-button" href="">{{ esc_html_e('Report', 'tournamatch') }}</a>
                    @endif
                    @if ($can_delete)
                        <a class="trn-button trn-button-danger trn-confirm-action-link trn-delete-match-action" href="#" data-match-id="{{ intval($match->match_id) }}"
                            data-confirm-title="{{ esc_html_e('Delete Match', 'tournamatch') }}"
                            data-confirm-message="{{ esc_html_e('Are you sure you want to delete this match?', 'tournamatch') }}" data-modal-id="delete-match">
                            {{ esc_html_e('Delete', 'tournamatch') }}
                        </a>
                    @endif
                    @if ($can_clear)
                        <a class="trn-button trn-button-danger" href="{!! trn_esc_route_e('admin.tournaments.clear-match', [
                            'id' => $match->match_id,
                            '_wpnonce' => wp_create_nonce('tournamatch-bulk-matches'),
                        ]) !!}">
                            {{ esc_html_e('Clear', 'tournamatch') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="px-6">
            <div class="mx-auto mt-10 flex items-center justify-center text-white">
                <div class="flex w-full max-w-2xl flex-col items-center justify-center rounded-lg bg-[#1a1a1a] p-6 text-center shadow-lg">
                    <?php
                                $views = array(
                                'match_details' => array(
                                    'heading' => __( 'Details', 'tournamatch' ),
                                    'content' => function ( $match ) use ( $one_row, $two_row, $competition ) {
                                        $competition_label = trn_get_localized_competition_type( $match->competition_type, true );
                                        $description_list = array(
                                            $competition_label => array(
                                                'term'        => $competition_label,
                                                'description' => function ( $match ) use ( $competition ) {
                                                    $competition_route = ( 'ladders' === $match->competition_type ) ? 'ladders.single' : 'tournaments.single.brackets';
                                                    echo '<a href="' . esc_url( trn_route( $competition_route, array( 'id' => $match->competition_id ) ) ) . '">' . esc_html( $competition->name ) . '</a>';
                                                },
                                            ),
                                            'status'           => array(
                                                'term'        => __( 'Status', 'tournamatch' ),
                                                'description' => trn_get_localized_match_status( $match->match_status ),
                                            ),
                                        );
                                        if ( '0000-00-00 00:00:00' !== $match->match_date ) {
                                            $description_list = trn_array_merge_after_key(
                                                $description_list,
                                                'status',
                                                array(
                                                    'date' => array(
                                                        'term'        => __( 'Date', 'tournamatch' ),
                                                        'description' => date_i18n( get_option( 'date_format' ), strtotime( get_date_from_gmt( $match->match_date ) ) ),
                                                    ),
                                                ),
                                                false,
                                                true
                                            );
                                        }
                                        if ( 'confirmed' === $match->match_status ) {
                                            if ( 'draw' === $match->one_result ) {
                                                $result = array(
                                                    'result' => array(
                                                        'term'        => __( 'Result', 'tournamatch' ),
                                                        'description' => __( 'Draw', 'tournamatch' ),
                                                    ),
                                                );
                                            } else {
                                                $winner_callback = function ( $match ) use ( $one_row ) {
                                                    echo '<a href="' . esc_url( trn_route( "{$match->one_competitor_type}.single", array( 'id' => $match->one_competitor_id ) ) ) . '">' . esc_html( $one_row->name ) . '</a>';
                                                };
                                                $loser_callback = function ( $match ) use ( $two_row ) {
                                                    echo '<a href="' . esc_url( trn_route( "{$match->two_competitor_type}.single", array( 'id' => $match->two_competitor_id ) ) ) . '">' . esc_html( $two_row->name ) . '</a>';
                                                };
                                                if ( 'lost' === $match->one_result ) {
                                                    list( $winner_callback, $loser_callback ) = array( $loser_callback, $winner_callback );
                                                }
                                                $result = array(
                                                    'winner' => array(
                                                        'term'        => __( 'Winner', 'tournamatch' ),
                                                        'description' => $winner_callback,
                                                    ),
                                                    'loser'  => array(
                                                        'term'        => __( 'Loser', 'tournamatch' ),
                                                        'description' => $loser_callback,
                                                    ),
                                                );
                                            }
                                            $description_list = trn_array_merge_after_key( $description_list, 'status', $result, true, true );
                                        }
                                        $description_list = apply_filters( 'trn_single_match_details_description_list', $description_list, $match );
                                        trn_single_template_description_list( $description_list, $match );
                                    },
                                ),
                                'comments'      => array(
                                    'heading' => __( 'Comments', 'tournamatch' ),
                                    'content' => function ( $match ) use ( $one_row, $two_row ) {
                            ?>
                    <dl class="trn-dl">
                        <dt class="trn-dt">{{ esc_html($one_row->name) }}: </dt>
                        <dd class="trn-dd">{{ esc_html($match->one_comment) }}</dd>
                        <dt class="trn-dt">{{ esc_html($two_row->name) }}: </dt>
                        <dd class="trn-dd">{{ esc_html($match->two_comment) }}</dd>
                    </dl>
                    <?php
                                },
                            ),
                            );
                            ?>
                    @php
                        $views = apply_filters('trn_single_match_views', $views, $match);
                        trn_single_template_tab_views($views, $match);
                        $options = [
                            'redirect_link' => trn_route('matches.archive'),
                        ];
                        wp_enqueue_script('trn-delete-match');
                        wp_register_script('trn-match-details', plugins_url('/tournamatch/dist/js/match-details.js'), ['tournamatch'], '3.11.0', true);
                        wp_localize_script('trn-match-details', 'trn_match_details_options', $options);
                        wp_enqueue_script('trn-match-details');
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
