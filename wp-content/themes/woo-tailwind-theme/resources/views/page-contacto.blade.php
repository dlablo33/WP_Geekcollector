{{--
Template Name: nosotros
--}}
@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
            color: white;
        }
    </style>
    <section class="flex flex-col items-start justify-center bg-black lg:flex-row">
        <div class="py-30 flex h-auto w-full md:mx-10 md:px-20 lg:w-[45%]">
            <ul class="flex w-full flex-col items-start justify-start">
                <li class="w-full font-bold">
                    <div class="flex w-full flex-row" justify-start items-center>
                        <div class="mx-3 my-auto">
                            <img class="h-10 w-10" src="<?php echo get_template_directory_uri() . '/resources/images/nosotros/correo-electronico.png'; ?>" alt="Ícono de Email">
                        </div>
                        <div class="folex flex-col items-start justify-center py-3">
                            <h2>EMAIL:</h2>
                            <p class="text-lg md:text-xl">info@geekcollector.com</p>
                        </div>
                    </div>
                    <div class="bg-linear-65 h-[1px] w-full from-yellow-500 to-red-500"></div>
                </li>
                <li class="w-full font-bold">
                    <div class="flex w-full flex-row" justify-start items-center>
                        <div class="mx-3 my-auto">
                            <img class="h-10 w-10" src="<?php echo get_template_directory_uri() . '/resources/images/nosotros/whatsapp.png'; ?>" alt="Ícono de Whatsapp">
                        </div>
                        <div class="folex flex-col items-start justify-center py-3">
                            <h2>WHATSAPP:</h2>
                            <p class="text-lg md:text-xl">+52 81 2080 2420</p>
                        </div>
                    </div>
                    <div class="bg-linear-65 h-[1px] w-full from-yellow-500 to-red-500"></div>
                </li>
                <li class="w-full font-bold">
                    <div class="flex w-full flex-row" justify-start items-center>
                        <div class="mx-3 my-auto">
                            <img class="h-10 w-10" src="<?php echo get_template_directory_uri() . '/resources/images/nosotros/llamar.png'; ?>" alt="Ícono de Teléfono">
                        </div>
                        <div class="folex flex-col items-start justify-center py-3">
                            <h2>TELÉFONO:</h2>
                            <p class="text-lg md:text-xl">+52 81 2080 2420</p>
                        </div>
                    </div>
                    <div class="bg-linear-65 h-[1px] w-full from-yellow-500 to-red-500"></div>
                </li>
                <li class="w-full font-bold">
                    <div class="flex w-full flex-row" justify-start items-center>
                        <div class="mx-3 my-auto">
                            <img class="h-10 w-10" src="<?php echo get_template_directory_uri() . '/resources/images/nosotros/localizacion.png'; ?>" alt="Ícono de Ubicación">
                        </div>
                        <div class="folex flex-col items-start justify-center py-3">
                            <h2>UBICACIÓN:</h2>
                            <p class="text-lg md:text-xl">AVE. ALFONSO REYES 255</p>
                        </div>
                    </div>
                    <div class="bg-transpartent h-[1px] w-full"></div>
                </li>
            </ul>
        </div>
        <div class="h-140 w-full lg:w-[55%]">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3596.8868565144835!2d-100.27947329999999!3d25.641880399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8662bf99d30c3957%3A0x3492755f898822d6!2sAv.%20Alfonso%20Reyes%20255%2C%20Contry%2C%2064860%20Monterrey%2C%20N.L.!5e0!3m2!1ses-419!2smx!4v1755549626022!5m2!1ses-419!2smx"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
