@extends('layouts.admin-layout')

@section('title', 'Komisyon Kuralı Düzenle')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Komisyon Kuralı Düzenle
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('admin.affiliatemodule.admin.commissionrules.index') }}" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i> Listeye Dön
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.affiliatemodule.admin.commissionrules.update', $commissionRule->id) }}" method="POST" class="card mt-4">
        @csrf
        @method('PUT')

        <div class="card-header">
            <h3 class="card-title">Komisyon Bilgileri</h3>
        </div>

        <div class="card-body">
            <div class="row g-3">

                {{-- Seviye --}}
                <div class="col-md-6">
                    <label class="form-label required">Seviye</label>
                    <input
                        type="text"
                        class="form-control @error('level') is-invalid @enderror"
                        name="level"
                        value="{{ old('level', $commissionRule->level) }}"
                        placeholder="Seviye değerini giriniz"
                        required
                    >
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Yüzde --}}
                <div class="col-md-6">
                    <label class="form-label required">Yüzde (%)</label>
                    <input
                        type="text"
                        class="form-control @error('percentage') is-invalid @enderror"
                        name="percentage"
                        value="{{ old('percentage', $commissionRule->percentage) }}"
                        placeholder="Yüzde değerini giriniz"
                        required
                    >
                    @error('percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Durum --}}
                <div class="col-md-12">
                    <label class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $commissionRule->is_active) ? 'checked' : '' }}
                        >
                        <span class="form-check-label">Durum Aktif mi?</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.affiliatemodule.admin.commissionrules.index') }}" class="btn btn-secondary">
                <i class="ti ti-x me-1"></i> İptal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-check me-1"></i> Güncelle
            </button>
        </div>
    </form>
</div>
@endsection
