<?php $productViewHelper = app('Webkul\Product\Helpers\View'); ?>

<?php echo view_render_event('bagisto.shop.products.view.attributes.before', ['product' => $product]); ?>


<?php if($customAttributeValues = $productViewHelper->getAdditionalData($product)): ?>
    <accordian
        :title="trans('shop::app.products.specification')"
        :active="false"
    >
        <div slot="header">
            <?php echo app('translator')->get('shop::app.products.specification'); ?>

            <i class="icon expand-icon right"></i>
        </div>

        <div slot="body">
            <table class="full-specifications">
                <?php $__currentLoopData = $customAttributeValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($attribute['label'] ?? $attribute['admin_name']); ?></td>

                        <?php if(
                            $attribute['type'] == 'file'
                            && $attribute['value']
                        ): ?>
                            <td>
                                <a href="<?php echo e(route('shop.product.file.download', [$product->id, $attribute['id']])); ?>">
                                    <i class="icon sort-down-icon download"></i>
                                </a>
                            </td>
                        <?php elseif(
                            $attribute['type'] == 'image'
                            && $attribute['value']
                        ): ?>
                            <td>
                                <a href="<?php echo e(route('shop.product.file.download', [$product->id, $attribute['id']])); ?>">
                                    <img
                                        src="<?php echo e(Storage::url($attribute['value'])); ?>"
                                        style="height: 20px; width: 20px;"
                                        alt=""
                                    />
                                </a>
                            </td>
                        <?php else: ?>
                            <td><?php echo e($attribute['value']); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </table>
        </div>
    </accordian>
<?php endif; ?>

<?php echo view_render_event('bagisto.shop.products.view.attributes.after', ['product' => $product]); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Shop/src/resources/views/products/view/attributes.blade.php ENDPATH**/ ?>