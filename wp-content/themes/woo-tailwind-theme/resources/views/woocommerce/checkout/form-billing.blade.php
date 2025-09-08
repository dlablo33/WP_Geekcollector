@php
if (!isset($checkout)) {
    $checkout = WC()->checkout();
}
@endphp

<div class="woocommerce-billing-fields space-y-6">
    <?php if (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>
        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="h-6 w-6 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <?php esc_html_e('Billing & Shipping', 'woocommerce'); ?>
        </h3>
    <?php else : ?>
        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="h-6 w-6 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            <?php esc_html_e('Billing details', 'woocommerce'); ?>
        </h3>
    <?php endif; ?>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="woocommerce-billing-fields__field-wrapper grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php
        $fields = $checkout->get_checkout_fields('billing');
        
        // Personalización de campos específicos
        foreach ($fields as $key => $field) {
            // Clases base
            $field['class'] = array_merge($field['class'] ?? [], ['mb-0']);
            $field['input_class'] = array_merge($field['input_class'] ?? [], [
                'w-full px-4 py-3 bg-white border border-gray-300 rounded-lg',
                'text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                'transition-all duration-200 shadow-sm'
            ]);
            $field['label_class'] = array_merge($field['label_class'] ?? [], [
                'block mb-2 text-gray-700 font-medium'
            ]);
            
            // Campos de ancho completo
            if (in_array($key, ['billing_address_1', 'billing_address_2', 'billing_company', 'billing_email'])) {
                $field['class'][] = 'md:col-span-2';
            }
            
            woocommerce_form_field($key, $field, $checkout->get_value($key));
        }
        ?>
    </div>

    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
<div class="woocommerce-account-fields mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
    <?php if (!$checkout->is_registration_required()) : ?>
    <p class="form-row form-row-wide create-account">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox flex items-center">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                   id="createaccount" 
                   <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true); ?> 
                   type="checkbox" name="createaccount" value="1" />
            <span class="ml-2 text-gray-700"><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
        </label>
    </p>
    <?php endif; ?>

    <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

    <?php if ($checkout->get_checkout_fields('account')) : ?>
    <div class="create-account mt-4 space-y-4 hidden">
        <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
            <?php 
            $field['input_class'] = array_merge($field['input_class'] ?? [], [
                'w-full px-4 py-3 bg-white border border-gray-300 rounded-lg',
                'text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                'transition-all duration-200 shadow-sm'
            ]);
            $field['label_class'] = array_merge($field['label_class'] ?? [], [
                'block mb-2 text-gray-700 font-medium'
            ]);
            woocommerce_form_field($key, $field, $checkout->get_value($key)); 
            ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createAccount = document.getElementById('createaccount');
    const accountFields = document.querySelector('.create-account');
    
    if (createAccount && accountFields) {
        createAccount.addEventListener('change', function() {
            accountFields.classList.toggle('hidden', !this.checked);
        });
        
        // Mostrar campos si el checkbox viene marcado por defecto
        if (createAccount.checked) {
            accountFields.classList.remove('hidden');
        }
    }
});
</script>
<?php endif; ?>