@php
    do_action('woocommerce_before_account_orders', $has_orders);
@endphp

@if ($has_orders)
    <div class="w-full overflow-hidden overflow-x-auto">
        <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table w-full text-center">
            <thead class="divide-y divide-white">
                <tr class="border-b border-white">
                    @foreach (wc_get_account_orders_columns() as $column_id => $column_name)
                        <th scope="col" class="woocommerce-orders-table__header woocommerce-orders-table__header-{{ esc_attr($column_id) }} py-2">
                            <span class="nobr">{{ esc_html($column_name) }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-white">
                @foreach ($customer_orders->orders as $customer_order)
                    @php
                        $order = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                    @endphp
                    <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-{{ esc_attr($order->get_status()) }} order border-b border-white">
                        @foreach (wc_get_account_orders_columns() as $column_id => $column_name)
                            @php
                                $is_order_number = 'order-number' === $column_id;
                            @endphp
                            @if ($is_order_number)
                                <th class="whitespace-nowrap  woocommerce-orders-table__cell woocommerce-orders-table__cell-{{ esc_attr($column_id) }} py-2 px-6 capitalize"
                                    data-title="{{ esc_attr($column_name) }}" scope="row">
                                @else
                                <td class="whitespace-nowrap woocommerce-orders-table__cell woocommerce-orders-table__cell-{{ esc_attr($column_id) }} py-2 px-6 capitalize"
                                    data-title="{{ esc_attr($column_name) }}">
                            @endif
                            @if (has_action('woocommerce_my_account_my_orders_column_' . $column_id))
                                @php
                                    do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order);
                                @endphp
                            @elseif($is_order_number)
                                @php
                                    /* translators: %s: the order number, usually accompanied by a leading # */
                                @endphp
                                <a href="{{ esc_url($order->get_view_order_url()) }}"
                                    aria-label="{{ esc_attr(sprintf(__('View order number %s', 'woocommerce'), $order->get_order_number())) }}">
                                    {{ esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()) }}
                                </a>
                            @elseif('order-date' === $column_id)
                                <time
                                    datetime="{{ esc_attr($order->get_date_created()->date('c')) }}">{{ esc_html(wc_format_datetime($order->get_date_created())) }}</time>
                            @elseif('order-status' === $column_id)
                                {{ esc_html(wc_get_order_status_name($order->get_status())) }}
                            @elseif('order-total' === $column_id)
                                @php
                                    /* translators: 1: formatted order total 2: total order items */
                                @endphp
                                {!! wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count)) !!}
                            @elseif('order-actions' === $column_id)
                                @php
                                    $actions = wc_get_account_orders_actions($order);
                                    if (!empty($actions)) {
                                        foreach ($actions as $key => $action) {
                                            // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                            if (empty($action['aria-label'])) {
                                                // Generate the aria-label based on the action name.
                                                /* translators: %1$s Action name, %2$s Order number. */
                                                $action_aria_label = sprintf(__('%1$s order number %2$s', 'woocommerce'), $action['name'], $order->get_order_number());
                                            } else {
                                                $action_aria_label = $action['aria-label'];
                                            }
                                            echo '<a href="' .
                                                esc_url($action['url']) .
                                                '" class="woocommerce-button' .
                                                esc_attr($wp_button_class) .
                                                ' button ' .
                                                sanitize_html_class($key) .
                                                '" aria-label="' .
                                                esc_attr($action_aria_label) .
                                                '">' .
                                                esc_html($action['name']) .
                                                '</a>';
                                            unset($action_aria_label);
                                        }
                                    }
                                @endphp
                            @endif
                            @if ($is_order_number)
                                </th>
                            @else
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @php
        do_action('woocommerce_before_account_orders_pagination');
    @endphp

    @if (1 < $customer_orders->max_num_pages)
        <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
            @if (1 !== $current_page)
                <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button{{ esc_attr($wp_button_class) }}"
                    href="{{ esc_url(wc_get_endpoint_url('orders', $current_page - 1)) }}">
                    @php
                        esc_html_e('Previous', 'woocommerce');
                    @endphp
                </a>
            @endif
            @if (intval($customer_orders->max_num_pages) !== $current_page)
                <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button{{ esc_attr($wp_button_class) }}"
                    href="{{ esc_url(wc_get_endpoint_url('orders', $current_page + 1)) }}">
                    @php
                        esc_html_e('Next', 'woocommerce');
                    @endphp
                </a>
            @endif

        </div>
    @endif
@else
    @php
        wc_print_notice(
            esc_html__('No order has been made yet.', 'woocommerce') .
                ' <a class="woocommerce-Button wc-forward button' .
                esc_attr($wp_button_class) .
                '" href="' .
                esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) .
                '">' .
                esc_html__('Browse products', 'woocommerce') .
                '</a>',
            'notice',
        ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment

    @endphp
@endif

@php

    do_action('woocommerce_after_account_orders', $has_orders);
@endphp
