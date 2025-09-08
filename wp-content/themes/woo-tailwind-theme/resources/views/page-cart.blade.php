@extends('layouts.app')

@section('content')
    @php
        $cart = function_exists('WC') ? WC()->cart : null;
    @endphp

    <div class="min-h-screen bg-white px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            {{-- Encabezado animado --}}
            <div class="animate-fade-in-up mb-12 text-center" style="animation-delay: 0.1s">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                    <span class="block">TU CARRITO</span>
                    <span class="block text-orange-500">DE COMPRAS</span>
                </h1>
                <div class="animate-scale-x mx-auto mt-4 h-1 w-24 bg-orange-500" style="animation-delay: 0.3s"></div>
            </div>

            @if (!$cart || $cart->is_empty())
                {{-- Carrito vacío con animación --}}
                <div class="animate-bounce-in py-16 text-center">
                    <div class="mb-6 inline-block rounded-full bg-orange-100 p-6">
                        <svg class="h-20 w-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-2xl font-medium text-gray-900">Tu carrito está vacío</h3>
                    <p class="mt-2 text-gray-500">Comienza a agregar productos para continuar</p>
                    <div class="my-6">
                        <a href="{{ wc_get_page_permalink('shop') }}"
                            class="inline-flex transform items-center rounded-full border border-transparent bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-3 text-lg font-medium text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-orange-600 hover:to-orange-700 hover:shadow-orange-500/20">
                            Explorar productos
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                    @php do_action('woocommerce_cart_is_empty'); @endphp
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    {{-- LISTA DE PRODUCTOS --}}
                    <div class="overflow-hidden rounded-2xl bg-white shadow-xl transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl lg:col-span-2">
                        <form class="woocommerce-cart-form" action="{{ wc_get_cart_url() }}" method="post">
                            {{-- Encabezado de la tabla --}}
                            <div class="grid grid-cols-12 gap-4 border-b bg-gradient-to-r from-orange-50 to-gray-50 px-6 py-4">
                                <div class="col-span-12 text-sm font-bold uppercase text-gray-700 md:col-span-6">Artículo</div>
                                <div class="col-span-2 hidden text-center text-sm font-bold uppercase text-gray-700 md:block">Precio</div>
                                <div class="col-span-2 hidden text-center text-sm font-bold uppercase text-gray-700 md:block">Cantidad</div>
                                <div class="col-span-2 hidden text-right text-sm font-bold uppercase text-gray-700 md:block">Total</div>
                            </div>

                            {{-- Productos --}}
                            <div class="divide-y divide-gray-200">
                                @foreach ($cart->get_cart() as $cart_item_key => $cart_item)
                                    @php
                                        $product = $cart_item['data'];
                                        $qty = $cart_item['quantity'];
                                        $permalink = $product && $product->is_visible() ? $product->get_permalink() : '';
                                        $thumbnail = $product->get_image('woocommerce_thumbnail', [
                                            'class' =>
                                                'w-20 h-20 object-cover rounded-lg border-2 border-white shadow-md group-hover:border-orange-200 transition-all duration-300',
                                        ]);
                                    @endphp

                                    <div class="animate-fade-in group grid grid-cols-2 items-center gap-4 px-6 py-6 transition-colors duration-300 hover:bg-orange-50/30"
                                        style="animation-delay: {{ $loop->index * 0.05 }}s">
                                        {{-- Imagen y nombre --}}
                                        <div class="col-span-1 flex items-center space-x-4">
                                            <div class="relative">
                                                @if ($permalink)
                                                    <a href="{{ $permalink }}"
                                                        class="block transform transition-all duration-300 hover:scale-105">{!! $thumbnail !!}</a>
                                                @else
                                                    <div class="transform transition-all duration-300 hover:scale-105">{!! $thumbnail !!}</div>
                                                @endif
                                                <button onclick="removeCartItem('{{ $cart_item_key }}')"
                                                    class="absolute -right-2 -top-2 transform rounded-full bg-red-500 p-1 text-white opacity-0 shadow-lg transition-opacity duration-300 hover:scale-110 hover:bg-red-600 hover:shadow-red-500/30 group-hover:opacity-100"
                                                    aria-label="{{ sprintf(__('Eliminar %s', 'woocommerce'), $product->get_name()) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div>
                                                @if ($permalink)
                                                    <a href="{{ $permalink }}"
                                                        class="text-sm font-medium text-gray-900 transition-colors hover:text-orange-600 md:text-lg">{{ $product->get_name() }}</a>
                                                @else
                                                    <span class="text-sm font-medium text-gray-900 md:text-lg">{{ $product->get_name() }}</span>
                                                @endif
                                                <p class="mt-1 text-sm text-gray-500">
                                                    @php echo wc_get_formatted_cart_item_data($cart_item); @endphp
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-span-1 flex flex-col md:block">
                                            <div class="grid grid-cols-1 md:grid-cols-6">
                                                {{-- Precio --}}
                                                <div class="col-span-1 hidden text-center md:col-span-2 md:col-start-1 md:block">
                                                    <span class="font-medium text-gray-900">{!! wc_price($product->get_price()) !!}</span>
                                                </div>
                                                {{-- Cantidad --}}
                                                <div class="col-span-1 mb-2 flex flex-col justify-center md:col-span-2 md:col-start-3 md:mb-0">
                                                    <div
                                                        class="quantity-selector flex w-auto items-center overflow-hidden rounded-lg border border-gray-300 shadow-sm md:w-fit">
                                                        <button type="button"
                                                            class="quantity-btn minus bg-gray-100 px-3 py-1 text-gray-600 transition-colors duration-200 hover:bg-gray-200"
                                                            data-key="{{ $cart_item_key }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                        <input type="text" name="cart[{{ $cart_item_key }}][qty]" value="{{ $qty }}" min="1"
                                                            max="{{ $product->get_max_purchase_quantity() }}"
                                                            class="min-w-0 flex-1 border-0 bg-white text-center focus:outline-none focus:ring-0 md:w-12" aria-label="Cantidad"
                                                            data-key="{{ $cart_item_key }}" />
                                                        <button type="button"
                                                            class="quantity-btn plus bg-gray-100 px-3 py-1 text-gray-600 transition-colors duration-200 hover:bg-gray-200"
                                                            data-key="{{ $cart_item_key }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- Subtotal --}}
                                                <div class="col-span-1 text-center md:col-span-2 md:col-start-5 md:text-right">
                                                    <span class="font-medium text-gray-900">{!! WC()->cart->get_product_subtotal($product, $qty) !!}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Acciones --}}
                            <div
                                class="flex flex-col items-center justify-between space-y-4 border-t bg-gradient-to-r from-orange-50 to-gray-50 px-6 py-4 sm:flex-row sm:space-y-0">
                                <a href="{{ wc_get_page_permalink('shop') }}"
                                    class="inline-flex items-center text-orange-600 transition-colors hover:text-orange-800 md:font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Continuar comprando
                                </a>

                                <button type="submit" name="update_cart" value="1" id="update_cart"
                                    class="hidden transform rounded-full border border-gray-300 bg-white px-6 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all duration-300 hover:scale-105 hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 md:block">
                                    Actualizar carrito
                                </button>
                            </div>

                            {!! wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce', true, false) !!}
                        </form>
                    </div>

                    {{-- RESUMEN / CUPÓN / PAGAR --}}
                    <div class="space-y-6">
                        {{-- Cupón --}}
                        @if (wc_coupons_enabled())
                            <div class="hidden overflow-hidden rounded-2xl bg-white shadow-xl transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl md:block">
                                <div class="border-b bg-gradient-to-r from-orange-50 to-gray-50 px-6 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">Aplicar cupón</h3>
                                </div>
                                <div class="px-6 py-4">
                                    <form action="{{ wc_get_cart_url() }}" method="post" class="space-y-4">
                                        <div>
                                            <label for="coupon_code" class="mb-1 block text-sm font-medium text-gray-700">Ingresa tu código</label>
                                            <div class="mt-1 flex overflow-hidden rounded-lg shadow-sm">
                                                <input id="coupon_code" name="coupon_code" type="text"
                                                    class="block w-full flex-1 rounded-none rounded-l-lg border border-gray-300 px-4 py-3 focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                                    placeholder="Ej: DESCUENTO20">
                                                <button type="submit" name="apply_coupon" value="{{ esc_attr__('Aplicar cupón', 'woocommerce') }}"
                                                    class="inline-flex items-center rounded-r-lg border border-transparent bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-3 text-sm font-medium text-white shadow-md transition-all duration-300 hover:from-orange-600 hover:to-orange-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                                    Aplicar
                                                </button>
                                            </div>
                                        </div>
                                        {!! wp_nonce_field('apply-coupon', 'security', true, false) !!}
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- Resumen del pedido --}}
                        <div class="overflow-hidden rounded-2xl bg-white shadow-xl transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl">
                            <div class="border-b bg-gradient-to-r from-orange-50 to-gray-50 px-6 py-4">
                                <h3 class="text-lg font-medium text-gray-900">Resumen del pedido</h3>
                            </div>
                            <div class="space-y-4 px-6 py-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Productos ({{ $cart->get_cart_contents_count() }})</span>
                                    <span class="font-medium">{!! wc_price($cart->get_cart_contents_total()) !!}</span>
                                </div>

                                @foreach ($cart->get_coupons() as $code => $coupon)
                                    <div class="flex justify-between text-green-600">
                                        <span>{{ wc_cart_totals_coupon_label($coupon) }}</span>
                                        <span>{!! wc_cart_totals_coupon_html($coupon) !!}</span>
                                    </div>
                                @endforeach

                                <div class="mt-4 flex justify-between border-t border-gray-200 pt-4 text-lg font-bold">
                                    <span>Total</span>
                                    <span class="text-orange-600">{!! wc_price($cart->get_total('edit')) !!}</span>
                                </div>

                                <a href="{{ wc_get_checkout_url() }}"
                                    class="block w-full transform rounded-full border border-transparent bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 text-center text-lg font-bold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-orange-600 hover:to-orange-700 hover:shadow-orange-500/30 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                    Proceder al pago
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 inline-block h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Métodos de pago --}}
                        <div class="overflow-hidden rounded-2xl bg-white shadow-xl transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl">
                            <div class="border-b bg-gradient-to-r from-orange-50 to-gray-50 px-6 py-4">
                                <h3 class="text-lg font-medium text-gray-900">Métodos de pago</h3>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-4 gap-3">
                                    <div
                                        class="flex items-center justify-center rounded-lg border bg-gray-50 p-3 shadow-sm transition-colors duration-300 hover:bg-white hover:shadow-md">
                                        <img src="@asset('images/payment/visa.png')" alt="Visa" class="h-8 object-contain"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/1280px-Visa_Inc._logo.svg.png'">
                                    </div>
                                    <div
                                        class="flex items-center justify-center rounded-lg border bg-gray-50 p-3 shadow-sm transition-colors duration-300 hover:bg-white hover:shadow-md">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png"
                                            alt="Mastercard" class="h-8 object-contain">
                                    </div>
                                    <div
                                        class="flex items-center justify-center rounded-lg border bg-gray-50 p-3 shadow-sm transition-colors duration-300 hover:bg-white hover:shadow-md">
                                        <img src="@asset('images/payment/paypal.png')" alt="PayPal" class="h-8 object-contain"
                                            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/1280px-PayPal.svg.png'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            /* Animaciones personalizadas */
            @keyframes fade-in-up {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes scale-x {
                0% {
                    transform: scaleX(0);
                }

                100% {
                    transform: scaleX(1);
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

            @keyframes fade-in {
                0% {
                    opacity: 0;
                    transform: translateY(10px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.6s ease-out forwards;
            }

            .animate-scale-x {
                animation: scale-x 0.6s ease-out forwards;
            }

            .animate-bounce-in {
                animation: bounce-in 0.6s ease-out forwards;
            }

            .animate-fade-in {
                animation: fade-in 0.6s ease-out forwards;
            }

            /* Efectos hover */
            .hover-scale {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .hover-scale:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    @endpush

    <script>
        function removeCartItem(key) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto de tu carrito?')) {
                jQuery.ajax({
                    type: 'POST',
                    url: wc_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'remove_from_cart'),
                    data: {
                        cart_item_key: key,
                    },
                    beforeSend: function() {
                        // Mostrar spinner de carga
                        const item = jQuery(`[data-key="${key}"]`).closest('.grid');
                        item.css('opacity', '0.5');
                        item.find('button').prop('disabled', true);
                    },
                    success: function(response) {
                        jQuery(document.body).trigger('wc_fragment_refresh');
                    }
                }).then(function(data) {
                    console.log('then');
                    location.reload();
                });

            }
        }

        jQuery(document).ready(function($) {
            // Controlador para los botones de cantidad
            $('.quantity-btn').on('click', function(e) {
                e.preventDefault();

                const btn = $(this);
                const key = btn.data('key');
                console.log(key);
                const input = $(`input[data-key="${key}"]`);
                let qty = parseInt(input.val());

                if ($(this).hasClass('plus')) {
                    qty = qty + 1;
                } else if ($(this).hasClass('minus') && qty > 1) {
                    qty = qty - 1;
                }

                input.val(qty).trigger('change');

                // Actualizar cantidad via AJAX
                $.ajax({
                    type: 'POST',
                    url: wc_cart_params.ajax_url,
                    data: {
                        action: 'update_cart_item',
                        cart_item_key: key,
                        quantity: qty,
                        _wpnonce: wc_cart_params.nonce
                    },
                    beforeSend: function() {
                        // Mostrar spinner
                        const item = $(`[data-key="${key}"]`).closest('.grid');
                        item.css('opacity', '0.7');
                        item.find('.quantity-btn').prop('disabled', true);
                    },
                }).then(function(data) {
                    console.log('then');
                    location.reload();
                });
            });

            // Actualizar carrito cuando cambia la cantidad manualmente
            $('input[name^="cart["]').on('change', function() {
                const form = $(this).closest('form');
                const button = form.find('[name="update_cart"]');

                button.removeClass('hidden');
                button.addClass('inline-flex');

                // Mostrar carga
                button.prop('disabled', true).html(`
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-700 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Actualizando...
                    `);

                // Enviar formulario
                // form.submit();
            });
        });
    </script>
@endsection
