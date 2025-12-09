{{--
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */
--}}

<div class="woocommerce-shipping-fields">
    @if (true === WC()->cart->needs_shipping_address())
        <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
            <h3 id="ship-to-different-address" class="flex items-center">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex cursor-pointer items-center">
                    <input id="ship-to-different-address-checkbox"
                        class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox mr-3 h-5 w-5 rounded border-gray-300 text-orange-600 focus:ring-orange-500"
                        @checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 1 : 0)) type="checkbox" name="ship_to_different_address" value="1" />
                    <span class="text-lg font-medium text-gray-800">
                        {{ __('Ship to a different address?', 'woocommerce') }}
                    </span>
                </label>
            </h3>
        </div>

        <div class="shipping_address mt-6 space-y-6">
            @php do_action('woocommerce_before_checkout_shipping_form', $checkout); @endphp

            <div class="woocommerce-shipping-fields__field-wrapper grid grid-cols-1 items-end gap-4 md:grid-cols-2">
                @php
                    $fields = $checkout->get_checkout_fields('shipping');

                    $styled_fields = [];
                    foreach ($fields as $key => $field) {
                        $field['class'][] = 'mb-4';
                        $field['label_class'][] = 'block text-gray-700 mb-1 font-medium';
                        $field['input_class'][] = 'border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300';

                        $styled_fields[$key] = $field;
                    }
                @endphp

                @foreach ($styled_fields as $key => $field)
                    {{-- <div class="form-row @if (isset($field['class'])){{ implode(' ', $field['class']) }}@endif 
                                @if (isset($field['validate']) && in_array('postcode', $field['validate']))address-field postcode-field @endif
                                @if (isset($field['validate']) && in_array('state', $field['validate']))address-field state-field @endif">
                        
                    </div> --}}
                    @php
                        woocommerce_form_field($key, $field, $checkout->get_value($key));
                    @endphp
                @endforeach

            </div>

            @php do_action('woocommerce_after_checkout_shipping_form', $checkout); @endphp
        </div>
    @endif
</div>

<div class="woocommerce-additional-fields mt-8">
    @php do_action('woocommerce_before_order_notes', $checkout); @endphp

    @if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes')))
        @if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only())
            <h3 class="mb-4 flex items-center text-xl font-bold text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('Additional information', 'woocommerce') }}
            </h3>
        @endif

        <div class="woocommerce-additional-fields__field-wrapper space-y-4">
            @foreach ($checkout->get_checkout_fields('order') as $key => $field)
                <div class="form-row @if (isset($field['class'])) {{ implode(' ', $field['class']) }} @endif">
                    @php
                        woocommerce_form_field($key, $field, $checkout->get_value($key));
                    @endphp
                </div>
            @endforeach
        </div>
    @endif

    @php do_action('woocommerce_after_order_notes', $checkout); @endphp
</div>

@push('styles')
    <style>
        .woocommerce-shipping-fields,
        .woocommerce-additional-fields {
            @apply transition-all duration-300;
        }

        .shipping_address {
            @apply transform transition-all duration-500 ease-in-out;
        }

        /* Estilos para los campos de envío */
        .woocommerce-shipping-fields__field-wrapper .form-row {
            @apply mb-4;
        }

        .woocommerce-shipping-fields__field-wrapper label {
            @apply block text-sm font-medium text-gray-700 mb-2;
        }

        .woocommerce-shipping-fields__field-wrapper input,
        .woocommerce-shipping-fields__field-wrapper select,
        .woocommerce-shipping-fields__field-wrapper textarea {
            @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200;
        }

        .woocommerce-shipping-fields__field-wrapper .select2-container {
            @apply w-full;
        }

        /* Estilos para campos requeridos */
        .woocommerce-shipping-fields__field-wrapper .required {
            @apply text-red-500 ml-1;
        }

        /* Estilos para validación */
        .woocommerce-shipping-fields__field-wrapper .woocommerce-invalid {
            @apply border-red-500 ring-1 ring-red-500;
        }

        .woocommerce-shipping-fields__field-wrapper .woocommerce-validated {
            @apply border-green-500;
        }

        /* Estilos para el checkbox de dirección diferente */
        #ship-to-different-address-checkbox {
            @apply h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500;
        }

        /* Animaciones suaves */
        .shipping_address {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .woocommerce-shipping-fields__field-wrapper {
                @apply grid-cols-1 gap-3;
            }

            .woocommerce-shipping-fields__field-wrapper .form-row {
                @apply mb-3;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const shippingMethods = document.querySelectorAll('input[name^="shipping_method"]');

    shippingMethods.forEach(input => {
        input.addEventListener('change', function() {
            // Trigger WooCommerce update_checkout AJAX
            jQuery(document.body).trigger('update_checkout');
        });
    });
});

        document.addEventListener('DOMContentLoaded', function() {
            // Animación suave para mostrar/ocultar dirección de envío
            const shipToDifferentCheckbox = document.getElementById('ship-to-different-address-checkbox');
            const shippingAddress = document.querySelector('.shipping_address');

            if (shipToDifferentCheckbox && shippingAddress) {
                // Estado inicial
                if (!shipToDifferentCheckbox.checked) {
                    shippingAddress.style.display = 'none';
                }

                shipToDifferentCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        shippingAddress.style.display = 'block';
                        shippingAddress.style.animation = 'slideDown 0.5s ease-out';
                    } else {
                        shippingAddress.style.animation = 'slideUp 0.5s ease-out';
                        setTimeout(() => {
                            shippingAddress.style.display = 'none';
                        }, 500);
                    }
                });
            }

            // Mejorar la experiencia de usuario en dispositivos móviles
            if (window.innerWidth < 768) {
                const shippingFields = document.querySelectorAll(
                    '.woocommerce-shipping-fields__field-wrapper input, .woocommerce-shipping-fields__field-wrapper select');
                shippingFields.forEach(field => {
                    field.addEventListener('focus', function() {
                        this.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    });
                });
            }
        });
    </scr>
@endpush
