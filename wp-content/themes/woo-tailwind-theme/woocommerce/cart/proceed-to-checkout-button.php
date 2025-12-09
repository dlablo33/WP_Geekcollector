<?php
/**
 * Proceed to checkout button override for Blade.
 * Path: /woocommerce/cart/proceed-to-checkout-button.php
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists('\Roots\view') ) {
    echo \Roots\view('woocommerce.cart.proceed-to-checkout-button', [
        'checkout_url' => wc_get_checkout_url(),
        'button_class' => 'checkout-button button alt wc-forward' . ( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ),
    ])->render();
} else {
    ?>
    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
       class="checkout-button button alt wc-forward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
        <?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
    </a>
    <?php
}
