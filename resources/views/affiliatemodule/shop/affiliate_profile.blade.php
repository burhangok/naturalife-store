@extends('layouts.shop-layout')
@section('title', $affiliate->affiliate_code . ' - ' . $affiliate->customer->getNameAttribute())
@section('content')
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
                        <h3 class="mb-0"><i class="fas fa-user-tie me-2"></i>Temsilci Özeti</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Temsilci Kodu:</span>
                                <span class="fw-bold">{{ $affiliate->affiliate_code }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Seviyesi</span>
                                <span class="badge bg-primary text-white badge-lg">Seviye {{ $affiliate->level }}</span>
                            </li>
                            @if ($affiliate->parent)
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Üst Temsilcisi:</span>
                                <span
                                    class="fw-bold">{{ $affiliate->parent->affiliate_code . ' - ' . $affiliate->parent->customer->getNameAttribute() }}</span>
                            </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Alt Temsilci Sayısı:</span>
                                <span class="fw-bold">{{ $affiliate->children->count() }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Toplam Kazanç:</span>
                                <span class="fw-bold text-success">€{{ $affiliate->formatted_commission }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Üyelik Tarihi:</span>
                                <span class="fw-bold">{{ $affiliate->joined_at?->format('d.m.Y') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Son Komisyon:</span>
                                <span
                                    class="fw-bold">{{ $affiliate->last_commission_at?->format('d.m.Y') ?? 'Henüz yok' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Navigasyon Menüsü -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                            <button class="nav-link active text-start py-3 px-4 border-bottom" id="dashboard-tab"
                                data-bs-toggle="pill" data-bs-target="#dashboard" type="button">
                                <i class="fas fa-tachometer-alt me-2"></i> Özet Görünüm
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="referrals-tab"
                                data-bs-toggle="pill" data-bs-target="#referrals" type="button">
                                <i class="fas fa-link me-2"></i> Referans Linkim
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="network-tab"
                                data-bs-toggle="pill" data-bs-target="#network" type="button">
                                <i class="fas fa-sitemap me-2"></i> Alt Temsilcilerim
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab"
                                data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> Kazanç Geçmişi
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="orders-tab"
                                data-bs-toggle="pill" data-bs-target="#orders" type="button">
                                <i class="fas fa-shopping-cart me-2"></i> Siparişlerim
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="profile-tab" data-bs-toggle="pill"
                                data-bs-target="#profile" type="button">
                                <i class="fas fa-user-cog me-2"></i> Profil Bilgileri
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="payment-tab" data-bs-toggle="pill"
                            data-bs-target="#payment" type="button">
                            <i class="fas fa-money-bill me-2"></i> Ödeme Bilgileri
                        </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ana İçerik Alanı -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">

                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <!-- İstatistik Kartları -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card text-white bg-success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3 class="card-title"><i class="fas fa-euro-sign"></i> Toplam Kazanç</h3>
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
                                                <h3 class="card-title"><i class="fas fa-users"></i> Yönlendirdiğim Kişiler
                                                </h3>
                                                <h4>2</h4>
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
                                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Toplam Satış
                                                </h3>
                                                <h4>{{ core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
                                                </h4>
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
                                        <h3 class="mb-0"><i class="fas fa-mouse-pointer me-2"></i>Link Performansı</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Toplam Tıklama:</span>
                                            <span class="fw-bold">{{ $clicks->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Dönüşüm Sayısı:</span>
                                            <span class="fw-bold">{{ $clicks->where('converted', true)->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Dönüşüm Oranı:</span>
                                            <span class="fw-bold text-success">{{ $conversionRate }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0"><i class="fas fa-calendar me-2"></i>Bu Ay</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Bu Ayki Kazanç:</span>
                                            <span
                                                class="fw-bold text-success">€{{ number_format($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Bu Ayki Tıklama:</span>
                                            <span
                                                class="fw-bold">{{ $clicks->where('created_at', '>=', now()->startOfMonth())->count() }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Yeni Alt Temsilci:</span>
                                            <span
                                                class="fw-bold">{{ $affiliate->children->where('joined_at', '>=', now()->startOfMonth())->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Son Aktiviteler -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-history me-2"></i>Son Aktiviteler</h3>
                            </div>
                            <div class="card-body">
                                @if ($affiliate->commissions->take(5)->count() > 0)
                                    @foreach ($affiliate->commissions->take(5) as $commission)
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <div class="fw-bold">Komisyon Kazancı</div>
                                                <small
                                                    class="text-muted">{{ $commission->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bold text-success">
                                                    €{{ number_format($commission->amount, 2) }}</div>
                                                <small class="text-muted">Seviye {{ $commission->level }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-4">
                                        Henüz komisyon kazancınız bulunmuyor.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Referans Linki Tab -->
                    <div class="tab-pane fade" id="referrals" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-link me-2"></i>Referans Linkiniz</h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="referralLink"
                                        value="https://lifenature.eu/ref/{{ $affiliate->affiliate_code }}" readonly>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="copyToClipboard('referralLink')">
                                        <i class="fas fa-copy"></i> Kopyala
                                    </button>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <div class="border-end">
                                            <h4 class="text-primary">{{ $clicks->count() }}</h4>
                                            <small class="text-muted">Toplam Tıklama</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border-end">
                                            <h4 class="text-success">{{ $clicks->where('converted', true)->count() }}</h4>
                                            <small class="text-muted">Dönüşüm</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-info">{{ $conversionRate }}%</h4>
                                        <small class="text-muted">Dönüşüm Oranı</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tıklama Geçmişi -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-chart-line me-2"></i>Tıklama & UTM Geçmişi</h3>
                            </div>
                            <div class="card-body p-0">
                                @if ($clicks->isEmpty())
                                    <div class="p-4 text-center text-muted">
                                        Henüz bir tıklama kaydı yok.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Zaman</th>
                                                    <th>IP / Konum</th>
                                                    <th>Cihaz</th>
                                                    <th>Referer</th>
                                                    <th>Dönüşüm</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($clicks->take(10) as $click)
                                                    <tr>
                                                        <td>{{ $click->created_at->format('d.m.Y H:i') }}</td>
                                                        <td>
                                                            {{ $click->ip_address }}<br>
                                                            <small class="text-muted">{{ $click->country ?? '-' }} /
                                                                {{ $click->city ?? '-' }}</small>
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
                                                                <span class="badge bg-success text-white">Evet</span>
                                                            @else
                                                                <span class="badge bg-warning text-white">Hayır</span>
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
                                        <h3 class="text-muted mb-1">Toplam Alt Temsilci</h3>
                                        <h3 class="mb-0">{{ $downlineAffiliates->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Alt Temsilcilerden Kazanç</h3>
                                        <h3 class="mb-0">
                                            €{{ number_format($downlineAffiliates->sum(function ($affiliate) {return $affiliate->generatedCommissions()->sum('amount');}),2) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 py-3">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="text-center p-3 border rounded">
                                            <div class="mb-2">
                                                <i class="fas fa-user-circle fa-3x text-gray-400"></i>
                                            </div>
                                            <strong>{{ $affiliate->customer->getNameAttribute() }}</strong><br>
                                            <span class="badge bg-primary text-white">{{ $affiliate->level }}</span>
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
                                                    <span
                                                        class="badge bg-success level-badge text-white">{{ $downlineAffiliate->level }}</span>
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
                                <h3 class="mb-0"><i class="fas fa-sitemap me-2"></i>Alt Temsilcilerim</h3>
                            </div>

                            <div class="card-body p-0">

                                @if ($downlineAffiliates->isEmpty())
                                    <div class="p-4 text-center text-muted">
                                        Henüz alt temsilciniz bulunmuyor.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Temsilci</th>
                                                    <th>Seviye</th>
                                                    <th>Kayıt Tarihi</th>
                                                    <th>Alt Üye</th>
                                                    <th>Toplam Satış</th>
                                                    <th>Kazandırdığı</th>
                                                    <th>Detay</th>
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
                                                                <small
                                                                    class="text-muted">{{ $downlineAffiliate->affiliate_code }}</small>
                                                            </div>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-primary  text-white">{{ $downlineAffiliate->level }}</span>
                                                        </td>
                                                        <td>{{ $downlineAffiliate->joined_at?->format('d.m.Y') }}</td>
                                                        <td>{{ $downlineAffiliate->children->count() }}</td>
                                                        <td>{{ core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
                                                        </td>
                                                        <td class="text-success fw-bold">
                                                            €{{ number_format($downlineAffiliate->generatedCommissions()->sum('amount'), 2) }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('shop.customers.affiliatemodule.profile', $downlineAffiliate->id) }}"
                                                                class="btn btn-icon btn-outline-primary me-1">
                                                                <i class="fas fa-search"></i>
                                                            </a>
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
                                        <h3 class="text-muted mb-1">Toplam Kazanç</h3>
                                        <h3 class="mb-0">€{{ number_format($affiliate->commissions->sum('amount'), 2) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Bu Ayki Kazanç</h3>
                                        <h3 class="mb-0">
                                            €{{ number_format($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Son Komisyon</h3>
                                        <h3 class="mb-0">
                                            {{ $affiliate->last_commission_at?->format('d.m.Y') ?? 'Henüz yok' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Komisyon Geçmişi -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Komisyon Geçmişi</h3>
                            </div>
                            <div class="card-body p-0">
                                @if ($affiliate->commissions->isEmpty())
                                    <div class="p-4 text-center text-muted">
                                        Henüz komisyon kazancınız bulunmuyor.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tarih</th>
                                                    <th>Kaynak</th>
                                                    <th>Seviye</th>
                                                    <th>Tutar</th>
                                                    <th>Açıklama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($affiliate->commissions as $commission)
                                                    <tr>
                                                        <td>{{ $commission->created_at->format('d.m.Y H:i') }}</td>
                                                        <td>
                                                            @if ($commission->from_affiliate_id)
                                                                {{ $commission->fromAffiliate->customer->first_name ?? 'Bilinmiyor' }}
                                                                @if ($commission->level > 1)
                                                                    <small class="text-muted">(Alt bayi)</small>
                                                                @endif
                                                            @else
                                                                <span class="text-primary">Direkt Satış</span>
                                                            @endif
                                                        </td>
                                                        <td><span
                                                                class="badge bg-secondary text-white">{{ $commission->level }}</span>
                                                        </td>
                                                        <td class="text-success fw-bold">
                                                            €{{ number_format($commission->amount, 2) }}</td>
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
                                <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Siparişlerim</h3>
                                <div>
                                    <span class="badge bg-success text-white">Toplam:
                                        {{ core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if ($affiliate->customer->orders->isEmpty())
                                    <div class="p-4 text-center text-muted">
                                        Henüz sipariş kaydınız bulunmuyor.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sipariş No</th>
                                                    <th>Tarih</th>
                                                    <th>Tutar</th>
                                                    <th>Ödeme</th>
                                                    <th>Durum</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($affiliate->customer->orders as $order)
                                                    <tr>
                                                        <td>
                                                            <span class="fw-bold"><a href="{{ route('shop.customers.account.orders.view', $order->increment_id) }}" class="text-decoration-none" title="Siparişi Görüntüle">#{{ $order->increment_id }}</a></span>
                                                        </td>
                                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                                        <td class="fw-bold">
                                                            {{ core()->formatBasePrice($order->grand_total) }}</td>
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
                                                            @endphp
                                                            <span
                                                                class="badge {{ $statusClass }} text-white">{{ ucfirst($order->status) }}</span>
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
                                <h3 class="mb-0"><i class="fas fa-user-cog me-2"></i>Profil Bilgilerim</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ad Soyad</label>
                                        <input type="text" class="form-control"
                                            value="{{ $affiliate->customer->getNameAttribute() }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" class="form-control"
                                            value="{{ $affiliate->customer->email }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="tel" class="form-control"
                                            value="{{ $affiliate->customer->phone ?? '-' }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ülke</label>
                                        <input type="text" class="form-control"
                                            value="{{ optional($affiliate->customer->addresses->first())->country ?? '-' }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Temsilci Kodu</label>
                                        <input type="text" class="form-control"
                                            value="{{ $affiliate->affiliate_code }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seviye</label>
                                        <input type="text" class="form-control"
                                            value="Seviye {{ $affiliate->level }}" readonly>
                                    </div>
                                    @if ($affiliate->parent)
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Üst Temsilci</label>
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
                                            <label class="form-label">Adres</label>
                                            <textarea class="form-control" rows="4" readonly>{{ $addr->address }}, {{ $addr->city }} {{ $addr->postcode }}, {{ $addr->state }}, {{ $addr->country }}</textarea>
                                        </div>
                                    @endif
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Profil bilgilerinizi güncellemek için lütfen müşteri hesabınızdan düzenleyiniz.
                                </div>
                            </div>
                        </div>
                    </div>

                      <!-- Profil Bilgileri Tab -->
                      <div class="tab-pane fade" id="payment" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-user-cog me-2"></i>Ödeme Bilgileri</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('shop.customers.affiliatemodule.paymentmethod',$affiliate->id)}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <!-- Temel Ödeme Tercihleri -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label required">Tercih Edilen Ödeme Yöntemi</label>
                                            <select class="form-select" id="paymentMethod" name="payment_method" >
                                                <option value="">Seçiniz...</option>
                                                <option value="sepa" {{ ($affiliate->paymentMethod->payment_method ?? 'sepa') == 'sepa' ? 'selected' : '' }}>SEPA Transfer (Avrupa)</option>
                                                <option value="bank" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'bank' ? 'selected' : '' }}>Uluslararası Banka Transferi</option>
                                                <option value="paypal" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                                <option value="wise" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'wise' ? 'selected' : '' }}>Wise (eski TransferWise)</option>
                                                <option value="revolut" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'revolut' ? 'selected' : '' }}>Revolut Business</option>
                                                <option value="stripe" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'stripe' ? 'selected' : '' }}>Stripe Connect</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Para Birimi</label>
                                            <select class="form-select" name="currency">
                                                <option value="EUR" {{ ($affiliate->paymentMethod->currency ?? 'EUR') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                                <option value="USD" {{ ($affiliate->paymentMethod->currency ?? '') == 'USD' ? 'selected' : '' }}>Amerikan Doları (USD)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Minimum Ödeme Tutarı -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Vergi Durumu</label>
                                            <select class="form-select" name="tax_status">
                                                <option value="individual" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'individual' ? 'selected' : '' }}>Bireysel</option>
                                                <option value="company" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'company' ? 'selected' : '' }}>Şirket</option>
                                                <option value="freelancer" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'freelancer' ? 'selected' : '' }}>Serbest Meslek</option>
                                                <option value="vat_registered" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'vat_registered' ? 'selected' : '' }}>KDV Kayıtlı</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SEPA / Banka Bilgileri -->
                                    <div class="card mb-4" id="bankDetails">
                                        <div class="card-header">
                                            <h4 class="card-title">Banka / SEPA Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">Hesap Sahibi Adı</label>
                                                    <input type="text" class="form-control" name="account_holder_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->account_holder_name ?? '' }}" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Banka Adı</label>
                                                    <input type="text" class="form-control" name="bank_name" placeholder="Deutsche Bank AG" value="{{ $affiliate->paymentMethod->bank_name ?? '' }}" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">IBAN</label>
                                                    <input type="text" class="form-control" name="iban" placeholder="DE89 3704 0044 0532 0130 00" value="{{ $affiliate->paymentMethod->iban ?? '' }}" >
                                                    <small class="form-hint">Almanya, Fransa, Hollanda IBAN formatı desteklenir</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">BIC/SWIFT Kodu</label>
                                                    <input type="text" class="form-control" name="bic_swift_code" placeholder="DEUTDEDBXXX" value="{{ $affiliate->paymentMethod->bic_swift_code ?? '' }}" >
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Banka Adresi</label>
                                                    <textarea class="form-control" name="bank_address" rows="2" placeholder="Taunusanlage 12, 60325 Frankfurt am Main, Deutschland">{{ $affiliate->paymentMethod->bank_address ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PayPal Bilgileri -->
                                    <div class="card mb-4" id="paypalDetails" style="display: none;">
                                        <div class="card-header">
                                            <h4 class="card-title">PayPal Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">PayPal E-posta Adresi</label>
                                                    <input type="email" class="form-control" name="paypal_email" placeholder="hans.mueller@example.com" value="{{ $affiliate->paymentMethod->paypal_email ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">PayPal İş Hesabı ID</label>
                                                    <input type="text" class="form-control" name="paypal_merchant_id" placeholder="PayPal Merchant ID (opsiyonel)" value="{{ $affiliate->paymentMethod->paypal_merchant_id ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Wise/Revolut Bilgileri -->
                                    <div class="card mb-4" id="digitalWalletDetails" style="display: none;">
                                        <div class="card-header">
                                            <h4 class="card-title">Dijital Cüzdan Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">E-posta Adresi</label>
                                                    <input type="email" class="form-control" name="digital_wallet_email" placeholder="hesap@example.com" value="{{ $affiliate->paymentMethod->digital_wallet_email ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Hesap ID/Numarası</label>
                                                    <input type="text" class="form-control" name="digital_wallet_account_id" placeholder="Wise/Revolut hesap numarası" value="{{ $affiliate->paymentMethod->digital_wallet_account_id ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vergi ve Kimlik Bilgileri -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Vergi ve Kimlik Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Vergi Numarası</label>
                                                    <input type="text" class="form-control" name="tax_number" placeholder="DE123456789" value="{{ $affiliate->paymentMethod->tax_number ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">KDV Numarası</label>
                                                    <input type="text" class="form-control" name="vat_number" placeholder="DE987654321" value="{{ $affiliate->paymentMethod->vat_number ?? '' }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ülke</label>
                                                    <select class="form-select" name="tax_country">
                                                        <option value="DE" {{ ($affiliate->paymentMethod->tax_country ?? 'DE') == 'DE' ? 'selected' : '' }}>Almanya</option>
                                                        <option value="FR" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'FR' ? 'selected' : '' }}>Fransa</option>
                                                        <option value="NL" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'NL' ? 'selected' : '' }}>Hollanda</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Adı (varsa)</label>
                                                    <input type="text" class="form-control" name="company_name" placeholder="Mueller Marketing GmbH" value="{{ $affiliate->paymentMethod->company_name ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Kayıt Numarası</label>
                                                    <input type="text" class="form-control" name="company_registration_number" placeholder="HRB 123456" value="{{ $affiliate->paymentMethod->company_registration_number ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fatura Adresi -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Fatura Adresi</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">Ad Soyad/Şirket</label>
                                                    <input type="text" class="form-control" name="billing_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->billing_name ?? '' }}" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Cadde/Sokak</label>
                                                    <input type="text" class="form-control" name="billing_street" placeholder="Muster Straße 123" value="{{ $affiliate->paymentMethod->billing_street ?? '' }}" >
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Posta Kodu</label>
                                                    <input type="text" class="form-control" name="billing_postal_code" placeholder="10115" value="{{ $affiliate->paymentMethod->billing_postal_code ?? '' }}" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Şehir</label>
                                                    <input type="text" class="form-control" name="billing_city" placeholder="Berlin" value="{{ $affiliate->paymentMethod->billing_city ?? '' }}" >
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Ülke</label>
                                                    <select class="form-select" name="billing_country" required>
                                                        <option value="DE" {{ ($affiliate->paymentMethod->billing_country ?? 'DE') == 'DE' ? 'selected' : '' }}>Almanya</option>
                                                        <option value="FR" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'FR' ? 'selected' : '' }}>Fransa</option>
                                                        <option value="NL" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'NL' ? 'selected' : '' }}>Hollanda</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ödeme Koşulları ve Notlar -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Özel Notlar</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Özel Notlar</label>
                                                    <textarea class="form-control" name="special_notes" rows="3" placeholder="Ödeme ile ilgili özel notlar, koşullar veya talimatlar...">{{ $affiliate->paymentMethod->special_notes ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kaydet Butonu -->
                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary me-2">İptal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-3"></i>
                                            Ödeme Bilgilerini Kaydet
                                        </button>
                                    </div>
                                </form>


                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                   Bu bilgiler sizlere ödeme gönderilmek için kullanılacaktır.
                                </div>
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
