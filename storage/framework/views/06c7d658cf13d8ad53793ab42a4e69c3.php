<?php $__env->startComponent('shop::emails.layout'); ?>
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #121A26;line-height: 24px;margin-bottom: 24px">
            <?php echo app('translator')->get('shop::app.emails.dear', ['customer_name' => $userName]); ?>, 👋
        </p>

        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            <?php echo app('translator')->get('shop::app.emails.customers.forgot-password.greeting'); ?>
        </p>
    </div>

    <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
        <?php echo app('translator')->get('shop::app.emails.customers.forgot-password.description'); ?>
    </p>

    <div style="display: flex;margin-bottom: 95px">
        <a
            href="<?php echo e(route('shop.customers.reset_password.create', $token)); ?>"
            style="padding: 16px 45px;justify-content: center;align-items: center;gap: 10px;border-radius: 2px;background: #060C3B;color: #FFFFFF;text-decoration: none;text-transform: uppercase;font-weight: 700;"
        >
            <?php echo app('translator')->get('shop::app.emails.customers.forgot-password.reset-password'); ?>
        </a>
    </div>
<?php echo $__env->renderComponent(); ?><?php /**PATH /Users/alfanova/Documents/web projeleri/eticaret/naturalife-store/packages/Webkul/Shop/src/Resources/views/emails/customers/forgot-password.blade.php ENDPATH**/ ?>