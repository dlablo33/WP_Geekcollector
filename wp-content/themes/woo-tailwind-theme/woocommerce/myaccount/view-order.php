<?php
echo \Roots\view(
	'woocommerce.myaccount.view-order',
	[
		'order' => $order,
		'order_id' => $order_id,
	]
)->render();
