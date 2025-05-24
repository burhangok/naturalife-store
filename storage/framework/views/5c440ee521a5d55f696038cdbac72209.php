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

                    </div>
                </div>
                <div class="h1 mb-3">1,500</div>
                <div class="d-flex mb-2">
                    <div>Alt Bayi Sayısı</div>
                    <div class="ms-auto">
                        <span class="text-green d-inline-flex align-items-center lh-1">

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
                    <div class="subheader">Kazandığınız Komisyonlar</div>
                    <div class="ms-auto lh-1">

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

<?php echo $__env->make('layouts.shop-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/shop/affiliate_dashboard.blade.php ENDPATH**/ ?>