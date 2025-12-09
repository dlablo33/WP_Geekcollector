<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Redirige a tu dashboard.blade
echo \Roots\view('woocommerce.myaccount.dashboard')->render();
