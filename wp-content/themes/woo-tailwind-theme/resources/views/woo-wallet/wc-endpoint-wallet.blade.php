@php

    global $wp;
    do_action('woo_wallet_before_my_wallet_content');
    $is_rendred_from_myaccount = wc_post_content_has_shortcode('woo-wallet') ? false : is_account_page();
    $menu_items = apply_filters(
        'woo_wallet_nav_menu_items',
        [
            'top_up' => [
                'title' => apply_filters('woo_wallet_account_topup_menu_title', __('Wallet topup', 'woo-wallet')),
                'url' => $is_rendred_from_myaccount
                    ? esc_url(wc_get_endpoint_url(get_option('woocommerce_woo_wallet_endpoint', 'my-wallet'), 'add', wc_get_page_permalink('myaccount')))
                    : add_query_arg('wallet_action', 'add'),
                'icon' => 'dashicons dashicons-plus-alt',
            ],
            'transfer' => [
                'title' => apply_filters('woo_wallet_account_transfer_amount_menu_title', __('Wallet transfer', 'woo-wallet')),
                'url' => $is_rendred_from_myaccount
                    ? esc_url(wc_get_endpoint_url(get_option('woocommerce_woo_wallet_endpoint', 'my-wallet'), 'transfer', wc_get_page_permalink('myaccount')))
                    : add_query_arg('wallet_action', 'transfer'),
                'icon' => 'dashicons dashicons-randomize',
            ],
        ],
        $is_rendred_from_myaccount,
    );
@endphp

