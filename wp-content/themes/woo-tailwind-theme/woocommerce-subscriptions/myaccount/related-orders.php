<?php
echo \Roots\view('woocommerce-subscriptions.myaccount.related-orders', [
	'subscription' => $subscription,
	'subscription_orders' => $subscription_orders,
	'page' => $page,
	'max_num_pages' => $max_num_pages,
])->render();
