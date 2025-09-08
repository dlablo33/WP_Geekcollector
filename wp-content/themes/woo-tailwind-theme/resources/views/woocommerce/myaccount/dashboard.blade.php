<?php
/**
 * Template Name: Perfil de Usuario GeekCollector
 */

$user = wp_get_current_user();
$user_id = $user->ID;

// Obtener información de suscripción
$subscriptions = wcs_get_users_subscriptions($user_id);
$active_subscription = null;

foreach ($subscriptions as $subscription) {
    if ($subscription->has_status('active')) {
        $active_subscription = $subscription;
        break;
    }
}

// Niveles de suscripción
$subscription_levels = [
    'byte_seeker' => [
        'title' => 'BYTE SEEKER',
        'subtitle' => 'Sin costo',
        'color' => 'from-orange-500 to-orange-700',
        'credit' => '$0 MXN',
        'bg_color' => 'orange',
    ],
    'pixel_knight' => [
        'title' => 'PIXEL KNIGHT',
        'subtitle' => '$200',
        'color' => 'from-blue-500 to-blue-700',
        'credit' => '$0 MXN',
        'bg_color' => 'blue',
    ],
    'realm_sorcerer' => [
        'title' => 'REALM SORCERER',
        'subtitle' => '$500',
        'color' => 'from-purple-500 to-purple-700',
        'credit' => '$0 MXN',
        'bg_color' => 'purple',
    ],
    'legendary_guardian' => [
        'title' => 'LEGENDARY GUARDIAN',
        'subtitle' => '$1,500',
        'color' => 'from-yellow-500 to-yellow-700',
        'credit' => '$0 MXN',
        'bg_color' => 'yellow',
    ],
    'cosmic_overlord' => [
        'title' => 'COSMIC OVERLORD',
        'subtitle' => '$3,000',
        'color' => 'from-pink-500 to-pink-700',
        'credit' => '$0 MXN',
        'bg_color' => 'pink',
    ],
];

// Determinar el plan actual
$current_plan = null;
$has_active_subscription = false;

if ($active_subscription) {
    foreach ($subscription_levels as $key => $plan_data) {
        // Verificar si el nombre del plan coincide con algún producto en la suscripción
        foreach ($active_subscription->get_items() as $item) {
            $product = $item->get_product();
            if ($product) {
                $product_name = strtolower($product->get_name());
                $plan_title = strtolower($plan_data['title']);

                // Buscar coincidencias más flexibles
                if (strpos($product_name, $plan_title) !== false || similar_text($product_name, $plan_title) > 5) {
                    // Umbral de similitud
                    $current_plan = $key;
                    $has_active_subscription = true;
                    break 2;
                }
            }
        }
    }

    // Si no se encontró coincidencia pero hay suscripción activa, usar la primera
    if (!$current_plan && $active_subscription) {
        $current_plan = 'byte_seeker'; // O asignar según algún criterio
        $has_active_subscription = true;
    }
}

// Obtener metadata del usuario
$collector_tag = get_user_meta($user_id, 'collector_tag', true) ?: '#G33K' . $user_id;
$user_bio = get_user_meta($user_id, 'description', true) ?: 'Aquí puedes escribir tu biografía, intereses o logros como jugador/coleccionista.';

// Formatear fecha de registro
$join_date = date('d/m/Y', strtotime($user->user_registered));

