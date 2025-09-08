<?php
/**
 * Mini-cart Template Wrapper
 *
 * Redirige la carga del mini-cart de WooCommerce a una vista Blade en Sage.
 *
 * @package WooTailwindTheme
 */

// Asegura que no se acceda directamente.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Renderiza la vista Blade desde resources/views/woocommerce/cart/mini-cart.blade.php
echo \Roots\view('woocommerce.cart.mini-cart')->render();
