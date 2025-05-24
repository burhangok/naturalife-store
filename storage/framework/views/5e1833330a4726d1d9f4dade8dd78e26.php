<?php echo view_render_event('bagisto.admin.catalog.product.edit.form.links.before', ['product' => $product]); ?>

    
<v-product-links></v-product-links>

<?php echo view_render_event('bagisto.admin.catalog.product.edit.form.links.after', ['product' => $product]); ?>


<?php if (! $__env->hasRenderedOnce('1a032d71-861d-44f1-b00e-c21e2630c187')): $__env->markAsRenderedOnce('1a032d71-861d-44f1-b00e-c21e2630c187');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-product-links-template"
    >
        <div class="grid gap-2.5">
            <!-- Panel -->
            <div
                class="box-shadow relative rounded bg-white dark:bg-gray-900"
                v-for="type in types"
            >
                <div class="mb-2.5 flex justify-between gap-5 p-4">
                    <div class="flex flex-col gap-2">
                        <p class="text-base font-semibold text-gray-800 dark:text-white">
                            {{ type.title }}
                        </p>

                        <p class="text-xs font-medium text-gray-500 dark:text-gray-300">
                            {{ type.info }}
                        </p>
                    </div>
                    
                    <!-- Add Button -->
                    <div class="flex items-center gap-x-1">
                        <div
                            class="secondary-button"
                            @click="selectedType = type.key; $refs.productSearch.openDrawer()"
                        >
                            <?php echo app('translator')->get('admin::app.catalog.products.edit.links.add-btn'); ?>
                        </div>
                    </div>
                </div>

                <!-- Product Listing -->
                <div
                    class="grid"
                    v-if="addedProducts[type.key].length"
                >
                    <div
                        class="flex justify-between gap-2.5 border-b border-slate-300 p-4 dark:border-gray-800"
                        v-for="product in addedProducts[type.key]"
                    >
                        <!-- Hidden Input -->
                        <input
                            type="hidden"
                            :name="type.key + '[]'"
                            :value="product.id"
                        />

                        <!-- Information -->
                        <div class="flex gap-2.5">
                            <!-- Image -->
                            <div
                                class="relative h-[60px] max-h-[60px] w-full max-w-[60px] overflow-hidden rounded"
                                :class="{'border border-dashed border-gray-300 dark:border-gray-800 dark:mix-blend-exclusion dark:invert': ! product.images.length}"
                            >
                                <template v-if="! product.images.length">
                                    <img src="<?php echo e(bagisto_asset('images/product-placeholders/front.svg')); ?>">
                                
                                    <p class="absolute bottom-1.5 w-full text-center text-[6px] font-semibold text-gray-400">
                                        <?php echo app('translator')->get('admin::app.catalog.products.edit.links.image-placeholder'); ?>
                                    </p>
                                </template>
            
                                <template v-else>
                                    <img :src="product.images[0].url">
                                </template>
                            </div>

                            <!-- Details -->
                            <div class="grid place-content-start gap-1.5">
                                <p class="text-base font-semibold text-gray-800 dark:text-white">
                                    {{ product.name }}
                                </p>

                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ "<?php echo app('translator')->get('admin::app.catalog.products.edit.links.sku'); ?>".replace(':sku', product.sku) }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="grid place-content-start gap-1 text-right">
                            <p class="font-semibold text-gray-800 dark:text-white">
                                {{ $admin.formatPrice(product.price) }}
                            </p>

                            <p
                                class="cursor-pointer text-red-600 transition-all hover:underline"
                                @click="remove(type.key, product)"
                            >
                                <?php echo app('translator')->get('admin::app.catalog.products.edit.links.delete'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- For Empty Variations -->
                <div
                    class="grid justify-center justify-items-center gap-3.5 px-2.5 py-10"
                    v-else
                >
                    <!-- Placeholder Image -->
                    <img
                        src="<?php echo e(bagisto_asset('images/icon-add-product.svg')); ?>"
                        class="h-20 w-20 dark:mix-blend-exclusion dark:invert"
                    />

                    <!-- Add Variants Information -->
                    <div class="flex flex-col items-center gap-1.5">
                        <p class="text-base font-semibold text-gray-400">
                            <?php echo app('translator')->get('admin::app.catalog.products.edit.links.empty-title'); ?>
                        </p>

                        <p class="text-gray-400">
                            {{ type.empty_info }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Product Search Blade Component -->
            <?php if (isset($component)) { $__componentOriginal327ffe807b42a6db021ef6ea08eda334 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal327ffe807b42a6db021ef6ea08eda334 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'admin::components.products.search','data' => ['ref' => 'productSearch',':addedProductIds' => 'addedProductIds','@onProductAdded' => 'addSelected($event)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin::products.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['ref' => 'productSearch',':added-product-ids' => 'addedProductIds','@onProductAdded' => 'addSelected($event)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal327ffe807b42a6db021ef6ea08eda334)): ?>
<?php $attributes = $__attributesOriginal327ffe807b42a6db021ef6ea08eda334; ?>
<?php unset($__attributesOriginal327ffe807b42a6db021ef6ea08eda334); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal327ffe807b42a6db021ef6ea08eda334)): ?>
<?php $component = $__componentOriginal327ffe807b42a6db021ef6ea08eda334; ?>
<?php unset($__componentOriginal327ffe807b42a6db021ef6ea08eda334); ?>
<?php endif; ?>
        </div>
    </script>

    <script type="module">
        app.component('v-product-links', {
            template: '#v-product-links-template',

            data() {
                return {
                    currentProduct: <?php echo json_encode($product, 15, 512) ?>,

                    selectedType: 'related_products',

                    types: [
                        {
                            key: 'related_products',
                            title: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.related-products.title'); ?>`,
                            info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.related-products.info'); ?>`,
                            empty_info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.related-products.empty-info'); ?>`,
                        }, {
                            key: 'up_sells',
                            title: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.up-sells.title'); ?>`,
                            info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.up-sells.info'); ?>`,
                            empty_info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.up-sells.empty-info'); ?>`,
                        }, {
                            key: 'cross_sells',
                            title: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.cross-sells.title'); ?>`,
                            info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.cross-sells.info'); ?>`,
                            empty_info: `<?php echo app('translator')->get('admin::app.catalog.products.edit.links.cross-sells.empty-info'); ?>`,
                        }
                    ],

                    addedProducts: {
                        'up_sells': <?php echo json_encode($product->up_sells()->with('images')->get(), 15, 512) ?>,

                        'cross_sells': <?php echo json_encode($product->cross_sells()->with('images')->get(), 15, 512) ?>,

                        'related_products': <?php echo json_encode($product->related_products()->with('images')->get(), 15, 512) ?>
                    },
                }
            },

            computed: {
                addedProductIds() {
                    let productIds = this.addedProducts[this.selectedType].map(product => product.id);

                    productIds.push(this.currentProduct.id);

                    return productIds;
                }
            },

            methods: {
                addSelected(selectedProducts) {
                    this.addedProducts[this.selectedType] = [...this.addedProducts[this.selectedType], ...selectedProducts];
                },

                remove(type, product) {
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.addedProducts[type] = this.addedProducts[type].filter(item => item.id !== product.id);
                        },
                    });
                },

                totalQty(product) {
                    let qty = 0;

                    product.inventories.forEach(function (inventory) {
                        qty += inventory.qty;
                    });

                    return qty;
                }
            }
        });
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/Resources/views/catalog/products/edit/links.blade.php ENDPATH**/ ?>