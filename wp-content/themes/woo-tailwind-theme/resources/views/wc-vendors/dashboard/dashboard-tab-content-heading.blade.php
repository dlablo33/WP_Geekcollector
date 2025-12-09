@php

    $progress_bar_items = array_map(function ($step) {
        $icon = $step['icon'];
        $class = 'incomplete';
        if ($step['is_complete']) {
            $icon = 'wcv-icon-setup-complete';
            $class = 'completed';
        }
        return [
            'icon' => $icon,
            'is_complete' => $step['is_complete'],
            'class' => $class,
        ];
    }, $store_setup_steps);

    $current_step = array_search(false, array_column($store_setup_steps, 'is_complete'), true);
    $current_step = $store_setup_steps[$current_step]['id'];

    $completed_steps = array_filter($store_setup_steps, function ($step) {
        return $step['is_complete'];
    });

    $completed_steps = count($completed_steps);

@endphp

<div class="wcv-cols-group wcv-horizontal-gutters column-group ink-stacker gutters">
    <div class="all-100 small-100 no-margin">
        <h2 class="wcv-heading small-align-center wcv-dashboard-welcome-message"><span class="text-white">{{ esc_html($welcome_message) }}</span></h2>
        @if (count($store_setup_steps) !== $completed_steps && !$is_dismissed)

            <div class="wcv-store-setup-steps-wrapper wcv-section-bg-light wcv-bottom-space">
                <div class="wcv-store-setup-steps-header wcv-flex">
                    <h3 class="wcv-heading">{{ esc_html_e('Complete your setup', 'wc-vendors') }}</h3>
                    <a href="#" class="wcv-store-setup-dismiss" title="{{ esc_attr__('Dismiss') }}">
                        {!! wcv_get_icon('wcv-icon wcv-icon-md', 'wcv-icon-times') !!}
                    </a>
                </div>
                <div class="wcv-store-setup-content-wrapper">
                    <div class="wcv-store-setup-progress-bar">
                        <div class="wcv-store-setup-progress-bar-fill"></div>
                    </div>
                    <div class="wcv-store-setup-steps">
                        @foreach ($store_setup_steps as $step)
                            @php
                                $step_icon = $step['is_complete'] ? 'wcv-icon-setup-complete' : $step['icon'];
                            @endphp
                            <div
                                class="wcv-store-setup-step {{ esc_attr($step['id'] === $current_step ? 'current' : '') }} {{ esc_attr(true === $step['is_complete'] ? 'completed' : '') }}">
                                <div class="wcv-store-setup-step-icon flex items-center justify-center">
                                    <svg class="wcv-icon wcv-step-icon">
                                        <use xlink:href="{{ esc_url(WCV_ASSETS_URL) }}svg/wcv-icons.svg?t={{ esc_attr($time) }}#{{ esc_attr($step_icon) }}"></use>
                                    </svg>
                                </div>
                                <div class="wcv-store-setup-step-content">
                                    <a href="{{ esc_url($step['link']) }}" class="wcv-store-setup-step-link">
                                        <h3 class="wcv-store-setup-step-title">{{ esc_html($step['title']) }}</h3>
                                        <p class="wcv-store-setup-step-description">{{ esc_html($step['description']) }}</p>
                                        @if (!$step['is_complete'])
                                            <p class="wcv-store-setup-step-proceed {{ esc_attr($step['id'] === $current_step ? 'current' : '') }}">
                                                {!! wcv_get_icon('wcv-icon wcv-icon-20 wcv-icon-middle', 'wcv-arrow-right-outline') !!}
                                            </p>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
