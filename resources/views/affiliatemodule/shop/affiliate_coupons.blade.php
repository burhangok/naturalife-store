@extends('layouts.shop-layout')

@php
    if(request('lang')) session(['lang' => request('lang')]);
    $lang = session('lang', 'de');
@endphp
@section('title', $lang == 'tr' ? 'Kuponlarınız' : 'Ihre Gutscheine')


@section('content')

<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <h2 class="page-title">
         {{ $lang == 'tr' ? 'Kuponlarım' : 'Meine Gutscheine' }}
        </h2>
        <div class="text-muted mt-1">{{ $lang == 'tr' ? 'Toplam ' . $cart_rules->count() . ' kupon listeleniyor' : 'Insgesamt ' . $cart_rules->count() . ' Gutscheine aufgelistet' }}</div>
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

  <!-- Kupon Kartları -->
  <div class="row">
    @forelse($cart_rules ?? [] as $cart_rule)
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card border-start border-4 {{ $cart_rule->status ? 'border-success' : 'border-danger' }} h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <h6 class="card-title mb-1 fw-bold text-primary">
                {{ $cart_rule->name }}
              </h6>
              <p class="text-muted me-3">
                {{ config('app.url').'/promo/'.$cart_rule->coupon_code }}
                <button type="button" onclick="copyToClipboard('{{ config('app.url').'/promo/'.$cart_rule->coupon_code }}')"
                    class="btn">
                <i class="fa fa-copy"></i>
            </button>
            </p>
              <small class="text-muted me-3">
                <i class="fas fa-tag me-1"></i>
                {{ $cart_rule->coupon_code ?? ($lang == 'tr' ? 'Kod Yok' : 'Kein Code') }}
              </small>
              @if ($cart_rule->affiliate)


              <small class="text-muted">
                <i class="fas fa-user me-1"></i>
                {{ $cart_rule->affiliate->getFullName() ?? '' }}
              </small>
              @endif
            </div>
            <span class="badge {{ $cart_rule->status ? 'bg-success' : 'bg-danger' }} text-white">
              {{ $cart_rule->status ? ($lang == 'tr' ? 'Aktif' : 'Aktiv') : ($lang == 'tr' ? 'Pasif' : 'Inaktiv') }}
            </span>
          </div>

          <div class="row text-center mb-3">
            <div class="col-6">
              <div class="text-muted small">{{ $lang == 'tr' ? 'İndirim' : 'Rabatt' }}</div>
              @if($cart_rule->action_type == 'by_percent')
                <div class="fw-bold text-success">%{{ $cart_rule->discount_amount }}</div>
              @else
                <div class="fw-bold text-success">₺{{ number_format($cart_rule->discount_amount, 2) }}</div>
              @endif
            </div>
            <div class="col-6">
              <div class="text-muted small">{{ $lang == 'tr' ? 'Sipariş Adeti' : 'Anzahl Bestellungen' }}</div>
              <div class="fw-bold">
                {{ $cart_rule->orders->count() }}
              </div>
            </div>
          </div>

          <div class="mb-3">
            <div class="row">
              <div class="col-4">
                <small class="text-muted">{{ $lang == 'tr' ? 'Komisyon:' : 'Provision:' }}</small>
                <div class="fw-bold">
                  <i class="ti ti-percentage text-primary me-1"></i>
                  {{ $cart_rule->commission_percentage ? $cart_rule->commission_percentage.'%' : '-' }}
                </div>
              </div>
              <div class="col-4">
                <small class="text-muted">{{ $lang == 'tr' ? 'Toplam Sipariş:' : 'Gesamtbestellungen:' }}</small>
                <div class="fw-bold text-success">
                  {{ core()->formatPrice($cart_rule->orders->sum('grand_total')) }}
                </div>
              </div>
              <div class="col-4">
                <small class="text-muted">{{ $lang == 'tr' ? 'Toplam Gelir:' : 'Gesamteinnahmen:' }}</small>
                <div class="fw-bold text-success">
                  {{ core()->formatPrice(4  ) }}
                </div>
              </div>
            </div>
          </div>

          @if($cart_rule->conditions)
          <div class="mb-3">
            <small class="text-muted">{{ $lang == 'tr' ? 'Koşullar:' : 'Bedingungen:' }}</small>
            <div class="small text-info">
              @php
                $conditions = json_decode($cart_rule->conditions, true);
              @endphp
              @if(isset($conditions['cart']['total_quantity']))
                <i class="fas fa-shopping-cart me-1"></i>
                {{ $lang == 'tr' ? 'Min. ' . $conditions['cart']['total_quantity'] . ' ürün' : 'Min. ' . $conditions['cart']['total_quantity'] . ' Produkte' }}<br>
              @endif
              @if(isset($conditions['cart']['base_total']))
                <i class="fas fa-money-bill me-1"></i>
                {{ $lang == 'tr' ? 'Min. ₺' . number_format($conditions['cart']['base_total'], 2) : 'Min. ₺' . number_format($conditions['cart']['base_total'], 2) }}
              @endif
            </div>
          </div>
          @endif
        </div>

        <div class="card-footer bg-transparent border-top-0 pt-0">
          <div class="btn-group w-100" role="group">
            <button type="button"
                    class="btn btn-outline-primary btn-md"
                    onclick="showCouponDetails({{ $cart_rule->id }})"
                    data-bs-toggle="modal"
                    data-bs-target="#couponDetailModal">
              <i class="fas fa-eye me-1"></i>
              {{ $lang == 'tr' ? 'Detaylar' : 'Details' }}
            </button>
            @if($cart_rule->orders && $cart_rule->orders->count() > 0)
            <button type="button"
                    class="btn btn-outline-success btn-md"
                    onclick="showCouponOrders({{ $cart_rule->id }})"
                    data-bs-toggle="modal"
                    data-bs-target="#couponOrdersModal">
              <i class="fas fa-list-alt me-1"></i>
              {{ $lang == 'tr' ? 'Siparişler (' . $cart_rule->orders->count() . ')' : 'Bestellungen (' . $cart_rule->orders->count() . ')' }}
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
          <h5 class="text-muted">{{ $lang == 'tr' ? 'Henüz Kupon Bulunamadı' : 'Noch keine Gutscheine gefunden' }}</h5>
          <p class="text-muted mb-4">{{ $lang == 'tr' ? 'Bu temsilci ile ilişkilendirilmiş herhangi bir kupon kodu bulunmuyor.' : 'Es wurden keine Gutscheincodes gefunden, die mit diesem Vertreter verknüpft sind.' }}</p>

        </div>
      </div>
    </div>
    @endforelse
  </div>
