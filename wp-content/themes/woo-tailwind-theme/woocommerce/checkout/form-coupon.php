<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle">
	<?php
		/**
		 * Filter checkout coupon message.
		 *
		 * @param string $message coupon message.
		 * @return string Filtered message.
		 *
		 * @since 1.0.0
		 */
		wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . '<a href="#" id="toggleCouponFormButton" role="button" aria-label="' . esc_attr__( 'Enter your coupon code', 'woocommerce' ) . '" aria-controls="woocommerce-checkout-form-coupon" aria-expanded="false" class="showcoupon text-blue-600 hover:text-blue-800 underline ml-1">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' );
	?>        	 						
	<form class="checkout_coupon woocommerce-form-coupon" method="post" id="woocommerce-checkout-form-coupon">
	<div id="woocommerce-checkout-form-coupon-backup" class="w-full coupon-form-backup coupon-form-backup-hidden">
		<p class="form-row mb-2">
			<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
			<input type="text" name="coupon_code" class="input-text px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
		</p>

		<p class="form-row mb-2">
			<button type="submit" class="button rounded-full px-4 py-2 transition-colors bg-gray-800 text-orange-500 hover:bg-orange-500 hover:text-white<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
		</p>

		<div class="clear"></div>
	</div>
	</form>
	<style>
		div#woocommerce-checkout-form-coupon-backup.coupon-form-backup {
			transition: all 0.3s ease-in-out !important;
			height: 106px !important;
			transform: scaleY(1) !important;
			overflow: hidden;
		}

		div#woocommerce-checkout-form-coupon-backup.coupon-form-backup.coupon-form-backup-hidden {
			transition: all 0.3s ease-in-out !important;
			height: 0 !important;
			transform: scaleY(0) !important;
		}
	</style>
	<script>
		const couponFormElement = document.getElementById( 'woocommerce-checkout-form-coupon' );
		const couponFormElementBackup = document.getElementById( 'woocommerce-checkout-form-coupon-backup' );
		const toggleCouponFormButton = document.getElementById( 'toggleCouponFormButton' );
		let variable = null;
		if ( !couponFormElement ) {
			console.log('esto funciona');
			toggleCouponFormButton.addEventListener('click', function(e) {
				e.preventDefault();
				couponFormElementBackup.classList.toggle('coupon-form-backup-hidden');
			});
		}
		else {
			couponFormElementBackup.classList.remove('coupon-form-backup-hidden');
		}
	</script>
</div>