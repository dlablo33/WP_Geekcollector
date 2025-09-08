<header class="bg-black shadow-md relative">
  <div class="container mx-auto px-4 py-3 flex items-center justify-between">
    {{-- Logo --}}
    <a href="{{ home_url('/') }}" class="flex items-center transform hover:scale-105 transition-transform duration-200">
      <img src="{{ get_template_directory_uri() }}/images/logohead.png" alt="Geek Collector" class="logo-custom" />
    </a>

    {{-- Barra de búsqueda --}}
    <div class="flex-1 mx-6 max-w-xl">
      <form role="search" method="get" class="relative w-full" action="{{ home_url('/') }}">
        <input 
          type="search" 
          name="s" 
          placeholder="Buscar productos..." 
          value="{{ get_search_query() }}" 
          class="w-full rounded-lg px-5 py-2 text-black border-0 focus:ring-2 focus:ring-orange-500 pl-12 bg-white bg-opacity-90 transition-all duration-300 focus:bg-white focus:shadow-md"
          aria-label="Buscar productos"
        />
        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </button>
        <input type="hidden" name="post_type" value="product" />
      </form>
    </div>

    {{-- Iconos de usuario y carrito --}}
    <div class="flex items-center space-x-6">
      {{-- Carrito con dropdown --}}
      <div x-data="{ open: false, loading: false }" @keydown.window.escape="open = false" class="relative">
        <button 
          class="relative text-white cursor-pointer hover:text-gray-300 focus:outline-none transition-colors duration-200 group"
          aria-label="Carrito de compras"
          @click="open = !open"
        >
          <div class="relative">
            <svg class="w-7 h-7 transform group-hover:rotate-[-5deg] transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M9 21a1 1 0 100-2 1 1 0 000 2zM20 21a1 1 0 100-2 1 1 0 000 2zM1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.98-1.75L23 6H6"></path>
            </svg>
            <span class="absolute -top-2 -right-2 bg-orange-600 text-xs rounded-full px-1.5 py-0.5 leading-none font-bold transform group-hover:scale-110 transition-all duration-300 shadow-sm"
                  x-text="$store.cart.count">
              {{ WC()->cart->get_cart_contents_count() ?? 0 }}
            </span>
          </div>
        </button>
        
        {{-- Dropdown del carrito --}}
        <div 
          x-show="open" 
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-2"
          x-transition:enter-end="opacity-100 translate-y-0"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0"
          x-transition:leave-end="opacity-0 translate-y-2"
          class="absolute right-0 mt-3 w-80 bg-white rounded-lg shadow-xl z-50 text-black border border-gray-100"
          style="display: none;"
          @click.away="open = false"
        >
          <div class="p-4">
            <h3 class="text-lg font-bold border-b pb-2 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span x-text="`Tu Carrito (${$store.cart.count})`"></span>
              <span x-show="loading" class="ml-2">
                <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
              </span>
            </h3>
            
            {{-- Lista de productos --}}
            <div class="max-h-96 overflow-y-auto py-2" x-html="$store.cart.fragments['div.widget_shopping_cart_content']"></div>
            
            {{-- Total y botones --}}
            <template x-if="$store.cart.count > 0">
              <div class="border-t border-gray-200 pt-3 mt-3">
                <div class="flex justify-between items-center font-bold mb-4">
                  <span class="text-gray-700">Total:</span>
                  <span x-html="$store.cart.total" class="text-lg text-orange-600"></span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <a href="{{ wc_get_cart_url() }}" 
                     class="bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded text-center text-sm font-medium transition-all duration-200 flex items-center justify-center border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Ver Carrito
                  </a>
                  <a href="{{ wc_get_checkout_url() }}" 
                     class="bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded text-center text-sm font-medium transition-all duration-200 flex items-center justify-center shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Finalizar Compra
                  </a>
                </div>
              </div>
            </template>
            
            {{-- Carrito vacío --}}
            <template x-if="$store.cart.count === 0">
              <div class="py-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-3 text-gray-500">Tu carrito está vacío</p>
                <a href="{{ wc_get_page_permalink('shop') }}" class="mt-3 inline-block text-sm text-orange-500 hover:text-orange-600 font-medium border-b border-transparent hover:border-orange-400 transition-colors duration-300">
                  Explorar productos
                </a>
              </div>
            </template>
          </div>
        </div>
      </div>

      {{-- Botón Cuenta --}}
      <a href="{{ wc_get_page_permalink('myaccount') }}" 
         class="text-white hover:text-gray-300 focus:outline-none flex items-center space-x-1 transition-colors duration-200 group"
         aria-label="Mi cuenta">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 transform group-hover:rotate-[5deg] transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </a>
    </div>
  </div>
</header>

<!-- Alpine Store para manejar el estado del carrito -->
<script>
document.addEventListener('alpine:init', () => {
  Alpine.store('cart', {
    count: {{ WC()->cart->get_cart_contents_count() ?? 0 }},
    total: `{!! WC()->cart->get_total() !!}`,
    fragments: {
      'div.widget_shopping_cart_content': `{!! woocommerce_mini_cart() !!}`
    },
    
    init() {
      // Actualizar carrito cuando hay cambios
      document.addEventListener('wc_fragments_loaded', (e) => {
        this.count = e.detail.cart_hash.count;
        this.total = e.detail.cart_hash.total;
        this.fragments = e.detail.cart_hash.fragments;
      });
      
      // Manejar clicks en eliminar productos
      document.addEventListener('click', async (e) => {
        if (e.target.closest('.remove_from_cart_button')) {
          e.preventDefault();
          const link = e.target.closest('.remove_from_cart_button');
          this.loading = true;
          
          try {
            const response = await fetch(link.href, {
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            });
            
            if (response.ok) {
              const data = await response.json();
              this.count = data.fragments['div.widget_shopping_cart_content'] 
                ? (data.fragments['div.widget_shopping_cart_content'].match(/cart-count">(\d+)</) || [,'0'])[1] 
                : '0';
              this.total = data.fragments['div.widget_shopping_cart_content']
                ? (data.fragments['div.widget_shopping_cart_content'].match(/amount">([^<]+)</) || [,'$0.00'])[1]
                : '$0.00';
              this.fragments = data.fragments;
              
              // Disparar evento para otros componentes
              document.dispatchEvent(new CustomEvent('wc_fragments_loaded', {
                detail: { cart_hash: data }
              }));
            }
          } catch (error) {
            console.error('Error:', error);
          } finally {
            this.loading = false;
          }
        }
      });
    }
  });
});
</script>

<!-- Scripts necesarios -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>