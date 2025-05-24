<?php if (isset($component)) { $__componentOriginal8001c520f4b7dcb40a16cd3b411856d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8001c520f4b7dcb40a16cd3b411856d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.layouts.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::layouts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

     <?php $__env->slot('title', null, []); ?> 
      Komisyon Detay
     <?php $__env->endSlot(); ?>



<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Komisyon Detayı #<?php echo e($commission->id); ?></h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('admin.commissions.index')); ?>" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left mr-1"></i> Listeye Dön
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Affiliate Bilgisi</span>
                                    <span class="info-box-number">
                                        <?php if($commission->affiliate): ?>
                                            <a href="<?php echo e(route('admin.affiliates.edit', $commission->affiliate_id)); ?>">
                                                <?php echo e($commission->affiliate->name ?? $commission->affiliate->user->name ?? 'ID: '.$commission->affiliate_id); ?>

                                            </a>
                                        <?php else: ?>
                                            Affiliate Silinmiş
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sipariş Bilgisi</span>
                                    <span class="info-box-number">
                                        <?php if($commission->order): ?>
                                            <a href="<?php echo e(route('admin.sales.orders.view', $commission->order_id)); ?>">
                                                #<?php echo e($commission->order_id); ?> - <?php echo e(number_format($commission->order->total, 2)); ?> TL
                                            </a>
                                        <?php else: ?>
                                            Sipariş Silinmiş
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Komisyon ID</th>
                                        <td><?php echo e($commission->id); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alt Affiliate</th>
                                        <td>
                                            <?php if($commission->fromAffiliate): ?>
                                                <a href="<?php echo e(route('admin.affiliates.edit', $commission->from_affiliate_id)); ?>">
                                                    <?php echo e($commission->fromAffiliate->name ?? $commission->fromAffiliate->user->name ?? 'ID: '.$commission->from_affiliate_id); ?>

                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Seviye</th>
                                        <td><?php echo e($commission->level); ?>. Seviye</td>
                                    </tr>
                                    <tr>
                                        <th>Komisyon Tutarı</th>
                                        <td><?php echo e(number_format($commission->amount, 2)); ?> TL</td>
                                    </tr>
                                    <tr>
                                        <th>Komisyon Oranı</th>
                                        <td>%<?php echo e(number_format($commission->percentage, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Durum</th>
                                        <td>
                                            <span class="badge badge-<?php echo e($commission->status == 'pending' ? 'warning' :
                                                ($commission->status == 'approved' ? 'info' :
                                                ($commission->status == 'paid' ? 'success' : 'danger'))); ?>">
                                                <?php echo e($commission->status == 'pending' ? 'Beklemede' :
                                                    ($commission->status == 'approved' ? 'Onaylandı' :
                                                    ($commission->status == 'paid' ? 'Ödendi' : 'Reddedildi'))); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Açıklama</th>
                                        <td><?php echo e($commission->description ?? '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ödeme Tarihi</th>
                                        <td><?php echo e($commission->paid_at ? $commission->paid_at->format('d.m.Y H:i') : '-'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Oluşturulma Tarihi</th>
                                        <td><?php echo e($commission->created_at->format('d.m.Y H:i')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Güncellenme Tarihi</th>
                                        <td><?php echo e($commission->updated_at->format('d.m.Y H:i')); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Komisyon Durumunu Güncelle</h3>
                                </div>
                                <form method="POST" action="<?php echo e(route('admin.commissions.update', $commission)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Durum</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" <?php echo e($commission->status == 'pending' ? 'selected' : ''); ?>>Beklemede</option>
                                                <option value="approved" <?php echo e($commission->status == 'approved' ? 'selected' : ''); ?>>Onaylandı</option>
                                                <option value="paid" <?php echo e($commission->status == 'paid' ? 'selected' : ''); ?>>Ödendi</option>
                                                <option value="rejected" <?php echo e($commission->status == 'rejected' ? 'selected' : ''); ?>>Reddedildi</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Açıklama</label>
                                            <textarea name="description" class="form-control" rows="3" placeholder="Açıklama"><?php echo e($commission->description); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8001c520f4b7dcb40a16cd3b411856d1)): ?>
<?php $attributes = $__attributesOriginal8001c520f4b7dcb40a16cd3b411856d1; ?>
<?php unset($__attributesOriginal8001c520f4b7dcb40a16cd3b411856d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8001c520f4b7dcb40a16cd3b411856d1)): ?>
<?php $component = $__componentOriginal8001c520f4b7dcb40a16cd3b411856d1; ?>
<?php unset($__componentOriginal8001c520f4b7dcb40a16cd3b411856d1); ?>
<?php endif; ?>
<?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/resources/views/affiliatemodule/admin/commissions/edit.blade.php ENDPATH**/ ?>