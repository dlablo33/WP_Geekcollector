<?php
/**
 * Override WooCommerce Empty Cart page content but keep hooks intact.
 * Path: /woocommerce/cart/cart-empty.php
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Empty cart hooks (mensajes u otros elementos que añade WooCommerce).
 */
do_action( 'woocommerce_cart_is_empty' );

if ( function_exists('\Roots\view') ) {
    // Renderizar la vista Blade personalizada en resources/views/woocommerce/cart/cart-empty.blade.php
    echo \Roots\view('woocommerce.cart.cart-empty')->render();
} else {
    // Fallback al template clásico si Blade no está disponible
    if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop">
            <a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                <?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) ); ?>
            </a>
        </p>
    <?php endif;
}
