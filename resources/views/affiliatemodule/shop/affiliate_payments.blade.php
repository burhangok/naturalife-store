@extends('layouts.shop-layout')

@section('title', "")

@section('content')
<style>
    .stats-card {
        transition: transform 0.2s ease;
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .stats-icon i {
        font-size: 24px;
        color: white;
    }

    .stats-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .payment-amount {
        font-size: 1.1rem;
        font-weight: 600;
        color: #28a745;
    }



    .main-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #dee2e6;
    }

    .card-body {
        padding: 2rem;
    }

    .filter-section {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }






    .empty-state i {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.75rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 1.5rem;
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 1rem;
        }

        .filter-section .row > div {
            margin-bottom: 1rem;
        }

        .table-responsive {
            font-size: 0.9rem;
        }


    }
</style>



<div class="container">
    <div class="container">

        <h1 class="mb-0">
            <i class="fas fa-money-check-alt me-2"></i>
            Ödemelerim
        </h1>
        <p class="mb-3 mt-2" style="opacity: 0.9;">Aldığınız ödemeleri ve cari hesap durumunuzu görüntüleyin</p>
    </div>
    <!-- İstatistik Kartları -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-value">{{ core()->formatPrice($affiliate->getTotalEarningsAttribute()) }}</div>
                <div class="stats-label">Toplam Kazanç</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-value">{{ core()->formatPrice($payments->sum('amount')) }}</div>
                <div class="stats-label">Ödenen Tutar</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
                    <i class="fas fa-wallet"></i>
                </div>
                @php
                    $balance = $affiliate->current_account_balance;
                    $balanceClass = $balance > 0 ? 'text-success' : ($balance < 0 ? 'text-danger' : 'text-primary');
                @endphp
                <div class="stats-value {{ $balanceClass }}">{{ core()->formatPrice($balance) }}</div>
                <div class="stats-label">Cari Bakiye</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stats-value">{{$payments->total()}}</div>
                <div class="stats-label">Toplam Ödeme Kaydı</div>
            </div>
        </div>
    </div>

    @if($payments->count() > 0)

    <!-- Filtre Bölümü -->
    <div class="filter-section">
        <form method="GET" action="">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="payment_method" class="form-label">Ödeme Yöntemi</label>
                    <select class="form-select" id="payment_method" name="payment_method">
                        <option value="">Tümü</option>
                        @foreach($paymentMethods as $key => $value)
                            <option value="{{ $key }}" {{ request('payment_method') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filtrele
                    </button>
                    <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Temizle
                    </a>
                </div>
            </div>
        </form>
    </div>
@endif
    <!-- Ödeme Geçmişi -->
    <div class="main-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Ödeme Geçmişi
                </h3>
                <div class="d-flex align-items-center">

                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped dataListTable mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tutar</th>
                            <th>Ödeme Yöntemi</th>
                            <th>Transaction ID</th>
                            <th>Tarih</th>
                            <th>İşlem Yapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#{{ $payment->id }}</span>
                            </td>
                            <td>
                                <span class="payment-amount">{{ $payment->getFormattedAmount() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info text-white">
                                    {{ $paymentMethods[$payment->payment_method] ?? $payment->payment_method }}
                                </span>
                            </td>
                            <td>
                                @if($payment->transaction_id)
                                    <code class="bg-light p-1 rounded">{{ $payment->transaction_id }}</code>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <span class="fw-medium">{{ $payment->created_at->format('d.m.Y H:i') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                @if($payment->createdAdmin)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                {{ mb_substr($payment->createdAdmin->name ?? 'A', 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $payment->createdAdmin->name }}</div>
                                            <small class="text-muted">Admin</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-robot me-1"></i>
                                        Sistem
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="card-body   text-center">
                <i class="fas fa-receipt"></i>
                <h3>Henüz ödeme alınmamış</h3>
                <p>İlk ödemeleriniz burada görüntülenecektir.</p>
            </div>
            @endif
        </div>

        @if($payments->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $payments->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    <!-- Cari Hesap Detayları -->
    @if($balance != 0)
    <div class="main-card mt-4">
        <div class="card-header">
            <h3 class="mb-0">
                <i class="fas fa-calculator me-2"></i>
                Cari Hesap Detayları
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="fw-medium">Toplam Kazanç:</span>
                        <span class="text-primary fw-bold">{{  core()->formatPrice($affiliate->getTotalEarningsAttribute()) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="fw-medium">Toplam Ödenen:</span>
                        <span class="text-success fw-bold">{{ core()->formatPrice($affiliate->total_paid_commission) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <span class="fw-bold fs-5">Kalan Bakiye:</span>
                        <span class="fw-bold fs-5 {{ $balanceClass }}">{{ core()->formatPrice($balance) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-1"></i>
                            Bilgilendirme
                        </h6>
                        <p class="mb-0 small">
                            @if($balance > 0)
                                Mevcut bakiyeniz {{ core()->formatPrice($balance) }} Bu tutar bir sonraki ödeme döneminde hesabınıza aktarılacaktır.
                            @elseif($balance < 0)
                                Hesabınızda {{ core()->formatPrice(abs($balance)) }}  borç bulunmaktadır. Bu tutar gelecek kazançlarınızdan düşülecektir.
                            @else
                                Cari hesap bakiyeniz sıfırdır.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>


@endsection
