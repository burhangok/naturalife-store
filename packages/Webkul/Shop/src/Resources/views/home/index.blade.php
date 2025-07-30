@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the theme customization -->
    @foreach ($customizations as $customization)
        @php ($data = $customization->options) @endphp

        <!-- Static content -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($customization::STATIC_CONTENT)
                <!-- push style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                <!-- render html -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($customization::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($customization::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch
    @endforeach
 @php
    $allProducts = app('Webkul\Product\Repositories\ProductRepository')->getAll();
@endphp

@if ($allProducts->count())
    <section class="container mb-4">
        <h2 class="font-dmserif text-3xl max-md:text-2xl max-sm:text-xl" style="margin-bottom: 20px">Alle Produkte</h2>

        <div class="grid grid-cols-3 gap-8 max-[1060px]:grid-cols-2 max-md:grid-cols-1 max-md:gap-4 max-md:justify-items-center">


            @foreach ($allProducts as $product)
            <div class="1180:transition-all group w-full max-w-[320px] rounded-md border border-transparent p-2.5 hover:border-gray-300 mx-auto">

                <!-- Product Image Container -->
                <div class="relative max-h-[300px] w-full overflow-hidden max-md:max-h-60 max-md:max-w-full max-md:rounded-lg max-sm:max-h-[200px] max-sm:max-w-full">

                    <!-- Product Image -->
                    <a href="{{ url($product->url_key) }}" aria-label="{{ $product->name }}">
                        <img
                            src="{{ $product->base_image_url }}"
                            alt="{{ $product->name }}"
                            class="after:content-[' '] relative bg-zinc-100 transition-all duration-300 after:block after:pb-[calc(100%+9px)] group-hover:scale-105 w-full h-48 object-cover"
                        />
                    </a>

                    <!-- Sale/New Badges -->
                    <div class="action-items">
                        @if($product->getTypeInstance()->haveDiscount())
                        <p
                        class="absolute top-5 inline-block rounded-[44px] bg-red-500 px-2.5 text-sm text-white ltr:left-5 max-sm:ltr:left-2 rtl:right-5"

                    >
                        @lang('shop::app.components.products.card.sale')
                    </p>

                        @elseif($product->new)
                        <p
                        class="absolute top-5 inline-block rounded-[44px] bg-navyBlue px-2.5 text-sm text-white ltr:left-5 max-sm:ltr:left-2 rtl:right-5"

                    >
                        @lang('shop::app.components.products.card.new')
                    </p>
                        @endif

                        <!-- Action Buttons (Wishlist, Compare) -->
                        <div class="opacity-0 transition-all duration-300 group-hover:bottom-0 group-hover:opacity-100 max-lg:opacity-100 max-sm:opacity-100">


                        </div>
                    </div>
                </div>

                <!-- Product Information Section -->
                <div class="-mt-9 grid w-full translate-y-9 content-start gap-2.5 bg-white p-2.5 transition-transform duration-300 ease-out group-hover:-translate-y-0 group-hover:rounded-t-lg max-md:relative max-md:mt-0 max-md:translate-y-0 max-md:gap-0 max-md:px-0 max-md:py-1.5">

                    <!-- Product Name -->
                    <p class="break-all text-base font-medium max-md:mb-1.5 max-md:whitespace-break-spaces max-md:leading-6 max-sm:text-sm max-sm:leading-4">
                        {{ $product->name }}
                    </p>

                    <!-- Product Price -->
                    <div class="flex items-center gap-2.5 text-lg font-semibold max-sm:text-sm max-sm:leading-6">
                        <p class="font-semibold max-sm:leading-4">
                            {{ core()->currency($product->price)  }}
                        </p>
                    </div>


                    <div class="action-items flex items-center justify-between gap-2 opacity-0 transition-all duration-300 ease-in-out group-hover:opacity-100 max-md:opacity-100">

                        @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))

                        <button
                        class="secondary-button w-full max-w-full p-2.5 text-sm font-medium max-sm:rounded-xl max-sm:p-2"

                        @click="addToCart()"
                    >
                        @lang('shop::app.components.products.card.add-to-cart')
                    </button>


                        @endif





                    </div>
                </div>
            </div>
        @endforeach




        </div>
        <a
        href="{{ url('/') }}"
        class="secondary-button mx-auto mt-5 block w-max rounded-2xl px-11 py-3 text-center text-base max-lg:mt-0 max-lg:hidden max-lg:py-3.5 max-md:rounded-lg"
        aria-label="Alle anzeigen"
    >
        @lang('shop::app.components.products.carousel.view-all')
    </a>
    </section>
@endif


</x-shop::layouts>
