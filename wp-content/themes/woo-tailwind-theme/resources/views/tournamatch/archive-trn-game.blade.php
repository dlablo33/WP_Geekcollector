@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-item-wrapper {
            background: #1a1a1a;
        }

        .trn-item-wrapper:hover {
            background: #ff7700 !important;
            color: #000 !important;
            transform: translateY(-2px) !important;
        }
    </style>
    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl text-white">
        @php
            $games = trn_get_games_with_competition_counts(isset($_GET['platform']) ? sanitize_text_field(wp_unslash($_GET['platform'])) : null);
            $image_directory = trn_upload_url() . '/images';
        @endphp
        <div class="px-4 md:px-0">
            <h1 class="trn-mb-4 text-4xl">
                {{ esc_html_e('Games', 'tournamatch') }}
            </h1>
        </div>
        <div class="mx-auto w-3/4 md:w-full">
            <div class="trn-row" id="games">
                @foreach ($games as $game)
                    @php
                        $src = $image_directory . '/games/blank.gif';
                        if (isset($game->thumbnail_id) && 0 < $game->thumbnail_id) {
                            $src = wp_get_attachment_image_src($game->thumbnail_id);
                            if (is_array($src)) {
                                $src = $src[0];
                            }
                        } elseif (isset($game->thumbnail) && 0 < strlen($game->thumbnail)) {
                            $src = $image_directory . '/games/' . $game->thumbnail;
                        }
                    @endphp
                    <div class="trn-col-lg-4 trn-col-sm-6">
                        <div class="trn-item-wrapper">
                            <div class="trn-item-group">
                                <div class="trn-item-thumbnail">
                                    <img class="bg-white" src="{{ esc_attr($src) }}" alt="{{ esc_html($game->name) }}">
                                </div>
                                <div class="trn-item-info">
                                    <span class="trn-item-title">{{ esc_html($game->name) }}</span>
                                    <span class="trn-item-meta">
                                        <?php
                                        printf(
                                            wp_kses_post(
                                                /* translators: A Hyperlinked number of ladders; '<a href="">5 Ladders</a>' */
                                                __('<a href="%1$s">%2$d Ladders</a>', 'tournamatch'),
                                            ),
                                            esc_url(trn_route('ladders.archive', ['game_id' => $game->game_id])),
                                            intval($game->ladders),
                                        );
                                        ?>
                                    </span>
                                    <span class="trn-item-meta">
                                        <?php
                                        printf(
                                            wp_kses_post(
                                                /* translators: A Hyperlinked number of tournaments; '<a href="">3</a> Tournaments' */
                                                __('<a href="%1$s">%2$d Tournaments</a>', 'tournamatch'),
                                            ),
                                            esc_url(trn_route('tournaments.archive', ['game_id' => $game->game_id])),
                                            intval($game->tournaments),
                                        );
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <ul class="trn-item-list">
                                <li class="trn-item-list-item platform">
                                    <?php echo esc_html($game->platform); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
