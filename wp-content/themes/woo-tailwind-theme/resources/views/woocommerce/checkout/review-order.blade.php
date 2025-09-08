{{-- resources/views/woocommerce/checkout/review-order.blade.php --}}
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        {{ __('Resumen de tu pedido', 'woocommerce') }}
    </h2>

    {{-- Productos --}}
    <div class="space-y-4">
        @php do_action('woocommerce_review_order_before_cart_contents') @endphp

        @foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
            @php 
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $thumbnail = $_product->get_image('thumbnail', ['class' => 'w-16 h-16 object-cover rounded-lg']);
            @endphp
            
            @if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key))
                <div class="flex items-start p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
                    <div class="flex-shrink-0 mr-4">
                        {!! $thumbnail !!}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate">
                            {!! apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) !!}
                        </p>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span class="mr-2">× {{ $cart_item['quantity'] }}</span>
                            @if ($_product->is_on_sale())
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">Oferta</span>
                            @endif
                        </div>
                        @if ($variation_data = wc_get_formatted_cart_item_data($cart_item))
                            <div class="text-xs text-gray-400 mt-1">
                                {!! $variation_data !!}
                            </div>
                        @endif
                    </div>
                    <div class="ml-4 text-right">
                        <p class="font-semibold text-gray-700">
                            {!! apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key) !!}
                        </p>
                        @if ($_product->get_regular_price() != $_product->get_price())
                            <p class="text-xs text-gray-400 line-through">
                                {!! wc_price($_product->get_regular_price() * $cart_item['quantity']) !!}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach

        @php do_action('woocommerce_review_order_after_cart_contents') @endphp
    </div>

    {{-- Sección de Envío --}}
{{-- Sección de Envío --}}
@if (WC()->cart->needs_shipping())
    <div class="p-5 bg-yellow-50 rounded-xl border border-yellow-200">
        <h3 class="text-lg font-semibold text-yellow-800">Debug: Información de envío</h3>
        
        <div class="mt-2 space-y-2">
            <p><strong>Needs shipping:</strong> {{ WC()->cart->needs_shipping() ? 'Sí' : 'No' }}</p>
            <p><strong>Show shipping:</strong> {{ WC()->cart->show_shipping() ? 'Sí' : 'No' }}</p>
            <p><strong>Shipping packages:</strong> {{ print_r(WC()->shipping()->get_packages(), true) }}</p>
        </div>
        
        @if (WC()->cart->show_shipping())
            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <h4 class="font-medium text-blue-800">Métodos de envío disponibles:</h4>
                {!! wc_cart_totals_shipping_html() !!}
            </div>
        @endif
    </div>
@endif

    {{-- Totales --}}
    <div class="p-5 rounded-xl bg-gradient-to-br from-white to-gray-50 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Resumen de pago', 'woocommerce') }}</h3>
        
        <ul class="space-y-3 text-gray-700">
            <li class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="font-medium">{{ __('Subtotal', 'woocommerce') }}</span>
                <span class="font-medium">{!! wc_cart_totals_subtotal_html() !!}</span>
            </li>

            @foreach (WC()->cart->get_coupons() as $code => $coupon)
                <li class="flex justify-between items-center py-2 border-b border-gray-100 text-green-700">
                    <div class="flex items-center">
                        <span>{!! wc_cart_totals_coupon_label($coupon) !!}</span>
                        <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">DESCUENTO</span>
                    </div>
                    <span class="font-medium">{!! wc_cart_totals_coupon_html($coupon) !!}</span>
                </li>
            @endforeach

            @foreach (WC()->cart->get_fees() as $fee)
                <li class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span>{{ $fee->name }}</span>
                    <span class="font-medium">{!! wc_cart_totals_fee_html($fee) !!}</span>
                </li>
            @endforeach

            @if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax())
                @if ('itemized' === get_option('woocommerce_tax_total_display'))
                    @foreach (WC()->cart->get_tax_totals() as $code => $tax)
                        <li class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span>{{ $tax->label }}</span>
                            <span class="font-medium">{!! $tax->formatted_amount !!}</span>
                        </li>
                    @endforeach
                @else
                    <li class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span>{{ WC()->countries->tax_or_vat() }}</span>
                        <span class="font-medium">{!! wc_cart_totals_taxes_total_html() !!}</span>
                    </li>
                @endif
            @endif

            @php do_action('woocommerce_review_order_before_order_total') @endphp
            <li class="flex justify-between items-center pt-3 mt-3">
                <span class="text-lg font-bold text-gray-900">{{ __('Total', 'woocommerce') }}</span>
                <span class="text-xl font-bold text-indigo-700 animate-pulse">
                    {!! wc_cart_totals_order_total_html() !!}
                </span>
            </li>
            @php do_action('woocommerce_review_order_after_order_total') @endphp
        </ul>

        {{-- Información adicional --}}
        <div class="mt-4 pt-4 border-t border-gray-200 text-xs text-gray-500">
            <p class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('El procesamiento del pedido puede tomar de 1 a 2 días hábiles', 'woocommerce') }}
            </p>
            <p class="flex items-center mt-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
                {{ __('Recibirás un correo con los detalles de tu compra', 'woocommerce') }}
            </p>
        </div>
    </div>
</div>