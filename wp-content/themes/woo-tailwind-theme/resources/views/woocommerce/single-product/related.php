<?php
/**
 * Related Products Template
 *
 * Sobrescribe el default de WooCommerce para mostrar SOLO productos,
 * con un diseño limpio usando Tailwind.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 */

defined('ABSPATH') || exit;

if ($related_products) : ?>

    <section class="related-products mt-16">
        <h2 class="mb-8 text-2xl font-bold uppercase tracking-wider text-gray-900">
            TAMBIÉN TE PUEDE INTERESAR
        </h2>

        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($related_products as $related_product) :
                $product = wc_get_product($related_product->get_id()); ?>
                
                <li class="bg-white rounded-xl shadow-md hover:shadow-xl transition p-4 text-center">
                    
                    <a href="<?php echo get_permalink($product->get_id()); ?>">
                        <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'mx-auto mb-4 rounded-lg h-48 object-contain']); ?>
                        <h3 class="text-lg font-semibold text-gray-800">
                            <?php echo $product->get_name(); ?>
                        </h3>
                    </a>

                    <div class="text-orange-600 font-bold mt-2 text-xl">
                        <?php echo $product->get_price_html(); ?>
                    </div>

                    <?php if ($product->is_in_stock()) : ?>
                        <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                           data-quantity="1"
                           class="mt-4 inline-block bg-orange-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-orange-700 transition">
                            Añadir al carrito
                        </a>
                    <?php else : ?>
                        <span class="mt-4 inline-block text-red-600 font-semibold">
                            Agotado
                        </span>
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>
        </ul>
    </section>

<?php endif; ?>
