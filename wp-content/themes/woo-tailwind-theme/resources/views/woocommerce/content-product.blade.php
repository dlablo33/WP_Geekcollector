{{-- <li {{ wc_product_class('rounded-2xl shadow-lg p-4', $product) }}>
  <a href="{{ get_permalink($product->get_id()) }}" class="block">
    <div class="overflow-hidden rounded-xl">
      {!! $product->get_image('medium') !!}
    </div>
    <h3 class="mt-2 text-lg font-bold">{{ $product->get_name() }}</h3>
    <p class="text-gray-600">{!! $product->get_price_html() !!}</p>
  </a>
  <div class="mt-3">
    {!! do_shortcode('[add_to_cart id="' . $product->get_id() . '"]') !!}
  </div>
</li> --}}
{{-- Codigo Añadido --}}
<li class="product-card animate-fade-in-up transform overflow-hidden rounded-2xl border-2 border-gray-800 bg-gray-900 shadow-xl transition-all duration-500 hover:-translate-y-2 hover:border-orange-500/30 hover:shadow-2xl"
    style="animation-delay: {{ $index * 0.05 }}s">
    <div class="relative">
        <a href="{{ get_permalink() }}" class="group block overflow-hidden">
            @if (has_post_thumbnail())
                <div class="aspect-w-1 aspect-h-1">
                    {!! get_the_post_thumbnail(null, 'large', [
                        'class' => 'w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110',
                    ]) !!}
                </div>
            @else
                <div class="flex h-64 w-full items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900">
                    <svg class="h-16 w-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            @endif
            <div
                class="absolute inset-0 flex items-end bg-gradient-to-t from-black/70 to-transparent p-6 opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                <span
                    class="inline-block translate-y-3 transform rounded-full bg-orange-600 px-4 py-2 text-sm font-bold text-white transition-transform duration-500 group-hover:translate-y-0">
                    Ver Detalles
                </span>
            </div>
        </a>

        <!-- Badge de oferta/destacado -->
        <div class="absolute right-4 top-4">
            @if (wc_get_product(get_the_ID())->is_on_sale())
                <span
                    class="animate-pulse-fast rounded-full bg-orange-600 px-3 py-1 text-xs font-bold text-white shadow-md">
                    ¡Oferta!
                </span>
            @elseif(wc_get_product(get_the_ID())->is_featured())
                <span class="rounded-full bg-amber-500 px-3 py-1 text-xs font-bold text-gray-900 shadow-md">
                    Destacado
                </span>
            @endif
        </div>
    </div>

    <div class="p-5">
        <div class="mb-3 flex items-start justify-between">
            <h3 class="text-lg font-bold text-white transition-colors hover:text-orange-400">
                <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
            </h3>
            <!-- Rating -->
            <div class="flex items-center rounded-full bg-gray-800 px-2 py-1">
                <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                    </path>
                </svg>
                <span class="ml-1 text-xs font-bold text-white">4.8</span>
            </div>
        </div>

        <p class="mb-4 line-clamp-2 text-sm text-gray-400">{{ get_the_excerpt() }}</p>

        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-xl font-bold text-orange-500">
                    {!! wc_get_product(get_the_ID())->get_price_html() !!}
                </span>
                @if (wc_get_product(get_the_ID())->is_on_sale())
                    <span class="text-xs text-gray-400 line-through">
                        {!! wc_get_product(get_the_ID())->get_regular_price() !!}
                    </span>
                @endif
            </div>

            <button
                class="add-to-cart flex transform items-center rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-4 py-2 text-sm font-bold text-white shadow transition-all duration-300 hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/20"
                data-product_id="<?php echo get_the_ID(); ?>" data-product_sku="<?php echo esc_attr(wc_get_product(get_the_ID())->get_sku()); ?>">
                <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Añadir
            </button>
        </div>
    </div>
</li>
