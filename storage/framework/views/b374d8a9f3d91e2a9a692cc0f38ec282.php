<?php if (isset($component)) { $__componentOriginal4c4dbe009fe892108b054e8b47e63427 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4c4dbe009fe892108b054e8b47e63427 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.layouts.account.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::layouts.account'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Page Title -->
     <?php $__env->slot('title', null, []); ?> 
        <?php echo app('translator')->get('shop::app.customers.account.profile.index.title'); ?>
     <?php $__env->endSlot(); ?>

    <!-- Breadcrumbs -->
    <?php if((core()->getConfigData('general.general.breadcrumbs.shop'))): ?>
        <?php $__env->startSection('breadcrumbs'); ?>
            <?php if (isset($component)) { $__componentOriginaldef12fd0653509715c3bc62a609dde73 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldef12fd0653509715c3bc62a609dde73 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.breadcrumbs.index','data' => ['name' => 'profile']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'profile']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldef12fd0653509715c3bc62a609dde73)): ?>
<?php $attributes = $__attributesOriginaldef12fd0653509715c3bc62a609dde73; ?>
<?php unset($__attributesOriginaldef12fd0653509715c3bc62a609dde73); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldef12fd0653509715c3bc62a609dde73)): ?>
<?php $component = $__componentOriginaldef12fd0653509715c3bc62a609dde73; ?>
<?php unset($__componentOriginaldef12fd0653509715c3bc62a609dde73); ?>
<?php endif; ?>
        <?php $__env->stopSection(); ?>
    <?php endif; ?>

    <div class="max-md:hidden">
        <?php if (isset($component)) { $__componentOriginalf60f1298dff473a76a071049d503ffbb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf60f1298dff473a76a071049d503ffbb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.layouts.account.navigation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::layouts.account.navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf60f1298dff473a76a071049d503ffbb)): ?>
<?php $attributes = $__attributesOriginalf60f1298dff473a76a071049d503ffbb; ?>
<?php unset($__attributesOriginalf60f1298dff473a76a071049d503ffbb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf60f1298dff473a76a071049d503ffbb)): ?>
<?php $component = $__componentOriginalf60f1298dff473a76a071049d503ffbb; ?>
<?php unset($__componentOriginalf60f1298dff473a76a071049d503ffbb); ?>
<?php endif; ?>
    </div>

    <div class="mx-4 flex-auto max-md:mx-6 max-sm:mx-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <!-- Back Button -->
                <a
                    class="grid md:hidden"
                    href="<?php echo e(route('shop.customers.account.index')); ?>"
                >


                    <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
                </a>

                <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.title'); ?>
                </h2>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.edit_button.before'); ?>


<?php if($isAffiliate): ?>
  <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    Temsilci Kodu: <?php echo e($isAffiliate->affiliate_code); ?>

                </h2>
<?php endif; ?>
            <a
                href="<?php echo e(route('shop.customers.account.profile.edit')); ?>"
                class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
            >

                <?php echo app('translator')->get('shop::app.customers.account.profile.index.edit'); ?>
            </a>

            <!-- Shop Modal-->
<!-- Müşteri hesabı profil sayfasına ekleyin -->
<?php if (isset($component)) { $__componentOriginal571c487d27ea546e3c8ba67e4aec0403 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal571c487d27ea546e3c8ba67e4aec0403 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.modal.index','data' => ['ref' => 'affiliateModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['ref' => 'affiliateModal']); ?>
     <?php $__env->slot('header', null, []); ?> 
        Temsilcilik Başvurusu
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('content', null, []); ?> 
        <form
            method="POST"
            action="<?php echo e(route('shop.customers.affiliate.store')); ?>"
            id="affiliate-form"
        >
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label for="sponsor_code" class="block mb-1">
                    <?php echo e(__('Sponsor Kodu')); ?>

                </label>
                <input
                    type="text"
                    id="affiliate_code"
                    name="affiliate_code"
                    class="w-full p-2 border border-gray-300 rounded"
                    placeholder="<?php echo e(__('Üst temsilci kodunu girin')); ?>"
                    required
                />
            </div>

            <div class="flex justify-end mt-4 gap-2">
                <button
                    type="button"
                    class="bg-gray-200 px-4 py-2 rounded"
                    @click="$refs.affiliateModal.close()"
                >
                    <?php echo e(__('İptal')); ?>

                </button>

               <button type="submit" class="primary-button flex rounded-2xl px-11 py-3 max-md:rounded-lg max-md:px-6 max-md:text-sm">
    Gönder
