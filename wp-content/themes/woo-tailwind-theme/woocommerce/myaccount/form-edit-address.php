<?php
echo \Roots\view('woocommerce.myaccount.form-edit-address', [
    'load_address' => $load_address,
    'address' => $address,
    'page_title' => ('billing' === $load_address) ? esc_html__('Billing address', 'woocommerce') : esc_html__('Shipping address', 'woocommerce')
])->render();