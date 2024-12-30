<?php $__env->startSection('title'); ?>
    Create User
<?php $__env->stopSection(); ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Create User',
            'spSubTitle' => 'start with basic information',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spTitle' => 'Users',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search user...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Basic Information</a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('users.store'), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('name', NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter name...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('employee_no', 'Employee no', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('employee_no', NULL, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter employee no...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('phone', 'Mobile', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('phone', NULL, ['required', 'class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('emergency_phone', 'Emergency mobile', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('emergency_phone', NULL, ['class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11])); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('email', 'Email', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('email', NULL, ['class' => 'input', 'type' => 'email', 'placeholder' => 'Enter email...'])); ?>

                            
                            
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('department','Department',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select" style="width: 100%">
                                <?php
                                //$designations = \App\Models\Designation::pluck('name', 'id');
                                $departments = array(
                                    '' => 'Select a department',
                                    'Accounts & Finance' => 'Accounts & Finance',
                                    'Administration'  => 'Administration',
                                    'Maintenance' => 'Maintenance',
                                    'Management' => 'Management',
                                    'E-Commerce' => 'E-Commerce',
                                    'Tourism'   => 'Tourism',
                                    'Technical' => 'Technical',
                                    'HR' => 'HR',
                                    'Office Staff' => 'Office Staff',
                                );
                                ?>
                                <?php echo e(Form::select('department', $departments ?? NULL, NULL, ['class' => 'input is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('designation','Designation',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select" style="width: 100%">
                                <?php $designations = \App\Models\Designation::pluck('name', 'id'); ?>
                                <?php echo e(Form::select('designation', $designations ?? NULL, NULL, ['class' => 'input  is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('role','User Role',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select" style="width: 100%">
                                <?php $designations = \App\Models\Role::pluck('name', 'id'); ?>
                                <?php echo e(Form::select('role', $designations ?? NULL, NULL, ['class' => 'input is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-success is-small">Save Changes</button>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>

    <div class="box">
        <h1 class="title is-5">Important Note</h1>
        <p>
            The default password is stored in the database when the admin authority creates the user.
            <br/>
            Default password: <strong>mtsbd123</strong>
        </p>
        <br/>
        <p>
            After you provide the basic information, you create a list of users, now you will find the created user and
            update the information for your user.
        </p>
    </div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/users/create.blade.php ENDPATH**/ ?>