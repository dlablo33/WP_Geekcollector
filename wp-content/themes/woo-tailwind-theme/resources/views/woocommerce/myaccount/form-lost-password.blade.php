@php
    do_action('woocommerce_before_lost_password_form');
@endphp

<div class="mx-auto py-20 md:py-30 max-w-6xl ">
    <div class="px-4 mb-35">
        
        <form method="post" class="woocommerce-ResetPassword lost_reset_password text-white">
            @php
                $msg = apply_filters(
                    'woocommerce_lost_password_message',
                    esc_html__(
                        'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.',
                        'woocommerce',
                    ),
                );
                $parts = explode('?', $msg, 2);
                $msg_b = $parts[0] . '?';
                $msg_a = count($parts) > 1 ? $parts[1] : '';
            @endphp
            <div class="mb-4 text-xl text-center font-semibold">
                {{ $msg_b }}
            </div>
			<div class="mb-4 text-left text-lg md:text-center md:text-xl">
                {{ $msg_a }}
            </div>

            <div class="flex flex-col items-center gap-2 md:items-end md:gap-4 md:flex-row justify-center">
                <!-- Input -->
				<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                    <label for="user_login">
                        {{ esc_html_e('Username or email', 'woocommerce') }}
                        &nbsp;<span class="required" aria-hidden="true">*</span><span class="screen-reader-text">
                            {{ esc_html_e('Required', 'woocommerce') }}
                        </span>
                    </label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text w-3/6 rounded-xl md:w-full" type="text" name="user_login" id="user_login"
                        autocomplete="username" required aria-required="true" />
                </div>

                <div class="clear"></div>
                @php
                    do_action('woocommerce_lostpassword_form');
                @endphp

                <!-- Boton Submit -->
                <div class="woocommerce-form-row form-row">
                    <input type="hidden" name="wc_reset_password" value="true" />
                    <div
                        class="w-full cursor-pointer rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] transition-all duration-300 hover:from-yellow-300 hover:via-orange-500 hover:to-red-500 md:w-60">
                        <button type="submit" class="w-full rounded-full bg-black px-2 py-2 text-base font-semibold text-white md:px-2 md:text-xl"
                            value="{{ esc_attr_e('Reset password', 'woocommerce') }}">
                            {{ esc_html_e('Reset password', 'woocommerce') }}
                        </button>
                    </div>
                    @php
                        wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce');
                    @endphp
                </div>
            </div>
        </form>
    </div>
</div>

@php
    do_action('woocommerce_after_lost_password_form');
@endphp
