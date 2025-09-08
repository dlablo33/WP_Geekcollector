@php
use Stripe\StripeClient;

$user_id = get_current_user_id();
$stripe_customer_id = get_user_meta($user_id, 'gc__stripe_customer_id', true);
$stripe = new StripeClient(get_option('woocommerce_stripe_settings')['secret_key']);

// Obtener métodos guardados
$saved_methods = [];
$default_payment_method_id = null;
if ($stripe_customer_id) {
    $customer = $stripe->customers->retrieve($stripe_customer_id, []);
    $default_payment_method_id = $customer->invoice_settings->default_payment_method ?? null;

    $payment_methods = $stripe->paymentMethods->all([
        'customer' => $stripe_customer_id,
        'type' => 'card',
    ]);
    $saved_methods = $payment_methods->data;
}
@endphp

<div class="payment-methods-container">
    @if (count($saved_methods))
        <div class="overflow-x-auto rounded-lg shadow-lg mb-10 animate-fade-in">
            <table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarjeta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Últimos 4 dígitos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Predeterminada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($saved_methods as $method)
                        <tr class="payment-method-row transition-all duration-300 hover:bg-blue-50 {{ $method->id === $default_payment_method_id ? 'default-payment-method bg-blue-50 border-l-4 border-blue-500' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="payment-method-icon mr-3">
                                        @php
                                            $brand = strtolower($method->card->brand);
                                            $icon_class = 'text-gray-400 text-xl';
                                            
                                            if (strpos($brand, 'visa') !== false) {
                                                $icon_class = 'text-blue-600 text-xl';
                                                echo '<i class="fa-brands fa-cc-visa"></i>';
                                            } elseif (strpos($brand, 'mastercard') !== false) {
                                                $icon_class = 'text-red-600 text-xl';
                                                echo '<i class="fa-brands fa-cc-mastercard"></i>';
                                            } elseif (strpos($brand, 'amex') !== false || strpos($brand, 'american') !== false) {
                                                $icon_class = 'text-blue-400 text-xl';
                                                echo '<i class="fa-brands fa-cc-amex"></i>';
                                            } elseif (strpos($brand, 'discover') !== false) {
                                                $icon_class = 'text-orange-600 text-xl';
                                                echo '<i class="fa-brands fa-cc-discover"></i>';
                                            } else {
                                                echo '<i class="fa-credit-card fa-solid ' . $icon_class . '"></i>';
                                            }
                                        @endphp
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ strtoupper($method->card->brand) }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">•••• {{ $method->card->last4 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ sprintf('%02d/%d', $method->card->exp_month, $method->card->exp_year) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($method->id === $default_payment_method_id)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Predeterminada
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        No predeterminada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if ($method->id !== $default_payment_method_id)
                                    <form method="post" action="{{ esc_url(wc_get_endpoint_url('set-default-payment-method')) }}" class="inline-block">
                                        @php wp_nonce_field('set-default-payment-method', 'set-default-payment-method-nonce'); @endphp
                                        <input type="hidden" name="payment_method_id" value="{{ $method->id }}">
                                        <button type="submit" class="set-default-btn text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200">
                                            Usar como predeterminada
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="mb-10 p-6 bg-white rounded-lg shadow-md text-center animate-pulse">
            <div class="text-gray-500 text-lg mb-4">
                <i class="fa-credit-card fa-regular fa-3x mb-3"></i>
                <p>No se han encontrado métodos de pago guardados.</p>
            </div>
        </div>
    @endif

    @if (WC()->payment_gateways->get_available_payment_gateways())
        <div class="text-center mt-8">
            <a class="add-payment-btn inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
               href="{{ esc_url(wc_get_endpoint_url('add-payment-method')) }}">
                <i class="fa-plus fa-solid mr-2"></i> Agregar método de pago
            </a>
        </div>
    @endif
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    .payment-method-row {
        transition: all 0.3s ease;
    }
    
    .set-default-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    @media (max-width: 768px) {
        .account-payment-methods-table {
            display: block;
            width: 100%;
        }
        
        .account-payment-methods-table thead {
            display: none;
        }
        
        .account-payment-methods-table tbody, 
        .account-payment-methods-table tr, 
        .account-payment-methods-table td {
            display: block;
            width: 100%;
        }
        
        .account-payment-methods-table tr {
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .account-payment-methods-table td {
            padding: 0.5rem;
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .account-payment-methods-table td::before {
            content: attr(data-label);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: #718096;
            text-align: left;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agregar etiquetas de datos para responsividad
    const table = document.querySelector('.account-payment-methods-table');
    if (table) {
        const headers = table.querySelectorAll('thead th');
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                if (index < headers.length) {
                    cell.setAttribute('data-label', headers[index].textContent.trim());
                }
            });
        });
    }
    
    // Animación para botones de establecer predeterminado
    const defaultButtons = document.querySelectorAll('.set-default-btn');
    defaultButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            this.innerHTML = '<i class="fa-spinner fa-solid animate-spin mr-1"></i> Procesando...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
        });
    });
});
</script>