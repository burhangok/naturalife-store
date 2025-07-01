@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    //30.06.2025 burhangok - Geliştirilmiş Top Navigation
    $channel = core()->getCurrentChannel();
    $customization = $themeCustomizationRepository->findOneWhere([
        'type' => 'footer_links',
        'status' => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Top Navigation Menüsü -->
<div class="top-navigation"
    style="background: linear-gradient(135deg, #66b47c 0%, #66b47c 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
    <div class="container mx-auto">
        <div class="flex items-center justify-between px-4 lg:px-8 py-3">

            <!-- Sol Taraf - Sayfa Linkleri -->
            <div class="flex items-center gap-6">
                <a href="{{ route('shop.cms.page', 'impressum') }}"
                    class="top-nav-link flex items-center gap-2 text-sm font-medium"
                    style="color: #f8f6f0 !important;">
                    <i class="fas fa-info-circle text-xs" style="color: inherit !important;"></i>
                    <span style="color: inherit !important;">Impressum</span>
                </a>

                <a href="{{ route('shop.cms.page', 'kontakt') }}"
                    class="top-nav-link flex items-center gap-2 text-sm font-medium"
                    style="color: #f8f6f0 !important;">
                    <i class="fas fa-envelope text-xs" style="color: inherit !important;"></i>
                    <span style="color: inherit !important;">Kontakt</span>
                </a>
            </div>

            <!-- Sağ Taraf - Sosyal Medya ve İletişim -->
            <div class="flex items-center gap-4">

                <!-- Telefon Numarası (Desktop'ta görünür) -->
                <a href="tel:+4915255416317"
                    class="top-nav-link lg:flex items-center gap-2 text-sm font-medium"
                    style="color: #f8f6f0 !important;">
                    <i class="fas fa-phone text-xs" style="color: inherit !important;"></i>
                    <span style="color: inherit !important;">+49 152 5541 6317</span>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/lifenatura_gmbh" target="_blank"
                    class="social-link instagram flex items-center gap-2 text-sm font-medium"
                    title="Instagram"
                    style="color: #f8f6f0 !important;">
                    <i class="fab fa-instagram text-base" style="color: inherit !important;"></i>
                    <span class="sm:inline" style="color: inherit !important;"> Instagram</span>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/4915255416317" target="_blank"
                    class="social-link whatsapp flex items-center gap-2 text-sm font-medium"
                    title="WhatsApp"
                    style="color: #f8f6f0 !important;">
                    <i class="fab fa-whatsapp text-base" style="color: inherit !important;"></i>
                    <span class="sm:inline" style="color: inherit !important;"> WhatsApp</span>
                </a>

                <!-- E-posta -->
                <a href="mailto:info@lifenatura.eu"
                    class="social-link email md:flex items-center gap-2 text-sm font-medium"
                    title="E-Mail"
                    style="color: #f8f6f0 !important;">
                    <i class="fas fa-at text-base" style="color: inherit !important;"></i>
                    <span class="lg:inline" style="color: inherit !important;"> E-Mail</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Özel CSS Stilleri -->

<style>
    .top-navigation {
        position: relative;
        z-index: 100;
    }

    /* !important ile güçlendirilmiş linkler */
    .top-navigation .top-nav-link {
        color: #f8f6f0 !important;
        text-decoration: none !important;
        transition: all 0.3s ease;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .top-navigation .top-nav-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.1) !important;
        transform: translateY(-1px);
    }

    .top-navigation .social-link {
        color: #f8f6f0 !important;
        text-decoration: none !important;
        transition: all 0.3s ease;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
    }

    .top-navigation .social-link.instagram:hover {
        color: #E4405F !important;
        background-color: rgba(228, 64, 95, 0.1) !important;
        border-color: rgba(228, 64, 95, 0.3) !important;
    }

    .top-navigation .social-link.whatsapp:hover {
        color: #25D366 !important;
        background-color: rgba(37, 211, 102, 0.1) !important;
        border-color: rgba(37, 211, 102, 0.3) !important;
    }

    .top-navigation .social-link.email:hover {
        color: #4285f4 !important;
        background-color: rgba(66, 133, 244, 0.1) !important;
        border-color: rgba(66, 133, 244, 0.3) !important;
    }

    /* Link içindeki span ve i elementleri */
    .top-navigation .top-nav-link span,
    .top-navigation .social-link span {
        color: inherit !important;
    }

    .top-navigation .top-nav-link i,
    .top-navigation .social-link i {
        color: inherit !important;
        transition: transform 0.3s ease;
    }

    /* Responsive tasarım */
    @media (max-width: 768px) {
        .top-navigation .container > div {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .top-navigation .flex {
            gap: 1rem;
        }

        .top-navigation .social-link span {
            display: none;
        }
    }

    /* Hover animasyonları */
    .top-navigation .top-nav-link:hover i,
    .top-navigation .social-link:hover i {
        transform: scale(1.1);
    }

    /* Gradient gölge efekti */
    .top-navigation::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    }

    /* Tüm link durumları için */
    .top-navigation a:link,
    .top-navigation a:visited,
    .top-navigation a:active {
        color: #f8f6f0 !important;
    }
</style>

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}
