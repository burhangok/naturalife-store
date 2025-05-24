@extends('layouts.admin-layout')

@section('title', 'Komisyon Kuralları Listesi')

@section('content')
<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <h2 class="page-title">
          Komisyon Kuralları
        </h2>
        <div class="text-muted mt-1">Toplam {{ $rules->count() }} kural listeleniyor</div>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="{{ route('admin.affiliatemodule.admin.commissionrules.create') }}" class="btn btn-primary d-none d-sm-inline-block">
            <i class="fas fa-plus me-2"></i>
            Yeni Kural Ekle
          </a>
          <a href="{{ route('admin.affiliatemodule.admin.commissionrules.create') }}" class="btn btn-primary d-sm-none btn-icon">
            <i class="fas fa-plus"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Alerts -->
  @if(session('success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <div class="d-flex">
      <div>
        <i class="fas fa-check me-2"></i>
      </div>
      <div>
        {{ session('success') }}
      </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
  </div>
  @endif

  <!-- Table -->
  <div class="card">

    <div class="table-responsive">
      <table class="table table-vcenter card-table dataListTable">
        <thead>
          <tr>
            <th>Seviye</th>
            <th>Yüzde (%)</th>
            <th>Durum</th>
            <th>Oluşturan</th>
            <th>Güncelleyen</th>
            <th class="w-1"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($rules as $rule)
          <tr>
            <td>
              <span class="badge bg-blue-lt">Seviye {{ $rule->level }}</span>
            </td>
            <td>
              <span class="badge bg-green-lt">%{{ number_format($rule->percentage, 2) }}</span>
            </td>
            <td>
              @if($rule->is_active)
              <span class="badge bg-success text-white">Aktif</span>
              @else
              <span class="badge bg-danger text-white">Pasif</span>
              @endif
            </td>
            <td class="text-muted">
              <div class="d-flex align-items-center">
                <i class="fas fa-user me-2 text-secondary"></i>
                {{ $rule->creator?->name ?? '-' }}
              </div>
            </td>
            <td class="text-muted">
              <div class="d-flex align-items-center">
                <i class="fas fa-edit me-2 text-secondary"></i>
                {{ $rule->updater?->name ?? '-' }}
              </div>
            </td>
            <td>
              <div class="btn-list flex-nowrap">
                <a href="{{ route('admin.affiliatemodule.admin.commissionrules.edit', $rule->id) }}" class="btn btn-outline-primary btn-md">
                  <i class="fas fa-edit me-1"></i>

                </a>
                <form action="{{ route('admin.affiliatemodule.admin.commissionrules.destroy', $rule) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-md">
                    <i class="fas fa-trash me-1"></i>

                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($rules->isEmpty())
    <div class="empty">
      <div class="empty-img">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="128" height="128" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="9" y1="10" x2="9.01" y2="10" /><line x1="15" y1="10" x2="15.01" y2="10" /><path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" /></svg>
      </div>
      <p class="empty-title">Henüz Kural Eklenmemiş</p>
      <p class="empty-subtitle text-muted">
        Yeni bir komisyon kuralı ekleyerek başlayabilirsiniz.
      </p>
      <div class="empty-action">
        <a href="{{ route('admin.affiliatemodule.admin.commissionrules.create') }}" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>
          Yeni Kural Ekle
        </a>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