</button>
            </div>
        </form>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal571c487d27ea546e3c8ba67e4aec0403)): ?>
<?php $attributes = $__attributesOriginal571c487d27ea546e3c8ba67e4aec0403; ?>
<?php unset($__attributesOriginal571c487d27ea546e3c8ba67e4aec0403); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal571c487d27ea546e3c8ba67e4aec0403)): ?>
<?php $component = $__componentOriginal571c487d27ea546e3c8ba67e4aec0403; ?>
<?php unset($__componentOriginal571c487d27ea546e3c8ba67e4aec0403); ?>
<?php endif; ?>

<!-- Butonu koşullu olarak ekleyin -->
<?php if(!$isAffiliate): ?>
    <button
        id="become-affiliate-btn"
        class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
        @click="$refs.affiliateModal.open()"
    >
        <?php echo app('translator')->get('shop::app.customers.account.profile.index.becomeaffiliate'); ?>
    </button>
<?php endif; ?>

<!-- JavaScript ekleyin -->
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (() => {
        // Form gönderimini işlemek için
        document.getElementById('affiliate-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Başarılı işlem
                    window.location.reload();
                } else {
                    // Hata işleme
                    console.error('Hata:', data.message);
                }
            })
            .catch(error => {
                console.error('Hata:', error);
            });
        });
    })();
