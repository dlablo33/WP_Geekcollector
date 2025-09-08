<?php
/**
 * Override WooCommerce Login/Register form but load Blade view.
 * Path: /woocommerce/myaccount/form-login.php
 */

if (!function_exists('\Roots\view')) {
    // Si por alguna razón Acorn no está cargado, usar plantilla original de WooCommerce
    wc_get_template_part('myaccount/form-login');
    return;
}

// Renderizar la vista Blade en resources/views/woocommerce/myaccount/form-login.blade.php
echo \Roots\view('woocommerce.myaccount.form-login')->render();

