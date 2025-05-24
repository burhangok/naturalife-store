<!-- Purchase Funnel Vue Component -->
<v-reporting-sales-purchase-funnel>
    <!-- Shimmer -->
    <?php if (isset($component)) { $__componentOriginal3038ebe39ee9203de73d86866adc199b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3038ebe39ee9203de73d86866adc199b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.shimmer.reporting.sales.purchase-funnel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::shimmer.reporting.sales.purchase-funnel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3038ebe39ee9203de73d86866adc199b)): ?>
<?php $attributes = $__attributesOriginal3038ebe39ee9203de73d86866adc199b; ?>
<?php unset($__attributesOriginal3038ebe39ee9203de73d86866adc199b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3038ebe39ee9203de73d86866adc199b)): ?>
<?php $component = $__componentOriginal3038ebe39ee9203de73d86866adc199b; ?>
<?php unset($__componentOriginal3038ebe39ee9203de73d86866adc199b); ?>
<?php endif; ?>
</v-reporting-sales-purchase-funnel>

<?php if (! $__env->hasRenderedOnce('d6b85f85-b162-405f-b755-71c0f7c56cd1')): $__env->markAsRenderedOnce('d6b85f85-b162-405f-b755-71c0f7c56cd1');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-reporting-sales-purchase-funnel-template"
    >
        <!-- Shimmer -->
        <template v-if="isLoading">
            <?php if (isset($component)) { $__componentOriginal3038ebe39ee9203de73d86866adc199b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3038ebe39ee9203de73d86866adc199b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.shimmer.reporting.sales.purchase-funnel','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::shimmer.reporting.sales.purchase-funnel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3038ebe39ee9203de73d86866adc199b)): ?>
