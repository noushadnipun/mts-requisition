<?php $__env->startSection('title'); ?>
    Other Information
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Other Information',
            'spSubTitle' => 'Edit user other information',
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
            <a href="<?php echo e(route('users.basic_info', $id)); ?>">Basic Information</a>
            <a href="<?php echo e(route('users.contact_info', $id)); ?>" class="is-active">Other Information</a>
            <a href="<?php echo e(route('users.user_photos', $id)); ?>">Images</a>
            <a href="<?php echo e(route('users.user_permissions', $id)); ?>">Permissions</a>
            <a href="<?php echo e(route('users.financial_info', $id)); ?>">Financial Information</a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('users.contact_info', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>


            <div class="columns">
                <div class="column is-4">
                    <div class="field">
                        <strong>Personal Information</strong>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('father', 'Father Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('father', $user->father, ['required', 'class' => 'input', 'placeholder' => 'Enter father name...'])); ?>

                        </div>
                    </div>

                    <div class="field">
                        <?php echo e(Form::label('mother', 'Mother Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('mother', $user->mother, ['required', 'class' => 'input', 'placeholder' => 'Enter mother name...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('address','Permanent Address', ['class' => 'label'])); ?>

                        <div class="control">
                            <?php echo e(Form::textarea('address', $user->address, ['required', 'class' => 'textarea', 'rows' => 2])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('postcode','Post Code',['class' => 'label'])); ?>

                        <div class="control">
                            <?php echo e(Form::number('postcode', $user->postcode, ['required', 'class' => 'input'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('district','District',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php
                                $districts = \DB::table('districts')->get()->pluck('name', 'name');
                                //dd($districts);
                                //$districts = ['' => 'Select district', 'Married' => 'Married', 'Unmarried' => 'Unmarried', 'Other' => 'Other'];
                                ?>
                                <?php echo e(Form::select('district', $districts ?? NULL, $user->district, ['class' => 'input', 'required' => true])); ?>

                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <?php echo e(Form::label('gender', 'Gender', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php $genders = ['' => 'Select gender', 'Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other']; ?>
                            <?php echo e(Form::select('gender', $genders ?? NULL, $user->gender, ['class' => 'input', 'required' => true])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('marital_status', 'Marital Status', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php $marital_statuses = ['' => 'Select marital status', 'Married' => 'Married', 'Unmarried' => 'Unmarried', 'Other' => 'Other']; ?>
                            <?php echo e(Form::select('marital_status', $marital_statuses ?? NULL, $user->marital_status, ['class' => 'input', 'required' => true])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('birthday', 'Birthday', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::date('birthday', $user->birthday, ['required', 'class' => 'input', 'placeholder' => 'Enter birthday...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('alternative_email', 'Alternative Email', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('alternative_email', $user->alternative_email, ['class' => 'input', 'type' => 'email', 'placeholder' => 'Enter email...'])); ?>

                        </div>
                    </div>

                    <div class="field">
                        <?php echo e(Form::label('basic_salary', 'Basic Salary', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('basic_salary', $user->basic_salary, ['required', 'class' => 'input', 'placeholder' => 'Enter basic_salary...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('join_date', 'Join Date', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::date('join_date', $user->join_date, ['required', 'class' => 'input', 'placeholder' => 'Enter join_date...'])); ?>

                        </div>
                    </div>

                    <div class="field">
                        <?php echo e(Form::label('employee_status','Employee Status',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php $emp_status = ['' => 'Select status', 'Enroll' => 'Enroll', 'Terminated' => 'Terminated', 'Long Leave' => 'Long Leave', 'Left Job' => 'Left Job', 'On Hold']; ?>
                                <?php echo e(Form::select('employee_status', $emp_status ?? NULL, $user->employee_status, ['class' => 'input', 'required' => true])); ?>                                
                                <input type="hidden" value="<?php echo e($user->employee_status_reason ?? NULL); ?>" name="employee_status_reason" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <strong>Old Company Information</strong>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('company', 'Company Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('company', $user->company, ['class' => 'input', 'placeholder' => 'Enter company name...', 'required' => true])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('company_address','Company Address',['class' => 'label'])); ?>

                        <div class="control">
                            <?php echo e(Form::text('company_address', $user->company_address, ['class' => 'textarea', 'rows' => 5, 'required' => true])); ?>

                        </div>
                    </div>
                </div>
            </div>


            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="contact_info"
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/users/contact_info.blade.php ENDPATH**/ ?>