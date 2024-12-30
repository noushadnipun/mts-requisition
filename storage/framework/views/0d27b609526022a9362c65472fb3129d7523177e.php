<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.0.0/animate.min.css"/>
<script src="https://unpkg.com/bulma-toast@2.2.0/dist/bulma-toast.min.js"></script>

<?php if(Session::has('message') || Session::has('status')): ?>
    <?php if(Session::get('status') == 0): ?>
        <?php
            $color_class = 'is-danger';
        ?>
    <?php else: ?>
        <?php
            $color_class = 'is-success';
        ?>
    <?php endif; ?>
    <script>
        bulmaToast.toast({
            message: '<?php echo e(Session::get('message')); ?>',
            type: '<?php echo e($color_class); ?>',
            position: 'bottom-left',
            dismissible: true,
            closeOnClick: true,
            duration: 4000,
            pauseOnHover: true,
            animate: {in: 'fadeIn', out: 'fadeOut'},
        })
    </script>

    <noscript>
        <div style="margin: 10px;">
            <div class="notification is-danger"><?php echo e(Session::get('message')); ?></div>
        </div>
    </noscript>
<?php endif; ?>

<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            bulmaToast.toast({
                message: '<?php echo e($error); ?>',
                type: 'is-warning',
                position: 'bottom-left',
                dismissible: true,
                closeOnClick: true,
                duration: 4000,
                pauseOnHover: true,
                animate: {in: 'fadeIn', out: 'fadeOut'},
            })
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<style>
    .notification {
        font-size: 18px;
    }
</style>
<?php /**PATH C:\laragon\www\mts\requisition\resources\views/layouts/notification.blade.php ENDPATH**/ ?>