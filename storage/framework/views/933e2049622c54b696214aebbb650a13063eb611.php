
<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php if($__env->yieldContent('title')): ?>
            <?php echo $__env->yieldContent('title'); ?>
        <?php else: ?>
            <?php echo e('Mobile Tele Solutions &#8211; A Service to Remember'); ?>

        <?php endif; ?>
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/styles.css')); ?>?<?php echo rand(0,999);?>"/>
    <script type="text/javascript"> var baseurl = "<?php echo url('/'); ?>";</script>
</head>
<body class="o_web_client o_home_menu_background">

<?php echo $__env->make('layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="hero is-fullheight">
    <?php echo $__env->yieldContent('full_width_content'); ?>
    <div class="hero-body">
        <div class="container">
            <?php if(!empty($__env->yieldContent('dashboard'))): ?>
                <?php echo $__env->yieldContent('dashboard'); ?>
            <?php else: ?>
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
</section>
<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('cusjs'); ?>
</body>
</html>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/layouts/noapp.blade.php ENDPATH**/ ?>