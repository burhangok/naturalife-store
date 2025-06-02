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
        <div class="row align-items-center">
          <div class="col">
            <h3 class="card-title">Temsilci Listesi</h3>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAffiliateModal">
              <i class="fas fa-plus"></i>
              Yeni Temsilci Ekle
            </button>
          </div>
        </div>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAffiliateModal">
                      <i class="fas fa-plus"></i>
                      İlk Temsilciyi Ekle
                    </button>
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
<!-- Yeni Affiliate Ekleme Modal -->
<div class="modal modal-blur fade" id="addAffiliateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>
                    Yeni Temsilci Tanımla
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.affiliatemodule.admin.affiliates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Müşteri Seçimi -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">
                                    <i class="fas fa-user me-1"></i>
                                    Müşteri
                                </label>
                                <select class="form-select" name="customer_id" required>
                                    <option value="">Müşteri Seçiniz</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                            ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-hint">Temsilci olacak müşteriyi seçiniz</small>
                            </div>
                        </div>

                        <!-- Üst Affiliate Seçimi -->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-sitemap me-1"></i>
                                    Üst Temsilci
                                </label>
                                <select class="form-select" name="parent_id">
                                    <option value="">Üst Temsilci Yok (Ana Seviye)</option>
                                    @foreach($affiliates as $affiliate)
                                        <option value="{{ $affiliate->id }}">
                                            {{ $affiliate->customer->first_name }} {{ $affiliate->customer->last_name }}
                                            ({{ $affiliate->affiliate_code }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-hint">Opsiyonel: Bu temsilcinin bağlı olacağı üst/sponsor temsilci</small>
                            </div>
                        </div>

                        <!-- Affiliate Kodu -->
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label ">
                                    <i class="fas fa-code me-1"></i>
                                    Temsilci Kodu
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="affiliate_code"
                                           placeholder="Örn: AFF123456" maxlength="16" >
                                    <button class="btn btn-outline-secondary" type="button" onclick="generateAffiliateCode()">
                                        <i class="fas fa-dice me-1"></i>
                                        Oluştur
                                    </button>
                                </div>
                                <small class="form-hint">Benzersiz temsilci kodu</small>
                            </div>
                        </div>






                        <!-- Açıklama -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-comment-alt me-1"></i>
                                    Açıklama
                                </label>
                                <textarea class="form-control" name="description" rows="3"
                                          placeholder="Bu affiliate hakkında notlar..."></textarea>
                                <small class="form-hint">Opsiyonel: Affiliate hakkında ek bilgiler</small>
                            </div>
                        </div>
                    </div>

                    <!-- Bilgi Kutusu -->
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div>
                                <i class="fas fa-info-circle me-2"></i>
                            </div>
                            <div>
                                <h4>Bilgi</h4>
                                <div class="text-muted">
                                    • Temsilci kodu benzersiz olmalıdır<br>
                                    • Üst temsilci seçilirse, seviye otomatik olarak hesaplanır<br>
                                    • Katılma tarihi otomatik olarak şu anki tarih olarak kaydedilir
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        İptal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                       Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Affiliate kodu otomatik oluşturma fonksiyonu
function generateAffiliateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = 'AFF';
    for (let i = 0; i < 4; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.querySelector('input[name="affiliate_code"]').value = result;
}


</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>
@endsection
