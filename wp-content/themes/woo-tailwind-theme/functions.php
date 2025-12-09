<?php

use Roots\Acorn\Application;
use PKPass\PKPass;
use Google\Client;
use Google\Service\Walletobjects;
use Firebase\JWT\JWT;

require_once ABSPATH . 'vendor/autoload.php'; 

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
    ->withProviders([
        App\Providers\ThemeServiceProvider::class,
    ])
    ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });


add_action('after_setup_theme', function () {
    add_filter('wc_get_template', function ($located, $template_name, $args, $template_path, $default_path) {
        error_log("WC carga plantilla: {$template_name} -> {$located}");
        return $located;
    }, 10, 5);
});

// ===================================================================================================================================================================
// Esto lo agrego Carlos
// ===================================================================================================================================================================

// Actualizar precio de carrito al cambiar cantidad
add_action('wp_ajax_update_cart_item', 'custom_update_cart_item');
add_action('wp_ajax_nopriv_update_cart_item', 'custom_update_cart_item');

function custom_update_cart_item()
{
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity      = intval($_POST['quantity']);

    if (isset(WC()->cart->cart_contents[$cart_item_key])) {
        WC()->cart->set_quantity($cart_item_key, $quantity, true);
    }

    WC_AJAX::get_refreshed_fragments();
    wp_die();
}

// Logica para filtrar por precio
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && (is_shop() || is_product_category() || is_tax() || is_search())) {
        $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
        $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 0;

        if ($query->get('ignore_price_filter')) {
            return;
        }

        if ($min_price || $max_price) {
            $meta_query = $query->get('meta_query') ?: [];

            if ($min_price) {
                $meta_query[] = [
                    'key' => '_price',
                    'value' => $min_price,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                ];
            }

            if ($max_price) {
                $meta_query[] = [
                    'key' => '_price',
                    'value' => $max_price,
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                ];
            }

            $query->set('meta_query', $meta_query);
        }
    }
});

// Requerir Terminos y Condiciones Checkbox
add_action('woocommerce_checkout_process', function () {
    if (! isset($_POST['terms'])) {
        wc_add_notice(__('Debes aceptar los términos y condiciones para continuar.', 'woocommerce'), 'error');
    }
});

// ===========================================================================================================================================================
// Requerir método de pago guardado para suscripciones >= 200
add_action('woocommerce_checkout_process', 'require_saved_payment_method_for_subscriptions');
add_action('woocommerce_checkout_create_order', 'require_saved_payment_method_for_subscriptions_validation');

function require_saved_payment_method_for_subscriptions()
{
    // Verificar si WooCommerce Subscriptions está activo
    if (!class_exists('WC_Subscriptions') || !function_exists('wcs_cart_contains_renewal')) {
        return;
    }

    // Revisar si el carrito tiene subscripciones usando diferentes métodos
    $has_subscription = false;

    // Método 1: Función alternativa (puede variar según la versión)
    if (function_exists('wcs_cart_contains_renewal')) {
        $has_subscription = wcs_cart_contains_renewal();
    }

    // Método 2: Verificar manualmente los items del carrito
    if (!$has_subscription) {
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];

            // Verificar si es una suscripción usando la clase WC_Subscriptions_Product
            if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
                $has_subscription = true;
                break;
            }
        }
    }

    if ($has_subscription) {
        foreach (WC()->cart->get_cart() as $cart_item) {
            $product = $cart_item['data'];

            // Verificar si es una suscripción
            if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
                $price = floatval($product->get_price());

                // Si el precio es 200 o más, exigir método de pago guardado
                if ($price >= 200) {
                    // Forzar el guardado de método de pago en la sesión
                    WC()->session->set('wc_stripe_force_save_payment_method', true);
                    return;
                }
            }
        }
    }

    // Si no hay suscripciones de alto valor, no forzar
    if (WC()->session->get('wc_stripe_force_save_payment_method')) {
        WC()->session->__unset('wc_stripe_force_save_payment_method');
    }
}

