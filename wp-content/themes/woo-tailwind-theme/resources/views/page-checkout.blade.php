@extends('layouts.app')

@section('content')
    @php
        $checkout = WC()->checkout();
        // Forzar cálculo de envíos
        WC()->cart->calculate_shipping();
        WC()->cart->calculate_totals();
    @endphp

    <div class="container mx-auto px-4 py-10">
        <!-- Título con animación -->
        <h1 class="animate-fade-in-down mb-8 text-center text-4xl font-bold text-white">
            Finalizar Compra
            <span class="mx-auto mt-3 block h-1 w-20 rounded-full bg-orange-500"></span>
        </h1>
        <div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"> </div>
        <style>
            /* div.woocommerce-notices-wrapper {
                                background: none;
                                margin: 0;
                                padding: 0;
                                border: none
                              }

                              div.woocommerce-notices-wrapper ul.woocommerce-error{
                                background: none;
                                margin: 0;
                                padding: 0;
                                border: none
                              } */
            /* div.woocommerce-notices-wrapper ul.woocommerce-error li{
                                width: 100%;
                                display: flex;
                                flex-direction: row;
                                flex-wrap: wrap;
                                justify-content: start;
                                align-items: center;
                                background-color: #FF1100;
                                color: white;
                                border-radius: 1rem;
                                padding: 0.5rem 1rem;
                                margin: 0 0 0.5rem 0;
                                border: none;
                              } */
            div.woocommerce-NoticeGroup.woocommerce-NoticeGroup-updateOrderReview,
            div.woocommerce-NoticeGroup.woocommerce-NoticeGroup-checkout {
                grid-column: 1 / 3;
            }
        </style>

        {{-- Remover hook de coupon_form del before_checkout_form para que no aparezca al inicio de la vista, e imprimirlo manualmente en otro sitio --}}
        @php remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10); @endphp
        {{-- Hook CRÍTICO antes del formulario --}}
       @php do_action('woocommerce_before_checkout_form'); @endphp


        {{-- Verifica si el carrito está vacío --}}
        @if (!$checkout->get_checkout_fields())
            <div class="animate-bounce py-10 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 w-16 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xl text-gray-300">Tu carrito está vacío.</p>
                <a href="{{ wc_get_page_permalink('shop') }}"
                    class="mt-4 inline-block transform rounded-lg bg-blue-500 px-6 py-2 font-medium text-white transition-all duration-300 hover:scale-105 hover:bg-blue-600">
                    Ir a la tienda
                </a>
                @php do_action('woocommerce_no_checkout_form'); @endphp
            </div>
        @else
            {{-- Hook antes de los detalles del cliente --}}
            @php do_action('woocommerce_checkout_before_customer_details'); @endphp

            <form name="checkout" method="post" class="checkout woocommerce-checkout grid grid-cols-1 gap-8 lg:grid-cols-2" action="{{ esc_url(wc_get_checkout_url()) }}"
                enctype="multipart/form-data">
                {{-- Columna izquierda: Datos del cliente --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-xl transition-all duration-500 hover:shadow-lg">

                    {{-- Hook antes de facturación --}}
                    @php do_action('woocommerce_checkout_before_billing'); @endphp

                    <div class="space-y-5">
                        @php
                            // Cargar la plantilla Blade correctamente
                            if (function_exists('woocommerce_checkout_billing')) {
                                woocommerce_checkout_billing();
                            } else {
                                // Fallback: intentar cargar manualmente
                                echo view('woocommerce.checkout.form-billing', ['checkout' => $checkout])->render();
                            }
                        @endphp
                    </div>

                    {{-- Hook después de facturación --}}
                    @php do_action('woocommerce_checkout_after_billing'); @endphp

                    <h2 class="mb-6 mt-10 flex items-center text-2xl font-bold text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Detalles de envío
                    </h2>

                    <div class="space-y-5">
                        {{-- Hook MÁS IMPORTANTE para métodos de envío --}}
                        @php wc_get_template('checkout/form-shipping.php', ['checkout' => $checkout]); @endphp
                    </div>

                    {{-- Hook después de envío --}}
                    @php do_action('woocommerce_checkout_after_shipping'); @endphp
                </div>

                {{-- Columna derecha: Resumen de pedido --}}
                <div class="sticky top-4 rounded-2xl border border-gray-200 bg-white p-8 shadow-xl transition-all duration-500 hover:shadow-lg">
                    {{-- Hook antes del heading de revisión --}}
                    @php do_action('woocommerce_checkout_before_order_review_heading'); @endphp

                    <h3 id="order_review_heading" class="mb-6 text-2xl font-bold text-gray-800">
                        @php do_action('woocommerce_checkout_order_review_heading'); @endphp
                        Tu pedido
                    </h3>
                    {{-- Hook para el formulario de cupón --}}
                    @php woocommerce_checkout_coupon_form(); @endphp
                    {{-- Hook antes de la revisión del pedido --}}
                    @php do_action('woocommerce_checkout_before_order_review'); @endphp

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        {{-- Hook que muestra los métodos de envío en el resumen --}}
                        @php do_action('woocommerce_checkout_order_review'); @endphp
                    </div>

                    {{-- Hook después de la revisión del pedido --}}
                    @php do_action('woocommerce_checkout_after_order_review'); @endphp

                    <!-- Términos y condiciones con estilo mejorado -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        {{-- Hook para términos y condiciones --}}
                        @php do_action('woocommerce_checkout_before_terms_and_conditions'); @endphp
                        <div class="woocommerce-terms-and-conditions-wrapper mt-4">
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input id="terms" name="terms" required="true" type="checkbox" {!! checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true) !!}
                                        class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox h-4 w-4 rounded border-gray-300 text-blue-600 focus:outline-none focus:ring focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">
                                        He leído y acepto los
                                        <a href="https://geekcollector.com/terminos-y-condiciones/" class="text-blue-600 underline hover:text-blue-800">Términos Y
                                            Condiciones</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Hook después de términos y condiciones --}}
                        @php do_action('woocommerce_checkout_after_terms_and_conditions'); @endphp
                    </div>
                </div>

                {{-- Hook dentro del formulario pero al final --}}
                @php do_action('woocommerce_checkout_after_customer_details'); @endphp
            </form>

            {{-- Hook después del formulario --}}
            @php do_action('woocommerce_after_checkout_form', $checkout); @endphp
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Animaciones personalizadas */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Estilos para los campos del formulario */
        .woocommerce form .form-row input.input-text,
        .woocommerce form .form-row textarea,
        .woocommerce form .form-row select {
            @apply w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm;
        }

        .woocommerce form .form-row label {
            @apply block mb-2 text-gray-700 font-medium;
        }

        .woocommerce-checkout-review-order-table {
            @apply w-full text-gray-700;
        }

        .woocommerce-checkout-review-order-table th,
        .woocommerce-checkout-review-order-table td {
            @apply py-3 px-4 border-b border-gray-200;
        }

        .woocommerce-checkout-review-order-table th {
            @apply text-left font-semibold text-gray-800;
        }

        .woocommerce-checkout-payment {
            @apply bg-gray-50 p-4 rounded-lg mt-6 border border-gray-200;
        }

        .woocommerce-privacy-policy-text {
            @apply text-gray-600 text-sm mb-4;
        }

        .woocommerce-privacy-policy-text a {
            @apply text-blue-600 hover:text-blue-800 underline;
        }

        #place_order {
            @apply w-full py-3 px-6 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-blue-500/20;
        }

        /* Estilos para los métodos de pago */
        .wc_payment_methods {
            @apply space-y-4;
        }

        .wc_payment_method label {
            @apply flex items-center cursor-pointer;
        }

        .payment_box {
            @apply bg-gray-100 p-4 mt-2 rounded-lg border border-gray-200 text-gray-700;
        }

        /* Estilos específicos para métodos de envío */
        .woocommerce-shipping-methods {
            @apply space-y-3;
        }

        .shipping_method {
            @apply mr-2;
        }

        .woocommerce-shipping-method__name {
            @apply font-medium text-gray-800;
        }

        .woocommerce-shipping-method__description {
            @apply text-sm text-gray-600 ml-6;
        }

        /* Ajustes para pantallas pequeñas */
        @media (max-width: 768px) {
            .checkout.woocommerce-checkout {
                @apply grid-cols-1;
            }

            .container {
                @apply px-3;
            }

            .bg-white {
                @apply px-5 py-6;
            }
        }
    </style>

