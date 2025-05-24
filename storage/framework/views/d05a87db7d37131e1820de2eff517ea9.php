<?php $__env->startSection('title', 'Komisyon Kuralı Düzenle'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Komisyon Kuralı Düzenle
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.index')); ?>" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i> Listeye Dön
                </a>
            </div>
        </div>
    </div>

    <form action="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.update', $commissionRule->id)); ?>" method="POST" class="card mt-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card-header">
            <h3 class="card-title">Komisyon Bilgileri</h3>
        </div>

        <div class="card-body">
            <div class="row g-3">

                
                <div class="col-md-6">
                    <label class="form-label required">Seviye</label>
                    <input
                        type="text"
                        class="form-control <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        name="level"
                        value="<?php echo e(old('level', $commissionRule->level)); ?>"
                        placeholder="Seviye değerini giriniz"
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

                
                <div class="col-md-6">
                    <label class="form-label required">Yüzde (%)</label>
                    <input
                        type="text"
                        class="form-control <?php $__errorArgs = ['percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        name="percentage"
                        value="<?php echo e(old('percentage', $commissionRule->percentage)); ?>"
                        placeholder="Yüzde değerini giriniz"
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

                
                <div class="col-md-12">
                    <label class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?php echo e(old('is_active', $commissionRule->is_active) ? 'checked' : ''); ?>

                        >
                        <span class="form-check-label">Durum Aktif mi?</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="<?php echo e(route('admin.affiliatemodule.admin.commissionrules.index')); ?>" class="btn btn-secondary">
                <i class="ti ti-x me-1"></i> İptal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-check me-1"></i> Güncelle
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/commissionrules/edit.blade.php ENDPATH**/ ?>