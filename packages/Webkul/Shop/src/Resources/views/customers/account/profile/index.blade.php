<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.profile.index.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="profile" />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto max-md:mx-6 max-sm:mx-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <!-- Back Button -->
                <a
                    class="grid md:hidden"
                    href="{{ route('shop.customers.account.index') }}"
                >


                    <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
                </a>

                <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    @lang('shop::app.customers.account.profile.index.title')
                </h2>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.before') !!}

@if($isAffiliate)
  <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    Temsilci Kodu: {{$isAffiliate->affiliate_code}}
                </h2>
@endif
            <a
                href="{{ route('shop.customers.account.profile.edit') }}"
                class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
            >

                @lang('shop::app.customers.account.profile.index.edit')
            </a>

            <!-- Shop Modal-->
<!-- Müşteri hesabı profil sayfasına ekleyin -->
<x-shop::modal ref="affiliateModal">
    <x-slot:header>
        Temsilcilik Başvurusu
    </x-slot>

    <x-slot:content>
        <form
            method="POST"
            action="{{ route('shop.customers.affiliate.store') }}"
            id="affiliate-form"
        >
            @csrf

            <div class="mb-4">
                <label for="sponsor_code" class="block mb-1">
                    {{ __('Sponsor Kodu') }}
                </label>
                <input
                    type="text"
                    id="affiliate_code"
                    name="affiliate_code"
                    class="w-full p-2 border border-gray-300 rounded"
                    placeholder="{{ __('Üst temsilci kodunu girin') }}"
                    required
                />
            </div>

            <div class="flex justify-end mt-4 gap-2">
                <button
                    type="button"
                    class="bg-gray-200 px-4 py-2 rounded"
                    @click="$refs.affiliateModal.close()"
                >
                    {{ __('İptal') }}
                </button>

               <button type="submit" class="primary-button flex rounded-2xl px-11 py-3 max-md:rounded-lg max-md:px-6 max-md:text-sm">
    Gönder
</button>
            </div>
        </form>
    </x-slot>
</x-shop::modal>

<!-- Butonu koşullu olarak ekleyin -->
@if(!$isAffiliate)
    <button
        id="become-affiliate-btn"
        class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-2 max-sm:py-1.5 max-sm:text-sm"
        @click="$refs.affiliateModal.open()"
    >
        @lang('shop::app.customers.account.profile.index.becomeaffiliate')
    </button>
@endif

<!-- JavaScript ekleyin -->
@push('scripts')
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
@endpush


            {!! view_render_event('bagisto.shop.customers.account.profile.edit_button.after') !!}
        </div>




        <!-- Profile Information -->
        <div class="mt-8 grid grid-cols-1 gap-y-6 max-md:mt-5 max-sm:gap-y-4">
            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.before') !!}

            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    @lang('shop::app.customers.account.profile.index.first-name')
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    {{ $customer->first_name }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.first_name.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.before') !!}

            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    @lang('shop::app.customers.account.profile.index.last-name')
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    {{ $customer->last_name }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.last_name.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.gender.before') !!}

            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    @lang('shop::app.customers.account.profile.index.gender')
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    {{ $customer->gender ?? '-'}}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.gender.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.before') !!}

            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    @lang('shop::app.customers.account.profile.index.dob')
                </p>

                <p class="text-sm font-medium text-zinc-500">
                    {{ $customer->date_of_birth ?? '-' }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.date_of_birth.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.email.before') !!}

            <div class="grid w-full grid-cols-[2fr_3fr] border-b border-zinc-200 px-8 py-3 max-md:px-0">
                <p class="text-sm font-medium">
                    @lang('shop::app.customers.account.profile.index.email')
                </p>

                <p class="text-sm font-medium text-zinc-500 no-underline">
                    {{ $customer->email }}
                </p>
            </div>

            {!! view_render_event('bagisto.shop.customers.account.profile.email.after') !!}

            {!! view_render_event('bagisto.shop.customers.account.profile.delete.before') !!}

            <!-- Profile Delete modal -->
            <x-shop::form action="{{ route('shop.customers.account.profile.destroy') }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <div class="primary-button rounded-2xl px-11 py-3 max-md:hidden max-md:rounded-lg">
                            @lang('shop::app.customers.account.profile.index.delete-profile')
                        </div>

                        <div class="rounded-2xl py-3 text-center font-medium text-red-500 max-md:w-full max-md:max-w-full max-md:py-1.5 md:hidden">
                            @lang('shop::app.customers.account.profile.index.delete-profile')
                        </div>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="text-2xl font-medium max-md:text-base">
                            @lang('shop::app.customers.account.profile.index.enter-password')
                        </h2>
                    </x-slot>

                    <x-slot:content>
                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control
                                type="password"
                                name="password"
                                class="px-6 py-4"
                                rules="required"
                                placeholder="Enter your password"
                            />

                            <x-shop::form.control-group.error
                                class="text-left"
                                control-name="password"
                            />
                        </x-shop::form.control-group>
                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>

                    <button
                            type="submit"
                            class="primary-button flex rounded-2xl px-11 py-3 max-md:rounded-lg max-md:px-6 max-md:text-sm"
                        >
                            @lang('shop::app.customers.account.profile.index.delete')
                        </button>

                    </x-slot>
                </x-shop::modal>
            </x-shop::form>

            {!! view_render_event('bagisto.shop.customers.account.profile.delete.after') !!}

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
</x-shop::layouts.account>
