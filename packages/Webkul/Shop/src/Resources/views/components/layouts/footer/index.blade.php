{!! view_render_event('bagisto.shop.layout.footer.before') !!}

@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    $channel = core()->getCurrentChannel();
    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<footer style="background: #f8fffe; padding:20px 20px 0; margin-top: 50px;">
    <div style="max-width: 1200px; margin: 0 auto; text-align: center;">

        <!-- Logo ve Başlık -->
        <div style="margin-bottom: 60px;">
            <div style="display: inline-flex; align-items: center;">

                <a
                href="{{ route('shop.home.index') }}"
                aria-label="@lang('shop::app.components.layouts.header.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"

                    alt="{{ config('app.name') }}"
                >
            </a>
            </div>
        </div>

        <!-- İletişim Bilgileri -->
        <div style="margin-bottom: 20px;">
            <p style="font-size: 18px; color: #374151; font-weight: 600; margin-bottom: 15px; line-height: 1.6;">
                Sie können uns jederzeit über WhatsApp kontaktieren.
            </p>
            <p style="font-size: 16px; color: #6b7280; margin: 0; line-height: 1.6;">
                Sie können uns in den sozialen Medien folgen.
            </p>
        </div>

        <!-- Sosyal Medya -->
        <div style="margin-bottom: 20px;">
            <a href="https://www.instagram.com/lifenatura_gmbh" target="_blank"
               style="display: inline-flex; align-items: center; justify-content: center; width: 70px; height: 70px; background: linear-gradient(135deg, #e91e63, #ad1457); border-radius: 16px; text-decoration: none; box-shadow: 0 10px 30px rgba(233, 30, 99, 0.3); transition: all 0.3s ease; transform: translateY(0);"
               onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(233, 30, 99, 0.4)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(233, 30, 99, 0.3)';">
                <svg width="32" height="32" fill="white" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </a>
        </div>



        <!-- Newsletter -->
        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
            <div style="margin-bottom: 80px; max-width: 500px; margin-left: auto; margin-right: auto;">
                <h4 style="font-size: 22px; font-weight: 600; color: #374151; margin-bottom: 20px;">Newsletter Abonnieren</h4>
                <p style="font-size: 16px; color: #6b7280; margin-bottom: 35px; line-height: 1.6;">
                    Bleiben Sie über unsere neuesten Produkte und Angebote informiert.
                </p>

                <x-shop::form :action="route('shop.subscription.store')">
                    <div style="display: flex; gap: 15px; align-items: stretch;">
                        <input type="email" name="email" placeholder="Ihre E-Mail-Adresse" required
                               style="flex: 1; padding: 16px 20px; background: white; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 16px; outline: none; transition: all 0.3s ease;"
                               onfocus="this.style.borderColor='#059669'; this.style.boxShadow='0 0 0 3px rgba(5, 150, 105, 0.1)';"
                               onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                        <button type="submit" style="background: linear-gradient(135deg, #059669, #047857); color: white; padding: 16px 32px; border: none; border-radius: 12px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(5, 150, 105, 0.4)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(5, 150, 105, 0.3)';">
                            Abonnieren
                        </button>
                    </div>
                </x-shop::form>
            </div>
        @endif

    </div>

    <!-- Alt Footer -->
    <div style="background: #0c415a; text-align: center; border-top: 1px solid #e2e8f0; padding: 40px 0; margin: 0 -20px;">
        <div style="padding: 0 20px;">

            <!-- Mobil Footer Links -->
            @if ($customization?->options)
                <div style="margin-bottom: 30px;">
                    @foreach ($customization->options as $footerLinkSection)
                        @php
                            usort($footerLinkSection, function ($a, $b) {
                                return $a['sort_order'] - $b['sort_order'];
                            });
                        @endphp
                        @foreach ($footerLinkSection as $link)
                            <a href="{{ $link['url'] }}" style="color:white; text-decoration: none; font-size: 14px; display: inline-block; margin: 5px 15px; transition: color 0.3s ease;"
                              >
                                {{ $link['title'] }}
                            </a>
                        @endforeach
                    @endforeach
                </div>
            @endif

            <!-- Copyright -->
            <div style="text-align: center; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                <p style="color: white; font-size: 14px; margin: 0; line-height: 1.6;">

                    Copyright © 2025 <span style="color: white; font-weight: 600;">Life Natura</span> Alle Rechte vorbehalten.
                </p>
            </div>
        </div>
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
