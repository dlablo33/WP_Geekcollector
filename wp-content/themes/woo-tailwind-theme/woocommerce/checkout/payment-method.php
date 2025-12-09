<?php
echo \Roots\view('woocommerce.checkout.payment-method', [
	'gateway' => $gateway,
])->render();
