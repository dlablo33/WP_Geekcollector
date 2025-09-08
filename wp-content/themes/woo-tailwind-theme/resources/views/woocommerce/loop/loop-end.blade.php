<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</ul>
        <nav class="woocommerce-pagination mt-8">
            @php
                global $wp_query;
                echo paginate_links([
                    'total'   => isset($wp_query) ? $wp_query->max_num_pages : 1,
                    'current' => max( 1, get_query_var('paged', 1) ),
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'type'    => 'list',
                ]);
            @endphp
        </nav>
    </section>
</div>
