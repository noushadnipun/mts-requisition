<?php
$approved_task_status = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('code', 'approver_approved')->first();
//dd($approved_task_status);
//dump($approved_task_status);
$if_site_exists = \Tritiyo\Task\Models\Task::leftJoin('tasks_site', 'tasks_site.task_id', 'tasks.id')
                ->where('tasks.id', $task->id)
                ->whereRaw('tasks_site.site_id IS NOT NULL')
                ->get();
?>
<?php if($if_site_exists->count() > 0): ?>
    <?php if( $task->override_status == 'No' && $approved_task_status == Null || $task->override_status == Null): ?>

        <?php else: ?>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script>
            //$('form#requisition_form input').attr('disabled', true);
            //$('form#requisition_form button').addClass('is-hidden');
            $('form#add_route button').addClass('is-hidden');
            $('form#add_route input').attr('disabled', true);
            $('form#add_route textarea').attr('disabled', true);
        </script>
    <?php endif; ?>

    <?php if( $task->override_status == 'Yes' || $task->task_assigned_to_head == 'Yes' && $approved_task_status == Null): ?>
        <?php if($task->override_status == 'No'): ?>
        <?php else: ?>
            <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
            <script>
                //$('form#requisition_form input').attr('disabled', true);
                //$('form#requisition_form button').addClass('is-hidden');
                $('form#add_route button').addClass('is-hidden');
                $('form#add_route input').attr('disabled', true);
                $('form#add_route textarea').attr('disabled', true);
            </script>
        <?php endif; ?>
    <?php else: ?>
        <?php if( $task->task_assigned_to_head == NULL || $task->task_assigned_to_head == 'No'): ?>
            <?php echo e(Form::open(array('url' => route('tasks.update', $task->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

            <?php echo e(Form::hidden('task_id', $task->id ?? '')); ?>


            <?php if(!empty($task)): ?>
                <?php echo e(Form::hidden('task_assigned_to_head', 'Yes' ?? '')); ?>

                <?php echo e(Form::hidden('task_message_handler', 'task_assigned_to_head' ?? '')); ?>

                <input type="submit" value="Assign to head" class="button is-success is-small"/>
            <?php endif; ?>
            <?php echo e(Form::close()); ?>

        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <article class="message is-danger">
        <div class="message-body">
            আপনি এখনো এই কাজকে কোনো সাইটের অন্তর্ভুক্ত করেননি। দয়া করে সাইট ইনফরমেশনে ক্লিক করে সাইট যুক্ত করুন।
        </div>
    </article>
<?php endif; ?>

<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskaction/ready_for_assign_to_head.blade.php ENDPATH**/ ?>