<?php $__env->startSection('title'); ?>
    Single Project
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
            <a href="javascript:void(0)" class="is-active">
                <i class="fas fa-list"></i>&nbsp; Project Data All Time
            </a>

            <a href="<?php echo e(route('projects.current.range', $project->id)); ?>">
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


        <div class="card tile is-child">
            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth"
                           style="text-align: left;">
                        <tr>
                            <td colspan="4">
                                <strong>Project Information</strong>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <table class="table is-bordered is-striped is-narrow is-fullwidth">
                                    <tr>
                                        <td width="25%">
                                            <a href="<?php echo e(route('projects.site', $project->id)); ?>" target="_blank">
                                                <div class="tag is-dark has-text-white"
                                                     style="font-size: 16px; width: 100%;">
                                                    Total Sites:
                                                    <?php echo e(\Tritiyo\Site\Models\Site::where('project_id', $project->id)->count()); ?>

                                                </div>
                                            </a>
                                        </td>
                                        <td width="25%">
                                            <a href="<?php echo e(route('projects.site', $project->id)); ?>?key=Running" target="_blank">
                                                <div class="tag is-success has-text-white"
                                                     style="font-size: 16px; width: 100%;">
                                                    Total Running Site: <?php echo e(status_based_count($project->id, 'Running')); ?>

                                                </div>
                                            </a>
                                        </td>
                                        <td width="25%">
                                            <a href="<?php echo e(route('projects.site', $project->id)); ?>?key=Completed" target="_blank">
                                                <div class="tag is-link has-text-white"
                                                     style="font-size: 16px; width: 100%;">
                                                    Total Completed
                                                    Site: <?php echo e(status_based_count($project->id, 'Completed')); ?>

                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('projects.site', $project->id)); ?>?key=Rejected" target="_blank">
                                                <div class="tag is-danger has-text-white"
                                                     style="font-size: 16px; width: 100%;">
                                                    Total Rejected Site: <?php echo e(status_based_count($project->id, 'Rejected')); ?>

                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                 
                        <tr>
                          	<td colspan="4">
                              <table class="table is-fullwidth">
                                <tr>
                                                  <td>
                                                      <div class="notification is-warning has-text-centered">
                                                          Budget <br/>
                                                          <h1 class="title">
                                                              BDT.
                                                              <?php echo e(\Tritiyo\Project\Helpers\ProjectHelper::all_range_budgets($project->id)); ?>


                                                          </h1>
                                                          <p> &nbsp; </p>

                                                      </div>
                                                  </td>  
                                  
                                                  <td>
                                                      <div class="notification is-link has-text-centered">
                                                          Total Budget Used
                                                          <h1 class="title">


                                                              <?php
                                                              $current_range_id = \Tritiyo\Project\Helpers\ProjectHelper::current_range_id($project->id);
                                                              $mobileBill = round(\Tritiyo\Project\Models\MobileBill::where('project_id', $project->id)->get()->sum('received_amount'), 2);
                                                              //$budgetuse = \Tritiyo\Project\Helpers\ProjectHelper::used_range_budgets($project->id);
                                                             $budgetuse = \Tritiyo\Project\Helpers\ProjectHelper::ttrbGetTotalByProject('reba_amount', $project->id, $current_range_id);
                                                           
                                                              //dump($mobileBill);
                                                              ?>
                                                         
                                                              BDT. <?php echo e($budgetuse + $mobileBill); ?>

                                                             

                                                          </h1>
                                                          <small>
                                                              Used Budget BDT. <?php echo e($budgetuse); ?> + Mobile Bill BDT. <?php echo e($mobileBill); ?>

                                                          </small>
                                                      </div>
                                                  </td>
                                   
                                                  <td>
                                                      <div class="notification is-info has-text-centered">
                                                          Total Invoice Submitted
                                                          <h1 class="title">
                                                              <?php
                                                              $invoiceSiteAmount = round(\Tritiyo\Site\Models\SiteInvoice::where('project_id', $project->id)->get()->sum('invoice_amount'));                                        
                                                              //dump($mobileBill);
                                                              ?>
                                                              BDT. <?php echo e($invoiceSiteAmount); ?>


                                                          </h1>
                                                        <small>
                                                          &nbsp;
                                                        </small>
                                                      </div>
                                                  </td>
                                               
                                </tr>
                               
                              </table>
                              </td>
                        </tr>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>

                        <?php
                            function status_based_count($project_id, $status) {
                                $total_sites = \Tritiyo\Site\Models\Site::where('project_id', $project_id)->where('completion_status', $status)->get();
                                //dd($total_sites);
                                return count($total_sites);
                                #SELECT * FROM sites WHERE project_id = 8 AND completion_status = 'Running'
                            }
                        ?>


                        <tr>
                            <td width="15%"><strong>Project Name:</strong></td>
                            <td><?php echo e($project->name); ?></td>
                            <td width="15%"><strong>Project Code:</strong></td>
                            <td><?php echo e($project->code); ?></td>
                        </tr>


                        <tr>
                            <td><strong>Project Type:</strong></td>
                            <td><?php echo e($project->type); ?></td>
                            <td><strong>Project Manager:</strong></td>
                            <td>
                                <?php $projectManager = \App\Models\User::where('id', $project->manager)->first() ?>
                                <?php echo e(!empty($projectManager) ? $projectManager->name : ''); ?>

                            </td>
                        </tr>

                        <tr>
                            <td><strong>Project customer:</strong></td>
                            <td><?php echo e($project->customer); ?></td>
                            <td><strong>Project vendor:</strong></td>
                            <td><?php echo e($project->vendor); ?></td>
                        </tr>

                        <tr>
                            <td><strong>Project supplier:</strong></td>
                            <td><?php echo e($project->supplier); ?></td>
                            <td><strong></strong></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><strong>Project address:</strong></td>
                            <td><?php echo e($project->address); ?></td>
                            <td><strong>Project location:</strong></td>
                            <td><?php echo e($project->location); ?></td>
                        </tr>

                        <tr>
                            <td><strong>Head Office:</strong></td>
                            <td><?php echo e($project->office); ?></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><strong>Project start:</strong></td>
                            <td><?php echo e($project->start); ?></td>
                            <td><strong>Approximate project end:</strong></td>
                            <td><?php echo e($project->end); ?></td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <?php echo e($project->summary); ?>

                            </td>
                        </tr>

                    </table>
                    <div class="level">
                        <div class="level-left">
                            <strong>Project based tasks</strong>
                        </div>
                        <div class="level-right">
                            <div class="level-item ">
                                <form method="get" action="<?php echo e(route('projects.show', $project->id)); ?>">
                                    <?php echo csrf_field(); ?>

                                    <div class="field has-addons">
                                        <a href="<?php echo e(route('download_excel_project')); ?>?id=<?php echo e($project->id); ?>&daterange=<?php echo e(request()->get('daterange') ?? date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days')) . ' - ' . date('Y-m-d')); ?>"
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
                        <th>Task Status</th>
                        <th>Task For</th>
                        <th>Project Name</th>
                        <th>Project Manager</th>
                        <th>Site Code</th>
                        <th>Site Head</th>
                        <th>Requisition Approved</th>
                        <th>Submit  Bill</th>
                        <th>Bill Approved</th>
                    </tr>
                    <?php //echo request()->get('daterange');?>
                    <?php
                        if (request()->get('daterange')) {
                                $dates = explode(' - ', request()->get('daterange'));
                                $start = $dates[0];
                                $end = $dates[1];

                            $tasks = \Tritiyo\Task\Models\Task::where('project_id', $project->id)->whereBetween('task_for', [$start, $end])->paginate(30);


                        } else {
                           $start = date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'));
                           $end = date('Y-m-d');
                           $tasks = \Tritiyo\Task\Models\Task::where('project_id', $project->id)->whereBetween('task_for', [$start, $end])->paginate(30);
                        }
                    ?>
                    <?php
                        $sumOf = [];
                        $submitBill = [];
                        $billApproveSum = [];
                    ?>
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first();
                            $sites = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                  						->select('sites.site_code', 'sites.id')->where('tasks_site.task_id', $task->id)->groupBy('tasks_site.site_id')->get();
                  			$site_id = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')->select('sites.id')->where('tasks_site.task_id', $task->id)->first() ?? NULL;
                            $task_name = $task->task_name ?? NULL;
                            $task_for = $task->task_for ?? NULL;
                            $project_name = $project->name ?? NULL;
                            $manager_name = App\Models\User::where('id', $task->user_id)->first()->name ?? NULL;
                            //$site_code = $sites->site_code ?? NULL;
                            $site_head = $task->site_head ?? NULL;
                            $site_head_name = App\Models\User::where('id', $task->site_head)->first()->name ?? NULL;
                            /*
                            $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id, true);
                            $rmf = new \Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $task->id, false);
                            $requisition_approved_total = $rm->getTotal();
                            $requisition_approved_totalf = $rmf->getTotal();

                            $rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('bill_edited_by_accountant', $task->id, true);
                            $bill_approved_total = $rm->getTotal();
                            */
                            $calculate = \Tritiyo\Task\Models\TaskRequisitionBill::select('bpbr_amount', 'rpbm_amount', 'bebm_amount', 'rebc_amount', 'bebc_amount', 'reba_amount', 'beba_amount', )
                                    ->where('task_id', $task->id)->first();
                        ?>

                        <?php
                            $statusCheck = \Tritiyo\Task\Models\TaskStatus::select('code', 'message')->where('task_id', $task->id)->latest()->first();
                            if(strpos($statusCheck->code, 'decline') == true){
                                $decline = '#ffd8e5';
                            } else {
                                $decline = '';
                            }
                        ?>
                        <tr style="background: <?php echo e($decline); ?>">
                            <td>
                                <a href="<?php echo e(route('tasks.show', $task->id)); ?>" target="__blank">
                                    <?php echo e($task_name); ?>

                                </a>
                            </td>
                            <td><?php echo e($statusCheck->message); ?></td>
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
                              		<?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              		<?php
                              		//dump($site);
                              		$site_code =  $site->site_code; ?>
                                    <a target="__blank"
                                       href="<?php echo e(route('sites.show', $site->id)); ?>">
                                        <?php echo e($site_code ?? NULL); ?> <br/>
                                    </a>
                              		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                                BDT.   <?php echo e($sumOf[] = $calculate->reba_amount ?? 0); ?>


                            </td>
                            <td>
                                BDT. <?php echo e($submitBill []= $calculate->bpbr_amount ?? 0); ?>

                            </td>
                            <td>
                                BDT. <?php echo e($billApproveSum []= $calculate->beba_amount ?? 0); ?>

                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td colspan="7" style="text-align: right;">
                            Total
                        </td>
                        <td>
                            BDT. <?php echo e(array_sum($sumOf)); ?>

                        </td>
                        <td>
                            BDT.	<?php echo e(array_sum($submitBill)); ?></td>
                        <td>
                            BDT.   <?php echo e(array_sum($billApproveSum)); ?>

                        </td>
                    </tr>
                </table>
                <div class="pagination_wrap pagination is-centered">
                    <?php if(Request::get('daterange') ): ?>
                        <?php echo e($tasks->appends(['daterange' => Request::get('daterange')])->links('pagination::bootstrap-4')); ?>

                    <?php else: ?>
                        <?php echo e($tasks->links('pagination::bootstrap-4')); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>



    </article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('cusjs'); ?>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/project/src/views/show.blade.php ENDPATH**/ ?>