<?php $__env->startSection('title'); ?>
    Include vehicle information of task
<?php $__env->stopSection(); ?>

<?php
$task_id = request()->get('task_id');
$task = \Tritiyo\Task\Models\Task::where('id', $task_id)->first();


?>

<?php
    $remaining_balance = \Tritiyo\Project\Helpers\ProjectHelper::remainingBalance($task->project_id, $task->current_range_id);
    $today_use = \Tritiyo\Task\Helpers\RequisitionData::todayManagerUsedAmount($task->project_id, $task->current_range_id);
    $of95 = $remaining_balance - $today_use;
?>

<div style="display: none;">
    <input type="text" value="<?php echo e($of95); ?>" id="of95" />
</div>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
        'spTitle' => 'Vehicle',
        'spSubTitle' => 'Add a vehicle of task',
        'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
        'spShowButtonSet' => true,
        'spAddUrl' => null,
        'spAddUrl' => route('tasks.create'),
        'spAllData' => route('tasks.index'),
        'spSearchData' => route('tasks.search'),
        'spTitle' => 'Tasks',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
        'spShowFilterSet' => true,
        'spPlaceholder' => 'Search tasks...',
        'spMessage' => $message = $message ?? NULl,
        'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary" id="app">
        <a style="float: right; display: block">
            <span style="cursor: pointer;" class="tag is-success" id="addrow">Add Breakdown &nbsp; <strong>+</strong></span>
        </a>
        <?php echo $__env->make('task::layouts.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="customContainer">
            <?php if (!empty($task_id) && $task_id) {
                $routeUrl = route('taskvehicle.update', $task_id);
                $method = 'PUT';
            } else {
                $routeUrl = route('taskvehicle.store');
                $method = 'post';
            } ?>

            <?php echo e(Form::open(['url' => $routeUrl, 'method' => $method, 'value' => 'PATCH', 'id' => 'add_route', 'class' => 'task_vehicle_table', 'files' => true, 'autocomplete' => 'off'])); ?>


            <?php if($task_id): ?>
                <?php echo e(Form::hidden('task_id', $task_id ?? '')); ?>

            <?php endif; ?>
            <?php if(!empty($taskId)): ?>
                <?php echo e(Form::hidden('tassk_id', $taskId ?? '')); ?>

            <?php endif; ?>

            <?php
                $vehicles = \Tritiyo\Vehicle\Models\Vehicle::get();
                $getTaskVehicle = \Tritiyo\Task\Models\TaskVehicle::where('task_id', $task_id)->get();
            ?>
            <div id="myTable">
                <?php if(count($getTaskVehicle) > 0): ?>
                    <?php $__currentLoopData = $getTaskVehicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $veh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="columns s<?php echo e($veh->id); ?>">
                            <div class="column is-2">
                                <div class="field">
                                    <?php echo e(Form::label('vehicle_id', 'Vehicle', ['class' => 'label'])); ?>

                                    <div class="control">
                                        <select name="vehicle_id[]" id="vehicle_select" class="input is-small" required>
                                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vehicle->id); ?>"
                                                    <?php echo e($veh->vehicle_id == $vehicle->id ? 'selected' : ''); ?>>
                                                    <?php echo e($vehicle->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="column is-2">
                                <?php echo e(Form::label('vehicle_rent', 'Vehicle Rent', ['class' => 'label'])); ?>

                                <?php echo e(Form::number('vehicle_rent[]', $veh->vehicle_rent, ['class' => 'input is-small xvehicle_rent_id'])); ?>

                            </div>
                            <div class="column is-6">
                                <?php echo e(Form::label('vehicle_note', 'Note', ['class' => 'label'])); ?>

                                <?php echo e(Form::text('vehicle_note[]', $veh->vehicle_note, ['class' => 'input is-small'])); ?>

                            </div>
                            <div class="column is-1">
                                <label></label> <br />
                                <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>
                            </div>

                        </div>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    
                    <div class="columns">
                        <div class="column is-2">
                            <label for="vehicle_id" class="label">Vehicle</label>
                            <select name="vehicle_id[]" id="vehicle_select" class="input is-small" required>
                                <option></option>
                                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="column is-2">
                            <label for="vehicle_rent" class="label">Vehicle Rent</label>
                            <input name="vehicle_rent[]" type="number" value="" class="input is-small vehicle_rent_id"
                                required>
                        </div>
                        <div class="column is-6">
                            <label for="vehicle_note" class="label">Note</label>
                            <input name="vehicle_note[]" type="text" value="" class="input is-small" required>
                        </div>
                        <div class="column is-1">
                            <label></label> <br />
                            <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>
                        </div>
                    </div>

                <?php endif; ?>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small" id="save_changes">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>

    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <?php echo $__env->make('task::task_status_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('cusjs'); ?>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        //Add Row Function
        $(document).ready(function() {
            var counter = 1;

            $("#addrow").on("click", function() {
                var cols = '<div class="columns r' + counter + '">';
                cols += '<div class="column is-2">';
                cols += '<label for="vehicle_id" class="label">Vehicle</label>';
                cols += '<select name="vehicle_id[]" id="vehicle_select" class="input" required>';
                cols += '<option></option>';
                cols += '<?php foreach($vehicles as $vehicle){?>';
                cols += '<option value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->name; ?></option>';
                cols += '<?php } ?>';
                cols += '<select>';
                cols += '</div>';
                cols += '<div class="column is-2">';
                cols += '<label for="vehicle_rent" class="label">Vehicle Rent</label>';
                cols +=
                    '<input name="vehicle_rent[]" type="number" value="" class="input is-small vehicle_rent_id" required>';
                cols += '</div>';
                cols += '<div class="column is-6">';
                cols += '<label for="vehicle_note" class="label">Note</label>';
                cols +=
                '<input name="vehicle_note[]" type="text" value="" class="input is-small" required>';
                cols += '</div>';
                cols += '<div class="column is-1">';
                cols += '<br/><a><span class="tag is-danger is-small ibtnDel">Delete</span></a>';
                cols += '</div>';
                cols += '</div>';
                $("div#myTable").append(cols);
                vehicleSelectRefresh();
                counter++;
            });


            $("div#myTable").on("click", ".ibtnDel", function(event) {
                $(this).closest("div.columns").remove();
                counter -= 1
            });
         
            $(document).on("change", "input", function() {
                var of95 = parseInt($('#of95').val());

                var sum = 0;
                $(".vehicle_rent_id").each(function() {
                    sum += +$(this).val();
                });


                var summation = parseInt(sum);
                //var live_usages_total = summation + actual_usage;
                var live_usages_total = summation;
                if (live_usages_total > of95) {
                    $('#save_changes').hide();
                    alert(
                        'Your entered amount exceeding 100% of your current budget. Please enter lower amount to proceed.');
                } else {
                    $('#save_changes').show();
                }
            });

        });
    </script>


    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        //Select 2
        function vehicleSelectRefresh() {
            $('select#vehicle_select').select2({
                placeholder: "Select vehicle",
                allowClear: true,
            });
        }
        vehicleSelectRefresh();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskvehicle/create.blade.php ENDPATH**/ ?>