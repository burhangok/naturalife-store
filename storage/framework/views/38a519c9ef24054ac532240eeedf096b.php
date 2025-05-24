<?php $__env->startSection('title', $affiliate->affiliate_code . ' - ' . $affiliate->customer->getNameAttribute()); ?>
<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row">
            <!-- Sol Panel - Kullanıcı Bilgileri ve Özet -->
            <div class="col-md-3">
                <!-- Kullanıcı Profil Kartı -->


                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="mb-0"><i class="fas fa-user-tie me-2"></i>Temsilci Özeti</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Temsilci Kodu:</span>
                                <span class="fw-bold"><?php echo e($affiliate->affiliate_code); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Seviyesi</span>
                                <span class="badge bg-primary text-white badge-lg">Seviye <?php echo e($affiliate->level); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Üst Temsilcisi:</span>
                                <span
                                    class="fw-bold"><?php echo e($affiliate->parent->affiliate_code . ' - ' . $affiliate->parent->customer->getNameAttribute()); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Alt Temsilci Sayısı:</span>
                                <span class="fw-bold"><?php echo e($affiliate->children->count()); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Toplam Kazanç:</span>
                                <span class="fw-bold text-success">€<?php echo e($affiliate->formatted_commission); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Üyelik Tarihi:</span>
                                <span class="fw-bold"><?php echo e($affiliate->joined_at?->format('d.m.Y')); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span class="text-muted">Son Komisyon:</span>
                                <span
                                    class="fw-bold"><?php echo e($affiliate->last_commission_at?->format('d.m.Y') ?? 'Henüz yok'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Navigasyon Menüsü -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                            <button class="nav-link active text-start py-3 px-4 border-bottom" id="dashboard-tab"
                                data-bs-toggle="pill" data-bs-target="#dashboard" type="button">
                                <i class="fas fa-tachometer-alt me-2"></i> Özet Görünüm
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="referrals-tab"
                                data-bs-toggle="pill" data-bs-target="#referrals" type="button">
                                <i class="fas fa-link me-2"></i> Referans Linkim
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="network-tab"
                                data-bs-toggle="pill" data-bs-target="#network" type="button">
                                <i class="fas fa-sitemap me-2"></i> Alt Temsilcilerim
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="earnings-tab"
                                data-bs-toggle="pill" data-bs-target="#earnings" type="button">
                                <i class="fas fa-money-bill-wave me-2"></i> Kazanç Geçmişi
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-bottom" id="orders-tab"
                                data-bs-toggle="pill" data-bs-target="#orders" type="button">
                                <i class="fas fa-shopping-cart me-2"></i> Siparişlerim
                            </button>
                            <button class="nav-link text-start py-3 px-4" id="profile-tab" data-bs-toggle="pill"
                                data-bs-target="#profile" type="button">
                                <i class="fas fa-user-cog me-2"></i> Profil Bilgileri
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ana İçerik Alanı -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">

                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <!-- İstatistik Kartları -->
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
                                                <h3 class="card-title"><i class="fas fa-users"></i> Yönlendirdiğim Kişiler
                                                </h3>
                                                <h4>2</h4>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-user-friends fa-2x opacity-75"></i>
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
                                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Toplam Satış
                                                </h3>
                                                <h4><?php echo e(core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))); ?>

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

                        <!-- Link Performansı -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0"><i class="fas fa-mouse-pointer me-2"></i>Link Performansı</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Toplam Tıklama:</span>
                                            <span class="fw-bold"><?php echo e($clicks->count()); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Dönüşüm Sayısı:</span>
                                            <span class="fw-bold"><?php echo e($clicks->where('converted', true)->count()); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Dönüşüm Oranı:</span>
                                            <span class="fw-bold text-success"><?php echo e($conversionRate); ?>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0"><i class="fas fa-calendar me-2"></i>Bu Ay</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Bu Ayki Kazanç:</span>
                                            <span
                                                class="fw-bold text-success">€<?php echo e(number_format($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2)); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Bu Ayki Tıklama:</span>
                                            <span
                                                class="fw-bold"><?php echo e($clicks->where('created_at', '>=', now()->startOfMonth())->count()); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Yeni Alt Temsilci:</span>
                                            <span
                                                class="fw-bold"><?php echo e($affiliate->children->where('joined_at', '>=', now()->startOfMonth())->count()); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Son Aktiviteler -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-history me-2"></i>Son Aktiviteler</h3>
                            </div>
                            <div class="card-body">
                                <?php if($affiliate->commissions->take(5)->count() > 0): ?>
                                    <?php $__currentLoopData = $affiliate->commissions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <div class="fw-bold">Komisyon Kazancı</div>
                                                <small
                                                    class="text-muted"><?php echo e($commission->created_at->format('d.m.Y H:i')); ?></small>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bold text-success">
                                                    €<?php echo e(number_format($commission->amount, 2)); ?></div>
                                                <small class="text-muted">Seviye <?php echo e($commission->level); ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-center text-muted py-4">
                                        Henüz komisyon kazancınız bulunmuyor.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Referans Linki Tab -->
                    <div class="tab-pane fade" id="referrals" role="tabpanel">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-link me-2"></i>Referans Linkiniz</h3>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="referralLink"
                                        value="https://lifenature.eu/ref/<?php echo e($affiliate->affiliate_code); ?>" readonly>
                                    <button class="btn btn-outline-primary" type="button"
                                        onclick="copyToClipboard('referralLink')">
                                        <i class="fas fa-copy"></i> Kopyala
                                    </button>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <div class="border-end">
                                            <h4 class="text-primary"><?php echo e($clicks->count()); ?></h4>
                                            <small class="text-muted">Toplam Tıklama</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border-end">
                                            <h4 class="text-success"><?php echo e($clicks->where('converted', true)->count()); ?></h4>
                                            <small class="text-muted">Dönüşüm</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="text-info"><?php echo e($conversionRate); ?>%</h4>
                                        <small class="text-muted">Dönüşüm Oranı</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tıklama Geçmişi -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-chart-line me-2"></i>Tıklama & UTM Geçmişi</h3>
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
                                                    <th>Zaman</th>
                                                    <th>IP / Konum</th>
                                                    <th>Cihaz</th>
                                                    <th>Referer</th>
                                                    <th>Dönüşüm</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $clicks->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $click): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($click->created_at->format('d.m.Y H:i')); ?></td>
                                                        <td>
                                                            <?php echo e($click->ip_address); ?><br>
                                                            <small class="text-muted"><?php echo e($click->country ?? '-'); ?> /
                                                                <?php echo e($click->city ?? '-'); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php echo e(ucfirst($click->device_type)); ?><br>
                                                            <small class="text-muted"><?php echo e($click->browser); ?></small>
                                                        </td>
                                                        <td>
                                                            <small class="text-truncate d-block" style="max-width:150px;">
                                                                <?php echo e(Str::limit($click->referrer_url, 30)); ?>

                                                            </small>
                                                        </td>
                                                        <td>
                                                            <?php if($click->converted): ?>
                                                                <span class="badge bg-success text-white">Evet</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning text-white">Hayır</span>
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

                    <!-- Alt Temsilciler Tab -->
                    <div class="tab-pane fade" id="network" role="tabpanel">
                        <!-- Alt Temsilci İstatistikleri -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Toplam Alt Temsilci</h3>
                                        <h3 class="mb-0"><?php echo e($downlineAffiliates->count()); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Alt Temsilcilerden Kazanç</h3>
                                        <h3 class="mb-0">
                                            €<?php echo e(number_format($downlineAffiliates->sum(function ($affiliate) {return $affiliate->generatedCommissions()->sum('amount');}),2)); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 py-3">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="text-center p-3 border rounded">
                                            <div class="mb-2">
                                                <i class="fas fa-user-circle fa-3x text-gray-400"></i>
                                            </div>
                                            <strong><?php echo e($affiliate->customer->getNameAttribute()); ?></strong><br>
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
                                                    <strong><?php echo e($downlineAffiliate->customer->first_name . ' ' . $downlineAffiliate->customer->last_name); ?></strong><br>
                                                    <span
                                                        class="badge bg-success level-badge text-white"><?php echo e($downlineAffiliate->level); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alt Temsilciler Listesi -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-sitemap me-2"></i>Alt Temsilcilerim</h3>
                            </div>

                            <div class="card-body p-0">

                                <?php if($downlineAffiliates->isEmpty()): ?>
                                    <div class="p-4 text-center text-muted">
                                        Henüz alt temsilciniz bulunmuyor.
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
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

                    <!-- Kazanç Geçmişi Tab -->
                    <div class="tab-pane fade" id="earnings" role="tabpanel">
                        <!-- Kazanç Özeti -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Toplam Kazanç</h3>
                                        <h3 class="mb-0">€<?php echo e(number_format($affiliate->commissions->sum('amount'), 2)); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Bu Ayki Kazanç</h3>
                                        <h3 class="mb-0">
                                            €<?php echo e(number_format($affiliate->commissions->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2)); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-muted mb-1">Son Komisyon</h3>
                                        <h3 class="mb-0">
                                            <?php echo e($affiliate->last_commission_at?->format('d.m.Y') ?? 'Henüz yok'); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Komisyon Geçmişi -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Komisyon Geçmişi</h3>
                            </div>
                            <div class="card-body p-0">
                                <?php if($affiliate->commissions->isEmpty()): ?>
                                    <div class="p-4 text-center text-muted">
                                        Henüz komisyon kazancınız bulunmuyor.
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tarih</th>
                                                    <th>Kaynak</th>
                                                    <th>Seviye</th>
                                                    <th>Tutar</th>
                                                    <th>Açıklama</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $affiliate->commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($commission->created_at->format('d.m.Y H:i')); ?></td>
                                                        <td>
                                                            <?php if($commission->from_affiliate_id): ?>
                                                                <?php echo e($commission->fromAffiliate->customer->first_name ?? 'Bilinmiyor'); ?>

                                                                <?php if($commission->level > 1): ?>
                                                                    <small class="text-muted">(Alt bayi)</small>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-primary">Direkt Satış</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-secondary text-white"><?php echo e($commission->level); ?></span>
                                                        </td>
                                                        <td class="text-success fw-bold">
                                                            €<?php echo e(number_format($commission->amount, 2)); ?></td>
                                                        <td><?php echo e($commission->description ?? '-'); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Siparişlerim Tab -->
                    <div class="tab-pane fade" id="orders" role="tabpanel">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Siparişlerim</h3>
                                <div>
                                    <span class="badge bg-success text-white">Toplam:
                                        <?php echo e(core()->formatPrice($affiliate->customer->orders->whereNotIn('status', ['canceled', 'closed'])->sum('base_grand_total_invoiced'))); ?></span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <?php if($affiliate->customer->orders->isEmpty()): ?>
                                    <div class="p-4 text-center text-muted">
                                        Henüz sipariş kaydınız bulunmuyor.
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Sipariş No</th>
                                                    <th>Tarih</th>
                                                    <th>Tutar</th>
                                                    <th>Ödeme</th>
                                                    <th>Durum</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $affiliate->customer->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <span class="fw-bold"><a href="<?php echo e(route('shop.customers.account.orders.view', $order->increment_id)); ?>" class="text-decoration-none" title="Siparişi Görüntüle">#<?php echo e($order->increment_id); ?></a></span>
                                                        </td>
                                                        <td><?php echo e($order->created_at->format('d.m.Y H:i')); ?></td>
                                                        <td class="fw-bold">
                                                            <?php echo e(core()->formatBasePrice($order->grand_total)); ?></td>
                                                        <td><?php echo e($order->payment->method_title); ?></td>
                                                        <td>
                                                            <?php
                                                                $statusClass = match ($order->status) {
                                                                    'completed' => 'bg-success',
                                                                    'processing' => 'bg-warning',
                                                                    'pending' => 'bg-info',
                                                                    'canceled' => 'bg-danger',
                                                                    default => 'bg-secondary',
                                                                };
                                                            ?>
                                                            <span
                                                                class="badge <?php echo e($statusClass); ?> text-white"><?php echo e(ucfirst($order->status)); ?></span>
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

                    <!-- Profil Bilgileri Tab -->
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0"><i class="fas fa-user-cog me-2"></i>Profil Bilgilerim</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ad Soyad</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo e($affiliate->customer->getNameAttribute()); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" class="form-control"
                                            value="<?php echo e($affiliate->customer->email); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="tel" class="form-control"
                                            value="<?php echo e($affiliate->customer->phone ?? '-'); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ülke</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo e(optional($affiliate->customer->addresses->first())->country ?? '-'); ?>"
                                            readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Temsilci Kodu</label>
                                        <input type="text" class="form-control"
                                            value="<?php echo e($affiliate->affiliate_code); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Seviye</label>
                                        <input type="text" class="form-control"
                                            value="Seviye <?php echo e($affiliate->level); ?>" readonly>
                                    </div>
                                    <?php if($affiliate->parent): ?>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Üst Temsilci</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo e($affiliate->parent->affiliate_code); ?> - <?php echo e($affiliate->parent->customer->getNameAttribute()); ?>"
                                                readonly>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                        $addr =
                                            $affiliate->customer->addresses->first() ??
                                            (object) [
                                                'address' => null,
                                                'city' => null,
                                                'postcode' => null,
                                                'state' => null,
                                                'country' => null,
                                            ];
                                    ?>
                                    <?php if($addr->address): ?>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Adres</label>
                                            <textarea class="form-control" rows="4" readonly><?php echo e($addr->address); ?>, <?php echo e($addr->city); ?> <?php echo e($addr->postcode); ?>, <?php echo e($addr->state); ?>, <?php echo e($addr->country); ?></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Profil bilgilerinizi güncellemek için lütfen müşteri hesabınızdan düzenleyiniz.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Kopyalama fonksiyonu
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            element.setSelectionRange(0, 99999);
            document.execCommand('copy');

            // Toast bildirim göster
            showToast('Link kopyalandı!', 'success');
        }

        // Toast bildirim fonksiyonu
        function showToast(message, type = 'info') {
            const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

            // Toast container oluştur (yoksa)
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1055';
                document.body.appendChild(toastContainer);
            }

            // Toast ekle
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);

            // Toast'u göster
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            // Toast kapandıktan sonra DOM'dan kaldır
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }

        // Tab değişimi için URL hash güncelleme
        document.addEventListener('DOMContentLoaded', function() {
            // URL'deki hash'e göre tab seçme
            const hash = window.location.hash;
            if (hash) {
                const tabButton = document.querySelector(`button[data-bs-target="${hash}"]`);
                if (tabButton) {
                    const tab = new bootstrap.Tab(tabButton);
                    tab.show();
                }
            }

            // Tab değişiminde URL hash'ini güncelleme
            const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(e) {
                    const target = e.target.getAttribute('data-bs-target');
                    if (target) {
                        history.pushState(null, null, target);
                    }
                });
            });
        });

        // Responsive tablo için scroll indicator
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('.table-responsive');
            tables.forEach(table => {
                if (table.scrollWidth > table.clientWidth) {
                    table.classList.add('has-scroll');
                }
            });
        });
    </script>

    <style>
        /* Özel CSS */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .nav-pills .nav-link {
            border-radius: 0;
            color: #495057;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }

        .nav-pills .nav-link.active {
            background-color: #007bff;
            color: white;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .table-responsive.has-scroll::after {
            content: '→ Kaydırarak devamını görün';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            color: #6c757d;
            pointer-events: none;
        }

        .badge {
            font-size: 0.75em;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Mobil uyumluluk */
        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Animasyonlar */
        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .nav-link {
            transition: all 0.2s ease-in-out;
        }

        /* Scroll bar özelleştirme */
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/shop/affiliate_profile.blade.php ENDPATH**/ ?>