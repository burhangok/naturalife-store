@extends('layouts.admin-layout')

@section('title', 'Temsilci Ödeme Detayı #'.$payment->id)

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb breadcrumb-arrows">

                        <li class="breadcrumb-item"><a href="{{ route('admin.affiliatemodule.admin.affiliatepayments.index') }}">Temsilci Ödemeleri</a></li>
                        <li class="breadcrumb-item active">Ödeme #{{ $payment->id }}</li>
                    </ol>
                </nav>
                <h2 class="page-title">
                    <i class="fas fa-credit-card me-2 text-primary"></i>
                    Ödeme Detayı #{{ $payment->id }}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('admin.affiliatemodule.admin.affiliatepayments.index') }}" class="btn btn-ghost-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Geri Dön
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>
                            Yazdır
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>
                                Yazdır
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-file-pdf me-2"></i>
                                PDF İndir
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>
                                Ödemeyi Sil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <!-- Özet Kartları -->
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <i class="fas fa-euro-sign"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Ödeme Tutarı</div>
                                <div class="text-muted">{{ $payment->getFormattedAmount() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @php
                                    $paymentIcons = [
                                        'sepa' => 'fas fa-university',
                                        'bank' => 'fas fa-building-columns',
                                        'paypal' => 'fab fa-paypal',
                                        'wise' => 'fas fa-globe',
                                        'revolut' => 'fas fa-mobile-alt',
                                        'stripe' => 'fab fa-stripe'
                                    ];
                                    $paymentColors = [
                                        'sepa' => 'primary',
                                        'bank' => 'dark',
                                        'paypal' => 'info',
                                        'wise' => 'success',
                                        'revolut' => 'warning',
                                        'stripe' => 'purple'
                                    ];
                                @endphp
                                <span class="bg-{{ $paymentColors[$payment->payment_method] ?? 'secondary' }} text-white avatar">
                                    <i class="{{ $paymentIcons[$payment->payment_method] ?? 'fas fa-credit-card' }}"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Ödeme Yöntemi</div>
                                <div class="text-muted">{{ App\Models\AffiliatePayment::getPaymentMethods()[$payment->payment_method] ?? $payment->payment_method }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-info text-white avatar">
                                    <i class="fas fa-user-tie"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Temsilci</div>
                                <div class="text-muted">{{ $payment->affiliate->customer->getNameAttribute() ?? '-' }}</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-warning text-white avatar">
                                    <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">Ödeme Tarihi</div>
                                <div class="text-muted">{{ $payment->created_at->format('d.m.Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Ana İçerik -->
            <div class="col-lg-8">

                <!-- Ödeme Detayları -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt me-2"></i>
                            Ödeme Detayları
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <tbody>
                                    <tr>
                                        <td class="w-50">
                                            <strong>Ödeme Tutarı</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success fs-6 px-3 py-2 text-white">
                                                {{ $payment->getFormattedAmount() }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Para Birimi</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $payment->currency }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Ödeme Yöntemi</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="{{ $paymentIcons[$payment->payment_method] ?? 'fas fa-credit-card' }} me-2 text-{{ $paymentColors[$payment->payment_method] ?? 'muted' }}"></i>
                                                {{ App\Models\AffiliatePayment::getPaymentMethods()[$payment->payment_method] ?? $payment->payment_method }}
                                            </div>
                                        </td>
                                    </tr>
                                    @if($payment->transaction_id)
                                    <tr>
                                        <td>
                                            <strong>İşlem ID</strong>
                                        </td>
                                        <td>
                                            <code class="fs-6">{{ $payment->transaction_id }}</code>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            <strong>Oluşturma Tarihi</strong>
                                        </td>
                                        <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Son Güncelleme</strong>
                                        </td>
                                        <td>{{ $payment->updated_at->format('d.m.Y H:i') }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Açıklama -->
                @if($payment->description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comment-alt me-2"></i>
                            Açıklama
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="markdown">
                            {{ $payment->description }}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Dosya -->
                @if($payment->payment_file_path)
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-paperclip me-2"></i>
                            Ek Dosya
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="fas fa-file-alt me-3 text-primary fa-2x"></i>
                            <div class="flex-fill">
                                <div class="font-weight-medium">Ödeme Belgesi</div>
                                <div class="text-muted">{{ basename($payment->payment_file_path) }}</div>
                            </div>
                            <a href="{{ Storage::url($payment->payment_file_path) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-download me-1"></i>
                                İndir
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Yan Panel -->
            <div class="col-lg-4">

                <!-- Temsilci Bilgileri -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-tie me-2"></i>
                            Temsilci Bilgileri
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar avatar-xl mb-3" style="background-color: #206bc4; color: white; font-size: 24px;">
                                {{ substr($payment->affiliate->customer->getNameAttribute() ?? 'N', 0, 1) }}
                            </div>
                            <h4 class="mb-1">{{ $payment->affiliate->customer->getNameAttribute() ?? '-' }}</h4>
                            <div class="text-muted">{{ $payment->affiliate->affiliate_code ?? '' }}</div>
                            <div class="text-muted">{{ $payment->affiliate->customer->email ?? '' }}</div>
                            <div class="text-muted">{{ $payment->affiliate->customer->phone_number ?? '' }}</div>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('admin.affiliatemodule.admin.affiliates.edit', $payment->affiliate_id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt me-1"></i>
                                Temsilci Detayına Git
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Admin Bilgileri -->
                @if($payment->createdAdmin)
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-shield me-2"></i>
                            Yönetici Bilgileri
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                          <div class="avatar avatar-m mb-3" style="background-color: #206bc4; color: white; font-size: 24px;">
                                            {{ mb_substr($payment->createdAdmin->name ?? 'N', 0, 1) }}
                            </div>       </div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $payment->createdAdmin->name }}</div>
                                        <div class="text-muted">Oluşturan</div>
                                    </div>
                                </div>
                            </div>
                            @if($payment->updatedAdmin && $payment->updated_admin_id != $payment->created_admin_id)
                            <div class="list-group-item px-0">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar avatar-m mb-3" style="background-color: #206bc4; color: white; font-size: 24px;">
                                            {{ mb_substr($payment->createdAdmin->name ?? 'N', 0, 1) }}
                            </div>           </div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $payment->updatedAdmin->name }}</div>
                                        <div class="text-muted">Güncelleyen</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Hızlı İşlemler -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt me-2"></i>
                            Hızlı İşlemler
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                <i class="fas fa-plus me-1"></i>
                                Yeni Ödeme Ekle
                            </button>
                            <a href="{{ route('admin.affiliatemodule.admin.affiliatepayments.index', ['affiliate_id' => $payment->affiliate_id]) }}" class="btn btn-outline-info">
                                <i class="fas fa-list me-1"></i>
                                Bu Temsilcinin Ödemeleri
                            </a>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-1"></i>
                                Ödemeyi Sil
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Silme Onay Modal -->
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x"></i>
                </div>
                <div class="modal-title text-center mb-3">Ödemeyi Silmek İstediğinizden Emin misiniz?</div>
                <div class="text-muted text-center">Bu işlem geri alınamaz ve tüm veriler kalıcı olarak silinecektir.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn w-100" data-bs-dismiss="modal">İptal</button>
                        </div>
                        <div class="col">
                            <form action="{{ route('admin.affiliatemodule.admin.affiliatepayments.destroy', $payment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i>
                                    Sil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Ödeme Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.affiliatemodule.admin.affiliatepayments.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>
                        Yeni Ödeme Ekle
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Temsilci <span class="text-danger">*</span></label>
                                <select name="affiliate_id" class="form-select" required>
                                    <option value="">Temsilci seçiniz...</option>
                                    @foreach($affiliates as $affiliate)
                                        <option value="{{ $affiliate->id }}" {{ $affiliate->id == $payment->affiliate_id ? 'selected' : '' }}>
                                            {{ $affiliate->affiliate_code.' - '.$affiliate->customer->getNameAttribute() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tutar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required placeholder="0.00">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Para Birimi <span class="text-danger">*</span></label>
                                <select name="currency" class="form-select" required>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="USD">USD - Dolar</option>
                                    <option value="TRY">TRY - Türk Lirası</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ödeme Yöntemi <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="">Yöntem seçiniz...</option>
                                    @foreach($paymentMethods as $key => $method)
                                        <option value="{{ $key }}">{{ $method }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control" placeholder="İşlem numarası (opsiyonel)">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Ödeme ile ilgili notlar..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Belge Ekle</label>
                        <input type="file" name="payment_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <div class="form-hint">Maksimum 5MB - PDF, JPG, PNG, DOC, DOCX formatları desteklenir</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Ödemeyi Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.modal-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.text-purple {
    color: #6f42c1 !important;
}

.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.breadcrumb-arrows .breadcrumb-item + .breadcrumb-item::before {
    content: "→";
    color: #6c757d;
}

@media print {
    .d-print-none {
        display: none !important;
    }

    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }

    .page-body {
        padding-top: 0 !important;
    }
}

.markdown {
    line-height: 1.6;
    white-space: pre-wrap;
}

.list-group-flush .list-group-item {
    border-width: 0 0 1px 0;
}

.fs-6 {
    font-size: 1rem !important;
}
</style>
@endpush

@endsection
