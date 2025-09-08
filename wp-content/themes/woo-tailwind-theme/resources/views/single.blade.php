@extends('layouts.app')

@section('content')
    @php
        global $product;

        if (!is_a($product, 'WC_Product')) {
            $product = wc_get_product(get_the_ID());
        }

        $post_thumbnail_id = $product->get_image_id();
        $gallery_ids = $product->get_gallery_image_ids();
        
        // Obtener productos relacionados
        $related_ids = wc_get_related_products($product->get_id(), 4);
        $related_products = !empty($related_ids) ? wc_get_products(['include' => $related_ids, 'limit' => 4]) : [];
        
        // Verificar si es un producto de subasta
        $is_auction = method_exists($product, 'get_type') && $product->get_type() === 'auction';
        
        // Métodos específicos para Auctions for WooCommerce
        if ($is_auction) {
            // Obtener información de la subasta
            $current_bid = method_exists($product, 'get_curent_bid') ? $product->get_curent_bid() : 0;
            $start_price = method_exists($product, 'get_start_price') ? $product->get_start_price() : 0;
            $bid_increment = method_exists($product, 'get_increase_bid_value') ? $product->get_increase_bid_value() : 5;
            $reserve_price = method_exists($product, 'get_reserve_price') ? $product->get_reserve_price() : null;
            $buy_now_price = method_exists($product, 'get_buy_now') ? $product->get_buy_now() : null;
            
            // Fechas de la subasta
            $auction_start = method_exists($product, 'get_auction_start_time') ? $product->get_auction_start_time() : null;
            $auction_end = method_exists($product, 'get_auction_end_time') ? $product->get_auction_end_time() : null;
            
            // Estado de la subasta
            $is_finished = method_exists($product, 'is_finished') ? $product->is_finished() : false;
            $is_started = method_exists($product, 'is_started') ? $product->is_started() : false;
            $is_closed = method_exists($product, 'is_closed') ? $product->is_closed() : false;
            
            // Obtener el siguiente valor de puja mínimo
            $min_bid_value = $start_price;
            if ($current_bid > 0) {
                $min_bid_value = $current_bid + $bid_increment;
            }
            
            // Obtener historial de pujas
            $bid_count = method_exists($product, 'get_auction_bid_count') ? $product->get_auction_bid_count() : 0;
        }
    @endphp

    <div class="animate-fadeIn min-h-screen bg-white">
        <div class="container mx-auto px-4 py-12">
            {{-- Contenido principal --}}
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                {{-- Galería con miniaturas --}}
                <div class="flex gap-6">
                    @if ($gallery_ids)
                        <div class="flex w-24 flex-col gap-3">
                            @foreach ($gallery_ids as $image_id)
                                <div
                                    class="transform cursor-pointer overflow-hidden rounded-lg bg-gray-100 transition-all duration-300 hover:-translate-y-1 hover:ring-2 hover:ring-orange-500">
                                    <img src="{{ wp_get_attachment_image_url($image_id, 'thumbnail') }}" alt="{{ get_the_title() }}" class="h-20 w-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex-1 overflow-hidden rounded-xl bg-gray-50 shadow-lg transition-shadow duration-300 hover:shadow-xl">
                        @if ($post_thumbnail_id)
                            <img src="{{ wp_get_attachment_image_url($post_thumbnail_id, 'large') }}" alt="{{ get_the_title() }}"
                                class="animate-zoomIn h-auto max-h-[600px] w-full object-contain p-4">
                        @endif
                    </div>
                </div>

                {{-- Información del producto --}}
                <div class="animate-slideInRight space-y-8">
                    <h1 class="text-4xl font-bold uppercase tracking-wide text-gray-900">{{ $product->get_name() }}</h1>

                    @if ($product->get_rating_count() > 0)
                        <div class="flex items-center">
                            {!! wc_get_rating_html($product->get_average_rating()) !!}
                            <span class="ml-2 text-sm text-gray-600">
                                ({{ $product->get_review_count() }} reseñas)
                            </span>
                        </div>
                    @endif

                    {{-- Mostrar información específica para subastas --}}
                    @if ($is_auction)
                        <div class="auction-info space-y-4 rounded-lg border-2 border-orange-200 bg-orange-50 p-4">
                            <h3 class="text-xl font-bold text-orange-800">SUBASTA EN CURSO</h3>
                            
                            {{-- Precio actual o precio de salida --}}
                            <div class="text-2xl font-bold text-orange-600">
                                @if ($current_bid && $current_bid > 0)
                                    Precio actual: {!! wc_price($current_bid) !!}
                                @else
                                    Precio de salida: {!! wc_price($start_price) !!}
                                @endif
                            </div>
                            
                            {{-- Buy it now price --}}
                            @if ($buy_now_price)
                                <div class="text-xl font-bold text-green-600">
                                    Compra inmediata: {!! wc_price($buy_now_price) !!}
                                </div>
                            @endif
                            
                            {{-- Información de la subasta --}}
                            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                                @if ($start_price)
                                    <div class="text-sm">
                                        <span class="font-semibold">Precio de salida:</span> 
                                        {!! wc_price($start_price) !!}
                                    </div>
                                @endif
                                
                                @if ($bid_increment)
                                    <div class="text-sm">
                                        <span class="font-semibold">Incremento de puja:</span> 
                                        {!! wc_price($bid_increment) !!}
                                    </div>
                                @endif
                                
                                @if ($reserve_price)
                                    <div class="text-sm">
                                        <span class="font-semibold">Precio de reserva:</span> 
                                        {!! wc_price($reserve_price) !!}
                                    </div>
                                @endif
                                
                                @if ($auction_start)
                                    <div class="text-sm">
                                        <span class="font-semibold">Inicio:</span> 
                                        {{ date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($auction_start)) }}
                                    </div>
                                @endif
                                
                                @if ($auction_end)
                                    <div class="text-sm">
                                        <span class="font-semibold">Finaliza:</span> 
                                        {{ date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($auction_end)) }}
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Temporizador de la subasta --}}
                            @if ($auction_end && !$is_finished)
                                <div class="auction-timer mt-4">
                                    <h4 class="font-semibold text-orange-700">Tiempo restante:</h4>
                                    <div id="auction-countdown" class="text-lg font-mono font-bold text-orange-800"
                                         data-end-time="{{ strtotime($auction_end) }}">
                                        Cargando...
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Estado de la subasta --}}
                            <div class="mt-2">
                                @if ($is_finished || $is_closed)
                                    <div class="inline-block rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-800">
                                        SUBASTA FINALIZADA
                                    </div>
                                @elseif ($is_started)
                                    <div class="inline-block rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-800">
                                        SUBASTA ACTIVA
                                    </div>
                                @else
                                    <div class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-sm font-bold text-yellow-800">
                                        PRÓXIMAMENTE
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Formulario de puja --}}
                        @if ((!$is_finished && !$is_closed) && $is_started)
                            <div class="bid-form mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <h4 class="mb-3 text-lg font-semibold">Realizar una puja</h4>
                                
                                @if (is_user_logged_in())
                                    {{-- FORMULARIO CORREGIDO - Usando la estructura exacta del plugin --}}
                                    <form class="auction_form cart" method="post" action="{{ esc_url($product->get_permalink()) }}" enctype="multipart/form-data">
                                        @php 
                                            do_action('before_auction_form');
                                        @endphp
                                        
                                        <input type="hidden" name="place-bid" value="{{ $product->get_id() }}">
                                        <input type="hidden" name="product_id" value="{{ $product->get_id() }}">
                                        
                                        <div class="flex flex-wrap items-center gap-3">
                                            <label for="bid_value" class="font-medium">Tu puja (mín. {!! wc_price($min_bid_value) !!}):</label>
                                            <input type="number" id="bid_value" name="bid_value" 
                                                   class="w-32 rounded border border-gray-300 px-3 py-2"
                                                   step="any"
                                                   min="{{ $min_bid_value }}"
                                                   value="{{ $min_bid_value }}"
                                                   required>
                                            <button type="submit" class="rounded-lg bg-orange-600 px-4 py-2 font-medium text-white hover:bg-orange-700">
                                                Pujar ahora
                                            </button>
                                        </div>
                                        
                                        @php 
                                            // Nonce específico de Auctions for WooCommerce
                                            wp_nonce_field('place-bid', '_wpnonce');
                                        @endphp
                                    </form>
                                    
                                    {{-- Botón de compra inmediata --}}
                                    @if ($buy_now_price)
                                        <div class="mt-4">
                                            <form class="buy_now_form" method="post" action="{{ esc_url($product->get_permalink()) }}" enctype="multipart/form-data">
                                                <input type="hidden" name="buy-now" value="{{ $product->get_id() }}">
                                                <input type="hidden" name="product_id" value="{{ $product->get_id() }}">
                                                <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                                                    Comprar ahora por {!! wc_price($buy_now_price) !!}
                                                </button>
                                                @php wp_nonce_field('buy-now', '_wpnonce'); @endphp
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-sm text-gray-600">
                                        <a href="{{ wp_login_url(get_permalink()) }}" class="text-orange-600 hover:underline">
                                            Inicia sesión
                                        </a> 
                                        para poder pujar en esta subasta.
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        {{-- Historial de pujas --}}
                        @if ($bid_count > 0)
                            <div class="bid-history mt-6 rounded-lg border border-gray-200 bg-white p-4">
                                <h4 class="mb-3 text-lg font-semibold">Historial de pujas ({{ $bid_count }})</h4>
                                <div class="max-h-60 overflow-y-auto">
                                    @php
                                        // Usar la función del plugin para mostrar el historial
                                        if (function_exists('woocommerce_auction_history')) {
                                            woocommerce_auction_history($product->get_id());
                                        } else {
                                            // Fallback: intentar obtener el historial manualmente
                                            $history = method_exists($product, 'get_auction_history') ? $product->get_auction_history() : array();
                                            if (!empty($history)) {
                                                echo '<table class="w-full text-sm">';
                                                echo '<thead><tr><th class="text-left">Usuario</th><th class="text-right">Puja</th><th class="text-right">Fecha</th></tr></thead>';
                                                echo '<tbody>';
                                                foreach ($history as $bid) {
                                                    echo '<tr>';
                                                    echo '<td class="px-2 py-1">' . (isset($bid->userid) ? get_userdata($bid->userid)->display_name : 'Anónimo') . '</td>';
                                                    echo '<td class="px-2 py-1 text-right">' . wc_price($bid->bid) . '</td>';
                                                    echo '<td class="px-2 py-1 text-right">' . date_i18n(get_option('date_format'), strtotime($bid->date)) . '</td>';
                                                    echo '</tr>';
                                                }
                                                echo '</tbody></table>';
                                            } else {
                                                echo '<p class="text-gray-500 text-center">No se puede mostrar el historial de pujas</p>';
                                            }
                                        }
                                    @endphp
                                </div>
                            </div>
                        @else
                            <div class="mt-6 rounded-lg border border-gray-200 bg-white p-4 text-center text-gray-500">
                                Aún no hay pujas para esta subasta
                            </div>
                        @endif
                    @else
                        {{-- Precio normal para productos regulares --}}
                        <div class="text-3xl font-bold text-orange-600">
                            {!! $product->get_price_html() !!}
                        </div>

                        @if ($product->is_on_sale())
                            <div class="inline-block animate-pulse rounded-full bg-purple-100 px-3 py-1 text-sm text-orange-800">
                                ¡OFERTA ESPECIAL!
                            </div>
                        @endif
                    @endif

                    <div class="prose max-w-none text-lg leading-relaxed text-gray-700">
                        {!! apply_filters('woocommerce_short_description', $product->get_short_description()) !!}
                    </div>

                    {{-- Disponibilidad --}}
                    <div class="text-lg">
                        @if ($product->is_in_stock())
                            <span class="flex items-center text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                DISPONIBLE
                            </span>
                        @else
                            <span class="flex items-center text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" viewBox="0 0 20 20" fill="CurrentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                                AGOTADO
                            </span>
                        @endif
                    </div>

                    {{-- Mostrar botón de compra normal o funcionalidad de subasta --}}
                    @if (!$is_auction)
                        {{-- Cantidad + botón de compra para productos normales --}}
                        <form class="cart" action="{{ esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())) }}" method="post"
                            enctype='multipart/form-data'>
                            <div class="flex items-center gap-4 pt-4">
                                {{-- Input de cantidad de WooCommerce --}}
                                {!! woocommerce_quantity_input([], $product, false) !!}

                                {{-- Botón de añadir al carrito --}}
                                <button type="submit" name="add-to-cart" value="{{ $product->get_id() }}"
                                    class="transform rounded-lg bg-orange-600 px-6 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:scale-105 hover:bg-orange-700 hover:shadow-purple-300">
                                    AÑADIR AL CARRITO
                                </button>
                            </div>
                        </form>
                    @elseif ($is_finished || $is_closed)
                        {{-- Botón de compra para el ganador de la subasta --}}
                        @php
                            $current_winner = null;
                            if (method_exists($product, 'get_auction_current_bider')) {
                                $current_winner = $product->get_auction_current_bider();
                            }
                        @endphp
                        
                        @if ($current_winner && $current_winner == get_current_user_id())
                            <div class="winner-notice mt-6 rounded-lg bg-green-100 p-4">
                                <h4 class="text-lg font-semibold text-green-800">¡Felicidades! Has ganado esta subasta.</h4>
                                <form class="cart" method="post" enctype='multipart/form-data'>
                                    <button type="submit" name="add-to-cart" value="{{ $product->get_id() }}"
                                        class="mt-3 rounded-lg bg-green-600 px-6 py-3 font-medium text-white hover:bg-green-700">
                                        COMPRAR PRODUCTO
                                    </button>
                                </form>
                            </div>
                        @elseif ($current_winner)
                            <div class="winner-notice mt-6 rounded-lg bg-blue-100 p-4">
                                <h4 class="text-lg font-semibold text-blue-800">Subasta finalizada. Hay un ganador.</h4>
                            </div>
                        @else
                            <div class="winner-notice mt-6 rounded-lg bg-gray-100 p-4">
                                <h4 class="text-lg font-semibold text-gray-800">Subasta finalizada. No hubo ganador.</h4>
                            </div>
                        @endif
                    @endif

                    {{-- Info de envío --}}
                    <div class="border-t border-gray-200 pt-4 text-sm text-gray-600">
                        <div class="mt-2 flex items-center">
                        </div>
                        <div class="mt-1 flex items-center">
                        </div>
                    </div>

                    {{-- Meta información --}}
                    <div class="space-y-1 pt-4 text-sm text-gray-600">
                        @if ($product->get_sku())
                            <p><span class="font-semibold text-gray-900">SKU:</span> {{ $product->get_sku() }}</p>
                        @endif

                        <p>
                            <span class="font-semibold text-gray-900">CATEGORÍAS:</span>
                            <span class="text-orange-600">{!! wc_get_product_category_list($product->get_id()) !!}</span>
                        </p>

                        @if (wc_get_product_tag_list($product->get_id()))
                            <p>
                                <span class="font-semibold text-gray-900">ETIQUETAS:</span>
                                <span class="text-blue-600">{!! wc_get_product_tag_list($product->get_id()) !!}</span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tabs de detalles del producto --}}
            <div class="mt-16 overflow-hidden rounded-xl bg-gray-50 shadow-lg transition-all duration-300 hover:shadow-xl">
                {!! woocommerce_output_product_data_tabs() !!}
            </div>

            {{-- Productos relacionados con estilos específicos --}}
            @if (!empty($related_products))
                <div class="animate-fadeInUp mt-16 related-products-section">
                    <div class="mt-16">
                        <h2 class="mb-8 text-2xl font-bold uppercase tracking-wider text-gray-900">TAMBIÉN TE PUEDE INTERESAR</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($related_products as $related)
                                <div class="product-card rounded-xl border p-4 shadow hover:shadow-lg">
                                    <a href="{{ get_permalink($related->get_id()) }}">
                                        @if (has_post_thumbnail($related->get_id()))
                                            <img src="{{ get_the_post_thumbnail_url($related->get_id(), 'medium') }}" 
                                                 alt="{{ $related->get_name() }}" 
                                                 class="mx-auto rounded-lg product-image">
                                        @else
                                            <div class="mx-auto rounded-lg bg-gray-200 flex items-center justify-center product-image-placeholder">
                                                <span class="text-gray-500">Sin imagen</span>
                                            </div>
                                        @endif
                                        <h3 class="mt-2 text-lg font-semibold text-center">{{ $related->get_name() }}</h3>
                                        <div class="price-container mt-2 text-center">
                                            {!! $related->get_price_html() !!}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes zoomIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .animate-fadeIn { animation: fadeIn 0.5s ease-out; }
        .animate-slideInRight { animation: slideInRight 0.5s ease-out; }
        .animate-fadeInUp { animation: fadeInUp 0.5s ease-out; }
        .animate-zoomIn { animation: zoomIn 0.5s ease-out; }

        .related-products-section {
            margin-top: 4rem;
            padding: 2rem 0;
            background: transparent;
        }

        .related-products-section h2 {
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.875rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #1f2937;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .related-products-section h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #f97316;
        }

        .product-card {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 1rem;
            border: 1px solid #e5e7eb;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: white;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #f97316;
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin: 0 auto;
            border-radius: 0.5rem;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-image-placeholder {
            width: 100%;
            height: 200px;
            margin: 0 auto;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card h3 {
            margin-top: 1rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            text-align: center;
            flex-grow: 1;
        }

        .price-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .price-container .amount {
            font-weight: bold;
            color: #f97316;
            font-size: 1.125rem;
        }

        .price-container del {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .price-container del .amount {
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .price-container ins {
            background: transparent;
            text-decoration: none;
        }

        .woocommerce-Price-currencySymbol {
            display: inline !important;
            margin-right: 2px;
        }

        .auction-info {
            transition: all 0.3s ease;
        }
        
        .bid-form input:focus {
            outline: none;
            ring: 2px;
            ring-color: #f19f32;
        }
        
        .bid-history table {
            border-collapse: collapse;
        }
        
        .bid-history th,
        .bid-history td {
            border: 1px solid #e5e7eb;
        }
        
        .auction-timer {
            padding: 10px;
            background: #ee9038;
            border-radius: 8px;
            border: 1px solid #e99869;
        }

        @media (max-width: 640px) {
            .related-products-section .grid {
                gap: 1rem;
            }
            
            .product-image, .product-image-placeholder {
                height: 150px;
            }
            
            .product-card h3 {
                font-size: 1rem;
            }
            
            .price-container .amount {
                font-size: 1rem;
            }
            
            .auction-info .grid {
                grid-template-columns: 1fr;
            }
            
            .bid-form .flex {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .bid-form input {
                width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>

    <script>
        window.onload = function() {
            window.scrollTo(0, 0);
            
            const countdownElement = document.getElementById('auction-countdown');
            if (countdownElement) {
                const endTime = parseInt(countdownElement.getAttribute('data-end-time')) * 1000;
                updateCountdown(endTime, countdownElement);
                
                setInterval(() => updateCountdown(endTime, countdownElement), 1000);
            }
        };

        function updateCountdown(endTime, element) {
            const now = new Date().getTime();
            const distance = endTime - now;
            
            if (distance < 0) {
                element.innerHTML = "SUBASTA FINALIZADA";
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            let countdownText = '';
            if (days > 0) countdownText += `${days}d `;
            countdownText += `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            element.innerHTML = countdownText;
        }

        jQuery(function($) {
            $(document.body).on('added_to_cart', function() {
                location.reload();
            });

            $('.auction_form').on('submit', function(e) {
                const bidValue = parseFloat($('#bid_value').val());
                const minBid = parseFloat($('#bid_value').attr('min'));
                
                if (bidValue < minBid) {
                    e.preventDefault();
                    alert(`La puja mínima es ${minBid.toFixed(2)}`);
                    return false;
                }
            });

            $(document).ready(function() {
                $('.price-container').each(function() {
                    var html = $(this).html();
                    html = html.replace(/\n/g, '').replace(/\s+/g, ' ').trim();
                    $(this).html(html);
                });
            });
        });
    </script>

@endsection