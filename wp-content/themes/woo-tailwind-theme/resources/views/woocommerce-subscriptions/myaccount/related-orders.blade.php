<header>
    {{-- <h2>{{ esc_html_e('Related orders', 'woocommerce-subscriptions') }}</h2> --}}
	<h2 class="text-xl py-1 mb-2 border-b border-gray-600 font-semibold">Orden Relacionada</h2>
</header>

<table id="woocommerce-subscriptions-related-orders-table"
    class="shop_table shop_table_responsive my_account_orders woocommerce-orders-table woocommerce-MyAccount-orders woocommerce-orders-table--orders w-full">

    <thead>
        <tr class="bg-gray-700 text-gray-200">
            <th class=" px-6 py-2 order-number woocommerce-orders-table__header woocommerce-orders-table__header-order-number text-left"><span
                    class="nobr"># {{ esc_html_e('Order', 'woocommerce-subscriptions') }}</span>
            </th>
            <th class=" px-6 py-2 order-date woocommerce-orders-table__header woocommerce-orders-table__header-order-date woocommerce-orders-table__header-order-date text-left"><span
                    class="nobr">{{ esc_html_e('Date', 'woocommerce-subscriptions') }}</span></th>
            <th class=" px-6 py-2 order-status woocommerce-orders-table__header woocommerce-orders-table__header-order-status text-left"><span
                    class="nobr">{{ esc_html_e('Status', 'woocommerce-subscriptions') }}</span>
            </th>
            <th class=" px-6 py-2 order-total woocommerce-orders-table__header woocommerce-orders-table__header-order-total text-left"><span
                    class="nobr">{{ esc_html_x('Total', 'table heading', 'woocommerce-subscriptions') }}</span></th>
            <th class=" px-6 py-2 order-actions woocommerce-orders-table__header woocommerce-orders-table__header-order-actions text-left">&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($subscription_orders as $subscription_order)
            @php
                $order = wc_get_order($subscription_order);
                if (!$order) {
                    continue;
                }
                $item_count = $order->get_item_count();
                $order_date = $order->get_date_created();
            @endphp

            <tr class="order woocommerce-orders-table__row woocommerce-orders-table__row--status-{{ esc_attr($order->get_status()) }} ">
                <!-- Orden -->
				<td class="px-6 py-2 order-number woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                    data-title="{{ esc_attr_e('Order Number', 'woocommerce-subscriptions') }}">
                    <!-- translators: placeholder is an order number. -->

                    <a href="{{ esc_url($order->get_view_order_url()) }}"
                        aria-label="{{ esc_attr(sprintf(__('View order number %s', 'woocommerce-subscriptions'), $order->get_order_number())) }}">
                        {{ sprintf(esc_html_x('#%s', 'hash before order number', 'woocommerce-subscriptions'), esc_html($order->get_order_number())) }}
                    </a>
                </td>
				<!-- Fecha -->
                <td class="px-6 py-2 order-date woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date capitalize"
                    data-title="{{ esc_attr_e('Date', 'woocommerce-subscriptions') }}">
                    <time datetime="{{ esc_attr($order_date->date('Y-m-d')) }}"
                        title="{{ esc_attr($order_date->getTimestamp()) }}">{{ wp_kses_post($order_date->date_i18n(wc_date_format())) }}</time>
                </td>
				<!-- Estatus -->
                <td class="px-6 py-2 order-status woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                    data-title="{{ esc_attr_e('Status', 'woocommerce-subscriptions') }}" style="white-space:nowrap;">
                    {{ esc_html(wc_get_order_status_name($order->get_status())) }}
                </td>
				<!-- Total -->
                <td class="px-6 py-2 order-total woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                    data-title="{{ esc_attr_x('Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions') }}">
                    {!! wp_kses_post(
                        sprintf(_n('%1$s', '%1$s', $item_count, 'woocommerce-subscriptions'), $order->get_formatted_order_total(), $item_count),
                    ) !!}
                </td>
				<!-- Accion -->
                <td class="px-6 py-2 order-actions woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions">
                    @php

                        $actions = [];

                        if ($order->needs_payment() && $order->get_id() === $subscription->get_last_order('ids', 'any')) {
                            $actions['pay'] = [
                                'url' => $order->get_checkout_payment_url(),
                                'name' => esc_html_x('Pay', 'pay for a subscription', 'woocommerce-subscriptions'),
                            ];
                        }

                        if (in_array($order->get_status(), apply_filters('woocommerce_valid_order_statuses_for_cancel', ['pending', 'failed'], $order))) {
                            $redirect = wc_get_page_permalink('myaccount');

                            if (wcs_is_view_subscription_page()) {
                                $redirect = $subscription->get_view_order_url();
                            }

                            $actions['cancel'] = [
                                'url' => $order->get_cancel_order_url($redirect),
                                'name' => esc_html_x('Cancel', 'an action on a subscription', 'woocommerce-subscriptions'),
                            ];
                        }

                        $actions['view'] = [
                            'url' => $order->get_view_order_url(),
                            'name' => esc_html_x('View', 'view a subscription', 'woocommerce-subscriptions'),
                        ];

                        $actions = apply_filters('woocommerce_my_account_my_orders_actions', $actions, $order);

                        if ($actions) {
                            foreach ($actions as $key => $action) {
                                echo wp_kses_post(
                                    '<a href="' .
                                        esc_url($action['url']) .
                                        '" class="woocommerce-button px-2 button ' .
                                        sanitize_html_class($key) .
                                        esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') .
                                        '">' .
                                        esc_html($action['name']) .
                                        '</a>',
                                );
                            }
                        }
                    @endphp
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<?php
/**
 * Allows additional content to be added following the related orders table.
 *
 * @since 2.0.0 Hook added.
 * @since 7.5.0 Additional params $subscription_orders, $page and $max_num_pages added.
 *
 * @param WC_Subscription $subscription
 * @param int[]           $subscription_orders
 * @param int             $page
 * @param int             $max_num_pages
 */
do_action('woocommerce_subscription_details_after_subscription_related_orders_table', $subscription, $subscription_orders, $page, $max_num_pages);
?>
