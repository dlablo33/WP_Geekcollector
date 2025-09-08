<?php
echo \Roots\view('woocommerce-subscriptions.myaccount.my-subscriptions',[
	'current_page' => $current_page,
	'subscriptions' => $subscriptions,
	'max_num_pages' => $max_num_pages,
])->render();
