<?php
defined('ABSPATH') || exit;

global $product;

if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
  return;
}

// Renderizamos la vista Blade
echo \Roots\view('woocommerce.content-product', [
  'product' => $product,
  'index' => isset($index) ? $index : 0,
])->render();