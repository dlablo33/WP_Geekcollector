@php
    $columns = wc_get_loop_prop('columns'); // Propiedades de WooCommerce
    wc_set_loop_prop('columns', 1);
@endphp

@php
    $max_price = 0;
    $min_price = PHP_FLOAT_MAX;
    $current_category = get_queried_object();

    $all_category_posts = new WP_Query([
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $current_category->term_id,
            ],
        ],
        'ignore_price_filter' => true,
    ]);

    if ($all_category_posts->have_posts()) {
        foreach ($all_category_posts->posts as $product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                $price = $product->get_price();
                $max_price = max($max_price, (float) $price);
                $min_price = min($min_price, (float) $price);
            }
        }
        wp_reset_postdata();
    } else {
        $min_price = 0;
    }
@endphp
<script src="https://cdn.jsdelivr.net/npm/nouislider@latest/dist/nouislider.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@latest/dist/nouislider.min.css">

<div class="container mx-auto grid grid-cols-1 gap-8 px-4 py-12 lg:grid-cols-4">
    <!-- Sidebar de filtros - Diseño premium -->
    <aside class="lg:col-span-1">
        <div class="animate-slide-in-left sticky top-24 space-y-8">
            <!-- Filtro de precio - Estilo mejorado -->
            <div class="group rounded-2xl border-2 border-gray-800 bg-gray-900 p-6 shadow-2xl transition-all duration-500 hover:shadow-orange-500/10">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="flex items-center text-lg font-bold uppercase text-orange-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Rango de Precios
                    </h4>
                    <span class="animate-pulse rounded-full bg-orange-500/10 px-2 py-1 text-xs text-orange-400">Filtrar</span>
                </div>
                <div id="price-slider" class="my-6"></div>
                <div class="price-filter-wrapper max-w-full text-white">
                    <form method="GET" id="rangoPrecio" action="" class="space-y-4">
                        <div class="flex w-full items-center gap-2">
                            <input type="text" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Mín"
                                class="w-1/2 rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-orange-500 focus:ring-orange-500">

                            <input type="text" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Máx"
                                class="w-1/2 rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-orange-500 focus:ring-orange-500">
                        </div>

                        <button type="submit"
                            class="w-full cursor-pointer rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-5 py-2 text-sm font-bold uppercase text-white shadow transition-all hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/30">
                            Aplicar Filtro
                        </button>
                    </form>
                    @if (isset($_GET['min_price']) || isset($_GET['max_price']))
                        <form action="">
                            <button
                                class="mt-4 w-full cursor-pointer rounded-full bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-2 text-sm font-bold uppercase text-white shadow transition-all hover:scale-105 hover:from-orange-500 hover:to-orange-600 hover:shadow-lg hover:shadow-orange-500/30">
                                Reset
                            </button>
                        </form>
                    @endif

                </div>

            </div>

            <!-- Filtro de categorías - Diseño acordeón premium -->
            <div class="rounded-2xl border-2 border-gray-800 bg-gray-900 p-6 shadow-2xl transition-all duration-500 hover:shadow-orange-500/10">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="flex items-center text-lg font-bold uppercase text-orange-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Categorías
                    </h4>
                    <?php
                    $product_categories = get_terms([
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => 0,
                        'orderby' => 'name',
                    ]);
                    $category_count = is_array($product_categories) ? count($product_categories) : 0;
                    ?>
                    <span class="animate-pulse rounded-full bg-orange-500/10 px-2 py-1 text-xs text-orange-400">
                        <?php echo $category_count; ?> categorías
                    </span>
                </div>

                <?php
                if (!empty($product_categories) && is_array($product_categories)) {
                    echo '<ul class="space-y-3 accordion-categories">';
                    foreach ($product_categories as $category) {
                        $children = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => $category->term_id]);
                        $has_children = !empty($children);
                
                        echo '<li class="' . ($has_children ? 'has-children' : '') . ' rounded-lg overflow-hidden transition-all duration-300">';
                
                        if ($has_children) {
                            echo '<div class="category-toggle flex justify-between items-center p-3 bg-gray-800/50 hover:bg-gray-800 cursor-pointer transition-all duration-300 group">';
                            echo '<span class="font-medium text-white group-hover:text-orange-400 transition-colors">' . esc_html($category->name) . '</span>';
                            echo '<svg class="w-5 h-5 transform transition-transform duration-300 text-orange-500 group-hover:text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                            echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>';
                            echo '</svg>';
                            echo '</div>';
                
                            
                            echo '<ul class="subcategories-menu pl-6 pr-3 bg-gray-900/80 transition-all duration-500 overflow-hidden max-h-0">';
                            foreach ($children as $child) {
                                echo '<li class="py-2 border-b border-gray-800 last:border-0">';
                                echo '<a href="' . esc_url(get_term_link($child)) . '" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors group">';
                                echo '<span class="w-1.5 h-1.5 bg-orange-500 rounded-full mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></span>';
                                echo esc_html($child->name);
                                echo '</a>';
                                echo '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<a href="' . esc_url(get_term_link($category)) . '" class="flex items-center p-3 bg-gray-800/50 hover:bg-gray-800 transition-all duration-300 group">';
                            echo '<span class="font-medium text-white group-hover:text-orange-400 transition-colors">' . esc_html($category->name) . '</span>';
                            echo '</a>';
                        }
                
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="text-gray-400 text-sm py-3">No se encontraron categorías</p>';
                }
                ?>
            </div>
        </div>
    </aside>

    <!-- Grid de productos -->
    <section class="lg:col-span-3">
        <ul class="products grid grid-cols-1 justify-start gap-8 sm:grid-cols-2 lg:grid-cols-3">

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const slider = document.getElementById('price-slider');
                    if (!slider) return;

                    noUiSlider.create(slider, {
                        start: [{{ $_GET['min_price'] ?? $min_price }}, {{ $_GET['max_price'] ?? $max_price }}],
                        connect: true,
                        step: 100,
                        margin: 100,
                        range: {
                            'min': {{ $min_price }},
                            'max': {{ $max_price }}
                        }
                    });

                    const minInput = document.getElementById('min_price');
                    const maxInput = document.getElementById('max_price');

                    slider.noUiSlider.on('update', (values, handle) => {
                        if (handle === 0) minInput.value = Math.round(values[0]) ? Math.round(values[0]) : '';
                        if (handle === 1) maxInput.value = Math.round(values[1]) ? Math.round(values[1]) : '';
                    });

                    // Add custom classes to slider elements for better styling
                    slider.noUiSlider.on('create', function() {
                        // Add custom class to the connect element
                        const connect = slider.querySelector('.noUi-connect');
                        if (connect) {
                            connect.classList.add('bg-gradient-to-r', 'from-orange-600', 'to-orange-500');
                        }

                        // Add custom classes to handles
                        const handles = slider.querySelectorAll('.noUi-handle');
                        handles.forEach(handle => {
                            handle.classList.add('bg-gradient-to-b', 'from-orange-600', 'to-orange-500', 'border-2', 'border-white', 'shadow-md',
                                'shadow-orange-500/40');
                        });
                    });
                });
            </script>

            <script>
                document.querySelectorAll(".category-toggle").forEach(toggle => {
                    toggle.addEventListener("click", () => {
                        const submenu = toggle.nextElementSibling;

                        if (!submenu) return;

                        // Cierra otras categorias
                        document.querySelectorAll(".subcategories-menu").forEach(menu => {
                            if (menu !== submenu) {
                                menu.style.maxHeight = "0px";
                            }
                        });

                        // Toggle the clicked submenu
                        if (submenu.style.maxHeight && submenu.style.maxHeight !== "0px") {
                            submenu.style.maxHeight = "0px"; // collapse
                        } else {
                            submenu.style.maxHeight = submenu.scrollHeight + "px"; // expand
                        }
                    });
                });
            </script>
