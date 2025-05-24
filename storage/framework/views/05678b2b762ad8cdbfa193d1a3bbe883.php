<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name'  => '',
    'value' => 1,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name'  => '',
    'value' => 1,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<v-quantity-changer
    <?php echo e($attributes->merge(['class' => 'flex items-center border dark:border-gray-300'])); ?>

    name="<?php echo e($name); ?>"
    value="<?php echo e($value); ?>"
>
</v-quantity-changer>

<?php if (! $__env->hasRenderedOnce('b90b20a2-df54-4103-87df-935393d7a070')): $__env->markAsRenderedOnce('b90b20a2-df54-4103-87df-935393d7a070');
$__env->startPush('scripts'); ?>
    <script
        type="text/x-template"
        id="v-quantity-changer-template"
    >
        <div>
            <span 
                class="cursor-pointer text-2xl dark:text-gray-300"
                @click="decrease"
            >
                -
            </span>

            <p class="w-2.5 select-none text-center dark:text-gray-300">
                {{ quantity }}
            </p>
            
            <span 
                class="cursor-pointer text-2xl dark:text-gray-300"
                @click="increase"
            >
                +
            </span>

            <v-field
                type="hidden"
                :name="name"
                v-model="quantity"
            ></v-field>
        </div>
    </script>

    <script type="module">
        app.component("v-quantity-changer", {
            template: '#v-quantity-changer-template',

            props:['name', 'value'],

            data() {
                return  {
                    quantity: this.value,
                }
            },

            watch: {
                value() {
                    this.quantity = this.value;
                },
            },

            methods: {
                increase() {
                    this.$emit('change', ++this.quantity);
                },

                decrease() {
                    if (this.quantity > 1) {
                        this.quantity -= 1;
                        
                        this.$emit('change', this.quantity);
                    }
                },
            }
        });
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Admin/src/Resources/views/components/quantity-changer/index.blade.php ENDPATH**/ ?>