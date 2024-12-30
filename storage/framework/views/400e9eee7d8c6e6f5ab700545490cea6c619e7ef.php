<?php $__env->startSection('title'); ?>
    User Profile
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'User Profile',
            'spSubTitle' => 'a single user data',
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
    
    
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Basic Information
            </p>
        </header>
        <div class="card-content">
            <div class="is-user-avatar image has-max-width is-aligned-center">
                <?php if(!empty($user->avatar)): ?>
                    <img src="<?php echo e(url($user->avatar)); ?>" alt="<?php echo e($user->name); ?>">
                <?php else: ?>
                    User Photo
                <?php endif; ?>
            </div>
            <hr/>
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Name</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->name); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Email</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->email); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee No</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->employee_no); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Username</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->username); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Role</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e(\App\Models\Role::where('id', $user->role)->first()->name); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Birthday</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->birthday); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Gender</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->gender); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Marital Status</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->marital_status); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Phone No</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->phone); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Phone No (Alternative)</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->emergency_phone); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Basic Salary</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->basic_salary); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee Status</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->employee_status ?? NULL); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Employee Status Note</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->employee_status_reason ?? NULL); ?></div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Company and Other Information
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Father</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->father); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Mother</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->mother); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Address</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->address); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">District</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->district); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Post Code</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->postcode); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Company</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->company); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Designation</div>
                    <div class="column is-1">:</div>
                    <div
                        class="column"><?php echo e(\App\Models\Designation::where('id', $user->designation)->first()->name); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Join Date</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->join_date); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Company Address</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->company_address); ?></div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Financial Information
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Bank Information</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->bank_information); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Mobile Banking Information</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->mbanking_information); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Email (Alternative)</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->alternative_email); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Is Active</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($user->is_active); ?></div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Reading folder from module
            </p>
        </header>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/users/show.blade.php ENDPATH**/ ?>