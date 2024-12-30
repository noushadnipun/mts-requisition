

<?php if($task->manager_override_task_chunck != null): ?>
    <script>
        $('form.task_table button').addClass('is-hidden');
        $('form.task_table input').attr('disabled', true);
        $('form.task_table textarea').attr('disabled', true);
    </script>
<?php endif; ?>

<?php if(auth()->user()->isManager(auth()->user()->id)): ?>
    
<?php endif; ?>
<?php if(auth()->user()->isApprover(auth()->user()->id)): ?>
    
<?php endif; ?>

<?php echo $__env->make('task::taskaction.accept_decline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('task::task_basic_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php
    $taskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->orderBy('id', 'desc')->first();
  	//dump($taskStatus);
    $proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
?>

<?php if(auth()->user()->isManager(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id)): ?>
    <?php echo $__env->make('task::taskaction.task_proof_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    <?php if(empty($taskStatus) || $taskStatus->code == 'declined' && auth()->user()->isResource(auth()->user()->id)): ?>
        <?php echo $__env->make('task::taskaction.task_accept_decline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php elseif(empty($taskStatus) || $taskStatus->code == 'head_accepted'): ?>
        <?php echo $__env->make('task::taskaction.task_proof_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php elseif(empty($taskStatus) || $taskStatus->code == 'proof_given'): ?>
        <?php echo $__env->make('task::taskaction.task_proof_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php echo $__env->make('task::taskrequisitionbill.requistion_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/task_status_sidebar.blade.php ENDPATH**/ ?>