<div class="woo-wallet-my-wallet-container">
    <div class="woo-wallet-sidebar mb-2">
        <!-- Titulo -->
        <h3 class="woo-wallet-sidebar-heading mb-2 text-3xl font-bold">
            <a
                href="{{ $is_rendred_from_myaccount ? esc_url(wc_get_account_endpoint_url(get_option('woocommerce_woo_wallet_endpoint', 'my-wallet'))) : esc_url(get_permalink()) }}">
                {{ apply_filters('woo_wallet_account_menu_title', __('My Wallet', 'woo-wallet')) }}
            </a>
        </h3>
        <!-- Menu -->
        <ul class="flex gap-4">
            @foreach ($menu_items as $item => $menu_item)
                @if (apply_filters('woo_wallet_is_enable_' . $item, true))
                    <li class="card">

                        <a href="{{ esc_url($menu_item['url']) }}">
                            <div class="rounded-lg border bg-orange-500 px-4 py-2 text-black">
                                <span class="{{ esc_attr($menu_item['icon']) }}"></span>
                                <div>{{ esc_html($menu_item['title']) }}</div>
                            </div>

                        </a>
                    </li>
                @endif
            @endforeach
            @php
                do_action('woo_wallet_menu_items');
            @endphp

        </ul>
    </div>
    <div class="woo-wallet-content">
        <!-- Balance y Precio -->
        <div class="woo-wallet-content-heading mb-3 flex items-center gap-2">
            <h3 class="woo-wallet-content-h3 text-xl text-gray-300"> {{ esc_html_e('Balance', 'woo-wallet') }}:</h3>
            <div class="woo-wallet-price text-xl font-bold">{!! woo_wallet()->wallet->get_wallet_balance(get_current_user_id()) !!}</div>
        </div>
        <div style="clear: both"></div>
        <hr class="mb-2" />
        <!-- Recarga de Saldo -->
        @if ((isset($wp->query_vars['woo-wallet']) && !empty($wp->query_vars['woo-wallet'])) || isset($_GET['wallet_action']))
            @if (apply_filters('woo_wallet_is_enable_top_up', true) &&
                    ((isset($wp->query_vars['woo-wallet']) && 'add' === $wp->query_vars['woo-wallet']) || (isset($_GET['wallet_action']) && 'add' === $_GET['wallet_action'])))
                <form method="post" action="">
                    <div class="woo-wallet-add-amount flex flex-col">
                        <div class="mb-2">
                            <label for="woo_wallet_balance_to_add">{{ esc_html_e('Enter amount', 'woo-wallet') }}</label>
                        </div>
                        @php
                            $min_amount = woo_wallet()->settings_api->get_option('min_topup_amount', '_wallet_settings_general', 0);
                            $max_amount = woo_wallet()->settings_api->get_option('max_topup_amount', '_wallet_settings_general', '');
                        @endphp

                        <div class="mb-3">
                            <input type="text" inputmode="decimal" pattern="[0-9]*\.?[0-9]*" class="rounded-lg bg-white px-2 py-1 text-black"
                                min="{{ esc_attr($min_amount) }}" max="{{ esc_attr($max_amount) }}" name="woo_wallet_balance_to_add" id="woo_wallet_balance_to_add"
                                class="woo-wallet-balance-to-add" placeholder="0.00" required onblur="formatDecimal(this)" />
                        </div>
                        @php
                            wp_nonce_field('woo_wallet_topup', 'woo_wallet_topup');
                        @endphp
                        <div>
                            <input type="submit" name="woo_add_to_wallet" class="woo-add-to-wallet cursor-pointer rounded-lg bg-orange-500 px-6 py-2"
                                value="{{ esc_html_e('Add', 'woo-wallet') }}" />
                        </div>
                    </div>
                </form>
                <!-- Transferencia de fondos -->
            @elseif(apply_filters('woo_wallet_is_enable_transfer', 'on' === woo_wallet()->settings_api->get_option('is_enable_wallet_transfer', '_wallet_settings_general', 'on')) &&
                    ((isset($wp->query_vars['woo-wallet']) && 'transfer' === $wp->query_vars['woo-wallet']) ||
                        (isset($_GET['wallet_action']) && 'transfer' === $_GET['wallet_action'])))
                <form method="post" action="" id="woo_wallet_transfer_form">
                    <div class="woo-wallet-field-container form-row form-row-wide mb-4">
                        <label for="woo_wallet_transfer_user_id">{{ esc_html_e('Select whom to transfer', 'woo-wallet') }}
                            @if (apply_filters('woo_wallet_user_search_exact_match', true))
                                {{ esc_html_e('(Email)', 'woo-wallet') }}
                            @endif
                        </label>
                        <select name="woo_wallet_transfer_user_id" class="woo-wallet-select2" required=""></select>
                    </div>
                    <div class="woo-wallet-field-container form-row form-row-wide mb-2 flex gap-1">
                        <label for="woo_wallet_transfer_amount">{{ esc_html_e('Amount', 'woo-wallet') }}: </label>
                        <input type="input" value="100" class="rounded-lg bg-white px-2 text-black" step="0.01"
                            min="{{ woo_wallet()->settings_api->get_option('min_transfer_amount', '_wallet_settings_general', 100) }}" name="woo_wallet_transfer_amount"
                            required="" onblur="formatDecimal(this)" />
                    </div>
                    <div class="woo-wallet-field-container form-row form-row-wide mb-3 flex items-start gap-1">
                        <label for="woo_wallet_transfer_note">{{ esc_html_e('What\'s this for', 'woo-wallet') }}:</label>
                        <textarea name="woo_wallet_transfer_note" class="rounded-lg border bg-white"></textarea>
                    </div>
                    <div class="woo-wallet-field-container form-row">
                        {!! wp_nonce_field('woo_wallet_transfer', 'woo_wallet_transfer') !!}
                        <input type="submit" class="button rounded-lg bg-orange-500 px-6 py-2" name="woo_wallet_transfer_fund"
                            value="{{ esc_html_e('Proceed to transfer', 'woo-wallet') }}" />
                    </div>
                </form>
            @endif
            @php
                do_action('woo_wallet_menu_content');
            @endphp
            <!-- Transacciones -->
        @elseif(apply_filters('woo_wallet_is_enable_transaction_details', true))
            @php
                $transactions = get_wallet_transactions(['limit' => apply_filters('woo_wallet_transactions_count', 10)]);
            @endphp
            @if (!empty($transactions))

                <ul class="woo-wallet-transactions-items">
                    @foreach ($transactions as $transaction)
                        <li class="mb-2">
                            <div class="max-w-4/12 py-2 px-2 rounded-lg justify-between flex gap-2 border border-white bg-slate-900">
                                <div>
									{{ esc_html(wc_string_to_datetime($transaction->date)->date_i18n('y/m/d')) }} |
                                    {{ wp_kses_post($transaction->details) }} 
                                </div>
                                <div class="woo-wallet-transaction-type-{{ esc_attr($transaction->type) }} text-right">
                                    {{ 'credit' === $transaction->type ? '+' : '-' }}
                                    {!! wp_kses_post(
                                        wc_price(apply_filters('woo_wallet_amount', $transaction->amount, $transaction->currency, $transaction->user_id), woo_wallet_wc_price_args($transaction->user_id)),
                                    ) !!}
                                    

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                @php
                    esc_html_e('No transactions found', 'woo-wallet');
                @endphp
            @endif

        @endif
    </div>
</div>
@php
    do_action('woo_wallet_after_my_wallet_content');
@endphp
<script>
    function formatDecimal(input) {
        let value = input.value.trim();
        if (value && !isNaN(value)) {
            input.value = parseFloat(value).toFixed(2);
        }
    }
</script>
