<!-- Özet İstatistikler -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                <h4 class="mb-0">{{ $totalOrders }}</h4>
                <small>Toplam Sipariş</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <i class="fas fa-money-bill fa-2x mb-2"></i>
                <h4 class="mb-0">{{ core()->formatPrice($totalRevenue) }}</h4>
                <small>Toplam Gelir</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4 class="mb-0">{{ core()->formatPrice($totalDiscount, 0) }}</h4>
                <small>Toplam İndirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <h4 class="mb-0">{{ $coupon->commission_percentage }}</h4>
                <small>Temsilci Komisyonu (%)</small>
            </div>
        </div>
    </div>
</div>

<!-- Müşteri Analizi -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    En Çok Satın Alan Müşteriler
                </h6>
            </div>
            <div class="card-body">
                @if($topCustomers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Müşteri</th>
                                    <th class="text-center">Sipariş</th>
                                    <th class="text-end">Toplam</th>
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
                        <div>Henüz müşteri verisi bulunmuyor</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Müşteri Özeti
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>Tekil Müşteri:</span>
                    <strong class="text-primary">{{ $uniqueCustomers }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Tekrar Eden:</span>
                    <strong class="text-success">{{ $repeatCustomers }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tekrar Oranı:</span>
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
        <h6 class="mb-0">
            <i class="fas fa-list-alt me-2"></i>
            Sipariş Detayları ({{ $coupon->coupon_code }})
        </h6>
        <div>
            <button class="btn btn-primary btn-sm" onclick="shareCouponLink({{ $coupon->coupon_code }})">
                <i class="fas fa-share me-1"></i>
                Kupon Linkini Paylaş
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-vcenter table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Sipariş No</th>
                            <th>Müşteri</th>
                            <th>Tarih</th>
                            <th class="text-center">Durum</th>
                            <th class="text-end">İndirim</th>
                            <th class="text-end">Toplam</th>
                            <th class="text-center">İşlem</th>
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
                                        {{ $order->items->count() }} ürün
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sales.orders.view', $order->id) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                            title="Admin Panelde Görüntüle"
                                            target="_blank">
                                             <i class="fas fa-external-link-alt"></i>
                                         </a>
                                    </div>
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
                        {{ $orders->firstItem() }}-{{ $orders->lastItem() }} / {{ $orders->total() }} sipariş
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Henüz sipariş bulunmuyor</h5>
                <p class="text-muted">Bu kupon kodu ile henüz sipariş verilmemiş.</p>
                <div class="mt-3">
                    <button class="btn btn-primary btn-sm" onclick="shareCouponLink({{ $coupon->id }})">
                        <i class="fas fa-share me-1"></i>
                        Kupon Linkini Paylaş
                    </button>
                </div>
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
    // Kupon linkini kopyala veya paylaş
    const link = '{{ url(path: "/coupon") }}/' + couponId;
    navigator.clipboard.writeText(link).then(function() {
        alert('Kupon linki kopyalandı: ' + link);
    });
}
</script>
