@php
    if(request('lang')) session(['lang' => request('lang')]);
    $lang = session('lang', 'de');
@endphp
<!-- Özet İstatistikler -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                <h4 class="mb-0">{{ $totalOrders }}</h4>
                <small>{{ $lang == 'tr' ? 'Toplam Sipariş' : 'Gesamtbestellungen' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-money-bill fa-2x mb-2"></i>
                <h4 class="mb-0">{{ core()->formatPrice($totalRevenue) }}</h4>
                <small>{{ $lang == 'tr' ? 'Toplam Gelir' : 'Gesamteinnahmen' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4 class="mb-0">{{ core()->formatPrice($totalDiscount, 0) }}</h4>
                <small>{{ $lang == 'tr' ? 'Toplam İndirim' : 'Gesamtrabatt' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <h4 class="mb-0">{{ $coupon->commission_percentage }}</h4>
                <small>{{ $lang == 'tr' ? 'Komisyon Oranı(%)' : 'Provisionssatz (%)' }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Müşteri Analizi -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    {{ $lang == 'tr' ? 'En Çok Satın Alan Müşteriler' : 'Top-Kunden' }}
                </h4>
            </div>
            <div class="card-body">
                @if($topCustomers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>{{ $lang == 'tr' ? 'Müşteri' : 'Kunde' }}</th>
                                    <th class="text-center">{{ $lang == 'tr' ? 'Sipariş' : 'Bestellungen' }}</th>
                                    <th class="text-end">{{ $lang == 'tr' ? 'Toplam' : 'Gesamt' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $customer)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $customer->customer_first_name }} {{ $customer->customer_last_name }}</div>
                                            <small class="text-muted">{{ $customer->customer_email }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary text-white">{{ $customer->order_count }}</span>
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            {{ core()->formatPrice($customer->total_spent) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <div>{{ $lang == 'tr' ? 'Henüz müşteri verisi bulunmuyor' : 'Noch keine Kundendaten vorhanden' }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    {{ $lang == 'tr' ? 'Müşteri Özeti' : 'Kundenübersicht' }}
                </h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ $lang == 'tr' ? 'Tekil Müşteri:' : 'Einzelne Kunden:' }}</span>
                    <strong class="text-primary">{{ $uniqueCustomers }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ $lang == 'tr' ? 'Tekrar Eden:' : 'Wiederkehrende:' }}</span>
                    <strong class="text-success">{{ $repeatCustomers }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>{{ $lang == 'tr' ? 'Tekrar Oranı:' : 'Wiederholungsrate:' }}</span>
                    <strong class="text-info">
                        %{{ $uniqueCustomers > 0 ? number_format(($repeatCustomers / $uniqueCustomers) * 100, 1) : 0 }}
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Siparişler Listesi -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-list-alt me-2"></i>
            {{ $lang == 'tr' ? 'Sipariş Detayları' : 'Bestelldetails' }} ({{ $coupon->coupon_code }})
        </h4>
        <div></div>
    </div>
    <div class="card-body p-0">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-vcenter table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>{{ $lang == 'tr' ? 'Sipariş No' : 'Bestell-Nr.' }}</th>
                            <th>{{ $lang == 'tr' ? 'Müşteri' : 'Kunde' }}</th>
                            <th>{{ $lang == 'tr' ? 'Tarih' : 'Datum' }}</th>
                            <th class="text-center">{{ $lang == 'tr' ? 'Durum' : 'Status' }}</th>
                            <th class="text-end">{{ $lang == 'tr' ? 'İndirim' : 'Rabatt' }}</th>
                            <th class="text-end">{{ $lang == 'tr' ? 'Toplam' : 'Gesamt' }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary">#{{ $order->increment_id }}</div>
                                    <small class="text-muted">{{ $order->id }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-blue-lt me-2">
                                            {{ substr($order->customer_first_name ?? 'M', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</div>
                                            <small class="text-muted">{{ $order->customer_email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $order->created_at->format('d.m.Y') }}</div>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'canceled' => 'danger',
                                            'closed' => 'secondary'
                                        ];
                                        $statusColor = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}  text-white">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="text-success fw-bold">
                                        -{{ core()->formatPrice($order->discount_amount) }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold">{{ core()->formatPrice($order->grand_total) }}</div>
                                    <small class="text-muted">
                                        {{ $order->items->count() }} {{ $lang == 'tr' ? 'ürün' : 'Artikel' }}
                                    </small>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Sayfalama -->
            @if($orders->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        {{ $orders->firstItem() }}-{{ $orders->lastItem() }} / {{ $orders->total() }} {{ $lang == 'tr' ? 'sipariş' : 'Bestellungen' }}
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">{{ $lang == 'tr' ? 'Henüz sipariş bulunmuyor' : 'Noch keine Bestellungen vorhanden' }}</h5>
                <p class="text-muted">{{ $lang == 'tr' ? 'Bu kupon kodu ile henüz sipariş verilmemiş.' : 'Für diesen Gutscheincode wurden noch keine Bestellungen aufgegeben.' }}</p>
            </div>
        @endif
    </div>
</div>


<!-- JavaScript Fonksiyonları -->
<script>



function exportCouponOrders(couponId) {
    window.open('/admin/coupons/' + couponId + '/export-orders', '_blank');
}

function shareCouponLink(couponId) {
    alert("shareCouponLink");
    // Kupon linkini kopyala veya paylaş
    const link = '{{ url(path: "/promo") }}/' + couponId;
    navigator.clipboard.writeText(link).then(function() {
        alert('Kupon linki kopyalandı: ' + link);
    });
}
</script>
