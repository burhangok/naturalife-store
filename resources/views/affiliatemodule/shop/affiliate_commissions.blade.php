@extends('layouts.shop-layout')

@section('title', 'Komisyonlar Listesi')

@section('content')
<div class="page-wrapper">


    <div class="page-body">
        <div class="container">
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="12" cy="12" r="9"></circle>
                                <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                            </svg>
                        </div>
                        <div>{{ session('error') }}</div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
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
                                    <h3 class="card-title"><i class="fas fa-money-check"></i> Bu Ay ki Kazanç
                                    </h3>

                                    <h4>{{ core()->formatPrice($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount')) }}</h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-days fa-2x opacity-75"></i>
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
                                    <h3 class="card-title"><i class="fas fa-users"></i>Alt Temsilci Sayınız
                                    </h3>
                                    <h4>{{ $affiliate->children->count()}}
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
            <!-- JavaScript fonksiyonu -->
            <script>
                function toggleDetails(id) {
                    const detailRow = document.getElementById(id);
                    if (detailRow.classList.contains('d-none')) {
                        detailRow.classList.remove('d-none');
                    } else {
                        detailRow.classList.add('d-none');
                    }
                }
            </script>

            <!-- Siparişlere Göre Gruplandırılmış Komisyonlar -->
            @php
            $commissionCollection = collect($commissions);
            $orderGroups = $commissionCollection->groupBy('order_id');
        @endphp

            @forelse ($orderGroups as $orderId => $groupCommissions)
                @php
                    $order = $groupCommissions->first()->order;
                    $totalCommission = $groupCommissions->sum('amount');
                @endphp

                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <h3 class="card-title mb-1">
                                    <i class="fas fa-receipt text-primary me-2"></i> Sipariş #{{ $orderId }}
                                </h3>

                                @if($order)
                                    <div class="small text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i> {{ $order->created_at->format('d.m.Y H:i') }}
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-hand-holding-usd me-1"></i> Dağıtılan Komisyon:
                                        <strong class="text-success">{{ core()->formatBasePrice($totalCommission) }} €</strong>
                                        + Temsilci İndirimi: <strong class="text-warning">{{ core()->formatBasePrice($order->base_discount_amount) }}</strong>
                                        = <strong class="text-primary">{{ core()->formatBasePrice($order->base_discount_amount + $totalCommission) }} </strong>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-user me-1"></i> Siparişi Veren:
                                        <strong>{{ optional($order->customer)->first_name .' '.optional($order->customer)->last_name }}</strong>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-shopping-cart me-1"></i> Sepet Tutarı:
                                        <strong class="text-dark">{{ core()->formatBasePrice($order->grand_total) }} €</strong>
                                    </div>
                                @else
                                    <div class="small text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i> Sipariş silinmiş -
                                        Toplam Komisyon: <strong>{{ number_format($totalCommission, 2) }} €</strong>
                                    </div>
                                @endif
                            </div>

    <!-- Siparişlere Göre Gruplandırılmış Komisyonlar
                            @if($order)
                                <div class="col-auto">
                                    <a href="#" class="text-decoration-none" title="Siparişi Görüntüle">
                                        <i class="fas fa-external-link-alt text-primary fs-5"></i> Siparişi Görüntüle
                                    </a>
                                </div>
                            @endif
-->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th><i class="fas fa-hashtag text-muted me-1"></i>Komisyon ID</th>
                                    <th><i class="fas fa-user-tie text-muted me-1"></i>Temsilci</th>
                                    <th><i class="fas fa-user-friends text-muted me-1"></i>Alt Temsilci</th>
                                    <th><i class="fas fa-layer-group text-muted me-1"></i>Seviye</th>
                                    <th><i class="fas fa-percentage text-muted me-1"></i>Oran</th>
                                    <th><i class="fas fa-euro-sign text-muted me-1"></i>Tutar</th>
                                    <th><i class="fas fa-calendar-alt text-muted me-1"></i>Tarih</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($groupCommissions as $commission)
                                    <tr>
                                        <td>{{ $commission->id }}</td>
                                        <td>
                                            @if ($commission->affiliate)
                                                <a href="{{ route('shop.customers.affiliatemodule.profile', $commission->affiliate_id) }}" class="text-primary">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    {{ $commission->affiliate->id }} - {{ $commission->affiliate->affiliate_code }}
                                                    <small class="text-muted">({{ $commission->affiliate->customer->getNameAttribute() }})</small>
                                                </a>
                                            @else
                                                <span class="text-muted"><i class="fas fa-user-slash me-1"></i>Temsilci Silinmiş</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($commission->fromAffiliate)
                                                <a href="{{ route('shop.customers.affiliatemodule.profile', $commission->from_affiliate_id) }}" class="text-secondary">
                                                    <i class="fas fa-user-friends me-1"></i>
                                                    {{ $commission->fromAffiliate->id }} - {{ $commission->fromAffiliate->affiliate_code }}
                                                    <small class="text-muted">({{ $commission->fromAffiliate->customer->getNameAttribute() }})</small>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-blue-lt">Seviye {{ $commission->level }}</span></td>
                                        <td><span class="text-green fw-bold">%{{ $commission->percentage }}</span></td>
                                        <td><span class="fw-bold">{{ number_format($commission->amount, 2) }} €</span></td>
                                        <td><span class="text-muted">{{ $commission->created_at->format('d.m.Y H:i') }}</span></td>
                                        <td class="text-end">
                                            <button type="button"
                                                onclick="toggleDetails('commission-{{ $commission->id }}')"
                                                class="btn btn-icon btn-md btn-outline-primary"
                                                title="Detayları Göster">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Detay Satırı -->
                                    <tr id="commission-{{ $commission->id }}" class="d-none">
                                        <td colspan="8">
                                            <div class="card border shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="card-title mb-0"><i class="fas fa-info-circle me-2 text-primary"></i><strong class="text-muted">Komisyon ID:</strong> {{ $commission->id }}   <span class="badge bg-blue-lt">Seviye {{ $commission->level }}</span>
                                                        </h4>

                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-2"><strong class="text-muted">Komisyon Alan Temsilci:</strong>
                                                                    @if ($commission->affiliate)
                                                                    <a href="{{ route('shop.customers.affiliatemodule.profile', $commission->affiliate_id) }}" class="text-primary">
                                                                        <i class="fas fa-user-tie me-1"></i>
                                                                        {{ $commission->affiliate->id }} - {{ $commission->affiliate->affiliate_code }}
                                                                        <small class="text-muted">({{ $commission->affiliate->customer->getNameAttribute() }})</small>
                                                                    </a>        @else
                                                                        <span class="text-danger">Temsilci Silinmiş</span>
                                                                    @endif
                                                                </li>
                                                                <li class="mb-2"><strong class="text-muted">Komisyon Kazandıran Alt Temsilci:</strong>
                                                                    @if ($commission->fromAffiliate)
                                                                    <a href="{{ route('shop.customers.affiliatemodule.profile', $commission->from_affiliate_id) }}" class="text-secondary">
                                                                        <i class="fas fa-user-friends me-1"></i>
                                                                        {{ $commission->fromAffiliate->id }} - {{ $commission->fromAffiliate->affiliate_code }}
                                                                        <small class="text-muted">({{ $commission->fromAffiliate->customer->getNameAttribute() }})</small>
                                                                    </a>       @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </li>

                                                                <li class="mb-2"><strong class="text-muted">Açıklama:</strong> {{ $commission->description }}</li>

                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">

                                                                <li class="mb-2"><strong class="text-muted">Oran:</strong> %{{ $commission->percentage }}</li>
                                                                <li class="mb-2"><strong class="text-muted">Tutar:</strong> <span class="fw-bold text-success">{{ number_format($commission->amount, 2) }} €</span></li>
                                                                    <li class="mb-2"><strong class="text-muted">Oluşturulma:</strong> {{ $commission->created_at->format('d.m.Y H:i') }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    @if($commission->note)
                                                        <div class="mt-4">
                                                            <label class="form-label"><i class="fas fa-sticky-note text-muted me-2"></i>Not:</label>
                                                            <div class="form-control bg-light">{{ $commission->note }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            @empty
                <div class="empty">
                    <div class="empty-img">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sad" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <line x1="9" y1="10" x2="9.01" y2="10"></line>
                            <line x1="15" y1="10" x2="15.01" y2="10"></line>
                            <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                        </svg>
                    </div>
                    <p class="empty-title">Kayıt Bulunamadı</p>
                    <p class="empty-subtitle text-muted">
                        Arama kriterlerinize uygun komisyon kaydı bulunmamaktadır.
                    </p>
                </div>
            @endforelse

            <!-- Sayfalama -->
            {{-- Bu kısmı tabler pagination ile düzenleyebilirsiniz --}}
        </div>
    </div>
</div>
@endsection
