<?php $__env->startSection('title'); ?>
    Single Task
<?php $__env->stopSection(); ?>

<?php
    if (auth()->user()->isManager(auth()->user()->id)) {
        $addbtn = route('tasks.create');
        $alldatas = route('tasks.index');
    } else {
        $addbtn = '#';
        $alldatas = '#';
    }
?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Single Task',
            'spSubTitle' => 'view a Task',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addbtn,
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'Tasks',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spPlaceholder' => 'Search sites...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    
    

    <?php echo $__env->make('task::task_basic_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php
        $taskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('action_performed_by', auth()->user()->id)
                      ->orderBy('id', 'desc')->first();
        $proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
    ?>

    <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id)): ?>
        <?php echo $__env->make('task::taskaction.task_proof_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    <?php else: ?>
        <?php if(empty($taskStatus) || $taskStatus->code == 'task_assigned_to_head' && auth()->user()->isResource(auth()->user()->id)): ?>
            <?php echo $__env->make('task::taskaction.task_accept_decline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(empty($taskStatus) || $taskStatus->code == 'head_accepted'): ?>

            <?php
            $checkProof = Tritiyo\Task\Models\Task::leftjoin('tasks_proof', 'tasks_proof.task_id', '=', 'tasks.id')
              	->leftjoin('tasks_status', 'tasks_status.task_id', 'tasks.id')
                ->select('tasks.id','tasks.site_head', 'tasks_proof.task_id')
              	->where('tasks_status.code', 'task_assigned_to_head')
                ->where('tasks.site_head', auth()->user()->id)
                ->where('tasks_proof.task_id', null)
                ->orderBy('tasks.id', 'asc')
                ->get();
            //dump($checkProof);
            ?>

			<?php if(count($checkProof) > 0): ?>
      			
              <?php if($task->id == $checkProof[0]['id']): ?>
                  <?php
                      //echo date('hia');
                      $proof_submission_end = \App\Models\Setting::timeSettings('proof_submission_end');
                      //echo $taskCreationEndTime;
                      if(!empty($proof_submission_end) && date('Hi') > $proof_submission_end){
                          echo '<div class="notification is-danger py-1">Proof Submission Time is Over. You can not submit proof after '.numberToTimeFormat($proof_submission_end).' </div>';
                      }else{
                 ?>
                      <?php echo $__env->make('task::taskaction.task_proof_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <?php } ?>
              <?php else: ?>
                  <div class="notification is-success has-background-danger-dark " style="padding: 2px 10px;">
                      You have <?php echo e(count($checkProof) -1); ?> pending proof
                  </div>
              <?php endif; ?>
      		<?php endif; ?>




            
            
        <?php endif; ?>

    <?php endif; ?>

    <?php if(auth()->user()->isResource(auth()->user()->id)): ?>
        <?php echo $__env->make('task::taskaction.task_proof_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>


    <?php echo $__env->make('task::taskrequisitionbill.requistion_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Status
            </p>
        </header>

        <div class="card-content">
            <?php $taskStatus = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->orderBy('id', 'DESC')->get() ;

            ?>
            <?php //dd($taskStatus);?>
            <?php $__currentLoopData = $taskStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    if($task_status->code == 'head_declined' || $task_status->code == 'approver_declined' || $task_status->code == 'requisition_declined_by_cfo' || $task_status->code == 'requisition_declined_by_accountant'){
                            $msgClass = 'danger';
                    } else {
                            $msgClass = 'success';
                    }
                ?>
                <?php  $declineReason = \Tritiyo\Task\Models\TaskDecline::where('task_id', $task_status->task_id)->orderBy('id', 'DESC')->first(); ?>
                <div class="task_status <?php echo e($msgClass); ?>"><?php echo e($task_status->message); ?>


                    <?php echo e(!empty($declineReason) && $task_status->code == $declineReason->code ? '-Reason: '.$declineReason->decline_reason : ''); ?>


                    <div class="has-text-black-ter has-text-weight-medium"><?php echo e($task_status->created_at); ?></div>
                      <?php if(auth()->user()->isAdmin(auth()->user()->id)): ?>
                          <div class="has-text-black-ter has-text-weight-medium">
                            	Action performed by: <?php echo e(\App\Models\User::where('id', $task_status->action_performed_by)->first()->name); ?>

                  			</div>
                      <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('cusjs'); ?>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
        }

        .task_status {
            padding: .30rem .50rem;
            margin-bottom: .30rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            font-size: 11px;
        }

        .task_status.success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .task_status.danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\task\src/views/show.blade.php ENDPATH**/ ?>