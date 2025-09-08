<div class="mb-5">{!! wc_print_notices() !!}</div>

<h2 class="mb-2 border-b border-gray-600 py-1 text-xl font-semibold">Membresía</h2>

<div class="mb-5 grid grid-cols-2">
    @php
        $end_date = $subscription->get_date('end');
        $start_date = $subscription->get_date('start');
        $next_payment = $subscription->get_date('next_payment');
    @endphp
    <div class="col-span-1">
        <div class="grid grid-cols-2 mb-3">
            <div class="col-span-1 text-xl font-bold">
                Status:
            </div>
            <div class="col-span-1 col-start-2 text-xl font-semibold capitalize">
                {{ $subscription->get_status() }}
            </div>
        </div>
        <div class="grid grid-cols-2">
            <div class="col-span-1 text-xl font-bold">
                Fecha de Inicio:
            </div>
            <div class="col-span-1 col-start-2 text-xl font-semibold">
                {{ date('Y-m-d', strtotime($start_date)) }}
            </div>
        </div>
        @if ($end_date)
            <div class="grid grid-cols-2">
                <div class="col-span-1 text-xl font-bold">
                    Fecha de Terminacion:
                </div>
                <div class="col-span-1 col-start-2 text-xl font-semibold">
                    {{ date('Y-m-d', strtotime($end_date)) }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-span-1 col-start-2">
        @if ($next_payment)
            <div class="grid grid-cols-2 mb-3">
                <div class="col-span-1 text-xl font-bold">
                    Proximo Pago:
                </div>
                <div class="col-span-1 col-start-2 text-xl font-semibold">
                    {{ date('Y-m-d', strtotime($next_payment)) }}
                </div>
            </div>
            <div class="grid grid-cols-2">
                <div class="col-span-1 text-xl font-bold">
                    Monto:
                </div>
                <div class="col-span-1 col-start-2 text-xl font-semibold">
                    {{ $subscription->get_total() }} {{ $subscription->get_currency() }}
                </div>
            </div>
        @endif

    </div>
</div>

<div class="mb-4">
    {!! do_action('woocommerce_subscription_details_after_subscription_table', $subscription) !!}
</div>
