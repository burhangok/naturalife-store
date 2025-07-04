@php
$fullName=$affiliate->customer->first_name.' '.$affiliate->customer->last_name;
@endphp
@extends('layouts.admin-layout')

@section('title', $fullName.' - Temsilci Detay Sayfası')

@section('content')


 <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card mb-3">

                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="mb-0"><b>Temsilci:</b> {{$affiliate->affiliate_code .'-'.$fullName}} </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                                <button class="nav-link active text-start py-3 px-4 border-bottom" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button">
                                    <i class="ti ti-user me-2"></i> Genel Bilgiler
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="commission-tab" data-bs-toggle="pill" data-bs-target="#commission" type="button">
                                    <i class="ti ti-percentage me-2"></i> Komisyon Ayarları
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="network-tab" data-bs-toggle="pill" data-bs-target="#network" type="button">
                                    <i class="ti ti-hierarchy me-2"></i> Temsilcilik Sistemi
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab" data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                    <i class="ti ti-currency-euro me-2"></i> Kazanç Geçmişi
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="payments-tab" data-bs-toggle="pill" data-bs-target="#payments" type="button">
                                    <i class="ti ti-credit-card me-2"></i> Ödemeler & Cari
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="coupons-tab" data-bs-toggle="pill" data-bs-target="#coupons" type="button">
                                    <i class="ti ti-ticket me-2"></i> Kuponlar
                                </button>
                                <button class="nav-link text-start py-3 px-4 border-bottom" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button">
                                    <i class="ti ti-shopping-cart me-2"></i> Siparişleri
                                </button>
                                <button class="nav-link text-start py-3 px-4" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button">
                                    <i class="ti ti-settings me-2"></i> Ödeme Tercihleri
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
<div class="card shadow-sm mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fas fa-user-tie fa-2x text-primary me-3"></i>
    <h5 class="mb-0">Temsilci Özeti</h5>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-hashtag text-secondary me-2"></i>
          <strong>Temsilci ID:</strong>
        </span>
        <span class="text-dark">{{ $affiliate->id }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-code-branch text-secondary me-2"></i>
          <strong>Temsilci Kodu:</strong>
        </span>
        <span class="text-dark">{{ $affiliate->affiliate_code }}</span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-user-friends text-secondary me-2"></i>
          <strong>Müşteri ID:</strong>
        </span>
        <span class="text-dark"><a href="{{route('admin.customers.customers.view', $affiliate->customer_id)}}" class="text-blue-500 hover:text-blue-700">{{ $affiliate->customer_id }}</a></span>
      </li>
       <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-users text-secondary me-2"></i>
          <strong>Alt Temsilci Sayısı</strong>
        </span>
        <span class="text-dark">{{ $affiliate->children->count() }}</span>
      </li>
    </ul>
  </div>

</div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Özet Bilgiler</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Toplam Kazanç:</span>
                            <span class="fw-bold">€{{$affiliate->formatted_commission}}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Son Komisyon Aldığı Tarih:</span>
                            <span class="fw-bold">{{$affiliate->last_commission_at === null ? '' : $affiliate->last_commission_at->format('d.m.Y')}}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Alt Temsilci:</span>
                            <span class="fw-bold">{{$downlineAffiliates->count()}}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Genel Bilgiler -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Temsilci Bilgileri</h3>
                                <div>

                                    <span class="badge bg-primary  text-white">Seviye {{$affiliate->level}}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ad Soyad</label>
                                            <input type="text" class="form-control"  value="{{$affiliate->customer->first_name.' '.$affiliate->customer->last_name}}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">E-posta</label>
                                            <input type="email" class="form-control"  value="{{$affiliate->customer->email}}" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Telefon</label>
                                            <input type="tel" class="form-control" value="{{$affiliate->customer->phone}}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Üyelik Tarihi</label>
                                            <input type="text" class="form-control" value="{{ $affiliate->joined_at?->format('d.m.Y H:i') }}"
 disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ülke</label>
                                           <input
  type="text"
  class="form-control"
  value="{{ optional($affiliate->customer->addresses->first())->country }}"
  disabled
>
    </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Üst Temsilci</label>
                                          <input
  type="text"
  class="form-control"
  value="{{
    optional($affiliate->parent)->affiliate_code
    ? optional($affiliate->parent)->id . ' - '.optional($affiliate->parent)->affiliate_code . ' - ' . optional($affiliate->parent->customer)->first_name . ' ' . optional($affiliate->parent->customer)->last_name
    : ''
  }}"
  disabled
>

                                        </div>
                                    </div>
