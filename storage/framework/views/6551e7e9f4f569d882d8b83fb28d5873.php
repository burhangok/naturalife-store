<div <?php echo $htmlAttributes; ?>></div>

<?php if($errors->has('g-recaptcha-response')): ?>
    <span class="control-error">
        <?php echo e($errors->first('g-recaptcha-response')); ?>

    </span>
<?php endif; ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Customer/src/Resources/views/captcha/view.blade.php ENDPATH**/ ?>