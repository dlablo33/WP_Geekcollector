<li class="wc_payment_method payment_method_{{ esc_attr($gateway->id) }}">
    <div class="flex">
        <input id="payment_method_{{ esc_attr($gateway->id) }}" type="radio" class="input-radio" name="payment_method" value="{{ esc_attr($gateway->id) }}"
            @checked($gateway->chosen) data-order_button_text="{{ esc_attr($gateway->order_button_text) }}" />
        <label for="payment_method_{{ esc_attr($gateway->id) }}" class="flex w-full">
            {!! $gateway->get_icon() !!}  <span class="ml-2">{!! $gateway->get_title() !!}</span>
        </label>
    </div>

    @if ($gateway->has_fields() || $gateway->get_description())
        <div class="payment_box payment_method_{{ esc_attr($gateway->id) }}" @unless ($gateway->chosen) style="display:none;" @endunless>
            {!! $gateway->payment_fields() !!}
        </div>
    @endif
</li>
