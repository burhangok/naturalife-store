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
        <?php echo app('translator')->get('admin::app.catalog.attributes.index.title'); ?>
     <?php $__env->endSlot(); ?>

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <!-- Title -->
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            <?php echo app('translator')->get('admin::app.catalog.attributes.index.title'); ?>
        </p>

        <div class="flex items-center gap-x-2.5">
            <?php if(bouncer()->hasPermission('catalog.attributes.create')): ?>
                <a href="<?php echo e(route('admin.catalog.attributes.create')); ?>">
                    <div class="primary-button">
                        <?php echo app('translator')->get('admin::app.catalog.attributes.index.create-btn'); ?>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php echo view_render_event('bagisto.admin.catalog.attributes.list.before'); ?>


    <?php if (isset($component)) { $__componentOriginal3bea17ac3f7235e71a823454ccb74424 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3bea17ac3f7235e71a823454ccb74424 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.datagrid.index','data' => ['src' => route('admin.catalog.attributes.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::datagrid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.catalog.attributes.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3bea17ac3f7235e71a823454ccb74424)): ?>
<?php $attributes = $__attributesOriginal3bea17ac3f7235e71a823454ccb74424; ?>
<?php unset($__attributesOriginal3bea17ac3f7235e71a823454ccb74424); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3bea17ac3f7235e71a823454ccb74424)): ?>
<?php $component = $__componentOriginal3bea17ac3f7235e71a823454ccb74424; ?>
<?php unset($__componentOriginal3bea17ac3f7235e71a823454ccb74424); ?>
<?php endif; ?>

    <?php echo view_render_event('bagisto.admin.catalog.attributes.list.after'); ?>


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
<?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/resources/views/catalog/attributes/index.blade.php ENDPATH**/ ?>