<?php $__env->startSection('title', 'Temsilciler'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xl">


  <!-- Bildirimler -->
  <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l5 5l10 -10"></path>
          </svg>
        </div>
        <div><?php echo e(session('success')); ?></div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  <?php endif; ?>

  <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 9v2m0 4v.01"></path>
            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
          </svg>
        </div>
        <div><?php echo e(session('error')); ?></div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
  <?php endif; ?>

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
          <?php $__empty_1 = true; $__currentLoopData = $affiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($affiliate->id); ?></td>
              <td class="text-nowrap font-weight-medium"><?php echo e($affiliate->affiliate_code); ?></td>
              <td>
                <a href="<?php echo e(route('admin.customers.customers.view', $affiliate->customer_id)); ?>" class="text-reset">
                  <?php echo e($affiliate->customer_id); ?>

                </a>
              </td>
              <td><?php echo e($affiliate->customer->first_name .' ' .$affiliate->customer->last_name); ?></td>
              <td>
                <span class="badge bg-azure-lt"><?php echo e($affiliate->level); ?></span>
              </td>
              <td><?php echo $affiliate->status_badge; ?></td>
              <td>
                <?php
                  $tooltipContent = '<strong>' . $affiliate->affiliate_code . '</strong><br><br>';
                  foreach ($affiliate->children as $index => $child) {
                    $tooltipContent .= optional($child->customer)->first_name . ' ' . optional($child->customer)->last_name;
                    if ($index < count($affiliate->children) - 1) {
                      $tooltipContent .= '<br>';
                    }
                  }
                ?>

                <span class="badge bg-primary text-white"
                      data-bs-toggle="tooltip"
                      data-bs-html="true"
                      title="<?php echo $tooltipContent; ?>">
                      <i class="fas fa-users"></i>

                  <?php echo e($affiliate->children->count()); ?>

                </span>
              </td>
              <td><?php echo e($affiliate->formatted_commission); ?> ₺</td>
              <td class="text-nowrap"><?php echo e($affiliate->joined_at->format('d.m.Y H:i')); ?></td>
              <td>
                <div class="btn-list flex-nowrap">
                  <a href="<?php echo e(route('admin.affiliatemodule.admin.affiliates.edit', $affiliate->id)); ?>" class="btn btn-icon btn-outline-primary me-1">
                    <i class="fas fa-edit"></i>
</a>
                </div>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
          <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/affiliates/index.blade.php ENDPATH**/ ?>