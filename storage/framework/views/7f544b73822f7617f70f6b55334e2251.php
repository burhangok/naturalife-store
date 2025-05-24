<?php
$fullName=$affiliate->customer->first_name.' '.$affiliate->customer->last_name;
?>


<?php $__env->startSection('title', $fullName.' - Temsilci Detay Sayfası'); ?>

<?php $__env->startSection('content'); ?>


 <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="mb-0"><b>Temsilci:</b> <?php echo e($affiliate->affiliate_code .'-'.$fullName); ?> </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                            <button class="nav-link active text-start py-3 px-4 border-bottom" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button">
                                <i class="fas fa-user me-2"></i> Genel Bilgiler
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="commission-tab" data-bs-toggle="pill" data-bs-target="#commission" type="button">
                                <i class="fas fa-percentage me-2"></i> Komisyon Ayarları
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="network-tab" data-bs-toggle="pill" data-bs-target="#network" type="button">
                                <i class="fas fa-sitemap me-2"></i> Temsilcilik Sistemi
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab" data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> Kazanç Geçmişi
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab" data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> Ödemeler & Cari
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> Siparişler
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="settings-tab" data-bs-toggle="pill" data-bs-target="#settings" type="button">
                                <i class="fas fa-cog me-2"></i> Ödeme Tercihleri
                            </button>
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
        <span class="text-dark"><?php echo e($affiliate->id); ?></span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-code-branch text-secondary me-2"></i>
          <strong>Temsilci Kodu:</strong>
        </span>
        <span class="text-dark"><?php echo e($affiliate->affiliate_code); ?></span>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-user-friends text-secondary me-2"></i>
          <strong>Müşteri ID:</strong>
        </span>
        <span class="text-dark"><a href="<?php echo e(route('admin.customers.customers.view', $affiliate->customer_id)); ?>" class="text-blue-500 hover:text-blue-700"><?php echo e($affiliate->customer_id); ?></a></span>
      </li>
       <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>
          <i class="fas fa-users text-secondary me-2"></i>
          <strong>Alt Temsilci Sayısı</strong>
        </span>
        <span class="text-dark"><?php echo e($affiliate->children->count()); ?></span>
      </li>
    </ul>
  </div>

</div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-3">Özet Bilgiler</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Toplam Kazanç:</span>
                            <span class="fw-bold">€<?php echo e($affiliate->formatted_commission); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Son Komisyon Aldığı Tarih:</span>
                            <span class="fw-bold"><?php echo e($affiliate->last_commission_at === null ? '' : $affiliate->last_commission_at->format('d.m.Y')); ?></span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Alt Temsilci:</span>
                            <span class="fw-bold"><?php echo e($downlineAffiliates->count()); ?></span>
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

                                    <span class="badge bg-primary  text-white">Seviye <?php echo e($affiliate->level); ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ad Soyad</label>
                                            <input type="text" class="form-control"  value="<?php echo e($affiliate->customer->first_name.' '.$affiliate->customer->last_name); ?>" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">E-posta</label>
                                            <input type="email" class="form-control"  value="<?php echo e($affiliate->customer->email); ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Telefon</label>
                                            <input type="tel" class="form-control" value="<?php echo e($affiliate->customer->phone); ?>" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Üyelik Tarihi</label>
                                            <input type="text" class="form-control" value="<?php echo e($affiliate->joined_at?->format('d.m.Y H:i')); ?>"
 disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Ülke</label>
                                           <input
  type="text"
  class="form-control"
  value="<?php echo e(optional($affiliate->customer->addresses->first())->country); ?>"
  disabled
>
    </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Üst Temsilci</label>
                                          <input
  type="text"
  class="form-control"
  value="<?php echo e(optional($affiliate->parent)->affiliate_code
    ? optional($affiliate->parent)->id . ' - '.optional($affiliate->parent)->affiliate_code . ' - ' . optional($affiliate->parent->customer)->first_name . ' ' . optional($affiliate->parent->customer)->last_name
    : ''); ?>"
  disabled
