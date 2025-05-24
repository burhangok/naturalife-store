<?php if (! $__env->hasRenderedOnce('5f41934d-25f8-4870-8a7d-b47f149cfe5f')): $__env->markAsRenderedOnce('5f41934d-25f8-4870-8a7d-b47f149cfe5f');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-empty-info-template"
    >
        <div class="grid justify-center justify-items-center gap-3.5 px-2.5 py-10">
            <img
                src="<?php echo e(bagisto_asset('images/icon-add-product.svg')); ?>"
                class="h-20 w-20 dark:mix-blend-exclusion dark:invert"
            >

            <div class="flex flex-col items-center gap-2">
                <p
                    class="text-base font-semibold text-gray-400"
                    v-if="type == 'event'"
                >
                    <?php echo app('translator')->get('admin::app.catalog.products.edit.types.booking.empty-info.tickets.add'); ?>
                </p>

                <p
                    class="text-base font-semibold text-gray-400"
                    v-else
                >
                    <?php echo app('translator')->get('admin::app.catalog.products.edit.types.booking.empty-info.slots.add'); ?>
                </p>

                <p class="text-gray-400">
                    <?php echo app('translator')->get('admin::app.catalog.products.edit.types.booking.empty-info.slots.description'); ?>
                </p>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-empty-info', {
            template: '#v-empty-info-template',

            props: ['type'],
        });
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/resources/views/catalog/products/edit/types/booking/empty-info.blade.php ENDPATH**/ ?>