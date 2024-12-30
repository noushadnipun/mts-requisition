<?php $__env->startSection('title'); ?>
    Current Range Project
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('projects.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Single Project',
            'spSubTitle' => 'view a Project',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addUrl,
            'spAllData' => route('projects.index'),
            'spSearchData' => route('projects.search'),
            'spTitle' => 'Projects',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('projects.create'),
            'spAllData' => route('projects.index'),
            'spSearchData' => route('projects.search'),
            'spPlaceholder' => 'Search projects...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">

        <p class="panel-tabs">
            <a href="<?php echo e(route('projects.show', $project->id)); ?>">
                <i class="fas fa-list"></i>&nbsp; Project Data All Time
            </a>
            <a href="javascript:void(0)" class="is-active">
                <i class="fas fa-list"></i>&nbsp; Current Range Project Data
            </a>

            <a href="<?php echo e(route('projects.range', $project->id)); ?>">
                <i class="fas fa-list"></i>&nbsp; Range based tasks
            </a>

            <a href="<?php echo e(route('projects.site', $project->id)); ?>">
                <i class="fas fa-list"></i>&nbsp; Site of project
            </a>

            <a href="<?php echo e(route('projects.sites.info', $project->id)); ?>">
                <i class="fas fa-list"></i>&nbsp; Range Based Site Information of Project
            </a>
        </p>

        <?php
            function status_based_count($project_id, $status) {
                $total_sites = \Tritiyo\Site\Models\Site::where('project_id', $project_id)->where('completion_status', $status)->get();
                //dd($total_sites);
                return count($total_sites);
                #SELECT * FROM sites WHERE project_id = 8 AND completion_status = 'Running'
            }
        ?>

        <?php
        $ranges = \Tritiyo\Project\Helpers\ProjectHelper::all_ranges($project->id);
        $i = 0;
        foreach ($ranges as $range) {
        if($i == 0) {

        $exploded = explode(',', $range->status_string);
        //dump($exploded[0]);
        $range_datas0 = explode('|', $exploded[0]);
        if (count($exploded) > 1) {
            $range_datas1 = explode('|', $exploded[1]);
        } else {
            $today = explode('|', $exploded[0]);
            $range_datas1 = [
                '0' => $today[0],
                '1' => $today[1],
                '2' => date('Y-m-d'),
                '3' => $today[3],
                '4' => $today[4]
            ];
        }
        ?>


        <div class="card tile is-child has-background-info-light my-2">
            <div class="card-content">
                <div class="card-data">
                    <div class="level">
                        <div class="level-left">
                            <strong>Range based tasks </strong>
                        </div>
                        <div class="level-right">
                            <div class="level-item tag is-warning is-light">
                                <?php echo e($range_datas0[2]); ?> - <?php echo e($range_datas1[2]); ?>

                            </div>
                        </div>
                    </div>

                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth"
                           style="text-align: left;">
                        <tr>
                            <td colspan="2" width="50%">
                                <div class="notification is-warning has-text-centered">
                                    Budget <br/>
                                    <h1 class="title">
                                        BDT.

                                        <?php echo e(\Tritiyo\Project\Helpers\ProjectHelper::current_range_budgets($range_datas0[1], $range_datas0[0])); ?>


                                        <?php //dump($range); ?>
                                    </h1>
                                    <p> &nbsp; </p>
                                </div>
                            </td>
                            <td colspan="2">
                                <div class="notification is-link has-text-centered">
                                    Total Budget Used
                                    <h1 class="title">
                                        <?php
                                            $total_requisition = \Tritiyo\Project\Helpers\ProjectHelper::ttrbGetTotalByProject('reba_amount', $project->id, $range_datas0[0]);
                                        ?>
                                       <?php
                                        $mobileBill = round(\Tritiyo\Project\Models\MobileBill::where('project_id', $project->id)->where('range_id', $range_datas0[0])->get()->sum('received_amount'), 2);
                                        $budgetuse = $total_requisition;
                                        //dump($range_datas0[0]);
                                        ?>
                                        BDT. <?php echo e($budgetuse + $mobileBill); ?>


                                    </h1>
                                    <small>
                                        Used Budget BDT. <?php echo e($budgetuse); ?> + Mobile Bill BDT. <?php echo e($mobileBill); ?>

                                    </small>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>


                    </table>

                </div>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <tr>
                        <th>Task Name</th>
                        <th>Task For</th>
                        <th>Project Name</th>
                        <th>Project Manager</th>
                        <th>Site Code</th>
                        <th>Site Head</th>
                        <th>Requisition Approved</th>
                        <th>Submit Bill</th>
                        <th>Bill Approved</th>
                    </tr>
                    <?php //echo request()->get('daterange');?>
                    <?php
                        $start = $range_datas0[2];
                        $end = $range_datas1[2];
                        $tasks = \Tritiyo\Task\Models\Task::where('project_id', $project->id)->whereBetween('task_for', [$start, $end])->paginate(50);
                    ?>
                    <?php
                        $requisitionApproveTotal = [];
                        $submitBill = [];
                        $billApproveTotal = [];
                    ?>

                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $project = Tritiyo\Project\Models\Project::where('id', $task->project_id)->first();
                            $sites = Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')->select('sites.site_code')->where('tasks_site.task_id', $task->id)->first();
                  			$site_id = Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')->select('sites.id')->where('tasks_site.task_id', $task->id)->first() ?? NULL;
                            $task_name = $task->task_name ?? NULL;
                            $task_for = $task->task_for ?? NULL;
                            $project_name = $project->name ?? NULL;
                            $manager_name = App\Models\User::where('id', $task->user_id)->first()->name ?? NULL;
                            $site_code = $sites->site_code ?? NULL;
                            $site_head = $task->site_head ?? NULL;
                            $site_head_name = App\Models\User::where('id', $task->site_head)->first()->name ?? NULL;


                  			//$rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id, false);
                            //$requisition_approved_total = $rm->getTotal();
                  			//$rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_edited_by_accountant', $task->id, false);
                            //$bill_approved_total = $rm->getTotal();

                  			$rm = DB::SELECT("SELECT reba_amount FROM ttrb WHERE id = " . $task->id);
                  			$requisition_approved_total = $rm[0]->reba_amount;

                  			$sb = DB::SELECT("SELECT bpbr_amount FROM ttrb WHERE id = " . $task->id);
                  			$submit_bill_total = $sb[0]->bpbr_amount;

                  			$bill = DB::SELECT("SELECT beba_amount FROM ttrb WHERE id = " . $task->id);
                  			$bill_approved_total = $bill[0]->beba_amount;
                        ?>


                        <tr>
                            <td>
                                <a href="<?php echo e(route('tasks.show', $task->id)); ?>" target="__blank">
                                    <?php echo e($task_name); ?>

                                </a>
                            </td>
                            <td><?php echo e($task_for); ?></td>
                            <td>
                                <a target="__blank"
                                   href="<?php echo e(route('projects.show', $project->id)); ?>">
                                    <?php echo e($project_name); ?>

                                </a>
                            </td>
                            <td><?php echo e($manager_name ?? NULL); ?></td>
                            <td>
                                <?php if(!empty($site_id)): ?>
                                    <a target="__blank"
                                       href="<?php echo e(route('sites.show', $site_id)); ?>">
                                        <?php echo e($site_code ?? NULL); ?>

                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(!empty($site_head)): ?>
                                    <a href="<?php echo e(route('hidtory.user', $site_head)); ?>">
                                        <?php echo e($site_head_name ?? NULL); ?>

                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                               BDT. <?php echo e($requisitionApproveTotal[] = $requisition_approved_total); ?>

                            </td>
                            <td>
                            		BDT.  <?php echo e($submitBill[] = $submit_bill_total); ?>

                           </td>
                            <td>
                                BDT.  <?php echo e($billApproveTotal[] =  $bill_approved_total); ?>

                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <tr>
                        <td colspan="6"></td>
                        <td> Total:  <?php echo e(array_sum($requisitionApproveTotal)); ?> </td>
                        <td>Total: <?php echo e(array_sum($submitBill)); ?></td>
                        <td>  Total:   <?php echo e(array_sum($billApproveTotal)); ?></td>
                    </tr>
                </table>
                <div class="pagination_wrap pagination is-centered">
                    <?php echo e($tasks->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>


        <?php
        }
        $i++;

        //dump($range_datas0);
        //dump($range_datas1);
        } // End Range Foreach
        ?>
    </article>

<?php $__env->stopSection(); ?>




<?php $__env->startSection('cusjs'); ?>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <script type="text/javascript">
        document.getElementById('textboxID').select();
    </script>

    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/project/src/views/current-range.blade.php ENDPATH**/ ?>