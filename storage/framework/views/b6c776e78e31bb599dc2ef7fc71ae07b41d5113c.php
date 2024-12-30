<?php $__env->startSection('title'); ?>
    Include Anonymous Proof information of task
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Vehicle',
            'spSubTitle' => 'Add Anonymous Proof of task',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'Tasks',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary" id="app">

        <?php
        $disabled = 'disabled="disabled"';
        $task_id = request()->get('task_id');
        ?>

        <?php echo $__env->make('task::layouts.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <div class="customContainer">

            <?php echo e(Form::open(array('url' => route('tasks.update', $task_id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>


            <div class="columns">
                <div class="column is-9">
                    <div class="field">
                        <label for="task_details" class="label">Task Anonymous Proof Details</label>
                        <div class="control">
                            <?php if(auth()->user()->isManager(auth()->user()->id)): ?>
                                <?php
                                    $disabled = '';
                                ?>
                            <?php endif; ?>
                            <input type="hidden" name="anonymousproof_details" value="anonymousproof_details">
                            <textarea  class="textarea" rows="5" placeholder="Enter Task Anonymous Proof Details..."
                                      name="anonymous_proof_details" cols="50"
                                      id="anonymous_proof_details" <?php echo e($disabled); ?>><?php echo e($task->anonymous_proof_details); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(auth()->user()->isManager(auth()->user()->id)): ?>
                <div class="columns">
                    <div class="column">
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-success is-small">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>

            <?php endif; ?>
            <?php echo e(Form::close()); ?>

        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <?php
        $task = \Tritiyo\Task\Models\Task::where('id', $task_id)->first();
    ?>
    <?php echo $__env->make('task::task_status_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('cusjs'); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskanonymousproof/create.blade.php ENDPATH**/ ?>