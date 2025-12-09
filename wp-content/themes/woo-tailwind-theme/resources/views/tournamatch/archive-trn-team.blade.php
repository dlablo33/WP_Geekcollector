@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-teams-table-members,
        .trn-teams-table-created,
        .trn-teams-table-action {
            text-align: center;
        }

        td {
            text-align: center;
        }

        .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_processing {
            color: black
        }

        /* Mobile */
        @media (max-width: 767px) {

            /* Numero de items */
            .dataTables_length {
                display: none !important;
            }

            /* Busqueda */
            .dataTables_info {
                margin-bottom: 10px;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
            }

            /* Tabla scroll */
            .trn-table.trn-table-striped.dataTable.no-footer {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                white-space: nowrap;
            }
        }
    </style>
    <div class="mx-auto mt-10 max-w-7xl px-4 text-white md:min-h-[70vh] md:w-full">
        @php
            // Add backwards compatibility for old team accept invitation URLs (3.x and <= 4.3.4).
            if ('acceptInvitation' === get_query_var('mode')) {
                wp_safe_redirect(trn_route('magic.accept-team-invitation', ['join_code' => get_query_var('code')]));
                exit();
            }
        @endphp
        <h1 class="mb-4 text-4xl">{{ esc_html_e('Teams', 'tournamatch') }}</h1>
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <div>
                @if (is_user_logged_in())
                    <div class="trn-float-right mb-5">
                        <a class="trn-button" href="{{ trn_esc_route_e('teams.single.create') }}">
                            {{ esc_html_e('Create Team', 'tournamatch') }}
                        </a>
                    </div>
                @endif
                <div class="trn-clearfix"></div>
                <div class="mt-5 w-full">
                    {!! do_shortcode('[trn-teams-list-table]') !!}
                </div>
            </div>
        </div>
    </div>

@endsection
