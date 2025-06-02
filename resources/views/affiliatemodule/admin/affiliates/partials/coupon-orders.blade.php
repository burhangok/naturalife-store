

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
                <h4 class="mb-0">₺{{ number_format($totalRevenue, 0) }}</h4>
                <small>Toplam Gelir</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <i class="fas fa-percentage fa-2x mb-2"></i>
                <h4 class="mb-0">₺{{ number_format($totalDiscount, 0) }}</h4>
                <small>Toplam İndirim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <h4 class="mb-0">₺{{ number_format($totalCommission, 0) }}</h4>
                <small>Komisyon (%{{ $commissionRate * 100 }})</small>
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
                                            <span class="badge bg-primary">{{ $customer->order_count }}</span>
                                        </td>
                                        <td class="text-end fw-bold text-success">
                                            ₺{{ number_format($customer->total_spent, 2) }}
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
            Sipariş Detayları ({{ $coupon->name }})
        </h6>
        <div>
            <button class="btn btn-sm btn-outline-primary" onclick="exportCouponOrders({{ $coupon->id }})">
                <i class="fas fa-download me-1"></i>
                Excel'e Aktar
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
                                    <span class="badge bg-{{ $statusColor }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="text-success fw-bold">
                                        -₺{{ number_format($order->discount_amount, 2) }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold">₺{{ number_format($order->grand_total, 2) }}</div>
                                    <small class="text-muted">
                                        {{ $order->items->count() }} ürün
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                onclick="showOrderDetails({{ $order->id }})"
                                                title="Sipariş Detayı">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.sales.orders.view', $
