<?php
if (request()->get('task_id')) {
    $task_id = request()->get('task_id');
} elseif (!empty($task)) {
    $task_id = $task->id;
}

$requisition = \Tritiyo\Task\Models\TaskRequisitionBill::select('id')->where('task_id', $task_id)->first();

if ($requisition) {
    $requisitionUrl = url('taskrequisitionbill/' . $requisition->id . '/edit/?task_id=' . $task_id . '&information=requisitionbillInformation');
} else {
    $requisitionUrl = url('taskrequisitionbill/create?task_id=' . $task_id . '&information=requisitionbillInformation');
}

$taskInformation = 'taskinformation';
$siteInformation = 'siteinformation';
$vehicleInformation = 'vehicleinformation';
$materialInformation = 'materialInformation';
$anonymousProofInformation = 'anonymousproof';
$requisitionbillInformation = 'requisitionbillInformation';

?>

<div class="panel-tabs">
    <a class="<?php echo e(request()->get('information') == $taskInformation ? 'is-active' : ''); ?>"
       href="<?php echo e(route('tasks.edit', $task_id)); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($taskInformation); ?>">Task
        Information</a>
    <a class="<?php echo e(request()->get('information') == $siteInformation ? 'is-active' : ''); ?>"
       href="<?php echo e(route('tasks.site.edit', $task_id)); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($siteInformation); ?>">Site
        Information</a>
    <a class="<?php echo e(request()->get('information') == $anonymousProofInformation ? 'is-active' : ''); ?>"
       href="<?php echo e(route('tasks.anonymousproof.edit', $task_id)); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($anonymousProofInformation); ?>"
       class="">Anonymous Proof</a>
    <a class="<?php echo e(request()->get('information') == $vehicleInformation ? 'is-active' : ''); ?>"
       href="<?php echo e(route('taskvehicle.create')); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($vehicleInformation); ?>" class="">Vehicle
        Information</a>
    <a class="<?php echo e(request()->get('information') == $materialInformation ? 'is-active' : ''); ?>"
       href="<?php echo e(route('taskmaterial.create')); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($materialInformation); ?>" class="">Material
        Information</a>

    <?php
    $taskStsApproverApproved = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task_id)->get();
    $collection = Tritiyo\Task\Helpers\TaskHelper::arrayExist($taskStsApproverApproved, 'code', 'approver_approved');
    ?>
    <?php if($collection == true): ?>
        <?php if( auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id)): ?>
            <a class="<?php echo e(request()->get('information') == $requisitionbillInformation ? 'is-active' : ''); ?>"
               href="<?php echo e($requisitionUrl); ?>?task_id=<?php echo e($task_id); ?>&information=<?php echo e($requisitionbillInformation); ?>" class="">Requisition
                Information</a>

        <?php endif; ?>
    <?php endif; ?>
  
  
  
  
	<!-- Guard For task -->
  <?php 
  	$guardForTask = \Tritiyo\Task\Models\Task::where('id', $task_id)->first();
  	$guardForTaskRequisition = \Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $task_id)->first();
   	$guardForTaskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task_id)->orderBy('id', 'desc')->first();
  ?>
   <?php if(auth()->user()->isResource(auth()->user()->id)): ?>
  
  	<?php if($guardForTask->site_head == auth()->user()->id): ?>
  	<?php else: ?>
  		<?php dd('Invalid Request');?>
  	<?php endif; ?>
	
  	<?php if(Route::currentRouteName() == 'tasks.edit'): ?>
  		<?php dd('Invalid Request'); ?>
  	<?php endif; ?>
  	
  
  <?php endif; ?>
  
  
  <?php if(auth()->user()->isManager(auth()->user()->id)): ?>
  
  	<?php if($guardForTask->user_id == auth()->user()->id): ?>
  	<?php else: ?>
  		<?php dd('This is not your Task');?>
  	<?php endif; ?>
  
  <?php endif; ?>
  
  
    <?php if(auth()->user()->isCFO(auth()->user()->id)): ?>
  
  		<?php if(empty($guardForTaskRequisition) || (!empty($guardForTaskRequisition) && $guardForTaskRequisition->requisition_submitted_by_manager == NULL) ): ?>
  				<style>
                  button.button {display: none}
                    input.button {display: none}
                    a.button {display: none}
  				</style>
  		<?php endif; ?>
  
  <?php endif; ?>
  
  
  <?php if(auth()->user()->isAccountant(auth()->user()->id)): ?>
  
  		<?php if(empty($guardForTaskRequisition) || (!empty($guardForTaskRequisition) && $guardForTaskRequisition->requisition_approved_by_cfo == NULL) ): ?>
  				<style>
                  button.button {display: none}
                    input.button {display: none}
                    a.button {display: none}
  				</style>
  		<?php endif; ?>
  
  <?php endif; ?>
  
    <?php if(auth()->user()->isApprover(auth()->user()->id)): ?>
  		
  		<?php if($guardForTaskStatus->code == 'proof_given' || $guardForTaskStatus->code == 'task_approver_edited' || $guardForTaskStatus->code == 'task_override_data'): ?>
  			
  		<?php else: ?>
  			<style>
                  button.button {display: none}
              	  input.button {display: none}
              	  a.button {display: none}
  			</style>

  		<?php endif; ?>
  		
  	<?php endif; ?>
 
  
</div>

<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/layouts/tab.blade.php ENDPATH**/ ?>