<?php
defined('ABSPATH') || exit;

use Roots\view;

// Obtener el checkout global
global $checkout;

// Si por algún motivo no existe, inicializarlo
if ( ! $checkout ) {
    $checkout = WC()->checkout();
}

// Renderizar la versión Blade
echo view('woocommerce.checkout.form-shipping', [
    'checkout' => $checkout,
])->render();
