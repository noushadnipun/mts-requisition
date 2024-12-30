<?php $__env->startSection('title'); ?>
    Users
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Users',
            'spSubTitle' => 'all users here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spTitle' => 'Users',
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spTitle' => 'Users',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="column is-2">
            <div class="control">
                <?php 
                    $filterUser = ['Enroll', 'Terminated', 'Long Leave', 'Left Job', 'On Hold'];
                	$filterDepartments = [
                        'Accounts & Finance' => 'Accounts & Finance',
                        'Administration'  => 'Administration',
                        'Maintenance' => 'Maintenance',
                        'Management' => 'Management',
                        'E-Commerce' => 'E-Commerce',
                        'Tourism'   => 'Tourism',
                        'Technical' => 'Technical',
                        'HR' => 'HR',
                        'Office Staff' => 'Office Staff',
                      ];
                ?>
                <form action="<?php echo e(route('users.index')); ?>" method="get" class="is-inline-block" style="vertical-align: top;">
                  <!-- employee status -->
                    <select name="filter_user" id="filter_user" class="select sb-example-1" xonchange="this.form.submit()">
                        <option  value=""> Filter User</option>
                        <?php $__currentLoopData = $filterUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e($value == request()->get('filter_user') ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  <!-- Deprtments Filter -->
                  	<select name="filter_department" id="filter_department" class="select sb-example-1" xonchange="this.form.submit()">
                        <option  value=""> Filter Department</option>
                        <?php $__currentLoopData = $filterDepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e($value == request()->get('filter_department') ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  <button type="submit" style="vertical-align: top; margin-top: 1px;" class="button is-small is-info-light is-rounded"><i class="fa fa-search"></i></button>
                </form>
              
              
            
              
            </div>
        </div>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spPlaceholder' => 'Search user...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php
    function enrollStatus($status) {
        switch ($status) {
          case 'Enroll':
            $colorClass = '';
            break;
          case 'Terminated':
            $colorClass = 'is-danger has-text-danger';
            break;
          case 'Long Leave':
            $colorClass = 'is-link has-text-link';
            break;
            case 'Left Job':
                $colorClass = 'is-warning has-text-warning';
            break;
          default:
            $colorClass = '';
        }
        return $colorClass;
    }
?>
<?php $__env->startSection('column_left'); ?>
    <div class="columns is-multiline">
        <?php
      	if (request()->get('filter_user') && request()->get('filter_department') ){
            $users = \App\Models\User::where('employee_status', request()->get('filter_user'))->where('department', request()->get('filter_department'))->orderBy('id', 'desc')->paginate(24);
        }
      	elseif (request()->get('filter_user')){
            $users = \App\Models\User::where('employee_status', request()->get('filter_user'))->orderBy('id', 'desc')->paginate(24);
        }elseif (request()->get('filter_department')){
            $users = \App\Models\User::where('department', request()->get('filter_department'))->orderBy('id', 'desc')->paginate(24);
        }
        ?>

        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      		
            <div class="column is-3">
                <article class="borderedCol media message <?php echo e(enrollStatus($user->employee_status)); ?>">
                    <div class="media-content">
                        <div class="content">
                            <div>
                                <strong>
                                    <a href="<?php echo e(route('users.show', $user->id)); ?>"
                                    title="View user">
                                        <?php echo e($user->name); ?>

                                    </a>
                                </strong>
                            </div>
                            <div style="color: #000 !important;">
                                <small>
                                    <strong>Designation: </strong> <?php echo e(\App\Models\Designation::where('id', $user->designation)->first()->name); ?>

                                </small>
                              	<br/>
                              	 <small>
                                    <strong>Department: </strong> <?php echo e($user->department ?? Null); ?>

                                </small>
                                <br/>
                                <small>
                                    <strong>Role: </strong> <?php echo e(\App\Models\Role::where('id', $user->role)->first()->name); ?>

                                </small>
                                <br/>
                                <small>
                                    <strong>Email: </strong> <?php echo e($user->email); ?>

                                </small>
                                <br>
                                <small>
                                    <strong>Employee Status: </strong> <?php echo e($user->employee_status); ?>

                                </small>
                                <br/>
                                <small>
                                    <strong>Employee No:</strong> <?php echo e($user->employee_no); ?> &
                                    <strong>Phone: </strong> <?php echo e($user->phone); ?>

                                </small>
                            </div>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a href="<?php echo e(route('users.show', $user->id)); ?>"
                                class="level-item"
                                title="View user data">
                                    <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                </a>
                                <a href="<?php echo e(route('users.basic_info', $user->id)); ?>"
                                class="level-item"
                                title="View all transaction">
                                    <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                </a>
                                
                                <a href="<?php echo e(route('users.reset_password', $user->id)); ?>"
                                class="level-item"
                                 onclick="confirm('Are you sure?')"
                                title="Reset Password">
                                    <span class="icon is-danger is-small" style="color: red;"><i class="fas fa-lock"></i></span>
                                </a>
                                
                                <!--
                                <a class="level-item" title="Delete user" href="javascript:void(0)" onclick="confirm('Are you sure?')">
                                    <span class="icon is-small is-red"><i class="fas fa-times"></i></span>
                                </a>
                                -->
                            </div>
                        </nav>
                    </div>
                    <figure class="media-right">
                        <p class="image is-64x64">
                            <?php if(!empty($user->avatar)): ?>
                                <img class="is-rounded avatar"
                                    src="<?php echo e(url($user->avatar)); ?>" alt="<?php echo e($user->name); ?>">
                            <?php else: ?>
                                <img class="is-rounded avatar"
                                    src="https://bulma.io/images/placeholders/128x128.png">
                            <?php endif; ?>
                        </p>
                    </figure>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="pagination_wrap pagination is-centered">
      <?php if(request()->get('filter_user') && request()->get('filter_department')): ?>
      	<?php echo e($users->appends(['filter_user'=> request()->get('filter_user'), 'filter_department'=> request()->get('filter_department')])->links('pagination::bootstrap-4')); ?>

      <?php elseif(request()->get('filter_user') ): ?>
      	<?php echo e($users->appends(['filter_user'=> request()->get('filter_user')])->links('pagination::bootstrap-4')); ?>

       <?php elseif(request()->get('filter_department') ): ?>
      	<?php echo e($users->appends(['filter_department'=> request()->get('filter_department')])->links('pagination::bootstrap-4')); ?>

      <?php else: ?>
        <?php echo e($users->links('pagination::bootstrap-4')); ?>

      <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<style>
    article.media {
        border: 1px solid #eeeeee;
    }

    article.media.message {
        padding: 10px;
        font-size: 13px;
        overflow-wrap: break-word;
    }

    img.avatar {
        width: 70px !important;
        height: 70px !important;
        min-width: 70px !important;
        min-height: 70px !important;
    }

    .message a:not(.button):not(.tag):not(.dropdown-item) {
        text-decoration: none !important;
    }

</style>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\resources\views/users/index.blade.php ENDPATH**/ ?>