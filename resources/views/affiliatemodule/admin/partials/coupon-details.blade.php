

<div class="row">
    <!-- Sol Kolon - Temel Bilgiler -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Temel Bilgiler
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td class="text-muted">Kupon Adı:</td>
                        <td class="fw-bold">{{ $coupon->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kupon Kodu:</td>
                        <td>
                            <span class="badge bg-primary text-white">{{ $coupon->coupon_code ?? 'Kod Yok' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Durum:</td>
                        <td>
                            <span class="badge {{ $coupon->status ? 'bg-success' : 'bg-danger' }} text-white">
                                {{ $coupon->status ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">İndirim Türü:</td>
                        <td>
                            @if($coupon->action_type == 'by_percent')
                                <span class="text-success">Yüzde İndirim (%{{ $coupon->discount_amount }})</span>
                            @elseif($coupon->action_type == 'by_fixed')
                                <span class="text-success">Sabit İndirim (₺{{ number_format($coupon->discount_amount, 2) }})</span>
                            @else
                                <span class="text-info">{{ ucfirst($coupon->action_type) }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Başlangıç Tarihi:</td>
                        <td>
                            @if($coupon->starts_from)
                                <i class="fas fa-calendar-plus text-success me-1"></i>
                                {{ \Carbon\Carbon::parse($coupon->starts_from)->format('d.m.Y H:i') }}
                            @else
                                <span class="text-muted">Belirtilmemiş</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Bitiş Tarihi:</td>
                        <td>
                            @if($coupon->ends_till)
                                <i class="fas fa-calendar-times text-danger me-1"></i>
                                {{ \Carbon\Carbon::parse($coupon->ends_till)->format('d.m.Y H:i') }}
                                @if(\Carbon\Carbon::parse($coupon->ends_till)->isPast())
                                    <span class="badge bg-warning ms-2 text-white">Süresi Dolmuş</span>
                                @endif
                            @else
                                <span class="text-muted text-white">Belirtilmemiş</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Kullanım Limitleri -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-limit me-2"></i>
                    Kullanım Limitleri
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <div class="text-muted small">Toplam Kullanım</div>
                            <div class="h4 mb-0">
                                {{ $totalOrders }}
                                @if($coupon->uses_per_coupon)
                                    <small class="text-muted">/ {{ $coupon->uses_per_coupon }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <div class="text-muted small">Müşteri Başına</div>
                            <div class="h4 mb-0">
                                {{ $coupon->usage_per_customer ?? '∞' }}
                            </div>
                        </div>
                    </div>
                </div>

                @if($coupon->uses_per_coupon)
                    <div class="progress mt-3" style="height: 8px;">
                        @php $percentage = ($totalOrders / $coupon->uses_per_coupon) * 100; @endphp
                        <div class="progress-bar {{ $percentage > 80 ? 'bg-danger' : ($percentage > 60 ? 'bg-warning' : 'bg-success') }}"
                             style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                    <small class="text-muted">%{{ number_format($percentage, 1) }} kullanılmış</small>
                @endif
            </div>
        </div>
    </div>

    <!-- Sağ Kolon - İstatistikler -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Performans İstatistikleri
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="text-muted small">Toplam Sipariş</div>
                            <div class="h3 mb-0 text-primary">{{ $totalOrders }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="text-muted small">Toplam Gelir</div>
                            <div class="h3 mb-0 text-success">€{{ number_format($totalRevenue, 2) }}</div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="text-muted small">Toplam İndirim</div>
                            <div class="h3 mb-0 text-warning">€{{ number_format($totalDiscount, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="text-muted small">Ort. Sipariş</div>
                            <div class="h3 mb-0 text-info">€{{ number_format($avgOrderValue, 2) }}</div>
                        </div>
                    </div>
                </div>

                @if($firstUsed && $lastUsed)
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="text-muted small">İlk Kullanım</div>
                            <div class="small">{{ \Carbon\Carbon::parse($firstUsed)->format('d.m.Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Son Kullanım</div>
                            <div class="small">{{ \Carbon\Carbon::parse($lastUsed)->format('d.m.Y') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aylık İstatistikler -->
        @if($monthlyStats->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Aylık Performans
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($monthlyStats as $stat)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $stat->month }}/{{ $stat->year }}</strong>
                            </div>
                            <div class="text-end">
                                <div class="small text-muted">{{ $stat->count }} sipariş</div>
                                <div class="text-success">€{{ number_format($stat->total, 2) }}</div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Koşullar -->
@if($coupon->conditions)
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-list-check me-2"></i>
                Kupon Koşulları
            </h6>
        </div>
        <div class="card-body">
            @php
                $conditions = json_decode($coupon->conditions, true);
            @endphp

            @if(isset($conditions['cart']))
                <div class="alert alert-info">
                    <strong>Sepet Koşulları:</strong>
                    <ul class="mb-0 mt-2">
                        @if(isset($conditions['cart']['total_quantity']))
                            <li>Minimum {{ $conditions['cart']['total_quantity'] }} ürün olmalı</li>
                        @endif
                        @if(isset($conditions['cart']['base_total']))
                            <li>Minimum sepet tutarı €{{ number_format($conditions['cart']['base_total'], 2) }} olmalı</li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endif
