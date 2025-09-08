@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Encabezado con animación -->
    <div class="text-center mb-12">
        <!-- Banner animado para el título -->
        <div class="banner-container mb-6 inline-block">
            <div class="banner-background animate-banner-glow">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 animate-fade-in-down relative z-10 px-6 py-4">Subastas Activas</h1>
            </div>
        </div>

    <!-- Shortcode de subastas -->
    <div class="mb-16 animate-fade-in">
        @php echo do_shortcode('[auctions]'); @endphp
    </div>

    <!-- Separador -->
    <div class="relative my-16">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="px-3 bg-white text-lg font-medium text-gray-900">Más subastas</span>
        </div>
    </div>

    <!-- Grid de subastas personalizadas -->
    @php
        $args = [
            'post_type' => 'product',
            'posts_per_page' => 9,
            'tax_query' => [
                [
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'auction',
                ],
            ],
            'meta_query' => [
                [
                    'key'     => '_auction_closed',
                    'value'   => '0',
                    'compare' => '='
                ]
            ]
        ];
        $subastas = new WP_Query($args);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @if($subastas->have_posts())
            @while($subastas->have_posts()) 
                @php 
                    $subastas->the_post(); 
                    global $product; 
                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                    $time_remaining = $product->get_seconds_remaining();
                    $bid_count = $product->get_auction_bid_count();
                @endphp
                
                <div class="auction-card bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 animate-fade-in">
                    <!-- Badge de estado -->
                    <div class="absolute top-4 left-4 z-10">
                        <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                            Activa
                        </span>
                    </div>
                    
                    <!-- Imagen de la subasta -->
                    <div class="relative overflow-hidden">
                        <a href="{{ get_permalink() }}">
                            <img class="w-full h-56 object-cover transition-transform duration-500 hover:scale-105" 
                                 src="{{ $featured_image ? $featured_image[0] : 'https://via.placeholder.com/400x300?text=Imagen+No+Disponible' }}" 
                                 alt="{{ get_the_title() }}">
                        </a>
                        
                        <!-- Contador regresivo -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4 text-white">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold">Termina en:</span>
                                <div class="countdown flex space-x-1" data-end-time="{{ $product->get_auction_end_time('c') }}">
                                    <span class="hours">00</span>:<span class="minutes">00</span>:<span class="seconds">00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contenido de la subasta -->
                    <div class="p-5">
                        <a href="{{ get_permalink() }}">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 hover:text-blue-600 transition-colors duration-300">{{ get_the_title() }}</h3>
                        </a>
                        
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-sm text-gray-600">Puja actual</p>
                                <p class="text-2xl font-bold text-blue-600">{{ wc_price($product->get_auction_current_bid()) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Pujas</p>
                                <p class="text-lg font-semibold">{{ $bid_count }}</p>
                            </div>
                        </div>
                        
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-sm text-gray-600 mb-1">
                                <i class="fas fa-gavel mr-2"></i>Precio inicial: {{ wc_price($product->get_auction_start_price()) }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <i class="far fa-clock mr-2"></i>Termina: {{ $product->get_auction_end_time() }}
                            </p>
                        </div>
                        
                        <a href="{{ get_permalink() }}" class="mt-4 block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                            Pujar ahora
                        </a>
                    </div>
                </div>
            @endwhile
            @php wp_reset_postdata(); @endphp
        @else

        @endif
    </div>

<style>
    /* Animaciones personalizadas */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Animación para el banner con efecto de difuminado */
    @keyframes bannerGlow {
        0% {
            background-position: 0% 50%;
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.5);
        }
        50% {
            background-position: 100% 50%;
            box-shadow: 0 0 40px rgba(255, 140, 0, 0.7);
        }
        100% {
            background-position: 0% 50%;
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.5);
        }
    }
    
    /* Animación para el texto del banner */
    @keyframes textPulse {
        0% {
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
        }
        50% {
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.9), 0 0 20px rgba(255, 255, 255, 0.6);
        }
        100% {
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
        }
    }
    
    .banner-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .banner-background {
        background: linear-gradient(270deg, #ff8c00, #ffd700, #ffa500, #ff8c00);
        background-size: 400% 400%;
        border-radius: 12px;
        padding: 4px;
        animation: bannerGlow 4s ease infinite;
    }
    
    .banner-background h1 {
        background: linear-gradient(45deg, #ff8c00, #ffa500, #ffd700);
        border-radius: 8px;
        display: inline-block;
        animation: textPulse 3s ease-in-out infinite;
    }
    
    .animate-fade-in-down {
        animation: fadeInDown 0.6s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        animation-delay: 0.2s;
        opacity: 0;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
        opacity: 0;
    }
    
    .animate-banner-glow {
        animation: bannerGlow 4s ease infinite;
    }
    
    .auction-card {
        opacity: 0;
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .auction-card:nth-child(1) { animation-delay: 0.1s; }
    .auction-card:nth-child(2) { animation-delay: 0.2s; }
    .auction-card:nth-child(3) { animation-delay: 0.3s; }
    .auction-card:nth-child(4) { animation-delay: 0.4s; }
    .auction-card:nth-child(5) { animation-delay: 0.5s; }
    .auction-card:nth-child(6) { animation-delay: 0.6s; }
    
    /* Efecto de carga para las imágenes */
    .auction-card img {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de los contadores regresivos
    function updateCountdowns() {
        document.querySelectorAll('.countdown').forEach(countdown => {
            const endTime = new Date(countdown.dataset.endTime).getTime();
            const now = new Date().getTime();
            const distance = endTime - now;
            
            if (distance < 0) {
                countdown.innerHTML = "Finalizada";
                return;
            }
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            countdown.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
            countdown.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
            countdown.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
        });
    }
    
    // Actualizar contadores cada segundo
    setInterval(updateCountdowns, 1000);
    updateCountdowns();
    
    // Efectos de hover para las tarjetas
    const auctionCards = document.querySelectorAll('.auction-card');
    auctionCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.querySelector('img').style.transform = 'scale(1.05)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.querySelector('img').style.transform = 'scale(1)';
        });
    });
    
    // Efecto de aparición al hacer scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observar todas las tarjetas de subasta
    auctionCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
});
</script>

<!-- Font Awesome para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection