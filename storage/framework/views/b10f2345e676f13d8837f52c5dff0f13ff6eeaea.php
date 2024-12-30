<?php $__env->startSection('title'); ?>
    User Permission
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'User Permission Information',
            'spSubTitle' => 'Edit user User permission information',
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
            <a href="<?php echo e(route('users.contact_info', $id)); ?>">Other Information</a>
            <a href="<?php echo e(route('users.user_photos', $id)); ?>">Images</a>
            <a href="<?php echo e(route('users.user_permissions', $id)); ?>" class="is-active">Permissions</a>
            <a href="<?php echo e(route('users.financial_info', $id)); ?>">Financial Information</a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('users.user_permissions', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column">
                    <?php $routelist = \App\Models\Routelist::get(); ?>
                    <table class="table is-bordered">
                        <tr>
                            <th></th>
                            <th>Route Name</th>
                            <th>URL</th>
                            <th>Description</th>
                            <th>Note</th>
                            <th>In</th>
                            <th>For</th>
                        </tr>
                        <?php $__currentLoopData = $routelist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $data = \DB::table('permissions')->select('checked')->where('route_id', $list->id)->where('user_id', $id)->get()->all();

                            if ($data) {
                                foreach ($data as $d) {
                                    if ($d->checked == 'on') {
                                        $checked = 'checked';
                                    } else {
                                        $checked = '';
                                    }
                                }

                            } else {
                                $checked = '';
                            }
                            ?>
                            <tr>
                                <td>
                                    <input name="permission[<?php echo e($key); ?>][route_id]"
                                           type="hidden"
                                           value="<?php echo e($list->id); ?>"/>
                                    <input name="permission[<?php echo e($key); ?>][user_id]"
                                           type="hidden"
                                           value="<?php echo e($id); ?>"/>
                                    <?php if($data ?? ''): ?>
                                        <input name="permission[<?php echo e($key); ?>][checked]"
                                               type="hidden" <?php echo e($checked ?? ''); ?> value="off"/>
                                        <input name="permission[<?php echo e($key); ?>][checked]"
                                               type="checkbox" <?php echo e($checked ?? ''); ?> value="on"/>
                                    <?php else: ?>
                                        <input name="permission[<?php echo e($key); ?>][checked]"
                                               type="checkbox" <?php echo e($checked ?? ''); ?> value="on"/>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($list->route_name); ?></td>
                                <td><?php echo e($list->route_url); ?></td>
                                <td><?php echo e($list->route_description); ?></td>
                                <td><?php echo e($list->route_note); ?></td>
                                <td>
                                    <?php
                                    $designation = \App\Models\Designation::where('id', $list->route_grouping)->get()->all();
                                    foreach ($designation as $desi) {
                                        echo $desi->name;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $roles = \App\Models\Role::where('id', $list->to_role)->get()->all();
                                    foreach ($roles as $role) {
                                        echo $role->name;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="user_permissions"
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/users/user_permissions.blade.php ENDPATH**/ ?>