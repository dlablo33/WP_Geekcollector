{{-- 
Template Name: iGeek
--}}
@extends('layouts.app')

@section('content')
<style>
  @keyframes move-x {
    0% {
      transform: translateX(-100%) scaleX(1);
    }
    50% {
      transform: translateX(100%) scaleX(1);
    }
    50.01% {
      transform: translateX(100%) scaleX(-1);
    }
    100% {
      transform: translateX(-100%) scaleX(-1);
    }
  }

  .animate-move-x {
    animation: move-x 8s linear infinite;
  }
  
  .map-container {
    border-radius: 0.75rem;
    overflow: hidden;
  }
</style>

<section class="min-h-screen flex flex-col items-center justify-start bg-gradient-to-r from-orange-900 via-black to-orange-900 text-white text-center px-6 py-10 space-y-10">
    <!-- Logo -->
<!-- Logo Mejorado -->
<div class="flex flex-col items-center space-y-3">
    <img src="{{ get_stylesheet_directory_uri() }}/resources/images/iconlogo.png" 
         alt="Geek Collector Logo" 
         class="w-32 h-32 mb-2">
    <h1 class="text-4xl font-bold tracking-tight text-center">
        <span class="text-orange-500">GEEK</span>COLLECTOR
    </h1>

    <p class="text-lg text-gray-300 max-w-2xl text-center leading-relaxed">
        Somos una tienda especializada en figuras premium, cartas coleccionables, 
        torneos oficiales y eventos exclusivos para verdaderos collectors.
    </p>
     <div class="text-xl font-semibold text-orange-400 text-center">
        COLECCIONABLES | TORNEOS | COMUNIDAD
    </div> 

</div>

    <!-- Redes sociales -->
    <div class="flex space-x-6 justify-center text-2xl">
        <a href="https://instagram.com" target="_blank" class="hover:text-orange-500"><i class="fab fa-instagram"></i></a>
        <a href="https://facebook.com" target="_blank" class="hover:text-orange-500"><i class="fab fa-facebook"></i></a>
        <a href="https://youtube.com" target="_blank" class="hover:text-orange-500"><i class="fab fa-youtube"></i></a>
        <a href="https://twitch.tv" target="_blank" class="hover:text-orange-500"><i class="fab fa-twitch"></i></a>
    </div>

    <!-- Animación -->
    <div class="relative w-full max-w-xl h-40 overflow-hidden flex items-center justify-center">
        <img src="{{ get_stylesheet_directory_uri() }}/resources/images/3gXp.gif" 
             alt="GeekCollector Animation"
             class="absolute h-32 w-auto animate-move-x object-contain">
    </div>

    <!-- Ubicación -->
<!-- Ubicación Mejorada -->
<div class="relative bg-gradient-to-br from-black to-gray-900 border-2 border-orange-500 rounded-2xl overflow-hidden w-full max-w-2xl text-center shadow-2xl shadow-orange-900/50">
    <!-- Efecto de esquina naranja -->
    <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-l-4 border-orange-500 rounded-tl-xl"></div>
    <div class="absolute bottom-0 right-0 w-16 h-16 border-b-4 border-r-4 border-orange-500 rounded-br-xl"></div>
    
    <div class="p-1 bg-gradient-to-r from-orange-600 to-orange-800">
        <h2 class="text-2xl font-bold py-2 text-white tracking-wider">
            <span class="text-orange-300">📍</span> VISÍTANOS
        </h2>
    </div>
    
    <div class="p-5">
        <!-- Mapa con efecto hover -->
        <div class="w-full h-64 mb-5 rounded-xl overflow-hidden transform hover:scale-[1.02] transition-all duration-300 shadow-lg">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3584.240805177345!2d-100.326!3d25.686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662be3be8b8a4d1%3A0xf8f9445f7f1d2a55!2sPlaza%20Punta%20Sur!5e0!3m2!1ses!2smx!4v1699999999999" 
                width="100%" height="100%" style="border:none;" allowfullscreen="" loading="lazy"
                class="hover:opacity-90 transition-opacity">
            </iframe>
        </div>
        
        <!-- Dirección con iconos -->
        <div class="space-y-2 mb-6">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-store text-orange-500"></i>
                <p class="text-lg font-medium text-white">Geek Collector</p>
            </div>
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-map-marker-alt text-orange-500"></i>
                <p class="text-gray-300">Plaza Punta Sur, Av. Alfonso Reyes 255</p>
            </div>
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-door-open text-orange-500"></i>
                <p class="text-gray-300">Local 20 y 21, Contry</p>
            </div>
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-city text-orange-500"></i>
                <p class="text-gray-300">64850 Monterrey, N.L., México</p>
            </div>
        </div>
        
        <!-- Botón con efecto -->
        <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3596.8868565144835!2d-100.27947329999999!3d25.641880399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662bf99d30c3957%3A0x3492755f898822d6!2sAv.%20Alfonso%20Reyes%20255%2C%20Contry%2C%2064860%20Monterrey%2C%20N.L.!5e0!3m2!1ses-419!2smx!4v1755549626022!5m2!1ses-419!2smx" target="_blank"
           class="inline-flex items-center justify-center bg-gradient-to-r from-orange-600 to-orange-800 hover:from-orange-700 hover:to-orange-900 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 group">
           <span>¿Cómo llegar?</span>
           <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>

    <!-- Cupón / CTA -->
<!-- Cupón Mejorado -->

</div>
</section>
@endsection