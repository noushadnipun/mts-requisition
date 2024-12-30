<?php if(!empty($task)): ?>
<?php
  $latest = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->main_task_id)->where('code', 'approver_approved')->orderBy('id', 'desc')->first();
  $requisition = \Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $task->main_task_id)->first();

  if ($latest) {
    if ($requisition) {
      $taskEditUrl = url('taskrequisitionbill/' . $requisition->id . '/edit/?task_id=' . $task->main_task_id . '&information=requisitionbillInformation');
    } else {
      $taskEditUrl = url('taskrequisitionbill/create?task_id=' . $task->main_task_id . '&information=requisitionbillInformation');
    }
  } else {
    $taskEditUrl = route('tasks.edit', $task->main_task_id) . '?task_id=' . $task->main_task_id . '&information=taskinformation';
  }


?>
<tr>
    <td>
        <small>
            <a href="<?php echo e($taskEditUrl); ?>"
                title="View task" target="_blank">
                <strong style="color: #555;">Task Name: </strong>
                <?php echo e($task->task_name); ?>

            </a>
           <br/>
          	<strong>Task ID:</strong>
            <?php echo e($task->main_task_id); ?><br/>
            <strong>Task Type:</strong>
            <?php echo e($task->task_type); ?><br/>
            <strong>Task Date:</strong>
            <?php echo e($task->task_for); ?><br/>
        </small>
    </td>
    <td>
        
        <?php if(isset($task_status->message)): ?>
            <?php if($task_status->code == 'head_declined' || $task_status->code == 'approver_declined' || $task_status->code == 'requisition_declined_by_cfo' || $task_status->code == 'requisition_declined_by_accountant'): ?>
                <?php
                    $red = 'statusDangerMessage';
                ?>
            <?php endif; ?>
            <div class="<?php echo e(!empty($red) ? $red : 'statusSuccessMessage'); ?>" style="display: inline-block">
              	<?php echo e($task_status->message ?? NULL); ?>  <br/>
                
              	 <?php if(auth()->user()->isAdmin(auth()->user()->id)): ?>
                   <div class="has-text-black-ter has-text-weight-medium">
                        Action performed by: <?php echo e(\App\Models\User::where('id', $task_status->action_performed_by)->first()->name); ?>

                   </div>
                  <?php endif; ?>
            </div>
        <?php endif; ?><br/>

    </td>
    <td>
        <small>
            <strong>Project: </strong>
            <?php $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first() ?>
            <?php echo e($project->name); ?> (<?php echo e($task->project_id); ?>)<br/>

            <strong>Project Manager: </strong>
            <?php
                $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first();
            ?>
            <?php echo e(\App\Models\User::where('id', $project->manager)->first()->name ?? NULL); ?>

            (<?php echo e($project->manager); ?>)<br/>
            <strong>Site Head:</strong>
            	<?php if($task->site_head): ?>
                  <a href="<?php echo e(route('hidtory.user', $task->site_head)); ?>" target="_blank">
                      <?php echo e(\App\Models\User::where('id', $task->site_head)->first()->name ?? NULL); ?>

                  </a>
                <?php endif; ?>
            <br/>
        </small>
    </td>
    <td>
        <small>
            <strong>Requisition Total:</strong>
            <?php
          			$rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('reba_amount', $task->main_task_id, false);          			
          	?>
          	<?php echo e($rm->ttrbAmountPicker('reba_amount', $task->main_task_id, false) ?? 0); ?>

            <br/>
            <strong>Bill Total:</strong>
            <?php
          			$rm = new \Tritiyo\Task\Helpers\SiteHeadTotal('beba_amount', $task->main_task_id, false);          			
          	?>
          	<?php echo e($rm->ttrbAmountPicker('beba_amount', $task->main_task_id, false) ?? 0); ?>

            <br/>
        </small>
    </td>
</tr>
<?php endif; ?>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/tasklist/task_search_result_template.blade.php ENDPATH**/ ?>