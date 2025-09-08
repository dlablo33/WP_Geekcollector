{{-- <div class="page-header">
  <h1>{!! $title !!}</h1>
</div> --}}
{{-- Codigo Añadido por Pao --}}
<div class="animated-gradient relative overflow-hidden py-16 text-white">
        <div class="absolute inset-0 z-0">
            <div class="animate-pulse-slow absolute inset-0 bg-gradient-to-r from-orange-500/20 via-orange-600/10 to-transparent"></div>
            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1633613286848-e6f43bbafb8d?q=80&w=1470&auto=format&fit=crop')] bg-cover bg-center opacity-10 mix-blend-overlay">
            </div>
        </div>

        <div class="container relative z-10 mx-auto px-4 text-center">
            <h2 class="animate-fade-in-down mb-6 text-4xl font-bold uppercase md:text-5xl">
                Explora todos los resultados de
            </h2>
            <h1
                class=" page-headermt-2 inline-block transform rounded-full bg-gradient-to-r from-orange-600 to-orange-500 px-8 py-3 text-xl font-bold tracking-wide text-white transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-orange-500/30">
                {!! $title !!}
            </h1>
        </div>
    </div>