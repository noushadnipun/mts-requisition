<?php $__env->startSection('title'); ?>
    Tasks
<?php $__env->stopSection(); ?>

<?php
    if (auth()->user()->isManager(auth()->user()->id)) {
        $addbtn = route('tasks.create');
    } else {
        $addbtn = '#';
        $alldatas = '#';
    }
?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Tasks',
            'spSubTitle' => 'all tasks here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php 
      		if(auth()->user()->isManager(auth()->user()->id)){
      		 $billPendingTask =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_manager', Null)
          							->where('tasks.user_id', auth()->user()->id)
                                   ->orderBy('tasks.id', 'desc');
            }
      
      		elseif(auth()->user()->isCFO(auth()->user()->id)) {
            	$billPendingTask =  \Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                        			->select('tasks.*', 'tasks_requisition_bill.task_id')
                                    ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                    ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                    ->where('tasks_requisition_bill.bill_approved_by_manager', 'Yes')
                                    ->where('tasks_requisition_bill.bill_approved_by_CFO', Null)
                                    ->orderBy('tasks.id', 'desc');
              
            } elseif(auth()->user()->isAccountant(auth()->user()->id)){
            	$billPendingTask = Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_manager', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_cfo', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_accountant', Null)
                                   ->orderBy('tasks.id', 'desc');
            } 
     		 elseif(auth()->user()->isResource(auth()->user()->id)){
            	$billPendingTask = Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
          							->where('tasks.task_assigned_to_head', 'Yes')
          							->where('tasks.site_head', auth()->user()->id)
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', NULL)
                                   ->orderBy('tasks.id', 'desc');
            } 
      		else{
            	$billPendingTask = '';
            }
      
      		//echo $billPendingTask;
            if(!empty($billPendingTask)){
             if(request()->get('user')){
                $billPendingTask = $billPendingTask->where('tasks.site_head', request()->get('user'));	
              }	
             $billPendingTask = $billPendingTask->count();
            }
     		 ?>
      
	<?php if($billPendingTask > 50 && auth()->user()->isManager(auth()->user()->id)): ?>
      <span class="tag is-small is-tag is-danger  is-rounded" style="font-weight: 600;">You can not create any task, cause you have <?php echo e($billPendingTask); ?> pending bills to clear. please clear your pending bills. </span>
      <a class="tag is-small is-tag is-warning is-dark is-rounded" href="<?php echo e(route('tasks.index')); ?>?bill=pending">Click to view Pending Bills</a>
      
	<?php else: ?>
        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addbtn,
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'All Task',
            'spCss' => 'is-warning',
            'xspAllData' => route('tasks.index').'?bill=pending',
            'xspTitle' => 'Pending Bills ('.$billPendingTask.')',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php endif; ?>
      










      

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    </nav>
</section>


<?php
function userAccess($arg)
{
    return auth()->user()->$arg(auth()->user()->id);
}
?>
<?php $__env->startSection('column_left'); ?>
    <?php if(!empty($tasks)): ?>
        <div class="columns is-multiline">

            <?php if(auth()->user()->isResource(auth()->user()->id)): ?>
          
          		<?php
          			if(request()->get('bill') == 'pending'){
                       $tasks =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
          							->where('tasks.task_assigned_to_head', 'Yes')
          							->where('tasks.site_head', auth()->user()->id)
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', NULL)
                                   ->orderBy('tasks.id', 'desc')
                                   ->paginate('20');
                   } else {
          				$tasks = \Tritiyo\Task\Models\Task::where('task_assigned_to_head', 'Yes')
          											->where('site_head', auth()->user()->id)
          											->orderBy('task_for', 'desc')
          											->paginate(32);
          		   }
          		?>
                <?php //$tasks = \Tritiyo\Task\Models\Task::where('task_assigned_to_head', 'Yes')->where('user_id', auth()->user()->id)->orWhere('site_head', auth()->user()->id)->orderBy('task_for', 'desc')->paginate(32) ?>
                <?php //$tasks = \Tritiyo\Task\Models\Task::orderBy('task_for', 'desc')->where('site_head', auth()->user()->id)->where('task_assigned_to_head', 'Yes')->paginate('48') ?>

                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($task->user_id == auth()->user()->id || $task->site_head == auth()->user()->id): ?>
                        <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php /*
                @foreach($tasks as $task)
                        @include('task::tasklist.index_template')
                @endforeach
                */ ?>


            <?php elseif(auth()->user()->isApprover(auth()->user()->id)): ?>
          
                <?php
          				$tasks = \Tritiyo\Task\Models\Task::leftjoin('tasks_status', 'tasks_status.task_id', 'tasks.id')
                                                    ->leftjoin('tasks_requisition_bill', 'tasks_requisition_bill.task_id', 'tasks.id')
                                                    ->select('tasks.*', 'tasks_status.code')
                                                    ->where('tasks_status.code', 'proof_given')
                                                    ->where('tasks.task_assigned_to_head', 'Yes')
                                                    ->where('requisition_approved_by_cfo', NULL)
                                                    ->orderBy('tasks.id', 'desc')          											
                                                    ->paginate('48');
