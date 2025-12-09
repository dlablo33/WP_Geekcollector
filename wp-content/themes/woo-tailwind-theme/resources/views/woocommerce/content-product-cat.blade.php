<?php 
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li <?php wc_product_cat_class('product-card animate-fade-in-up transform overflow-hidden rounded-2xl border-2 border-gray-800 bg-gray-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/30 hover:shadow-2xl', $category); ?>>
  <div class="relative">
    <?php
    /**
     * The woocommerce_before_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_open - 10
     */
    do_action( 'woocommerce_before_subcategory', $category );
    ?>

    <div class="aspect-w-1 aspect-h-1 group">
      <?php
      /**
       * The woocommerce_before_subcategory_title hook.
       *
       * @hooked woocommerce_subcategory_thumbnail - 10
       */
      // Modificamos el hook para añadir clases personalizadas
      remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
      add_action( 'woocommerce_before_subcategory_title', 'custom_subcategory_thumbnail', 10 );
      function custom_subcategory_thumbnail( $category ) {
        $small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'medium' );
        $thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );
        
        if ( $thumbnail_id ) {
          $image = wp_get_attachment_image( $thumbnail_id, $small_thumbnail_size, '', array(
            'class' => 'w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110'
          ) );
        } else {
          $image = '<div class="flex h-64 w-full items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">';
          $image .= '<svg class="h-16 w-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
          $image .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>';
          $image .= '</svg>';
          $image .= '</div>';
        }
        
        echo $image;
      }
      do_action( 'woocommerce_before_subcategory_title', $category );
      ?>

      <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/70 to-transparent p-6 opacity-0 transition-opacity duration-500 group-hover:opacity-100">
        <span class="inline-block translate-y-3 transform rounded-full bg-orange-600 px-4 py-2 text-sm font-bold text-white transition-transform duration-500 group-hover:translate-y-0">
          Ver Categoría
        </span>
      </div>
    </div>

    <?php
    /**
     * The woocommerce_after_subcategory_title hook.
     */
    do_action( 'woocommerce_after_subcategory_title', $category );
    ?>

    <div class="p-5">
      <div class="mb-3 flex items-start justify-between">
        <h3 class="text-lg font-bold text-white transition-colors hover:text-orange-400">
          <?php
          /**
           * The woocommerce_shop_loop_subcategory_title hook.
           *
           * @hooked woocommerce_template_loop_category_title - 10
           */
          // Modificamos el hook para personalizar el título
          remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
          add_action( 'woocommerce_shop_loop_subcategory_title', 'custom_template_loop_category_title', 10 );
          function custom_template_loop_category_title( $category ) {
            echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '" class="hover:text-orange-400 transition-colors">';
            echo esc_html( $category->name );
            echo '</a>';
          }
          do_action( 'woocommerce_shop_loop_subcategory_title', $category );
          ?>
        </h3>
        
        <!-- Contador de productos -->
        <div class="flex items-center rounded-full bg-gray-800 px-2 py-1">
          <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
          </svg>
          <span class="ml-1 text-xs font-bold text-white">
            <?php echo $category->count; ?>
          </span>
        </div>
      </div>

      <p class="mb-4 line-clamp-2 text-sm text-gray-400">
        <?php
          if ( $category->description ) {
            echo esc_html( $category->description );
          } else {
            echo 'Explora nuestra colección de ' . esc_html( $category->name );
          }
        ?>
      </p>

      <a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>" 
         class="inline-flex transform items-center rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-4 py-2 text-sm font-bold text-white shadow transition-all duration-300 hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/20">
        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
        Explorar
      </a>
    </div>

    <?php
    /**
     * The woocommerce_after_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_close - 10
     */
    do_action( 'woocommerce_after_subcategory', $category );
    ?>
  </div>
</li>

<?php
// Restauramos los hooks originales para no afectar otros templates
remove_action( 'woocommerce_before_subcategory_title', 'custom_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

remove_action( 'woocommerce_shop_loop_subcategory_title', 'custom_template_loop_category_title', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
?>