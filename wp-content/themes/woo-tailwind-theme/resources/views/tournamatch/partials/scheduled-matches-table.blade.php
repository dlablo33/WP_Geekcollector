@php
    $scheduled_matches = isset($args['scheduled_matches']) ? $args['scheduled_matches'] : [];
@endphp

<table class="trn-table trn-table-striped trn-scheduled-matches-table" id="scheduled-matches-table">
    <tr>
        <th class="trn-scheduled-matches-table-event">{{ esc_html_e('Event', 'tournamatch') }}</th>
        <th class="trn-scheduled-matches-table-name">{{ esc_html_e('Name', 'tournamatch') }}</th>
        <th class="trn-scheduled-matches-table-competitors">{{ esc_html_e('Competitors', 'tournamatch') }}</th>
        <th class="trn-scheduled-matches-table-date">{{ esc_html_e('Scheduled', 'tournamatch') }}</th>
        <th class="trn-scheduled-matches-table-action"></th>
    </tr>
    <!--<template id="trn-scheduled-matches-table-row-template">-->
    @foreach ($scheduled_matches as $scheduled_match)
        <tr data-competition-type="{{ esc_html($scheduled_match->competition_type) }}" data-competition-id="{{ intval($scheduled_match->competition_id) }}"
            data-match-id="{{ intval($scheduled_match->match_id) }}">
            <td class="trn-scheduled-matches-table-event">
                {{ trn_get_localized_competition_type($scheduled_match->competition_type) }}
            </td>
            <td class="trn-scheduled-matches-table-name">
                <a href="{{ trn_esc_route_e($scheduled_match->competition_slug, ['id' => $scheduled_match->competition_id]) }}">
                    {{ esc_html($scheduled_match->name) }}</a>
            </td>
            <td class="trn-scheduled-matches-table-competitors">
                <a href="{{ trn_esc_route_e($scheduled_match->route_name, [$scheduled_match->route_var => $scheduled_match->one_competitor_id]) }}">
                    {{ esc_html($scheduled_match->one_name) }}
                </a>
                vs
                <a href="{{ trn_esc_route_e($scheduled_match->route_name, [$scheduled_match->route_var => $scheduled_match->two_competitor_id]) }}">
                    {{ esc_html($scheduled_match->two_name) }}
                </a>
            </td>
            <td class="trn-scheduled-matches-table-date">
                {{ esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime(get_date_from_gmt($scheduled_match->match_date)))) }}
            </td>
            <td class="trn-scheduled-matches-table-action">
                <a class="trn-button trn-button-sm" href="{{ trn_esc_route_e('matches.single.report', ['id' => $scheduled_match->match_id]) }}">
                    {{ esc_html_e('Report', 'tournamatch') }}
                </a>
            </td>
        </tr>
    @endforeach
    <!--</template>-->
</table>
