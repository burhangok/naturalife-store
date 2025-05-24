<?php $__env->startSection('title', 'Temsilcilik Modülü Yönetim Paneli'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xl">
<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Temsilciler</div>
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
                <div class="h1 mb-3">1,500</div>
                <div class="d-flex mb-2">
                    <div>Toplam Temsilci</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            7% <i class="ti ti-trending-up"></i>
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
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
                    <div class="subheader">Satışlar</div>
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
                    <div class="h1 mb-0 me-2">₺4,200</div>
                    <div class="me-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">
                            8% <i class="ti ti-trending-up"></i>
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
                    <div class="subheader">Komisyonlar</div>
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
                    <div class="h1 mb-3">152</div>
                    <div class="me-auto">
                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                            0% <i class="ti ti-minus"></i>
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 45%" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" aria-label="45% Complete">
                        <span class="visually-hidden">45% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Temsilciler</div>
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
                    <div class="h1 mb-3">95</div>
                    <div class="me-auto">
                        <span class="text-red d-inline-flex align-items-center lh-1">
                            -5% <i class="ti ti-trending-down"></i>
                        </span>
                    </div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-primary" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
                        <span class="visually-hidden">75% Complete</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="card-title">Komisyonlar</div>
            </div>
            <div class="card-body">
                <div id="chart-mention-example" class="chart-lg"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-0">
                <div class="card-title">Son Hareketler</div>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: url(https://eu.ui-avatars.com/api/?name=AK&background=random)"></span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong>Ahmet Kaya</strong> yeni bir hesap oluşturdu.
                            </div>
                            <div class="text-muted">2 saat önce</div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: url(https://eu.ui-avatars.com/api/?name=MY&background=random)"></span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong>Mehmet Yılmaz</strong> bir yorum yazdı.
                            </div>
                            <div class="text-muted">5 saat önce</div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: url(https://eu.ui-avatars.com/api/?name=FK&background=random)"></span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong>Fatma Kara</strong> ürün siparişi verdi.
                            </div>
                            <div class="text-muted">Dün</div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: url(https://eu.ui-avatars.com/api/?name=AY&background=random)"></span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong>Ayşe Yıldız</strong> profilini güncelledi.
                            </div>
                            <div class="text-muted">2 gün önce</div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-auto">
                            <span class="avatar" style="background-image: url(https://eu.ui-avatars.com/api/?name=OD&background=random)"></span>
                        </div>
                        <div class="col">
                            <div class="text-truncate">
                                <strong>Okan Demir</strong> blog yazısı paylaştı.
                            </div>
                            <div class="text-muted">3 gün önce</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Burada dashboard için gerekli JavaScript kodları yer alacak
    document.addEventListener("DOMContentLoaded", function() {
        // Grafik yükleme kodları buraya gelebilir
        console.log("Dashboard sayfası yüklendi!");
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/dashboard.blade.php ENDPATH**/ ?>