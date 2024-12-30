<?php $__env->startSection('title'); ?>
    Add Mobile Bill
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_left'); ?>

    <?php
    if(request()->get('manager')){
        $dates = explode(' - ', request()->get('daterange'));
        $start = $dates[0];
        $end = $dates[1];
        $bills = \Tritiyo\Project\Models\MobileBill::orderBy('id', "DESC")->where('manager_id', request()->get('manager'))->whereBetween('received_date', [$start, $end])->paginate('50');
    } elseif(request()->get('daterange')){
        $dates = explode(' - ', request()->get('daterange'));
        $start = $dates[0];
        $end = $dates[1];
        $bills = \Tritiyo\Project\Models\MobileBill::orderBy('id', "DESC")->whereBetween('received_date', [$start, $end])->paginate('50');
    } else {
        $bills = \Tritiyo\Project\Models\MobileBill::orderBy('id', "DESC")->paginate('50');
    }
    ?>

    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Add Mobile Bill</a>
        </p>
        <div class="customContainer">
            <form action="<?php echo e(route('projects.add.mobile.bill.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div id="mobile_bill_form">
                  <div class="columns" id="default_load">
                        <div class="column is-1">
                            <label></label> <br />
                            <a>  
                                <span style="cursor: pointer;" class="tag is-success" id="addrow">Add More &nbsp;</span>
                            </a>
                        </div>
                  </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field is-grouped">
                            <div class="control">
                                <button id="task_create_btn" class="button is-success is-small">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="m-3">
            <div class="level">
                <div class="level-left">
                    <strong>Mobile Bill List</strong>
                </div>
                <div class="level-right">
                    <div class="level-item ">

                        <form method="get" action="<?php echo e(route('projects.add.mobile.bill')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="field has-addons">
                                <a href="<?php echo e(route('download_excel_mobile_bill')); ?>?manager=<?php echo e(request()->get('manager')); ?>&daterange=<?php echo e(request()->get('daterange') ??  date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days')) . ' - ' . date('Y-m-d')); ?>"
                                   class="button is-primary is-small">
                                    Download as excel
                                </a>
                                <div class="control mx-2">
                                    <?php $managers = \App\Models\User::where('role', '3')->where('employee_status', 'Enroll')->get(); ?>
                                    <select id="manager_search" class="input" name="manager">
                                        <option></option>
                                        <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($manager->id); ?>" <?php echo e($manager->id == request()->get('manager') ? 'selected' : NULL); ?>><?php echo e($manager->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="control">
                                    <input class="input is-small" type="text" name="daterange" id="textboxID" autocomplete="off"
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
                </div>
            </div>

            <table class="bw_table">
            <tr>
                <th>Manager Name</th>
               	<th>Project Name</th>
                <th>Mobile Number</th>
                <th>Recieved Amount</th>
                <th>Recieved Date</th>
            </tr>
            <?php $totalBill = []; ?>
            <?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(\App\Models\User::where('id', $bill->manager_id)->first()->name); ?></td>
                   <td><?php echo e(\Tritiyo\Project\Models\Project::where('id', $bill->project_id)->first()->name); ?></td>
                    <td><?php echo e($bill->mobile_number); ?></td>
                    <td><?php echo e($totalBill []=$bill->received_amount); ?></td>
                    <td><?php echo e($bill->received_date); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="2"></td>
                <td>Total: <?php echo e(array_sum($totalBill)); ?></td>
                <td></td>
            </tr>
        </table>
        </div>

        <div class="pagination_wrap pagination">

            <?php if(Request::get('key')): ?>
                <?php echo e($bills->appends(['key' => Request::get('key')])->links('pagination::bootstrap-4')); ?>

            <?php else: ?>
                <?php echo e($bills->links('pagination::bootstrap-4')); ?>

            <?php endif; ?>
        </div>
        </div>
    </article>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('column_right'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('cus_js'); ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#textboxID").datepicker({minDate: -20, maxDate: "+1M +15D", dateFormat: 'yy-mm-dd'});
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


    </script>
    <script>
        $('#manager_select').select2({
            placeholder: "Select Head of Site",
            // /allowClear: true
        });
        $('#manager_search').select2({
            placeholder: "Select Head of Site",
            // /allowClear: true
        });
    </script>
    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
            text-align: center;
        }
    </style>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
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





<script type="text/template" data-template="mobile_bill_form">

    
        
        
        <div class="column is-3">
            <div class="field">
                <?php echo e(Form::label('project', 'Project', array('class' => 'label'))); ?>

                <div class="control">
                    <?php  $projects = \Tritiyo\Project\Models\Project::get();?>
                    <select name="project_id[]" id="" class="input is-small">
                        <option value="" selected disabled>Select one</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $check = DB::table('project_ranges')->where('project_id', $project->id)
                                        ->orderBy('id', 'desc')
                                        ->first();
                        ?>
                        <?php if(!empty($check) && $check->project_status == 'Inactive'): ?>
                        <?php else: ?>
                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="column is-3">
            <div class="field">
                <?php echo e(Form::label('mobile_number', 'Mobile Number', array('class' => 'label'))); ?>

                <div class="control">
                    <input type="text" name="mobile_number[]" value="" class="input is-small" required>
                </div>
            </div>
        </div>

        <div class="column is-3">
            <div class="field">
                <?php echo e(Form::label('received_amount', 'Amount', array('class' => 'label'))); ?>

                <div class="control">
                    <input type="text" name="received_amount[]" value="" class="input is-small" required>
                </div>
            </div>
        </div>

</script>







    <script>
        //Breakdown
            var HTML = $('script[data-template="mobile_bill_form"]').html();
            $("div#default_load").prepend(HTML); 
            $("#addrow").on("click", function() {
                fieldHTML = '<div class="columns">'
                fieldHTML += $('script[data-template="mobile_bill_form"]').html();
                fieldHTML += '<div class="column is-1">\
                                <label></label> <br />\
                                <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>\
                                </div>';
                fieldHTML += '</div>';
                $("div#mobile_bill_form").append(fieldHTML);
                counter++;
            });

            $("div#mobile_bill_form").on("click", ".ibtnDel", function(event) {
                $(this).closest("div.columns").remove();
                counter -= 1
            });




    </script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/project/src/views/add_mobile_bill.blade.php ENDPATH**/ ?>