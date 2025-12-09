@extends('layouts.app')

@section('content')
    <!-- Logica de min y max -->
    @php
        $max_price = 0;
        $min_price = PHP_FLOAT_MAX;

        $search_term = htmlspecialchars_decode(get_search_query());

        $all_search_results = new WP_Query([
            's' => $search_term,
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'ignore_price_filter' => true,
        ]);

        if ($all_search_results->have_posts()) {
            foreach ($all_search_results->posts as $product_id) {
                $product = wc_get_product($product_id);
                if ($product) {
                    $price = $product->get_price();
                    $max_price = max($max_price, (float) $price);
                    $min_price = min($min_price, (float) $price);
                }
            }
            wp_reset_postdata();
        } else {
            $min_price = 0;
        }
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/nouislider@latest/dist/nouislider.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@latest/dist/nouislider.min.css">
    <!-- Hero de búsqueda con animación mejorada -->
    <div class="animated-gradient relative overflow-hidden py-16 text-white">
        <div class="absolute inset-0 z-0">
            <div class="animate-pulse-slow absolute inset-0 bg-gradient-to-r from-orange-500/20 via-orange-600/10 to-transparent"></div>
            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1633613286848-e6f43bbafb8d?q=80&w=1470&auto=format&fit=crop')] bg-cover bg-center opacity-10 mix-blend-overlay">
            </div>
        </div>

        <div class="container relative z-10 mx-auto px-4 text-center">
            <h2 class="animate-fade-in-down mb-6 text-4xl font-bold uppercase md:text-5xl">
                Explora todos los resultados de
            </h2>
            <span
                class="mt-2 inline-block transform rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-8 py-3 text-xl font-bold tracking-wide text-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-orange-500/30">
                {!! get_search_query() !!}
            </span>
        </div>
    </div>

    <!-- Filtros y resultados -->
    <div class="container mx-auto grid grid-cols-1 gap-8 px-4 py-12 lg:grid-cols-4">

        <!-- Sidebar de filtros - Diseño premium -->
        <aside class="lg:col-span-1">
            <div class="animate-slide-in-left sticky top-24 space-y-8">
                <!-- Filtro de precio - Estilo mejorado -->
                <div class="group rounded-2xl border-2 border-gray-800 bg-gray-900 p-6 shadow-2xl transition-all duration-500 hover:shadow-orange-500/10">
                    <div class="mb-4 flex items-center justify-between">
                        <h4 class="flex items-center text-lg font-bold uppercase text-orange-500">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Rango de Precios
                        </h4>
                        <span class="animate-pulse rounded-full bg-orange-500/10 px-2 py-1 text-xs text-orange-400">Filtrar</span>
                    </div>
                    <div id="price-slider" class="my-6"></div>
                    <div class="price-filter-wrapper max-w-full text-white">

                        <form method="GET" id="rangoPrecio" action="" class="space-y-4">
                            <div class="flex w-full items-center gap-2">
                                <input type="hidden" name="s" value="{{ $_GET['s'] }}">
                                <input type="hidden" name="post_type" value="{{ $_GET['post_type'] }}">
                                <input type="text" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Mín"
                                    class="w-1/2 rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-orange-500 focus:ring-orange-500">

                                <input type="text" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Máx"
                                    class="w-1/2 rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-orange-500 focus:ring-orange-500">
                            </div>

                            <button type="submit"
                                class="w-full rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-5 py-2 text-sm font-bold uppercase text-white shadow transition-all hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/30">
                                Aplicar Filtro
                            </button>
                        </form>
                        @if (isset($_GET['min_price']) || isset($_GET['max_price']))
                            <form action="">
                                <input type="hidden" name="s" value="{{ $_GET['s'] }}">
                                <input type="hidden" name="post_type" value="{{ $_GET['post_type'] }}">
                                <button
                                    class="mt-4 w-full cursor-pointer rounded-full bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-2 text-sm font-bold uppercase text-white shadow transition-all hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/30">
                                    Reset
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Filtro de categorías - Diseño acordeón premium -->
                <div class="rounded-2xl border-2 border-gray-800 bg-gray-900 p-6 shadow-2xl transition-all duration-500 hover:shadow-orange-500/10">
                    <div class="mb-4 flex items-center justify-between">
                        <h4 class="flex items-center text-lg font-bold uppercase text-orange-500">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            Expansiones
                        </h4>
                        <?php
                        $product_categories = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'parent' => 0,
                            'orderby' => 'name',
                        ]);
                        $category_count = is_array($product_categories) ? count($product_categories) : 0;
                        ?>
                        <span class="animate-pulse rounded-full bg-orange-500/10 px-2 py-1 text-xs text-orange-400">
                            <?php echo $category_count; ?> categorías
                        </span>
                    </div>

                    <?php
                    if (!empty($product_categories) && is_array($product_categories)) {
                        echo '<ul class="space-y-3 accordion-categories">';
                        foreach ($product_categories as $category) {
                            $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $category->term_id]);
                            $has_children = !empty($children);
                    
                            echo '<li class="' . ($has_children ? 'has-children' : '') . ' rounded-lg overflow-hidden transition-all duration-300">';
                    
                            if ($has_children) {
                                echo '<div class="category-toggle flex justify-between items-center p-3 bg-gray-800/50 hover:bg-gray-800 cursor-pointer transition-all duration-300 group">';
                                echo '<span class="font-medium text-white group-hover:text-orange-400 transition-colors">' . esc_html($category->name) . '</span>';
                                echo '<svg class="w-5 h-5 transform transition-transform duration-300 text-orange-500 group-hover:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
                                echo '</svg>';
                                echo '</div>';
                    
                                echo '<ul class="subcategories pl-6 pr-3 bg-gray-900/80 hidden transition-all duration-500 overflow-hidden max-h-0">';
                                foreach ($children as $child) {
                                    echo '<li class="py-2 border-b border-gray-800 last:border-0">';
                                    echo '<a href="' . esc_url(get_term_link($child)) . '" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors group">';
                                    echo '<span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></span>';
                                    echo esc_html($child->name);
                                    echo '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<a href="' . esc_url(get_term_link($category)) . '" class="flex items-center p-3 bg-gray-800/50 hover:bg-gray-800 transition-all duration-300 group">';
                                echo '<span class="font-medium text-white group-hover:text-orange-400 transition-colors">' . esc_html($category->name) . '</span>';
                                echo '</a>';
                            }
                    
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p class="text-gray-400 text-sm py-3">No se encontraron categorías</p>';
                    }
                    ?>
                </div>
            </div>
        </aside>

        <!-- Grid de productos - Diseño premium -->
        <section class="lg:col-span-3">
            @if (have_posts())
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @php $index = 0 @endphp
                    @while (have_posts())
                        @php
                            the_post();
                            $index++;
                        @endphp
                        <div class="product-card animate-fade-in-up transform overflow-hidden rounded-2xl border-2 border-gray-800 bg-gray-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/30 hover:shadow-2xl"
                            style="animation-delay: {{ $index * 0.05 }}s">
                            <div class="relative">
                                <a href="{{ get_permalink() }}" class="group block overflow-hidden">
                                    @if (has_post_thumbnail())
                                        <div class="aspect-w-1 aspect-h-1">
                                            {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110']) !!}
                                        </div>
                                    @else
                                        <div class="flex h-64 w-full items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                                            <svg class="h-16 w-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute inset-0 flex items-end bg-gradient-to-t from-black/70 to-transparent p-6 opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                                        <span
                                            class="inline-block translate-y-3 transform rounded-full bg-orange-600 px-4 py-2 text-sm font-bold text-white transition-transform duration-500 group-hover:translate-y-0">
                                            Ver Detalles
                                        </span>
                                    </div>
                                </a>

                                <!-- Badge de oferta/destacado -->
                                <div class="absolute right-4 top-4">
                                    @if (wc_get_product(get_the_ID())->is_on_sale())
                                        <span class="animate-pulse-fast rounded-full bg-orange-600 px-3 py-1 text-xs font-bold text-white shadow-md">
                                            ¡Oferta!
                                        </span>
                                    @elseif(wc_get_product(get_the_ID())->is_featured())
                                        <span class="rounded-full bg-amber-500 px-3 py-1 text-xs font-bold text-gray-900 shadow-md">
                                            Destacado
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="mb-3 flex items-start justify-between">
                                    <h3 class="text-lg font-bold text-white transition-colors hover:text-orange-400">
                                        <a href="{{ get_permalink() }}">{!! get_the_title() !!}</a>
                                    </h3>
                                    <!-- Rating -->
                                    <div class="flex items-center rounded-full bg-gray-800 px-2 py-1">
                                        <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="ml-1 text-xs font-bold text-white">4.8</span>
                                    </div>
                                </div>

                                <p class="mb-4 line-clamp-2 text-sm text-gray-400">{{ get_the_excerpt() }}</p>

                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-xl font-bold text-orange-500">
                                            {!! wc_get_product(get_the_ID())->get_price_html() !!}
                                        </span>
                                        @if (wc_get_product(get_the_ID())->is_on_sale())
                                            <span class="text-xs text-gray-400 line-through">
                                                {!! wc_get_product(get_the_ID())->get_regular_price() !!}
                                            </span>
                                        @endif
                                    </div>

                                    <button
                                        class="add-to-cart flex transform items-center rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-4 py-2 text-sm font-bold text-white shadow transition-all duration-300 hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/20"
                                        data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr(wc_get_product(get_the_ID())->get_sku()); ?>">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Añadir
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endwhile
                </div>

                <!-- Paginación mejorada -->
                <div class="animate-fade-in class mt-16">
                    <div class="flex items-center justify-center space-x-2">
                        {!! paginate_links([
                            'prev_text' => __('<span class="text-orange-500 ">&larr; Anterior</span>'),
                            'next_text' => __('<span class="text-orange-500">Siguiente &rarr;</span>'),
                            'page-numbers' => __('<a class="text-black">'),
                            'type' => 'list',
                        ]) !!}
                    </div>
                </div>
            @else
                <div class="animate-fade-in py-20 text-center">
                    <div class="inline-block rounded-2xl border-2 border-gray-800 bg-gray-900 p-6 shadow-xl">
                        <svg class="mx-auto h-20 w-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-6 text-2xl font-bold text-white">No se encontraron resultados</h3>
                        <p class="mx-auto mt-3 max-w-md text-gray-400">Lo sentimos, no encontramos productos que coincidan con tu búsqueda.</p>
                        <a href="{{ home_url('/shop') }}"
                            class="mt-6 inline-block transform rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-8 py-3 text-lg font-bold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-orange-500 hover:to-orange-600">
                            Explorar Todos los Productos
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </div>

    <!-- Estilos personalizados -->
    <style>
        .animated-gradient {
            background: linear-gradient(-45deg,
                    rgba(254, 240, 138, 0.7),
                    rgba(234, 88, 12, 0.7),
                    rgba(220, 38, 38, 0.7),
                    rgba(234, 88, 12, 0.7));
            background-size: 400% 400%;
            animation: gradientMove 18s ease-in-out infinite alternate,
                pulseLight 6s ease-in-out infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 50% 100%;
            }

            50% {
                background-position: 100% 50%;
            }

            75% {
                background-position: 50% 0%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes pulseLight {

            0%,
            100% {
                filter: brightness(1);
            }

            50% {
                filter: brightness(1.15);
            }
        }

        /* Animaciones personalizadas */
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-in-left {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.2;
            }

            50% {
                opacity: 0.3;
            }
        }

        @keyframes pulse-fast {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.8s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.6s ease-out forwards;
        }

        .animate-bounce-in {
            animation: bounce-in 0.8s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .animate-pulse-fast {
            animation: pulse-fast 1s ease-in-out infinite;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Estilos para el acordeón de categorías */
        .accordion-categories li.has-children.active .subcategories {
            display: block;
            max-height: 1000px;
        }

        /* Estilos para el filtro de precios */
        .price-filter-wrapper .ui-slider {
            height: 6px !important;
            margin-bottom: 20px !important;
        }

        .price-filter-wrapper .ui-slider .ui-slider-range {
            background-color: #f97316 !important;
            height: 6px !important;
        }

        .price-filter-wrapper .ui-slider .ui-slider-handle {
            width: 18px !important;
            height: 18px !important;
            background: #f97316 !important;
            border-radius: 50% !important;
            border: none !important;
            top: -6px !important;
            margin-left: -9px !important;
            cursor: pointer !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }

        .price-filter-wrapper .price_slider_amount button {
            background: #f97316 !important;
            color: white !important;
            border: none !important;
            padding: 10px 20px !important;
            border-radius: 9999px !important;
            font-weight: bold !important;
            text-transform: uppercase !important;
            font-size: 12px !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
        }

        .price-filter-wrapper .price_slider_amount button:hover {
            background: #ea580c !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(249, 115, 22, 0.3) !important;
        }

        .price-filter-wrapper .price_label {
            color: #f97316 !important;
            font-size: 14px !important;
            font-weight: bold !important;
            text-align: center !important;
            margin-bottom: 15px !important;
        }

        /* Estilos para las cards de productos */
        .product-card {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .product-card:hover {
            box-shadow: 0 20px 25px -5px rgba(249, 115, 22, 0.1), 0 10px 10px -5px rgba(249, 115, 22, 0.04);
        }

        /* Paginación */
        .page-numbers {
            display: flex;
            gap: 8px;
            align-items: center,
        }

        .page-numbers li {
            display: flex;
        }

        .page-numbers a,
        .dots,
        .current {
            padding: 6px 12px;
            border-radius: 9999px;
            border-style: solid;
            border-color: white;
            transition: all 0.3s ease;
            background-color: #1E2939;
            color: #f97316;
        }

        .page-numbers a:hover {
            background: #f97316 !important;
            color: white !important;
            border-radius: 9999px;
        }

        .page-numbers .current {
            background: #f97316;
            color: white;
            font-weight: bold;
        }

        /* Mejoras generales */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom Style noUiSlider */
        /* Barra Slider */
        .noUi-connect {
            background: linear-gradient(to right, #ea580c, #f97316) !important;
        }

        /* Botones Arrastrables */
        .noUi-handle {
            background: linear-gradient(to bottom, #ea580c, #f97316) !important;
            border: 2px solid #fff !important;
            box-shadow: 0 2px 6px rgba(234, 88, 12, 0.4) !important;
        }

        .noUi-handle:before,
        .noUi-handle:after {
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .noUi-target {
            background: #374151 !important;
            border: none !important;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3) !important;
        }

        .noUi-handle:hover {
            background: linear-gradient(to bottom, #dc2626, #ea580c) !important;
            cursor: grab;
        }

        .noUi-handle:active {
            cursor: grabbing;
        }
    </style>

    <!-- Scripts para interactividad -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Acordeón de categorías
            const categoryToggles = document.querySelectorAll('.category-toggle');

            categoryToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const parentLi = this.closest('li');
                    const submenu = parentLi.querySelector('.subcategories');

                    // Cerrar otros items abiertos
                    document.querySelectorAll('.accordion-categories li.has-children.active').forEach(item => {
                        if (item !== parentLi) {
                            item.classList.remove('active');
                            item.querySelector('.subcategories').style.maxHeight = '0';
                        }
                    });

                    // Alternar el item actual
                    parentLi.classList.toggle('active');

                    if (parentLi.classList.contains('active')) {
                        submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    } else {
                        submenu.style.maxHeight = '0';
                    }
                });
            });

            // 2. Botones "Añadir al carrito" con recarga de página
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                // Efecto hover con animación
                button.addEventListener('mouseenter', function() {
                    this.querySelector('svg').classList.add('animate-spin');
                });

                button.addEventListener('mouseleave', function() {
                    this.querySelector('svg').classList.remove('animate-spin');
                });

                // Click para añadir al carrito
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product_id');
                    const originalText = this.innerHTML;

                    // Mostrar estado de carga
                    this.innerHTML =
                        '<svg class="animate-spin w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Añadiendo...';
                    this.disabled = true;

                    // AJAX para añadir al carrito
                    jQuery.ajax({
                        type: 'POST',
                        url: wc_add_to_cart_params.ajax_url,
                        data: {
                            action: 'woocommerce_add_to_cart',
                            product_id: productId,
                            quantity: 1
                        },
                        success: function(response) {
                            // Si es producto variable, redirigir a la página del producto
                            if (response.error && response.product_url) {
                                window.location.href = response.product_url;
                                return;
                            }

                            // Recargar la página para actualizar el carrito
                            window.location.reload();
                        },
                        error: function() {
                            // Mostrar error y restaurar botón
                            button.innerHTML = 'Error! Intenta nuevamente';
                            setTimeout(() => {
                                button.innerHTML = originalText;
                                button.disabled = false;
                            }, 2000);
                        }
                    });
                });
            });

            // 3. Estilizar el slider de precios
            const waitForPriceSlider = setInterval(() => {
                const priceSlider = document.querySelector('.price_slider');
                if (priceSlider) {
                    clearInterval(waitForPriceSlider);

                    // Aplicar estilo naranja a los controles
                    const sliderHandles = document.querySelectorAll('.ui-slider-handle');
                    sliderHandles.forEach(handle => {
                        handle.style.backgroundColor = '#f97316';
                        handle.style.borderColor = '#f97316';
                    });

                    const sliderRange = document.querySelector('.ui-slider-range');
                    if (sliderRange) {
                        sliderRange.style.backgroundColor = '#f97316';
                    }
                }
            }, 100);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('price-slider');
            if (!slider) return;

            noUiSlider.create(slider, {
                start: [{{ $_GET['min_price'] ?? $min_price }}, {{ $_GET['max_price'] ?? $max_price }}],
                connect: true,
                step: 100,
                margin: 100,
                range: {
                    'min': {{ $min_price }},
                    'max': {{ $max_price }}
                }
            });

            const minInput = document.getElementById('min_price');
            const maxInput = document.getElementById('max_price');

            slider.noUiSlider.on('update', (values, handle) => {
                if (handle === 0) minInput.value = Math.round(values[0]);
                if (handle === 1) maxInput.value = Math.round(values[1]);
            });

            // Add custom classes to slider elements for better styling
            slider.noUiSlider.on('create', function() {
                // Add custom class to the connect element
                const connect = slider.querySelector('.noUi-connect');
                if (connect) {
                    connect.classList.add('bg-gradient-to-r', 'from-orange-600', 'to-orange-500');
                }

                // Add custom classes to handles
                const handles = slider.querySelectorAll('.noUi-handle');
                handles.forEach(handle => {
                    handle.classList.add('bg-gradient-to-b', 'from-orange-600', 'to-orange-500', 'border-2', 'border-white', 'shadow-md',
                        'shadow-orange-500/40');
                });
            });
        });
    </script>
@endsection
