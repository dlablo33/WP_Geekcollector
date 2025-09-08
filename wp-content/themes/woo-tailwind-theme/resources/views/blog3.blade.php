{{-- 
Template Name: Blog3
--}}
@extends('layouts.app')

@section('content')
    @php
        $blogs = [
            [
                'titulo' => 'La saga gótica Majo Suiri de Makoto Sanda tendrá adaptación a manga',
                'subtitulo' => 'La misteriosa historia de brujas y enigmas llega al formato manga de la mano de Yū Mitsuki.',
                'escritor' => 'Ryo',
                'fecha_publicacion' => '2025-08-18T21:12:34.567890+00:00',
                'img' => 'https://cdn.somoskudasai.com/image/7988da4690adf9dd38ce7f89eef59d17/1280x720/majo-suiri-de-makoto-sanda.webp',
                'contenido' => '
                    El pasado viernes, Yū Mitsuki lanzó la adaptación a manga de las novelas Majo Suiri (La deducción de la bruja) de Makoto Sanda a través del portal Kadocomi de Kadokawa. Esta nueva propuesta busca dar vida al universo gótico y enigmático creado por el reconocido autor.
                    <H2>Misterio con tintes sobrenaturales</H2>

                    La historia gira en torno a Kunori Orizue, una joven tan bella como enigmática que se autoproclama "bruja". A su alrededor comienzan a suceder incidentes inquietantes y llenos de misterio. Todo se complica cuando se reencuentra con su amigo de la infancia, Takumi, quien termina atrapado en la cadena de sucesos inexplicables que envuelven a Kunori.
                    <H2>El recorrido literario de la obra</H2>

                    La primera novela de la saga se publicó en agosto de 2023, mientras que la segunda vio la luz en diciembre de 2023. Ambas cuentan con ilustraciones de Kaomin, aportando un estilo visual que refuerza la atmósfera oscura y misteriosa de la trama.
                    <H2>Makoto Sanda: un autor de peso</H2>

                    Makoto Sanda no es ajeno al mundo del manga y las novelas ligeras. Junto a Isuo Tsukumo, trabajó en el spin-off The Ancient Magus Bride: Wizard\'s Blue, que se publicó entre abril de 2019 y marzo de 2024. La editorial Seven Seas editó el manga en Occidente, con su octavo volumen disponible desde abril de 2024.

                    Entre sus trabajos más destacados también se encuentra Rental Magica, publicada entre 2004 y 2013 en 24 volúmenes, la cual inspiró un anime de 24 episodios estrenado en 2007. Además, es autor de The Case Files of Lord El-Melloi II, ambientada en el universo Fate/stay night, que recibió una adaptación al anime en 2019 con el título Rail Zeppelin Grace note, y un especial televisivo en 2021.

                    La versatilidad de Sanda también lo llevó a ser el Dungeon Master de la campaña de rol “Red Dragon”, que inspiró la serie Chaos Dragon. En esa partida participaron nombres de gran peso en la industria como Kinoko Nasu (Type-Moon, Fate/stay night) y Gen Urobuchi (Fate/Zero), consolidando a Sanda como una figura clave en la creación de universos narrativos ricos y complejos.
                    ',
                'categoria' => 'Manga',
                'tags' => ['Makoto Sanda', 'Kadocomi', 'Majo Suiri'],
            ],
        ];
    @endphp

    <div class="container mx-auto px-2 py-4 sm:px-4">
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-7 md:col-start-2">
                <div class="w-full">
                    @foreach ($blogs as $blog)
                        <div class="px-3 md:px-0">
                            <div class="mb-2 text-sm font-semibold text-violet-300 hover:underline">
                                <a href="#">
                                    {{ $blog['categoria'] }}
                                </a>
                            </div>
                            <div class="mb-2 text-5xl text-white">
                                {{ $blog['titulo'] }}
                            </div>
                            <div class="mb-2 text-xl text-gray-500">
                                {{ $blog['subtitulo'] }}
                            </div>
                            <div class="mb-1 text-base text-white transition-colors duration-300 ease-in-out hover:text-violet-700">
                                <a href="#">
                                    {{ $blog['escritor'] }}
                                </a>
                            </div>
                            <div class="mb-5 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse('2025-08-18T21:12:34.567890+00:00')->diffForHumans(\Carbon\Carbon::now()) }}
                            </div>
                        </div>

                        <div>
                            <img class="mb-5 h-full w-full" src="{{ $blog['img'] }}" alt="">
                        </div>

                        <div class="px-3 md:px-0">
                            <div class="grid grid-cols-12">
                                <div class="col-span-12 flex items-start justify-center text-white md:col-span-1 md:col-start-1">

                                    <!-- AddToAny BEGIN -->
                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style my-3 flex space-x-3 md:flex-col md:space-y-4" data-a2a-title="GeekCollector">
                                        <span class="text-base text-white md:hidden">Comparte:</span>
                                        <a class="a2a_button_facebook">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a class="a2a_button_whatsapp">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M20.52 3.48A11.84 11.84 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.12.55 4.2 1.59 6.02L0 24l6.21-1.62A11.95 11.95 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.19-1.24-6.18-3.48-8.52zM12 22a9.9 9.9 0 0 1-5.06-1.38l-.36-.22-3.68.96.98-3.59-.24-.37A9.93 9.93 0 0 1 2 12c0-5.52 4.48-10 10-10 2.67 0 5.18 1.04 7.07 2.93A9.93 9.93 0 0 1 22 12c0 5.52-4.48 10-10 10zm5.48-7.57c-.3-.15-1.78-.88-2.05-.98-.28-.1-.48-.15-.68.15-.2.3-.78.97-.95 1.17-.18.2-.35.23-.65.08-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.38-.03-.53-.08-.15-.68-1.64-.93-2.25-.24-.58-.48-.5-.68-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.08-.8.38-.28.3-1.05 1.02-1.05 2.48 0 1.46 1.07 2.87 1.22 3.07.15.2 2.1 3.2 5.1 4.48 2.99 1.28 3.6.98 4.25.92.65-.06 2.09-.85 2.38-1.67.3-.82.3-1.52.2-1.67-.1-.15-.28-.23-.58-.38z" />
                                            </svg>

                                        </a>
                                        <a class="a2a_button_x">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                            </svg>
                                        </a>
                                        <!-- Clipboard -->
                                        <button type="button" class="hover:cursor-pointer" onclick="copyPageUrl()">
                                            <svg class="h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8" />
                                            </svg>
                                        </button>

                                    </div>
                                    <script>
                                        var a2a_config = a2a_config || {};
                                        a2a_config.locale = "es";
                                    </script>
                                    <script defer src="https://static.addtoany.com/menu/page.js"></script>
                                    <!-- AddToAny END -->

                                </div>

                                <div class="col-span-12 text-white md:col-span-10 md:col-start-2">
                                    @php
                                        $dom = new DOMDocument();
                                        @$dom->loadHTML(mb_convert_encoding($blog['contenido'], 'HTML-ENTITIES', 'UTF-8'));
                                        $elements = $dom->getElementsByTagName('body')->item(0)->childNodes;
                                    @endphp
                                    @foreach (iterator_to_array($elements) as $element)
                                        @if ($element->nodeName === 'h2')
                                            <div class="my-4 text-2xl font-bold text-white">{{ $element->nodeValue }}</div>
                                        @else
                                            @php
                                                $textContent = trim($element->textContent);
                                            @endphp
                                            @if ($textContent !== '')
                                                <div class="my-3 text-lg text-white">{{ $textContent }}</div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($blog['tags'] as $tag)
                                <div
                                    class="mr-1 mt-4 inline-block space-x-3 rounded-full bg-gradient-to-r from-yellow-200 via-orange-600 to-red-600 p-[2px] hover:from-yellow-300 hover:via-orange-500 hover:to-red-500 md:mr-2">
                                    <div class="rounded-full bg-black px-4 py-2 text-sm font-bold text-white md:text-base">
                                        <a href="#">{{ $tag }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            @php
                $categorias = [
                    [
                        'nombre' => 'PSA Gems',
                        'icon' => '
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512"
                            style="enable-background:new 0 0 512 512;" xml:space="preserve" width="30" height="30">
                            <g>
                                <g>
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M385.321,429.5h45c16.57,0,30-13.43,30-30v-362c0-16.57-13.43-30-30-30h-273.64c-16.57,0-30,13.43-30,30v45" />
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M420.321,141.752V250.5c0,2.21-1.79,4-4,4h-31" />
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M166.681,82.5v-31c0-2.21,1.79-4,4-4h245.64c2.21,0,4,1.79,4,4v55.252" />
                                    <g>

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="385.324"
                                            y1="304" x2="420.324" y2="304" />

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="385.324"
                                            y1="334" x2="420.324" y2="334" />

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="385.324"
                                            y1="364" x2="420.324" y2="364" />
                                    </g>
                                </g>
                                <g>
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M355.324,504.5H81.679c-16.569,0-30-13.431-30-30v-362c0-16.569,13.431-30,30-30h273.646c16.569,0,30,13.431,30,30v362&#10;&#9;&#9;&#9;C385.324,491.069,371.893,504.5,355.324,504.5z" />
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M134.868,329.5H95.679c-2.209,0-4-1.791-4-4v-199c0-2.209,1.791-4,4-4h245.645c2.209,0,4,1.791,4,4v199c0,2.209-1.791,4-4,4&#10;&#9;&#9;&#9;H169.868" />
                                    <g>

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="91.679"
                                            y1="379" x2="345.324" y2="379" />

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="91.679"
                                            y1="409" x2="345.324" y2="409" />

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="91.679"
                                            y1="439" x2="345.324" y2="439" />

                                        <line style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" x1="91.679"
                                            y1="469" x2="285.324" y2="469" />
                                    </g>
                                    <path style="fill:currentColor;stroke:#000000;stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                        d="&#10;&#9;&#9;&#9;M229.282,166.717l11.935,24.183c1.751,3.548,5.136,6.007,9.051,6.576l26.687,3.878c9.86,1.433,13.798,13.55,6.663,20.505&#10;&#9;&#9;&#9;l-19.311,18.824c-2.833,2.762-4.126,6.741-3.457,10.641l4.559,26.579c1.684,9.82-8.623,17.309-17.443,12.673l-23.87-12.549&#10;&#9;&#9;&#9;c-3.502-1.841-7.686-1.841-11.188,0l-23.87,12.549c-8.819,4.637-19.127-2.852-17.443-12.673l4.559-26.579&#10;&#9;&#9;&#9;c0.669-3.9-0.624-7.879-3.457-10.641l-19.311-18.824c-7.135-6.955-3.198-19.072,6.663-20.505l26.687-3.878&#10;&#9;&#9;&#9;c3.916-0.569,7.3-3.028,9.051-6.576l11.935-24.183C212.131,157.782,224.872,157.782,229.282,166.717z" />
                                </g>
                            </g>
                        </svg>
                        ',
                    ],
                    [
                        'nombre' => 'TCG News',
                        'icon' =>
                            '<svg id="Glyph" enable-background="new 0 0 64 64" height="30" viewBox="0 0 64 64" width="30" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path d="m5.799 18.381c-1.826 1.243-2.299 3.731-1.057 5.557l7.187 10.561-4.781-17.036z"/><path d="m28.947 2.629-2.867 1.951 7.238-2.031c-1.304-.815-3.018-.841-4.371.08z"/><path d="m35.053 61.371 2.867-1.951-7.238 2.031c1.304.815 3.018.841 4.371-.08z"/><path d="m58.201 45.619c1.826-1.243 2.299-3.731 1.057-5.557l-7.187-10.561 4.781 17.037z"/><path d="m8.725 15.681 3.275 11.669v-16.742l-.504.141c-2.127.597-3.367 2.805-2.771 4.932z"/><path d="m38.455 3.184-2.907.816h6.59c-.981-.839-2.347-1.19-3.683-.816z"/><path d="m25.545 60.816 2.907-.816h-6.59c.981.839 2.347 1.19 3.683.816z"/><path d="m52 53.392.504-.141c2.127-.597 3.367-2.805 2.771-4.932l-3.275-11.67z"/><path d="m14 10v44c0 2.209 1.791 4 4 4h28c2.209 0 4-1.791 4-4v-44c0-2.209-1.791-4-4-4h-28c-2.209 0-4 1.791-4 4zm5 45h-2v-2h2zm26-46h2v2h-2zm0 44h2v2h-2zm-13-32c5.738 0 10.444 4.394 10.95 10h-7.09c-.45-1.72-2-3-3.86-3s-3.41 1.28-3.86 3h-7.09c.506-5.606 5.212-10 10.95-10zm2 11c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-5.86 1c.45 1.72 2 3 3.86 3s3.41-1.28 3.86-3h7.09c-.506 5.606-5.212 10-10.95 10s-10.444-4.394-10.95-10zm-9.14-22h-2v-2h2z"/></g></svg>',
                    ],
                    [
                        'nombre' => 'New Arrivals',
                        'icon' =>
                            '<svg id="svg2" enable-background="new 0 0 300 300" height="30" viewBox="0 0 300 300" width="30" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><path id="path8" clip-rule="evenodd" d="m291.9 148.3-129.9 109c-2.4 2-6 1.7-8-.7l-69.5-82.8c-2-2.4-1.7-6 .7-8l129.9-109c2.4-2 6-1.7 8 .7l69.5 82.8c2 2.4 1.7 6-.7 8zm-216.1 25.2 67.1 80c-1.3 0-2.5-.4-3.6-1.3l-82.8-69.5c-2.4-2-2.7-5.6-.7-8l109-129.9c2-2.4 5.6-2.7 8-.7l23.7 19.9-120 100.7c-2.6 2.1-3 6.1-.7 8.8zm-28 10.3 82.1 68.9c-1.6.8-3.6.8-5.3-.2l-93.6-54c-2.7-1.6-3.6-5-2.1-7.8l84.8-146.9c1.6-2.7 5-3.6 7.8-2.1l25.1 14.5-99.6 118.7c-2.2 2.7-1.9 6.7.8 8.9zm-25.1 17.3 93.2 53.8c-1.3.7-2.9.8-4.4.2l-101.5-37c-2.9-1.1-4.5-4.3-3.4-7.3l58-159.4c1.1-2.9 4.3-4.5 7.3-3.4l26.4 9.6-77.9 134.9c-1.8 3-.8 6.8 2.3 8.6z" fill="currentColor" fill-rule="evenodd"/></svg>',
                    ],
                    [
                        'nombre' => 'Funko News',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 73 26">
                            <g fill="currentColor" fill-rule="evenodd">
                                <path d="M21.536 11.226c-.473-.45-1.96-.274-4.827-.113.566-2.392.97-4.48 2.027-6.107 4.91.275 10.944.964 17.855.944C50.196 5.911 50.319.845 50.319.845c-5.789 1.668-13.74 1.175-19.753.621C23.016.772 15.465-.966 9.227.702c-7.367 1.97-8.076 7.44-7.813 9.787C4.37 6.61 8.368 5.23 13.49 4.94c.485-.027.996-.037 1.518-.041-.93.975-1.652 2.511-2.4 4.906-.162.525-.321 1.027-.478 1.519-6.3.547-7.523 3.425-7.161 4.18.385.804 2.62-.25 5.41-.56.178-.02.35-.036.52-.054-1.09 2.817-2.294 4.829-4.232 6.005C3.712 22.687.62 21.858 0 21.36c.24 3.288 5.184 5.08 9.386 2.78 3.35-1.832 5.288-6.206 6.35-9.484a49.11 49.11 0 0 0 2.77-.087c2.535-.17 3.648-2.754 3.03-3.342M72.376 7.543a.996.996 0 0 0-1.255.653c-.079.25-.056.51.044.73-.953.872-1.834 1.518-2.298 1.368-.6-.194-.146-1.825.44-3.312a1.086 1.086 0 0 0 1.201-.752 1.103 1.103 0 0 0-.704-1.383 1.085 1.085 0 0 0-1.367.711c-.13.41-.009.84.275 1.122-.78 1.43-1.593 2.667-2.305 2.459l-.026-.007c-.716-.232-.669-1.723-.482-3.355.4-.057.754-.339.885-.754a1.102 1.102 0 0 0-.703-1.383 1.085 1.085 0 0 0-1.368.711c-.164.517.07 1.067.53 1.31-.377 1.555-.946 3.148-1.546 2.954-.461-.15-.806-1.186-1.08-2.45a1.012 1.012 0 0 0-.178-1.844.996.996 0 0 0-1.255.654 1.012 1.012 0 0 0 .762 1.299l.177 4.238 6.936 2.253 2.582-3.35a.995.995 0 0 0 1.38-.602c.169-.531-.12-1.1-.645-1.27"/>
                                <path d="M64.405 19.355c-1.287 2.286-3.126 3.45-4.106 2.602-.98-.848-.73-3.389.557-5.675 1.287-2.285 3.125-3.45 4.105-2.601.98.848.731 3.389-.556 5.674M62.658 11.5s-1.649.62-2.796 1.706c-.39.37-.766.753-1.107 1.178h-.001l-.006.01c-.317.396-.565.82-.83 1.274-.37.628-.693 1.29-.948 1.983v-.003s-.664 1.402-1.15 2.102c-.472.68-1.368 1.33-1.726 1.576a9.195 9.195 0 0 1-1.295.489c-2.945.859-3.486-1.26-2.827-2.26.237-.359 1.867-1.612 2.981-2.539 2.155-1.79 3.632-2.926 4.646-3.956 1.074-1.09.38-1.692-.454-1.836-2.08-.359-3.032.197-3.638.717-.73.627-5.085 5.878-5.085 5.878S55.51 4.104 56.673 1.746c.96-1.943-3.646-2.212-4.918.583-.74 1.626-5.82 13.396-6.44 14.852-1.134 2.662-1.202 3.078-1.769 3.544a.261.261 0 0 0-.016.022l-.044.028c-.002 0-.003.002-.005.004-.546.451-1.31.858-1.82.85-.307-.003-.488-.187-.54-.564-.053-.376-.008-.856.135-1.44.085-.348.198-.729.342-1.143.143-.414.299-.832.468-1.256.168-.424.341-.838.52-1.242l.49-1.116c.147-.338.272-.63.374-.874.102-.246.165-.42.19-.523.17-.696.137-1.323-.041-1.719-.179-.395-.501-.593-.968-.593-.466 0-.907.131-1.313.364-.447.256-.854.536-1.277 1.045a47.664 47.664 0 0 0-1.054 1.334c-.233.306-.481.625-.745.96-.263.334-.511.65-.743.952a883.803 883.803 0 0 1-1.003 1.299h-.28c.016-.066.062-.195.136-.388.076-.193.166-.42.272-.678a134.748 134.748 0 0 0 .69-1.736c.112-.287.21-.55.298-.791.086-.24.147-.43.18-.572.127-.517.13-.931.01-1.241-.12-.311-.431-.466-.935-.466s-.938.146-1.303.437a3.08 3.08 0 0 0-.86 1.087 47.714 47.714 0 0 0-.896 2.005 72.243 72.243 0 0 0-1.86 4.92 34.96 34.96 0 0 0-.337 1.058c-.663.337-1.35.624-2.062.84-.273.083-.612.14-.808-.07-.144-.153-.147-.39-.127-.601.102-1.114.579-2.152 1.031-3.173a96.909 96.909 0 0 0 2.134-5.222c.082-.22.165-.463.093-.686-.112-.351-.53-.479-.89-.527-.78-.103-1.68-.025-2.184.586-.166.202-.273.446-.378.686l-2.588 5.904c-.544 1.24-1.217 2.604-2.484 3.045-.22.077-.467.12-.68.025-.272-.121-.413-.443-.412-.744.001-.301.116-.588.229-.867 1.066-2.626 1.854-4.452 2.92-7.079.05-.12.314-.734.322-1.022a.502.502 0 0 0-.276-.436c-.68-.315-1.508-.125-2.122.307-.967.68-1.496 1.78-1.973 2.827-.529 1.161-1.066 2.32-1.548 3.504-.551 1.355-1.141 2.667-1.442 4.102-.153.733-.111 1.678.416 2.204.344.343.858.442 1.34.457 1.952.062 3.8-.971 5.225-2.322.05.715.155 1.534.747 1.93.378.251.864.259 1.314.21.905-.096 1.781-.38 2.627-.72.353-.143.701-.295 1.045-.457.004.153.02.298.047.433.06.277.184.498.378.663.192.164.48.247.863.247.307 0 .595-.071.863-.212.267-.14.542-.404.822-.79l5.46-7.341h.224a71.873 71.873 0 0 0-.796 2.111 18.37 18.37 0 0 0-.558 1.827c-.352 1.44-.444 2.535-.277 3.283.167.748.507 1.122 1.02 1.122s1.02-.073 1.523-.219a9.837 9.837 0 0 0 1.48-.565c.336-.159.666-.339.995-.527-.001.124-.037.361-.042.473-.017.405.043.49.23.664.186.175.38.191.78.191.3 0 .408-.027.671-.219.248-.18 1.147-1.524 1.839-2.481.114-.157.239-.32.377-.489-.254 1.187.292 2.92 1.928 3.19 1.59.262 4.176-.103 7.513-2.705.059.363.15.706.276 1.026.242.613.623 1.11 1.142 1.49.519.38 1.21.571 2.072.571.598 0 1.187-.104 1.766-.312a7.634 7.634 0 0 0 1.67-.844 9.093 9.093 0 0 0 1.498-1.26 11.898 11.898 0 0 0 2.185-3.184c.48-1.092.71-1.91.95-3.168.11-.67.17-1.262.162-1.804 0 0-.06-1.338-.242-1.46-.181-.122-5.24-1.66-5.24-1.66"/>
                            </g>
                        </svg>',
                    ],
                ];
            @endphp
            <div class="col-span-12 mt-10 md:col-span-3">
                <div class="px-8">
                    <div class="rounded-xl border-2 border-gray-500 p-4">
                        <h2 class="mb-2 py-4 text-2xl font-semibold text-gray-500">Categorías</h2>
                        @foreach ($categorias as $categoria)
                            <a href="#">
                                <div class="text-white">
                                    <div
                                        class="flex items-center gap-x-4 rounded-xl px-2 py-4 text-center text-2xl font-semibold transition-colors duration-300 hover:bg-gray-100/50">
                                        {!! $categoria['icon'] !!}
                                        <span class="mr-auto">{{ $categoria['nombre'] }}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        async function copyPageUrl() {
            try {
                await navigator.clipboard.writeText(location.href);
                console.log('Page URL copied to clipboard');
                Toastify({
                    text: "Copiado",
                    duration: 3000,
                    backgroundColor: "black",
                    style: {
                        color: "white" // This sets the text color to white
                    }
                }).showToast();
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
    </script>
@endsection