function require_saved_payment_method_for_subscriptions_validation($order)
{
    // Verificar si WooCommerce Subscriptions está activo
    if (!class_exists('WC_Subscriptions') || !function_exists('wcs_order_contains_subscription')) {
        return;
    }

    // Revisar si la orden tiene subscripciones
    $has_subscription = false;

    // Método preferido si la función existe
    if (function_exists('wcs_order_contains_subscription')) {
        $has_subscription = wcs_order_contains_subscription($order);
    } else {
        // Método alternativo: verificar items manualmente
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            if ($product && class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
                $has_subscription = true;
                break;
            }
        }
    }

    if ($has_subscription) {
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();

            // Verificar si es una suscripción
            if ($product && class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
                $price = floatval($product->get_price());

                // Si el precio es 200 o más, validar método de pago guardado
                if ($price >= 200) {
                    // Verificar si Stripe está forzando el guardado
                    $force_save = WC()->session->get('wc_stripe_force_save_payment_method');

                    // Verificar si el usuario ha seleccionado guardar el método de pago
                    $save_payment_method = false;

                    // Diferentes métodos para detectar si se guardará el pago
                    if (isset($_POST["wc-stripe-payment-token"]) && 'new' !== $_POST["wc-stripe-payment-token"]) {
                        $save_payment_method = true;
                    }

                    if (isset($_POST['wc-stripe-new-payment-method']) && 'true' === $_POST['wc-stripe-new-payment-method']) {
                        $save_payment_method = true;
                    }

                    if (isset($_POST['stripe_source']) && !empty($_POST['stripe_source'])) {
                        // Para Stripe Sources
                        $save_payment_method = true;
                    }

                    if (!$save_payment_method) {
                        throw new Exception(
                            __('Para suscripciones de €200 o más, debes guardar un método de pago. Por favor, selecciona "Guardar esta tarjeta para pagos futuros" durante el proceso de pago.', 'woocommerce')
                        );
                    }
                }
            }
        }
    }
}

// Opcional: Añadir mensaje informativo en el checkout
add_action('woocommerce_before_checkout_form', 'display_saved_payment_method_notice');

function display_saved_payment_method_notice()
{
    // Verificar si WooCommerce Subscriptions está activo
    if (!class_exists('WC_Subscriptions')) {
        return;
    }

    $has_high_value_subscription = false;

    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];

        if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
            $price = floatval($product->get_price());

            if ($price >= 200) {
                $has_high_value_subscription = true;
                break;
            }
        }
    }

    if ($has_high_value_subscription) {
        wc_add_notice(
            __('<strong>Nota importante:</strong> Para suscripciones de €200 o más, se requiere guardar un método de pago para futuras renovaciones. Asegúrate de seleccionar "Guardar esta tarjeta para pagos futuros".', 'woocommerce'),
            'notice'
        );
    }
}

// Función alternativa para verificar suscripciones en el carrito
function custom_cart_contains_subscription()
{
    if (!class_exists('WC_Subscriptions')) {
        return false;
    }

    foreach (WC()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if (WC_Subscriptions_Product::is_subscription($product)) {
            return true;
        }
    }

    return false;
}


// ===========================================================================================================================================================
//Puntos Criticos Envios 
// Cambiar productos por página
add_filter('loop_shop_per_page', function ($cols) {
    return 9; // 3 filas de 3 productos
}, 20);

add_filter('loop_shop_columns', function () {
    return 3; // 3 columnas
}, 20);
add_filter('woocommerce_payment_gateways', function ($gateways) {
    foreach ($gateways as $gateway) {
        if (isset($gateway->id)) {
            // Forzar soporte en Stripe
            if (strpos($gateway->id, 'stripe') !== false) {
                $gateway->supports = array_merge($gateway->supports, [
                    'tokenization',
                    'add_payment_method',
                ]);
            }

            // Forzar soporte en PayPal
            if (strpos($gateway->id, 'paypal') !== false) {
                $gateway->supports = array_merge($gateway->supports, [
                    'tokenization',
                    'add_payment_method',
                ]);
            }
        }
    }
    return $gateways;
});
add_action('wp_enqueue_scripts', function () {
    if (is_account_page()) {
        wp_enqueue_script('wc-stripe'); // Asegura cargar el JS de Stripe
    }
});

