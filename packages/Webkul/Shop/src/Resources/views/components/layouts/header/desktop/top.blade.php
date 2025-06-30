@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')
@php
//30.06.2025 burhangok
@endphp
@php
    $channel = core()->getCurrentChannel();
    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp
<!-- Yeni Top Navigation Menüsü -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="flex items-center justify-between px-16 py-2">
        <!-- Sol Taraf - Sayfa Linkleri -->
        <div class="flex items-center gap-6">

            @if ($customization?->options)

                @foreach ($customization->options as $footerLinkSection)
                    @php
                        usort($footerLinkSection, function ($a, $b) {
                            return $a['sort_order'] - $b['sort_order'];
                        });
                    @endphp
                    @foreach ($footerLinkSection as $link)
                        <a href="{{ $link['url'] }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors" >
                            {{ $link['title'] }}
                        </a>
                    @endforeach
                @endforeach

        @endif


        </div>


        <div class="flex items-center gap-6">


        </div>
    </div>
</div>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}



{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}



