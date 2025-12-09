@extends('layouts.app')

@section('content')
    @include('partials.trn-menu')
    <style>
        .trn-players-table-name {
            text-align: left !important
        }

        td {
            text-align: center;
        }

        .dataTables_processing {
            color: black
        }

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

            /* Paginacion centrada */
            div.dataTables_wrapper div.dataTables_paginate ul.trn-pagination {
                justify-content: center !important;
            }

            /* Scroll */
            .trn-table.trn-table-striped.trn-matches-table.dataTable.no-footer {
                width: 100% !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                display: block !important;
                white-space: nowrap;
            }

            /* Apply flex to rows, including thead */
            .trn-matches-table tr {
                display: flex !important;
                width: 100% !important;
                text-align: start !important;
                align-content: center
            }

            /* Extra header para i */
            .trn-matches-table thead tr::after {
                content: '';
                flex: 1 1 0;
            }

            /* Make headers and cells behave consistently */
            .trn-matches-table th,
            .trn-matches-table td {
                flex: 1 1 0 !important;
                min-width: 150px;
                padding: 0.5rem;
                box-sizing: border-box;
                overflow: visible !important;
                text-overflow: ellipsis;
                text-align: start;
            }

            .trn-matches-table td {
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
            .trn-challenges-table-status {
                text-align: end !important;
                padding-inline: 20px;
            }
        }
    </style>
    <div class="mx-auto mt-10 max-w-7xl p-4 text-white">
        <h1 class="trn-mb-4 text-4xl">
            {!! esc_html_e('Matches', 'tournamatch') !!}
        </h1>
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <div>
                {!! do_shortcode('[trn-matches-list-table]') !!}
            </div>
        </div>
    </div>
@endsection