</script>
<?php $__env->stopPush(); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.edit_button.after'); ?>

        </div>




        <!-- Profile Information -->
        <div class="mt-8 grid grid-cols-1 gap-y-6 max-md:mt-5 max-sm:gap-y-4">
            <?php echo view_render_event('bagisto.shop.customers.account.profile.first_name.before'); ?>


            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.first-name'); ?>
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    <?php echo e($customer->first_name); ?>

                </p>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.first_name.after'); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.last_name.before'); ?>


            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.last-name'); ?>
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    <?php echo e($customer->last_name); ?>

                </p>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.last_name.after'); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.gender.before'); ?>


            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.gender'); ?>
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    <?php echo e($customer->gender ?? '-'); ?>

                </p>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.gender.after'); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.date_of_birth.before'); ?>


            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.dob'); ?>
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    <?php echo e($customer->date_of_birth ?? '-'); ?>

                </p>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.date_of_birth.after'); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.email.before'); ?>


            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    <?php echo app('translator')->get('shop::app.customers.account.profile.index.email'); ?>
                </p>

                <p class="text-sm font-medium text-zinc-500 no-underline">
                    <?php echo e($customer->email); ?>

                </p>
            </div>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.email.after'); ?>


            <?php echo view_render_event('bagisto.shop.customers.account.profile.delete.before'); ?>


            <!-- Profile Delete modal -->
            <?php if (isset($component)) { $__componentOriginal4d3fcee3e355fb6c8889181b04f357cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4d3fcee3e355fb6c8889181b04f357cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.form.index','data' => ['action' => ''.e(route('shop.customers.account.profile.destroy')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => ''.e(route('shop.customers.account.profile.destroy')).'']); ?>
                <?php if (isset($component)) { $__componentOriginal571c487d27ea546e3c8ba67e4aec0403 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal571c487d27ea546e3c8ba67e4aec0403 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.modal.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                     <?php $__env->slot('toggle', null, []); ?> 
                        <div class="primary-button rounded-2xl px-11 py-3 max-md:hidden max-md:rounded-lg">
                            <?php echo app('translator')->get('shop::app.customers.account.profile.index.delete-profile'); ?>
                        </div>

                        <div class="rounded-2xl py-3 text-center font-medium text-red-500 max-md:w-full max-md:max-w-full max-md:py-1.5 md:hidden">
                            <?php echo app('translator')->get('shop::app.customers.account.profile.index.delete-profile'); ?>
                        </div>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('header', null, []); ?> 
                        <h2 class="text-2xl font-medium max-md:text-base">
                            <?php echo app('translator')->get('shop::app.customers.account.profile.index.enter-password'); ?>
                        </h2>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <?php if (isset($component)) { $__componentOriginal578beb4bb944f523450535628cf00b41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal578beb4bb944f523450535628cf00b41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.form.control-group.index','data' => ['class' => '!mb-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::form.control-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!mb-0']); ?>
                            <?php if (isset($component)) { $__componentOriginal03b54b937596232babb8a12a8847d013 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03b54b937596232babb8a12a8847d013 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.form.control-group.control','data' => ['type' => 'password','name' => 'password','class' => 'px-6 py-4','rules' => 'required','placeholder' => 'Enter your password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::form.control-group.control'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'password','class' => 'px-6 py-4','rules' => 'required','placeholder' => 'Enter your password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03b54b937596232babb8a12a8847d013)): ?>
<?php $attributes = $__attributesOriginal03b54b937596232babb8a12a8847d013; ?>
<?php unset($__attributesOriginal03b54b937596232babb8a12a8847d013); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03b54b937596232babb8a12a8847d013)): ?>
<?php $component = $__componentOriginal03b54b937596232babb8a12a8847d013; ?>
<?php unset($__componentOriginal03b54b937596232babb8a12a8847d013); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal72f1d7ac608c1db7c92b56fb85299dbf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72f1d7ac608c1db7c92b56fb85299dbf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'shop::components.form.control-group.error','data' => ['class' => 'text-left','controlName' => 'password']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('shop::form.control-group.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-left','control-name' => 'password']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72f1d7ac608c1db7c92b56fb85299dbf)): ?>
<?php $attributes = $__attributesOriginal72f1d7ac608c1db7c92b56fb85299dbf; ?>
<?php unset($__attributesOriginal72f1d7ac608c1db7c92b56fb85299dbf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72f1d7ac608c1db7c92b56fb85299dbf)): ?>
<?php $component = $__componentOriginal72f1d7ac608c1db7c92b56fb85299dbf; ?>
<?php unset($__componentOriginal72f1d7ac608c1db7c92b56fb85299dbf); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal578beb4bb944f523450535628cf00b41)): ?>
<?php $attributes = $__attributesOriginal578beb4bb944f523450535628cf00b41; ?>
<?php unset($__attributesOriginal578beb4bb944f523450535628cf00b41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal578beb4bb944f523450535628cf00b41)): ?>
<?php $component = $__componentOriginal578beb4bb944f523450535628cf00b41; ?>
<?php unset($__componentOriginal578beb4bb944f523450535628cf00b41); ?>
<?php endif; ?>
                     <?php $__env->endSlot(); ?>

                    <!-- Modal Footer -->
                     <?php $__env->slot('footer', null, []); ?> 

                    <button
                            type="submit"
                            class="primary-button flex rounded-2xl px-11 py-3 max-md:rounded-lg max-md:px-6 max-md:text-sm"
                        >
                            <?php echo app('translator')->get('shop::app.customers.account.profile.index.delete'); ?>
                        </button>

                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal571c487d27ea546e3c8ba67e4aec0403)): ?>
