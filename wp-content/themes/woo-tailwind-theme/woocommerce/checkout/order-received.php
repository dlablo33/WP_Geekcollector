<?php
echo \Roots\view('woocommerce.checkout.order-received', [
    'order_id' => $order->get_id(),
    'order' => $order
])->render();
