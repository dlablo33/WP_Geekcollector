<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if (!defined('ABSPATH')) {
    exit();
}

?>
<div class="animate-fade-in mt-16">
    <div class="flex items-center justify-center space-x-2">
        {!! paginate_links([
            'base' => $base,
            'format' => $format,
            'add_args' => false,
            'current' => max(1, $current),
            'total' => $total,
            'prev_text' => __(
                '<span class="flex items-center px-4 py-2 rounded-lg  border-orange-500 text-orange-500 font-bold hover:text-white transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/20"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> Anterior</span>',
            ),
            'next_text' => __(
                '<span class="flex items-center px-4 py-2 rounded-lg  border-orange-500 text-orange-500 font-bold hover:text-white transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/20">Siguiente <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>',
            ),
            'type' => 'list',
            'end_size' => 1,
            'mid_size' => 2,
        ]) !!}
    </div>
</div>

<style>
    .page-numbers {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .page-numbers li {
        display: flex;
        margin: 0;
    }

    .page-numbers li a,
    .page-numbers li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }

    .page-numbers li a {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        color: #d1d5db;
        border-color: #4b5563;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .page-numbers li a:hover {
        background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
        color: #ffffff;
        border-color: #f97316;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -3px rgba(249, 115, 22, 0.2);
    }

    .page-numbers li span.current {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: #ffffff;
        border-color: #ea580c;
        box-shadow: 0 8px 15px -3px rgba(249, 115, 22, 0.3);
        transform: scale(1.05);
    }

    .page-numbers li span.dots {
        background: transparent;
        color: #9ca3af;
        border: none;
        box-shadow: none;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .page-numbers {
            gap: 0.25rem;
        }

        .page-numbers li a,
        .page-numbers li span {
            min-width: 2.25rem;
            height: 2.25rem;
            font-size: 0.75rem;
            border-radius: 0.5rem;
        }

        .page-numbers li .prev_text,
        .page-numbers li .next_text {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>
