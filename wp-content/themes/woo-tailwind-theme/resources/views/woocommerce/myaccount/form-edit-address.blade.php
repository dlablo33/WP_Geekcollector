@php
    $page_title = 'billing' === $load_address ? esc_html__('Billing address', 'woocommerce') : esc_html__('Shipping address', 'woocommerce');
    do_action('woocommerce_before_edit_account_address_form');
@endphp

@if (!$load_address)
    @php
        wc_get_template('myaccount/my-address.php');
    @endphp
@else
    <form method="post" novalidate>
        <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ apply_filters('woocommerce_my_account_edit_address_title', $page_title, $load_address) }}</h2>

        <div class="woocommerce-address-fields">
            {{ do_action("woocommerce_before_edit_address_form_{$load_address}") }}

            <div class="woocommerce-address-fields__field-wrapper grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach ($address as $key => $field)
                    @php
                        ob_start();
                        woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                        $field_html = ob_get_clean();

                        // Determine if field should span full width
                        $full_width_fields = ['address_1', 'address_2'];
                        $col_span = in_array($key, $full_width_fields) ? 'md:col-span-2' : '';

                        $styled_html = str_replace(
                            ['<p class="form-row', '<label', '<input', '<select', '<textarea'],
                            [
                                '<p class="form-row ' . $col_span . ' mb-4"',
                                '<label class="mb-1 block text-sm font-medium text-gray-200"',
                                '<input class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-900 px-3 py-2 shadow-sm"',
                                '<select class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-900 px-3 py-2 shadow-sm"',
                                '<textarea class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 shadow-sm"',
                            ],
                            $field_html,
                        );
                    @endphp
                    {!! $styled_html !!}
                @endforeach
            </div>

            @php
                do_action("woocommerce_after_edit_address_form_{$load_address}");
            @endphp

            <div class="mt-6 md:col-span-2">
                <button type="submit" class="cursor-pointer rounded-full border border-white bg-gray-900 px-6 py-2 text-white" name="save_address"
                    value="{{ esc_attr_e('Save address', 'woocommerce') }}">
                    {{ esc_html__('Save address', 'woocommerce') }}
                </button>
                @php
                    wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce');
                @endphp
                <input type="hidden" name="action" value="edit_address" />
            </div>
        </div>
    </form>
@endif

@php
    do_action('woocommerce_after_edit_account_address_form');
@endphp
