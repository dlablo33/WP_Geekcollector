<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Wrapper inicio (abre contenedor principal de WooCommerce)
do_action( 'woocommerce_before_main_content' );

// Cabecera de categorías (nombre, descripción, etc.)
do_action( 'woocommerce_shop_loop_header' );
?>
@php(dd('Estoy en archive-product.blade.php de Blade'))

<div class="container mx-auto grid grid-cols-1 gap-8 px-4 py-12 lg:grid-cols-4">
    <?php get_template_part('partials/aside-filters'); ?>

    <section class="lg:col-span-3">
        <?php if ( have_posts() ) : ?>
            <ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php
                while ( have_posts() ) :
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
                ?>
            </ul>

            <?php
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php else : ?>
            <p class="text-center text-gray-500">No hay productos en esta categoría.</p>
        <?php endif; ?>
    </section>
</div>

<?php
// Wrapper cierre
do_action( 'woocommerce_after_main_content' );


get_footer( 'shop' );
