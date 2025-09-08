@php
use Stripe\StripeClient;

$user_id = get_current_user_id();
$stripe_customer_id = get_user_meta($user_id, 'gc__stripe_customer_id', true);
$stripe_secret_key = get_option('woocommerce_stripe_settings')['secret_key'] ?? '';

$stripe = new StripeClient($stripe_secret_key);

// Crear cliente si no existe
if (!$stripe_customer_id) {
    $current_user = wp_get_current_user();
    $customer = $stripe->customers->create([
        'name' => $current_user->first_name . ' ' . $current_user->last_name,
        'email' => $current_user->user_email,
    ]);
    update_user_meta($user_id, 'gc__stripe_customer_id', $customer->id);
    $stripe_customer_id = $customer->id;
}

// Crear SetupIntent
$intent = $stripe->setupIntents->create([
    'customer' => $stripe_customer_id,
]);
$setup_intent_client_secret = $intent->client_secret;
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<div class="max-w-2/4">
    <div class="flex gap-1">
        <svg class="h-6 w-6 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
        </svg>
        <span class="mb-4 text-gray-400">Tarjeta</span>
    </div>

    <form id="add-payment-method-form" method="post">
        @php wp_nonce_field('woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce'); @endphp

        <div id="card-element" class="text-black h-12 rounded-lg border bg-white p-2"></div>
        <div id="card-errors" class="mt-2 text-red-500"></div>

        <button type="submit" class="mt-4 rounded-lg bg-orange-500 px-4 py-2 text-white">
            Agregar método de pago
        </button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ get_option("woocommerce_stripe_settings")["publishable_key"] ?? "" }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('add-payment-method-form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const { setupIntent, error } = await stripe.confirmCardSetup(
            '{{ $setup_intent_client_secret }}',
            { payment_method: { card: card } }
        );

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            fetch('{{ admin_url("admin-ajax.php") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                body: new URLSearchParams({
                    action: 'save_stripe_payment_method',
                    payment_method_id: setupIntent.payment_method
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Método de pago agregado y configurado como predeterminado');
                    location.reload();
                } else {
                    document.getElementById('card-errors').textContent = data.message;
                }
            });
        }
    });
</script>
