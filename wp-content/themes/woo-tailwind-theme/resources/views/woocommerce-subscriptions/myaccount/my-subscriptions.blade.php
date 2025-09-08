<div class="woocommerce_account_subscriptions">
    <h2 class="mb-2 border-b border-gray-600 py-1 text-xl font-semibold">Mis Membresías</h2>

    @if (!empty($subscriptions))
        <table
            class="my_account_subscriptions my_account_orders woocommerce-orders-table woocommerce-MyAccount-subscriptions shop_table shop_table_responsive woocommerce-orders-table--subscriptions w-full">

            <thead>
                <tr class="bg-gray-700 text-left text-gray-200">
                    <th
                        class="subscription-id order-number woocommerce-orders-table__header woocommerce-orders-table__header-order-number woocommerce-orders-table__header-subscription-id px-6 py-2">
                        <span class="nobr">{{ esc_html_e('Subscription', 'woocommerce-subscriptions') }}</span>
                    </th>
                    <th
                        class="subscription-status order-status woocommerce-orders-table__header woocommerce-orders-table__header-order-status woocommerce-orders-table__header-subscription-status px-6 py-2">
                        <span class="nobr">{{ esc_html_e('Status', 'woocommerce-subscriptions') }}</span>
                    </th>
                    <th
                        class="subscription-next-payment order-date woocommerce-orders-table__header woocommerce-orders-table__header-order-date woocommerce-orders-table__header-subscription-next-payment px-6 py-2">
                        <span class="nobr">{{ esc_html_x('Next payment', 'table heading', 'woocommerce-subscriptions') }}</span>
                    </th>
                    <th
                        class="subscription-total order-total woocommerce-orders-table__header woocommerce-orders-table__header-order-total woocommerce-orders-table__header-subscription-total px-6 py-2">
                        <span class="nobr">{{ esc_html_x('Total', 'table heading', 'woocommerce-subscriptions') }}</span>
                    </th>
                    <th
                        class="subscription-actions order-actions woocommerce-orders-table__header woocommerce-orders-table__header-order-actions woocommerce-orders-table__header-subscription-actions px-6 py-2">
                        &nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subscriptions as $subscription_id => $subscription)
                    <tr class="order woocommerce-orders-table__row woocommerce-orders-table__row--status-{{ esc_attr($subscription->get_status()) }}">
                        <!-- Orden -->
                        <td class="subscription-id order-number woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-id woocommerce-orders-table__cell-order-number px-6 py-2"
                            data-title="{{ esc_attr_e('ID', 'woocommerce-subscriptions') }}">
                            <a href="{{ esc_url($subscription->get_view_order_url()) }}"
                                aria-label="{{ esc_attr(sprintf(__('View subscription number %s', 'woocommerce-subscriptions'), $subscription->get_order_number())) }}">
                                {{ esc_html(sprintf(_x('#%s', 'hash before order number', 'woocommerce-subscriptions'), $subscription->get_order_number())) }}
                            </a>
                            @php
                                do_action('woocommerce_my_subscriptions_after_subscription_id', $subscription);
                            @endphp
                        </td>
                        <!-- Estatus -->
                        <td class="subscription-status order-status woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-status woocommerce-orders-table__cell-order-status px-6 py-2"
                            data-title="{{ esc_attr_e('Status', 'woocommerce-subscriptions') }}">
                            {{ esc_attr(wcs_get_subscription_status_name($subscription->get_status())) }}
                        </td>
                        <!-- Siguiente Pago -->
                        <td class="subscription-next-payment order-date woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-next-payment woocommerce-orders-table__cell-order-date px-6 py-2 capitalize"
                            data-title="{{ esc_attr_x('Next Payment', 'table heading', 'woocommerce-subscriptions') }}">
                            {{ esc_attr($subscription->get_date_to_display('next_payment')) }}
                            @if (!$subscription->is_manual() && $subscription->has_status('active') && $subscription->get_time('next_payment') > 0)
                                <br /><small>{{ esc_attr($subscription->get_payment_method_to_display('customer')) }}</small>
                            @endif
                        </td>
                        <!-- Total -->
                        <td class="subscription-total order-total woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-total woocommerce-orders-table__cell-order-total px-6 py-2"
                            data-title="{{ esc_attr_x('Total', 'Used in data attribute. Escaped', 'woocommerce-subscriptions') }}">
                            {!! wp_kses_post($subscription->get_formatted_order_total()) !!}
                        </td>
                        <!-- Accion -->
                        <td
                            class="subscription-actions order-actions woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-actions woocommerce-orders-table__cell-order-actions">
                            <a href="{{ esc_url($subscription->get_view_order_url()) }}"
                                class="woocommerce-button button view{{ esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') }}">
                                {{ esc_html_x('View', 'view a subscription', 'woocommerce-subscriptions') }}
                            </a>
                            @php
                                do_action('woocommerce_my_subscriptions_actions', $subscription);
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        @if (1 < $max_num_pages)
            <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
                @if (1 !== $current_page)
                    <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button"
                        href="{{ esc_url(wc_get_endpoint_url('subscriptions', $current_page - 1)) }}">{{ esc_html_e('Previous', 'woocommerce-subscriptions') }}</a>
                @endif
                @if (intval($max_num_pages) !== $current_page)
                    <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button"
                        href="{{ esc_url(wc_get_endpoint_url('subscriptions', $current_page + 1)) }}">{{ esc_html_e('Next', 'woocommerce-subscriptions') }}</a>
                @endif
            </div>
        @endif
    @else
        <div class="no_subscriptions woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
            @if (1 < $current_page)
                {!! printf(
                    esc_html__('You have reached the end of subscriptions. Go to the %sfirst page%s.', 'woocommerce-subscriptions'),
                    '<a href="' . esc_url(wc_get_endpoint_url('subscriptions', 1)) . '">',
                    '</a>',
                ) !!}
            @else
                {{ esc_html_e('You have no active subscriptions.', 'woocommerce-subscriptions') }}
                <a class="woocommerce-Button button" href="{{ esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) }}">
                    {{ esc_html_e('Browse products', 'woocommerce-subscriptions') }}
                </a>
            @endif

        </div>
    @endif

</div>
