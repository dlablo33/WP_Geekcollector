
<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-4"> Mis Billeteras</h2>

    <div class="mb-6">
        <span class="text-gray-500">Saldo:</span>
        <p class="text-3xl font-bold text-green-600">
            {{ wc_price( woo_wallet()->wallet->get_wallet_balance( get_current_user_id() ) ) }}
        </p>
    </div>
    <div class="text-white">AAAA</div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ wc_get_endpoint_url('woo-wallet-recharge') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Recarga</a>
        <a href="{{ wc_get_endpoint_url('woo-wallet-transfer') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Transferir</a>
        <a href="{{ wc_get_endpoint_url('woo-wallet-transactions') }}" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">Movimientos</a>
    </div>
</div>
