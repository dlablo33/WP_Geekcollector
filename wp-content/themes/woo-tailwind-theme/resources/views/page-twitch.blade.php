{{--  
  Template Name: Twitch Template
--}}
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #9146FF;
            --secondary: #0E0E10;
            --accent: #1F1F23;
            --text: #EFEFF1;
            --text-secondary: #ADADB8;
            --highlight: #00FF7F;
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--secondary) 0%, #18181B 100%);
            color: var(--text);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(14, 14, 16, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
            text-decoration: none;
        }

        .logo i {
            color: var(--primary);
            animation: pulse 2s infinite;
        }

        .section-title {
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .twitch-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        #twitch-embed {
            width: 100%;
            height: 600px;
            background: #000;
            border-radius: 12px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .schedule-card {
            background: var(--accent);
            border-radius: 8px;
            padding: 20px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .schedule-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary);
        }

        .schedule-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .schedule-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .schedule-card .time {
            color: var(--highlight);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .schedule-card .game {
            display: inline-block;
            background: rgba(145, 70, 255, 0.2);
            color: var(--primary);
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @media (max-width: 768px) {
            #twitch-embed {
                height: 400px;
            }
        }
    </style>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">
                    <i class="fab fa-twitch"></i> GeekCollectorMTY
                </a>
            </nav>
        </div>
    </header>

    <!-- Twitch Player Section -->
    <section class="twitch-section">
        <div class="container">
            <div class="mb-2 flex items-center justify-between py-4">
                <div>
                    <span class="section-title"><i class="fas fa-broadcast-tower"></i> Transmisión en vivo </span>
                </div>

                <div class="flex gap-1">
                    <!-- SVG Facebook -->
                    <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/geek.collectormx/"
                        class="text-[#9146FF] transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- SVG Twitter -->
                    <a target="_blank" rel="noopener noreferrer" href="https://x.com/geekcollectormx"
                        class="text-[#9146FF] transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>

                    <!-- SVG Instagram -->
                    <a target="_blank" rel="noopener noreferrer" href="https://instagram.com/geek.collectormx"
                        class="text-[#9146FF] transition-colors duration-200 hover:text-orange-400">
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
                        class="text-[#9146FF] transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>

                    <!-- SVG Twitch -->
                    <a target="_blank" rel="noopener noreferrer" href="https://www.twitch.tv/geekcollectormty"
                        class="text-[#9146FF] transition-colors duration-200 hover:text-orange-400">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="twitch-container">
                <div id="twitch-embed"></div>
            </div>
        </div>
    </section>

    <!-- Schedule Section -->
    <section class="schedule-section">
        <div class="container">
            <h2 class="section-title"><i class="far fa-calendar-alt"></i> Horario & Torneos</h2>

            <div class="schedule-grid">
                <div class="schedule-card">
                    <h3>Horario de Tienda</h3>
                    <div class="time">1:00 PM - 11:00 PM</div>
                    <p>¡Visítanos en nuestro horario regular!</p>
                    <span class="game mt-1">Tienda</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de One Piece</h3>
                    <div class="time">Sábados - 6:00 PM</div>
                    <p>Participa en las batallas pirata más épicas.</p>
                    <span class="game mt-1">One Piece TCG</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de Magic</h3>
                    <div class="time">Viernes - 7:00 PM</div>
                    <p>Friday Night Magic y otros eventos especiales.</p>
                    <span class="game mt-1">Magic: The Gathering</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de Star Wars</h3>
                    <div class="time">Domingos - 5:00 PM</div>
                    <p>Demuestra tu fuerza en la galaxia.</p>
                    <span class="game mt-1">Star Wars TCG</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de Digimon</h3>
                    <div class="time">Jueves - 7:00 PM</div>
                    <p>Conquista el campo digital con tu deck.</p>
                    <span class="game mt-1">Digimon TCG</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de Lorcana</h3>
                    <div class="time">Miércoles - 6:00 PM</div>
                    <p>El universo Disney en cartas coleccionables.</p>
                    <span class="game mt-1">Lorcana</span>
                </div>

                <div class="schedule-card">
                    <h3>Torneos de Pokémon</h3>
                    <div class="time">Martes - 5:00 PM</div>
                    <p>¡Atrápalos a todos en nuestras ligas!</p>
                    <span class="game mt-1">Pokémon TCG</span>
                </div>

                <div class="schedule-card">
                    <h3>Streams especiales</h3>
                    <div class="time">Aleatorios</div>
                    <p>Apertura de cartas, cajas y coleccionables en vivo.</p>
                    <span class="game mt-1">Unboxings</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Twitch Embed Script -->
    <script src="https://player.twitch.tv/js/embed/v1.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Twitch.Player("twitch-embed", {
                channel: "geekcollectormty",
                width: "100%",
                height: "100%",
                autoplay: true,
                parent: [window.location.hostname]
            });
        });
    </script>
@endsection
