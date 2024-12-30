<?php if(auth()->user()->isResource(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id)): ?>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title" style="background: lemonchiffon">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Task Acception Panel
            </p>
        </header>
        <?php
            $taskStatuss = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                                  ->orderBy('id', 'desc')->first();
        ?>
        <div class="card-content">
            <div class="card-data">
                <?php echo e(Form::open(array('url' => route('taskstatus.store'), 'method' => 'POST', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

                <?php echo e(Form::hidden('task_id', $task->id ?? '')); ?>


                <?php if(!empty($taskStatuss) && ($taskStatuss->code == 'head_declined' && auth()->user()->id == $taskStatuss->action_performed_by)): ?>
                    <button class="button is-danger">Task Declined</button>
                <?php else: ?>
                <?php echo Tritiyo\Task\Helpers\TaskHelper::buttonInputApproveDecline('head_accepted', 'head_declined');?>
                <?php endif; ?>

                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskaction/task_accept_decline.blade.php ENDPATH**/ ?>