@php($totals = $order->get_order_item_totals())

<form id="order_review" method="post" class="space-y-6">
    {{-- Tabla de productos --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Producto</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Cantidad</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @foreach ($order->get_items() as $item_id => $item)
                    @if (apply_filters('woocommerce_order_item_visible', true, $item))
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {!! apply_filters('woocommerce_order_item_name', $item->get_name(), $item, false) !!}
                                @php do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false) @endphp
                                @php wc_display_item_meta($item) @endphp
                                @php do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false) @endphp
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {!! apply_filters(
                                    'woocommerce_order_item_quantity_html',
                                    '<strong>&times;' . esc_html($item->get_quantity()) . '</strong>',
                                    $item
                                ) !!}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {!! $order->get_formatted_line_subtotal($item) !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

            <tfoot>
                @if ($totals)
                    @foreach ($totals as $total)
                        <tr>
                            <th colspan="2" class="px-4 py-2 text-right text-sm font-semibold text-gray-700">
                                {{ $total['label'] }}
                            </th>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {!! $total['value'] !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tfoot>
        </table>
    </div>

    {{-- Métodos de pago --}}
    @php do_action('woocommerce_pay_order_before_payment') @endphp
    <div id="payment" class="space-y-4">
        @if ($order->needs_payment())
            <ul class="space-y-3">
                @forelse ($available_gateways as $gateway)
                    @php wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]) @endphp
                @empty
                    <li class="text-sm text-gray-600">
                        {!! apply_filters(
                            'woocommerce_no_available_payment_methods_message',
                            __('No hay métodos de pago disponibles para tu ubicación.', 'woocommerce')
                        ) !!}
                    </li>
                @endforelse
            </ul>
        @endif

        <div class="space-y-3">
            <input type="hidden" name="woocommerce_pay" value="1" />
            @php wc_get_template('checkout/terms.php') @endphp

            @php do_action('woocommerce_pay_order_before_submit') @endphp

            {!! apply_filters(
                'woocommerce_pay_order_button_html',
                '<button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'
            ) !!}

            @php do_action('woocommerce_pay_order_after_submit') @endphp
            @php wp_nonce_field('woocommerce-pay', 'woocommerce-pay-nonce') @endphp
        </div>
    </div>
</form>
