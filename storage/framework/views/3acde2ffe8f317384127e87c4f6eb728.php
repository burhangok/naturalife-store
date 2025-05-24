<?php $__env->startSection('title', 'Alt Temscilcilerim'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">


    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Statistics Cards -->
            <div class="row row-deck row-cards mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Toplam Temsilci</div>
                                <div class="ms-auto lh-1">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Son 7 gün</a>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-0 me-2"><?php echo e($isAffiliate ?? '24'); ?></div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        8% <i class="fas fa-trending-up ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div id="chart-revenue-bg" class="chart-sm"></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Aktif Temsilci</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2"><?php echo e($activeRepresentatives ?? '18'); ?></div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        12% <i class="fas fa-trending-up ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    <span class="visually-hidden">75% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Bu Ay Kayıt</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2"><?php echo e($thisMonthRegistrations ?? '6'); ?></div>
                                <div class="me-auto">
                                    <span class="text-yellow d-inline-flex align-items-center lh-1">
                                        0% <i class="fas fa-minus ms-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-yellow" style="width: 25%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <span class="visually-hidden">25% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Ortalama Satış</div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-3 me-2">₺<?php echo e(number_format($averageSales ?? 45780, 0, ',', '.')); ?></div>
                                <div class="me-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        15% <i class="fas fa-trending-up ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Representatives Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Alt Temsilcilerim</h3>
                            <div class="card-actions">
                                <div class="dropdown">
                                    <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item">
                                            <i class="fas fa-download me-2"></i>
                                            Excel'e Aktar
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body p-0">

                            <?php if($downlineAffiliates->isEmpty()): ?>
                                <div class="p-4 text-center text-muted">
                                    Henüz alt temsilciniz bulunmuyor.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 dataListTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Temsilci</th>
                                                <th>Seviye</th>
                                                <th>Kayıt Tarihi</th>
                                                <th>Alt Üye</th>
                                                <th>Toplam Satış</th>
                                                <th>Kazandırdığı</th>
                                                <th>Detay</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $downlineAffiliates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $downlineAffiliate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <div class="fw-bold">
                                                                <?php echo e($downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name); ?>

                                                            </div>
                                                            <small
                                                                class="text-muted"><?php echo e($downlineAffiliate->affiliate_code); ?></small>
                                                        </div>
                                                    </td>
                                                    <td><span
                                                            class="badge bg-primary  text-white"><?php echo e($downlineAffiliate->level); ?></span>
                                                    </td>
                                                    <td><?php echo e($downlineAffiliate->joined_at?->format('d.m.Y')); ?></td>
                                                    <td><?php echo e($downlineAffiliate->children->count()); ?></td>
                                                    <td><?php echo e(core()->formatPrice($downlineAffiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))); ?>

                                                    </td>
                                                    <td class="text-success fw-bold">
                                                        €<?php echo e(number_format($downlineAffiliate->generatedCommissions()->sum('amount'), 2)); ?>

                                                    </td>
                                                    <td>
                                                        <a href="<?php echo e(route('shop.customers.affiliatemodule.profile', $downlineAffiliate->id)); ?>"
                                                            class="btn btn-icon btn-outline-primary me-1">
                                                            <i class="fas fa-search"></i>
                                                        </a>
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
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/shop/affiliate_downaffiliates.blade.php ENDPATH**/ ?>