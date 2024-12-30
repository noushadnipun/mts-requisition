<?php $__env->startSection('title'); ?>
    Basic Information
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Basic Information',
            'spSubTitle' => 'Edit user basic information',
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
            <a href="<?php echo e(route('users.basic_info', $id)); ?>" class="is-active">Basic Information</a>
            <a href="<?php echo e(route('users.contact_info', $id)); ?>">Other Information</a>
            <a href="<?php echo e(route('users.user_photos', $id)); ?>">Images</a>
            <a href="<?php echo e(route('users.user_permissions', $id)); ?>">Permissions</a>
            <a href="<?php echo e(route('users.financial_info', $id)); ?>">Financial Information</a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('users.basic_info', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('name', $user->name, ['required', 'class' => 'input', 'placeholder' => 'Enter name...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('employee_no', 'Employee no', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('employee_no', $user->employee_no, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter employee no...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('phone', 'Mobile', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('phone', $user->phone, ['required', 'class' => 'input', 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('emergency_phone', 'Emergency mobile', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::number('emergency_phone', $user->emergency_phone, ['class' => 'input', 'required' => true, 'placeholder' => 'Enter phone no...', 'maxlength' => 11, 'minlength' => 11])); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-4">
                    <div class="field">
                        <?php echo e(Form::label('email', 'Email', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('email', $user->email, ['class' => 'input', 'type' => 'email', 'placeholder' => 'Enter email...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <?php echo e(Form::label('department','Department',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select is-fullwidth">
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
                                <?php echo e(Form::select('department', $departments ?? NULL, $user->department, ['class' => 'input is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('designation','Designation',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select is-fullwidth">
                                <?php $designations = \App\Models\Designation::pluck('name', 'id'); ?>
                                <?php echo e(Form::select('designation', $designations ?? NULL, $user->designation, ['class' => 'input is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('role','User Group',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select is-fullwidth">
                                <?php $roles = \App\Models\Role::pluck('name', 'id'); ?>
                                <?php echo e(Form::select('role', $roles ?? NULL, $user->role, ['class' => 'input is-small'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="basic_info"
                                   class="button is-success is-small"
                                   value="Save Changes"/>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/users/basic_info.blade.php ENDPATH**/ ?>