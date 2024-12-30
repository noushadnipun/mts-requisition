
        <?php
            $taskStatuss = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                                  ->orderBy('id', 'desc')->first();
        ?>

        <?php echo e(Form::open(array('url' => route('taskstatus.store'), 'method' => 'POST', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

        <?php echo e(Form::hidden('task_id', $task->id ?? '')); ?>



        <?php if(!empty($taskStatus) && $taskStatus->code == 'declined' && auth()->user()->id == $taskStatus->action_performed_by): ?>

                <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
                <script>
                    $('form#requisition_form input').attr('disabled', true);
                    $('form#requisition_form button').addClass('is-hidden');
                    $('form#add_route button').addClass('is-hidden');
                    $('form#add_route input').attr('disabled', true);
                    $('form#add_route textarea').attr('disabled', true);
                </script>

        <?php elseif(!empty($taskStatuss)  && $taskStatuss->code == 'task_approver_edited'): ?>
            <?php echo Tritiyo\Task\Helpers\TaskHelper::buttonInputApproveDecline('approver_approved', 'approver_declined');?>

        <?php elseif(!empty($taskStatuss)  && $taskStatuss->code == 'approver_approved'): ?>

        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
         <script>
            $('form#requisition_form input').attr('disabled', true);
            $('form#requisition_form button').addClass('is-hidden');
            $('form#add_route button').addClass('is-hidden');
            $('form#add_route input').attr('disabled', true);
            $('form#add_route textarea').attr('disabled', true);
        </script>

        <?php elseif(!empty($taskStatuss)  && $taskStatuss->code == 'approver_declined'): ?>

        <button class="button is-danger is-small">Task Declined</button>

        <?php else: ?>
            <?php if( $task->override_status == 'Yes' || $task->override_status == Null): ?>				
                <?php echo Tritiyo\Task\Helpers\TaskHelper::buttonInputApproveDecline('approver_approved', 'approver_declined');?>
            <?php endif; ?>
        <?php endif; ?>

        <?php echo e(Form::close()); ?>



<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskaction/task_approver_accept_decline.blade.php ENDPATH**/ ?>