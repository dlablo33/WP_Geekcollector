<?php
/**
 * Override WooCommerce Checkout page but load Blade view.
 * Path: /woocommerce/checkout/form-checkout.php
 */

if (!defined('ABSPATH')) {
    exit;
}

$checkout = WC()->checkout();

if (!function_exists('\Roots\view')) {
    // Si por alguna razón Acorn no está cargado, usar plantilla original de WooCommerce
    wc_get_template_part('checkout/form-checkout');
    return;
}

// Renderizar la vista Blade en resources/views/woocommerce/checkout/form-checkout.blade.php
echo \Roots\view('woocommerce.checkout.form-checkout', ['checkout' => $checkout])->render();