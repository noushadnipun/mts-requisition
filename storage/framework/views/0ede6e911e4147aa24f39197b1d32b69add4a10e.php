<?php $__env->startSection('title', 'MTS App Dashboard'); ?>
<?php $__env->startSection('sub_title', 'all parent menu here'); ?>

<?php $__env->startSection('dashboard'); ?>
    <div class="dashboard_bg">

    </div>
    <style>
        div.dashboard_bg {
            position: relative;
            z-index: 1;
        }

        div.dashboard_bg::after {
            content: "";
            background-image: url('<?php echo e(asset('/public/images/MTS-Logo.png')); ?>');
            background-size: 80% 111%;
            background-color: #0000;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position-x: center;
            background-position-y: bottom;
            opacity: 0.2;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100vh;
            width: 100vw;
        }
    .section {
        padding: 3rem 1.5rem;
        z-index: 10;
        position: relative;
        position: relative;
        z-index: 10;
    }
    </style>


    <section class="section">
        <div class="columns">
            <div class="column is-2"></div>
            <div class="column is-8">
                <div class="columns">
                    <div class="column colorWhite has-text-centered-mobile">
                        Welcome, <br/><strong><?php echo e(Auth::user()->name ?? NULL); ?></strong>&nbsp;
                        as <?php echo e(\App\Models\Role::where('id', Auth::user()->role)->first()->name); ?><br/>
                        <a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                      
                      <div class="notification is-warning is-light mt-2 py-1">
                        <b>Notice:</b>
                        <ul>
                          <li> <span class="tag is-success">Manager</span>	The Last Time of Task Creation is <?php echo e(numberToTimeFormat(\App\Models\Setting::timeSettings('task_creation_end'))); ?></li>
                          <li>  <span class="tag is-primary">Site Head</span> The Last Time of Task Proof Submission is	<?php echo e(numberToTimeFormat(\App\Models\Setting::timeSettings('proof_submission_end'))); ?> </li>
                          <li>	<span class="tag is-info">Approver</span> The Last Time of Task Approval is	<?php echo e(numberToTimeFormat(\App\Models\Setting::timeSettings('approval_time_end'))); ?></li>
                          <li>	<span class="tag is-success">Manager</span> The Last Time of Requisition Submission is	<?php echo e(numberToTimeFormat(\App\Models\Setting::timeSettings('requsition_submission_manager_end'))); ?></li>
                          <li>	<span class="tag is-link">&nbsp; CFO &nbsp; &nbsp;</span> The Last Time of Requisition Approve is	<?php echo e(numberToTimeFormat(\App\Models\Setting::timeSettings('requsition_submission_cfo_end'))); ?></li>
                        </ul>                        
                        <p class="has-text-danger"> If the task created date expires, You will no longer be able to any action that task. </p>                        
                      </div>
                    </div>
                </div>
                <?php if(auth()->user()->employee_status == 'On Hold'): ?>
                    <div class="columns is-multiline">
                        <div class="column is-12">
                            <div class="isCentered">
                                <div class="notification is-warning" style="margin-left: 25px;">
                                    <h1 class="subtitle">Your account on hold. Ask administrator or human resource manager for help.</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="columns is-mobile is-multiline">
                        <?php
                        //dd(Auth::user()->role);
                        $routelist = \App\Models\Routelist::where('show_menu', '=', 1)
                            ->where('is_active', '=', 1)
                            ->get();
                        //dd($routelist);
                        ?>
                        <?php $__currentLoopData = $routelist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $selected = explode(",", $menu->to_role);
                            ?>

                            <?php if(!empty(Auth::user()->role)): ?>
                                <?php if(in_array(Auth::user()->role, $selected) && $menu->dashboard_menu == 1): ?>
                                    <div class="column is-6-mobile is-2-desktop">
                                        <div class="isCentered">
                                            <?php if(!empty($menu->route_url)): ?>
                                                <?php if($menu->route_url == '#' || $menu->route_url == NULL): ?>
                                                    <?php $link = '#'; ?>
                                                <?php else: ?>
                                                    <?php
                                                    $link = route($menu->route_url) . '?route_id=' . $menu->id;
                                                    ?>
                                                <?php endif; ?>
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
                <?php endif; ?>
            </div>
            <div class="column is-2"></div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


































































































<?php echo $__env->make('layouts.noapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/dashboard.blade.php ENDPATH**/ ?>