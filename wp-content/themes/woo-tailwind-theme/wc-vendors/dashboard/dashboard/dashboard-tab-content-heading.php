<?php
echo \Roots\view('wc-vendors.dashboard.dashboard-tab-content-heading', [
    'store_setup_steps' => $store_setup_steps,
    'welcome_message' => $welcome_message,
    'is_dismissed' => $is_dismissed,
    'time' => $time,
])->render();