// DEBUG: Mostrar información para troubleshooting
echo '<!-- DEBUG: ';
echo 'Active Subscription: ' . ($active_subscription ? 'Yes' : 'No');
echo ' | Has Active: ' . ($has_active_subscription ? 'Yes' : 'No');
echo ' | Current Plan: ' . ($current_plan ? $current_plan : 'None');
if ($active_subscription) {
    echo ' | Subscription Items: ';
    foreach ($active_subscription->get_items() as $item) {
        $product = $item->get_product();
        if ($product) {
            echo $product->get_name() . ', ';
        }
    }
}
echo ' -->';
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil de Usuario - <?php echo $user->display_name; ?></title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;500;600;700&family=Roboto+Mono:wght@300;400;500&display=swap');

            body {
                font-family: 'Oxanium', cursive;
                background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 100%);
                color: #e2e8f0;
                min-height: 100vh;
                padding: 0px;
            }

            .geek-font {
                font-family: 'Roboto Mono', monospace;
            }

            .card {
                background: rgba(15, 15, 26, 0.8);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            }

            .valorant-accent {
                border-left: 4px solid #ff4655;
            }

            .tcg-accent {
                border-left: 4px solid #0ff5d3;
            }

            .rank-badge {
                background: linear-gradient(135deg, #3a3a6a 0%, #242450 100%);
                border: 2px solid #ff4655;
            }

            .tcg-item {
                transition: all 0.3s ease;
            }

            .tcg-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            .leaderboard-item {
                transition: all 0.3s ease;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .leaderboard-item:hover {
                background: rgba(255, 255, 255, 0.05);
            }

            .collection-item {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
                transition: all 0.3s ease;
            }

            .collection-item:hover {
                transform: scale(1.05);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            }

            .profile-img {
                border: 3px solid #ff4655;
                box-shadow: 0 0 20px rgba(255, 70, 85, 0.5);
            }

            @media (max-width: 768px) {
                .container-division {
                    flex-direction: column;
                }
            }
        </style>
    </head>

    <body class="flex min-h-screen items-center justify-center">
        <div class="card w-full max-w-6xl p-4 md:p-8">
            <!-- Header con información de suscripción -->
            <div class="mb-8 flex flex-col items-center justify-between border-b border-gray-700 pb-6 md:flex-row">
                <div class="mb-4 md:mb-0">
                    <?php if ($has_active_subscription && $current_plan) : 
                    $plan = $subscription_levels[$current_plan]; ?>
                    <h1 class="from-<?php echo $plan['bg_color']; ?>-500 to-<?php echo $plan['bg_color']; ?>-300 bg-gradient-to-r bg-clip-text text-3xl font-bold text-white"><?php echo $plan['title']; ?>
                    </h1>
                    <p class="text-sm opacity-70">Membresía Activa</p>
                    <?php else : ?>
                    <h1 class="text-center text-3xl font-bold text-gray-400">Sin membresía activa</h1>
                    <a href="https://geekcollector.mx/membresias/"
                        class="mt-2 inline-block transform rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-2 font-semibold text-white transition-all duration-300 hover:scale-105 hover:from-blue-600 hover:to-purple-700">
                        <i class="fas fa-crown mr-2"></i>Únete ahora
                    </a>
                    <?php endif; ?>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-sm opacity-70">CRÉDITO</p>
                    <p class="text-2xl font-bold text-green-400">
                        <?php
                        if (is_user_logged_in() && function_exists('woo_wallet')) {
                            $wallet = woo_wallet()->wallet ?? null;
                            if ($wallet && method_exists($wallet, 'get_wallet_balance')) {
                                // Devuelve el saldo ya formateado (mismo que ves en "Mi billetera")
                                echo $wallet->get_wallet_balance(get_current_user_id());
                            } else {
                                echo wc_price(0);
                            }
                        } else {
                            echo wc_price(0);
                        }
                        ?>
                    </p>
                </div>

            </div>

            <!-- Perfil de usuario -->
            <div class="mb-10 flex flex-col items-center gap-6 md:flex-row">
                <!-- Contenedor del avatar y el nombre con el botón al lado -->
                <div class="flex items-center gap-4">
                    <!-- Mostrar el avatar -->
                    <div>
                        <?php
                        // Obtén el ID del usuario actual
                        $user_id = get_current_user_id();
                        
                        // Obtener la URL del avatar de Simple Local Avatars
                        $avatar_url = get_user_meta($user_id, 'simple_local_avatar', true);
                        
                        // Verifica si la URL del avatar local existe y es válida
                        if (is_string($avatar_url) && !empty($avatar_url)) {
                            // Si hay avatar cargado localmente, mostrarlo
                            echo '<img src="' . esc_url($avatar_url) . '" alt="Avatar" class="w-32 h-32 rounded-full profile-img border-4 border-gradient-to-r from-blue-500 to-purple-600 shadow-lg">';
                        } else {
                            // Si no hay avatar cargado localmente, mostrar un avatar por defecto
                            // Aquí puedes poner una imagen predeterminada, si lo deseas
                            echo '<img src="' . get_template_directory_uri() . '/images/default-avatar.png" alt="Avatar" class="w-32 h-32 rounded-full profile-img border-4 border-gradient-to-r from-blue-500 to-purple-600 shadow-lg">';
                        }
                        ?>
                    </div>

                    <!-- Nombre de usuario y botón para cambiar imagen -->
                    <div class="text-center md:text-left">
                        <h2 class="text-2xl font-semibold"><?php echo $user->display_name; ?>
                            <!-- Botón de cambio de avatar al lado del nombre -->
                            <button id="change-avatar-btn-inline"
                                class="ml-4 transform rounded-full bg-gradient-to-r from-blue-500 to-purple-600 p-2 text-white transition-all duration-300 hover:scale-105 hover:bg-gradient-to-r hover:from-blue-600 hover:to-purple-700">
                                <i class="fas fa-camera"></i>
                            </button>
                        </h2>
                        <p class="text-sm opacity-70">Collector Tag: <?php echo $collector_tag; ?></p>
                        <p class="text-xs text-gray-400">Miembro desde <?php echo $join_date; ?></p>
                    </div>
                </div>
            </div>

            <!-- Formulario oculto para cargar una nueva foto de perfil -->
            <div id="avatar-upload-form" class="mt-6 hidden text-center md:text-left">
                <form method="post" enctype="multipart/form-data" class="rounded-lg bg-gray-800 p-6 shadow-md">
                    <label for="avatar" class="mb-2 block text-sm font-medium text-gray-300">Sube una nueva foto de perfil:</label>
                    <input type="file" name="avatar" accept="image/*"
                        class="mb-4 block w-full rounded-lg bg-gray-700 p-3 text-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button type="submit"
                        class="inline-block transform rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-2 font-semibold text-white transition-all duration-300 hover:scale-105 hover:from-blue-600 hover:to-purple-700">
                        Subir Foto
                    </button>
                </form>
            </div>

            <?php
            // Procesar la subida de la imagen
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
                // Obtener el archivo subido
                $avatar = $_FILES['avatar'];
            
                // Verificar si el archivo es una imagen válida
                if ($avatar['error'] == UPLOAD_ERR_OK && in_array(strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $upload_dir = wp_upload_dir();
                    $upload_file = $upload_dir['path'] . '/' . sanitize_file_name($avatar['name']);
            
                    // Mover el archivo al directorio de carga
                    if (move_uploaded_file($avatar['tmp_name'], $upload_file)) {
                        // Guardar la URL del archivo en los metadatos del usuario
                        update_user_meta($user_id, 'simple_local_avatar', $upload_dir['url'] . '/' . basename($upload_file));
                        // Redirigir para evitar un resubido de archivo en el recargado de página
                        wp_redirect($_SERVER['REQUEST_URI']);
                        exit();
                    }
                }
            }
            ?>

            <!-- Script para mostrar el formulario cuando se haga clic en el botón -->
            <script>
                document.getElementById('change-avatar-btn-inline').addEventListener('click', function() {
                    document.getElementById('avatar-upload-form').classList.toggle('hidden');
                });
            </script>

            <!-- División principal en dos columnas -->
            <div class="container-division flex flex-col gap-8 lg:flex-row">
                <!-- Columna izquierda: Valorant Stats y Leaderboard -->
                <div class="w-full space-y-8 lg:w-1/2">
                    <!-- Valorant Stats -->
                    <div class="card valorant-accent p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-xl font-bold">
                            <i class="fas fa-crosshairs text-red-500"></i> Geek Stats
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-center md:grid-cols-3">
                            <div class="rank-badge rounded-xl p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="mt-1 text-xs">Ranking Actual</p>
                            </div>
                            <div class="rounded-xl bg-gray-800 p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-xs">Puntos Totales</p>
                            </div>
                            <div class="rounded-xl bg-gray-800 p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-xs">Torneos Jugados</p>
                            </div>
                            <div class="rounded-xl bg-gray-800 p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-xs">Victorias Totales</p>
                            </div>
                            <div class="rounded-xl bg-gray-800 p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-xs">Top 3 Acumulados</p>
                            </div>
                            <div class="rounded-xl bg-gray-800 p-4">
                                <p class="text-3xl font-bold">0</p>
                                <p class="text-xs">K/D Ratio</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="mb-2 font-semibold">Agentes más jugados</h4>
                            <div class="flex gap-4">
                                <div class="text-center">
                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-700 md:h-16 md:w-16">
                                        <i class="fas fa-question text-gray-400"></i>
                                    </div>
                                    <p class="mt-1 text-xs">Sin datos</p>
                                </div>
                                <div class="text-center">
                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-700 md:h-16 md:w-16">
                                        <i class="fas fa-question text-gray-400"></i>
                                    </div>
                                    <p class="mt-1 text-xs">Sin datos</p>
                                </div>
                                <div class="text-center">
                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-gray-700 md:h-16 md:w-16">
                                        <i class="fas fa-question text-gray-400"></i>
                                    </div>
                                    <p class="mt-1 text-xs">Sin datos</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leaderboard Geek -->
                    <div class="card p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-xl font-bold">
                            <i class="fas fa-trophy text-yellow-500"></i> Leaderboard Geek
                        </h3>
                        <div class="space-y-3">
                            <div class="leaderboard-item flex items-center justify-between rounded-lg bg-gray-800 p-3">
                                <div class="flex items-center gap-3">
                                    <?php echo get_avatar($user_id, 40, '', '', ['class' => 'w-10 h-10 rounded-full']); ?>
                                    <div>
                                        <p class="font-semibold"><?php echo $user->display_name; ?></p>
                                        <p class="text-xs text-gray-400">Nivel 0</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-green-400">#0</p>
                                    <p class="text-xs text-gray-400">0 pts</p>
                                </div>
                            </div>

                            <div class="leaderboard-item flex items-center justify-between rounded-lg bg-gray-800 p-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-700">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Jugador 2</p>
                                        <p class="text-xs text-gray-400">Nivel 0</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-yellow-400">#0</p>
                                    <p class="text-xs text-gray-400">0 pts</p>
                                </div>
                            </div>

                            <div class="leaderboard-item flex items-center justify-between rounded-lg bg-gray-800 p-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-700">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold">Jugador 3</p>
                                        <p class="text-xs text-gray-400">Nivel 0</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-orange-500">#0</p>
                                    <p class="text-xs text-gray-400">0 pts</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <button class="rounded-lg bg-purple-700 px-4 py-2 text-sm transition hover:bg-purple-600">
                                Ver ranking completo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha: TCG's y Colecciones -->
                <div class="w-full space-y-8 lg:w-1/2">
                    @php
                        $tcgs = [
                            [
                                'img' => 'One Piece.png',
                                'name' => 'One Piece',
                                'style' => 'background-image: linear-gradient(to bottom right, rgba(22, 78, 99, 0.5), rgba(56, 189, 248, 0.3));',
                            ],
                            [
                                'img' => 'Magic The Gathering.png',
                                'name' => 'Magic',
                                'style' => 'background-image: linear-gradient(to bottom right, rgba(127, 29, 29, 0.5), rgba(185, 28, 28, 0.3));',
                            ],
                            [
                                'img' => 'Pokémon.png',
                                'name' => 'POKÉMON',
                                'style' => 'background-image: linear-gradient(to bottom right, rgba(113, 63, 18, 0.5), rgba(202, 138, 4, 0.3));',
                            ],
                            [
                                'img' => 'Yu-Gi-Oh!.png',
                                'name' => 'Yu-Gi-Oh!',
                                'style' => 'background-image: linear-gradient(to bottom right, rgba(30, 64, 175, 0.5), rgba(37, 99, 235, 0.3));',
                            ],
                            [
                                'img' => 'Lorcana.png',
                                'name' => 'Lorcana',
                                'style' => 'background-image: linear-gradient(to bottom right, rgba(88, 28, 135, 0.5), rgba(147, 51, 234, 0.2));',
                            ],
                        ];

                        $colleciones = [
                            ['img' => 'DC.png', 'name' => 'DC', 'items' => '0'],
                            ['img' => 'Disney.png', 'name' => 'Disney', 'items' => '0'],
                            ['img' => 'DragonBall.png', 'name' => 'Dragon Ball', 'items' => '0'],
                            ['img' => 'Funko.png', 'name' => 'Funko', 'items' => '0'],
                            ['img' => 'Marvel.png', 'name' => 'Marvel', 'items' => '0'],
                            ['img' => 'Pixar.png', 'name' => 'Pixar', 'items' => '0'],
                        ];
                    @endphp

                    <!-- Mis TCG's -->
                    <div class="card tcg-accent p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-xl font-bold">
                            <i class="fas fa-dragon text-cyan-400"></i> Mis TCG's
                        </h3>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach ($tcgs as $tcg)
                                <div style="{{ $tcg['style'] }}" class="tcg-item flex flex-col items-center justify-center rounded-xl p-4 text-center">
                                    <div>
                                        <img class="h-10 w-10 object-contain sm:h-14 sm:w-14" src="{{ asset('resources/images/tcg/' . $tcg['img']) }}"
                                            alt="{{ $tcg['name'] }}">
                                    </div>
                                    <div class="text-sm">
                                        {{ $tcg['name'] }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        0 cartas
                                    </div>
                                </div>
                            @endforeach
                            <div
                                class="tcg-item flex cursor-pointer items-center justify-center rounded-xl bg-gradient-to-br from-gray-800 to-gray-700 p-4 text-center hover:bg-gray-700">
                                <i class="fas fa-plus text-3xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Colecciones -->
                    <div class="card p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-xl font-bold">
                            <i class="fas fa-layer-group text-green-400"></i> Colecciones
                        </h3>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            @foreach ($colleciones as $collecion)
                                <div class="collection-item flex flex-col items-center justify-center rounded-xl p-4 text-center">
                                    <img class="h-10 w-10 object-contain sm:h-14 sm:w-14" src="{{ asset('resources/images/colecciones/' . $collecion['img']) }}"
                                        alt="{{ $collecion['name'] }}">
                                    <div class="text-sm">{{ $collecion['name'] }}</div>
                                    <div class="text-xs text-gray-400">{{ $collecion['items'] }} items</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sobre mí -->
                </div>
            </div>
        </div>

        <script>
            // Efecto de hover mejorado para los items
            document.addEventListener('DOMContentLoaded', function() {
                const items = document.querySelectorAll('.tcg-item, .collection-item');
                items.forEach(item => {
                    item.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-5px)';
                    });
                    item.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                });
            });
        </script>
    </body>

</html>
