@extends('layouts.admin-layout')

@section('title', 'Komisyon Kuralları')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Komisyon Kuralı Oluştur
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.affiliatemodule.admin.commissionrules.index') }}" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i> Listeye Dön
                </a>
            </div>
        </div>
    </div>

        <div class="card m-3">
            <div class="card-header">
                <h2 class="card-title flex items-center gap-2">
                    <i class="fas fa-info-circle text-muted"></i> Komisyon Bilgileri
                </h2>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.affiliatemodule.admin.commissionrules.store') }}" method="POST" id="komisyon-form">
                    @csrf

                    <div class="row">
                        {{-- Seviye --}}
                        <div class="col-md-6 mb-3">
                            <label for="level" class="form-label">
                                <i class="fas fa-layer-group text-primary mr-1"></i> Seviye
                            </label>
                            <input
                                type="text"
                                name="level"
                                id="level"
                                class="form-control @error('level') is-invalid @enderror"
                                placeholder="Seviye değerini giriniz"
                                value="{{ old('level') }}"
                                required
                            >
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Yüzde --}}
                        <div class="col-md-6 mb-3">
                            <label for="percentage" class="form-label">
                                <i class="fas fa-percentage text-primary mr-1"></i> Yüzde (%)
                            </label>
                            <input
                                type="text"
                                name="percentage"
                                id="percentage"
                                class="form-control @error('percentage') is-invalid @enderror"
                                placeholder="Yüzde değerini giriniz"
                                value="{{ old('percentage') }}"
                                required
                            >
                            @error('percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Durum --}}
                    <div class="mb-4">
                        <label class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                            >
                            <span class="form-check-label">Durum Aktif mi?</span>
                        </label>
                    </div>

                    {{-- Butonlar --}}
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.affiliatemodule.admin.commissionrules.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-1"></i> İptal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
