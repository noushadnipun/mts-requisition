<?php $__env->startSection('title'); ?>
    Time setting
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Time setting',
            'spSubTitle' => 'edit time setting data',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => false
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => false
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a href="<?php echo e(route('settings.global', 1)); ?>">
                <i class="fas fa-wrench"></i>&nbsp; Global Settings
            </a>
            <a href="<?php echo e(route('settings.payment', 2)); ?>">
                <i class="fas fa-dollar-sign"></i>&nbsp; Payment Settings
            </a>
            <a href="<?php echo e(route('settings.time', 3)); ?>" class="is-active">
                <i class="fas fa-clock"></i>&nbsp; Time Settings
            </a>
          
             <a href="<?php echo e(route('settings.time', 4)); ?>" class="">
                <i class="fas fa-envelope"></i>&nbsp; Email Settings
            </a>
         	 <a href="<?php echo e(route('settings.other', 5)); ?>" class="">
                <i class="fas fa-cog"></i>&nbsp; Other Settings
            </a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('settings.time', 3), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-12">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Settings Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('name', $setting->name ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter setting name...'])); ?>

                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (!empty($setting)) {
                $fields = json_decode($setting->settings);
            }
            ?>

            <div class="columns">
                <div class="column is-12">
                    <div class="field">
                        <?php echo e(Form::label('time_zone', 'Time Zone', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('time_zone', $fields->company_name ?? 'Asia/Dhaka', ['required', 'class' => 'input', 'readonly' => true])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline">
              <?php /*
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('requisition_start', 'Requisition Start Time', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('requisition_start', $fields->requisition_start ?? NULL, ['class' => 'input', 'placeholder' => 'Enter requisition start...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('requisition_end', 'Requisition End Time', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('requisition_end', $fields->requisition_end ?? NULL, ['class' => 'input', 'placeholder' => 'Enter address...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('requisition_approval_start', 'Requisition Approval Start', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('requisition_approval_start', $fields->requisition_approval_start ?? NULL, ['class' => 'input', 'placeholder' => 'Enter requisition approval start...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('requisition_approval_end', 'Requisition Approval End', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('requisition_approval_end', $fields->requisition_approval_end ?? NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter requisition approval end...']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('bill_start', 'Bill Start', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('bill_start', $fields->bill_start ?? NULL, ['class' => 'input', 'placeholder' => 'Enter bill start...']) }}
                        </div>
                    </div>
                </div>

                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('bill_end', 'Bill End', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('bill_end', $fields->bill_end ?? NULL, ['class' => 'input', 'placeholder' => 'Enter bill end...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('bill_approval_start', 'Bill Approval Start', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('bill_approval_start', $fields->bill_approval_start ?? NULL, ['class' => 'input', 'placeholder' => 'Enter bill aproval start...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        {{ Form::label('bill_approval_end', 'Bill Approval End', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::text('bill_approval_end', $fields->bill_approval_end ?? NULL, ['class' => 'input', 'placeholder' => 'Enter bill aproval end...']) }}
                        </div>
                    </div>
                </div>
                */ ?>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('task_creation_end', 'Task Create End Time', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('task_creation_end', $fields->task_creation_end ?? NULL, ['class' => 'input', 'placeholder' => 'Ex: 0400pm'])); ?>

                        </div>
                    </div>
                </div>
              
              
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('proof_submission_end', 'Proof Submission End Time', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('proof_submission_end', $fields->proof_submission_end ?? NULL, ['class' => 'input', 'placeholder' => 'Ex: 0400pm'])); ?>

                        </div>
                    </div>
                </div>
              
                 <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('approval_time_end', 'Approver Approve End Time', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('approval_time_end', $fields->approval_time_end ?? NULL, ['class' => 'input', 'placeholder' => 'Ex: 0400pm'])); ?>

                        </div>
                    </div>
                </div>
              
              
              	<div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('requsition_submission_manager_end', 'Manager Requisition Submission End Time', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('requsition_submission_manager_end', $fields->requsition_submission_manager_end ?? NULL, ['class' => 'input', 'placeholder' => 'Ex: 0400pm'])); ?>

                        </div>
                    </div>
                </div>
              
              	<div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('requsition_submission_cfo_end', 'CFO Requisition Submission End Time', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('requsition_submission_cfo_end', $fields->requsition_submission_cfo_end ?? NULL, ['class' => 'input', 'placeholder' => 'Ex: 0400pm'])); ?>

                        </div>
                    </div>
                </div>
              
              
              
            </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/settings/time.blade.php ENDPATH**/ ?>