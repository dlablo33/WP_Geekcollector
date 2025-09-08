<?php
/**
 * Cross-sells override to allow Blade rendering.
 * Path: /woocommerce/cart/cross-sells.php
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists('\Roots\view') ) {
    echo \Roots\view('woocommerce.cart.cross-sells', [
        'cross_sells' => $cross_sells,
        'heading'     => apply_filters(
            'woocommerce_product_cross_sells_products_heading',
            __( 'You may be interested in&hellip;', 'woocommerce' )
        ),
    ])->render();
} else {
    // Fallback plantilla original
    if ( $cross_sells ) : ?>
        <div class="cross-sells">
            <?php
            $heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );

            if ( $heading ) :
                ?>
                <h2><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php foreach ( $cross_sells as $cross_sell ) : ?>
                <?php
                    $post_object = get_post( $cross_sell->get_id() );
                    setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore
                    wc_get_template_part( 'content', 'product' );
                ?>
            <?php endforeach; ?>

            <?php woocommerce_product_loop_end(); ?>
        </div>
    <?php
    endif;

    wp_reset_postdata();
}
