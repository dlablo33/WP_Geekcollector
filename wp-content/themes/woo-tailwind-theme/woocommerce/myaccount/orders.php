<?php
echo \Roots\view('woocommerce.myaccount.orders', [
	'has_orders' => $has_orders,
	'customer_orders' => $customer_orders,
	'wp_button_class' => $wp_button_class,
])->render();
