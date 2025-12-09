{{-- resources/views/woocommerce/myaccount/form-login.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        /* Estilos para autocompletado */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Transiciones entre formularios */
        .form-container {
            transition: all 0.5s ease-in-out;
            overflow: hidden;
        }

        .hidden-form {
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            position: absolute;
            width: 100%;
            transform: translateX(100%);
        }

        .visible-form {
            opacity: 1;
            max-height: 1000px;
            position: relative;
            transform: translateX(0);
        }

        /* Estilo para botones de alternancia */
        .switch-button {
            background: transparent;
            color: #f56565;
            border: 2px solid #f56565;
            transition: all 0.3s ease;
        }

        .switch-button:hover {
            background: #f56565;
            color: white;
            transform: scale(1.02);
        }

        /* Estilo para campos de formulario */
        .form-input {
            width: 100%;
            background: transparent;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 9999px;
            color: white;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #f56565;
        }

        /* Estilo para botón de submit */
        .submit-btn {
            width: 100%;
            padding: 0.75rem;
            border-radius: 9999px;
            background: linear-gradient(to right, #f6e05e, #f56565);
            color: white;
            font-weight: bold;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 101, 101, 0.4);
        }

        /* Ocultar campos ocultos de WooCommerce */
        input[type="hidden"] {
            display: none !important;
        }

        .dokan-role-customer{
            display: none !important;
        }
    </style>

    <section class="flex min-h-screen w-full items-center justify-center bg-cover bg-center px-4 md:px-14"
        style="background-image: url('/wp-content/themes/woo-tailwind-theme/resources/images/login/fondologin.jpg');">

        <div class="w-full max-w-md bg-transparent">
            {{-- Formulario de Login --}}
            <div id="loginForm" class="form-container visible-form rounded-[50px] border-4 border-orange-500 bg-black/60 p-8 text-gray-200 shadow-lg">
                <h2 class="mb-6 text-center text-4xl font-bold">INICIAR SESIÓN</h2>

                <form class="woocommerce-form woocommerce-form-login login" method="post">
                    @php do_action('woocommerce_login_form_start') @endphp

                    <div class="mb-4 space-y-4">
                        <div>
                            <label for="username" class="mb-2 block text-base font-bold">NOMBRE DE USUARIO O CORREO ELECTRÓNICO</label>
                            <input type="text" class="form-input" name="username" id="username" autocomplete="username" value="{{ old('username') }}" required>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-base font-bold">CONTRASEÑA</label>
                            <input type="password" class="form-input" name="password" id="password" autocomplete="current-password" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="rememberme" class="rounded border-gray-300 text-orange-500">
                                <span>Recuérdame</span>
                            </label>
                            <a href="{{ wp_lostpassword_url() }}" class="text-sm font-bold text-orange-400 hover:text-orange-300">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>

                    <button type="submit" name="login" value="Log in" class="submit-btn">
                        INICIAR SESIÓN
                    </button>

                    {{-- Campos ocultos necesarios para WooCommerce --}}
                    @php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce') @endphp
                    @php do_action('woocommerce_login_form_end') @endphp

                    @if (get_option('woocommerce_enable_myaccount_registration') === 'yes')
                        <button type="button" onclick="showRegisterForm()" class="switch-button mt-4 w-full rounded-full p-3 text-lg font-bold">
                            ¿No tienes cuenta? <span class="font-extrabold">Regístrate</span>
                        </button>
                    @endif
                </form>
            </div>

            {{-- Formulario de Registro --}}
            @if (get_option('woocommerce_enable_myaccount_registration') === 'yes')
                <div id="registerForm" class="form-container hidden-form rounded-[50px] border-4 border-orange-500 bg-black/60 p-8 text-gray-200 shadow-lg">
                    <h2 class="mb-6 text-center text-4xl font-bold">CREA UNA CUENTA</h2>

                    <form method="post" class="woocommerce-form woocommerce-form-register register">
                        @php do_action('woocommerce_register_form_start') @endphp

                        <div class="mb-4 space-y-4">
                            @if (get_option('woocommerce_registration_generate_username') === 'no')
                                <div>
                                    <label for="reg_username" class="mb-2 block text-base font-bold">NOMBRE DE USUARIO</label>
                                    <input type="text" class="form-input" name="username" id="reg_username" autocomplete="username" value="{{ old('username') }}" required>
                                </div>
                            @endif

                            <div>
                                <label for="reg_email" class="mb-2 block text-base font-bold">CORREO ELECTRÓNICO</label>
                                <input type="email" class="form-input" name="email" id="reg_email" autocomplete="email" value="{{ old('email') }}" required>
                            </div>

                            @if (get_option('woocommerce_registration_generate_password') === 'no')
                                <div>
                                    <label for="reg_password" class="mb-2 block text-base font-bold">CONTRASEÑA</label>
                                    <input type="password" class="form-input" name="password" id="reg_password" autocomplete="new-password" required>
                                    <p class="mt-1 text-sm text-gray-400">Mínimo 8 caracteres con letras y números.</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-400">Se enviará un enlace para establecer una nueva contraseña a su correo.</p>
                            @endif
                        </div>

                        <button type="submit" name="register" value="Register" class="submit-btn">
                            REGISTRARSE
                        </button>

                        {{-- Campos ocultos necesarios para WooCommerce --}}
                        @php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce') @endphp
                        @php do_action('woocommerce_register_form') @endphp
                        @php do_action('woocommerce_register_form_end') @endphp

                        <button type="button" onclick="showLoginForm()" class="switch-button mt-4 w-full rounded-full p-3 text-lg font-bold">
                            ¿Ya tienes cuenta? <span class="font-extrabold">Inicia sesión</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>

    <script>
        function showRegisterForm() {
            document.getElementById('loginForm').classList.remove('visible-form');
            document.getElementById('loginForm').classList.add('hidden-form');
            document.getElementById('registerForm').classList.remove('hidden-form');
            document.getElementById('registerForm').classList.add('visible-form');

            // Enfocar el primer campo del formulario de registro
            setTimeout(() => {
                const firstInput = document.querySelector('#registerForm input');
                if (firstInput) firstInput.focus();
            }, 50);
        }

        function showLoginForm() {
            document.getElementById('registerForm').classList.remove('visible-form');
            document.getElementById('registerForm').classList.add('hidden-form');
            document.getElementById('loginForm').classList.remove('hidden-form');
            document.getElementById('loginForm').classList.add('visible-form');

            // Enfocar el primer campo del formulario de login
            setTimeout(() => {
                const firstInput = document.querySelector('#loginForm input');
                if (firstInput) firstInput.focus();
            }, 50);
        }
    </script>
@endsection
