<?php $__env->startSection('column_left'); ?>
    <?php
    $today = date('Y-m-d');
   


    $resourcesAvailable = \DB::select("SELECT * FROM (SELECT *,
                                                (SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$today') AS site_head,
                                                (SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$today') AS manager,
                                                (SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND tasks_site.task_for = '$today' GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                                                users.id AS useriddddd
                                        FROM users WHERE users.role = 2 AND users.employee_status  NOT IN ( 'Terminated', 'Left Job', 'Long Leave', 'On Hold')
                                    ) AS mm WHERE mm.site_head IS NULL AND mm.resource_used IS NULL");


    $dateForEmergency = date('Y-m-d');



    /*  Nipun */

    $siteHeadBookedForEmergency = \App\Models\User::leftjoin('tasks', 'users.id', 'tasks.site_head')
                                                ->select('users.id', 'users.name', 'users.designation', 'users.department', 'tasks.site_head as site_head')
                                                ->where('tasks.task_for' ,  $dateForEmergency)
                                                  ->where('tasks.task_type' ,  'emergency')
                                                ->where('users.role', 2)
                                                ->get();


    $resourcesBookedForEmergency = \App\Models\User::leftjoin('tasks_site', 'users.id', 'tasks_site.resource_id')
                                                ->select('users.id', 'users.name', 'users.department', 'users.designation')
                                                ->where('tasks_site.task_for' ,  $dateForEmergency)
                                                  ->where('tasks_site.task_type' ,  'emergency')
                                                ->where('users.role', 2)
                                               ->groupBy('tasks_site.resource_id')
                                                ->get();

                                                  //dd($resourcesBookedForEmergency);


                                    //End

    $dateForGeneral = date("Y-m-d", strtotime("+1 day"));



   /*  Nipun */

        $siteHeadBookedForGeneral = \App\Models\User::leftjoin('tasks', 'users.id', 'tasks.site_head')
                                                    ->select('users.id', 'users.name', 'users.designation', 'users.department',  'tasks.site_head as site_head')
                                                    ->where('tasks.task_for' ,  $dateForGeneral)
                                                      ->where('tasks.task_type' ,  'general')
                                                    ->where('users.role', 2)
                                                    ->get();


        $resourcesBookedForGeneral = \App\Models\User::leftjoin('tasks_site', 'users.id', 'tasks_site.resource_id')
                                                    ->select('users.id', 'users.name', 'users.designation', 'users.department')
                                                    ->where('tasks_site.task_for' ,  $dateForGeneral)
                                                      ->where('tasks_site.task_type' ,  'general')
                                                    ->where('users.role', 2)
                                                   ->groupBy('tasks_site.resource_id')
                                                    ->get();

       





        /* this day booked for general */
        $thisDateForGeneral = date('Y-m-d');

        $thisDateSiteHeadBookedForGeneral = \App\Models\User::leftjoin('tasks', 'users.id', 'tasks.site_head')
        ->select('users.id', 'users.name', 'users.designation', 'users.department',  'tasks.site_head as site_head')
        ->where('tasks.task_for' ,  $thisDateForGeneral)
        ->where('tasks.task_type' ,  'general')
        ->where('users.role', 2)
        ->get();


        $thisDateResourcesBookedForGeneral = \App\Models\User::leftjoin('tasks_site', 'users.id', 'tasks_site.resource_id')
        ->select('users.id', 'users.name', 'users.designation', 'users.department')
        ->where('tasks_site.task_for' ,  $thisDateForGeneral)
        ->where('tasks_site.task_type' ,  'general')
        ->where('users.role', 2)
        ->groupBy('tasks_site.resource_id')
        ->get();



        //End

    ?>
    <div class="columns is-vcentered  pt-2">
        <div class="column is-12 mx-auto">
            <div class="card tile is-child xquick_view">
                <div class="card-content">
                    <div class="card-data">
                            <div class="columns">
                            <!--  Available Resource / Site Head  General Task-->
                                <div class="column is-3 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-primary-dark" colspan="5">A Resource or Site Head is Avaialble for today</th>
                                        </tr>
                                        <tr>
                                          <th class="has-background-primary-info">S/N</th>
                                            <th class="has-background-primary-info">Name</th>
                                            <th class="has-background-primary-info">Designation</th>
                                          <th class="has-background-primary-info">Department</th>
                                           <th class="has-background-primary-info">Status</th>
                                        </tr>
                                        <?php $__currentLoopData = $resourcesAvailable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                              <td><?php echo e(++$key); ?></td>
                                                <td style="">
                                                   <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                                 <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                              <td>  <?php echo e($user->employee_status ?? NULL); ?> </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>

                              <!--- Booked  Resource / SIte Head Emergency Task  -->
                                <div class="column is-3 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-danger-dark" colspan="5">A Resource or Site Head is Booked for <?php echo e($dateForEmergency); ?>   -  Emergency</th>
                                        </tr>
                                        <tr>
                                              <th class="has-background-primary-info" style="width: 10px;">S/N</th>
                                            <th class="has-background-primary-info">Name</th>
                                            <th class="has-background-primary-info">Designation</th>
                                           <th class="has-background-primary-info">Department</th>
                                              <th class="has-background-primary-info">Role</th>
                                        </tr>
                                      <!--- Booked  Site Head  Emergency Task  -->
                                      <?php $__currentLoopData = $siteHeadBookedForEmergency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                              <td><?php echo e(++$key); ?></td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>

                                                  <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                	<?php
                                                    	if(!empty($user->site_head)){
                                                        	echo 'Site Head';
                                                        } else {
                                                        	echo 'Resource';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      	<!--- Booked  Resource  Emergency Task  -->
                                        <?php $__currentLoopData = $resourcesBookedForEmergency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                              <td> <?php echo e(count($siteHeadBookedForEmergency) + (++$key)); ?> </td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                              <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                	<?php
                                                    	if(!empty($user->site_head)){
                                                        	echo 'Site Head';
                                                        } else {
                                                        	echo 'Resource';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>

                                <!-- This Date Booked Resource / Site Head  General Task-->

                                <div class="column is-3 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-warning-dark" colspan="5">A Resource or Site Head is Booked for <?php echo e($thisDateForGeneral); ?>  -  General</th>
                                        </tr>
                                        <tr>
                                            <th class="has-background-primary-info">S/N</th>
                                            <th class="has-background-primary-info">Name</th>
                                            <th class="has-background-primary-info">Designation</th>
                                            <th class="has-background-primary-info">Department</th>
                                            <th class="has-background-primary-info">Role</th>
                                        </tr>
                                        <!--- This Date Booked  Site Head General Task  -->
                                        <?php $__currentLoopData = $thisDateSiteHeadBookedForGeneral; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(++$key); ?></td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                                <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                    <?php
                                                    if(!empty($user->site_head)){
                                                        echo 'Site Head';
                                                    } else {
                                                        echo 'Resource';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <!--- This Date Booked  Resource General Task  -->
                                        <?php $__currentLoopData = $thisDateResourcesBookedForGeneral; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(count($siteHeadBookedForGeneral) + (++$key)); ?> </td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                                <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                    <?php
                                                    if(!empty($user->site_head)){
                                                        echo 'Site Head';
                                                    } else {
                                                        echo 'Resource';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>

                              	<!--  Booked Resource / Site Head  General Task-->
                                <div class="column is-3 mx-auto">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <th class="has-background-link-dark" colspan="5">A Resource or Site Head is Booked for <?php echo e($dateForGeneral); ?>  -  General</th>
                                        </tr>
                                        <tr>
                                          	<th class="has-background-primary-info">S/N</th>
                                            <th class="has-background-primary-info">Name</th>
                                            <th class="has-background-primary-info">Designation</th>
                                            <th class="has-background-primary-info">Department</th>
                                             <th class="has-background-primary-info">Role</th>
                                        </tr>
                                       <!--- Booked  Site Head General Task  -->
                                      <?php $__currentLoopData = $siteHeadBookedForGeneral; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                              <td><?php echo e(++$key); ?></td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                                  <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                	<?php
                                                    	if(!empty($user->site_head)){
                                                        	echo 'Site Head';
                                                        } else {
                                                        	echo 'Resource';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                      <!--- Booked  Resource General Task  -->
                                        <?php $__currentLoopData = $resourcesBookedForGeneral; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                              <td> <?php echo e(count($siteHeadBookedForGeneral) + (++$key)); ?> </td>
                                                <td style="">
                                                    <a target="_blank" href="<?php echo e(route('hidtory.user', $user->id)); ?>"><?php echo e($user->name); ?></a>
                                                </td>
                                                <td style="">
                                                    <?php echo e(\DB::table('designations')->where('id', $user->designation)->first()->name); ?>

                                                </td>
                                                  <td>  <?php echo e($user->department ?? NULL); ?> </td>
                                                <td>
                                                	<?php
                                                    	if(!empty($user->site_head)){
                                                        	echo 'Site Head';
                                                        } else {
                                                        	echo 'Resource';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </div>


                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>




<?php $__env->startSection('cusjs'); ?>
    <style>
        .columns .column .is-3 {
            display: unset;
            display: unset;
            flex-wrap: unset;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/live_resource_usage.blade.php ENDPATH**/ ?>