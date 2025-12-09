<?php
echo \Roots\view('woocommerce.checkout.payment', [
	'order_button_text' => $order_button_text,
	'available_gateways' => $available_gateways,
])->render();
