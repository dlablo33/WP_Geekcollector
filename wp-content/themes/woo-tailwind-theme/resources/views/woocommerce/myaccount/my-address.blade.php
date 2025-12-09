@php
    $customer_id = get_current_user_id();

    if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
        $get_addresses = apply_filters(
            'woocommerce_my_account_get_addresses',
            [
                'billing' => __('Billing address', 'woocommerce'),
                'shipping' => __('Shipping address', 'woocommerce'),
            ],
            $customer_id,
        );
    } else {
        $get_addresses = apply_filters(
            'woocommerce_my_account_get_addresses',
            [
                'billing' => __('Billing address', 'woocommerce'),
            ],
            $customer_id,
        );
    }

@endphp

<div class="mb-4 text-xl font-semibold">
    {{ apply_filters('woocommerce_my_account_my_address_description', esc_html__('The following addresses will be used on the checkout page by default.', 'woocommerce')) }}
</div>

@if (!wc_ship_to_billing_address_only() && wc_shipping_enabled())
    <div class="u-columns woocommerce-Addresses col2-set addresses">
@endif

<div class="grid grid-cols-12 gap-2">
    @foreach ($get_addresses as $name => $address_title)
        @php
            $address = wc_get_account_formatted_address($name);
        @endphp
        <div class="woocommerce-Address col-span-12 md:col-span-6 mb-4 rounded-2xl border bg-gray-900 px-3 py-3">

            <header class="woocommerce-Address-title title mb-2">
                <h2 class="mb-2 text-xl font-semibold">{{ esc_html($address_title) }}</h2>
                <a href="{{ esc_url(wc_get_endpoint_url('edit-address', $name)) }}" class="edit rounded-full bg-gray-700 px-5 text-lg">
                    @php
                        printf(
                            /* translators: %s: Address title */
                            $address ? esc_html__('Edit', 'woocommerce') : esc_html__('Add %s', 'woocommerce'),
                            esc_html($address_title),
                        );
                    @endphp
                </a>
            </header>
            @php
                // Get the address fields from WooCommerce with their labels
                $address_fields = WC()->countries->get_address_fields(
                    get_user_meta(get_current_user_id(), $name . '_country', true) ?: WC()->countries->get_base_country(),
                    $name . '_',
                );
            @endphp
            <address class="px-3">
                @if ($address)
                    @foreach ($address_fields as $key => $field)
                        @php
                            $value = get_user_meta(get_current_user_id(), $key, true);
                        @endphp
                        @if ($value)
                            <div class="address-line max-w-10/12 mb-1 text-base">
                                <span class="address-label font-bold">{{ $field['label'] }}:</span>
                                <span class="address-value">{{ $value }}</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    {{ __('You have not set up this type of address yet.', 'woocommerce') }}
                @endif
                {{ do_action('woocommerce_my_account_after_my_address', $name) }}
            </address>
        </div>
    @endforeach
</div>

@if (!wc_ship_to_billing_address_only() && wc_shipping_enabled())
    </div>
@endif
