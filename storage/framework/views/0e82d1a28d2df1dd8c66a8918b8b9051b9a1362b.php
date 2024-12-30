<?php
    $vehicles = \Tritiyo\Vehicle\Models\Vehicle::get();
?>
<fieldset class="pb-5">
    <div class="mb-3">
        <label>Vehicle Information</label>
        <?php if(isset($task_vehicle) && !empty($task_vehicle)): ?>
            <a style="float: right; display: block">
                <span style="cursor: pointer;" class="tag is-success" id="add_vehicle_row">
                    Add Breakdown &nbsp; <strong>+</strong>
                </span>
            </a>
        <?php endif; ?>
    </div>
    <?php $veh_count = 0 ?>
    <?php if(isset($task_vehicle) && !empty($task_vehicle)): ?>
        <?php $__currentLoopData = $task_vehicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $veh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="myVehicle">
                <div class="columns vs<?php echo e($key); ?>">
                    <div class="column is-1">
                        <label></label> <br/>
                        <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <?php echo e(Form::label('vehicle_id', 'Vehicle', array('class' => 'label'))); ?>

                            <div class="control">
                                <select name="vehicle[<?php echo e($veh_count = $key); ?>][vehicle_id]" id="vehicle_select"
                                        class="input is-small" required>
                                    <option></option>
                                    <option value="None">None</option>
                                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($vehicle->id); ?>" <?php echo e($veh->vehicle_id == $vehicle->id ? 'selected' : ''); ?> ><?php echo e($vehicle->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="column is-2">
                        <?php echo e(Form::label('vehicle_rent', 'Vehicle Rent', array('class' => 'label'))); ?>

                        <input name="vehicle[<?php echo e($veh_count = $key); ?>][vehicle_rent]" type="number"
                               value="<?php echo e($veh->vehicle_rent); ?>" class="input is-small" required>
                    </div>
                    <div class="column is-6">
                        <?php echo e(Form::label('vehicle_note', 'Note', array('class' => 'label'))); ?>

                        <input name="vehicle[<?php echo e($veh_count = $key); ?>][vehicle_note]" type="text"
                               value="<?php echo e($veh->vehicle_note); ?>" class="input is-small" required>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div id="myVehicle">
            <div class="columns">
                <div class="column is-1">
                    <label></label> <br/>
                    <a><span class="tag is-success is-small " id="add_vehicle_row"> Add &nbsp; <strong>+</strong></span></a>
                </div>
                <div class="column is-3">
                    <label for="vehicle_id" class="label">Vehicle</label>
                    <select name="vehicle[0][vehicle_id]" id="vehicle_select" class="input is-small" required>
                        <option></option>
                        <option value="None">None</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="column is-2">
                    <label for="vehicle_rent" class="label">Vehicle Rent</label>
                    <input name="vehicle[0][vehicle_rent]" type="number" value="0" class="input is-small" required>
                </div>
                <div class="column is-6">
                    <label for="vehicle_note" class="label">Note</label>
                    <input name="vehicle[0][vehicle_note]" type="text" value="0" class="input is-small" required>
                </div>
            </div>
        </div>
    <?php endif; ?>
</fieldset>



<script>
    var veh_counter = "<?php echo e($veh_count +1); ?>";

    $("#add_vehicle_row").on("click", function () {
        var cols = '<div class="columns r' + veh_counter + '">';
        cols += '<div class="column is-1">';
        cols += '<br/><a><span class="tag is-danger is-small ibtnDel">Delete</span></a>';
        cols += '</div>';
        cols += '<div class="column is-3">';
        cols += '<label for="vehicle_id" class="label">Vehicle</label>';
        cols += '<select name="vehicle[' + veh_counter + '][vehicle_id]" id="vehicle_select" class="input is-small" required>';
        cols += '<option></option>';
        cols += '<?php foreach($vehicles as $vehicle){?>';
        cols += '<option value="<?php echo $vehicle->id;?>"><?php echo $vehicle->name;?></option>';
        cols += '<?php } ?>';
        cols += '<select>';
        cols += '</div>';
        cols += '<div class="column is-2">';
        cols += '<label for="vehicle_rent" class="label">Vehicle Rent</label>';
        cols += '<input name="vehicle[' + veh_counter + '][vehicle_rent]" type="number" value="" class="input is-small" required>';
        cols += '</div>';
        cols += '<div class="column is-6">';
        cols += '<label for="vehicle_note" class="label">Note</label>';
        cols += '<input name="vehicle[' + veh_counter + '][vehicle_note]" type="text" value="" class="input is-small" required>';
        cols += '</div>';
        cols += '</div>';
        $("div#myVehicle").append(cols);
        vehicleSelectRefresh();
        veh_counter++;
    });


    $("div#myVehicle").on("click", ".ibtnDel", function (event) {
        $(this).closest("div.columns").remove();
        veh_counter -= 1
    });

</script>


<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskrequisitionbill/resource_form/vehicle_breakdown.blade.php ENDPATH**/ ?>