<script>
jQuery(function($){
  $(document).ajaxComplete(function(event, xhr, settings){
    // Solo para la petición de checkout
    if (typeof settings.url === 'string' && settings.url.indexOf('?wc-ajax=checkout') !== -1) {
      console.group('wc-ajax=checkout debug');
      console.log('XHR status:', xhr.status);
      console.log('XHR headers:', xhr.getAllResponseHeaders());
      console.log('XHR responseText (primeros 1000 chars):', xhr.responseText ? xhr.responseText.substring(0,1000) : '');
      console.groupEnd();

      // 1) Intentar parsear JSON (caso ideal)
      try {
        var data = JSON.parse(xhr.responseText);
        if (data && data.result === 'success' && data.redirect) {
          window.location.href = data.redirect;
          return;
        }
      } catch (e) {
        // no es JSON
      }

      // 2) Buscar URL de order-received en el HTML
      var m = xhr.responseText && xhr.responseText.match(/\/checkout\/order-received\/\d+\/\?key=[^"'<> ]+/);
      if (m && m[0]) {
        window.location.href = m[0];
        return;
      }

      // 3) Buscar header Location
      var headers = xhr.getAllResponseHeaders();
      var locMatch = headers && headers.match(/location:\s*(.*)/i);
      if (locMatch && locMatch[1]) {
        var loc = locMatch[1].trim();
        try { loc = decodeURI(loc); } catch(e){}
        window.location.href = loc;
        return;
      }

      // 4) Nada válido — mostrar consola para depuración
      console.error('Checkout AJAX: no se detectó redirect válido. Revisa debug.log y la respuesta completa en Network > Response.');
      // opcional: mostrar un aviso amigable
      // alert('Hubo un problema procesando tu pedido. Revisa la consola del navegador para más detalles.');
    }
  });
});
</script>

@endpush