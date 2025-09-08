<?php
defined( 'ABSPATH' ) || exit;
?>

<?php
/**
 * Before account navigation
 */
do_action( 'woocommerce_before_account_navigation' );

/**
 * My Account navigation.
 */
do_action( 'woocommerce_account_navigation' );

/**
 * After account navigation
 */
do_action( 'woocommerce_after_account_navigation' );
?>

<div class="woocommerce-MyAccount-content">
    <?php
        /**
         * My Account content.
         */
        do_action( 'woocommerce_before_account_content' );

        if ( function_exists('\Roots\view') ) {
            echo \Roots\view('woocommerce.myaccount.my-account')->render();
        } else {
            do_action( 'woocommerce_account_content' );
        }

        do_action( 'woocommerce_after_account_content' );
    ?>
</div>