>

                                        </div>
                                    </div>
<?php

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
?>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Adres</label>
                                           <textarea class="form-control" rows="5" style="white-space: pre-wrap;" disabled>
<?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($line); ?><?php if(! $loop->last): ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</textarea>   </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Seviye</label>
                                             <input type="text" class="form-control" value="<?php echo e($affiliate->level); ?>" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Durum</label>
                                             <input type="text" class="form-control" value="<?php echo e($affiliate->status == 'active' ? "Aktif" : "Pasif"); ?>" disabled>


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
                                    <input type="text" class="form-control" value="https://lifenature.eu/ref/<?php echo e($affiliate->affiliate_code); ?>" readonly>

                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Toplam Tıklama: <strong><?php echo e($clicks->count()); ?></strong></span>
                                    <span>Dönüşüm Oranı: <strong><?php echo e($conversionRate); ?></strong></span>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
  <div class="card-header d-flex align-items-center">
    <i class="fas fa-chart-line fa-lg text-primary me-2"></i>
    <h5 class="mb-0">Tıklama & UTM Geçmişi</h5>
  </div>
  <div class="card-body p-0">
    <?php if($clicks->isEmpty()): ?>
      <div class="p-4 text-center text-muted">
        Henüz bir tıklama kaydı yok.
      </div>
    <?php else: ?>
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
            <?php $__currentLoopData = $clicks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $click): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($i + 1); ?></td>
                <td><?php echo e($click->created_at->format('d.m.Y H:i:s')); ?></td>
                <td>
                  <?php echo e($click->ip_address); ?><br>
                  <small class="text-muted">
                    <?php echo e($click->country ?? '-'); ?> / <?php echo e($click->city ?? '-'); ?>

                  </small>
                </td>
                <td>
                  <?php echo e(ucfirst($click->device_type)); ?><br>
                  <small class="text-muted">
                    <?php echo e($click->browser); ?> <?php echo e($click->browser_version); ?>

                  </small>
                </td>
                <td>
                  <a href="<?php echo e($click->referrer_url); ?>" target="_blank" class="text-truncate d-block" style="max-width:150px;">
                    <?php echo e(Str::limit($click->referrer_url, 30)); ?>

                  </a>
                </td>
                <td>
                  <?php $__currentLoopData = ['utm_source','utm_medium','utm_campaign','utm_term','utm_content']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($click->$u): ?>
                      <span class="badge bg-secondary bg-opacity-25 text-dark me-1">
                        <?php echo e(strtoupper($u)); ?>: <?php echo e($click->$u); ?>

                      </span>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td>
                  <?php if($click->converted): ?>
                    <span class="badge bg-success">Evet</span>
                  <?php else: ?>
                    <span class="badge bg-warning">Hayır</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
                    </div>

                    <!-- Komisyon Ayarları -->
                    <div class="tab-pane fade" id="commission" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Komisyon Yapılandırması</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Burada temsilci için özel komisyon oranları ayarlayabilirsiniz. Değişiklik yapılmadığında sistem genelindeki oranlar geçerli olacaktır.
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="useCustom">
                                    <label class="form-check-label" for="useCustom">
                                        Özel komisyon oranlarını kullan
                                    </label>
                                </div>

                                <div class="row">

                                    <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <div class="col-md-6 mb-3">
                                        <div class="card commission-card">
                                            <div class="card-body">
                                                <h6>Seviye <?php echo e($rule->level); ?> Komisyonu</h6>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="<?php echo e($rule->percentage); ?>" disabled>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <small class="text-muted">Sistem genelinde: <?php echo e($rule->percentage); ?>%</small>
                                            </div>
                                        </div>
                                    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

                        <!-- Komisyon Ayarları -->
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

                                        <?php if($affiliate->customer->orders->isEmpty()): ?>
                                        <div class="p-4 text-center text-muted">
                                          Henüz bir sipariş kaydı yok.
                                        </div>
                                      <?php else: ?>
                                      <h3 class="me-3">Toplam Sepet Tutarı: <?php echo e(core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))); ?></h3>
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
                                              <?php $__currentLoopData = $affiliate->customer->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                  <td> <a href="<?php echo e(route('admin.sales.orders.view', $order->increment_id)); ?>" class="text-decoration-none" title="Siparişi Görüntüle">
                                                    #<?php echo e($order->id); ?></a></td>
                                                    <td><?php echo e($order->created_at->format('d.m.Y H:i')); ?></td>
                                                    <td><?php echo e(core()->formatBasePrice($order->grand_total)); ?></td>
                                                    <td><?php echo e($order->payment->method_title); ?></td>
                                                    <td><?php echo e($order->status); ?></td>

                                                </tr>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      <?php endif; ?>
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
                                                    <strong><?php echo e($fullName); ?></strong><br>
                                                    <span class="badge bg-primary text-white"><?php echo e($affiliate->level); ?></span>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mb-2">
                                                <div class="border-start" style="height: 30px; width: 2px;"></div>
                                            </div>

                                            <div class="d-flex justify-content-around">
                                               <?php $__currentLoopData = $downlineAffiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $downlineAffiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                                <div class="text-center">
                                                    <div class="border-top" style="width: 100%; height: 20px;"></div>
                                                    <div class="p-2 border rounded">
                                                        <div class="mb-1">

    <i class="fas fa-user-circle fa-3x text-gray-400"></i>

                                                        </div>
                                                        <strong><?php echo e($downlineAffiliate->customer->first_name.' '. $downlineAffiliate->customer->last_name); ?></strong><br>
                                                        <span class="badge bg-success level-badge text-white"><?php echo e($downlineAffiliate->level); ?></span>
                                                    </div>
                                                </div>

     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>


                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                  <th> Id</th>
                                                  <th>Temsilci Kodu</th>
                                                <th>Temsilci</th>
                                                <th>Seviye</th>
                                                <th>Kayıt Tarihi</th>
                                                <th>Alt Üye Sayısı</th>
                                                <th>Kazanılan Komisyon</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $downlineAffiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $downlineAffiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>
                                                         <td><?php echo e($downlineAffiliate->id); ?></td>
                  <td><?php echo e($downlineAffiliate->affiliate_code); ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">

                                                        <div>
                                                           <?php echo e($downlineAffiliate->customer->first_name.' '. $downlineAffiliate->customer->last_name); ?><br>
                                                            <small class="text-muted"><?php echo e($downlineAffiliate->customer->email); ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success text-white"><?php echo e($downlineAffiliate->level); ?></span></td>
                                                <td><?php echo e($downlineAffiliate->joined_at?->format('d.m.Y H:i')); ?></td>
                                                <td><?php echo e($downlineAffiliate->children->count()); ?></td>
                                                <td> € <?php echo e(number_format($downlineAffiliate->generatedCommissions()->sum('amount'),2.2)); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.affiliatemodule.admin.affiliates.edit', $downlineAffiliate->id)); ?>" class="btn btn-icon btn-outline-primary me-1">
                                                        <i class="fas fa-edit"></i>
                                    </a>
                                                </td>
                                            </tr>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        Toplam <?php echo e($downlineAffiliates->count()); ?> kayıt gösteriliyor
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
                                                    <th>Toplam Kazanç</th>
                                                    <th>Kazanılan Komisyon</th>

                                                    <th>İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $downlineAffiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $downlineAffiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><a href="<?php echo e(route('admin.affiliatemodule.admin.affiliates.edit', $downlineAffiliate->id)); ?>">
                                                            <?php echo e($downlineAffiliate->affiliate_code); ?></a></td>

                                                        <td><?php echo e($downlineAffiliate->customer->getNameAttribute()); ?></td>

                                                        <td><span class="badge bg-blue-lt">Seviye <?php echo e($downlineAffiliate->level); ?></span></td>
                                                        <td><?php echo e($downlineAffiliate->children->count()); ?></td>
                                                        <td><?php echo e(core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))); ?></td>

                                                        <td>
                                                            €<?php echo e(number_format($downlineAffiliate->commissions()->sum('amount'), 2, ',', '.')); ?>

                                                        </td>
                                                        <td> € <?php echo e(number_format($downlineAffiliate->generatedCommissions()->sum('amount'),2.2)); ?></td>



                                                        <td>
                                                            <a href="<?php echo e(route('admin.affiliatemodule.admin.affiliates.edit', $downlineAffiliate->id)); ?>"
                                                               class="btn btn-md btn-primary">
                                                               <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">Alt affiliate bulunamadı</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>

                    </div>

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
                                                    <h3 class="mb-0">€<?php echo e(number_format($total, 2, ',', '.')); ?></h3>

                                                        <small class="text-success">
                                                            <i class="fas fa-arrow-up me-1"></i>
                                                           10% geçen aya göre
                                                        </small>



                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-1">Bu Ayki Kazanç</h6>
                                                    <h3 class="mb-0">€<?php echo e(number_format($total, 2, ',', '.')); ?></h3>

                                                        <small class="text-success">
                                                            <i class="fas fa-arrow-up me-1"></i>
                                                           32% geçen haftaya göre
                                                        </small>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h6 class="text-muted mb-1">Toplam Çekilen</h6>
                                                    <h3 class="mb-0">€20000</h3>

                                                        <small class="text-muted">
                                                            Son alınan hakediş: <?php echo e($affiliate->last_commission_at === null ? '' : $affiliate->last_commission_at->format('d.m.Y')); ?>

                                                        </small>

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
                                                <?php $__empty_1 = true; $__currentLoopData = $affiliate->commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($commission->created_at->format('d.m.Y')); ?></td>
                                                        <td><?php echo e($commission->order_id ?? '-'); ?></td>
                                                        <td>
                                                            <?php if($commission->from_affiliate_id): ?>
                                                                <?php echo e($commission->fromAffiliate->affiliate_code.' - '. $commission->fromAffiliate->customer->first_name.' ' .$commission->fromAffiliate->customer->last_name ?? 'Bilinmiyor'); ?>

                                                                <?php if($commission->level > 1): ?>
                                                                    (Alt bayi)
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                Direkt Satış
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>Seviye <?php echo e($commission->level); ?></td>
                                                        <td>€<?php echo e(number_format($commission->amount, 2, ',', '.')); ?></td>
                                                        <td><?php echo e($commission->description ?? '-'); ?></td>


                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center py-3">Kayıt bulunamadı</td>
                                                    </tr>
                                                <?php endif; ?>
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
                                <form>
                                    <!-- Temel Ödeme Tercihleri -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label required">Tercih Edilen Ödeme Yöntemi</label>
                                            <select class="form-select" id="paymentMethod" required>
                                                <option value="">Seçiniz...</option>
                                                <option value="sepa" selected>SEPA Transfer (Avrupa)</option>
                                                <option value="bank">Uluslararası Banka Transferi</option>
                                                <option value="paypal">PayPal</option>
                                                <option value="wise">Wise (eski TransferWise)</option>
                                                <option value="revolut">Revolut Business</option>
                                                <option value="stripe">Stripe Connect</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Ödeme Sıklığı</label>
                                            <select class="form-select" required>
                                                <option value="weekly">Haftalık</option>
                                                <option value="biweekly">İki Haftada Bir</option>
                                                <option value="monthly" selected>Aylık</option>
                                                <option value="quarterly">Üç Aylık</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Minimum Ödeme Tutarı -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Minimum Ödeme Tutarı</label>
                                            <div class="input-group">
                                                <span class="input-group-text">€</span>
                                                <input type="number" class="form-control" value="50" min="1" step="0.01">
                                                <span class="input-group-text">EUR</span>
                                            </div>
                                            <small class="form-hint">Bu tutarın altındaki komisyonlar sonraki ödemeye aktarılır</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Vergi Durumu</label>
                                            <select class="form-select">
                                                <option value="individual">Bireysel</option>
                                                <option value="company">Şirket</option>
                                                <option value="freelancer">Serbest Meslek</option>
                                                <option value="vat_registered">KDV Kayıtlı</option>
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
                                                    <input type="text" class="form-control" placeholder="Hans Mueller" value="Hans Mueller" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Banka Adı</label>
                                                    <input type="text" class="form-control" placeholder="Deutsche Bank AG" value="Deutsche Bank AG" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">IBAN</label>
                                                    <input type="text" class="form-control" placeholder="DE89 3704 0044 0532 0130 00" value="DE89 3704 0044 0532 0130 00" required>
                                                    <small class="form-hint">Almanya, Fransa, Hollanda IBAN formatı desteklenir</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">BIC/SWIFT Kodu</label>
                                                    <input type="text" class="form-control" placeholder="DEUTDEDBXXX" value="DEUTDEDBXXX" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Banka Adresi</label>
                                                    <textarea class="form-control" rows="2" placeholder="Taunusanlage 12, 60325 Frankfurt am Main, Deutschland">Taunusanlage 12, 60325 Frankfurt am Main, Deutschland</textarea>
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
                                                    <input type="email" class="form-control" placeholder="hans.mueller@example.com" value="hans.mueller@example.com">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">PayPal İş Hesabı ID</label>
                                                    <input type="text" class="form-control" placeholder="PayPal Merchant ID (opsiyonel)">
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
                                                    <input type="email" class="form-control" placeholder="hesap@example.com">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Hesap ID/Numarası</label>
                                                    <input type="text" class="form-control" placeholder="Wise/Revolut hesap numarası">
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
                                                    <input type="text" class="form-control" placeholder="DE123456789" value="DE123456789">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">KDV Numarası</label>
                                                    <input type="text" class="form-control" placeholder="DE987654321" value="DE987654321">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Ülke</label>
                                                    <select class="form-select">
                                                        <option value="DE" selected>Almanya</option>
                                                        <option value="FR">Fransa</option>
                                                        <option value="NL">Hollanda</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Adı (varsa)</label>
                                                    <input type="text" class="form-control" placeholder="Mueller Marketing GmbH">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Şirket Kayıt Numarası</label>
                                                    <input type="text" class="form-control" placeholder="HRB 123456">
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
                                                    <input type="text" class="form-control" placeholder="Hans Mueller" value="Hans Mueller" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Cadde/Sokak</label>
                                                    <input type="text" class="form-control" placeholder="Muster Straße 123" value="Muster Straße 123" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Posta Kodu</label>
                                                    <input type="text" class="form-control" placeholder="10115" value="10115" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label required">Şehir</label>
                                                    <input type="text" class="form-control" placeholder="Berlin" value="Berlin" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label required">Ülke</label>
                                                    <select class="form-select" required>
                                                        <option value="DE" selected>Almanya</option>
                                                        <option value="FR">Fransa</option>
                                                        <option value="NL">Hollanda</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ödeme Koşulları ve Notlar -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-title">Ödeme Koşulları ve Notlar</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Ödeme Gecikmesi (gün)</label>
                                                    <select class="form-select">
                                                        <option value="0">Hemen</option>
                                                        <option value="7">7 Gün</option>
                                                        <option value="15" selected>15 Gün</option>
                                                        <option value="30">30 Gün</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Para Birimi</label>
                                                    <select class="form-select">
                                                        <option value="EUR" selected>Euro (EUR)</option>
                                                        <option value="USD">Amerikan Doları (USD)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Özel Notlar</label>
                                                    <textarea class="form-control" rows="3" placeholder="Ödeme ile ilgili özel notlar, koşullar veya talimatlar..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Kaydet Butonu -->
                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary me-2">İptal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <svg class="icon me-2" width="24" height="24">
                                                <use xlink:href="#tabler-device-floppy"></use>
                                            </svg>
                                            Ödeme Bilgilerini Kaydet
                                        </button>
                                    </div>
                                </form>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/affiliates/edit.blade.php ENDPATH**/ ?>