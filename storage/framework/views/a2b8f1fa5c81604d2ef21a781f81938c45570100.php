<div class="card tile is-child">
    <div class="card-content">
        <div class="card-data">
            <div class="level">
                <div class="level-left">
                    <strong>Site based tasks</strong>
                </div>
                <div class="level-right">
                    <div class="level-item ">
                        <form method="get" action="<?php echo e(route('sites.show', $site->id)); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="field has-addons">
                                <a href="<?php echo e(route('download_excel_site')); ?>?id=<?php echo e($site->id); ?>&daterange=<?php echo e(request()->get('daterange') ??  date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days')) . ' - ' . date('Y-m-d')); ?>"
                                   class="button is-primary is-small">
                                    Download as excel
                                </a>
                                <div class="control">
                                    <input class="input is-small" type="text" name="daterange" id="textboxID"
                                           value="<?php echo e(request()->get('daterange') ?? null); ?>">
                                </div>
                                <div class="control">
                                    <input name="search" type="submit"
                                           class="button is-small is-primary has-background-primary-dark"
                                           value="Search"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <tr>
                <th>Task Name</th>
                <th>Task For</th>
                <th>Task Type</th>
                <th>Vehicle Used</th>
                <th>Material Used</th>
                <th>Purchase Note</th>

                <th>Budget</th>
                <th>Approved Req.</th>
                <th>Submitted Bill </th>
                <th>Approved Bill</th>
                <th>Completion Status</th>
            </tr>
            <?php //echo request()->get('daterange');?>
            <?php
                $totalBudget = [];
                $approveReq = [];
                $submittedBill = [];
                $approveBill = [];
                if (request()->get('daterange')) {
                        $dates = explode(' - ', request()->get('daterange'));
                        $start = $dates[0];
                        $end = $dates[1];

                     //$tasks = \Tritiyo\Task\Models\Task::where('site_id', $site->id)->whereBetween('task_for', [$start, $end])->groupBy('task_id')->paginate(50);
                     $tasks = \Tritiyo\Task\Models\TaskSite::leftjoin('tasks', 'tasks.id', 'tasks_site.task_id')
                                                            ->select('tasks_site.*', 'tasks.task_for as tasks_task_for')
                                                            ->where('tasks_site.site_id', $site->id)
                                                            ->whereBetween('tasks.task_for', [$start, $end])
                                                            ->groupBy('tasks_site.task_id')
                                                            ->paginate(50);


                } else {
                    $start = date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'));
                    $end = date('Y-m-d');
                    //$tasks = \Tritiyo\Task\Models\Task::where('project_id', $project->id)->whereBetween('task_for', [$start, $end])->paginate(50);
                    $tasks = \Tritiyo\Task\Models\TaskSite::leftjoin('tasks', 'tasks.id', 'tasks_site.task_id')
                                                            ->select('tasks_site.*', 'tasks.task_for as tasks_task_for')
                                                            ->where('tasks_site.site_id', $site->id)
                                                            //->whereBetween('tasks.task_for', [$start, $end])
                                                            ->groupBy('tasks_site.task_id')
                                                            //->toSql();
                                                            ->paginate('50');
                }
            ?>

            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $task_name = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_name;
                    $task_for = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_for;
                    $task_type = \Tritiyo\Task\Models\Task::where('id', $data->task_id)->first()->task_type;
                ?>
                <tr>
                    <td><a href="<?php echo e(route('tasks.show', $data->task_id)); ?>"><?php echo e($task_name); ?></a></td>
                    <td><?php echo e($task_for); ?></td>
                    <td><?php echo e($task_type); ?></td>
                    <td>
                        <?php
                        $vehicleUsed = \Tritiyo\Task\Models\TaskVehicle::leftjoin('vehicles', 'vehicles.id', 'tasks_vehicle.vehicle_id')
                                                    ->select('vehicles.name')
                                                    ->where('tasks_vehicle.task_id', $data->task_id)
                                                    ->get()->toArray();
                        echo implode('<br>', array_column($vehicleUsed, 'name'));
                        ?>
                    </td>
                    <td>

                        <?php
                            $materialUsed = \Tritiyo\Task\Models\TaskMaterial::leftjoin('materials', 'materials.id', 'tasks_material.material_id')
                                                        ->select('materials.name')
                                                        ->where('tasks_material.task_id', $data->task_id)
                                                        ->get()->toArray();
                            echo implode('<br>', array_column($materialUsed, 'name'));
                        ?>
                    </td>
                    <?php
                        $taskId = $data->task_id;
                        $obr = new Tritiyo\Task\Helpers\RequisitionData('requisition_edited_by_accountant', $taskId);
                        $purchases = $obr->getPurchaseData();
                    ?>
                    <td>
                        <?php if(!empty($purchases)): ?>
                            <?php echo implode('<br>',array_column($purchases, 'pa_note'));?>
                        <?php endif; ?>
                    </td>



                    <td>
                        <?php
                            $total_project_budget = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()->budget;
                            $total_sites = \Tritiyo\Site\Models\Site::where('project_id', '=', $site->project_id)->get()->count();
                            echo $totalBudget []= $total_project_budget/$total_sites;

                      		$taskSite = Tritiyo\Task\Models\TaskSite::where('task_id' , $taskId)->get()->groupBy('site_id')->count() ?? 0 ;
                        ?>
                    </td>
                    <td>
                       BDT. <?php echo e($approveReq []=  Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('reba_amount' ,$taskId)/$taskSite); ?>

                    </td>
                    <td>
                       BDT. <?php echo e($submittedBill []= Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('bpbr_amount' ,$taskId)/$taskSite); ?>

                    </td>
                    <td>
                       BDT. <?php echo e($approveBill []= Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('beba_amount' ,$taskId)/$taskSite); ?>

                    </td>
                    <td>
                        <?php echo e($site->completion_status); ?>

                    </td>
                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="6"></td>
                <td><?php echo e(number_format(array_sum($totalBudget),2)); ?></td>
                <td>Total : <?php echo e(array_sum($approveReq)); ?></td>
                <td>Total : <?php echo e(array_sum($submittedBill)); ?></td>
                <td>Total : <?php echo e(array_sum($approveBill)); ?></td>
                <td></td>
            </tr>

        </table>
        <div class="pagination_wrap pagination is-centered">
            <?php echo e($tasks->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\site\src/views/excel_with_show.blade.php ENDPATH**/ ?>