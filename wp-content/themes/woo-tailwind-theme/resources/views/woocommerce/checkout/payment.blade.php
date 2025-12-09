<?php
/**
 * Checkout Payment Template - Versión Mejorada y Corregida
 */
defined('ABSPATH') || exit();
?>

@if (!wp_doing_ajax())
    @php do_action('woocommerce_review_order_before_payment') @endphp
@endif

<div id="payment" class="woocommerce-checkout-payment mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
    @if (WC()->cart && WC()->cart->needs_payment())
        <h3 class="mb-4 flex items-center text-xl font-bold text-gray-800">
            <svg class="mr-2 h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            {{ __('Método de pago', 'woocommerce') }}
        </h3>

        <ul class="wc_payment_methods payment_methods methods space-y-3">
            <?php
            if (!empty($available_gateways)) {
                foreach ($available_gateways as $gateway) {
                    wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
                }
            } else {
                echo '<li>';
                wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
                echo '</li>';
            }
            ?>
        </ul>
    @endif

    <div class="form-row place-order mt-8">
        <noscript>
            <div class="mb-4 rounded-lg bg-blue-50 p-3 text-sm text-blue-800">
                @php
                    printf(__('Tu navegador no soporta JavaScript. Haz clic en %1$sActualizar totales%2$s antes de realizar el pedido.', 'woocommerce'), '<em>', '</em>');
                @endphp
            </div>
            <button type="submit" class="button alt rounded-lg bg-gray-200 px-4 py-2 text-gray-800 transition-colors hover:bg-gray-300"
                name="woocommerce_checkout_update_totals" value="{{ __('Update totals', 'woocommerce') }}">
                {{ __('Update totals', 'woocommerce') }}
            </button>
        </noscript>

        @php wc_get_template('checkout/terms.php') @endphp

        @php do_action('woocommerce_review_order_before_submit') @endphp

        <button type="submit"
            class="button alt w-full transform rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4 font-bold text-white shadow-md transition-all duration-300 hover:scale-[1.02] hover:from-indigo-700 hover:to-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
            name="woocommerce_checkout_place_order" id="place_order" value="{{ esc_attr($order_button_text) }}" data-value="{{ esc_attr($order_button_text) }}">
            <span class="flex items-center justify-center">
                {{ esc_html($order_button_text) }}
                <svg class="ml-2 h-5 w-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </span>
        </button>

        @php do_action('woocommerce_review_order_after_submit') @endphp

        @php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce') @endphp
    </div>
</div>

@if (!wp_doing_ajax())
    @php do_action('woocommerce_review_order_after_payment') @endphp
@endif

<style>
    /* Animaciones y estilos personalizados */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Estilos para los iconos de pago */
    .payment-icon img {
        max-height: 30px;
        width: auto;
        display: inline-block;
    }

    /* Efecto hover para el botón de pago */
    #place_order:hover {
        box-shadow: 0 5px 15px rgba(67, 56, 202, 0.3);
    }

    /* Estilos específicos para OXXO */
    .payment_method_oxxo .payment-icon {
        background-color: #FF5A00;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
    }

    .payment_method_oxxo .payment-icon img {
        filter: brightness(0) invert(1);
    }

    /* Estilos para tarjetas de crédito/débito */
    .payment_method_ppec_paypal .payment-icon,
    .payment_method_stripe .payment-icon {
        background-color: #f5f5f5;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* Adaptación para móviles */
    @media (max-width: 768px) {
        .wc_payment_methods {
            gap: 0.5rem;
        }

        .wc_payment_method label {
            padding: 0.75rem;
            flex-direction: column;
            align-items: flex-start;
        }

        .payment-icon {
            margin-bottom: 0.5rem;
        }

        #place_order {
            padding: 0.75rem;
            font-size: 1.125rem;
        }
    }
</style>
