<?php $__env->startSection('content'); ?>

    <div class="box is-centered">
        <h1 class="title has-text-success is-justify-content-center">
            <?php echo e(env('APP_NAME')); ?>

            
        </h1>
        <form action="<?php echo e(route('login')); ?>" method="post">
            <?php echo csrf_field(); ?>

            <div class="field">
                <label for="" class="label"><?php echo e(__('E-Mail Address')); ?></label>
                <div class="control has-icons-left">
                    <input type="email" placeholder="e.g. info@bizbosserp.com"
                           class="input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                           value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                    <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="field">
                <label for="" class="label"><?php echo e(__('Password')); ?></label>
                <div class="control has-icons-left">
                    <input type="password" placeholder="*******" class="input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="password"
                           required autocomplete="current-password" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert"><strong><?php echo e($message); ?></strong></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="field">
                <label for="" class="checkbox">
                    <input type="checkbox">
                    <?php echo e(__('Remember Me')); ?>

                </label>
            </div>
            <div class="field">
                <button class="button is-success is-small">
                    <?php echo e(__('Login')); ?>

                </button>
            </div>
            <div class="field">
                <?php if(Route::has('password.request')): ?>
                    <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                        <?php echo e(__('Forgot Your Password?')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.noapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\resources\views/auth/login.blade.php ENDPATH**/ ?>