@php
    $order = wc_get_order($order_id);
    $subscriptions = function_exists('wcs_get_subscriptions_for_order') ? wcs_get_subscriptions_for_order($order) : [];
    $message = apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'woocommerce'), $order);
@endphp

<div class="bg-white p-6 text-black">
    <div class="mx-auto max-w-7xl">
        {{-- Encabezado animado --}}
        <div class="animate-fade-in-up mb-12 text-center" style="animation-delay: 0.1s">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                <span class="block">{{ $message }}</span>

            </h1>
            <div class="animate-scale-x mx-auto mt-4 h-1 w-24 bg-orange-500" style="animation-delay: 0.3s"></div>
        </div>

        {{-- Resumen --}}
        <div class="mb-4 space-y-2 text-sm">
            <div><strong>{{ __('Order number', 'woocommerce') }}:</strong> {{ $order->get_order_number() }}</div>
            <div class="capitalize"><strong>{{ __('Date', 'woocommerce') }}:</strong> {{ wc_format_datetime($order->get_date_created()) }}</div>
            <div><strong>{{ __('Email', 'woocommerce') }}:</strong> {{ $order->get_billing_email() }}</div>
            @if ($order->get_payment_method_title())
                <div><strong>{{ __('Payment method', 'woocommerce') }}:</strong> {{ $order->get_payment_method_title() }}</div>
            @endif
        </div>

        <div class="grid grid-cols-12 gap-2">
            {{-- Columna Izquierda --}}
            <div class="col-span-12 md:col-span-8">
                <div class="overflow-hidden rounded-2xl bg-white p-4 shadow-xl transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl">
                    {{-- Orden --}}
                    <h2 class="border-b border-gray-300 py-2 text-xl font-semibold">{{ __('Order details', 'woocommerce') }}</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto whitespace-nowrap rounded text-left shadow">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="p-2">{{ __('Product', 'woocommerce') }}</th>
                                    <th class="p-2 text-right">{{ __('Total', 'woocommerce') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->get_items() as $item)
                                    <tr class="border-b border-gray-200">
                                        <td class="p-2">{{ $item->get_name() }} × {{ $item->get_quantity() }}</td>
                                        <td class="p-2 text-right">{!! $order->get_formatted_line_subtotal($item) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Suscriptions --}}
                    @if ($subscriptions)
                        <div class="mt-6">
                            <h2 class="border-b border-gray-300 py-2 text-xl font-semibold">Suscripciones relacionadas</h2>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto whitespace-nowrap rounded text-left shadow">
                                    <thead>
                                        <tr class="border-b border-gray-300 text-black">
                                            <th class="p-2">{{ __('Subscription', 'woocommerce-subscriptions') }}</th>
                                            <th class="p-2">{{ __('Status', 'woocommerce') }}</th>
                                            <th class="p-2">{{ __('Next payment', 'woocommerce-subscriptions') }}</th>
                                            <th class="p-2">{{ __('Total', 'woocommerce') }}</th>
                                            <th class="p-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $sub)
                                            <tr class="border-b border-gray-200 capitalize">
                                                <td class="p-2">#{{ $sub->get_id() }}</td>
                                                <td class="p-2">{{ wc_get_order_status_name($sub->get_status()) }}</td>
                                                <td class="p-2">{{ $sub->get_date_to_display('next_payment') ?? '-' }}</td>
                                                <td class="p-2">{!! $sub->get_formatted_order_total() !!}</td>
                                                <td class="p-2">
                                                    <a href="{{ $sub->get_view_order_url() }}" class="text-orange-400 hover:underline">
                                                        {{ __('View', 'woocommerce') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Right Column --}}
            <div class="col-span-12 md:col-span-3 md:col-start-10">
                {{-- Totales --}}
                <div>
                    @php $totals = $order->get_order_item_totals(); @endphp
                    @if ($totals)
                        <div class="mt-4 space-y-2 text-black">
                            @foreach ($totals as $key => $total)
                                @if ($total['type'] === 'shipping' && $order->get_shipping_method())
                                    <div class="flex justify-between">
                                        <span class="font-bold">{{ __('Shipping', 'woocommerce') }}:</span>
                                        <div class="text-right font-light">
                                            <div>{{ $order->get_shipping_method() }}</div>
                                            @php $shipping_method = strtolower($order->get_shipping_method()); @endphp
                                            @if (!Str::contains($shipping_method, ['pickup', 'collection']))
                                                <span>{!! $order->get_formatted_shipping_address() !!}</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="{{ $total['type'] === 'total' ? 'font-bold text-orange-400' : 'font-semibold' }} flex justify-between">
                                        <span>{{ $total['label'] }}</span>
                                        <span>{!! $total['value'] !!}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                {{-- Direccion Facturacion --}}
                <div class="mt-6">
                    <h2 class="py-2 text-lg font-bold text-black">Dirección de facturación</h2>
                    <div class="grid grid-cols-1 gap-2 gap-x-4 rounded-lg p-4 shadow md:grid-cols-2">
                        @php
                            $fields = WC()->countries->get_address_fields($order->get_billing_country(), 'billing_');
                        @endphp
                        @php
                            $fields = WC()->countries->get_address_fields($order->get_billing_country(), 'billing_');
                        @endphp

                        {{-- First render all fields except email --}}
                        @foreach ($fields as $key => $field)
                            @php
                                $value = $order->{'get_' . str_replace('billing_', 'billing_', $key)}();
                            @endphp
                            @if ($value && $key !== 'billing_email')
                                <div>
                                    <span class="block text-xs text-black">{{ $field['label'] ?? ucfirst($key) }}</span>
                                    <span class="block text-sm font-medium">{{ $value }}</span>
                                </div>
                            @endif
                        @endforeach

                        {{-- Then render email at the end --}}
                        @php
                            $email = $order->get_billing_email();
                        @endphp
                        @if ($email)
                            <div>
                                <span class="block text-xs text-black">{{ $fields['billing_email']['label'] ?? __('Email', 'woocommerce') }}</span>
                                <span class="block text-sm font-medium">{{ $email }}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
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
