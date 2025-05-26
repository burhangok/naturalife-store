@extends('layouts.admin-layout')

@section('title', 'Temcilci Ödemeleri')

@section('content')
<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Temcilci Ödemeleri</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        <i class="fas fa-plus"></i> Yeni Ödeme
                    </button>
                </div>

                <div class="card-body">
                    <!-- Filtreler -->
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-6">
                            <select name="affiliate_id" class="form-select">
                                <option value="">Tüm Temcilciler</option>
                                @foreach($affiliates as $affiliate)
                                    <option value="{{ $affiliate->id }}" {{ request('affiliate_id') == $affiliate->id ? 'selected' : '' }}>
                                        {{ $affiliate->affiliate_code.' - '.$affiliate->customer->getNameAttribute() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-secondary">Filtrele</button>
                            <a href="{{ route('admin.affiliatemodule.admin.affiliatepayments.index') }}" class="btn btn-outline-secondary">Temizle</a>
                        </div>
                    </form>

                    @if ($payments->count()>0)
 <!-- Tablo -->
 <div class="table-responsive ">
    <table class="table table-striped dataListTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Temcilci</th>
                <th>Tutar</th>
                <th>Ödeme Yöntemi</th>
                <th>Transactıon ID</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>#{{ $payment->id }}</td>
                    <td>
                        <strong>{{ $payment->affiliate->customer->getNameAttribute() }}</strong><br>
                        <small class="text-muted">{{ $payment->affiliate->customer->phone_number }}</small>
                    </td>
                    <td>
                        <strong>{{ $payment->getFormattedAmount() }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-info text-white">{{ $paymentMethods[$payment->payment_method] ?? $payment->payment_method }}</span>
                    </td>
                    <td>
                        @if($payment->transaction_id)
                            <code>{{ $payment->transaction_id }}</code>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        {{ $payment->created_at->format('d.m.Y H:i') }}<br>
                        <small class="text-muted">{{ $payment->createdAdmin->name ?? 'Sistem' }}</small>
                    </td>
                    <td>
                        <div class="btn-group">

                            <a href="{{ route('admin.affiliatemodule.admin.affiliatepayments.edit', $payment) }}" class="btn btn-md btn-outline-warning me-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.affiliatemodule.admin.affiliatepayments.destroy', $payment) }}" class="d-inline" onsubmit="return confirm('Emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-md btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
</div>

@else
<div  class="text-center py-4">
    <div class="text-muted">
        <i class="fas fa-inbox fa-3x mb-3"></i>
        <p>Henüz ödeme kaydı bulunmuyor.</p>
    </div>
</div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ödeme Ekleme Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.affiliatemodule.admin.affiliatepayments.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Ödeme Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Affiliate <span class="text-danger">*</span></label>
                                <select name="affiliate_id" class="form-select" required>
                                    <option value="">Seçiniz...</option>
                                    @foreach($affiliates as $affiliate)
                                        <option value="{{ $affiliate->id }}">{{ $affiliate->affiliate_code.' - '.$affiliate->customer->getNameAttribute() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tutar <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" step="0.01" min="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Para Birimi <span class="text-danger">*</span></label>
                                <select name="currency" class="form-select" required>
                                    <option value="EUR">EUR</option>
                                    <option value="USD">USD</option>
                                    <option value="TRY">TRY</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ödeme Yöntemi <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="">Seçiniz...</option>
                                    @foreach($paymentMethods as $key => $method)
                                        <option value="{{ $key }}">{{ $method }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Transaction ID</label>
                                <input type="text" name="transaction_id" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dosya Ekle</label>
                        <input type="file" name="payment_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <small class="text-muted">Maksimum 5MB - PDF, JPG, PNG, DOC, DOCX</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
