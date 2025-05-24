@extends('layouts.admin-layout')

@section('title', 'Temsilciler')

@section('content')
<div class="container-xl">


  <!-- Bildirimler -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l5 5l10 -10"></path>
          </svg>
        </div>
        <div>{{ session('success') }}</div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 9v2m0 4v.01"></path>
            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
          </svg>
        </div>
        <div>{{ session('error') }}</div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  @endif

  <!-- Tablo Kartı -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Temsilci Listesi</h3>
    </div>

    <div class="table-responsive">
      <table class="table table-vcenter card-table table-striped dataListTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Kod</th>
            <th>Müşteri ID</th>
            <th>İsim Soyisim</th>
            <th>Seviye</th>
            <th>Durum</th>
            <th>Alt Temsilci</th>
            <th>Kazanılan Komisyon</th>
            <th>Katılım Tarihi</th>
            <th class="w-1">İşlemler</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($affiliates as $affiliate)
            <tr>
              <td>{{ $affiliate->id }}</td>
              <td class="text-nowrap font-weight-medium">{{ $affiliate->affiliate_code }}</td>
              <td>
                <a href="{{route('admin.customers.customers.view', $affiliate->customer_id)}}" class="text-reset">
                  {{ $affiliate->customer_id }}
                </a>
              </td>
              <td>{{ $affiliate->customer->first_name .' ' .$affiliate->customer->last_name}}</td>
              <td>
                <span class="badge bg-azure-lt">{{ $affiliate->level }}</span>
              </td>
              <td>{!! $affiliate->status_badge !!}</td>
              <td>
                @php
                  $tooltipContent = '<strong>' . $affiliate->affiliate_code . '</strong><br><br>';
                  foreach ($affiliate->children as $index => $child) {
                    $tooltipContent .= optional($child->customer)->first_name . ' ' . optional($child->customer)->last_name;
                    if ($index < count($affiliate->children) - 1) {
                      $tooltipContent .= '<br>';
                    }
                  }
                @endphp

                <span class="badge bg-primary text-white"
                      data-bs-toggle="tooltip"
                      data-bs-html="true"
                      title="{!! $tooltipContent !!}">
                      <i class="fas fa-users"></i>

                  {{ $affiliate->children->count() }}
                </span>
              </td>
              <td>{{ $affiliate->formatted_commission }} ₺</td>
              <td class="text-nowrap">{{ $affiliate->joined_at->format('d.m.Y H:i') }}</td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="{{ route('admin.affiliatemodule.admin.affiliates.edit', $affiliate->id) }}" class="btn btn-icon btn-outline-primary me-1">
                    <i class="fas fa-edit"></i>
</a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center py-4">
                <div class="empty">
                  <div class="empty-img">
                    <i class="fas fa-face-frown"></i>

                  </div>
                  <p class="empty-title">Henüz temsilci kaydı bulunmamaktadır</p>
                  <p class="empty-subtitle text-muted">
                    Yeni bir temsilci ekleyerek başlayabilirsiniz.
                  </p>
                  <div class="empty-action">

                  </div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>
@endsection
