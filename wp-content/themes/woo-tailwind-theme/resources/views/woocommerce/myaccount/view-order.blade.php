@php
    $notes = $order->get_customer_order_notes();
@endphp

<div class="mb-4">
    @php
        printf(
            /* translators: 1: order number 2: order date 3: order status */
            esc_html__('Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce'),
            '<span class="order-number font-bold">' . $order->get_order_number() . '</span>',
            '<span class="order-date font-bold">' . wc_format_datetime($order->get_date_created()) . '</span>',
            '<span class="order-status font-bold">' . wc_get_order_status_name($order->get_status()) . '</span>',
        );
    @endphp

</div>

@if ($notes)
    <h2 class="py-2 text-xl font-semibold">
        @php
            esc_html_e('Order updates', 'woocommerce');
        @endphp
    </h2>
    <ol class="space-y-4">
        @foreach ($notes as $note)
            <li class="w-2/4 rounded-lg border border-white bg-gray-900 p-4 shadow">
                <div class="text-sm text-gray-400">
                    {{ date_i18n(__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date)) }}
                </div>
                <div class="mt-2 text-white">
                    {!! wpautop(wptexturize($note->comment_content)) !!}
                </div>
            </li>
        @endforeach
    </ol>
@endif

@php
    $order = wc_get_order($order_id);
    $billing_fields = WC()->checkout()->get_checkout_fields('billing');
    $shipping_fields = WC()->checkout()->get_checkout_fields('shipping');
    $subscriptions = wcs_get_subscriptions_for_order($order_id); // WooCommerce Subscriptions helper
@endphp

<div class="space-y-8">

    {{-- Detalles Pedido --}}
    <div>
        <h2 class="mb-2 border-b border-gray-600 py-2 text-xl font-bold">Detalles del pedido</h2>
        <div class="space-y-3">
            @foreach ($order->get_items() as $item_id => $item)
                @php $product = $item->get_product(); @endphp
                <div class="flex items-center justify-between rounded-lg border border-gray-700 bg-gray-800 p-4">
                    <div>
                        <div class="font-medium text-white">
                            {{ $item->get_name() }} × {{ $item->get_quantity() }}
                        </div>
                        @if ($product && ($sku = $product->get_sku()))
                            <div class="text-sm text-gray-400">SKU: {{ $sku }}</div>
                        @endif
                    </div>
                    <div class="font-semibold text-white">
                        {!! $order->get_formatted_line_subtotal($item) !!}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Subtotal y Total --}}
        @php
            $totals = $order->get_order_item_totals();
        @endphp

        @if ($totals)
            <div class="mt-4 grid grid-cols-12 gap-2 text-white">
                @foreach ($totals as $key => $total)
                    @if ($total['type'] === 'shipping')
                        {{-- Row Shipping --}}
                        @if ($order->get_shipping_method())
                            <div class="col-span-12 md:col-span-3 md:col-start-9 flex justify-between">
                                <span class="font-bold">{{ __('Shipping', 'woocommerce') }}:</span>
                                <div class="text-right font-semibold">
                                    <div>{{ $order->get_shipping_method() }}</div>

                                    @php
                                        $shipping_method = strtolower($order->get_shipping_method());
                                    @endphp

                                    @if (!Str::contains($shipping_method, ['pickup', 'collection']))
                                        <span>{!! $order->get_formatted_shipping_address() !!}</span>
                                    @endif

                                </div>

                            </div>
                        @endif
                    @else
                        {{--  Row Totales --}}
                        <div class="{{ $total['type'] === 'total' ? 'font-bold text-orange-400' : 'font-semibold' }} col-span-12 md:col-span-3 md:col-start-9 flex justify-between">
                            <span>{{ $total['label'] }}</span>
                            <span>{!! $total['value'] !!}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>

    {{-- Subscripciones --}}
    @if (!empty($subscriptions))
        <div>
            <h2 class="mb-2 border-b border-gray-600 py-2 text-xl font-bold">Suscripciones relacionadas</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-700 text-white">
                    <thead class="">
                        <tr class="bg-gray-700 text-gray-200">
                            <th class="px-6 py-2 text-left">#</th>
                            <th class="px-6 py-2 text-left">Estado</th>
                            <th class="px-6 py-2 text-left">Próximo pago</th>
                            <th class="px-6 py-2 text-left">Total</th>
                            <th class="px-6 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $sub)
                            <tr class="border-t border-gray-700">
                                <td class="px-6 py-2">#{{ $sub->get_id() }}</td>
                                <td class="px-6 py-2 capitalize">{{ wc_get_order_status_name($sub->get_status()) }}</td>
                                <td class="px-6 py-2 capitalize">
                                    {{ $sub->get_date_to_display('next_payment') ?? '-' }}
                                </td>
                                <td class="px-6 py-2">{!! $sub->get_formatted_order_total() !!}</td>
                                <td class="px-6 py-2">
                                    <a href="{{ $sub->get_view_order_url() }}" class="text-orange-400 hover:underline">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Billing Address --}}
    <div class="mb-2">
        <h2 class="py-2 text-lg font-bold text-white">Dirección de facturación</h2>
        <div class="grid w-2/4 grid-cols-1 gap-4 rounded-lg p-4 shadow md:w-full md:grid-cols-2 xl:grid-cols-4">
            @php
                $fields = WC()->countries->get_address_fields($order->get_billing_country(), 'billing_');
            @endphp
            @foreach ($fields as $key => $field)
                @php
                    $value = $order->{'get_' . str_replace('billing_', 'billing_', $key)}();
                @endphp
                @if ($value)
                    <div>
                        <span class="block text-xs text-gray-400">{{ $field['label'] ?? ucfirst($key) }}</span>
                        <span class="block text-sm font-medium">{{ $value }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>
