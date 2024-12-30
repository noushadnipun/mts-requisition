<?php $__env->startSection('title'); ?>
    Edit Site
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('sites.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Edit Site',
            'spSubTitle' => 'Edit a single site',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addUrl,
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spTitle' => 'Sites',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('sites.create'),
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spPlaceholder' => 'Search sites...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Site Information</a>
        </p>


        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('sites.update', $site->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('project_id', 'Project', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php $projects = \Tritiyo\Project\Models\Project::pluck('name', 'id')->prepend('Select Project', ''); ?>
                            <?php echo e(Form::select('project_id', $projects, $site->project_id ?? NULL, ['class' => 'input is-small'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <?php echo e(Form::label('location','Location',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select is-small">
                                <?php
                                $upazilas = \DB::table('upazilas')->get()->pluck('name', 'name');
                                ?>
                                <?php echo e(Form::select('location', $upazilas ?? NULL, $site->location ?? NULL, ['class' => 'input', 'required' => true])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <?php echo e(Form::label('site_code', 'Site Code', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('site_code', $site->site_code ?? NULL, ['class' => 'input is-small', 'placeholder' => 'Enter Site Code...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <?php echo e(Form::label('task_limit', 'Limit Of Task', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('task_limit', $site->task_limit ?? NULL, ['class' => 'input is-small', 'placeholder' => 'Enter limit of task...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <?php echo e(Form::label('completion_status', 'Completion Status', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php
                                $completion_statuses = ['' => '', 'Running' => 'Running', 'Rejected' => 'Rejected', 'Completed' => 'Completed', 'Pending' => 'Pending', 'Discard' => 'Discard'];
//dump($site->completion_status);
                            ?>
                            <?php echo e(Form::select('completion_status', $completion_statuses, $site->completion_status ?? NULL, ['class' => 'input is-small', 'required' => true])); ?>

                        </div>
                    </div>
                </div>

            </div>
            
            
            
            
            
            <?php echo e(Form::hidden('budget', $site->budget ?? NULL, ['class' => 'input is-small', 'placeholder' => 'Enter budget...'])); ?>

            
            
            
            
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    
    
    
    
    
    
    
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/edit.blade.php ENDPATH**/ ?>