<?php $__env->startSection('title'); ?>
    Overridden Data by Manager
<?php $__env->stopSection(); ?>


<?php $__env->startSection('column_left'); ?>

<?php

    $query = \Tritiyo\Task\Models\Task::select('manager_override_chunck')->where('id', $task_id)->first()->toArray();

    $json_extracted = (object)json_decode($query['manager_override_chunck']);

    $task = $json_extracted->task[0];
    $task_site_data = $json_extracted->task_site;
    $task_vehicle = $json_extracted->task_vehicle;
    $task_material = $json_extracted->task_material;


    function group_by($key, $array) {
        $result = [];
        foreach($array as $val) {
                $result[$val->$key] = $val;
        }
        return $result;
    }

    $task_sites = group_by('site_id', $task_site_data);
    $task_resources = group_by('resource_id', $task_site_data);
   
?>

<div class="columns is-vcentered">
    <div class="column is-6 mx-auto">

        <div class="card tile is-child xquick_view pt-0">

            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                        Overridden Data by Manager | Task General Information
            </header>

            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">

                        <tr>
                            <td><strong>Task Type</strong></td>
                            <td><span class="tag is-info"><?php echo e(ucwords($task->task_type) ?? NULL); ?></span></td>
                            <td><strong>Task Name</strong></td>
                            <td><?php echo e($task->task_name ?? NULL); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Site Head</strong></td>
                            <td>
                                <span class="has-text-info">
                                    <?php echo e(\App\Models\User::where('id', $task->site_head)->first()->name); ?> (<?php echo e($task->site_head ?? NULL); ?>)
                                </span>
                            </td>
                            <td><strong>Task Code</strong></td>
                            <td colspan="3"><?php echo e($task->task_code ?? NULL); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Task Created Time</strong></td>
                            <td><?php echo e($task->created_at); ?></td>
                            <td><strong>Task Created For</strong></td>
                            <td><?php echo e($task->task_for ?? NULL); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Project Name</strong></td>
                            <td>
                                <a href="<?php echo e(route('projects.show', $task->project_id)); ?>" target="_blank">
                                    <?php echo e(\Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name); ?>

                                </a>
                            </td>
                            <td><strong>Project Manager</strong></td>
                            <td><?php echo e(\App\Models\User::where('id', $task->user_id)->first()->name); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong>Task Details</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4"><?php echo e($task->task_details ?? NULL); ?></td>
                        </tr>

                        <?php if(!empty($task->anonymous_proof_details)): ?>
                            <tr>
                                <td colspan="4"><strong>Anonymous Proof</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <?php echo preg_replace("/[\n]/","<br/>", $task->anonymous_proof_details);?>                     
                                </td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php if(!empty($task_sites)): ?>
                            <tr>
                                <td colspan="4"><strong>Site and resource information</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php $__currentLoopData = $task_sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('sites.show', $data->site_id)); ?>" target="_blank">
                                            <?php echo e(\Tritiyo\Site\Models\Site::where('id', $data->site_id)->first()->site_code); ?>

                                        </a>
                                        <br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td colspan="2">
                                   
                                    <?php $__currentLoopData = $task_resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(\App\Models\User::where('id', $data->resource_id )->first()->name); ?>

                                        <br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if(is_array($task_vehicle) || is_array($task_material->count)): ?>
                            <tr>
                                <td colspan="2"><strong>Vehicle information</strong></td>
                                <td colspan="2"><strong>Material information</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <td>Name</td>
                                            <td>Rent</td>
                                        </tr>
                                        <?php if(is_array($task_vehicle)): ?>
                                            <?php $__currentLoopData = $task_vehicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(\Tritiyo\Vehicle\Models\Vehicle::where('id', $data->vehicle_id)->first()->name); ?></td>
                                                    <td><?php echo e($data->vehicle_rent); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                                <td colspan="2">
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <td>Material</td>
                                            <td>Qty</td>
                                            <td>Amount</td>
                                        </tr>
                                        <?php if(is_array($task_material)): ?>
                                            <?php $__currentLoopData = $task_material; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(\Tritiyo\Material\Models\Material::where('id', $data->material_id)->first()->name); ?></td>
                                                    <td><?php echo e($data->material_qty); ?></td>
                                                    <td><?php echo e($data->material_amount); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </table>
                                </td>
                            </tr>

                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/manager_overridden_data.blade.php ENDPATH**/ ?>