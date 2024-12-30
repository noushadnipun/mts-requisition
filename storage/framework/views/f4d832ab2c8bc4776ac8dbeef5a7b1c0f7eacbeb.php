<?php $__env->startSection('column_left'); ?>
    <?php
    $today = date('Y-m-d');
    if (request()->get('daterange')) {
        $dates = explode(' - ', request()->get('daterange'));
        $startdate = $dates[0];
        $enddate = $dates[1];
        //dd($dates[0]);
        $resourceUsedArchive = DB::select("
                          SELECT * FROM (
                              SELECT resource_id, used FROM (
                                  SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE (task_for BETWEEN'$startdate' AND '$enddate' ) AND resource_id IS NOT NULL GROUP BY resource_id
                                  UNION
                                  SELECT id, site_head, 'Used' AS used FROM `tasks`  where (task_for BETWEEN'$startdate' AND '$enddate' )  AND site_head IS NOT NULL
                              ) AS mm WHERE mm.resource_id IS NOT NULL
                              UNION
                                  SELECT id AS resource_id, NULL AS used   FROM users WHERE users.role = 2
                          ) AS www GROUP BY www.resource_id
          ");
    } else {
        $startdate = \Carbon\Carbon::now()->subMonth(1)->format('Y-m-d');
        $enddate = date('Y-m-d');
        $resourceUsedArchive = DB::select("
                          SELECT * FROM (
                              SELECT resource_id, used FROM (
                                  SELECT task_id, resource_id, 'Used' AS used FROM `tasks_site`  WHERE (task_for BETWEEN'$startdate' AND '$enddate' ) AND resource_id IS NOT NULL GROUP BY resource_id
                                  UNION
                                  SELECT id, site_head, 'Used' AS used FROM `tasks`  where (task_for BETWEEN'$startdate' AND '$enddate' )  AND site_head IS NOT NULL
                              ) AS mm WHERE mm.resource_id IS NOT NULL
                              UNION
                                  SELECT id AS resource_id, NULL AS used   FROM users WHERE users.role = 2
                          ) AS www GROUP BY www.resource_id
          ");
    }

    $nonUsed = [];
    $used = [];
    foreach ($resourceUsedArchive as $data) {
        //dump($data->resource_id);
        if (!empty($data->resource_id) && $data->used == NULL) {
			/**
            $countSiteHead = \Tritiyo\Task\Models\Task::where('site_head', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->groupBy('task_for')->get();
            $countResource = \Tritiyo\Task\Models\TaskSite::where('resource_id', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->where('task_for', '!=', NULL)->groupBy('task_for')->get();

            $nonUsed[] = [
                'id' => $data->resource_id,
                'designation' => \App\Models\User::where('id', $data->resource_id)->first()->designation ?? NULL,
                'designationName' => DB::table('designations')->where('id', \App\Models\User::where('id', $data->resource_id)->first()->designation)->first()->name ?? NULL,
                'name' => \App\Models\User::where('id', $data->resource_id)->first()->name ?? NULL,
                'department' => \App\Models\User::where('id', $data->resource_id)->first()->department ?? NULL,
                'join_date' => \App\Models\User::where('id', $data->resource_id)->first()->join_date ?? NULL,
                'count' => count($countSiteHead) + count($countResource) ?? NULL,
                'siteHead' => count($countSiteHead) ?? NULL,
                'Resource' => count($countResource) ?? NULL,
            ];
            **/
        } else {

            //dd($startdate);

            $countSiteHead = \Tritiyo\Task\Models\Task::where('site_head', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->groupBy('task_for')->get();
            $countResource = \Tritiyo\Task\Models\TaskSite::where('resource_id', $data->resource_id)->whereBetween('task_for', array($startdate, $enddate))->where('task_for', '!=', NULL)->groupBy('task_for')->get();
            $used[] = [
                'id' => $data->resource_id,
                'designation' => \App\Models\User::where('id', $data->resource_id)->first()->designation ?? NULL,
                'designationName' => DB::table('designations')->where('id', \App\Models\User::where('id', $data->resource_id)->first()->designation)->first()->name ?? NULL,
                'name' => \App\Models\User::where('id', $data->resource_id)->first()->name ?? NULL,
                'department' => \App\Models\User::where('id', $data->resource_id)->first()->department ?? NULL,
                'join_date' => \App\Models\User::where('id', $data->resource_id)->first()->join_date ?? NULL,
                'count' => count($countSiteHead) + count($countResource) ?? NULL,
                'siteHead' => count($countSiteHead) ?? NULL,
                'Resource' => count($countResource) ?? NULL,
            ];
        }
    }


    ?>
    <div class="columns is-vcentered pt-2">
        <div class="column is-10 mx-auto">

            <div class="card tile is-child xquick_view">
                <div class="card-content">
                    <div class="column is-12 mb-4">
                        <form method="get" action="<?php echo e(route('archive.resource.transaction')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="field has-addons">
                                <a href="<?php echo e(route('archive.resource.transaction.excel')); ?>?daterange=<?php echo e(request()->get('daterange') ?? NULL); ?>"
                                   class="button is-primary is-small mr-2">
                                    Download as excel
                                </a>
                                <div class="control">
                                    <input class="input is-small" type="text" name="daterange" id="textboxID"
                                           value="<?php echo e(request()->get('daterange') ?? null); ?>">
                                </div>
                                <div class="control">
                                    <input name="search" type="submit"
                                           class="button is-small is-primary has-background-primary-dark"
                                           value="Search"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-data">
                        <div class="columns">

                            <div class="column is-12 mx-auto">
                                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                    <tr>
                                        <th colspan="8">Used</th>
                                    </tr>
                                    <tr>
                                        <th class="has-background-primary-dark" style="width: 100px;">Name</th>
                                        <th class="has-background-primary-dark" style="width: 30px;">Designation</th>
                                        <th class="has-background-primary-dark" style="width: 30px;">Department</th>                                        
                                        <th class="has-background-primary-dark" style="width: 30px;">
                                            Approved Requisition
                                        </th>
                                        
                                        <th class="has-background-primary-dark" style="width: 30px;">
                                            Submit Bill
                                        </th>
                                        <th class="has-background-primary-dark" style="width: 30px;">
                                            Approved Bill by CFO
                                        </th>
                                        <th class="has-background-primary-dark" style="width: 30px;">
                                            Approved Bill
                                        </th>
                                        <th class="has-background-primary-dark" style="width: 30px;" title="Approved Requsition Total By Accountant - Approved Bill Total By Accountant">
                                            Balance <br/>(Req. Acc. - Bill Acc.)
                                        </th>
                                    </tr>
                                    <?php
                                    usort($used, function ($a, $b) {
                                        return $a['designationName'] <=> $b['designationName'];
                                    });
                                    $accountant_approve_requ_sum = [];
                                    $resource_submit_bill_sum = [];
                                  	$bill_edited_by_cfo_sum = [];
                                  	$bill_edited_by_accountant_sum = [];
                                  	$total_sum = [];
                                    ?>
                                    <?php $__currentLoopData = $used; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  		<?php if($data['siteHead'] != 0): ?>
                                  
                                  
                                  <?php
                                  $reba_amount = \Tritiyo\Task\Helpers\SiteHeadTotal::ttrbSiteHeadArchiveTransaction('reba_amount',  $data['id'], $startdate, $enddate);
                                  $beba_amount = \Tritiyo\Task\Helpers\SiteHeadTotal::ttrbSiteHeadArchiveTransaction('beba_amount',  $data['id'], $startdate, $enddate);
                                  ?>
                                                  <tr>
                                                    <td>
                                                        <a target="_blank" href="<?php echo e(route('hidtory.user', $data['id'])); ?>">
                                                          <?php echo e($data['name']); ?>

                                                      </a>
                                                    </td>
                                                    <td>
                                                        <?php echo e($data['designationName'] ?? NULL); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($data['department'] ?? NULL); ?>

                                                    </td>
                                                    <td>                                                      	
                                                        BDT. <?php echo e($accountant_approve_requ_sum[] = $reba_amount); ?>

                                                    </td>
                                                    <td>
                                                        BDT. <?php echo e($resource_submit_bill_sum[] =  \Tritiyo\Task\Helpers\SiteHeadTotal::ttrbSiteHeadArchiveTransaction('bpbr_amount',  $data['id'], $startdate, $enddate)); ?>

                                                    </td>
                                                    <td>
                                                      	BDT. <?php echo e($bill_edited_by_cfo_sum[] =  \Tritiyo\Task\Helpers\SiteHeadTotal::ttrbSiteHeadArchiveTransaction('bebc_amount',  $data['id'], $startdate, $enddate)); ?>

                                                    </td>
                                                    <td>
                                                    	BDT. <?php echo e($bill_edited_by_accountant_sum[] = $beba_amount); ?>

                                                    </td>
                                                    <td>
                                                      	BDT. <?php echo e($total_sum[] = $reba_amount - $beba_amount); ?>

                                                    </td>
                                                  </tr>

                                  
                                  
                                  
                                        
                                  		<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td>BDT. <?php echo e(array_sum($accountant_approve_requ_sum)); ?></td>
                                        <td>BDT. <?php echo e(array_sum($resource_submit_bill_sum)); ?></td>
                                        <td>BDT. <?php echo e(array_sum($bill_edited_by_cfo_sum)); ?></td>
                                        <td>BDT. <?php echo e(array_sum($bill_edited_by_accountant_sum)); ?></td>
                                        <td>BDT. <?php echo e(array_sum($total_sum)); ?></td>
                                    </tr>
                                           

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('cusjs'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/archive_resource_transaction.blade.php ENDPATH**/ ?>