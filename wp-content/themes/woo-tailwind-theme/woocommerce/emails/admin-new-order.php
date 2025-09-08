<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 10.0.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

defined( 'ABSPATH' ) || exit;

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

// Validar $order para evitar errores en test emails
if ( empty( $order ) || ! is_a( $order, 'WC_Order' ) ) {
    // Para test emails de WP Mail SMTP, crear un objeto de pedido falso
    $order = new WC_Order();
    $order->set_billing_first_name( 'Test' );
    $order->set_billing_last_name( 'User' );
    $sent_to_admin = true;
    $plain_text = false;
    $email = null;
}

do_action( 'woocommerce_email_header', $email_heading ?? 'Nuevo pedido', $email );
?>

<?php
echo $email_improvements_enabled ? '<div class="email-introduction">' : '';
$text = __( 'You’ve received the following order from %s:', 'woocommerce' );
if ( $email_improvements_enabled ) {
    $text = __( 'You’ve received a new order from %s:', 'woocommerce' );
}
?>
<p><?php printf( esc_html( $text ), esc_html( $order->get_formatted_billing_full_name() ) ); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( ! empty( $additional_content ) ) {
    echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
    echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
    echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

do_action( 'woocommerce_email_footer', $email );

