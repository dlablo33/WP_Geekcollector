<?php
echo \Roots\view('wc-vendors.dashboard.dashboard-tab-content-sales-snapshot', [
    'chart_data' => $chart_data,
    'sales_snapshot' => $sales_snapshot,
    'time' => $time,
])->render();
