<?php
/**
 * Shipping Calculator override for Blade.
 * Path: /woocommerce/cart/shipping-calculator.php
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists('\Roots\view') ) {
    echo \Roots\view('woocommerce.cart.shipping-calculator', [
        'cart_url'       => wc_get_cart_url(),
        'button_text'    => ! empty( $button_text ) ? $button_text : __( 'Calculate shipping', 'woocommerce' ),
        'countries'      => WC()->countries->get_shipping_countries(),
        'current_cc'     => WC()->customer->get_shipping_country(),
        'current_r'      => WC()->customer->get_shipping_state(),
        'states'         => WC()->countries->get_states( WC()->customer->get_shipping_country() ),
        'city'           => WC()->customer->get_shipping_city(),
        'postcode'       => WC()->customer->get_shipping_postcode(),
        'button_class'   => wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '',
    ])->render();
} else {
    do_action( 'woocommerce_before_shipping_calculator' );
    ?>
    <form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

        <?php printf(
            '<a href="#" class="shipping-calculator-button" aria-expanded="false" aria-controls="shipping-calculator-form" role="button">%s</a>',
            esc_html( ! empty( $button_text ) ? $button_text : __( 'Calculate shipping', 'woocommerce' ) )
        ); ?>

        <section class="shipping-calculator-form" id="shipping-calculator-form" style="display:none;">

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_country', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_country_field">
                    <label for="calc_shipping_country"><?php esc_html_e( 'Country / region', 'woocommerce' ); ?></label>
                    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state country_select" rel="calc_shipping_state">
                        <option value="default"><?php esc_html_e( 'Select a country / region&hellip;', 'woocommerce' ); ?></option>
                        <?php
                        foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
                            echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
                        }
                        ?>
                    </select>
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_state', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_state_field">
                    <?php
                    $current_cc = WC()->customer->get_shipping_country();
                    $current_r  = WC()->customer->get_shipping_state();
                    $states     = WC()->countries->get_states( $current_cc );

                    if ( is_array( $states ) && empty( $states ) ) {
                        echo '<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" />';
                    } elseif ( is_array( $states ) ) {
                        echo '<span>
                            <label for="calc_shipping_state">' . esc_html__( 'State / County', 'woocommerce' ) . '</label>
                            <select name="calc_shipping_state" class="state_select" id="calc_shipping_state">
                                <option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';
                        foreach ( $states as $ckey => $cvalue ) {
                            echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) . '</option>';
                        }
                        echo '</select></span>';
                    } else {
                        echo '<label for="calc_shipping_state">' . esc_html__( 'State / County', 'woocommerce' ) . '</label>
                            <input type="text" class="input-text" value="' . esc_attr( $current_r ) . '" name="calc_shipping_state" id="calc_shipping_state" />';
                    }
                    ?>
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_city_field">
                    <label for="calc_shipping_city"><?php esc_html_e( 'City:', 'woocommerce' ); ?></label>
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
                </p>
            <?php endif; ?>

            <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
                <p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                    <label for="calc_shipping_postcode"><?php esc_html_e( 'Postcode / ZIP:', 'woocommerce' ); ?></label>
                    <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                </p>
            <?php endif; ?>

            <p>
                <button type="submit" name="calc_shipping" value="1" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
                    <?php esc_html_e( 'Update', 'woocommerce' ); ?>
                </button>
            </p>
            <?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>
        </section>
    </form>
    <?php
    do_action( 'woocommerce_after_shipping_calculator' );
}
