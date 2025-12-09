<?php
/**
 * Override WooCommerce Cart item data.
 * Path: /woocommerce/cart/cart-item-data.php
 *
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

defined('ABSPATH') || exit;

// Configuración para desarrollo - fuerza recarga de caché
if (defined('WP_DEBUG') && WP_DEBUG) {
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}

// Pasar datos adicionales a la vista Blade
$view_data = [
    'item_data' => $item_data,
    'scripts' => true // Habilita scripts adicionales
];

// Verificar si estamos en el contexto de Sage
if (function_exists('Roots\view')) {
    try {
        echo \Roots\view('woocommerce.cart.cart-item-data', $view_data)->render();
    } catch (Exception $e) {
        // Fallback seguro si hay error en la vista Blade
        error_log('Error rendering cart-item-data view: ' . $e->getMessage());
        $this->fallback_template($item_data);
    }
} else {
    $this->fallback_template($item_data);
}

// Función de fallback
if (!function_exists('fallback_template')) {
    function fallback_template($item_data) {
        ?>
        <dl class="variation">
            <?php foreach ($item_data as $data) : ?>
                <dt class="<?php echo sanitize_html_class('variation-' . $data['key']); ?>">
                    <?php echo wp_kses_post($data['key']); ?>:
                </dt>
                <dd class="<?php echo sanitize_html_class('variation-' . $data['key']); ?>">
                    <?php echo wp_kses_post(wpautop($data['display'])); ?>
                </dd>
            <?php endforeach; ?>
        </dl>
        <?php
    }
}