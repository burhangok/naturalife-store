<?php $__env->startSection('title', 'Komisyonlar Listesi'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">


    <div class="page-body">
        <div class="container">
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
                                <circle cx="12" cy="12" r="9"></circle>
                                <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                            </svg>
                        </div>
                        <div><?php echo e(session('error')); ?></div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            <?php endif; ?>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="card-title"><i class="fas fa-euro-sign"></i> Toplam Kazanç</h3>
                                    <h4>€<?php echo e(number_format($affiliate->commissions()->sum('amount'), 2)); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="card-title"><i class="fas fa-money-check"></i> Bu Ay ki Kazanç
                                    </h3>

                                    <h4><?php echo e(core()->formatPrice($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'))); ?></h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-days fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="card-title"><i class="fas fa-users"></i>Alt Temsilci Sayınız
                                    </h3>
                                    <h4><?php echo e($affiliate->children->count()); ?>

                                    </h4>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- JavaScript fonksiyonu -->
            <script>
                function toggleDetails(id) {
                    const detailRow = document.getElementById(id);
                    if (detailRow.classList.contains('d-none')) {
                        detailRow.classList.remove('d-none');
                    } else {
                        detailRow.classList.add('d-none');
                    }
                }
            </script>

            <!-- Siparişlere Göre Gruplandırılmış Komisyonlar -->
            <?php
            $commissionCollection = collect($commissions);
            $orderGroups = $commissionCollection->groupBy('order_id');
        ?>

            <?php $__empty_1 = true; $__currentLoopData = $orderGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderId => $groupCommissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $order = $groupCommissions->first()->order;
                    $totalCommission = $groupCommissions->sum('amount');
                ?>

                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <h3 class="card-title mb-1">
                                    <i class="fas fa-receipt text-primary me-2"></i> Sipariş #<?php echo e($orderId); ?>

                                </h3>

                                <?php if($order): ?>
                                    <div class="small text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i> <?php echo e($order->created_at->format('d.m.Y H:i')); ?>

                                        <span class="mx-2">|</span>
                                        <i class="fas fa-hand-holding-usd me-1"></i> Dağıtılan Komisyon:
                                        <strong class="text-success"><?php echo e(core()->formatBasePrice($totalCommission)); ?> €</strong>
                                        + Temsilci İndirimi: <strong class="text-warning"><?php echo e(core()->formatBasePrice($order->base_discount_amount)); ?></strong>
                                        = <strong class="text-primary"><?php echo e(core()->formatBasePrice($order->base_discount_amount + $totalCommission)); ?> </strong>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-user me-1"></i> Siparişi Veren:
                                        <strong><?php echo e($order->customer->first_name .' '.$order->customer->last_name); ?></strong>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-shopping-cart me-1"></i> Sepet Tutarı:
                                        <strong class="text-dark"><?php echo e(core()->formatBasePrice($order->grand_total)); ?> €</strong>
                                    </div>
                                <?php else: ?>
                                    <div class="small text-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i> Sipariş silinmiş -
                                        Toplam Komisyon: <strong><?php echo e(number_format($totalCommission, 2)); ?> €</strong>
                                    </div>
                                <?php endif; ?>
                            </div>

    <!-- Siparişlere Göre Gruplandırılmış Komisyonlar
                            <?php if($order): ?>
                                <div class="col-auto">
                                    <a href="#" class="text-decoration-none" title="Siparişi Görüntüle">
                                        <i class="fas fa-external-link-alt text-primary fs-5"></i> Siparişi Görüntüle
                                    </a>
                                </div>
                            <?php endif; ?>
-->
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th><i class="fas fa-hashtag text-muted me-1"></i>Komisyon ID</th>
                                    <th><i class="fas fa-user-tie text-muted me-1"></i>Temsilci</th>
                                    <th><i class="fas fa-user-friends text-muted me-1"></i>Alt Temsilci</th>
                                    <th><i class="fas fa-layer-group text-muted me-1"></i>Seviye</th>
                                    <th><i class="fas fa-percentage text-muted me-1"></i>Oran</th>
                                    <th><i class="fas fa-euro-sign text-muted me-1"></i>Tutar</th>
                                    <th><i class="fas fa-calendar-alt text-muted me-1"></i>Tarih</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $groupCommissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($commission->id); ?></td>
                                        <td>
                                            <?php if($commission->affiliate): ?>
                                                <a href="<?php echo e(route('shop.customers.affiliatemodule.profile', $commission->affiliate_id)); ?>" class="text-primary">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    <?php echo e($commission->affiliate->id); ?> - <?php echo e($commission->affiliate->affiliate_code); ?>

                                                    <small class="text-muted">(<?php echo e($commission->affiliate->customer->getNameAttribute()); ?>)</small>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted"><i class="fas fa-user-slash me-1"></i>Temsilci Silinmiş</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($commission->fromAffiliate): ?>
                                                <a href="<?php echo e(route('shop.customers.affiliatemodule.profile', $commission->from_affiliate_id)); ?>" class="text-secondary">
                                                    <i class="fas fa-user-friends me-1"></i>
                                                    <?php echo e($commission->fromAffiliate->id); ?> - <?php echo e($commission->fromAffiliate->affiliate_code); ?>

                                                    <small class="text-muted">(<?php echo e($commission->fromAffiliate->customer->getNameAttribute()); ?>)</small>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-blue-lt">Seviye <?php echo e($commission->level); ?></span></td>
                                        <td><span class="text-green fw-bold">%<?php echo e($commission->percentage); ?></span></td>
                                        <td><span class="fw-bold"><?php echo e(number_format($commission->amount, 2)); ?> €</span></td>
                                        <td><span class="text-muted"><?php echo e($commission->created_at->format('d.m.Y H:i')); ?></span></td>
                                        <td class="text-end">
                                            <button type="button"
                                                onclick="toggleDetails('commission-<?php echo e($commission->id); ?>')"
                                                class="btn btn-icon btn-md btn-outline-primary"
                                                title="Detayları Göster">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Detay Satırı -->
                                    <tr id="commission-<?php echo e($commission->id); ?>" class="d-none">
                                        <td colspan="8">
                                            <div class="card border shadow-sm">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="card-title mb-0"><i class="fas fa-info-circle me-2 text-primary"></i><strong class="text-muted">Komisyon ID:</strong> <?php echo e($commission->id); ?>   <span class="badge bg-blue-lt">Seviye <?php echo e($commission->level); ?></span>
                                                        </h4>

                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">
                                                                <li class="mb-2"><strong class="text-muted">Komisyon Alan Temsilci:</strong>
                                                                    <?php if($commission->affiliate): ?>
                                                                    <a href="<?php echo e(route('shop.customers.affiliatemodule.profile', $commission->affiliate_id)); ?>" class="text-primary">
                                                                        <i class="fas fa-user-tie me-1"></i>
                                                                        <?php echo e($commission->affiliate->id); ?> - <?php echo e($commission->affiliate->affiliate_code); ?>

                                                                        <small class="text-muted">(<?php echo e($commission->affiliate->customer->getNameAttribute()); ?>)</small>
                                                                    </a>        <?php else: ?>
                                                                        <span class="text-danger">Temsilci Silinmiş</span>
                                                                    <?php endif; ?>
                                                                </li>
                                                                <li class="mb-2"><strong class="text-muted">Komisyon Kazandıran Alt Temsilci:</strong>
                                                                    <?php if($commission->fromAffiliate): ?>
                                                                    <a href="<?php echo e(route('shop.customers.affiliatemodule.profile', $commission->from_affiliate_id)); ?>" class="text-secondary">
                                                                        <i class="fas fa-user-friends me-1"></i>
                                                                        <?php echo e($commission->fromAffiliate->id); ?> - <?php echo e($commission->fromAffiliate->affiliate_code); ?>

                                                                        <small class="text-muted">(<?php echo e($commission->fromAffiliate->customer->getNameAttribute()); ?>)</small>
                                                                    </a>       <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </li>

                                                                <li class="mb-2"><strong class="text-muted">Açıklama:</strong> <?php echo e($commission->description); ?></li>

                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="list-unstyled">

                                                                <li class="mb-2"><strong class="text-muted">Oran:</strong> %<?php echo e($commission->percentage); ?></li>
                                                                <li class="mb-2"><strong class="text-muted">Tutar:</strong> <span class="fw-bold text-success"><?php echo e(number_format($commission->amount, 2)); ?> €</span></li>
                                                                    <li class="mb-2"><strong class="text-muted">Oluşturulma:</strong> <?php echo e($commission->created_at->format('d.m.Y H:i')); ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <?php if($commission->note): ?>
                                                        <div class="mt-4">
                                                            <label class="form-label"><i class="fas fa-sticky-note text-muted me-2"></i>Not:</label>
                                                            <div class="form-control bg-light"><?php echo e($commission->note); ?></div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">
                    <div class="empty-img">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-sad" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <line x1="9" y1="10" x2="9.01" y2="10"></line>
                            <line x1="15" y1="10" x2="15.01" y2="10"></line>
                            <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                        </svg>
                    </div>
                    <p class="empty-title">Kayıt Bulunamadı</p>
                    <p class="empty-subtitle text-muted">
                        Arama kriterlerinize uygun komisyon kaydı bulunmamaktadır.
                    </p>
                </div>
            <?php endif; ?>

            <!-- Sayfalama -->
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/shop/affiliate_commissions.blade.php ENDPATH**/ ?>