<?php $attributes = $__attributesOriginal3038ebe39ee9203de73d86866adc199b; ?>
<?php unset($__attributesOriginal3038ebe39ee9203de73d86866adc199b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3038ebe39ee9203de73d86866adc199b)): ?>
<?php $component = $__componentOriginal3038ebe39ee9203de73d86866adc199b; ?>
<?php unset($__componentOriginal3038ebe39ee9203de73d86866adc199b); ?>
<?php endif; ?>
        </template>

        <!-- Purchase Funnel Section -->
        <template v-else>
            <div class="box-shadow relative flex-1 rounded bg-white p-4 dark:bg-gray-900">
                <!-- Header -->
                <p class="mb-4 text-base font-semibold text-gray-600 dark:text-white">
                    <?php echo app('translator')->get('admin::app.reporting.sales.index.purchase-funnel'); ?>
                </p>
                
                <!-- Content -->
                <div class="grid grid-cols-4 gap-6">
                    <!-- Total Visits -->
                    <div class="flex flex-col gap-4">
                        <div class="grid gap-0.5">
                            <p class="text-base font-semibold leading-none text-gray-800 dark:text-white">
                                {{ report.statistics.visitors.total }}
                            </p>

                            <p class="text-xs font-semibold leading-none text-gray-600 dark:text-gray-300">
                                <?php echo app('translator')->get('admin::app.reporting.sales.index.total-visits'); ?>
                            </p>
                        </div>

                        <div class="relative aspect-[0.5/1] w-full bg-slate-100">
                            <div
                                class="absolute bottom-0 w-full bg-emerald-400"
                                :style="{ 'height': report.statistics.visitors.progress + '%' }"
                            ></div>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300">
                            <?php echo app('translator')->get('admin::app.reporting.sales.index.total-visits-info'); ?>
                        </p>
                    </div>

                    <!-- Total Product Visits -->
                    <div class="flex flex-col gap-4">
                        <div class="grid gap-0.5">
                            <p class="text-base font-semibold leading-none text-gray-800 dark:text-white">
                                {{ report.statistics.product_visitors.total }}
                            </p>

                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                <?php echo app('translator')->get('admin::app.reporting.sales.index.product-views'); ?>
                            </p>
                        </div>

                        <div class="relative aspect-[0.5/1] w-full bg-slate-100">
                            <div
                                class="absolute bottom-0 w-full bg-emerald-400"
                                :style="{ 'height': (report.statistics.product_visitors.progress).toFixed(2) + '%' }"
                            ></div>
                        </div>

                        <p
                            class="text-gray-600 dark:text-gray-300"
                            v-html="'<?php echo app('translator')->get('admin::app.reporting.sales.index.product-views-info'); ?>'.replace(':progress', '<span class=\'text-emerald-400 font-semibold\'>' + report.statistics.product_visitors.progress + '%</span>')"
                        ></p>
                    </div>

                    <!-- Total Added To Cart -->
                    <div class="flex flex-col gap-4">
                        <div class="grid gap-0.5">
                            <p class="text-base font-semibold leading-none text-gray-800 dark:text-white">
                                {{ report.statistics.carts.total }}
                            </p>

                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                <?php echo app('translator')->get('admin::app.reporting.sales.index.added-to-cart'); ?>
                            </p>
                        </div>

                        <div class="relative aspect-[0.5/1] w-full bg-slate-100">
                            <div
                                class="absolute bottom-0 w-full bg-emerald-400"
                                :style="{ 'height': (report.statistics.carts.progress).toFixed(2) + '%' }"
                            ></div>
                        </div>

                        <p
                            class="text-gray-600 dark:text-gray-300"
                            v-html="'<?php echo app('translator')->get('admin::app.reporting.sales.index.added-to-cart-info'); ?>'.replace(':progress', '<span class=\'text-emerald-400 font-semibold\'>' + report.statistics.carts.progress + '%</span>')"
                        ></p>
                    </div>

                    <!-- Total Purchased -->
                    <div class="flex flex-col gap-4">
                        <div class="grid gap-0.5">
                            <p class="text-base font-semibold leading-none text-gray-800 dark:text-white">
                                {{ report.statistics.orders.total }}
                            </p>

                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                <?php echo app('translator')->get('admin::app.reporting.sales.index.purchased'); ?>
                            </p>
                        </div>

                        <div class="relative aspect-[0.5/1] w-full bg-slate-100 dark:text-gray-300">
                            <div
                                class="absolute bottom-0 w-full bg-emerald-400"
                                :style="{ 'height': report.statistics.orders.progress + '%' }"
                            ></div>
                        </div>

                        <p
                            class="text-gray-600 dark:text-gray-300"
                            v-html="'<?php echo app('translator')->get('admin::app.reporting.sales.index.purchased-info'); ?>'.replace(':progress', '<span class=\'text-emerald-400 font-semibold\'>' + report.statistics.orders.progress + '%</span>')"
                        ></p>
                    </div>
                </div>

                <!-- Date Range Section -->
                <div class="mt-6 flex justify-end gap-5">
                    <div class="flex items-center gap-1">
                        <span class="h-3.5 w-3.5 rounded-md bg-emerald-400"></span>

                        <p class="text-xs dark:text-gray-300">
                            {{ report.date_range.current }}
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-reporting-sales-purchase-funnel', {
            template: '#v-reporting-sales-purchase-funnel-template',

            data() {
                return {
                    report: [],

                    isLoading: true,
                }
            },

            mounted() {
                this.getStats({});

                this.$emitter.on('reporting-filter-updated', this.getStats);
            },

            methods: {
                getStats(filters) {
                    this.isLoading = true;

                    var filters = Object.assign({}, filters);

                    filters.type = 'purchase-funnel';

                    this.$axios.get("<?php echo e(route('admin.reporting.sales.stats')); ?>", {
                            params: filters
                        })
                        .then(response => {
                            this.report = response.data;

                            this.isLoading = false;
                        })
                        .catch(error => {});
                }
            }
        });
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/resources/views/reporting/sales/purchase-funnel.blade.php ENDPATH**/ ?>