</div>

<!-- Kupon Detay Modal -->
<div class="modal fade" id="couponDetailModal" tabindex="-1" aria-labelledby="couponDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="couponDetailModalLabel">
          <i class="fas fa-ticket-alt me-2"></i>
          {{ $lang == 'tr' ? 'Kupon Detayları' : 'Gutschein Details' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="couponDetailContent">
        <div class="text-center py-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">{{ $lang == 'tr' ? 'Yükleniyor...' : 'Laden...' }}</span>
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
          {{ $lang == 'tr' ? 'Kupon Siparişleri' : 'Gutschein Bestellungen' }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="couponOrdersContent">
        <div class="text-center py-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">{{ $lang == 'tr' ? 'Yükleniyor...' : 'Laden...' }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showCouponDetails(couponId) {
  fetch(`/customer/affiliatemodule/coupon-details/${couponId}`)
    .then(response => response.text())
    .then(html => {
      document.getElementById('couponDetailContent').innerHTML = html;
    })
    .catch(error => {
      const lang = '{{ $lang }}';
      const errorMessage = lang === 'tr' ? 'Detaylar yüklenirken hata oluştu.' : 'Fehler beim Laden der Details.';
      document.getElementById('couponDetailContent').innerHTML =
        `<div class="alert alert-danger">${errorMessage}</div>`;
    });
}

function showCouponOrders(couponId) {
  fetch(`/customer/affiliatemodule/coupon-orders/${couponId}`)
    .then(response => response.text())
    .then(html => {
      document.getElementById('couponOrdersContent').innerHTML = html;
    })
    .catch(error => {
      const lang = '{{ $lang }}';
      const errorMessage = lang === 'tr' ? 'Siparişler yüklenirken hata oluştu.' : 'Fehler beim Laden der Bestellungen.';
      document.getElementById('couponOrdersContent').innerHTML =
        `<div class="alert alert-danger">${errorMessage}</div>`;
    });
}
</script>
<script>
    function copyToClipboard(text) {
        const lang = '{{ $lang }}';
        const successMessage = lang === 'tr' ? 'Link başarıyla kopyalandı!' : 'Link erfolgreich kopiert!';
        const errorMessage = lang === 'tr' ? 'Link kopyalanamadı!' : 'Link konnte nicht kopiert werden!';

        navigator.clipboard.writeText(text).then(() => {
            alert(successMessage);
        }).catch(err => {
            alert(errorMessage);
        });
    }
</script>
@endsection
