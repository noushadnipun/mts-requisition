<?php
$project = \Tritiyo\Project\Models\Project::where('id', Request::get('project_id'))->first();
?>

<?php $__env->startSection('title'); ?>
    Edit Project Status
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('project_ranges.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>

<?php

?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Edit Project Status',
            'spSubTitle' => 'Edit a single project',
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
            <a class="is-active">Project Information</a>
        </p>
        <div class="customContainer">
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Project Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->name ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('code', 'Project Code', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->code ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('type', 'Project Type', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->type ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('manager', 'Project Manager', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php $manager = \App\Models\User::where('id', $project->manager ?? NULL)->first()->name; ?>
                            <?php echo e($manager); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('customer', 'Project customer', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->customer ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('vendor', 'Project vendor', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->vendor ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('supplier', 'Project supplier', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->supplier ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('address', 'Project address', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->address ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('location', 'Project location', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->location ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('office', 'Head Office', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->office ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('start', 'Project start', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->start ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('end', 'Approximate project end', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->end ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('budget', 'Project approximate budget', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->budget ?? NULL); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('summary', 'Project summary', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e($project->summary ?? NULL); ?>

                        </div>
                    </div>
                </div>

                <div class="column is-6">
                    <div class="columns">
                        <div class="column is-12">
                            <?php
                                $exists = \Tritiyo\Project\Models\ProjectRange::where('project_id', $project->id)->orderBy('id', 'desc')->get();
                                //dd($exists);
                            ?>

                            <div style="color: red; font-size: 20px; margin: 0px 0 20px 0px;">
                                Please double check what you doing here
                            </div>

                            <div style="margin: 0px 0 20px 0px;">
                                <div class="columns">
                                    <div class="column is-6">
                                        <p>Current Project Status:</p>
                                        <span style="color: green; font-size: 25px;">
                                            <?php echo e(\Tritiyo\Project\Models\ProjectRange::where('project_id', $project->id)->orderBy('id', 'desc')->first()->project_status ?? NULL); ?>

                                        </span>
                                    </div>
                                    <div class="column is-6">
                                        <p>Last Project Status Updated at:</p>
                                        <span style="color: green; font-size: 25px;">
                                            <?php echo e(\Tritiyo\Project\Models\ProjectRange::where('project_id', $project->id)->orderBy('id', 'desc')->first()->status_update_date ?? NULL); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column is-6">
                                        <p>Current Range Budget Till Today:</p>
                                        <span style="color: green; font-size: 25px;">
                                            <?php
                                                $allCurrentBudgets = \Tritiyo\Project\Helpers\ProjectHelper::current_range_budgets($project->id);
                                            ?>
                                            <?php echo e($allCurrentBudgets ?? NULL); ?>

                                        </span>
                                    </div>
                                    <div class="column is-6">
                                        <p>Total Project Budget of All Time:</p>
                                        <span style="color: green; font-size: 25px;">
                                            <?php
                                                $allBudgets = \Tritiyo\Project\Helpers\ProjectHelper::all_range_budgets($project->id);
                                            ?>
                                            <?php echo e($allBudgets ?? NULL); ?>

                                        </span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="customContainer">
                        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
                            <?php
                            $routeUrl = route('project_budgets.store');
                            $method = 'post';
                            ?>
                            <?php if(count($exists) > 0): ?>
                                <?php if($exists[0]['project_status'] == 'Active') { ?>
                                <?php echo e(Form::open(array('url' => $routeUrl, 'method' => $method, 'value' => 'PATCH', 'id' => 'add_route', 'class' => 'project_budgets_table',  'files' => true, 'autocomplete' => 'off'))); ?>



                                <label for="budget_amount" class="label">Budget Amount</label>
                                <input name="project_id" type="hidden" value="<?php echo e($project->id ?? NULL); ?>"
                                       required>
                                <input name="current_range_id" type="hidden"
                                       value="<?php echo e($exists[0]->id ?? NULL); ?>" required>
                                <div class="field">
                                    <input name="budget_amount" type="number" value="" class="input is-small"
                                       required>
                                </div>

                            <?php
                                  $current_range_id = \Tritiyo\Project\Helpers\ProjectHelper::current_range_id($project->id);

                                  //SELECT count(id) FROM `sites` WHERE `project_id` = 4 AND site_type = 'Recurring' GROUP BY site_type
                                  $is_recurring = \Tritiyo\Site\Models\Site::select('id')->where('project_id', $project->id)->where('site_type', 'Recurring')->groupBy('site_type')->get();

                                    //dd();
                                    if(!empty($is_recurring) && count($is_recurring) > 0) {
                                            $sites = \Tritiyo\Site\Models\Site::where('project_id', $project->id)
                                            ->whereNotIn('site_type', ['Recurring'])
                                            ->where('range_ids', $current_range_id)
                                            ->latest()->get();
                                    } else {
                                            $sites = \Tritiyo\Site\Models\Site::where('project_id', $project->id)->latest()->get();
                                    }
                            ?>
                                <div class="field">
                                    <label class="label">Select Site</label>
                                    <select class="input is-small" name="site_id[]" id="site_select" multiple="multiple">
                                        <option></option>
                                        <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($site->id); ?>"><?php echo e($site->site_code); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="field is-grouped">
                                    <div class="control">
                                        <button class="button is-success is-small" style="margin-top: 10px;">
                                            Add Budget
                                        </button>
                                    </div>
                                </div>

                                <?php echo e(Form::close()); ?>

                                <?php } else { ?>
                                This project currently inactive. You can not add any budget to this project anymore.
                                <?php } ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div style="margin-top: 20px;">
                            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                <tbody>
                                <tr>
                                    <th>Row ID</th>
                                    <th>Project ID</th>
                                    <th>Range ID</th>
                                    <th>Budget Amount</th>
                                    <th>Site Code</th>
                                    <th>Budget Added at</th>
                                    <th>Action</th>
                                </tr>

                                <?php
                                    $project_budgets = \Tritiyo\Project\Models\ProjectBudget::where('project_id', $project->id)->orderBy('id', 'desc')->get();
                                ?>
                                <?php $__currentLoopData = $project_budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($budget->id); ?></td>
                                        <td><?php echo e($budget->project_id); ?></td>
                                        <td><?php echo e($budget->current_range_id); ?></td>
                                        <td><?php echo e($budget->budget_amount); ?></td>
                                        <td>
                                            <?php
                                                $explode = explode(',', $budget->site_id);
                                                //dump($explode);
                                                foreach($explode as $s){
                                                    echo '<a target="_blank" href="'.route('sites.show', $s).'">';
                                                    echo \Tritiyo\Site\Models\Site::where('id', $s)->first()->site_code ?? Null;
                                                    echo '</a>  ';
                                                }

                                            ?>
                                        </td>
                                        <td><?php echo e($budget->created_at); ?></td>
                                        <td>
                                            <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
                                          		<?php echo delete_data('project_budgets.destroy',  $budget->id); ?>

                                            <?php endif; ?>
                                          
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <article class="is-primary">
        <div class="box">
            <h1 class="title is-5">Important Note</h1>
            <p>
                Please select project manager and budget properly
            </p>
        </div>
    </article>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('cusjs'); ?>


    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        // Select 2
        function siteSelectRefresh() {
            $('select#site_select').select2({
                placeholder: "Select Site",
                allowClear: true,
            });
        }
        siteSelectRefresh()
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Documents\localhost\www\requisition\vendor\tritiyo\project\src/views/project_budget.blade.php ENDPATH**/ ?>