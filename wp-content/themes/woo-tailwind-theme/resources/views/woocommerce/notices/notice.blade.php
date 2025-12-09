@php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

@endphp
@foreach ( $notices as $notice )
	<div class="woocommerce-info [&::before]:!hidden md:!w-full !flex !flex-row !flex-wrap !justify-start !items-center !bg-orange-500 !text-white !block !rounded-2xl !px-4 !py-2 !m-0 !mb-2 !border-0"<?php echo wc_get_notice_data_attr( $notice ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<img class="mr-3" width="20" height="20" src="https://img.icons8.com/FFFFFF/ios-filled/50/speech-bubble-with-dots.png" alt="speech-bubble-with-dots"/>
		{!! wc_kses_notice( $notice['notice'] ) !!}
	</div>
@endforeach
