@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 py-4 sm:px-4">
        <!-- Añade los estilos y scripts de Swiper -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <style>
            .swiper-container {
                overflow: hidden;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: white;
                background: rgba(0, 0, 0, 0.5);
                width: 30px;
                height: 30px;
                border-radius: 50%;
                transition: all 0.3s ease;
            }

            .swiper-button-next:hover,
            .swiper-button-prev:hover {
                background: rgba(255, 165, 0, 0.8);
            }

            .swiper-button-next::after,
            .swiper-button-prev::after {
                font-size: 16px;
            }

            .swiper-pagination-bullet {
                background: white;
                width: 8px;
                height: 8px;
            }

            .swiper-pagination-bullet-active {
                background: orange;
            }

            /* Estilos para hacer los productos más pequeños */
            .product-slide {
                height: 180px !important;
            }

            .product-slide h4 {
                font-size: 12px !important;
                min-height: 2.5rem !important;
            }

            @media (min-width: 640px) {
                .product-slide {
                    height: 220px !important;
                    width: 200px !important;
                }

                .product-slide h4 {
                    font-size: 14px !important;
                }

                /* Separar Torneos de TCG */
                .item:nth-child(2),
                .item:last-child {
                    margin-left: auto;
                }
            }

            @media (min-width: 1024px) {
                .product-slide {
                    height: 240px !important;
                    width: 220px !important;
                }
            }

            /* Animacion de Cards */
            .expansion-card {
                transition: all 0.3s ease;
                transform: translateY(0);
            }

            .expansion-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            .expansion-card .info-card {
                background: rgba(0, 0, 0, 0.6);
                transition: all 0.3s ease;
            }

            .expansion-card:hover .info-card {
                background: rgba(0, 0, 0, 0.7);
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .expansion-card {
                animation: fadeIn 0.5s ease forwards;
            }

            .expansion-card:nth-child(1) {
                animation-delay: 0.1s;
            }

            .expansion-card:nth-child(2) {
                animation-delay: 0.2s;
            }

            .expansion-card:nth-child(3) {
                animation-delay: 0.3s;
            }

            .expansion-card:nth-child(4) {
                animation-delay: 0.4s;
            }

            .expansion-card:nth-child(5) {
                animation-delay: 0.5s;
            }
        </style>

        <!-- Sección de Categorías Centrada -->
        <div class="relative overflow-hidden py-2">
            <div class="flex flex-col items-center justify-center px-2 sm:flex-row">
                <div class="item order-3 mb-2 mt-3 flex items-center justify-center gap-4 text-sm sm:order-1 sm:mb-0 sm:mt-0 sm:text-base">
                    <a href="https://geekcollector.com/twitch/">
                        <div class="flex cursor-pointer items-center gap-2 text-orange-400">
                            <!-- Indicador "en vivo" -->
                            <span class="relative flex h-3 w-3">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-500 opacity-75"></span>
                                <span class="relative inline-flex h-3 w-3 rounded-full bg-red-600"></span>
                            </span>

                            <span class="text-white hover:text-orange-400">TWITCH</span>
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path
                                    d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z" />
                            </svg>
                        </div>

                    </a>
                </div>
                <div class="item order-1 flex flex-wrap justify-center gap-3 text-sm sm:order-2 sm:text-base">
                    <a href="https://geekcollector.com/product-category/tcg/magic-the-gathering/" class="flex items-center text-white transition hover:text-orange-400">
                        <span>MAGIC</span>
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/pokemon/" class="flex items-center text-white transition hover:text-orange-400">POKÉMON
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/one-piece/" class="flex items-center text-white transition hover:text-orange-400">ONE PIECE
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/lorcana/" class="flex items-center text-white transition hover:text-orange-400">DISNEY LORCANA
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/star-wars/" class="flex items-center text-white transition hover:text-orange-400">STAR WARS
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/digimon/" class="flex items-center text-white transition hover:text-orange-400">DIGIMON
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/product-category/tcg/digimon/" class="flex hidden items-center text-white transition hover:text-orange-400">SUBASTAS
                        <svg class="ml-1 h-3 w-3" fill="#ff8000" viewBox="0 0 52 52">
                            <path d="M8.3,14h35.4c1,0,1.7,1.3,0.9,2.2L27.3,37.4c-0.6,0.8-1.9,0.8-2.5,0L7.3,16.2C6.6,15.3,7.2,14,8.3,14z" />
                        </svg>
                    </a>
                    <a href="https://geekcollector.com/subastas/" class="flex items-center text-orange-400 transition">
                        <span class="text-white hover:text-orange-400">SUBASTAS</span>
                        <svg fill="currentColor" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="ml-1 h-3 w-3" viewBox="796 796 200 200" enable-background="new 796 796 200 200" xml:space="preserve">
                            <g>
                                <path
                                    d="M936.46,868.211c4.939,4.94,12.946,4.938,17.884,0c4.94-4.938,4.941-12.946,0-17.885l-50.619-50.622 c-4.94-4.94-12.947-4.938-17.887,0c-4.939,4.938-4.939,12.946,0,17.885L936.46,868.211z" />
                                <path
                                    d="M817.588,885.841c-4.938-4.94-12.946-4.94-17.884,0c-4.939,4.938-4.941,12.945,0,17.885l50.619,50.619 c4.94,4.94,12.946,4.94,17.887,0c4.94-4.938,4.94-12.946,0-17.886L817.588,885.841z" />
                                <path
                                    d="M989.605,963.929l-75.06-63.993c3.388-3.902,6.598-7.964,9.563-12.216l1.549-2.22c3.202-4.592,2.651-10.82-1.308-14.779 L883.328,829.7c-3.959-3.959-10.187-4.509-14.779-1.307l-3.618,2.523c-13.254,9.244-24.769,20.759-34.014,34.012l-2.524,3.619 c-3.203,4.593-2.653,10.822,1.306,14.78l41.023,41.021c3.959,3.959,10.186,4.51,14.778,1.307l2.22-1.549 c4.25-2.964,8.312-6.172,12.213-9.558l63.994,75.058c3.297,3.867,8.06,6.181,13.136,6.38c5.079,0.202,10.01-1.725,13.603-5.317 c3.595-3.593,5.522-8.523,5.32-13.602C995.785,971.988,993.471,967.227,989.605,963.929z" />
                            </g>
                        </svg>
                    </a>

                    <a href="https://geekcollector.com/torneos/" class="flex items-center text-orange-400 transition">
                        <span class="text-white hover:text-orange-400">CALENDARIO</span>
                        <svg class="ml-1 h-4 w-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                    stroke="#99999" stroke-width="2" stroke-linecap="round"></path>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="item order-2 mt-3 flex items-center justify-center gap-4 text-sm sm:order-3 sm:mt-0 sm:text-base">
                    <a href="https://geekcollector.com/tournaments/">
                        <div class="flex cursor-pointer items-center gap-1 text-orange-400">
                            <span class="text-white hover:text-orange-400">TORNEOS</span>
                            <svg class="h-3 w-4" fill="#ff8000" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M348.375,384.758c-12.811-25.137-32.785-44.594-56.582-54.492v-38.5l0.047-9.133c-0.016,0-0.031,0-0.047,0.004 v-0.242c-11.588,2.262-23.551,3.481-35.791,3.481c-11.369,0-22.476-1.094-33.291-3.055c-0.752-0.152-1.516-0.262-2.264-0.426v0.043 c-0.08-0.016-0.16-0.028-0.24-0.043v47.871c-12.209,5.078-23.393,12.695-33.137,22.293c-0.348,0.34-0.705,0.66-1.049,1.004 c-1.072,1.082-2.1,2.219-3.133,3.348c-0.705,0.77-1.426,1.512-2.115,2.305c-0.61,0.703-1.184,1.442-1.78,2.156 c-1.07,1.289-2.14,2.574-3.168,3.918c-0.088,0.117-0.17,0.238-0.26,0.355c-4.392,5.789-8.406,12.078-11.939,18.875h0.131 c-0.043,0.082-0.09,0.16-0.131,0.238H348.375z" />
                                    <polygon points="115.046,416 115.046,511.371 115.044,511.758 115.046,511.758 115.046,512 396.957,512 396.957,416" />
                                    <path
                                        d="M498.331,29.387c-8.027-9.094-19.447-14.312-31.328-14.312h-47.744V0.27V0.242l0,0V0H92.742v15.074H44.999 c-11.887,0-23.306,5.218-31.336,14.312C3.906,40.442-0.305,56.43,1.775,74.465c0.369,7.922,4.367,49.316,47.211,78.77 c24.732,17.008,48.424,24.629,69.44,27.938c29.008,45.328,79.76,75.398,137.576,75.398c57.805,0,108.558-30.07,137.568-75.398 c21.016-3.305,44.709-10.93,69.445-27.938c42.84-29.453,46.842-70.848,47.211-78.77C512.304,56.43,508.093,40.442,498.331,29.387z" />
                                </g>
                            </svg>
                        </div>
                    </a>

                    <a href="https://geekcollector.com/ladders">
                        <div class="flex cursor-pointer items-center gap-1 text-orange-400">
                            <span class="text-white hover:text-orange-400">LADDER</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="#ff8000" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.93,6.81a1,1,0,0,1-.47-.12L12,6.45l-.46.24a1,1,0,0,1-1.45-1.05l.09-.52L9.8,4.76a1,1,0,0,1,.56-1.7L10.87,3l.23-.47a1,1,0,0,1,1.8,0l.23.47.51.08a1,1,0,0,1,.56,1.7l-.38.36.09.52a1,1,0,0,1-.39,1A1.09,1.09,0,0,1,12.93,6.81Z" />
                                <path
                                    d="M8,16v5a1,1,0,0,1-1,1H3a1,1,0,0,1-1-1V16a1,1,0,0,1,1-1H7A1,1,0,0,1,8,16Zm6-7H10a1,1,0,0,0-1,1V21a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V10A1,1,0,0,0,14,9Zm7,4H17a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h4a1,1,0,0,0,1-1V14A1,1,0,0,0,21,13Z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Banner Hero Responsivo -->
        <div class="relative my-2 aspect-[4/3] w-full overflow-hidden sm:aspect-[16/7] md:aspect-[16/6]">
            <img src="{{ asset('resources/images/banner/Banner_Octubre_01.png') }}" class="absolute h-full w-full object-contain object-center" alt="Banner principal" />
        </div>

        {{-- <div class="bg-white">{{ do_shortcode('[ekc-swiss-system tournament="swup" ranking="true"]') }}</div> --}}

        <!-- Slider TCGs Centrado -->
        <div class="mx-auto mt-2 px-2 py-2">
            <div class="flex flex-wrap justify-center gap-4">
                @php
                    $tcgs = [
                        ['img' => 'Gundam.png', 'name' => 'GUNDAM', 'url' => 'https://geekcollector.com/product-category/tcg/gundam/'],
                        ['img' => 'Shadowverse.png', 'name' => 'SHADOWVERSE', 'url' => 'https://geekcollector.com/product-category/tcg/shadowverse/'],
                        ['img' => 'One Piece.png', 'name' => 'ONE-PIECE', 'url' => 'https://geekcollector.com/product-category/tcg/one-piece/'],
                        ['img' => 'Lorcana.png', 'name' => 'LORCANA', 'url' => 'https://geekcollector.com/product-category/tcg/lorcana/'],
                        ['img' => 'STAR WARS.png', 'name' => 'STAR WARS', 'url' => 'https://geekcollector.com/product-category/tcg/star-wars/'],
                        ['img' => 'Digimon.png', 'name' => 'DIGIMON', 'url' => 'https://geekcollector.com/product-category/tcg/digimon/'],
                        ['img' => 'Dragon Ball.png', 'name' => 'DRAGON BALL', 'url' => 'https://geekcollector.com/product-category/tcg/dragon-ball/'],
                        ['img' => 'Pokémon.png', 'name' => 'POKÉMON', 'url' => 'https://geekcollector.com/product-category/tcg/pokemon/'],
                        ['img' => 'Flesh and Blood.png', 'name' => 'FLESH & BLOOD', 'url' => 'https://geekcollector.com/product-category/tcg/flesh-and-blood/'],
                    ];
                @endphp

                @foreach ($tcgs as $tcg)
                    <a href="{{ $tcg['url'] }}" class="flex flex-col items-center font-light text-white transition hover:text-orange-400">
                        <img class="h-10 w-10 object-contain sm:h-14 sm:w-14" src="{{ asset('resources/images/tcg/' . $tcg['img']) }}" alt="{{ $tcg['name'] }}" />
                        <div class="mt-1 text-xs sm:text-sm">{{ $tcg['name'] }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Slider de Productos Populares - Versión actualizada -->
        <div class="mx-4 mt-12 px-2 py-2">
            <div class="flex flex-col items-center justify-start px-2 sm:flex-row sm:justify-between">
                <div
                    class="mb-4 flex w-fit items-center justify-center rounded-full border-2 border-black bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 px-2 py-0 font-sans text-base font-extrabold tracking-widest sm:mb-0 sm:py-1 lg:px-9 xl:py-3 xl:text-4xl">
                    BEST SELLERS
                </div>
                <div class="space-y-2 text-center text-base font-light tracking-wider text-white sm:text-right md:text-xl xl:text-3xl">
                    <div>LA MEJOR MANERA DE CONSEGUIR</div>
                    <div>LOS PRODUCTOS GEEK QUE MÁS AMAS.</div>
                </div>
            </div>
            @php
                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => 15,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'order' => 'DESC',
                    'meta_query' => [
                        [
                            'key' => '_stock_status',
                            'value' => 'instock',
                            'compare' => '=',
                        ],
                    ],
                    'tax_query' => [
                        [
                            'taxonomy' => 'product_cat',
                            'field' => 'slug', // puedes usar 'id' si prefieres
                            'terms' => ['drinks', 'snacks'], // Slugs de las categorías
                            'operator' => 'NOT IN',
                        ],
                    ],
                ];

                $loop = new WP_Query($args);
            @endphp

            <!-- Slider container -->
            <div class="swiper-container mt-10 px-4 py-4 sm:px-8">
                <!-- Slider wrapper -->
                <div class="swiper-wrapper">
                    @while ($loop->have_posts())
                        @php
                            $loop->the_post();
                            global $product;
                        @endphp
                        <!-- Que no tome productos sin imagen -->
                        @if (has_post_thumbnail($product->get_id()))
                            <!-- Slide -->
                            <div class="swiper-slide">
                                <a href="{{ esc_url($product->get_permalink()) }}" class="block">
                                    <div
                                        class="product-slide group relative flex flex-col items-center justify-center gap-y-1 rounded-2xl border-white bg-black px-1 py-4 shadow-[0_0px_10px_rgba(0,0,0,0)] shadow-white/40 sm:gap-y-2 sm:px-2">
                                        <div style="min-height: calc(2 * 1.5em);" class="ml-1 w-full overflow-hidden text-center font-semibold text-white sm:px-1">
                                            <h4> {{ mb_strtoupper($product->get_name(), 'UTF-8') }} </h4>
                                        </div>
                                        <div class="flex h-full w-full items-center justify-center overflow-hidden rounded-md">
                                            {!! $product->get_image('thumbnail', ['class' => 'h-full w-full object-contain']) !!}
                                        </div>
                                        <div class="ml-1 flex items-start">
                                            <div
                                                class="absolute bottom-2 z-10 -translate-x-1/2 rounded-full px-2 py-1 text-xs font-bold text-black opacity-0 transition-all duration-200 group-hover:bg-orange-600 group-hover:opacity-100 sm:text-sm">
                                                Comprar
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endwhile
                </div>

                <!-- Add navigation buttons -->

                <!-- Add pagination -->

            </div>

        </div>

        <!-- Banner de Membresia -->
        <div class="relative my-2 flex aspect-[4/3] w-full flex-col justify-center overflow-hidden bg-cover bg-center px-6 sm:aspect-[16/7] sm:px-10 md:aspect-[16/6]"
            style="background-image: url('{{ asset('resources/images/memebresias.jpg') }}')">

            <!-- Contenedor del texto -->
            <div class="w-full tracking-widest sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-5/12">
                <div class="text-2xl font-bold text-orange-500 sm:text-3xl md:text-4xl">
                    ÚNETE A LA ALIANZA.
                </div>
                <div class="text-2xl text-white sm:text-3xl md:text-4xl">
                    DESBLOQUEA BENEFICIOS LEGENDARIOS
                </div>
                <div class="mt-3 text-lg text-white sm:mt-5 sm:text-xl">
                    ¡CONOCE NUESTRAS MEMBRESIAS DISPONIBLES!
                </div>

                <!-- Botón -->
                <a href="https://geekcollector.com/membresias/">
                    <div class="mt-5 w-full sm:w-8/12 md:w-7/12 lg:w-6/12">
                        <div
                            class="flex items-center justify-center rounded-full border-2 border-black bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 px-4 py-2 text-center font-sans text-lg font-extrabold sm:text-xl">
                            MÁS INFORMACION
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Carrusel de Ultima Expansion -->
        <div class="mx-4 mt-12 px-2 py-2">
            <div class="flex flex-col items-center justify-start px-2 sm:flex-row sm:justify-between">
                <div
                    class="mb-4 flex w-fit items-center justify-center rounded-full border-2 border-black bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 px-2 py-0 font-sans text-base font-extrabold tracking-widest sm:mb-0 sm:py-1 lg:px-9 xl:py-3 xl:text-4xl">
                    ULTIMA EXPANSIÓN
                </div>
                <div class="space-y-2 text-center text-base font-light tracking-wider text-white sm:text-right md:text-xl xl:text-3xl">
                    <div>MUY PRONTO DISPONIBLE:</div>
                    <div>LO MÁS NUEVO ESTÁ POR LLEGAR.</div>
                </div>
            </div>
            @php
                $tcgs = [
                    [
                        'img' => 'dragonball.png',
                        'tcg' => 'DRAGON-BALL',
                        'name' => 'RIVALS CLASH - [FB06]',
                        'url' => 'https://geekcollector.com/product-category/tcg/dragon-ball/fb06-rivals-clash/',
                    ],
                    [
                        'img' => 'lorcana.png',
                        'tcg' => 'LORCANA',
                        'name' => 'REIGN OF JAFAR',
                        'url' => 'https://geekcollector.com/product-category/tcg/lorcana/reign-of-jafar/',
                    ],
                    [
                        'img' => 'magic_spiderman.jpg',
                        'tcg' => 'MAGIC: THE GATHERING',
                        'name' => 'SPIDERMAN',
                        'url' => 'https://geekcollector.com/product-category/tcg/magic-the-gathering/spiderman/',
                    ],
                    [
                        'img' => 'onepiece_prb_02.png',
                        'tcg' => 'ONE-PIECE',
                        'name' => 'Premium Booster Vol.2 [PRB-02]',
                        'url' => 'https://geekcollector.com/product-category/tcg/one-piece/prb02-premium-booster/',
                    ],
                    [
                        'img' => 'pokemon_megaevo.png',
                        'tcg' => 'POKEMON',
                        'name' => 'Mega Evolution',
                        'url' => 'https://geekcollector.com/product-category/tcg/pokemon/mega01mega-evolutions/',
                    ],
                ];
            @endphp
            <!-- Slider container -->
            <div class="swiper-exp-container mt-10 overflow-hidden">
                <!-- Slider wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($tcgs as $tcg)
                        <!-- Slide -->
                        <div class="swiper-slide gap-6">
                            <div
                                class="expansion-card relative flex h-[320px] w-full flex-col overflow-hidden rounded-2xl sm:max-w-[220px] md:max-w-[200px] lg:max-w-[220px] xl:max-w-[270px]">
                                <!-- Info card -->
                                <div class="info-card z-10 flex h-full flex-col justify-end p-4 text-white">
                                    <div class="text-sm font-bold uppercase tracking-wider sm:text-base">{{ $tcg['tcg'] }}</div>
                                    <div class="mt-1 text-lg font-semibold sm:text-xl">{{ $tcg['name'] }}</div>
                                    <div
                                        class="mt-3 w-fit cursor-pointer rounded-full bg-orange-500 px-4 py-1 text-xs font-bold text-white transition hover:bg-orange-600 sm:text-sm">
                                        <a href="{{ $tcg['url'] }}" class="inline-block">
                                            ORDENAR
                                        </a>
                                    </div>
                                </div>
                                <!-- Image underneath -->
                                <div class="absolute h-full w-full overflow-hidden">
                                    <img src="{{ asset('resources/images/expansions/' . $tcg['img']) }}" alt="{{ $tcg['name'] }}"
                                        class="h-full w-full rounded-2xl object-cover object-center transition duration-500 hover:scale-105">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Banner de Torneos -->
        <div class="relative my-2 mt-12 flex aspect-[4/3] w-full flex-col justify-center overflow-hidden bg-cover bg-center px-2 sm:aspect-[16/7] md:aspect-[16/6] md:px-10"
            style="background-image: url('{{ asset('resources/images/fondo-torneos.jpg') }}')">
            <div class="w-7/12 tracking-widest md:w-3/12">

                <div class="flex flex-wrap justify-center gap-4">
                    @php
                        $tcgs = [
                            ['img' => 'Shadowverse.png'],
                            ['img' => 'One Piece.png'],
                            ['img' => 'Lorcana.png'],
                            ['img' => 'Digimon.png'],
                            ['img' => 'Dragon Ball.png'],
                            ['img' => 'Pokémon.png'],
                        ];
                    @endphp

                    @foreach ($tcgs as $tcg)
                        <img class="h-5 w-5 object-contain sm:h-8 sm:w-8" src="{{ asset('resources/images/tcg/' . $tcg['img']) }}" />
                    @endforeach
                </div>

                <div class="xl mt-4 font-semibold text-white md:text-5xl">
                    ¿ESTÁS LISTO PARA EL <span class="text-orange-500">RETO?</span>
                </div>
                <hr class="mt-5 h-[3px] bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600">
                <div class="mt-5 text-sm text-white md:text-xl">
                    DESCUBRE TU HABILIDAD Y COMPITE CONTRA LOS MEJORES
                </div>

                <a href="#">
                    <div
                        class="mt-5 inline-block rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] transition-all duration-300 hover:from-yellow-300 hover:via-orange-500 hover:to-red-500">
                        <div class="rounded-full bg-black px-4 py-2 text-sm font-bold text-white md:text-lg">
                            <a href="https://geekcollector.com/torneos">MÁS INFORMACIÓN</a>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Ultimos Posts -->
        <div class="mt-12 py-2 md:mx-4 md:px-2">
            <div class="flex flex-col items-center justify-start px-2 sm:flex-row sm:justify-between">
                <div
                    class="justify-left mb-4 flex w-fit items-center rounded-full border-2 border-black bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 px-2 py-0 font-sans text-base font-extrabold tracking-widest sm:mb-0 sm:py-1 lg:px-9 xl:py-3 xl:text-4xl">
                    COMUNIDAD
                </div>
            </div>

            @php
                $posts = [
                    [
                        'img' => 'M1.png',
                        'titulo' => 'Membresías GeekCollector: ¡Sube de Nivel tu Pasión!',
                        'description' => 'En GeekCollector, nos consideramos como un punto de encuentro para quienes amamos los TCG y la cultura geek',
                        'url' => 'https://geekcollector.com/blog-1/',
                    ],
                    [
                        'img' => 'blog3.png',
                        'titulo' => 'Cómo la cultura de los TCG\'s, coleccionables y Funkos han revolucionado al mundo ',
                        'description' => '
                            La cultura geek y coleccionista ha pasado de ser un pasatiempo de nicho a convertirse en un fenómeno global. Lo que antes se limitaba a pequeños grupos de entusiastas que intercambiaban cartas o figuras en convenciones, hoy se ha convertido en una industria inmensa que trasciende generaciones, conecta comunidades y ha transformado la forma en que consumimos el entretenimiento.',
                        'url' => 'https://geekcollector.com/blog-2/',
                    ],
                    [
                        'img' => 'blog2.webp',
                        'titulo' => 'Top 10 Utility Lands',
                        'description' =>
                            'Utility lands are lands that, in addition to producing mana, have some positive effect on your decks. These effects can range from activated abilities, passive effects, or even some',
                        'url' => '',
                    ],
                ];
            @endphp

            <!-- Slider container -->
            <div class="swiper-post-container mt-10 overflow-hidden px-0">
                <!-- Slider wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($posts as $post)
                        <!-- Slide -->
                        <div class="swiper-slide gap-8">
                            <div class="relative flex h-[420px] w-full flex-col sm:min-w-[220px] md:max-w-[200px] lg:max-w-[220px] xl:max-w-[450px]">

                                <!-- Imagen debajo -->
                                <div class="relative h-[220px] w-full overflow-hidden">
                                    <img src="{{ asset('resources/images/blog/' . $post['img']) }}" class="h-full w-full rounded-t-2xl object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                </div>

                                <div class="mt-4 text-white">
                                    <div class="line-clamp-2 overflow-hidden text-xl font-semibold uppercase tracking-wider sm:text-base lg:text-3xl lg:leading-snug">
                                        {{ $post['titulo'] }}
                                    </div>
                                </div>

                                <!-- Boton Ver Mas -->
                                <div class="inline-block">
                                    <a href="{{ $post['url'] }}">
                                        <span class="bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 bg-clip-text text-2xl font-bold text-transparent">
                                            VER MÁS
                                        </span>
                                    </a>
                                </div>

                                <!-- Contenido -->
                                <div class="mt-4 flex flex-col justify-center text-white">
                                    <div class="line-clamp-2 text-lg font-semibold !normal-case sm:text-xl">
                                        {{ $post['description'] }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>

    <!-- Script de Swiper -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper-container', {
                // Optional parameters
                loop: true,
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 16,
                initialSlide: 0,
                rtl: false,


                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // Pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 2
                    },
                    // when window width is >= 768px
                    768: {
                        slidesPerView: 3
                    },
                    // when window width is >= 1024px
                    1024: {
                        slidesPerView: 5
                    }
                }
            });

            const swiperPost = new Swiper('.swiper-post-container', {
                // Optional parameters
                loop: false,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 20,
                initialSlide: 0,
                rtl: false,

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 3,
                        centeredSlides: false,
                        spaceBetween: 16
                    },
                    // when window width is >= 768px
                    768: {
                        slidesPerView: 3,
                        centeredSlides: false,
                        spaceBetween: 20
                    },
                    // when window width is >= 1024px
                    1024: {
                        slidesPerView: 3,
                        centeredSlides: false,
                        spaceBetween: 24
                    }
                }
            });

            const swiperExp = new Swiper('.swiper-exp-container', {
                loop: true,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 20,
                initialSlide: 0,

                // Responsive breakpoints
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        centeredSlides: false,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 3,
                        centeredSlides: false,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 5,
                        centeredSlides: false,
                        spaceBetween: 24,
                    },
                },
            });

        });
    </script>
@endsection