// Override Woo-Wallet Templates
add_filter('woo_wallet_locate_template', function ($template, $template_name, $template_path) {
    $theme_template = get_stylesheet_directory() . '/woo-wallet/' . $template_name;

    if (file_exists($theme_template)) {
        return $theme_template;
    }

    return $template;
}, 10, 3);

// Override Woocomerce Subscriptions Templates
add_filter('woocommerce_locate_template', function ($template, $template_name, $template_path) {
    $theme_template = get_stylesheet_directory() . '/woocommerce-subscriptions/' . $template_name;

    if (file_exists($theme_template)) {
        return $theme_template;
    }

    return $template;
}, 10, 3);

// Override Tournamatch Templates
add_filter('template_include', function ($template) {
    $theme_dir = get_stylesheet_directory() . '/tournamatch/';

    $basename = basename($template);

    $custom = $theme_dir . $basename;

    if (file_exists($custom)) {
        return $custom;
    }

    return $template;
});

add_action('woocommerce_before_shop_loop_item', function () {
    global $product;
    if ($product && $product->get_type() === 'auction') {
        echo '<div class="auction-card bg-gray-900 border border-yellow-500 rounded-xl p-6 shadow-lg">';
    }
}, 5);

add_action('woocommerce_after_shop_loop_item', function () {
    global $product;
    if ($product && $product->get_type() === 'auction') {
        echo '</div>';
    }
}, 50);




// ===================================================================================================================================================================

// ===================================================================================================================================================================
// Marcar en el HTML para rastrear QUÉ plantilla de Woo se usa

add_action('wp_enqueue_scripts', function () {
    wp_add_inline_style(
        'woocommerce-general', // manejador del CSS de WooCommerce
        '.products::before, .products::after { display: none !important; content: none !important; }'
    );
});


// ===========================================================================================================================================================
// Ajax para guardar método de pago de Stripe
add_action('wp_ajax_save_stripe_payment_method', 'save_stripe_payment_method');
add_action('wp_ajax_nopriv_save_stripe_payment_method', 'save_stripe_payment_method');

function save_stripe_payment_method()
{
    if (empty($_POST['payment_method_id'])) {
        wp_send_json_error(['message' => 'No Payment Method ID']);
    }

    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error(['message' => 'Usuario no autenticado']);
    }

    $payment_method_id = sanitize_text_field($_POST['payment_method_id']);
    $stripe_customer_id = get_user_meta($user_id, 'gc__stripe_customer_id', true);

    if (!$stripe_customer_id) {
        wp_send_json_error(['message' => 'Cliente Stripe no encontrado']);
    }

    // Obtener la API key desde WooCommerce Stripe settings
    $stripe_settings = get_option('woocommerce_stripe_settings', []);
    $secret_key = isset($stripe_settings['secret_key']) ? $stripe_settings['secret_key'] : '';

    if (empty($secret_key)) {
        wp_send_json_error(['message' => 'Stripe Secret Key no configurada']);
    }

    try {
        // Inicializar Stripe client
        $stripe = new \Stripe\StripeClient($secret_key);

        // Adjuntar el método al cliente
        $stripe->paymentMethods->attach(
            $payment_method_id,
            ['customer' => $stripe_customer_id]
        );

        // Configurar como predeterminado
        $stripe->customers->update($stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $payment_method_id,
            ],
        ]);

        wp_send_json_success(['message' => 'Método de pago agregado y configurado como predeterminado']);
    } catch (Exception $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}

// ===================================================================================================================================================================
// Forzar siempre el uso del avatar local de Simple Local Avatars
add_filter('get_avatar', 'usar_avatar_personalizado', 10, 5);

