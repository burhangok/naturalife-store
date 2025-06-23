@extends('layouts.shop-layout')
@section('title', $affiliate->affiliate_code . ' - ' . $affiliate->customer->getNameAttribute())
@section('content')
@php
    if(request('lang')) session(['lang' => request('lang')]);
    $lang = session('lang', 'de');
@endphp
    <div class="container py-4">

        <!-- Bildirimler -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M5 12l5 5l10 -10"></path>
                    </svg>
                </div>
                <div>{{ session('success') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                </div>
                <div>{{ session('error') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif
        <div class="row">

            <!-- Sol Panel - Kullanıcı Bilgileri ve Özet -->
            <div class="col-md-3">
                <!-- Kullanıcı Profil Kartı -->


                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="mb-0"><i class="fas fa-user-tie me-2"></i>{{ $lang == 'tr' ? 'Temsilci Profiliniz' : 'Affiliate Panel' }}</h3>

                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Temsilci Kodu:' : 'Vertretercode:' }}</span>
                                <span class="fw-bold">{{ $affiliate->affiliate_code }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Seviyesi' : 'Stufe' }}</span>
                                <span class="badge bg-primary text-white badge-lg">{{ $lang == 'tr' ? 'Seviye' : 'Stufe' }} {{ $affiliate->level }}</span>
                            </li>
                            @if ($affiliate->parent)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Üst Temsilcisi:' : 'Obervertreter:' }}</span>
                                <span class="fw-bold">{{ $affiliate->parent->affiliate_code . ' - ' . $affiliate->parent->customer->getNameAttribute() }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Alt Temsilci Sayısı:' : 'Anzahl der Untervertreter:' }}</span>
                                <span class="fw-bold">{{ $affiliate->children->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Toplam Kazanç:' : 'Gesamteinnahmen:' }}</span>
                                <span class="fw-bold text-success">{{ $affiliate->formatted_commission }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Üyelik Tarihi:' : 'Mitgliedsdatum:' }}</span>
                                <span class="fw-bold">{{ $affiliate->joined_at?->format('d.m.Y') }}</span>
                            </li>
                            @if ($affiliate->getLastCommission())
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">{{ $lang == 'tr' ? 'Son Komisyon:' : 'Letzte Provision:' }}</span>
                                <span class="fw-bold">
                                    {{ $affiliate->getLastCommission()->created_at?->format('d.m.Y').' - '.core()->formatPrice($affiliate->getLastCommission()->amount) ?? ($lang == 'tr' ? 'Henüz yok' : 'Noch nicht vorhanden') }}
                                </span>
                            </li>
                            @endif
                        </ul>

                    </div>
                </div>

                <!-- Navigasyon Menüsü -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                            <button class="nav-link active text-start py-3 px-4 border-bottom" id="dashboard-tab"
                                data-bs-toggle="pill" data-bs-target="#dashboard" type="button">
                                <i class="fas fa-tachometer-alt me-2"></i> {{ $lang == 'tr' ? 'Özet Görünüm' : 'Übersicht' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="referrals-tab"
                                data-bs-toggle="pill" data-bs-target="#referrals" type="button">
                                <i class="fas fa-link me-2"></i> {{ $lang == 'tr' ? 'Referans Linkim' : 'Mein Empfehlungslink' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="network-tab"
                                data-bs-toggle="pill" data-bs-target="#network" type="button">
                                <i class="fas fa-sitemap me-2"></i> {{ $lang == 'tr' ? 'Alt Temsilcilerim' : 'Meine Untervertreter' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab"
                                data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> {{ $lang == 'tr' ? 'Kazanç Geçmişi' : 'Verdienstverlauf' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="orders-tab"
                                data-bs-toggle="pill" data-bs-target="#orders" type="button">
                                <i class="fas fa-shopping-cart me-2"></i> {{ $lang == 'tr' ? 'Siparişlerim' : 'Meine Bestellungen' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="profile-tab" data-bs-toggle="pill"
                                data-bs-target="#profile" type="button">
                                <i class="fas fa-user-cog me-2"></i> {{ $lang == 'tr' ? 'Profil Bilgileri' : 'Profilinformationen' }}
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="payment-tab" data-bs-toggle="pill"
                                data-bs-target="#payment" type="button">
                                <i class="fas fa-money-bill me-2"></i> {{ $lang == 'tr' ? 'Ödeme Bilgileri' : 'Zahlungsinformationen' }}
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Ana İçerik Alanı -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">

              <!-- Dashboard Tab -->
<div class="tab-pane fade active show" id="dashboard" role="tabpanel">
    <!-- İstatistik Kartları -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title"><i class="fas fa-euro-sign"></i> {{ $lang == 'tr' ? 'Toplam Kazanç' : 'Gesamteinnahmen' }}</h3>
                            <h4>€{{ number_format($affiliate->commissions()->sum('amount'), 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title"><i class="fas fa-users"></i> {{ $lang == 'tr' ? 'Alt Temsilcilerim' : 'Meine Untervertreter' }}</h3>
                            <h4>{{ $downlineAffiliates->count() }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-friends fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="card-title"><i class="fas fa-shopping-cart"></i> {{ $lang == 'tr' ? 'Toplam Siparişiniz' : 'Ihre Gesamtbestellungen' }}</h3>
                            <h4>{{ core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Performansı -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-mouse-pointer me-2"></i>{{ $lang == 'tr' ? 'Link Performansı' : 'Link-Leistung' }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $lang == 'tr' ? 'Toplam Tıklama:' : 'Gesamtanzahl der Klicks:' }}</span>
                        <span class="fw-bold">{{ $clicks->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $lang == 'tr' ? 'Dönüşüm Sayısı:' : 'Anzahl der Conversions:' }}</span>
                        <span class="fw-bold">{{ $clicks->where('converted', true)->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>{{ $lang == 'tr' ? 'Dönüşüm Oranı:' : 'Conversion-Rate:' }}</span>
                        <span class="fw-bold text-success">{{ $conversionRate }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bu Ay -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-calendar me-2"></i>{{ $lang == 'tr' ? 'Bu Ay' : 'Dieser Monat' }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $lang == 'tr' ? 'Bu Ayki Kazanç:' : 'Einnahmen dieses Monats:' }}</span>
                        <span class="fw-bold text-success">€{{ number_format($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $lang == 'tr' ? 'Bu Ayki Tıklama:' : 'Klicks diesen Monat:' }}</span>
                        <span class="fw-bold">{{ $clicks->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>{{ $lang == 'tr' ? 'Yeni Alt Temsilci:' : 'Neue Untervertreter:' }}</span>
                        <span class="fw-bold">{{ $affiliate->children->where('joined_at', '>=', now()->startOfMonth())->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Aktiviteler -->
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0"><i class="fas fa-history me-2"></i>{{ $lang == 'tr' ? 'Son Aktiviteler' : 'Letzte Aktivitäten' }}</h3>
        </div>
        <div class="card-body">
            @if ($affiliate->commissions->take(5)->count() > 0)
                @foreach ($affiliate->commissions->take(5) as $commission)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-bold">{{ $lang == 'tr' ? 'Komisyon Kazancı' : 'Provisionsverdienst' }}</div>
                            <small class="text-muted">{{ $commission->created_at->format('d.m.Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">€{{ number_format($commission->amount, 2) }}</div>
                            <small class="text-muted">{{ $lang == 'tr' ? 'Seviye' : 'Stufe' }} {{ $commission->level }}</small>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted py-4">
                    {{ $lang == 'tr' ? 'Henüz komisyon kazancınız bulunmuyor.' : 'Sie haben noch keine Provisionseinnahmen.' }}
                </div>
            @endif
        </div>
    </div>
</div>


<!-- Referans Linki Tab -->
<div class="tab-pane fade" id="referrals" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="mb-0"><i class="fas fa-link me-2"></i>{{ $lang == 'tr' ? 'Referans Linkiniz' : 'Ihr Empfehlungslink' }}</h3>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="referralLink"
                    value="https://lifenature.eu/ref/{{ $affiliate->affiliate_code }}" readonly>
                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('referralLink')">
                    <i class="fas fa-copy"></i> {{ $lang == 'tr' ? 'Kopyala' : 'Kopieren' }}
                </button>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="border-end">
                        <h4 class="text-primary">{{ $clicks->count() }}</h4>
                        <small class="text-muted">{{ $lang == 'tr' ? 'Toplam Tıklama' : 'Gesamtanzahl der Klicks' }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border-end">
                        <h4 class="text-success">{{ $clicks->where('converted', true)->count() }}</h4>
                        <small class="text-muted">{{ $lang == 'tr' ? 'Dönüşüm' : 'Konversion' }}</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="text-info">{{ $conversionRate }}%</h4>
                    <small class="text-muted">{{ $lang == 'tr' ? 'Dönüşüm Oranı' : 'Konversionsrate' }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tıklama Geçmişi -->
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0"><i class="fas fa-chart-line me-2"></i>{{ $lang == 'tr' ? 'Tıklama & UTM Geçmişi' : 'Klick- & UTM-Verlauf' }}</h3>
        </div>
        <div class="card-body p-0">
            @if ($clicks->isEmpty())
                <div class="p-4 text-center text-muted">
                    {{ $lang == 'tr' ? 'Henüz bir tıklama kaydı yok.' : 'Noch keine Klick-Daten vorhanden.' }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ $lang == 'tr' ? 'Zaman' : 'Zeitpunkt' }}</th>
                                <th>{{ $lang == 'tr' ? 'IP / Konum' : 'IP / Standort' }}</th>
                                <th>{{ $lang == 'tr' ? 'Cihaz' : 'Gerät' }}</th>
                                <th>{{ $lang == 'tr' ? 'Referer' : 'Verweis' }}</th>
                                <th>{{ $lang == 'tr' ? 'Dönüşüm' : 'Konversion' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clicks->take(10) as $click)
                                <tr>
                                    <td>{{ $click->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        {{ $click->ip_address }}<br>
                                        <small class="text-muted">{{ $click->country ?? '-' }} / {{ $click->city ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ ucfirst($click->device_type) }}<br>
                                        <small class="text-muted">{{ $click->browser }}</small>
                                    </td>
                                    <td>
                                        <small class="text-truncate d-block" style="max-width:150px;">
                                            {{ Str::limit($click->referrer_url, 30) }}
                                        </small>
                                    </td>
                                    <td>
                                        @if ($click->converted)
                                            <span class="badge bg-success text-white">{{ $lang == 'tr' ? 'Evet' : 'Ja' }}</span>
                                        @else
                                            <span class="badge bg-warning text-white">{{ $lang == 'tr' ? 'Hayır' : 'Nein' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>


               <!-- Alt Temsilciler Tab -->
<div class="tab-pane fade" id="network" role="tabpanel">
    <!-- Alt Temsilci İstatistikleri -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h3 class="text-muted mb-1">{{ $lang == 'tr' ? 'Toplam Alt Temsilci' : 'Gesamtanzahl Untervertreter' }}</h3>
                    <h3 class="mb-0">{{ $downlineAffiliates->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h3 class="text-muted mb-1">{{ $lang == 'tr' ? 'Alt Temsilcilerden Kazanç' : 'Einnahmen von Untervertretern' }}</h3>
                    <h3 class="mb-0">
                        €{{ number_format($downlineAffiliates->sum(function ($affiliate) {
                            return $affiliate->generatedCommissions()->sum('amount');
                        }),2) }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Ağaç Yapısı -->
    <div class="card mb-3 py-3">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-center mb-3">
                    <div class="text-center p-3 border rounded">
                        <div class="mb-2">
                            <i class="fas fa-user-circle fa-3x text-gray-400"></i>
                        </div>
                        <strong>{{ $affiliate->customer->getNameAttribute() }}</strong><br>
                        <span class="badge bg-info text-white">{{ $affiliate->children->count() }} {{ $lang == 'tr' ? 'Alt Üye' : 'Untervertreter' }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-2">
                    <div class="border-start" style="height: 30px; width: 2px;"></div>
                </div>

                <div class="d-flex justify-content-around">
                    @foreach ($downlineAffiliates as $downlineAffiliate)
                        <div class="text-center">
                            <div class="border-top" style="width: 100%; height: 20px;"></div>
                            <div class="p-2 border rounded">
                                <div class="mb-1">
                                    <i class="fas fa-user-circle fa-3x text-gray-400"></i>
                                </div>
                                <strong>{{ $downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name }}</strong><br>
                                <span class="badge bg-primary level-badge text-white">{{ $lang == 'tr' ? 'Seviye' : 'Stufe' }} {{ $downlineAffiliate->level }}</span>

                                @if ($downlineAffiliate->children()->count() > 0)
                                    <span class="badge bg-info level-badge text-white">{{ $downlineAffiliate->children()->count() }} {{ $lang == 'tr' ? 'Alt Üye' : 'Untervertreter' }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Alt Temsilciler Listesi -->
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0"><i class="fas fa-sitemap me-2"></i>{{ $lang == 'tr' ? 'Alt Temsilcilerim' : 'Meine Untervertreter' }}</h3>
        </div>

        <div class="card-body p-0">
            @if ($downlineAffiliates->isEmpty())
                <div class="p-4 text-center text-muted">
                    {{ $lang == 'tr' ? 'Henüz alt temsilciniz bulunmuyor.' : 'Sie haben derzeit keine Untervertreter.' }}
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ $lang == 'tr' ? 'Temsilci' : 'Vertreter' }}</th>
                                <th>{{ $lang == 'tr' ? 'Seviye' : 'Stufe' }}</th>
                                <th>{{ $lang == 'tr' ? 'Kayıt Tarihi' : 'Registrierungsdatum' }}</th>
                                <th>{{ $lang == 'tr' ? 'Alt Üye' : 'Untervertreter' }}</th>
                                <th>{{ $lang == 'tr' ? 'Toplam Siparişi' : 'Gesamtbestellungen' }}</th>
                                <th>{{ $lang == 'tr' ? 'Bayilerinin Satış Tutarı' : 'Umsatz seiner Vertreter' }}</th>
                                <th>{{ $lang == 'tr' ? 'Kazancı' : 'Verdienst' }}</th>
                                <th>{{ $lang == 'tr' ? 'Ağının Kazandırdığı Komisyon' : 'Netzwerkprovision' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downlineAffiliates as $downlineAffiliate)
                                <tr>
                                    <td>
                                        <div>
                                            <div class="fw-bold">
                                                {{ $downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name }}
                                            </div>
                                            <small class="text-muted">{{ $downlineAffiliate->affiliate_code }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary text-white">{{ $downlineAffiliate->level }}</span>
                                    </td>
                                    <td>{{ $downlineAffiliate->joined_at?->format('d.m.Y') }}</td>
                                    <td>{{ $downlineAffiliate->children->count() }}</td>
                                    <td>
                                        {{ $downlineAffiliate->customer->orders->count() }} {{ $lang == 'tr' ? 'Adet' : 'Stk.' }},
                                        {{ core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
                                    </td>
                                    <td>€{{ number_format(array_sum($downlineAffiliate->getDescendantOrderTotalsPerLevel()), 2) }}</td>
                                    <td class="text-success fw-bold">
                                        €{{ number_format($downlineAffiliate->getTotalCommissionFromNetwork(), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>



                 <!-- Kazanç Geçmişi Tab -->
                 <div class="tab-pane fade" id="earnings" role="tabpanel">
                    <!-- Kazanç Özeti -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-muted mb-1">{{ $lang == 'tr' ? 'Toplam Kazanç' : 'Gesamteinnahmen' }}</h3>
                                    <h3 class="mb-0">€{{ number_format($affiliate->commissions->sum('amount'), 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-muted mb-1">{{ $lang == 'tr' ? 'Bu Ayki Kazanç' : 'Einnahmen diesen Monat' }}</h3>
                                    <h3 class="mb-0">€{{ number_format($affiliate->getThisMonthEarningsAttribute(), 2) }}</h3>
                                </div>
                            </div>
                        </div>

                        @if ($affiliate->getLastCommission())
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-muted mb-1">{{ $lang == 'tr' ? 'Son Komisyon' : 'Letzte Provision' }}</h3>
                                    <h3 class="mb-0">{{ core()->formatPrice($affiliate->getLastCommission()->amount) }}</h3>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Komisyon Geçmişi -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                {{ $lang == 'tr' ? 'Komisyon Geçmişi' : 'Provisionsverlauf' }}
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            @if ($affiliate->commissions->isEmpty())
                                <div class="p-4 text-center text-muted">
                                    {{ $lang == 'tr' ? 'Henüz komisyon kazancınız bulunmuyor.' : 'Sie haben noch keine Provisionseinnahmen.' }}
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ $lang == 'tr' ? 'Tarih' : 'Datum' }}</th>
                                                <th>{{ $lang == 'tr' ? 'Kaynak' : 'Quelle' }}</th>
                                                <th>{{ $lang == 'tr' ? 'Seviye' : 'Ebene' }}</th>
                                                <th>{{ $lang == 'tr' ? 'Tutar' : 'Betrag' }}</th>
                                                <th>{{ $lang == 'tr' ? 'Açıklama' : 'Beschreibung' }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($affiliate->commissions as $commission)
                                                <tr>
                                                    <td>{{ $commission->created_at->format('d.m.Y H:i') }}</td>
                                                    <td>
                                                        @if ($commission->from_affiliate_id)
                                                            {{ $commission->fromAffiliate->customer->getNameAttribute() ?? '-' }}
                                                            @if ($commission->level > 1)
                                                                <small class="text-muted">({{ $lang == 'tr' ? 'Alt bayi' : 'Unterpartner' }})</small>
                                                            @endif
                                                        @else
                                                            <span class="text-primary text-white">{{ $lang == 'tr' ? 'Direkt Satış' : 'Direktverkauf' }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-secondary text-white">{{ $commission->level }}</span></td>
                                                    <td class="text-success fw-bold">€{{ number_format($commission->amount, 2) }}</td>
                                                    <td>{{ $commission->description ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                 </div>

               <!-- Siparişlerim Tab -->
<div class="tab-pane fade" id="orders" role="tabpanel">
   <div class="card">
       <div class="card-header d-flex justify-content-between align-items-center">
           <h3 class="mb-0">
               <i class="fas fa-shopping-cart me-2"></i>
               {{ $lang == 'tr' ? 'Siparişlerim' : 'Meine Bestellungen' }}
           </h3>
           <div>
               <span class="badge bg-success text-white">
                   {{ $lang == 'tr' ? 'Toplam:' : 'Gesamt:' }}
                   {{ core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
               </span>
           </div>
       </div>
       <div class="card-body p-0">
           @if ($affiliate->customer->orders->isEmpty())
               <div class="p-4 text-center text-muted">
                   {{ $lang == 'tr' ? 'Henüz sipariş kaydınız bulunmuyor.' : 'Sie haben noch keine Bestellungen.' }}
               </div>
           @else
               <div class="table-responsive">
                   <table class="table table-hover mb-0">
                       <thead class="table-light">
                           <tr>
                               <th>{{ $lang == 'tr' ? 'Sipariş No' : 'Bestellnummer' }}</th>
                               <th>{{ $lang == 'tr' ? 'Tarih' : 'Datum' }}</th>
                               <th>{{ $lang == 'tr' ? 'Tutar' : 'Betrag' }}</th>
                               <th>{{ $lang == 'tr' ? 'Ödeme' : 'Zahlung' }}</th>
                               <th>{{ $lang == 'tr' ? 'Durum' : 'Status' }}</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($affiliate->customer->orders as $order)
                               <tr>
                                   <td>
                                       <span class="fw-bold">
                                           <a href="{{ route('shop.customers.account.orders.view', $order->increment_id) }}"
                                              class="text-decoration-none"
                                              title="{{ $lang == 'tr' ? 'Siparişi Görüntüle' : 'Bestellung anzeigen' }}">
                                              #{{ $order->increment_id }}
                                           </a>
                                       </span>
                                   </td>
                                   <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                   <td class="fw-bold">{{ core()->formatBasePrice($order->grand_total) }}</td>
                                   <td>{{ $order->payment->method_title }}</td>
                                   <td>
                                       @php
                                           $statusClass = match ($order->status) {
                                               'completed' => 'bg-success',
                                               'processing' => 'bg-warning',
                                               'pending' => 'bg-info',
                                               'canceled' => 'bg-danger',
                                               default => 'bg-secondary',
                                           };

                                           $statusText = $lang == 'tr' ?
                                               match ($order->status) {
                                                   'completed' => 'Tamamlandı',
                                                   'processing' => 'İşleniyor',
                                                   'pending' => 'Bekliyor',
                                                   'canceled' => 'İptal',
                                                   default => ucfirst($order->status),
                                               } :
                                               match ($order->status) {
                                                   'completed' => 'Abgeschlossen',
                                                   'processing' => 'In Bearbeitung',
                                                   'pending' => 'Ausstehend',
                                                   'canceled' => 'Storniert',
                                                   default => ucfirst($order->status),
                                               };
                                       @endphp
                                       <span class="badge {{ $statusClass }} text-white">{{ $statusText }}</span>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           @endif
       </div>
   </div>
</div>
<!-- Profil Bilgileri Tab -->
<div class="tab-pane fade" id="profile" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-user-cog me-2"></i>
                {{ $lang == 'tr' ? 'Profil Bilgilerim' : 'Meine Profilinformationen' }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'Ad Soyad' : 'Name Nachname' }}</label>
                    <input type="text" class="form-control"
                        value="{{ $affiliate->customer->getNameAttribute() }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'E-posta' : 'E-Mail' }}</label>
                    <input type="email" class="form-control"
                        value="{{ $affiliate->customer->email }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'Telefon' : 'Telefon' }}</label>
                    <input type="tel" class="form-control"
                        value="{{ $affiliate->customer->phone ?? '-' }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'Ülke' : 'Land' }}</label>
                    <input type="text" class="form-control"
                        value="{{ optional($affiliate->customer->addresses->first())->country ?? '-' }}"
                        readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'Temsilci Kodu' : 'Vertreter-Code' }}</label>
                    <input type="text" class="form-control"
                        value="{{ $affiliate->affiliate_code }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $lang == 'tr' ? 'Seviye' : 'Stufe' }}</label>
                    <input type="text" class="form-control"
                        value="{{ $lang == 'tr' ? 'Seviye ' . $affiliate->level : 'Stufe ' . $affiliate->level }}" readonly>
                </div>
                @if ($affiliate->parent)
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ $lang == 'tr' ? 'Üst Temsilci' : 'Übergeordneter Vertreter' }}</label>
                        <input type="text" class="form-control"
                            value="{{ $affiliate->parent->affiliate_code }} - {{ $affiliate->parent->customer->getNameAttribute() }}"
                            readonly>
                    </div>
                @endif
                @php
                    $addr =
                        $affiliate->customer->addresses->first() ??
                        (object) [
                            'address' => null,
                            'city' => null,
                            'postcode' => null,
                            'state' => null,
                            'country' => null,
                        ];
                @endphp
                @if ($addr->address)
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ $lang == 'tr' ? 'Adres' : 'Adresse' }}</label>
                        <textarea class="form-control" rows="4" readonly>{{ $addr->address }}, {{ $addr->city }} {{ $addr->postcode }}, {{ $addr->state }}, {{ $addr->country }}</textarea>
                    </div>
                @endif
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                {{ $lang == 'tr' ? 'Profil bilgilerinizi güncellemek için lütfen müşteri hesabınızdan düzenleyiniz.' : 'Um Ihre Profilinformationen zu aktualisieren, bearbeiten Sie diese bitte über Ihr Kundenkonto.' }}
            </div>
        </div>
    </div>
</div>

<!-- Ödeme Bilgileri Tab -->
<div class="tab-pane fade" id="payment" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-user-cog me-2"></i>
                {{ $lang == 'tr' ? 'Ödeme Bilgileri' : 'Zahlungsinformationen' }}
            </h3>
        </div>
        <div class="card-body">
            @php
            $customer = auth()->guard('customer')->user();
            $existingAffiliate = \App\Models\Affiliate::where('customer_id', $customer->id)->first();
        @endphp
            @if ($affiliate->id==$existingAffiliate->id)

            <form action="{{ route('shop.customers.affiliatemodule.paymentmethod',$affiliate->id)}}" method="POST">
                @csrf
                @method('POST')
                <!-- Temel Ödeme Tercihleri -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label required">{{ $lang == 'tr' ? 'Tercih Edilen Ödeme Yöntemi' : 'Bevorzugte Zahlungsmethode' }}</label>
                        <select class="form-select" id="paymentMethod" name="payment_method" >
                            <option value="">{{ $lang == 'tr' ? 'Seçiniz...' : 'Auswählen...' }}</option>
                            <option value="sepa" {{ ($affiliate->paymentMethod->payment_method ?? 'sepa') == 'sepa' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'SEPA Transfer (Avrupa)' : 'SEPA-Überweisung (Europa)' }}</option>
                            <option value="bank" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'bank' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Uluslararası Banka Transferi' : 'Internationale Banküberweisung' }}</option>
                            <option value="paypal" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="wise" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'wise' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Wise (eski TransferWise)' : 'Wise (ehemals TransferWise)' }}</option>
                            <option value="revolut" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'revolut' ? 'selected' : '' }}>Revolut Business</option>
                            <option value="stripe" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'stripe' ? 'selected' : '' }}>Stripe Connect</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ $lang == 'tr' ? 'Para Birimi' : 'Währung' }}</label>
                        <select class="form-select" name="currency">
                            <option value="EUR" {{ ($affiliate->paymentMethod->currency ?? 'EUR') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                            <option value="USD" {{ ($affiliate->paymentMethod->currency ?? '') == 'USD' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Amerikan Doları (USD)' : 'US-Dollar (USD)' }}</option>
                        </select>
                    </div>
                </div>

                <!-- Minimum Ödeme Tutarı -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">{{ $lang == 'tr' ? 'Vergi Durumu' : 'Steuerstatus' }}</label>
                        <select class="form-select" name="tax_status">
                            <option value="individual" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'individual' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Bireysel' : 'Privatperson' }}</option>
                            <option value="company" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'company' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Şirket' : 'Unternehmen' }}</option>
                            <option value="freelancer" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'freelancer' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Serbest Meslek' : 'Freiberufler' }}</option>
                            <option value="vat_registered" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'vat_registered' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'KDV Kayıtlı' : 'Umsatzsteuer-registriert' }}</option>
                        </select>
                    </div>
                </div>

                <!-- SEPA / Banka Bilgileri -->
                <div class="card mb-4" id="bankDetails">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'Banka / SEPA Bilgileri' : 'Bank- / SEPA-Informationen' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Hesap Sahibi Adı' : 'Kontoinhaber Name' }}</label>
                                <input type="text" class="form-control" name="account_holder_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->account_holder_name ?? '' }}" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Banka Adı' : 'Bankname' }}</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Deutsche Bank AG" value="{{ $affiliate->paymentMethod->bank_name ?? '' }}" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">IBAN</label>
                                <input type="text" class="form-control" name="iban" placeholder="DE89 3704 0044 0532 0130 00" value="{{ $affiliate->paymentMethod->iban ?? '' }}" >
                                <small class="form-hint">{{ $lang == 'tr' ? 'Almanya, Fransa, Hollanda IBAN formatı desteklenir' : 'Deutschland, Frankreich, Niederlande IBAN-Format wird unterstützt' }}</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'BIC/SWIFT Kodu' : 'BIC/SWIFT-Code' }}</label>
                                <input type="text" class="form-control" name="bic_swift_code" placeholder="DEUTDEDBXXX" value="{{ $affiliate->paymentMethod->bic_swift_code ?? '' }}" >
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang == 'tr' ? 'Banka Adresi' : 'Bankadresse' }}</label>
                                <textarea class="form-control" name="bank_address" rows="2" placeholder="Taunusanlage 12, 60325 Frankfurt am Main, Deutschland">{{ $affiliate->paymentMethod->bank_address ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PayPal Bilgileri -->
                <div class="card mb-4" id="paypalDetails" style="display: none;">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'PayPal Bilgileri' : 'PayPal-Informationen' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'PayPal E-posta Adresi' : 'PayPal E-Mail-Adresse' }}</label>
                                <input type="email" class="form-control" name="paypal_email" placeholder="hans.mueller@example.com" value="{{ $affiliate->paymentMethod->paypal_email ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $lang == 'tr' ? 'PayPal İş Hesabı ID' : 'PayPal Geschäftskonto-ID' }}</label>
                                <input type="text" class="form-control" name="paypal_merchant_id" placeholder="{{ $lang == 'tr' ? 'PayPal Merchant ID (opsiyonel)' : 'PayPal Merchant ID (optional)' }}" value="{{ $affiliate->paymentMethod->paypal_merchant_id ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wise/Revolut Bilgileri -->
                <div class="card mb-4" id="digitalWalletDetails" style="display: none;">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'Dijital Cüzdan Bilgileri' : 'Digitale Wallet-Informationen' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'E-posta Adresi' : 'E-Mail-Adresse' }}</label>
                                <input type="email" class="form-control" name="digital_wallet_email" placeholder="hesap@example.com" value="{{ $affiliate->paymentMethod->digital_wallet_email ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $lang == 'tr' ? 'Hesap ID/Numarası' : 'Konto-ID/Nummer' }}</label>
                                <input type="text" class="form-control" name="digital_wallet_account_id" placeholder="{{ $lang == 'tr' ? 'Wise/Revolut hesap numarası' : 'Wise/Revolut Kontonummer' }}" value="{{ $affiliate->paymentMethod->digital_wallet_account_id ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vergi ve Kimlik Bilgileri -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'Vergi ve Kimlik Bilgileri' : 'Steuer- und Identitätsinformationen' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ $lang == 'tr' ? 'Vergi Numarası' : 'Steuernummer' }}</label>
                                <input type="text" class="form-control" name="tax_number" placeholder="DE123456789" value="{{ $affiliate->paymentMethod->tax_number ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ $lang == 'tr' ? 'KDV Numarası' : 'USt-IdNr.' }}</label>
                                <input type="text" class="form-control" name="vat_number" placeholder="DE987654321" value="{{ $affiliate->paymentMethod->vat_number ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ $lang == 'tr' ? 'Ülke' : 'Land' }}</label>
                                <select class="form-select" name="tax_country">
                                    <option value="DE" {{ ($affiliate->paymentMethod->tax_country ?? 'DE') == 'DE' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Almanya' : 'Deutschland' }}</option>
                                    <option value="FR" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'FR' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Fransa' : 'Frankreich' }}</option>
                                    <option value="NL" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'NL' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Hollanda' : 'Niederlande' }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $lang == 'tr' ? 'Şirket Adı (varsa)' : 'Firmenname (falls vorhanden)' }}</label>
                                <input type="text" class="form-control" name="company_name" placeholder="Mueller Marketing GmbH" value="{{ $affiliate->paymentMethod->company_name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $lang == 'tr' ? 'Şirket Kayıt Numarası' : 'Handelsregisternummer' }}</label>
                                <input type="text" class="form-control" name="company_registration_number" placeholder="HRB 123456" value="{{ $affiliate->paymentMethod->company_registration_number ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fatura Adresi -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'Fatura Adresi' : 'Rechnungsadresse' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Ad Soyad/Şirket' : 'Name/Firma' }}</label>
                                <input type="text" class="form-control" name="billing_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->billing_name ?? '' }}" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Cadde/Sokak' : 'Straße/Hausnummer' }}</label>
                                <input type="text" class="form-control" name="billing_street" placeholder="Muster Straße 123" value="{{ $affiliate->paymentMethod->billing_street ?? '' }}" >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Posta Kodu' : 'Postleitzahl' }}</label>
                                <input type="text" class="form-control" name="billing_postal_code" placeholder="10115" value="{{ $affiliate->paymentMethod->billing_postal_code ?? '' }}" >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Şehir' : 'Stadt' }}</label>
                                <input type="text" class="form-control" name="billing_city" placeholder="Berlin" value="{{ $affiliate->paymentMethod->billing_city ?? '' }}" >
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">{{ $lang == 'tr' ? 'Ülke' : 'Land' }}</label>
                                <select class="form-select" name="billing_country" required>
                                    <option value="DE" {{ ($affiliate->paymentMethod->billing_country ?? 'DE') == 'DE' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Almanya' : 'Deutschland' }}</option>
                                    <option value="FR" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'FR' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Fransa' : 'Frankreich' }}</option>
                                    <option value="NL" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'NL' ? 'selected' : '' }}>{{ $lang == 'tr' ? 'Hollanda' : 'Niederlande' }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ödeme Koşulları ve Notlar -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $lang == 'tr' ? 'Özel Notlar' : 'Besondere Hinweise' }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">{{ $lang == 'tr' ? 'Özel Notlar' : 'Besondere Hinweise' }}</label>
                                <textarea class="form-control" name="special_notes" rows="3" placeholder="{{ $lang == 'tr' ? 'Ödeme ile ilgili özel notlar, koşullar veya talimatlar...' : 'Besondere Hinweise, Bedingungen oder Anweisungen zur Zahlung...' }}">{{ $affiliate->paymentMethod->special_notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kaydet Butonu -->
                <div class="text-end">
                    <button type="button" class="btn btn-outline-secondary me-2">{{ $lang == 'tr' ? 'İptal' : 'Abbrechen' }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-3"></i>
                        {{ $lang == 'tr' ? 'Ödeme Bilgilerini Kaydet' : 'Zahlungsinformationen speichern' }}
                    </button>
                </div>
            </form>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
               {{ $lang == 'tr' ? 'Bu bilgiler sizlere ödeme gönderilmek için kullanılacaktır.' : 'Diese Informationen werden verwendet, um Ihnen Zahlungen zu senden.' }}
            </div>
            @else
            <div class="alert alert-danger mt-3">
                <i class="fas fa-warning me-2"></i>
               {{ $lang == 'tr' ? 'Bu bilgileri sadece temsilci görüntüleyebilir ya da düzenleyebilir.' : 'Nur der Vertreter kann diese Informationen anzeigen oder bearbeiten.' }}
            </div>
            @endif
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Kopyalama fonksiyonu
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            element.setSelectionRange(0, 99999);
            document.execCommand('copy');

            // Toast bildirim göster
            showToast('Link kopyalandı!', 'success');
        }

        // Toast bildirim fonksiyonu
        function showToast(message, type = 'info') {
            const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

            // Toast container oluştur (yoksa)
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1055';
                document.body.appendChild(toastContainer);
            }

            // Toast ekle
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Toast'u göster
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            // Toast kapandıktan sonra DOM'dan kaldır
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }

        // Tab değişimi için URL hash güncelleme
        document.addEventListener('DOMContentLoaded', function() {
            // URL'deki hash'e göre tab seçme
            const hash = window.location.hash;
            if (hash) {
                const tabButton = document.querySelector(`button[data-bs-target="${hash}"]`);
                if (tabButton) {
                    const tab = new bootstrap.Tab(tabButton);
                    tab.show();
                }
            }

            // Tab değişiminde URL hash'ini güncelleme
            const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(e) {
                    const target = e.target.getAttribute('data-bs-target');
                    if (target) {
                        history.pushState(null, null, target);
                    }
                });
            });
        });

        // Responsive tablo için scroll indicator
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('.table-responsive');
            tables.forEach(table => {
                if (table.scrollWidth > table.clientWidth) {
                    table.classList.add('has-scroll');
                }
            });
        });
    </script>
<script>
    // Ödeme yöntemi değiştiğinde ilgili alanları göster/gizle
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const value = this.value;
        const bankDetails = document.getElementById('bankDetails');
        const paypalDetails = document.getElementById('paypalDetails');
        const digitalWalletDetails = document.getElementById('digitalWalletDetails');

        // Tüm detay alanlarını gizle
        bankDetails.style.display = 'none';
        paypalDetails.style.display = 'none';
        digitalWalletDetails.style.display = 'none';

        // Seçilen yönteme göre ilgili alanı göster
        if (value === 'sepa' || value === 'bank') {
            bankDetails.style.display = 'block';
        } else if (value === 'paypal') {
            paypalDetails.style.display = 'block';
        } else if (value === 'wise' || value === 'revolut') {
            digitalWalletDetails.style.display = 'block';
        }
    });

    // Sayfa yüklendiğinde varsayılan seçimi tetikle
    document.getElementById('paymentMethod').dispatchEvent(new Event('change'));
</script>
    <style>
        /* Özel CSS */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .nav-pills .nav-link {
            border-radius: 0;
            color: #495057;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
            color: white;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .table-responsive.has-scroll::after {
            content: '→ Kaydırarak devamını görün';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            color: #6c757d;
            pointer-events: none;
        }

        .badge {
            font-size: 0.75em;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Mobil uyumluluk */
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Animasyonlar */
        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .nav-link {
            transition: all 0.2s ease-in-out;
        }

        /* Scroll bar özelleştirme */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

@endsection
