<?php $__env->startSection('title', 'Alt Temscilcilerim'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Temsilci Paneli
                    </div>
                    <h2 class="page-title">
                        <i class="fas fa-users me-2"></i>
                        Benim Alt Temsilcilerim
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-sync me-2"></i>
                            Yenile
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="fas fa-download me-2"></i>
                            Excel'e Aktar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item active" href="#">Son 7 gün</a>
                                            <a class="dropdown-item" href="#">Son 30 gün</a>
                                            <a class="dropdown-item" href="#">Son 3 ay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-baseline">
                                <div class="h1 mb-0 me-2"><?php echo e($totalRepresentatives ?? '24'); ?></div>
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

            <!-- Filter and Search -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Arama</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="İsim, email, telefon...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Durum</label>
                                    <select class="form-select">
                                        <option value="">Tümü</option>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Pasif</option>
                                        <option value="pending">Beklemede</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Bölge</label>
                                    <select class="form-select">
                                        <option value="">Tüm Bölgeler</option>
                                        <option value="istanbul">İstanbul</option>
                                        <option value="ankara">Ankara</option>
                                        <option value="izmir">İzmir</option>
                                        <option value="bursa">Bursa</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Kayıt Tarihi</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fas fa-filter me-1"></i>
                                            Filtrele
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary">
                                            <i class="fas fa-redo me-1"></i>
                                            Temizle
                                        </button>
                                    </div>
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
                                        <a href="#" class="dropdown-item">
                                            <i class="fas fa-print me-2"></i>
                                            Yazdır
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">
                                            <i class="fas fa-sync me-2"></i>
                                            Verileri Yenile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">
                                            <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Tümünü seç">
                                        </th>
                                        <th>Temsilci</th>
                                        <th>İletişim</th>
                                        <th>Bölge</th>
                                        <th>Performans</th>
                                        <th>Kayıt Tarihi</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $representatives ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Seç">
                                        </td>
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <span class="avatar me-2"
                                                      style="background-image: url('<?php echo e($rep['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($rep['name'] ?? 'User') . '&background=random'); ?>')"></span>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?php echo e($rep['name'] ?? 'Ahmet Yılmaz'); ?></div>
                                                    <div class="text-muted">
                                                        <i class="fas fa-id-badge me-1"></i>
                                                        #<?php echo e($rep['code'] ?? 'T001'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <i class="fas fa-envelope me-1 text-muted"></i>
                                                <a href="mailto:<?php echo e($rep['email'] ?? 'ahmet@example.com'); ?>" class="text-reset"><?php echo e($rep['email'] ?? 'ahmet@example.com'); ?></a>
                                            </div>
                                            <div class="text-muted">
                                                <i class="fas fa-phone me-1"></i>
                                                <?php echo e($rep['phone'] ?? '+90 532 123 45 67'); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                                <?php echo e($rep['region'] ?? 'İstanbul Anadolu'); ?>

                                            </div>
                                            <div class="text-muted small">
                                                <?php echo e($rep['city'] ?? 'İstanbul'); ?> / <?php echo e($rep['district'] ?? 'Kadıköy'); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2"><?php echo e($rep['performance'] ?? '85'); ?>%</span>
                                                <div class="progress progress-sm flex-fill">
                                                    <div class="progress-bar bg-<?php echo e(($rep['performance'] ?? 85) >= 80 ? 'success' : (($rep['performance'] ?? 85) >= 60 ? 'warning' : 'danger')); ?>"
                                                         style="width: <?php echo e($rep['performance'] ?? 85); ?>%"></div>
                                                </div>
                                            </div>
                                            <div class="text-muted small">
                                                <i class="fas fa-chart-line me-1"></i>
                                                ₺<?php echo e(number_format($rep['sales'] ?? 125000, 0, ',', '.')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div><?php echo e($rep['created_at'] ?? '15.03.2024'); ?></div>
                                            <div class="text-muted small"><?php echo e($rep['days_ago'] ?? '70'); ?> gün önce</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e(($rep['status'] ?? 'active') == 'active' ? 'success' : (($rep['status'] ?? 'active') == 'pending' ? 'warning' : 'danger')); ?> me-1"></span>
                                            <?php echo e($rep['status_text'] ?? 'Aktif'); ?>

                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <a href="#" class="btn btn-white btn-sm" title="Detayları Görüntüle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-white btn-sm" title="Düzenle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <div class="dropdown">
                                                    <button class="btn btn-white btn-sm dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-user-check me-2"></i>
                                                            Profil Görüntüle
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-chart-bar me-2"></i>
                                                            Performans Raporu
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-envelope me-2"></i>
                                                            Mesaj Gönder
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Ara
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="empty">
                                                <div class="empty-img"><img src="https://tabler.io/static/illustrations/undraw_printing_invoices_5r4r.svg" height="128" alt="">
                                                </div>
                                                <p class="empty-title">Henüz alt temsilciniz bulunmuyor</p>
                                                <p class="empty-subtitle text-muted">
                                                    Size bağlı alt temsilci kaydı bulunmamaktadır. Sistem yöneticisiyle iletişime geçebilirsiniz.
                                                </p>
                                                <div class="empty-action">
                                                    <a href="#" class="btn btn-outline-primary">
                                                        <i class="fas fa-sync me-2"></i>
                                                        Sayfayı Yenile
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <p class="m-0 text-muted">Toplam <span class="badge bg-secondary"><?php echo e($totalCount ?? '24'); ?></span> kayıt gösteriliyor</p>
                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-chevron-left"></i>
                                        Önceki
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        Sonraki <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/shop/affiliate_downaffiliates.blade.php ENDPATH**/ ?>