// dd($tasks);
                ?>
                <?php /* Ager Code = Something wrong has there
                @foreach($tasks->where('task_assigned_to_head', 'Yes') as $task)
                    <?php
                        $proof_check = \Tritiyo\Task\Models\TaskStatus::where('code', 'proof_given')->where('task_id', $task->id)->first();
                        $checkRequisitionApprovedByCFO = \Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $task->id)->first();
                    ?>
                    @if($proof_check != null && $proof_check->code)
                        @if(empty($checkRequisitionApprovedByCFO) || (!empty($checkRequisitionApprovedByCFO) && $checkRequisitionApprovedByCFO->requisition_approved_by_cfo == NULL))
                            @include('task::tasklist.index_template')
                        @endif
                    @endif
                @endforeach
                */?>

                <?php $__currentLoopData = $tasks->where('task_assigned_to_head', 'Yes'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php elseif(auth()->user()->isManager(auth()->user()->id)): ?>
          
                <?php
                    if(request()->get('bill') == 'pending'){
                       $tasks =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_manager', Null)
          							->where('tasks.user_id', auth()->user()->id)
                                   ->orderBy('tasks.id', 'desc');
          				if(request()->get('user')){
          							$tasks = $tasks->where('tasks.site_head', request()->get('user'));	
          					}
          				$tasks = $tasks->paginate('48');
                   } else {
                        $tasks = \Tritiyo\Task\Models\Task::orderBy('id', 'desc')->where('user_id', auth()->user()->id)->paginate('20');
                   }
                ?>
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
            <?php elseif(auth()->user()->isCFO(auth()->user()->id)): ?>

                <?php
                    if(request()->get('bill') == 'pending'){
                        $tasks =  \Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                        			->select('tasks.*', 'tasks_requisition_bill.task_id')
                                    ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                    ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                    ->where('tasks_requisition_bill.bill_approved_by_manager', 'Yes')
                                    ->where('tasks_requisition_bill.bill_approved_by_CFO', Null)
                                    ->orderBy('tasks.id', 'desc');
          					if(request()->get('user')){
          							$tasks = $tasks->where('tasks.site_head', request()->get('user'));	
          					}
          				$tasks = $tasks->paginate('48');
                    } else {
                        $tasks =  \Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                        			->select('tasks.*', 'tasks_requisition_bill.task_id')
                                    ->where('tasks_requisition_bill.requisition_submitted_by_manager', 'Yes')
                                    ->orderBy('tasks.id', 'desc')
                                    ->paginate('48');
                    }

                ?>

                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                
            <?php elseif(auth()->user()->isAccountant(auth()->user()->id)): ?>
                <?php
                    if(request()->get('bill') == 'pending'){
                       $tasks =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                   ->where('tasks_requisition_bill.requisition_approved_by_accountant', 'Yes')
                                   ->where('tasks_requisition_bill.bill_submitted_by_resource', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_manager', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_cfo', 'Yes')
                                   ->where('tasks_requisition_bill.bill_approved_by_accountant', Null)
                                   ->orderBy('tasks.id', 'desc');
          					if(request()->get('user')){
          							$tasks = $tasks->where('tasks.site_head', request()->get('user'));	
          					}
          				$tasks = $tasks->paginate('48');
                   } else {
                       $tasks =  Tritiyo\Task\Models\TaskRequisitionBill::leftJoin('tasks', 'tasks.id', '=', 'tasks_requisition_bill.task_id')
                                   ->where(function($query) {
                                       $query->where('tasks_requisition_bill.requisition_approved_by_cfo', 'Yes');
                                       $query->where('tasks_requisition_bill.bill_submitted_by_resource', NULL);
                                       $query->where('tasks_requisition_bill.bill_approved_by_manager', NULL);
                                       $query->where('tasks_requisition_bill.bill_approved_by_cfo', NULL);
                                       $query->where('tasks_requisition_bill.bill_approved_by_accountant', NULL);
                                   })
                                   ->orWhere(function($query) {
                                       $query->where('tasks_requisition_bill.bill_approved_by_cfo', 'Yes');
                                   })
                                   ->orderBy('tasks.id', 'desc')
                                   //->toSql();
                                   ->paginate('48');
                                   //dd($tasks);
                   }

                ?>

                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                

            <?php elseif(auth()->user()->isAdmin(auth()->user()->id)): ?>
                <?php $tasks = \Tritiyo\Task\Models\Task::orderBy('id', 'desc')->paginate('48') ?>
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('task::tasklist.index_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>


        </div>

        <div class="pagination_wrap pagination is-centered">
            <?php if(Request::get('key')): ?>
                <?php echo e($tasks->appends(['key' => Request::get('key')])->links('pagination::bootstrap-4')); ?>

          	 <?php elseif(Request::get('bill')): ?>
          		<?php if(Request::get('user')): ?>
            	<?php echo e($tasks->appends(['bill' => Request::get('bill'), 'user' => Request::get('user')])->links('pagination::bootstrap-4')); ?>

          		<?php else: ?>
                <?php echo e($tasks->appends(['bill' => Request::get('bill')])->links('pagination::bootstrap-4')); ?>

          		<?php endif; ?>
            <?php else: ?>
                <?php echo e($tasks->links('pagination::bootstrap-4')); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\task\src/views/index.blade.php ENDPATH**/ ?>