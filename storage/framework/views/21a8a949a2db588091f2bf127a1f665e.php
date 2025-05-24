<div class="flex flex-col">
    <p class="font-semibold leading-6 text-gray-800 dark:text-white">
        <?php echo e($address->company_name ?? ''); ?>

    </p>

    <p class="font-semibold leading-6 text-gray-800 dark:text-white">
        <?php echo e($address->name); ?>

    </p>
    
    <p class="!leading-6 text-gray-600 dark:text-gray-300">
        <?php echo e($address->address); ?><br>

        <?php echo e($address->city); ?><br>

        <?php echo e($address->state); ?><br>

        <?php echo e(core()->country_name($address->country)); ?> <?php if($address->postcode): ?> (<?php echo e($address->postcode); ?>) <?php endif; ?><br>

        <?php echo e(__('admin::app.sales.orders.view.contact')); ?> : <?php echo e($address->phone); ?>

    </p>
</div><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/Resources/views/sales/address.blade.php ENDPATH**/ ?>