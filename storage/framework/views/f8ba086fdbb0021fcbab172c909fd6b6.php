<?php $__env->startSection('title', 'Komisyon Kuralları'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Komisyon Kuralı Oluştur
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.index')); ?>" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i> Listeye Dön
                </a>
            </div>
        </div>
    </div>

        <div class="card m-3">
            <div class="card-header">
                <h2 class="card-title flex items-center gap-2">
                    <i class="fas fa-info-circle text-muted"></i> Komisyon Bilgileri
                </h2>
            </div>

            <div class="card-body">
                <form action="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.store')); ?>" method="POST" id="komisyon-form">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label for="level" class="form-label">
                                <i class="fas fa-layer-group text-primary mr-1"></i> Seviye
                            </label>
                            <input
                                type="text"
                                name="level"
                                id="level"
                                class="form-control <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Seviye değerini giriniz"
                                value="<?php echo e(old('level')); ?>"
                                required
                            >
                            <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="col-md-6 mb-3">
                            <label for="percentage" class="form-label">
                                <i class="fas fa-percentage text-primary mr-1"></i> Yüzde (%)
                            </label>
                            <input
                                type="text"
                                name="percentage"
                                id="percentage"
                                class="form-control <?php $__errorArgs = ['percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Yüzde değerini giriniz"
                                value="<?php echo e(old('percentage')); ?>"
                                required
                            >
                            <?php $__errorArgs = ['percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?php echo e(old('is_active', true) ? 'checked' : ''); ?>

                            >
                            <span class="form-check-label">Durum Aktif mi?</span>
                        </label>
                    </div>

                    
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-1"></i> İptal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/commissionrules/create.blade.php ENDPATH**/ ?>