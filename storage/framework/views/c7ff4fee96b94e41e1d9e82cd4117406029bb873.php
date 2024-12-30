<?php $__env->startSection('title'); ?>
    Single Site
<?php $__env->stopSection(); ?>

<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('sites.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Single Site',
            'spSubTitle' => 'view a Site',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addUrl,
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spTitle' => 'Sites',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('sites.create'),
            'spAllData' => route('sites.index'),
            'spSearchData' => route('sites.search'),
            'spPlaceholder' => 'Search sites...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    
    
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Main Site Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-8 my-2">
                        <div class="columns">
                            <div class="column is-3">Site Code</div>
                            <div class="column is-1">:</div>
                            <div class="column"><?php echo e($site->site_code); ?></div>
                        </div>
                        <div class="columns">
                            <div class="column is-3">Project Name</div>
                            <div class="column is-1">:</div>
                            <div class="column">
                                <a href="<?php echo e(route('projects.show', $site->project_id)); ?>" target="_blank">
                                    <?php echo e(\Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()->name); ?>

                                </a>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-3">Location</div>
                            <div class="column is-1">:</div>
                            <div class="column"><?php echo e($site->location); ?></div>
                        </div>

                        <div class="columns">
                            <div class="column is-3">Status</div>
                            <div class="column is-1">:</div>
                            <div class="column"><?php echo e($site->completion_status); ?></div>
                        </div>

                        
                        
                        
                        
                        
                        
                        
                        
                    </div>

                    <div class="column">
                        <?php if($site->completion_status == 'Completed'): ?>
                            <button class="button is-small is-success is-rounded">Completed</button>
                        <?php elseif($site->completion_status == 'Rejected'): ?>
                            <button class="button is-small is-danger is-rounded">Rejected</button>
                        <?php else: ?>
                            <?php
                                $getSiteTask = \Tritiyo\Task\Models\TaskSite::where('site_id', $site->id)->get();
                            ?>
                            <?php if(count($getSiteTask) > 0): ?>
                                <p>Site status</p>
                                <form action="<?php echo e(route('site.status.update')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="show_page_single_site_id" value="<?php echo e($site->id); ?>"/>
                                    <select name="show_page_completion_status" id="show_page_completion_status"
                                            class="input is-small">
                                        <option value="">Select</option>
                                        <option
                                            value="Rejected" <?php echo e($site->completion_status == 'Rejected' ? 'selected' : ''); ?>>
                                            Rejected
                                        </option>
                                        <option
                                            value="Completed" <?php echo e($site->completion_status == 'Completed' ? 'selected' : ''); ?>>
                                            Completed
                                        </option>
                                        <option
                                            value="Pending" <?php echo e($site->completion_status == 'Pending' ? 'selected' : ''); ?>>
                                            Pending
                                        </option>
                                    </select>
                                    <div class="control mt-2" id="show_note"
                                         style="display: <?php echo e($site->completion_status == 'Pending' ? 'block' : 'none'); ?>">
                                        <p>Note</p>
                                        <textarea name="show_page_pending_note" id="show_page_pending_note"
                                                  class="textarea is-small" id="" cols="30"
                                                  rows="2"><?php echo e($site->pending_note); ?></textarea>
                                    </div>
                                    <button type="submit" class="button is-small is-link mt-2">Submit</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php echo $__env->make('site::excel_with_show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php
        $moves = \Tritiyo\Task\Models\TaskSite::where('site_id', $site->id)->groupBy('task_id')->get();
    ?>
    <?php if($moves->count() > 0): ?>
        <div class="card tile is-child" style="margin-top: 15px !important;">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                    Movement history
                </p>
            </header>
            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <tr>
                            <th title="Task date" width="15%">Task Name</th>
                            <th title="Task date" width="8%">Task date</th>
                            <th title="Task head">Site Head</th>
                            <th title="Task description" width="30%">Task Description</th>
                            <th title="Resources used">Resources used</th>
                            <th title="Requision Approved by Accountant">Approved Req.</th>
                            <th title="Bill Prepared by Resource">Submitted Bill</th>
                              <th title="Bill Approved  by Resource">Approved Bill</th>
                            <th title="Requisition - Bill">Outcome</th>
                        </tr>
                        <?php
                            $in_total = [];
                            $mApproveReq = [];
                            $mSubmitBill = [];
                            $mApproveBill = [];
                        ?>

                        <?php $__currentLoopData = $moves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $move): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td title="Task ID">
                                    <a href="<?php echo e(route('tasks.show', $move->task_id)); ?>" target="_blank">
                                        <?php echo e(\Tritiyo\Task\Models\Task::where('id', $move->task_id)->first()->task_name); ?>

                                    </a>
                                </td>
                                <td title="Task date">
                                    <?php echo e(\Tritiyo\Task\Models\Task::where('id', $move->task_id)->first()->task_for); ?>

                                </td>
                                <td title="Task head">
                                    <?php echo e(\App\Models\User::where('id', \Tritiyo\Task\Models\Task::where('id', $move->task_id)->first()->site_head)->first()->name); ?>

                                    
                                </td>
                                <td title="Task description">
                                    <?php echo e(\Tritiyo\Task\Models\Task::where('id', $move->task_id)->first()->task_details); ?>

                                </td>
                                <td title="Resource Used">
                                    <?php
                                        $rids = \DB::select('SELECT GROUP_CONCAT(resource_id) AS rids FROM `tasks_site` WHERE site_id = '. $move->site_id .' AND task_id = '. $move->task_id .' GROUP BY site_id');
                                        $resources = explode(',', $rids[0]->rids);
                                    ?>
                                    <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(\App\Models\User::where('id', $r)->first()->name); ?><br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <?php
                                    # SELECT COUNT(site_id) AS total
                                    # FROM `tasks_site`
                                    # WHERE task_id = 16
                                    # AND site_id = 24
                                    # GROUP BY task_id, site_id

                                    $count_of_sites_of_this_tasks = \DB::select('SELECT COUNT(site_id) AS total FROM `tasks_site` WHERE task_id = '. $move->task_id .' AND site_id = '. $move->site_id .' GROUP BY task_id, site_id');
                                    $count = (int)$count_of_sites_of_this_tasks[0]->total;
                                    //dump($count_of_sites_of_this_tasks[0]->total)
                                ?>
                                
                                <td title="Requision edited by Accountant">
                                    <?php
                                    $requisition = \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('reba_amount' ,$move->task_id);
                                    $mApproveReq [] = $requisition;
                                    echo 'BDT. ' . $requisition;
                                    
                                    ?>
                                     
                                </td>
                                <td title="Bill Prepared by Resource">
                                     <?php
                                              $submitbill =  \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('bpbr_amount' ,$move->task_id);
                                              $mSubmitBill []= $submitbill;
                                              echo 'BDT. ' . $submitbill;
                                        ?>
                                    

                                </td>
                                
                                <td title="Bill Approved  by Accountant">
                                           BDT. <?php echo e($mApproveBill []=  \Tritiyo\Task\Helpers\SiteHeadTotal::totalAmountRequisionBill('beba_amount' ,$move->task_id)); ?> 
                                </td>
                                
                                
                                <td>
                                    <?php
                                   // $accountant_approved_requisition_d = new Tritiyo\Task\Helpers\SiteHeadTotal('requisition_edited_by_accountant', $move->task_id);
                                    //$bill_prepared_by_resource = new Tritiyo\Task\Helpers\SiteHeadTotal('bill_prepared_by_resource', $move->task_id);

                                    echo 'BDT. ' . $in_total[] = ($requisition - $submitbill);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td colspan="5">
                                In Total for this site
                            </td>
                            <td>
                                <?php echo e('BDT. ' . array_sum($mApproveReq)); ?>

                            </td>
                             <td>
                                <?php echo e('BDT. ' . array_sum($mSubmitBill)); ?>

                            </td>
                            <td>
                                <?php echo e('BDT. ' . array_sum($mApproveBill)); ?>

                            </td>
                            <td>
                                <?php echo e('BDT. ' . array_sum($in_total)); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
        #$vehicle_used = \Tritiyo\Task\Models\TaskVehicle::where('site_id', $site->id)->get();
        $vehicle_used = \DB::select('SELECT task_id, (SELECT GROUP_CONCAT(vehicle_id) FROM tasks_vehicle WHERE tasks_vehicle.task_id = tasks_for_this_site.task_id) AS vehiclesss
                                    FROM (SELECT task_id FROM `tasks_site` WHERE site_id = '. $site->id .' GROUP BY task_id) AS tasks_for_this_site');
        //dd($vehicle_used);
    ?>
    <?php if(!empty($vehicle_used) && $vehicle_used[0]->vehiclesss != null): ?>
        <div class="card tile is-child" style="margin-top: 15px !important;">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                    Vehicle Used
                </p>
            </header>
            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <tr>
                            <th title="Task name" width="15%">Task Name</th>
                            <th title="Task date" width="8%">Task date</th>
                            <th title="Task Vehicle Name">Vehicle Name</th>
                            
                        </tr>
                        <?php $__currentLoopData = $vehicle_used; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td title="Task ID">
                                    <a href="<?php echo e(route('tasks.show', $vehicle->task_id)); ?>" target="_blank">
                                        <?php echo e(\Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->task_name); ?>

                                    </a>
                                </td>
                                <td title="Task date">
                                    <?php echo e(\Tritiyo\Task\Models\Task::where('id', $vehicle->task_id)->first()->task_for); ?>

                                </td>
                                <td title="Task Vehicle Name">
                                    <?php
                                        $vehicles = explode(',', $vehicle->vehiclesss)
                                    ?>
                                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(!empty($v) ? \Tritiyo\Vehicle\Models\Vehicle::where('id', $v)->first()->name : ''); ?>

                                        <br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
        $material_used = \DB::select('SELECT task_id, (SELECT GROUP_CONCAT(material_id) FROM tasks_material WHERE tasks_material.task_id = tasks_for_this_site.task_id) AS materialsss
                        FROM (SELECT task_id FROM `tasks_site` WHERE site_id = '. $site->id .' GROUP BY task_id) AS tasks_for_this_site');
    	//dd($material_used);
    ?>
    <?php if(!empty($material_used) && $material_used[0]->materialsss  != null): ?>
        <div class="card tile is-child" style="margin-top: 15px !important;">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-tasks default"></i></span>
                    Material Used
                </p>
            </header>
            <div class="card-content">
                <div class="card-data">
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                        <tr>
                            <th title="Task date" width="15%">Task Name</th>
                            <th title="Task date" width="8%">Task date</th>
                            <th title="Task Material Name">Material Name</th>
                            
                            
                        </tr>
                        <?php $__currentLoopData = $material_used; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td title="Task ID">
                                    <a href="<?php echo e(route('tasks.show', $material->task_id)); ?>" target="_blank">
                                        <?php echo e(\Tritiyo\Task\Models\Task::where('id', $material->task_id)->first()->task_name); ?>

                                    </a>
                                </td>
                                <td title="Task date">
                                    <?php echo e(\Tritiyo\Task\Models\Task::where('id', $material->task_id)->first()->task_for); ?>

                                </td>
                                <td title="Task Material Name">
                                    <?php
                                        $materialsss = explode(',', $material->materialsss)
                                    ?>
                                    <?php $__currentLoopData = $materialsss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(!empty($m) ? \Tritiyo\Material\Models\Material::where('id', $m)->first()->name : ''); ?>

                                        <br/>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </td>
                                
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Purchase -->
    <?php
    $gettaskID = Tritiyo\Task\Models\TaskSite::where('site_id', $site->id)->groupBy('task_id')->get();
    ?>

    <div class="card tile is-child" style="margin-top: 15px !important;">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Purchase
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <?php $__currentLoopData = $gettaskID; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $taskId = $t->task_id;
                        $obr = new Tritiyo\Task\Helpers\RequisitionData('requisition_edited_by_accountant', $taskId);
                        $purchases = $obr->getPurchaseData();
                    ?>
                    <?php if(!empty($purchases)): ?>
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th title="Task name" width="15%">Task Name</th>
                                <th title="Task date" width="8%">Task Name</th>
                                <th title="PA Note">Purchase Note</th>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('tasks.show', $taskId)); ?>" target="_blank">
                                        <?php echo e(\Tritiyo\Task\Models\Task::where('id', $taskId)->first()->task_name); ?>

                                    </a>
                                </td>
                                <td><?php echo e(\Tritiyo\Task\Models\Task::where('id', $taskId)->first()->task_for); ?></td>
                                <td>
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($purchase->pa_note); ?>

                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>



    <!-- Transport -->

    <div class="card tile is-child" style="margin-top: 15px !important;">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Transport
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <?php $__currentLoopData = $gettaskID; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $taskId = $t->task_id;
                        $obr = new Tritiyo\Task\Helpers\RequisitionData('requisition_edited_by_accountant', $taskId);
                        $transports = $obr->getTransportData();
                    ?>
                    <?php if(!empty($transports)): ?>
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                            <tr>
                                <th title="Task name" width="15%">Task Name</th>
                                <th title="Task date" width="8%">Task Name</th>
                                <th title="PA Note">Transport Information</th>
                            </tr>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('tasks.show', $taskId)); ?>" target="_blank">
                                        <?php echo e(\Tritiyo\Task\Models\Task::where('id', $taskId)->first()->task_name); ?>

                                    </a>
                                </td>
                                <td><?php echo e(\Tritiyo\Task\Models\Task::where('id', $taskId)->first()->task_for); ?></td>
                                <td>
                                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                        <tr>
                                            <td title="Task name" width="25%">Where To Where
                                            </th>
                                            <td title="Task date" width="15%">Transport Type
                                            </th>
                                            <td title="PA Note">Transport Note
                                            </th>
                                        </tr>
                                        <?php $__currentLoopData = $transports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($transport->where_to_where); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($transport->transport_type); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($transport->ta_note); ?>

                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>
<?php if( auth()->user()->isAccountant(auth()->user()->id) || auth()->user()->isManager(auth()->user()->id) ): ?>
<?php $__env->startSection('column_right'); ?>
    	<?php echo $__env->make('site::invoice_status_update', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php endif; ?>
<?php $__env->startSection('cus_js'); ?>
	<!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>



	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script>
      jQuery.browser = {
          msie: false,
          version: 0
      };
      </script>
	<script type="text/javascript">
          $('select#project_select').change(function(){
                  let project_id = $(this).find(':selected').val();

                      $.ajax({
                            method: 'GET',
                            url   : "<?php echo e(route('project.based.range', ['', ''])); ?>/"+ project_id,
                            success : function (data) {
                              //console.log(data);
                              let siteList = {};
                              //siteList += '<option></option>';
                              for(let i = 0; i < data.length; i++) {
                                let end_date = null;
                                if(data[i].end_date == null) {
                                  end_date = '<?php echo date('Y-m-d'); ?>';
                                } else {
                                  end_date = data[i].end_date;
                                }
                                siteList += '<option value="'+data[i].status_key+'">'+ data[i].start_date + ' - ' + end_date +'</option>';
                                //console.log(data[i].site_code)
                          }
                          $('#range_select').empty().append(siteList);
                        }
                  });          		
          });
      
      		$(function() {
                //$("#datepicker").datepicker({minDate: -20, maxDate: "+1M +15D", dateFormat: 'yy-mm-dd'});        
              	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});        
            });
	</script>


    <script>
        /**
        $(function () {
            $("#datepicker").datepicker({minDate: -20, maxDate: "+1M +15D", dateFormat: 'yy-mm-dd'});
        });

        const btn = document.querySelector('select#show_page_completion_status');
        btn.onchange = function () {
            if (btn.value == 'Pending') {
                document.querySelector('#show_note').setAttribute('style', 'display:block')
            } else {
                document.querySelector('#show_note').setAttribute('style', 'display:none')
                document.querySelector('#show_page_pending_note').value = null;
            }
        }
        	**/
    </script>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>


    <script type="text/javascript">
        document.getElementById('textboxID').select();
    </script>

    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/show.blade.php ENDPATH**/ ?>