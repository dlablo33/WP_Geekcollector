<?php
/**
 * Checkout Payment Template - Versión Mejorada y Corregida
 */
defined('ABSPATH') || exit;
?>

@if (!wp_doing_ajax())
  @php do_action('woocommerce_review_order_before_payment') @endphp
@endif

<div id="payment" class="woocommerce-checkout-payment bg-white p-6 rounded-xl shadow-sm border border-gray-200 mt-6">
  @if (WC()->cart && WC()->cart->needs_payment())
    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
      <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
      </svg>
      {{ __('Método de pago', 'woocommerce') }}
    </h3>
    
    <ul class="wc_payment_methods payment_methods methods space-y-3">
      @if (!empty($available_gateways))
        @foreach ($available_gateways as $gateway)
          <li class="wc_payment_method payment_method_{{ esc_attr($gateway->id) }}">
            <input id="payment_method_{{ esc_attr($gateway->id) }}" type="radio" class="input-radio hidden" name="payment_method" value="{{ esc_attr($gateway->id) }}" {{ checked($gateway->chosen, true) }} data-order_button_text="{{ esc_attr($gateway->order_button_text) }}" />

            <label for="payment_method_{{ esc_attr($gateway->id) }}" class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
              <div class="flex items-center">
                @if ($gateway->get_icon())
                  <span class="mr-3 payment-icon">{!! $gateway->get_icon() !!}</span>
                @endif
                <span class="font-medium text-gray-800">
                  {!! str_replace('&amp;', '&', esc_html($gateway->get_title())) !!}
                  @if ($gateway->id === 'oxxo')
                    <span class="block text-sm font-normal text-gray-500 mt-1">{{ __('Paga en efectivo en tiendas OXXO', 'woocommerce') }}</span>
                  @endif
                </span>
              </div>
              <svg class="w-5 h-5 text-blue-500 opacity-0 transition-opacity duration-200 [.has-[:checked]_&]:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </label>

            @if ($gateway->has_fields() || $gateway->get_description())
              <div class="payment_box payment_method_{{ esc_attr($gateway->id) }} mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200 animate-fade-in">
                {!! $gateway->payment_fields() !!}
              </div>
            @endif
          </li>
        @endforeach
      @else
        <li class="p-3 bg-yellow-50 text-yellow-800 rounded-lg">
          @php
            wc_print_notice(
              apply_filters(
                'woocommerce_no_available_payment_methods_message',
                WC()->customer->get_billing_country() ? 
                __('No hay métodos de pago disponibles. Contáctanos para ayuda.', 'woocommerce') : 
                __('Completa tus datos para ver los métodos de pago.', 'woocommerce')
              ), 
              'notice'
            );
          @endphp
        </li>
      @endif
    </ul>
  @endif
  
  <div class="form-row place-order mt-8">
    <noscript>
      <div class="bg-blue-50 text-blue-800 p-3 rounded-lg mb-4 text-sm">
        @php
          printf(
            __('Tu navegador no soporta JavaScript. Haz clic en %1$sActualizar totales%2$s antes de realizar el pedido.', 'woocommerce'),
            '<em>', '</em>'
          );
        @endphp
      </div>
      <button type="submit" class="button alt bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors" name="woocommerce_checkout_update_totals" value="{{ __('Update totals', 'woocommerce') }}">
        {{ __('Update totals', 'woocommerce') }}
      </button>
    </noscript>

    @php wc_get_template('checkout/terms.php') @endphp

    @php do_action('woocommerce_review_order_before_submit') @endphp

    <button type="submit" 
            class="button alt w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" 
            name="woocommerce_checkout_place_order" 
            id="place_order" 
            value="{{ esc_attr($order_button_text) }}" 
            data-value="{{ esc_attr($order_button_text) }}">
      <span class="flex items-center justify-center">
        {{ esc_html($order_button_text) }}
        <svg class="w-5 h-5 ml-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
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