<?php $attributes = $__attributesOriginal571c487d27ea546e3c8ba67e4aec0403; ?>
<?php unset($__attributesOriginal571c487d27ea546e3c8ba67e4aec0403); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal571c487d27ea546e3c8ba67e4aec0403)): ?>
<?php $component = $__componentOriginal571c487d27ea546e3c8ba67e4aec0403; ?>
<?php unset($__componentOriginal571c487d27ea546e3c8ba67e4aec0403); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4d3fcee3e355fb6c8889181b04f357cc)): ?>
<?php $attributes = $__attributesOriginal4d3fcee3e355fb6c8889181b04f357cc; ?>
<?php unset($__attributesOriginal4d3fcee3e355fb6c8889181b04f357cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4d3fcee3e355fb6c8889181b04f357cc)): ?>
<?php $component = $__componentOriginal4d3fcee3e355fb6c8889181b04f357cc; ?>
<?php unset($__componentOriginal4d3fcee3e355fb6c8889181b04f357cc); ?>
<?php endif; ?>

            <?php echo view_render_event('bagisto.shop.customers.account.profile.delete.after'); ?>


        </div>
    </div>


<script>
// Sayfanın tamamen yüklenmesini bekleyin
document.addEventListener('DOMContentLoaded', function() {
    // Submit düğmesine tıklama olayını ekle
    const submitButton = document.getElementById('submit-affiliate');
    if (submitButton) {
        submitButton.addEventListener('click', submitAffiliateRequest);
    }

    function submitAffiliateRequest() {
        const sponsorCode = document.getElementById('sponsor-code').value;
        const errorEl = document.getElementById('affiliate-error');

        // Temizle
        errorEl.style.display = 'none';

        // CSRF token alma
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Form verilerini hazırlama
        const formData = new FormData();
        formData.append('sponsor_code', sponsorCode);
        formData.append('_token', token);

        // Gönderme düğmesini devre dışı bırak
        submitButton.disabled = true;
        submitButton.textContent = 'İşleniyor...';

        // AJAX isteği
        fetch('/affiliate/create', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            submitButton.disabled = false;
            submitButton.textContent = 'Onaylıyorum';

            if (data.success) {
                // Modal nesnesini alın
                const modalEl = document.getElementById('affiliate-modal');
                const bootstrapModal = bootstrap.Modal.getInstance(modalEl);

                // Modalı kapat (Bootstrap 5 için)
                if (bootstrapModal) {
                    bootstrapModal.hide();
                }
                // Bootstrap 4 için jQuery ile
                else if (jQuery && jQuery('#affiliate-modal').modal) {
                    jQuery('#affiliate-modal').modal('hide');
                }
                // Diğer durumlarda
                else {
                    modalEl.classList.remove('show');
                    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                        backdrop.parentNode.removeChild(backdrop);
                    });
                    document.body.classList.remove('modal-open');
                    document.body.style.paddingRight = '';
                }

                // Bildirim göster
                alert(data.message || 'Tebrikler! Artık bir temsilcisiniz.');

                // Sayfayı yenile
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                // Hata mesajı göster
                errorEl.textContent = data.message || 'Bir hata oluştu';
                errorEl.style.display = 'block';
            }
        })
        .catch(error => {
            submitButton.disabled = false;
            submitButton.textContent = 'Onaylıyorum';
            errorEl.textContent = 'Bir hata oluştu. Lütfen tekrar deneyin.';
            errorEl.style.display = 'block';
            console.error('Affiliate request error:', error);
        });
    }
});
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4c4dbe009fe892108b054e8b47e63427)): ?>
<?php $attributes = $__attributesOriginal4c4dbe009fe892108b054e8b47e63427; ?>
<?php unset($__attributesOriginal4c4dbe009fe892108b054e8b47e63427); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4c4dbe009fe892108b054e8b47e63427)): ?>
<?php $component = $__componentOriginal4c4dbe009fe892108b054e8b47e63427; ?>
<?php unset($__componentOriginal4c4dbe009fe892108b054e8b47e63427); ?>
<?php endif; ?>
<?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Shop/src/Resources/views/customers/account/profile/index.blade.php ENDPATH**/ ?>