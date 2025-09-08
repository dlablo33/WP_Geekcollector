<div class="text-white">
    <form class="woocommerce-EditAccountForm edit-account" method="post" action="" @php do_action('woocommerce_edit_account_form_tag') @endphp>
        @php
            $user = wp_get_current_user();
            do_action('woocommerce_edit_account_form_start');
        @endphp

        <!-- Nombre -->
        <div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first mb-2">
            <label class="text-xl" for="account_first_name">
                {{ esc_html_e('First name', 'woocommerce') }}<span class="required" aria-hidden="true">*</span>:
            </label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text rounded-lg border-2 bg-white px-2 text-black" name="account_first_name"
                id="account_first_name" autocomplete="given-name" value="{{ esc_attr($user->first_name) }}" aria-required="true" />
        </div>

        <!-- Apellido -->
        <div class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last mb-2">
            <label for="account_last_name" class="text-xl">
                {{ esc_html_e('Last name', 'woocommerce') }}<span class="required" aria-hidden="true">*</span>:
            </label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text input-text rounded-lg border-2 bg-white px-2 text-black"
                name="account_last_name" id="account_last_name" autocomplete="family-name" value="{{ esc_attr($user->last_name) }}" aria-required="true" />
        </div>
        <div class="clear"></div>

        <!-- Display Nombre -->
        <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-2 flex flex-col items-start md:items-center gap-1 md:flex-row">
            <label for="account_display_name" class="text-xl">
                {{ esc_html_e('Display name', 'woocommerce') }}<span class="required" aria-hidden="true">*:</span>
            </label>

            <div class="flex items-center gap-2">
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text rounded-lg border-2 bg-white px-2 text-black"
                    name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="{{ esc_attr($user->display_name) }}"
                    aria-required="true" />
                <!-- daisyUI Tooltip -->
                <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
                <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
                <div class="tooltip" data-tip="{{ esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce') }}.">
                    <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

        </div>
        <div class="clear"></div>

        <!-- Email -->
        <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="account_email" class="text-xl">
                {{ esc_html_e('Email', 'woocommerce') }}<span class="required" aria-hidden="true">*:</span>
            </label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text cursor-default rounded-lg border-2 bg-white px-2 text-black focus:ring-0"
                readonly name="account_email" id="account_email" autocomplete="email" value="{{ esc_attr($user->user_email) }}" aria-required="true" />
        </div>

        @php
            // do_action('woocommerce_edit_account_form_fields');
        @endphp

        <!-- Cambio de Contraseña -->
        <div class="collapse">
            <input type="checkbox" class="peer" />
            <div class="collapse-title text-large text-primary-content peer-checked:bg-secondary peer-checked:text-secondary-content">
                <div class="flex gap-2 text-xl font-bold text-orange-500">
                    <svg class="h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ esc_html_e('Password change', 'woocommerce') }}
                </div>
            </div>

            <div
                class="collapse-content text-primary-content peer-checked:bg-secondary peer-checked:text-secondary-content max-h-0 overflow-hidden transition-all duration-700 ease-in-out peer-checked:max-h-[500px]">
                <!-- Contraseña Actual -->
                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-2">
                    <label for="password_current">{{ esc_html_e('Current password (leave blank to leave unchanged)', 'woocommerce') }}:</label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text rounded-lg border-2 bg-white px-2 text-black"
                        name="password_current" id="password_current" autocomplete="off" />
                </div>

                <!-- Nueva Contraseña -->
                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-2">
                    <label for="password_1">
                        {{ esc_html_e('New password (leave blank to leave unchanged)', 'woocommerce') }}:</label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text rounded-lg border-2 bg-white px-2 text-black" name="password_1"
                        id="password_1" autocomplete="off" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide mb-2">
                    <label for="password_2">{{ esc_html_e('Confirm new password', 'woocommerce') }}:</label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text rounded-lg border-2 bg-white px-2 text-black"
                        name="password_2" id="password_2" autocomplete="off" />
                </div>
            </div>
        </div>

        <div class="clear"></div>
        @php
            do_action('woocommerce_edit_account_form');
        @endphp
        <div>
            @php
                wp_nonce_field('save_account_details', 'save-account-details-nonce');
            @endphp

            <!-- Boton Submit -->
            <button type="submit"
                class="woocommerce-Button button {{ esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') }} inline-block cursor-pointer rounded-full bg-500 p-[2px]"
                name="save_account_details" value="{{ esc_attr_e('Save changes', 'woocommerce') }}">
                <div class="rounded-full bg-orange-500 px-4 py-2 text-sm font-bold text-white md:text-lg">
                    {{ esc_html_e('Save changes', 'woocommerce') }}
                </div>
            </button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>
        @php
            do_action('woocommerce_edit_account_form_end');
        @endphp
    </form>
</div>

@php
    do_action('woocommerce_after_edit_account_form');
@endphp
