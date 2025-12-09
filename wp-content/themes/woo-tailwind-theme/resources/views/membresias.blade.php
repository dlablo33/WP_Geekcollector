{{--
  Template Name: Membresias Template
--}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-2 py-4 uppercase sm:px-4">
        <!-- Swiper styles -->
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <style>
            .swiper-slide {
                background: #000000;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                color: #ff6600;
            }
        </style>

        <!-- Titulo -->
        <div class="flex flex-col flex-wrap content-center justify-center rounded-b-full bg-[#191919d0] py-4 text-center text-3xl font-bold text-white md:py-7 md:text-5xl">
            Membresias
            <span class="bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 bg-clip-text text-transparent">
                Premium
            </span>
        </div>

        <!-- Swiper container -->
        <div class="swiper swiper-container mt-10 h-[200px] w-full md:h-[450px]">
            <div class="swiper-wrapper text-white">

                @php
                    $membresias = [
                        ['img' => 'M4.png', 'name' => 'Legendary Guardian', 'url' => 'https://geekcollector.com/producto/legendary-guardian/'],
                        ['img' => 'M5.png', 'name' => 'Cosmic Overlord', 'url' => 'https://geekcollector.com/producto/cosmic-overlord/'],
                        ['img' => 'M1.png', 'name' => 'Byte Seeker', 'url' => 'https://geekcollector.com/producto/byte-seeker/'],
                        ['img' => 'M2.png', 'name' => 'Pixel Knight', 'url' => 'https://geekcollector.com/producto/pixel-knight/'],
                        ['img' => 'M3.png', 'name' => 'Realm Sorcerer', 'url' => 'https://geekcollector.com/producto/realm-sorcerer/'],
                        ['img' => 'M4.png', 'name' => 'Legendary Guardian', 'url' => 'https://geekcollector.com/producto/legendary-guardian/'],
                        ['img' => 'M5.png', 'name' => 'Cosmic Overlord', 'url' => 'https://geekcollector.com/producto/cosmic-overlord/'],
                        ['img' => 'M1.png', 'name' => 'Byte Seeker', 'url' => 'https://geekcollector.com/producto/byte-seeker/'],
                        ['img' => 'M2.png', 'name' => 'Pixel Knight', 'url' => 'https://geekcollector.com/producto/pixel-knight/'],
                        ['img' => 'M3.png', 'name' => 'Realm Sorcerer', 'url' => 'https://geekcollector.com/producto/realm-sorcerer/'],
                    ];
                @endphp

                @foreach ($membresias as $membresia)
                    <div class="swiper-slide text-white">
                        <a href="{{ $membresia['url'] }}">
                            <img class="h-full w-full object-cover" src="{{ asset('resources/images/membresias/' . $membresia['img']) }}" alt="{{ $membresia['name'] }}" />
                        </a>
                    </div>
                @endforeach

            </div>
            <div class="swiper-button-next invisible rounded-2xl bg-gray-300/50 p-8 md:visible"></div>
            <div class="swiper-button-prev invisible rounded-2xl bg-gray-300/50 p-8 md:visible"></div>
        </div>

        <!-- Tabla Beneficios -->
        <div class="container mx-auto px-2 py-4 sm:px-4">
            <div class="mt-15 flex flex-col items-center justify-center">
                <div class="flex flex-row items-center gap-1 md:gap-3">
                    <div><span class="text-xl font-bold text-white md:text-3xl">ACCEDE A</span></div>
                    <div
                        class="inline-block rounded-xl bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] transition-all duration-300 hover:from-yellow-300 hover:via-orange-500 hover:to-red-500">
                        <div class="rounded-xl bg-black px-2 py-2 text-xl font-bold text-white md:text-3xl">
                            Beneficios Exclusivos
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center text-xl text-white">
                    Personaliza tu experiencia y colecciona como un verdadero pro.
                </div>
            </div>

            @php
                $membresias = [
                    ['color' => '#f54a00', 'name' => 'Byte Seeker', 'url' => 'https://geekcollector.com/producto/byte-seeker/'],
                    ['color' => '#fb2c36', 'name' => 'Pixel Knight', 'url' => 'https://geekcollector.com/producto/pixel-knight/'],
                    ['color' => '#00668e', 'name' => 'Realm Sorcerer', 'url' => 'https://geekcollector.com/producto/realm-sorcerer/'],
                    ['color' => '#949494', 'name' => 'Legendary Guardian', 'url' => 'https://geekcollector.com/producto/legendary-guardian/'],
                    ['color' => '#e9c979', 'name' => 'Cosmic Overlord', 'url' => 'https://geekcollector.com/producto/cosmic-overlord/'],
                ];

                $data = [
                    [
                        'Capacidad Maxima' => 'ILIMITADA',
                        'Torneos Semanales' => 'NO',
                        'Subasta Comision' => 'NO',
                        'Apartado' => 'NO',
                        'Stream Area' => 'NO',
                        'Grading Mensual' => 'NO',
                        'Credito' => 'NO',
                        'Descuento' => 'NO',
                        'Mostrar Coleccion' => 'NO',
                    ],
                    [
                        'Capacidad Maxima' => 'ILIMITADA',
                        'Torneos Semanales' => '2 ENTRADAS (MES)',
                        'Subasta Comision' => 'NO',
                        'Apartado' => 'NO',
                        'Stream Area' => 'NO',
                        'Grading Mensual' => 'NO',
                        'Credito' => 'NO',
                        'Descuento' => 'NO',
                        'Mostrar Coleccion' => 'NO',
                    ],
                    [
                        'Capacidad Maxima' => '100 MIEMBROS',
                        'Torneos Semanales' => '5 ENTRADAS (MES)',
                        'Subasta Comision' => '1 ARTÍCULO',
                        'Apartado' => 'NO',
                        'Stream Area' => 'NO',
                        'Grading Mensual' => 'NO',
                        'Credito' => 'NO',
                        'Descuento' => 'NO',
                        'Mostrar Coleccion' => 'NO',
                    ],
                    [
                        'Capacidad Maxima' => '20 MIEMBROS',
                        'Torneos Semanales' => 'INCLUIDO',
                        'Subasta Comision' => '4 ARTÍCULOS',
                        'Apartado' => 'Máx. 2 Cajas',
                        'Stream Area' => 'SI',
                        'Grading Mensual' => '$500 MXN',
                        'Credito' => '$1,500 MXN',
                        'Descuento' => '5%',
                        'Mostrar Coleccion' => 'NO',
                    ],
                    [
                        'Capacidad Maxima' => '10 MIEMBROS',
                        'Torneos Semanales' => 'INCLUIDO',
                        'Subasta Comision' => '8 ARTÍCULOS',
                        'Apartado' => 'Máx. 4 Cajas',
                        'Stream Area' => 'SI',
                        'Grading Mensual' => '$1,000 MXN',
                        'Credito' => '$3,000 MXN',
                        'Descuento' => '10%',
                        'Mostrar Coleccion' => 'SI',
                    ],
                ];

                $beneficios = [
                    ['name' => 'CAPACIDAD MÁXIMA', 'key' => 'Capacidad Maxima'],
                    ['name' => 'ENTRADAS A TORNEOS SEMANALES', 'key' => 'Torneos Semanales'],
                    ['name' => 'ARTÍCULOS A SUBASTA SIN COMISIÓN', 'key' => 'Subasta Comision'],
                    ['name' => 'APARTADO PREFERENCIAL', 'key' => 'Apartado'],
                    ['name' => 'STREAM AREA', 'key' => 'Stream Area'],
                    ['name' => 'PSA GRADING MENSUAL', 'key' => 'Grading Mensual'],
                    ['name' => 'BONO EN CRÉDITO DE TIENDA', 'key' => 'Credito'],
                    ['name' => 'DESCUENTO EN MERCANCÍA**', 'key' => 'Descuento'],
                    ['name' => 'MOSTRAR COLECCIÓN EN TIENDA', 'key' => 'Mostrar Coleccion'],
                ];
            @endphp
            <div class="overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none]">
                <table class="mt-10 min-w-full table-fixed border-collapse divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="w-48 px-4 py-4 text-center text-xl font-bold uppercase tracking-wider text-white">
                                Beneficios
                            </th>

                            @foreach ($membresias as $membresia)
                                <th style="color: {{ $membresia['color'] }}" class="w-48 px-4 py-4 text-center text-2xl font-bold uppercase tracking-wider">
                                    {{ $membresia['name'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-500/50 text-white">
                        @foreach ($beneficios as $beneficio)
                            <tr>
                                <td class="w-52 px-4 py-3 text-lg font-medium md:w-64">
                                    {{ $beneficio['name'] }}
                                </td>
                                @foreach ($data as $columna)
                                    <td class="w-48 px-4 py-3 text-center align-middle text-lg">
                                        @if ($columna[$beneficio['key']] == 'NO')
                                            <span class="inline-flex items-center justify-center">
                                                <svg width="20" height="20" viewBox="0 0 100 100">
                                                    <line x1="20" y1="20" x2="80" y2="80" stroke="red" stroke-width="10"
                                                        stroke-linecap="round" />
                                                    <line x1="80" y1="20" x2="20" y2="80" stroke="red" stroke-width="10"
                                                        stroke-linecap="round" />
                                                </svg>
                                            </span>
                                        @elseif ($columna[$beneficio['key']] == 'SI')
                                            <span class="inline-flex items-center justify-center">
                                                <svg width="20" height="20" viewBox="0 0 100 100">
                                                    <path d="M20,50 L40,70 L80,30" fill="none" stroke="green" stroke-width="10" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        @else
                                            {{ $columna[$beneficio['key']] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr>
                            <td></td>
                            <!-- Botones de carrito -->
                            @foreach ($membresias as $membresia)
                                <td class="px-1 py-4 text-center">
                                    @php
                                        $product_id = url_to_postid($membresia['url']);
                                    @endphp
                                    <form action="{{ $membresia['url'] }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="add-to-cart" value="{{ $product_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit">
                                            <div
                                                class="w-42 inline-block cursor-pointer rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] transition-all duration-300 hover:from-yellow-300 hover:via-orange-500 hover:to-red-500 md:w-60">
                                                <div class="rounded-full bg-black py-2 text-sm font-semibold text-white md:px-4 md:text-lg">
                                                    Agregar al Carrito
                                                </div>
                                            </div>
                                        </button>
                                    </form>

                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-6 text-xs text-gray-400">
            **Aplican Restricciones
        </div>
        <div class="mt-10 flex justify-center text-3xl font-bold text-white">
            Preguntas Frecuentes
        </div>

        <!-- Preguntas Frecuentes -->
        <div class="mt-5 grid grid-cols-12">
            <!-- Columna Izquierda -->
            <div class="col-span-12 flex flex-col md:col-span-6">
                <!-- Pregunta 1 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l1" aria-expanded="false" aria-controls="pregunta-l1-heading" data-hs-collapse="#pregunta-l1-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué son las membresías?
                    </button>
                    <div id="pregunta-l1-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300" aria-labelledby="pregunta-l1">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Nuestras membresías son programas especiales diseñados para ofrecer beneficios exclusivos a nuestros Collectors más apasionados. 
                                 Al unirte, obtienes acceso anticipado a productos, descuentos especiales, dinámicas únicas, y experiencias personalizadas que fortalecen tu conexión con 
                                 la comunidad coleccionista.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 2 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l2" aria-expanded="false" aria-controls="pregunta-l2-heading" data-hs-collapse="#pregunta-l2-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Cuánto dura la membresía?
                    </button>
                    <div id="pregunta-l2-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l2">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Cada membresía tiene duración mensual. Se renueva automáticamente, a menos que decidas cancelarla antes del siguiente ciclo.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 3 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l3" aria-expanded="false" aria-controls="pregunta-l3-heading" data-hs-collapse="#pregunta-l3-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Puedo cambiar de nivel?
                    </button>
                    <div id="pregunta-l3-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l3">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Sí. Puedes cambiar tu nivel de membresía en cualquier momento. El nuevo nivel se activará al inicio del siguiente periodo de facturación. De haber disponibilidad
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 4 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l4" aria-expanded="false" aria-controls="pregunta-l4-heading" data-hs-collapse="#pregunta-l4-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué pasa si cancelo mi membresía?
                    </button>
                    <div id="pregunta-l4-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l4">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Puedes cancelarla en cualquier momento desde tu cuenta. Sin embargo, ciertos beneficios únicos como bonos en crédito de tienda no se reactivan si vuelves a contratar.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 5 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l5" aria-expanded="false" aria-controls="pregunta-l5-heading" data-hs-collapse="#pregunta-l5-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Cómo modifico mis intereses dentro de la membresía?
                    </button>
                    <div id="pregunta-l5-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l5">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Debes contactar directamente al gerente de tienda y solicitar los cambios que deseas realizar. El proceso puede tardar entre 48 a 72 horas.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 6 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l6" aria-expanded="false" aria-controls="pregunta-l6-heading" data-hs-collapse="#pregunta-l6-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Cómo activo mi membresía?
                    </button>
                    <div id="pregunta-l6-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l6">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Una vez que completes el pago, recibirás tu membresía digital directamente en tu wallet (Apple Wallet o Google Wallet). No necesitas tarjeta física.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 7 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l7" aria-expanded="false" aria-controls="pregunta-l7-heading" data-hs-collapse="#pregunta-l7-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué necesito para usarla?
                    </button>
                    <div id="pregunta-l7-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l7">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Un smartphone compatible con wallets digitales (Apple Wallet, Google Wallet). Todo es digital y práctico.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 8 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-l8" aria-expanded="false" aria-controls="pregunta-l8-heading" data-hs-collapse="#pregunta-l8-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Puedo usar mi membresía en tienda física?
                    </button>
                    <div id="pregunta-l8-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-l8">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 ¡Sí! Tu membresía digital es válida tanto online como en tienda física.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Columna Derecha -->
            <div class="col-span-12 flex flex-col md:col-span-6">
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r1" aria-expanded="false" aria-controls="pregunta-r1-heading" data-hs-collapse="#pregunta-r1-heading">

                        <!-- Improved SVG with perfect vertical alignment -->
                        <svg class="hs-collapse-open:rotate-90 mt-0.5 size-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>

                        ¿Qué son los créditos en tienda?
                    </button>
                    <div id="pregunta-r1-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r1">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Son puntos acumulables que obtienes al participar en torneos. Puedes usarlos para comprar cualquier producto en tienda sin restricciones. También puedes pagar entradas a torneos con estos créditos.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 2 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r2" aria-expanded="false" aria-controls="pregunta-r2-heading" data-hs-collapse="#pregunta-r2-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Los créditos tienen vigencia?
                    </button>
                    <div id="pregunta-r2-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r2">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 No. Los créditos acumulados no caducan y puedes usarlos cuando quieras, mientras tu cuenta siga activa.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 3 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r3" aria-expanded="false" aria-controls="pregunta-r3-heading" data-hs-collapse="#pregunta-r3-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Puedo transferir mis créditos a otro miembro?
                    </button>
                    <div id="pregunta-r3-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r3">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                No. Los créditos son personales e intransferibles.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 4 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r4" aria-expanded="false" aria-controls="pregunta-r4-heading" data-hs-collapse="#pregunta-r4-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Los torneos incluidos en las membresías caducan?
                    </button>
                    <div id="pregunta-r4-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r4">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Si los torneos mensuales que incluyen las membresías son para uso del mes en curso, en caso de no usarlos no se acumulan para el siguiente mes.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 5 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r5" aria-expanded="false" aria-controls="pregunta-r5-heading" data-hs-collapse="#pregunta-r5-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Cuántos torneos gratuitos tengo por membresía?
                    </button>
                    <div id="pregunta-r5-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r4">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 Depende del nivel de tu membresía. Cada mes se resetea el contador. Si no usas tus torneos ese mes, no se acumulan para el siguiente.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 6 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r6" aria-expanded="false" aria-controls="pregunta-r6-heading" data-hs-collapse="#pregunta-r6-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué pasa si me inscribo a un torneo y no asisto?
                    </button>
                    <div id="pregunta-r6-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r6">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Debes confirmar tu asistencia al menos 2 horas antes del evento. Si no te presentas sin aviso, perderás esa entrada.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 7 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r7" aria-expanded="false" aria-controls="pregunta-r7-heading" data-hs-collapse="#pregunta-r7-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué es el apartado de producto preferencial?
                    </button>
                    <div id="pregunta-r7-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r7">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Los niveles superiores pueden apartar productos antes de que estén disponibles para venta libre. El número de categorías permitidas depende de tu nivel.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 8 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r8" aria-expanded="false" aria-controls="pregunta-r8-heading" data-hs-collapse="#pregunta-r8-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Qué es el psa grading incluido?
                    </button>
                    <div id="pregunta-r8-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r8">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                 En niveles altos puedes enviar una o más cartas mensualmente para certificación PSA (hasta cierto monto sin costo). Nosotros nos encargamos del trámite.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Pregunta 9 -->
                <div>
                    <button type="button"
                        class="hs-collapse-toggle inline-flex items-center gap-x-2 bg-black px-4 py-3 text-left text-lg font-medium uppercase text-white md:text-xl"
                        id="pregunta-r9" aria-expanded="false" aria-controls="pregunta-r9-heading" data-hs-collapse="#pregunta-r9-heading">
                        <svg class="hs-collapse-open:rotate-90 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 6 6 6-6 6"></path>
                        </svg>
                        ¿Puedo puedo mostrar mi colección en tienda?
                    </button>
                    <div id="pregunta-r9-heading" class="hs-collapse hidden w-full overflow-hidden uppercase transition-[height] duration-300"
                        aria-labelledby="pregunta-r9">
                        <div class="rounded-lg bg-black px-4 py-3">
                            <p class="text-white dark:text-neutral-400">
                                Sí, este beneficio está disponible para el nivel más alto de membresía. Puedes coordinarlo con el equipo de tienda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-2 py-4 sm:px-4">
            <div class="mt-15 flex flex-col items-center justify-center">
                <div class="flex flex-row items-center gap-1 md:gap-3">
                    <div><span class="text-xl font-bold text-white md:text-3xl">Comunidad</span></div>
                    <div
                        class="inline-block rounded-xl bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] transition-all duration-300 hover:from-yellow-300 hover:via-orange-500 hover:to-red-500">
                        <div class="rounded-xl bg-black px-2 py-2 text-xl font-bold text-white md:text-3xl">
                            Geek Collection
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center text-xl text-white">
                    Personaliza tu experiencia y colecciona como un verdadero pro.
                </div>
            </div>
        </div>

        <div class="mt-5 py-2 md:mx-4 md:px-2">
            @php
                $posts = [
                    [
                        'img' => 'blog1.jpg',
                        'cliente' => 'Carlos Garcia',
                        'description' => 'La mejor tienda para comprar y vender cartas. Precios justos y trato 10/10.',
                    ],
                    [
                        'img' => 'blog2.webp',
                        'cliente' => 'Cesar Sucedo',
                        'description' => 'Siempre encuentro lo que busco. Gran stock y rapidez en los envíos. ¡Recomendadísima!',
                    ],
                    [
                        'img' => 'blog3.png',
                        'cliente' => 'Cesar Acosta',
                        'description' => 'Trueques seguros y productos en perfecto estado. Mi go-to para coleccionables.',
                    ],
                    [
                        'img' => 'blog1.jpg',
                        'cliente' => 'Paola Sofia',
                        'description' => 'Profesionales de verdad. Me ayudaron a armar mi colección sin compromiso.',
                    ],
                    [
                        'img' => 'blog2.webp',
                        'cliente' => 'Geek Collector',
                        'description' => 'Si eres serio en esto, es tu tienda. Sin estafas, todo transparente.',
                    ],
                ];
            @endphp

            <!-- Slider container -->
            <div class="swiper-post-container overflow-hidden px-2">
                <!-- Slider wrapper -->
                <div class="swiper-wrapper">
                    @foreach ($posts as $post)
                        <!-- Slide -->
                        <div class="swiper-slide">
                            <div class="relative flex h-auto w-auto flex-col rounded-2xl bg-gradient-to-t from-neutral-900 via-neutral-950 to-neutral-950 px-8 py-8">

                                <div class="flex items-center justify-center gap-x-2">

                                    <div class="flex-shrink-0">
                                        <div class="h-27 w-27 relative overflow-hidden rounded-full">
                                            <img src="{{ asset('resources/images/blog/' . $post['img']) }}" class="h-full w-full object-cover"
                                                alt="{{ $post['cliente'] }}">
                                        </div>
                                    </div>

                                    <div class="min-w-0">
                                        <div
                                            class="line-clamp-2 overflow-hidden px-2 text-center text-xl font-semibold uppercase tracking-wider text-white sm:text-base lg:text-2xl lg:leading-snug">
                                            {{ $post['cliente'] }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 justify-center text-white">
                                    <div class="text-center text-lg font-light normal-case sm:text-xl">
                                        "{{ $post['description'] }}"
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <!-- Swiper script -->
    <script type="module">
        import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs';

        new Swiper('.swiper-container', {
            effect: 'coverflow',
            initialSlide: 2,
            grabCursor: false,
            centeredSlides: true,
            slidesPerView: 2,
            loop: true,
            autoplay: {
                delay: 2500,
                pauseOnMouseEnter: true
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 1,
                slideShadows: false
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 4
                }
            }

        });

        const swiperPost = new Swiper('.swiper-post-container', {
            // Optional parameters
            loop: true,
            slidesPerView: 1,
            centeredSlides: true,
            spaceBetween: 16,
            initialSlide: 0,
            rtl: false,

            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 1,
                    centeredSlides: false,
                    spaceBetween: 16
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 3,
                    centeredSlides: false,
                    spaceBetween: 20
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 4,
                    centeredSlides: false,
                    spaceBetween: 24
                }
            }
        });
    </script>
@endsection