function usar_avatar_personalizado($avatar, $id_or_email, $size, $default, $alt) {
    // Obtener el ID del usuario
    if (is_numeric($id_or_email)) {
        $user_id = (int) $id_or_email;
    } elseif (is_object($id_or_email)) {
        if (!empty($id_or_email->user_id)) {
            $user_id = (int) $id_or_email->user_id;
        }
    } else {
        $user = get_user_by('email', $id_or_email);
        if ($user) {
            $user_id = $user->ID;
        }
    }

    if (!empty($user_id)) {
        // Revisar si tiene avatar personalizado
        $custom_avatar = get_user_meta($user_id, 'simple_local_avatar', true);
        if ($custom_avatar) {
            // Retornar HTML del avatar personalizado
            $avatar = "<img alt='" . esc_attr($alt) . "' src='" . esc_url($custom_avatar) . "' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }
    }

    return $avatar;
}



// Configuración
add_action('woocommerce_check_cart_items', function() {
    if (is_admin()) return;

    // Configuración
    $categoria_torneos = 'torneos'; // slug de la categoría de torneos
    $subs_permitidas   = ['Pixel Knight', 'Realm Sorcerer','Cosmic Overlord']; // slugs de las suscripciones

    $user_id = get_current_user_id();
    if (!$user_id) return;
  
    $has_valid_subscription = false;

    // Revisar si el usuario tiene alguna suscripción activa de las permitidas
    if (function_exists('wcs_user_has_subscription')) {
        foreach ($subs_permitidas as $plan) {
            if (wcs_user_has_subscription($user_id, $plan, 'active')) {
                $has_valid_subscription = true;
                break;
            }
        }
    }

    // Revisar carrito
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];

        if (has_term($categoria_torneos, 'product_cat', $product_id)) {
            // Leer fechas personalizadas del producto
            $fecha_preventa = get_post_meta($product_id, '_fecha_preventa', true);
            $fecha_general  = get_post_meta($product_id, '_fecha_general', true);

            $now = current_time('timestamp');

            // Convertir a timestamps
            $preventa_ts = $fecha_preventa ? strtotime($fecha_preventa) : 0;
            $general_ts  = $fecha_general ? strtotime($fecha_general) : 0;

            if ($has_valid_subscription) {
                if ($preventa_ts && $now < $preventa_ts) {
                    wc_add_notice("La preventa para este torneo comienza el " . date_i18n('d/m/Y H:i', $preventa_ts) . ".", 'error');
                    WC()->cart->remove_cart_item($cart_item['key']);
                }
            } else {
                if ($general_ts && $now < $general_ts) {
                    wc_add_notice("Este torneo estará disponible para todos el " . date_i18n('d/m/Y H:i', $general_ts) . ".", 'error');
                    WC()->cart->remove_cart_item($cart_item['key']);
                }
            }
        }
    }
});

// Asegura que el endpoint /my-account/orders/{page}/ use la misma plantilla
add_filter('woocommerce_my_account_my_orders_query', function ($args) {
    $args['posts_per_page'] = -1;
    return $args;
});

// Carga script de Preline
function theme_enqueue_scripts()
{
    // Enqueue noUiSlider (you can use CDN or local copy)
    wp_enqueue_script(
        'nouislider',
        'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.8.1/nouislider.min.js',
        [],
        '15.8.1',
        true
    );

    // Enqueue Preline (from node_modules)
    wp_enqueue_script(
        'preline',
        get_stylesheet_directory_uri() . '/node_modules/preline/dist/preline.js',
        ['nouislider'],
        '1.9.0', // or whatever version you have
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// ===================================================================================================================================================================
// DOKAN PLUGIN

//Remove dokan related products in product page
remove_action('woocommerce_product_tabs', 'dokan_set_more_from_seller_tab', 10);

//Remove redirect to dokan dashboard on login
remove_action('woocommerce_login_redirect', 'dokan_after_login_redirect', 1, 2);

//Remove extra information on shipping methods
remove_filter('woocommerce_cart_shipping_packages', 'split_shipping_packages');
remove_action('woocommerce_checkout_create_order_shipping_item', 'add_shipping_pack_meta', 10, 4);
remove_filter('woocommerce_shipping_package_name', 'change_shipping_pack_name', 10, 3);

// ===================================================================================================================================================================

