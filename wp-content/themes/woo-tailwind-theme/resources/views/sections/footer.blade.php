<footer class="bg-black px-4 pb-6 pt-10 text-white md:px-8">
    <div class="container mx-auto">
        <!-- Sección Superior del Footer -->
        <div class="mb-8 grid grid-cols-1 gap-8 md:grid-cols-8">

            <!-- Enlaces Rápidos -->
            <div class="col-start-1 md:col-span-2">
                <h3 class="mb-4 text-lg font-semibold text-orange-400">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="{{ home_url('/') }}" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Inicio</a></li>
                    <li><a href="{{ wc_get_page_permalink('shop') }}" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Tienda</a></li>
                    <li><a href="{{ wc_get_page_permalink('cart') }}" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Carrito</a></li>
                    <li><a href="{{ wc_get_page_permalink('myaccount') }}" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Mi Cuenta</a></li>
                </ul>
            </div>

            <!-- Membresias -->
            <div class="md:col-span-2 md:col-start-3">
                <a href="https://geekcollector.com/membresias/">
                    <h3 class="mb-4 text-lg font-semibold text-orange-400">Membresias</h3>
                </a>
                <ul class="space-y-2">
                    <li><a href="https://geekcollector.com/producto/byte-seeker/" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Nivel 1: Byte
                            Seeker</a></li>
                    <li><a href="https://geekcollector.com/producto/pixel-knight/" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Nivel 2:
                            Pixel Knight</a></li>
                    <li><a href="https://geekcollector.com/producto/realm-sorcerer/" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Nivel 3:
                            Realm Sorcerer</a></li>
                    <li><a href="https://geekcollector.com/producto/legendary-guardian/" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Nivel
                            4: Legendary Guardian</a></li>
                    <li><a href="https://geekcollector.com/producto/cosmic-overlord/" class="text-gray-400 transition-colors duration-200 hover:text-orange-400">Nivel 5:
                            Cosmic Overlord</a></li>
                </ul>
            </div>

            <!-- Información de Contacto -->
            <div class="md:col-span-2 md:col-start-5">
                <a href="{{ home_url('/contacto') }}">
                    <h3 class="mb-4 text-lg font-semibold text-orange-400">Contacto</h3>
                </a>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-start">
                        <a class="flex" href="{{ home_url('/contacto') }}">
                            <svg class="mr-2 h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>AVE. ALFONSO REYES 255</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span>+52 81 2080 2420</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="mr-2 h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>info@geekcollector.com</span>
                    </li>
                </ul>
            </div>

            <!-- Logo y Descripción -->
            <div class="md:col-span-2 md:col-start-7">
                <div class="mb-4 flex items-center">
                    <img src="{{ asset('resources/images/logohead.png') }}" alt="Logo GeekCollector" class="mr-3 h-10 w-auto">
                </div>
                <p class="mb-4 text-sm text-gray-400">Tu tienda especializada en juegos de cartas coleccionables y productos geek. Ofrecemos los mejores productos de
                    Magic, Pokémon, Yu-Gi-Oh! y más.</p>

                <hr class="border-1 mb-4 border-white">
                <div class="flex space-x-4">
                    <!-- SVG Facebook -->
                    <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/geek.collectormx/"
                        class="text-gray-400 transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- SVG Twitter -->
                    <a target="_blank" rel="noopener noreferrer" href="https://x.com/geekcollectormx"
                        class="text-gray-400 transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>

                    <!-- SVG Instagram -->
                    <a target="_blank" rel="noopener noreferrer" href="https://instagram.com/geek.collectormx"
                        class="text-gray-400 transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 1.802c-2.67 0-2.986.01-4.04.058-.976.045-1.505.207-1.858.344-.466.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.055-.058 1.37-.058 4.04 0 2.67.01 2.986.058 4.04.045.976.207 1.505.344 1.858.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.055.048 1.37.058 4.04.058 2.67 0 2.986-.01 4.04-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.04 0-2.67-.01-2.986-.058-4.04-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 0 0-.748-1.15 3.098 3.098 0 0 0-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.054-.047-1.37-.058-4.04-.058z"
                                clip-rule="evenodd" />
                            <circle cx="12" cy="12" r="3.5" fill="none" stroke="currentColor" stroke-width="1.5" />
                            <circle cx="16.5" cy="7.5" r="1" />
                        </svg>
                    </a>

                    <!-- SVG YouTube -->
                    <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/@Geek.collectormx"
                        class="text-gray-400 transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>

                    <!-- SVG Twitch -->
                    <a target="_blank" rel="noopener noreferrer" href="https://www.twitch.tv/geekcollectormty"
                        class="text-gray-400 transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sección Inferior del Footer -->
        <div class="mt-6 border-t border-gray-800 pt-6">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <p class="mb-4 text-sm text-gray-500 md:mb-0">© {{ date('Y') }} GeekCollector. Todos los derechos reservados.</p>
                <div class="flex space-x-6">
                    <a href="https://geekcollector.com/terminos-y-condiciones/"
                        class="text-sm text-gray-500 transition-colors duration-200 hover:text-orange-400">Términos y Condiciones</a>
                    <a href="#" class="text-sm text-gray-500 transition-colors duration-200 hover:text-orange-400">Política de Envíos</a>
                </div>
            </div>
        </div>
    </div>
</footer>
