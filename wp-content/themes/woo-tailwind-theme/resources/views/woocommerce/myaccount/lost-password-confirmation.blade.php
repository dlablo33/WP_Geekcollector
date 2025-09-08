@php
    // wc_print_notice(esc_html__('Password reset email has been sent.', 'woocommerce'));
@endphp

{{ do_action('woocommerce_before_lost_password_confirmation_message') }}
<div class="mx-auto my-1 max-w-6xl md:my-20">
    <div class="flex flex-col justify-center px-4">
        <!-- Animación -->
        <div class="md:mb-15 mb-12 flex h-40 w-full items-center justify-center">
            <img src="{{ get_stylesheet_directory_uri() }}/resources/images/mail.gif" alt="GeekCollector Animation" class="h-48 w-auto object-contain">
        </div>

        <!-- Mensaje -->
        <div class="mb-6 text-center text-lg text-white md:text-2xl">
            {{ esc_html(
                apply_filters(
                    'woocommerce_lost_password_confirmation_message',
                    esc_html__(
                        'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.',
                        'woocommerce',
                    ),
                ),
            ) }}
        </div>

        <!-- Boton Inicio -->
        <div class="mb-15 mx-auto w-full rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] md:w-60">
            <a href="https://geekcollector.com/">
                <button type="button" class="w-full cursor-pointer rounded-full bg-black px-2 py-2 text-sm font-semibold text-white md:px-2 md:text-xl">
                    Inicio
                </button>
            </a>
        </div><
    </div>
</div>

{{ do_action('woocommerce_after_lost_password_confirmation_message') }}
