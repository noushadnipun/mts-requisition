<?php $__env->startSection('title', 'Biz Boss Dashboard'); ?>
<?php $__env->startSection('sub_title', 'all parent menu here'); ?>

<?php $__env->startSection('dashboard'); ?>
    <section class="section">
        <div class="columns">
            <div class="column is-2"></div>
            <div class="column is-8">
                <div class="columns is-multiline">
                    <div class="column colorWhite">
                        Welcome, <br/><strong><?php echo e(Auth::user()->name); ?></strong>&nbsp;
                        as <?php echo e(\App\Models\Role::where('id', Auth::user()->role)->first()->name); ?><br/>
                        <a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>

                        <br/>
                        <br/>
                        <strong>You don't have permission to access this page</strong>
                    </div>
                </div>
                <div class="columns is-multiline">
                    <?php
                    $dashboard_menus = \App\Models\Routelist::where('show_menu', '=', 1)
                        ->where('is_active', '=', 1)
                        ->get();
                    ?>
                    <?php $__currentLoopData = $dashboard_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty(Auth::user()->role)): ?>
                            <?php if($menu->to_role == Auth::user()->role ?? 6 && $menu->dashboard_menu == 1): ?>
                                <div class="column is-2">
                                    <div class="isCentered">
                                        <?php if($menu->route_url == '#' || $menu->route_url == NULL): ?>
                                            <?php $link = '#'; ?>
                                        <?php else: ?>
                                            <?php $link = route($menu->route_url) . '?route_id=' . $menu->id; ?>
                                        <?php endif; ?>
                                        <a href="<?php echo e($link ?? NULL); ?>"
                                           class="button <?php echo e($menu->bulma_class_icon_bg); ?> is-large is-accent">
                                            <span><i class="<?php echo e($menu->font_awesome); ?>"></i></span>
                                        </a>
                                        <div class="o_caption"><?php echo e($menu->route_name); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="column is-2"></div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.noapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/oops.blade.php ENDPATH**/ ?>