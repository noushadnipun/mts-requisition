<?php
    $materials = \Tritiyo\Material\Models\Material::get();
?>
<fieldset class="pb-5">
    <div class="mb-3">
        <label>Material Information</label>
        <?php if(isset($task_material) && count($task_material) > 0): ?>
            <a style="float: right; display: block">
                <span style="cursor: pointer;" class="tag is-success"
                      id="add_material_row">Add Breakdown &nbsp; <strong>+</strong></span>
            </a>
        <?php endif; ?>
    </div>
    <?php $mat_count = 0 ?>
    <?php if(isset($task_material) && count($task_material) > 0): ?>
        <?php $__currentLoopData = $task_material; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="myMaterial">
                <div class="columns m<?php echo e($key); ?>">
                    <div class="column is-1">
                        <label></label> <br/>
                        <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>
                    </div>
                    <div class="column is-2">
                        <div class="field">
                            <?php echo e(Form::label('material_id', 'Material', array('class' => 'label'))); ?>

                            <div class="control">
                                <select name="material[<?php echo e($mat_count = $key); ?>][material_id]" id="material_select"
                                        class="input is-small"
                                        required>
                                    <option></option>
                                    <option value="None">None</option>
                                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($material->id); ?>" <?php echo e($mat->material_id == $material->id ? 'selected' : ''); ?> ><?php echo e($material->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="column is-2">
                        <?php echo e(Form::label('material_qty', 'Material Qty', array('class' => 'label'))); ?>

                        <input name="material[<?php echo e($mat_count = $key); ?>][material_qty]" type="number"
                               value="<?php echo e($mat->material_qty); ?>" class="input is-small" required>
                    </div>

                    <div class="column is-2">
                        <?php echo e(Form::label('material_amount', 'Amount', array('class' => 'label'))); ?>

                        <input name="material[<?php echo e($mat_count = $key); ?>][material_amount]" type="number"
                               value="<?php echo e($mat->material_amount); ?>" class="input is-small">
                    </div>
                    <div class="column is-5">
                        <?php echo e(Form::label('material_note', 'Note', array('class' => 'label'))); ?>

                        <input name="material[<?php echo e($mat_count = $key); ?>][material_note]" type="text"
                               value="<?php echo e($mat->material_note); ?>" class="input is-small">
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div id="myMaterial">
            <div class="columns">
                <div class="column is-1">
                    <label></label> <br/>
                    <a><span class="tag is-success is-small" id="add_material_row">Add &nbsp; <strong>+</strong></span></a>
                </div>
                <div class="column is-2">
                    <label for="material_id" class="label">Material</label>
                    <select name="material[0][material_id]" id="material_select" class="input is-small" required>
                        <option></option>
                        <option value="None">None</option>
                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($material->id); ?>"><?php echo e($material->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="column is-2">
                    <label for="material_qty" class="label">Material Qty</label>
                    <input name="material[0][material_qty]" type="number" value="0" class="input is-small" required>
                </div>
                <div class="column is-2">
                    <label for="material_amount" class="label">Material Amount</label>
                    <input name="material[0][material_amount]" type="number" value="0" class="input is-small">
                </div>
                <div class="column is-5">
                    <label for="material_note" class="label">Note</label>
                    <input name="material[0][material_note]" type="text" value="0" class="input is-small">
                </div>
            </div>
        </div>
    <?php endif; ?>
</fieldset>

<script>
    var mat_counter = "<?php echo e($mat_count + 1); ?>";

    $("#add_material_row").on("click", function () {
        //console.log(mat_counter)
        var cols = '<div class="columns m' + mat_counter + '">';
        cols += '<div class="column is-1">';
        cols += '<br/><a><span class="tag is-danger is-small ibtnDel">Delete</span></a>';
        cols += '</div>';
        cols += '<div class="column is-2">';
        cols += '<label for="material_id" class="label">Material</label>';
        cols += '<select name="material[' + mat_counter + '][material_id]" id="material_select" class="input is-small" required>';
        cols += '<?php foreach($materials as $material){?>';
        cols += '<option></option>'
        cols += '<option value="<?php echo $material->id;?>"><?php echo $material->name;?></option>';
        cols += '<?php } ?>';
        cols += '<select>';
        cols += '</div>';
        cols += '<div class="column is-2">';
        cols += '<label for="material_qty" class="label">Material Qty</label>';
        cols += '<input name="material[' + mat_counter + '][material_qty]" type="number" value="" class="input is-small" required>';
        cols += '</div>';
        cols += '<div class="column is-2">';
        cols += '<label for="material_amount" class="label">Material Amount</label>';
        cols += '<input name="material[' + mat_counter + '][material_amount]" type="number" value="" class="input is-small">';
        cols += '</div>';
        cols += '<div class="column is-5">';
        cols += '<label for="material_note" class="label">Note</label>';
        cols += '<input name="material[' + mat_counter + '][material_note]" type="text" value="" class="input is-small">';
        cols += '</div>';
        cols += '</div>';

        $("div#myMaterial").append(cols);
      	materialSelectRefresh();
        mat_counter++;
    });

    $("div#myMaterial").on("click", ".ibtnDel", function (event) {
        $(this).closest("div.columns").remove();
        mat_counter -= 1
    });
</script>






<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskrequisitionbill/resource_form/material_breakdown.blade.php ENDPATH**/ ?>