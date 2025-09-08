@extends('layouts.app')

@section('content')
  <div class="flex flex-col items-center justify-center min-h-screen bg-black text-white text-center p-6">
    
    {{-- Contenedor de la imagen --}}
    <div class="mb-8">
      <img src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExeW5vNjM4Z3E2YW1hbWtvZXloN3R1bnRrdHdjdHN4Z3FtcW5nMTZzNiZlcD12MV9naWZzX3NlYXJjaCZjdD1n/LmNwrBhejkK9EFP504/giphy.gif" 
           alt="Naruto corriendo"
           class="w-80 rounded-lg shadow-lg border-4 border-orange-500 animate-border-glow">
    </div>

    {{-- Mensaje personalizado --}}
    <h1 class="text-4xl md:text-5xl font-bold text-orange-400 mb-4">
      Página no encontrada
    </h1>
    <p class="mb-8 text-lg max-w-xl opacity-90">
      Parece que te perdiste en el camino ...<br>
      Pero ya están corriendo para ayudarte.
    </p>

    {{-- Botón de acción --}}
    <a href="{{ home_url('/') }}"
       class="px-8 py-3 bg-orange-500 hover:bg-orange-600 rounded-full text-white font-bold transition-all duration-300 
              transform hover:scale-110 shadow-lg hover:shadow-orange-500/30 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
      </svg>
      Volver al Inicio
    </a>
  </div>
@endsection

@section('styles')
  <style>
    @keyframes border-glow {
      0% { border-color: #f97316; }
      50% { border-color: #f59e0b; }
      100% { border-color: #f97316; }
    }
    .animate-border-glow {
      animation: border-glow 3s infinite;
    }
  </style>
@endsection
