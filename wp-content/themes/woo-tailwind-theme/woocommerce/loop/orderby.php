<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id_suffix = wp_unique_id();

?>
<!-- <form class="woocommerce-ordering rounded-2xl border-2 border-gray-800 bg-gray-900 p-0 shadow-2xl transition-all duration-500 hover:shadow-orange-500/10 hover:bg-gray-800 font-medium text-white group-hover:text-orange-400 transition-colors !mr-8" method="get">
	<?php if ( $use_label ) : ?>
		<label for="woocommerce-orderby-<?php echo esc_attr( $id_suffix ); ?>">
			<span ><?php echo esc_html__( 'Sort by', 'woocommerce' ); ?></span>
		</label>
	<?php endif; ?>
	<select
		name="orderby"
		style="appearance: none;"
		class="rounded-lg overflow-hidden transition-all duration-300 space-y-3 accordion-categories category-toggle p-3 flex justify-between items-center p-1 bg-gray-800 cursor-pointer group font-medium text-orange-400 transition-colors"
		<?php if ( $use_label ) : ?>
			id="woocommerce-orderby-<?php echo esc_attr( $id_suffix ); ?>"
		<?php else : ?>
			aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>"
		<?php endif; ?>>
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>>
  				• <?php echo esc_html($name); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
</div>
 -->