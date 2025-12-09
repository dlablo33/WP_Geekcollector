@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        @media (max-width: 767px) {

            /* Numero de items */
            .dataTables_length {
                display: none !important;
            }

            /* Busqueda */
            .dataTables_info {
                margin-bottom: 10px;
            }

            /* Busqueda */
            .dataTables_filter {
                margin-bottom: 10px;
            }

            /* scroll */
            .trn-table.trn-table-striped.trn-challenges-table.dataTable.no-footer {
                width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                display: block !important;
                white-space: nowrap;
            }

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
            }

			/* Apply flex to rows, including thead */
            .trn-challenges-table tr {
                display: flex !important;
                width: 100% !important;
                text-align: start !important;
                align-content: center
            }

			/* Make headers and cells behave consistently */
            .trn-challenges-table th,
            .trn-challenges-table td {
                flex: 1 1 0 !important;
                min-width: 150px;
                padding: 0.5rem;
                box-sizing: border-box;
                overflow: visible !important;
                text-overflow: ellipsis;
                text-align: start;
            }

            .trn-challenges-table td {
                margin-right: 2rem;
            }

			/* Icons de sort abajo */
            table.trn-table.dataTable thead .sorting::before {
                right: 4.5em !important;
                top: 0.5em !important;
            }

            /* Icons de sort arriba */
            table.trn-table.dataTable thead .sorting::after {
                right: 5em !important;
                top: 0.5em !important;
            }

			/* Boton de informacion */
            .trn-challenges-table-actions {
                text-align: end !important;
            }
        }
    </style>
    <div class="mx-auto mt-10 min-h-[70vh] max-w-7xl px-6 text-white">
        <div>
            <h1 class="trn-mb-4 text-2xl">
                {{ esc_html_e('Challenges', 'tournamatch') }}
                @if (is_user_logged_in())
                    <div class="trn-float-right">
                        <a href="{{ trn_esc_route_e('challenges.single.create') }}" class="trn-button">
                            {{ esc_html_e('New Challenge', 'tournamatch') }}
                        </a>
                    </div>
                @endif
            </h1>
            <div class="trn-clearfix"></div>
            {!! do_shortcode('[trn-challenges-list-table]') !!}
        </div>
    </div>
@endsection
