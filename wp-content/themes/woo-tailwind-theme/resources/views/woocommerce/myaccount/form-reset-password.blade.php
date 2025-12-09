@php
    do_action('woocommerce_before_reset_password_form');
@endphp

<div class="mx-auto py-10 max-w-6xl text-white md:py-30">
    <div class="mb-10 md:mb-30 px-4">
		<form method="post" class="woocommerce-ResetPassword lost_reset_password">
			<div class="text-2xl font-semibold">
				{{ apply_filters('woocommerce_reset_password_message', esc_html__('Enter a new password below.', 'woocommerce')) }}
			</div>
			<div class="flex flex-col gap-4 md:flex-row">
				<div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first flex-col">
					<label for="password_1">
						{{ esc_html_e('New password', 'woocommerce') }}&nbsp;<span class="required" aria-hidden="true">*</span>
						<span class="screen-reader-text"><?php esc_html_e('Required', 'woocommerce'); ?></span>
					</label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" required
						aria-required="true" />
				</div>
				<div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last flex-col">
					<label for="password_2">{{ esc_html_e('Re-enter new password', 'woocommerce') }}&nbsp;
						<span class="required" aria-hidden="true">*</span>
						<span class="screen-reader-text">{{ esc_html_e('Required', 'woocommerce') }}</span>
					</label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" required
						aria-required="true" />
				</div>
			</div>
			<input type="hidden" name="reset_key" value="{{ esc_attr($args['key']) }}" />
			<input type="hidden" name="reset_login" value="{{ esc_attr($args['login']) }}" />
			<div class="clear"></div>
			@php
				do_action('woocommerce_resetpassword_form');
			@endphp
			<!-- Boton Guardar -->
			<div class="mt-10 flex justify-center">
				<div class="woocommerce-form-row form-row mb-15 mx-auto w-full rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] md:w-60">
					<button type="submit"
						class="woocommerce-Button w-full cursor-pointer rounded-full bg-black px-2 py-2 text-sm font-semibold text-white md:px-2 md:text-xl"
						value="{{ esc_attr_e('Save', 'woocommerce') }}">
						{{ esc_html_e('Save', 'woocommerce') }}
					</button>
				</div>
			</div>
			{!! wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce') !!}
		</form>
	</div>
</div>
@php
    do_action('woocommerce_after_reset_password_form');
@endphp
