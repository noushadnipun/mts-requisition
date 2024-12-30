<?php $__env->startSection('title'); ?>
    Edit Project
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
            'spTitle' => 'Edit Project',
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
            <?php echo e(Form::open(array('url' => route('projects.update', $project->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Project Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('name', $project->name ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter project name...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('code', 'Project Code', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('code', $project->code ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter project code...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('type', 'Project Type', array('class' => 'label'))); ?>

                        <div class="control">
                            <select class="input is-small" name="type" id="">
                                <option value="">Select a project type</option>
                                <option value="Recurring" <?php echo e($project->type == 'Recurring' ? 'selected' : ''); ?>>Recurring</option>
                                <option value="Not Recurring" <?php echo e($project->type == 'Not Recurring' ? 'selected' : ''); ?>>Not Recurring</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-9">
                    <div class="field">
                        <?php echo e(Form::label('manager', 'Project Manager', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php $managers = \App\Models\User::where('role', 3)->pluck('name', 'id')->prepend('Select manager', ''); ?>
                            <?php echo e(Form::select('manager', $managers, $project->manager ?? NULL, ['class' => 'input'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('customer', 'Project customer', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('customer', $project->customer ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project customer...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('vendor', 'Project vendor', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('vendor', $project->vendor ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project vendor...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('supplier', 'Project supplier', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('supplier', $project->supplier ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter project supplier...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('address', 'Project address', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('address', $project->address ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter project address...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('location', 'Project location', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('location', $project->location ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project location...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('office', 'Head Office', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('office', $project->office ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project office...'])); ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('start', 'Project start', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::date('start', $project->start ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project start...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('end', 'Approximate project end', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::date('end', $project->end ?? NULL, ['class' => 'input', 'placeholder' => 'Enter project end...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3" style="display:none;">
                    <div class="field">
                        <?php echo e(Form::label('budget', 'Project approximate budget', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::hidden('budget', $project->budget ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter project budget...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-9">
                    <div class="field">
                        <?php echo e(Form::label('summary', 'Project summary', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('summary', $project->summary ?? NULL, ['required', 'class' => 'textarea', 'placeholder' => 'Enter project summary...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small" type="submit">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Documents\localhost\www\requisition\vendor\tritiyo\project\src/views/edit.blade.php ENDPATH**/ ?>