@extends('layouts.app')

@section('content')
<style>
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #00000000 inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<section 
    class="px-4 md:px-14 w-full min-h-screen flex items-center justify-center bg-cover bg-center animate-fade-in" 
    style="background-image: url('{{ get_theme_file_uri('resources/images/login/fondologin.jpg') }}');">

    <div class="w-full md:w-4/5 lg:w-3/5 flex flex-col md:flex-row gap-8 bg-black/70 rounded-[40px] shadow-2xl p-6 md:p-10 border border-orange-500">

        {{-- Columna izquierda: Login --}}
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center text-gray-200">
            <img src="{{ get_theme_file_uri('public/images/logohead.png') }}" alt="Geek Collector" class="h-16 mb-6">

            <h2 class="text-3xl font-bold mb-6">INICIAR SESIÓN</h2>

            <form class="w-full flex flex-col gap-y-4 woocommerce-form woocommerce-form-login login" method="post" novalidate>
                @php do_action('woocommerce_login_form_start') @endphp

                <label for="username" class="flex flex-col gap-1">
                    <span class="text-sm font-semibold">Usuario o correo</span>
                    <input 
                        class="w-full bg-transparent p-3 rounded-xl border border-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500" 
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required>
                </label>

                <label for="password" class="flex flex-col gap-1">
                    <span class="text-sm font-semibold">Contraseña</span>
                    <input 
                        class="w-full bg-transparent p-3 rounded-xl border border-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500"
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required>
                </label>

                @php do_action('woocommerce_login_form') @endphp

                <a href="{{ wp_lostpassword_url() }}" class="ml-auto text-sm text-orange-400 hover:underline">
                    ¿Olvidaste tu contraseña?
                </a>

                <button 
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-yellow-400 to-red-500 text-lg font-bold shadow-md hover:scale-105 transition-transform"
                    type="submit"
                    name="login"
                    value="Log in">
                    ACCEDER
                </button>

                @php do_action('woocommerce_login_form_end') @endphp
            </form>

            <p class="mt-6 text-center text-sm">
                ¿Nuevo aquí? <a href="#registro" class="text-orange-400 font-semibold hover:underline">Crea tu cuenta</a>
            </p>
        </div>

        {{-- Columna derecha: Registro --}}
        @if( get_option('woocommerce_enable_myaccount_registration') === 'yes' )
        <div id="registro" class="w-full md:w-1/2 flex flex-col justify-center items-center text-gray-200 border-l border-gray-600 pl-0 md:pl-6">
            <h2 class="text-3xl font-bold mb-6">CREA TU CUENTA</h2>

            <form method="post" class="w-full flex flex-col gap-y-4 woocommerce-form woocommerce-form-register register">
                @php do_action('woocommerce_register_form_start') @endphp

                @if( get_option('woocommerce_registration_generate_username') === 'no' )
                <label for="reg_username" class="flex flex-col gap-1">
                    <span class="text-sm font-semibold">Nombre de usuario</span>
                    <input
                        class="w-full bg-transparent p-3 rounded-xl border border-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500"
                        id="reg_username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required>
                </label>
                @endif

                <label for="reg_email" class="flex flex-col gap-1">
                    <span class="text-sm font-semibold">Correo electrónico</span>
                    <input
                        class="w-full bg-transparent p-3 rounded-xl border border-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500"
                        id="reg_email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required>
                </label>

                @if( get_option('woocommerce_registration_generate_password') === 'no' )
                <label for="reg_password" class="flex flex-col gap-1">
                    <span class="text-sm font-semibold">Contraseña</span>
                    <input
                        class="w-full bg-transparent p-3 rounded-xl border border-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500"
                        id="reg_password"
                        name="password"
                        type="password"
                        required>
                    <p class="text-xs text-gray-400">Mínimo 8 caracteres con letras, números y símbolos.</p>
                </label>
                @else
                    <p class="text-sm text-gray-400">Se en</p>
                @endif

                @php do_action('woocommerce_register_form') @endphp

                <button 
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-yellow-400 to-red-500 text-lg font-bold shadow-md hover:scale-105 transition-transform"
                    type="submit"
                    name="register"
                    value="Register">
                    REGISTRARSE
                </button>

                @php do_action('woocommerce_register_form_end') @endphp
            </form>

            <p class="mt-6 text-center text-sm">
                ¿Ya tienes cuenta? <a href="#login" class="text-orange-400 font-semibold hover:underline">Inicia sesión</a>
            </p>
        </div>
        @endif
    </div>
</section>
@endsection