@php

    $addr = $affiliate->customer->addresses->first()
            ?? (object) [
                'address' => null,

                'city'     => null,
                'postcode' => null,
                'state'    => null,
                'country'  => null,
            ];

    // Adres parçalarını bir diziye al, boşları filtrele
    $lines = array_filter([
        $addr->address.', ',
        trim("{$addr->city} , {$addr->postcode } "),
       ', '. $addr->state.', ',
        $addr->country.', ',
    ]);
@endphp
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Adres</label>
                                           <textarea class="form-control" rows="5" style="white-space: pre-wrap;" disabled>
@foreach($lines as $line)
{{ $line }}@if(! $loop->last)
@endif
@endforeach
</textarea>   </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Seviye</label>
                                             <input type="text" class="form-control" value="{{$affiliate->level}}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Durum</label>
                                             <input type="text" class="form-control" value="{{$affiliate->status == 'active' ? "Aktif" : "Pasif"}}" disabled>


                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button type="button" class="btn btn-light me-2">İptal</button>
                                            <button type="submit" class="btn btn-primary">Kaydet</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Referans Linki</h5>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="https://lifenature.eu/ref/{{$affiliate->affiliate_code}}" readonly>

                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Toplam Tıklama: <strong>{{$clicks->count()}}</strong></span>
                                    <span>Dönüşüm Oranı: <strong>{{$conversionRate}}</strong></span>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fas fa-chart-line fa-lg text-primary me-2"></i>
    <h5 class="mb-0">Tıklama & UTM Geçmişi</h5>
  </div>
  <div class="card-body p-0">
    @if($clicks->isEmpty())
      <div class="p-4 text-center text-muted">
        Henüz bir tıklama kaydı yok.
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th><i class="fas fa-calendar-alt me-1"></i>Zaman</th>
              <th><i class="fas fa-globe me-1"></i>IP / Konum</th>
              <th><i class="fas fa-desktop me-1"></i>Cihaz</th>
              <th><i class="fas fa-link me-1"></i>Referer</th>
              <th><i class="fas fa-bullhorn me-1"></i>UTM</th>
              <th><i class="fas fa-check-circle me-1"></i>Dönüşüm</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clicks as $i => $click)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $click->created_at->format('d.m.Y H:i:s') }}</td>
                <td>
                  {{ $click->ip_address }}<br>
                  <small class="text-muted">
                    {{ $click->country ?? '-' }} / {{ $click->city ?? '-' }}
                  </small>
                </td>
                <td>
                  {{ ucfirst($click->device_type) }}<br>
                  <small class="text-muted">
                    {{ $click->browser }} {{ $click->browser_version }}
                  </small>
                </td>
                <td>
                  <a href="{{ $click->referrer_url }}" target="_blank" class="text-truncate d-block" style="max-width:150px;">
                    {{ Str::limit($click->referrer_url, 30) }}
                  </a>
                </td>
                <td>
                  @foreach(['utm_source','utm_medium','utm_campaign','utm_term','utm_content'] as $u)
                    @if($click->$u)
                      <span class="badge bg-secondary bg-opacity-25 text-dark me-1">
                        {{ strtoupper($u) }}: {{ $click->$u }}
                      </span>
                    @endif
                  @endforeach
                </td>
                <td>
                  @if($click->converted)
                    <span class="badge bg-success">Evet</span>
                  @else
                    <span class="badge bg-warning">Hayır</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
                    </div>

                    <!-- Komisyon Ayarları -->
                    <div class="tab-pane fade" id="commission" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Komisyon Oranları</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>        </div>



                                <div class="row">

                                    @foreach ($rules as $rule)


                                    <div class="col-md-6 mb-3">
                                        <div class="card commission-card">
                                            <div class="card-body">
                                                <h6>Seviye {{$rule->level}} Komisyonu</h6>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="{{$rule->percentage}}" disabled>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <small class="text-muted">Sistem genelinde: {{$rule->percentage}}%</small>
                                            </div>
                                        </div>
                                    </div>
  @endforeach

                                    <div class="col-md-6 mb-3">
                                        <div class="card commission-card">
                                            <div class="card-body">
                                                <h6>Özel Komisyon</h6>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="2">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <small class="text-muted">Özel kampanyalar için ek komisyon</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-light me-2">Sıfırla</button>
                                        <button type="button" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="coupons" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Kupon Kodları</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Burada temsilci ile ilişkilendirdiğiniz kupon kodlarını görebilirsiniz.
                                </div>

                                <div class="row">
                                    @forelse($affiliate->cartRules ?? [] as $coupon)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card border-start border-4 {{ $coupon->status ? 'border-success' : 'border-danger' }} h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="card-title mb-1 fw-bold text-primary">
                                                                {{ $coupon->name }}
                                                            </h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-tag me-1"></i>
                                                                {{ $coupon->coupon_code ?? 'Kod Yok' }}
                                                            </small>
                                                        </div>
                                                        <span class="badge {{ $coupon->status ? 'bg-success' : 'bg-danger' }} text-white">
                                                            {{ $coupon->status ? 'Aktif' : 'Pasif' }}
                                                        </span>
                                                    </div>

                                                    <div class="row text-center mb-3">
                                                        <div class="col-6">
                                                            <div class="text-muted small">İndirim</div>
                                                            @if($coupon->action_type == 'by_percent')
                                                                <div class="fw-bold text-success">%{{ $coupon->discount_amount }}</div>
                                                            @else
                                                                <div class="fw-bold text-success">₺{{ number_format($coupon->discount_amount, 2) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-muted small">Toplam Sipariş Adeti</div>
                                                            <div class="fw-bold">
                                                                {{$coupon->orders->count()}}

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted">Komisyon Oranı:</small>
                                                                <div class="medium">
                                                                    <i class="ti ti-percentage text-primary me-1"></i>
                                                                    {{ $coupon->commission_percentage ? $coupon->commission_percentage : '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Toplam Sipariş:</small>
                                                                <div class="small">
                                                                    <i class="fas fa-check text-success me-1"></i>
                                                                    {{ core()->formatPrice($coupon->orders->sum('grand_total')) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($coupon->orders && $coupon->orders->count() > 0)
                                                        <div class="bg-light rounded p-2 mb-3">
                                                            <div class="row text-center">
                                                                <div class="col-6">
                                                                    <small class="text-muted">Toplam Sipariş</small>
                                                                    <div class="fw-bold text-primary">{{ $coupon->orders->count() }}</div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <small class="text-muted">Toplam Tutar</small>
                                                                    <div class="fw-bold text-success">
                                                                        {{ core()->formatPrice($coupon->orders->sum('grand_total')) }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if($coupon->conditions)
                                                        <div class="mb-3">
                                                            <small class="text-muted">Koşullar:</small>
                                                            <div class="small text-info">
                                                                @php
                                                                    $conditions = json_decode($coupon->conditions, true);
                                                                @endphp
                                                                @if(isset($conditions['cart']['total_quantity']))
                                                                    <i class="fas fa-shopping-cart me-1"></i>
                                                                    Min. {{ $conditions['cart']['total_quantity'] }} ürün
                                                                @endif
                                                                @if(isset($conditions['cart']['base_total']))
                                                                    <br><i class="fas fa-money-bill me-1"></i>
                                                                    Min. ₺{{ number_format($conditions['cart']['base_total'], 2) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="card-footer bg-transparent border-top-0 pt-0">
                                                    <div class="btn-group w-100" role="group">
                                                        <button type="button"
                                                                class="btn btn-outline-primary btn-sm"
                                                                onclick="showCouponDetails({{ $coupon->id }})"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#couponDetailModal">
                                                            <i class="fas fa-eye me-1"></i>
                                                            Detaylar
                                                        </button>
                                                        @if($coupon->orders && $coupon->orders->count() > 0)
                                                            <button type="button"
                                                                    class="btn btn-outline-success btn-sm"
                                                                    onclick="showCouponOrders({{ $coupon->id }})"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#couponOrdersModal">
                                                                <i class="fas fa-list-alt me-1"></i>
                                                                Siparişler ({{ $coupon->orders->count() }})
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="card bg-light">
                                                <div class="card-body text-center py-5">
                                                    <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Henüz Kupon Bulunamadı</h5>
                                                    <p class="text-muted mb-4">Bu temsilci ile ilişkilendirilmiş herhangi bir kupon kodu bulunmuyor.</p>
                                                    <a href="{{ route('admin.marketing.promotions.cart_rules.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>
                                                        Yeni Kupon Oluştur
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kupon Detay Modal -->
                    <div class="modal fade" id="couponDetailModal" tabindex="-1" aria-labelledby="couponDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="couponDetailModalLabel">
                                        <i class="fas fa-ticket-alt me-2"></i>
                                        Kupon Detayları
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="couponDetailContent">
                                    <!-- Ajax ile yüklenecek -->
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Yükleniyor...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kupon Siparişleri Modal -->
                    <div class="modal fade" id="couponOrdersModal" tabindex="-1" aria-labelledby="couponOrdersModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="couponOrdersModalLabel">
                                        <i class="fas fa-list-alt me-2"></i>
                                        Kupon Siparişleri
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="couponOrdersContent">
                                    <!-- Ajax ile yüklenecek -->
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Yükleniyor...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    function showCouponDetails(couponId) {
                        // Ajax ile kupon detaylarını yükle
                        fetch(`/admin/affiliatemodule/admin/affiliates/coupon-details/${couponId}`)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('couponDetailContent').innerHTML = html;
                            })
                            .catch(error => {
                                document.getElementById('couponDetailContent').innerHTML =
                                    '<div class="alert alert-danger">Detaylar yüklenirken hata oluştu.</div>';
                            });
                    }

                    function showCouponOrders(couponId) {
                        // Ajax ile kupon siparişlerini yükle
                        fetch(`/admin/affiliatemodule/admin/affiliates/coupon-orders/${couponId}`)
                            .then(response => response.text())
                            .then(html => {
                                document.getElementById('couponOrdersContent').innerHTML = html;
                            })
                            .catch(error => {
                                document.getElementById('couponOrdersContent').innerHTML =
                                    '<div class="alert alert-danger">Siparişler yüklenirken hata oluştu.</div>';
                            });
                    }
                    </script>

                        <!-- Siperişer Ayarları -->
                        <div class="tab-pane fade" id="orders" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Temsilcinin Verdiği Siparişler</h3>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> Bu temsilcinin satın altığı ürünleri ve sipariş bilgilerini görüntüleyebilirsiniz.
                                    </div>



                                    <div class="row">

                                        @if($affiliate->customer->orders->isEmpty())
                                        <div class="p-4 text-center text-muted">
                                          Henüz bir sipariş kaydı yok.
                                        </div>
                                      @else
                                      <h3 class="me-3">Toplam Sepet Tutarı: {{core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))}}</h3>
                                        <div class="table-responsive">
                                          <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                              <tr>
                                                <th>ID</th>
                                                <th></i>Tarih</th>
                                                <th>Sepet Tutarı</th>
                                                <th>Ödeme Yöntemi</th>
                                                <th>Durumu</th>


                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($affiliate->customer->orders as $order)
                                                <tr>
                                                  <td> <a href="{{ route('admin.sales.orders.view', $order->increment_id) }}" class="text-decoration-none" title="Siparişi Görüntüle">
                                                    #{{ $order->id }}</a></td>
                                                    <td>{{$order->created_at->format('d.m.Y H:i')}}</td>
                                                    <td>{{ core()->formatBasePrice($order->grand_total) }}</td>
                                                    <td>{{$order->payment->method_title}}</td>
                                                    <td>{{$order->status}}</td>

                                                </tr>
                                              @endforeach
                                            </tbody>
                                          </table>
                                        </div>
                                      @endif
                 </div>


                                </div>
                            </div>
                        </div>

                    <!-- Ağ Yapısı -->
                    <div class="tab-pane fade" id="network" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                              <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                <li class="nav-item">
                                  <a href="#tab-1" class="nav-link active" data-bs-toggle="tab">Ağ Yapısı</a>
                                </li>
                                <li class="nav-item">
                                  <a href="#tab-2" class="nav-link" data-bs-toggle="tab">Alt Temsilciler</a>
                                </li>

                              </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                  <div class="tab-pane active show" id="tab-1">
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="text-center p-3 border rounded">
                                                    <div class="mb-2">
                                                    <i class="fas fa-user-circle fa-3x text-gray-400"></i>
                                                    </div>
                                                    <strong>{{$fullName}}</strong><br>
                                                    <span class="badge bg-primary text-white">{{$affiliate->level}}</span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mb-2">
                                                <div class="border-start" style="height: 30px; width: 2px;"></div>
                                            </div>

                                            <div class="d-flex justify-content-around">
                                               @foreach ($downlineAffiliates as $downlineAffiliate )


                                                <div class="text-center">
                                                    <div class="border-top" style="width: 100%; height: 20px;"></div>
                                                    <div class="p-2 border rounded">
                                                        <div class="mb-1">

    <i class="fas fa-user-circle fa-3x text-gray-400"></i>

                                                        </div>
                                                        <strong>{{$downlineAffiliate->customer->first_name.' '. $downlineAffiliate->customer->last_name}}</strong><br>
                                                        <span class="badge bg-success level-badge text-white">{{$downlineAffiliate->level}}</span>
                                                    </div>
                                                </div>

     @endforeach
                                            </div>
                                        </div>
                                    </div>


                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Temsilci</th>
                                                <th>Seviye</th>
                                                <th>Kayıt Tarihi</th>
                                                <th>Alt Üye</th>
                                                <th>Toplam Siparişi</th>
                                                <th>Bayilerinin Satış Tutarı</th>
                                                <th>Kazancı</th>
                                                <th>Ağının Kazandırdığı Komisyon</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($downlineAffiliates as $downlineAffiliate)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <div class="fw-bold">
                                                                {{ $downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $downlineAffiliate->affiliate_code }}</small>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-primary  text-white">{{ $downlineAffiliate->level }}</span>
                                                    </td>
                                                    <td>{{ $downlineAffiliate->joined_at?->format('d.m.Y') }}</td>
                                                    <td>{{ $downlineAffiliate->children->count() }}</td>
                                                    <td> {{$downlineAffiliate->customer->orders->count()}} Adet, {{ core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}
                                                    </td>
                                                    <td>
                                                       €{{ number_format(array_sum($downlineAffiliate->getDescendantOrderTotalsPerLevel()), 2) }}
                                                    </td>

<td>  €{{ number_format($downlineAffiliate->getTotalEarningsAttribute(), 2)  }}
</td>

                                                    <td class="text-success fw-bold">
                                                        €{{ number_format($affiliate->getCommissionEarnedFrom($downlineAffiliate), 2) }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        Toplam {{$downlineAffiliates->count()}} kayıt gösteriliyor
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-primary btn-md">
                                            <i class="fas fa-plus me-1"></i> Alt Temsilci Ekle
                                        </button>
                                    </div>
                                </div>
                                  </div>
                                  <div class="tab-pane" id="tab-2">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Temsilci Kodu</th>
                                                    <th>Ad Soyad</th>
                                                    <th>Seviye</th>


                                                    <th>Alt Üye Sayısı</th>
                                                    <th>Toplam Sipariş</th>
                                                    <th>Toplam Kazancı</th>
                                                    <th>Kazanılan Komisyon</th>

                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($downlineAffiliates as $downlineAffiliate)
                                                    <tr>
                                                        <td><a href="{{ route('admin.affiliatemodule.admin.affiliates.edit', $downlineAffiliate->id) }}">
                                                            {{ $downlineAffiliate->affiliate_code }}</a></td>

                                                        <td>{{ $downlineAffiliate->customer->getNameAttribute() }}</td>

                                                        <td><span class="badge bg-blue-lt">Seviye {{ $downlineAffiliate->level }}</span></td>
                                                        <td>{{$downlineAffiliate->children->count()}}</td>
                                                        <td>{{ core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced')) }}</td>

                                                        <td>
                                                            €{{ number_format($downlineAffiliate->commissions()->sum('amount'), 2, ',', '.') }}
                                                        </td>
                                                        <td> € {{number_format($downlineAffiliate->generatedCommissions()->sum('amount'),2.2)}}</td>



                                                        <td>
                                                            <a href="{{ route('admin.affiliatemodule.admin.affiliates.edit', $downlineAffiliate->id) }}"
                                                               class="btn btn-md btn-primary">
                                                               <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">Alt affiliate bulunamadı</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>

                    </div>

                    <div class="tab-pane fade" id="payments" role="tabpanel">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Temsilci Ödemeleri</h3>
                                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                    <i class="fas fa-plus"></i> Yeni Ödeme
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- Özet Kartları -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h4 class="card-title">{{ core()->formatPrice($affiliate->total_earnings) }}</h4>
                                                <p class="card-text">Toplam Kazanç</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h4 class="card-title">{{core()->formatPrice($affiliate->total_paid_commission) }}</h4>
                                                <p class="card-text">Ödenen Tutar</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h4 class="card-title">{{ core()->formatPrice($affiliate->current_account_balance) }}</h4>
                                                <p class="card-text">Kalan Bakiye</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <h4 class="card-title">{{ $affiliate->payments->count() }}</h4>
                                                <p class="card-text">Toplam Ödeme</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($affiliate->payments()->exists())


                                <!-- Ödeme Geçmişi Tablosu -->
                                <div class="table-responsive">
                                    <table class="table table-striped dataListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tutar</th>
                                                <th>Ödeme Yöntemi</th>
                                                <th>Transactıon ID</th>
                                                <th>Tarih</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($affiliate->payments()->latest()->get() as $payment)
                                            <tr>
                                                <td>#{{ $payment->id }}</td>
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

                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                                        <p>Henüz ödeme kaydı bulunmuyor.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                <!-- Son Ödeme Bilgisi -->
                                @if($affiliate->getLastPayment())
                                <div class="mt-4">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">Son Ödeme Bilgisi</h6>
                                        <p class="mb-0">
                                            <strong>Tutar:</strong> {{ $affiliate->getLastPayment()->getFormattedAmount() }} |
                                            <strong>Tarih:</strong> {{ $affiliate->getLastPayment()->created_at->format('d.m.Y H:i') }} |
                                            <strong>Ödeme Yöntemi:</strong>
                                            <span class="badge bg-info text-white">
                                                {{ $paymentMethods[$affiliate->getLastPayment()->payment_method] ?? $affiliate->getLastPayment()->payment_method }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    <style>
                    .avatar-sm {
                        width: 32px;
                        height: 32px;
                    }

                    .avatar-title {
                        width: 100%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 14px;
                        font-weight: 600;
                    }

                    .table th {
                        font-weight: 600;
                        font-size: 13px;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    .card {
                        border: none;
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                    }

                    .btn-group-sm > .btn, .btn-sm {
                        padding: 0.25rem 0.5rem;
                        font-size: 0.775rem;
                    }
                    </style>



                    <style>
                    .avatar-sm {
                        width: 32px;
                        height: 32px;
                    }

                    .avatar-title {
                        width: 100%;
                        height: 100%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 14px;
                        font-weight: 600;
                    }

                    .table th {
                        font-weight: 600;
                        font-size: 13px;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    .card {
                        border: none;
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                    }

                    .btn-group-sm > .btn, .btn-sm {
                        padding: 0.25rem 0.5rem;
                        font-size: 0.775rem;
                    }
                    </style>
                    <!-- Kazanç Geçmişi -->
                    <div class="tab-pane fade" id="earnings" role="tabpanel">

<div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Kazanç Geçmişi</h3>

                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-1">Toplam Kazanç</h6>
                                                    <h3 class="mb-0">€{{ number_format($affiliate->commissions->sum('amount'), 2) }}</h3>



                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-1">Bu Ayki Kazanç</h6>
                                                    <h3 class="mb-0">  €{{ number_format($affiliate->getThisMonthEarningsAttribute(), 2) }}</h3>



                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-1">Toplam Alınan Ödeme</h6>
                                                    <h3 class="mb-0">  €{{ number_format($affiliate->getTotalPaidCommissionAttribute(), 2) }}</h3>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tarih</th>
                                                    <th>Sipariş No</th>
                                                    <th>Kaynak</th>
                                                    <th>Seviye</th>
                                                    <th>Tutar</th>
                                                     <th>Açıklama</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($affiliate->commissions as $commission)
                                                    <tr>
                                                        <td>{{ $commission->created_at->format('d.m.Y') }}</td>
                                                        <td> <a href="{{ route('admin.sales.orders.view', $orderId ?? '') }}" class="text-decoration-none" title="Siparişi Görüntüle">
                                                            <i class="fas fa-external-link-alt text-primary fs-5"></i>  {{ $commission->order_id ?? '-' }}</a></td>
                                                        <td>
                                                            @if ($commission->order->coupon_code)

                                                            ( {{$commission->order->coupon_code}} Kupon Satış Komisyonu)
                                                            @else
                                                            @if($commission->from_affiliate_id)
                                                                {{ $commission->fromAffiliate->affiliate_code.' - '. $commission->fromAffiliate->customer->first_name.' ' .$commission->fromAffiliate->customer->last_name ?? 'Bilinmiyor' }}
                                                                @if($commission->level > 1)
                                                                    (Alt Bayi Siparişi)
                                                                  @else
                                                                  (Kendi Siparişi)
                                                                @endif
                                                            @else
                                                                Direkt Satış
                                                            @endif
                                                            @endif
                                                        </td>
                                                        <td>@if ($commission->order->coupon_code) <span class="badge bg-danger-lt">Kupon Satış Komisyonu</span>@else<span class="badge bg-blue-lt">Seviye {{ $commission->level }}</span>@endif</td>

                                                        <td>€{{ number_format($commission->amount, 2, ',', '.') }}</td>
                                                        <td>{{ $commission->description ?? '-' }}</td>


                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-3">Kayıt bulunamadı</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                         <!-- Ayarlar -->
                    <div class="tab-pane fade" id="settings" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">Ödeme Bilgileri</h3>
                            </div>
                            <div class="card-body">

                                @if ($affiliate->paymentMethod)


                                <form >
                                    <!-- Temel Ödeme Tercihleri -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label required">Tercih Edilen Ödeme Yöntemi</label>
                                            <select class="form-select" id="paymentMethod" name="payment_method" disabled>
                                                <option value="">Seçiniz...</option>
                                                <option value="sepa" {{ ($affiliate->paymentMethod->payment_method ?? 'sepa') == 'sepa' ? 'selected' : '' }}>SEPA Transfer (Avrupa)</option>
                                                <option value="bank" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'bank' ? 'selected' : '' }}>Uluslararası Banka Transferi</option>
                                                <option value="paypal" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                                <option value="wise" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'wise' ? 'selected' : '' }}>Wise (eski TransferWise)</option>
                                                <option value="revolut" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'revolut' ? 'selected' : '' }}>Revolut Business</option>
                                                <option value="stripe" {{ ($affiliate->paymentMethod->payment_method ?? '') == 'stripe' ? 'selected' : '' }}>Stripe Connect</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Para Birimi</label>
                                            <select class="form-select" name="currency" disabled>
                                                <option value="EUR" {{ ($affiliate->paymentMethod->currency ?? 'EUR') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                                <option value="USD" {{ ($affiliate->paymentMethod->currency ?? '') == 'USD' ? 'selected' : '' }}>Amerikan Doları (USD)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Minimum Ödeme Tutarı -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Vergi Durumu</label>
                                            <select class="form-select" name="tax_status" disabled>
                                                <option value="individual" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'individual' ? 'selected' : '' }}>Bireysel</option>
                                                <option value="company" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'company' ? 'selected' : '' }}>Şirket</option>
                                                <option value="freelancer" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'freelancer' ? 'selected' : '' }}>Serbest Meslek</option>
                                                <option value="vat_registered" {{ ($affiliate->paymentMethod->tax_status ?? '') == 'vat_registered' ? 'selected' : '' }}>KDV Kayıtlı</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- SEPA / Banka Bilgileri -->
                                    <div class="card mb-4" id="bankDetails">
                                        <div class="card-header">
                                            <h4 class="card-title">Banka / SEPA Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">Hesap Sahibi Adı</label>
                                                    <input type="text" class="form-control" name="account_holder_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->account_holder_name ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Banka Adı</label>
                                                    <input type="text" class="form-control" name="bank_name" placeholder="Deutsche Bank AG" value="{{ $affiliate->paymentMethod->bank_name ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">IBAN</label>
                                                    <input type="text" class="form-control" name="iban" placeholder="DE89 3704 0044 0532 0130 00" value="{{ $affiliate->paymentMethod->iban ?? '' }}" disabled>
                                                    <small class="form-hint">Almanya, Fransa, Hollanda IBAN formatı desteklenir</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">BIC/SWIFT Kodu</label>
                                                    <input type="text" class="form-control" name="bic_swift_code" placeholder="DEUTDEDBXXX" value="{{ $affiliate->paymentMethod->bic_swift_code ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Banka Adresi</label>
                                                    <textarea class="form-control" name="bank_address" rows="2" placeholder="Taunusanlage 12, 60325 Frankfurt am Main, Deutschland" disabled>{{ $affiliate->paymentMethod->bank_address ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PayPal Bilgileri -->
                                    <div class="card mb-4" id="paypalDetails" style="display: none;">
                                        <div class="card-header">
                                            <h4 class="card-title">PayPal Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">PayPal E-posta Adresi</label>
                                                    <input type="email" class="form-control" name="paypal_email" placeholder="hans.mueller@example.com" value="{{ $affiliate->paymentMethod->paypal_email ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">PayPal İş Hesabı ID</label>
                                                    <input type="text" class="form-control" name="paypal_merchant_id" placeholder="PayPal Merchant ID (opsiyonel)" value="{{ $affiliate->paymentMethod->paypal_merchant_id ?? '' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Wise/Revolut Bilgileri -->
                                    <div class="card mb-4" id="digitalWalletDetails" style="display: none;">
                                        <div class="card-header">
                                            <h4 class="card-title">Dijital Cüzdan Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">E-posta Adresi</label>
                                                    <input type="email" class="form-control" name="digital_wallet_email" placeholder="hesap@example.com" value="{{ $affiliate->paymentMethod->digital_wallet_email ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Hesap ID/Numarası</label>
                                                    <input type="text" class="form-control" name="digital_wallet_account_id" placeholder="Wise/Revolut hesap numarası" value="{{ $affiliate->paymentMethod->digital_wallet_account_id ?? '' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vergi ve Kimlik Bilgileri -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Vergi ve Kimlik Bilgileri</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Vergi Numarası</label>
                                                    <input type="text" class="form-control" name="tax_number" placeholder="DE123456789" value="{{ $affiliate->paymentMethod->tax_number ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">KDV Numarası</label>
                                                    <input type="text" class="form-control" name="vat_number" placeholder="DE987654321" value="{{ $affiliate->paymentMethod->vat_number ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ülke</label>
                                                    <select class="form-select" name="tax_country" disabled>
                                                        <option value="DE" {{ ($affiliate->paymentMethod->tax_country ?? 'DE') == 'DE' ? 'selected' : '' }}>Almanya</option>
                                                        <option value="FR" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'FR' ? 'selected' : '' }}>Fransa</option>
                                                        <option value="NL" {{ ($affiliate->paymentMethod->tax_country ?? '') == 'NL' ? 'selected' : '' }}>Hollanda</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Adı (varsa)</label>
                                                    <input type="text" class="form-control" name="company_name" placeholder="Mueller Marketing GmbH" value="{{ $affiliate->paymentMethod->company_name ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Kayıt Numarası</label>
                                                    <input type="text" class="form-control" name="company_registration_number" placeholder="HRB 123456" value="{{ $affiliate->paymentMethod->company_registration_number ?? '' }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fatura Adresi -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Fatura Adresi</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label required">Ad Soyad/Şirket</label>
                                                    <input type="text" class="form-control" name="billing_name" placeholder="Hans Mueller" value="{{ $affiliate->paymentMethod->billing_name ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Cadde/Sokak</label>
                                                    <input type="text" class="form-control" name="billing_street" placeholder="Muster Straße 123" value="{{ $affiliate->paymentMethod->billing_street ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Posta Kodu</label>
                                                    <input type="text" class="form-control" name="billing_postal_code" placeholder="10115" value="{{ $affiliate->paymentMethod->billing_postal_code ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Şehir</label>
                                                    <input type="text" class="form-control" name="billing_city" placeholder="Berlin" value="{{ $affiliate->paymentMethod->billing_city ?? '' }}" disabled>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Ülke</label>
                                                    <select class="form-select" name="billing_country" disabled>
                                                        <option value="DE" {{ ($affiliate->paymentMethod->billing_country ?? 'DE') == 'DE' ? 'selected' : '' }}>Almanya</option>
                                                        <option value="FR" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'FR' ? 'selected' : '' }}>Fransa</option>
                                                        <option value="NL" {{ ($affiliate->paymentMethod->billing_country ?? '') == 'NL' ? 'selected' : '' }}>Hollanda</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ödeme Koşulları ve Notlar -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Ödeme Birimi ve Notlar</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Özel Notlar</label>
                                                    <textarea class="form-control" name="special_notes" rows="3" placeholder="Ödeme ile ilgili özel notlar, koşullar veya talimatlar..." disabled>{{ $affiliate->paymentMethod->special_notes ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kaydet Butonu -->
                                    <div class="text-end">

                                    </div>
                                </form>
@else
<div class="p-4 text-center text-muted">
   Temsicilciye ait ödeme tercihleri kaydı bulunmamıştır.
  </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab'lar arası geçiş için aktif tab'ı kaydetme
    $(document).ready(function() {
        // URL'deki hash'e göre tab seçme
        var hash = window.location.hash;
        if (hash) {
            $('.nav-tabs a[href="' + hash + '"]').tab('show');
        }

        // Tab değişiminde URL hash'ini güncelleme
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            history.pushState(null, null, $(e.target).attr('href'));
        });
    });
</script>


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

                                <input type="text" name="affiliate_id" id="affiliate_id" value="{{$affiliate->id}}" hidden>

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

<script>
    // Ödeme yöntemi değiştiğinde ilgili alanları göster/gizle
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const value = this.value;
        const bankDetails = document.getElementById('bankDetails');
        const paypalDetails = document.getElementById('paypalDetails');
        const digitalWalletDetails = document.getElementById('digitalWalletDetails');

        // Tüm detay alanlarını gizle
        bankDetails.style.display = 'none';
        paypalDetails.style.display = 'none';
        digitalWalletDetails.style.display = 'none';

        // Seçilen yönteme göre ilgili alanı göster
        if (value === 'sepa' || value === 'bank') {
            bankDetails.style.display = 'block';
        } else if (value === 'paypal') {
            paypalDetails.style.display = 'block';
        } else if (value === 'wise' || value === 'revolut') {
            digitalWalletDetails.style.display = 'block';
        }
    });

    // Sayfa yüklendiğinde varsayılan seçimi tetikle
    document.getElementById('paymentMethod').dispatchEvent(new Event('change'));
</script>
@endsection
