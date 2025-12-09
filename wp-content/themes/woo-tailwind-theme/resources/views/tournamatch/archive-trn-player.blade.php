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
        }
    </style>
    <div class="mx-auto mt-10 max-w-7xl p-4 text-white">
        <div class="flex w-full flex-col rounded-lg bg-[#1a1a1a] p-6 shadow-lg">
            <div>
                <h1 class="trn-mb-4 text-4xl">
                    {{ esc_html_e('Players', 'tournamatch') }}
                </h1>
                <div class="w-full">
                    @php
                        echo do_shortcode('[trn-players-list-table]');
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
