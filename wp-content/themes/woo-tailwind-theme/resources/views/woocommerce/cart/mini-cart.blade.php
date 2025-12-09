{{-- resources/views/woocommerce/cart/mini-cart.blade.php --}}
@if (WC()->cart->is_empty())
    <div class="p-6 text-center">
        <p class="text-gray-500">Tu carrito está vacío 🛒</p>
    </div>
@else
    <ul class="divide-y divide-gray-200 max-h-64 overflow-y-auto">
        @foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item)
            @php
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                $thumbnail  = $_product->get_image('thumbnail', ['class' => 'w-16 h-16 object-cover rounded']);
                $product_name = $_product->get_name();
                $product_price = WC()->cart->get_product_price($_product);
                $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
            @endphp

            <li class="flex items-center gap-4 p-4">
                {!! $thumbnail !!}
                <div class="flex-1">
                    <h4 class="text-sm font-semibold">
                        @if ($product_permalink)
                            <a href="{{ $product_permalink }}" class="hover:text-blue-500">{{ $product_name }}</a>
                        @else
                            {{ $product_name }}
                        @endif
                    </h4>
                    <p class="text-sm text-gray-500">Cantidad: {{ $cart_item['quantity'] }}</p>
                    <p class="text-sm font-bold">{!! $product_price !!}</p>
                </div>

                {{-- Botón eliminar con nonce y filtros correctos --}}
                {!! apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                        '<a href="%s" class="text-red-500 hover:text-red-700 text-sm" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">✕</a>',
                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                        esc_html__('Eliminar este artículo', 'woocommerce'),
                        esc_attr($product_id),
                        esc_attr($cart_item_key),
                        esc_attr($_product->get_sku())
                    ),
                    $cart_item_key
                ) !!}
            </li>
        @endforeach
    </ul>
@endif
