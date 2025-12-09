<div class="bg-white p-4 rounded-lg shadow-sm"> <!-- Fondo blanco con padding y bordes redondeados -->
    <dl class="variation space-y-2">
        @foreach ($item_data as $data)
            <div class="flex">
                <dt class="variation-{{ sanitize_title($data['key']) }} font-medium text-gray-700">
                    {{ $data['key'] }}:
                </dt>
                <dd class="variation-{{ sanitize_title($data['key']) }} ml-2 text-gray-600">
                    {!! wpautop($data['display']) !!}
                </dd>
            </div>
        @endforeach
    </dl>
</div>