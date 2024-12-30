<?php $__env->startSection('title'); ?>
Information of Range Based Total Sites Of Project 
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
        'spTitle' => 'Range Based Sites Of Project',
        'spSubTitle' => 'view all sites of current project',
        'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
        'spShowButtonSet' => true,
        'spAddUrl' => null,
        'spAddUrl' => $addUrl,
        'spAllData' => route('projects.index'),
        'spSearchData' => '#',
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
    <?php
    $projectId = $project->id;
    $rangeId = \Tritiyo\Project\Helpers\ProjectHelper::current_range_id($projectId);
    $allranges = \Tritiyo\Project\Helpers\ProjectHelper::all_ranges($project->id);
    //dump($allranges);
    ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a href="<?php echo e(route('projects.show', $project->id)); ?>">
                <i class="fas fa-list"></i>&nbsp;  Project Data All Time
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
            <a href="<?php echo e(route('projects.sites.info', $project->id)); ?>" class="is-active">
                <i class="fas fa-list"></i>&nbsp; Range Based Site Information of Project
            </a>
        </p>
        <br/>

        <?php
            //$sites = \Tritiyo\Site\Models\Site::where('sites.project_id', $projectId)->paginate('30');
        ?>
        <section id="rangeAccordion" class="accordions">
            <?php $__currentLoopData = $allranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cRange): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $rangeId = explode(' | ', $cRange->status_string);

                $exploded = explode(',', $cRange->status_string);
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
                 $rangeKey = str_replace(' ', '',$range_datas0[4]);
                 $sites = \Tritiyo\Task\Models\TaskSite::leftjoin('tasks', 'tasks.id', 'tasks_site.task_id')
                             ->leftjoin('sites', 'tasks_site.site_id', 'sites.id')
                             ->where('sites.project_id', $projectId)
                             ->where('tasks.current_range_id', $rangeId[0])
                             ->groupBy('sites.id')
                             ->paginate('30');
                 //$sites = \Tritiyo\Site\Models\Site::where('sites.project_id', $projectId)->paginate('30');
                	//dd($sites);
                 //$range_datas0 = explode('|', $exploded[0]);

            ?>
          
                <div class="card tile is-child has-background-info-light my-2 accordion <?php echo e(request()->get('range_key') == $rangeKey ? 'is-active' : ''); ?>">
                    <header class="card-header  accordion-header stoggle">
                        <p class="card-header-title">
                            <span class="icon"><i class="fas fa-tasks default"></i></span>
                            <?php echo e($range_datas0[2]); ?> - <?php echo e($range_datas1[2]); ?>

                            <a class="ml-3 is-size-7 has-text-link-dark"
                               href="<?php echo e(route('projects.sites.info', $project->id)); ?>?range_key=<?php echo e($rangeKey); ?>">Click Here</a>
                        </p>
                    </header>
                <?php if(request()->get('range_key') ): ?>
                    <div class="accordion-body">
                        <div class="level">
                            <div class="level-left"></div>
                            <div class="level-right">
                                <div class="level-item">
                                    <a href="<?php echo e(route('projects.sites.info.export', $project->id)); ?>?range_id=<?php echo e($rangeId[0]); ?>&&range_date=<?php echo e($range_datas0[2].'-'.$range_datas1[2]); ?>"
                                       class="button is-primary is-small">
                                        Download as excel
                                    </a>
                                </div>
                            </div>
                        </div>
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th width="3%">SL</th>
                                <th width="20%">Site Code</th>
                                <th>Completion Status</th>
                                <th> Task Count</th>
                              <?php /*
                                <th>Requisition Approved</th>
                                <th>Bill Submitted</th>
                                <th>Bill Approved</th>
                                */ ?>
                            </tr>

                            <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $sites->firstitem()); ?></td>
                                    <td>
                                        <a target="__blank" href="<?php echo e(route('sites.show', $site->id)); ?>" class="has-text-link">
                                        <?php echo e($site->site_code); ?>

                                        </a>
                                    </td>
                                    <td> <?php echo e($site->completion_status); ?> </td>
                                 
                                    <td>
                                        <?php
                                            $getTask = DB::table('tasks_site_datas')->where('site_id', $site->id)->groupBy('task_id')->get();
                                        ?>

                                        <?php 
                                       
                                         ///Requisition / Biil Amount
                                      
                                        $reba = [];
                                        $bpbr = [];
                                        $beba = [];

                                        $sharedreba = [];
                                        $sharedbpbr = [];
                                        $sharedbeba = [];

                                        $sharedTask = 0;
                                        foreach($getTask as $data){
                                         
                                            $amount = \Tritiyo\Task\Models\TaskRequisitionBill::select('reba_amount', 'bpbr_amount', 'beba_amount')->where('task_id', $data->task_id)->first();
                                          //dd($amount);
                                            $reba []= $amount['reba_amount'] ?? 0;
                                            $bpbr []= $amount['bpbr_amount'] ?? 0;
                                            $beba []= $amount['beba_amount'] ?? 0;
										
                                            $sharedTask += DB::table('tasks_site')->where('task_id', $data->task_id)
                                                            ->whereNotIn('site_id', [$site->id])->groupBy('task_id')->get()->count();
                                                         
                                            //$reba [] = $amount->sum('reba_amount');
                                            //$bpbr [] = $amount->sum('bpbr_amount');
                                            //$beba [] = $amount->sum('beba_amount');
											/*
                                            $sharedAmount = DB::table('ttrb')
                                                            ->leftjoin('tasks_site', 'tasks_site.task_id', 'ttrb.task_id')
                                                            ->select('ttrb.reba_amount', 'ttrb.bpbr_amount', 'ttrb.beba_amount')
                                                            ->where('ttrb.task_id', $data->task_id)
                                                            ->whereNotIn('tasks_site.site_id', [$site->id])
                                                            ->groupBy('tasks_site.task_id')
                                                            ->get();

                                            $sharedreba []= $sharedAmount->sum('reba_amount');
                                            $sharedbpbr []= $sharedAmount->sum('bpbr_amount');
                                            $sharedbeba []= $sharedAmount->sum('beba_amount');
                                            */
                                        }
                                        ?>
										
                                        <strong title="Total Task">TT:</strong> <?php echo e($totalTask = $getTask->count()); ?>

                                        <br>
                                        <strong title="Shared Task">ST:</strong> <?php echo e($sharedTask); ?>

                                        <strong title="Non Shared Task">NST:</strong> <?php echo e($totalTask - $sharedTask); ?>

                                     
                                    </td>
                                  <?php /*
                                    <td>
                                        <strong title="Total">T:</strong> {{ array_sum($reba) }}
                                        <br>
                                        <strong title="Shared">S:</strong> {{ array_sum($sharedreba) }}
                                        <strong title="Non Shared">NS:</strong> {{  array_sum($reba) - array_sum($sharedreba) }}
                                        
                                    </td>
                                  
                                    <td>
                                       {{array_sum($bpbr)}}
                                       <br>
                                       <strong title="Shared">S:</strong> {{ array_sum($sharedbpbr) }}
                                       <strong title="Non Shared">NS:</strong> {{  array_sum($bpbr) - array_sum($sharedbpbr) }}
                                    </td>

                                    <td>
                                        {{array_sum($beba)}}
                                        <br>
                                        <strong title="Shared">S:</strong> {{ array_sum($sharedbeba) }}
                                        <strong title="Non Shared">NS:</strong> {{  array_sum($beba) - array_sum($sharedbeba) }}
                                    </td>
                                    */ ?>
                                  
                     				
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                        <div class="pagination_wrap pagination is-centered">
                            <?php if(request()->get('range_key') ): ?>
                                <?php echo e($sites->appends(['range_key'=> request()->get('range_key')])->links('pagination::bootstrap-4')); ?>

                            <?php else: ?>
                            <?php echo e($sites->links('pagination::bootstrap-4')); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    </article>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('cusjs'); ?>


    <style>
        /* Accordion */
        section#rangeAccordion.accordions .accordion .accordion-header {
            align-items: center;
            background-color: #c4c2fd !important;
            border-radius: 4px 4px 0 0;
            color: #fff;
            display: flex;
            line-height: 0em;
            padding: 0em .0em !important;
            position: relative;
            border: 0px;
        }

        .accordions .accordion.is-active .accordion-body {
            max-height: 100em;
            overflow: hidden;
        }
        section#rangeAccordion.accordions .accordion.is-active .accordion-header {
            background-color: #a189d4 !important;
        }
        section#rangeAccordion.accordions .accordion {
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 4px;
            font-size: 13px;
            border: 0px;
        }

        section#rangeAccordion.accordions .accordion .accordion-header + .accordion-body .accordion-content {
            padding: 0em 0em;
        }

        section#rangeAccordion.accordions .accordion a:not(.button):not(.tag) {
            text-decoration: none;
        }
    </style>

    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/bulma-accordion@2.0.1/dist/js/bulma-accordion.min.js"></script>

    <script>

        var accordions = bulmaAccordion.attach();

    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-accordion@2.0.1/dist/css/bulma-accordion.min.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/project/src/views/project_sites_information.blade.php ENDPATH**/ ?>