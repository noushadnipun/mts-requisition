<div class="columns">
    <div class="column">
        <strong>Purchase Breakdown</strong>
        <?php if(!empty($task_purchase_breakdown)): ?>
        <a style="float: right">
            <span style="cursor: pointer;" class="tag is-success"  id="addrowPa">Add &nbsp; <strong>+</strong></span>
        </a>
        <?php endif; ?>
    </div>
    <div class="block">
    </div>
</div>

<div id="pa_wrap">
    <?php $pa_count = 0; ?>
    <?php if(!empty($task_purchase_breakdown)): ?>
        <?php $__currentLoopData = $task_purchase_breakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="columns">
            <div class="column is-1">
                <div class="block" style="margin-top: 3px;">
                        <span style="cursor: pointer;" class="tag is-danger ibtnDelPa">
                                                        Del <button class="delete is-small"></button>
                                                    </span>
                </div>
            </div>
            <div class="column is-2">
                <input class="input is-small" name="purchase[<?php echo e($pa_count = $key); ?>][pa_amount]"
                       type="number" min="0"
                       step=".01"
                       value="<?php echo e($item->pa_amount); ?>" required/>
            </div>
            <div class="column">
                <input class="input is-small" name="purchase[<?php echo e($pa_count = $key); ?>][pa_note]"
                       type="text"
                       value="<?php echo e($item->pa_note); ?>" required/>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="columns">
            <div class="column is-1">
                <div class="block" style="margin-top: 3px;">
                    <a style="display: block">
                                                <span style="cursor: pointer;" class="tag is-success"
                                                      id="addrowPa">Add &nbsp; <strong>+</strong></span>
                    </a>
                </div>
            </div>
            <div class="column is-2">
                <input class="input is-small" name="purchase[0][pa_amount]" type="number" min="0"
                       step=".01"
                       placeholder="PA Amount" required/>
            </div>
            <div class="column">
                <input class="input is-small" name="purchase[0][pa_note]" type="text"
                       placeholder="PA Note" required/>
            </div>
        </div>
    <?php endif; ?>
</div>

<script id="pa_form" type="text/template">
    <div class="columns">
        <div class="column is-1">
            <div class="block" style="margin-top: 3px;">
                    <span style="cursor: pointer;" class="tag is-danger ibtnDelPa">
                    Del <button class="delete is-small"></button>
                    </span>
            </div>
        </div>
        <div class="column is-2">
            <input class="input is-small pa_amount" name="" type="number" min="0" step=".01"
                   placeholder="PA Amount" required/>
        </div>
        <div class="column">
            <input class="input is-small pa_note" name="" type="text"
                   placeholder="PA Note" required/>
        </div>
    </div>
</script>



<script>
    //Add Row Function
    $(document).ready(function () {

        var pa_counter = '<?php echo e($pa_count + 1); ?>';

        //Purchase
        $("#addrowPa").on("click", function () {
            var cols_pa = '<div class="pa' + pa_counter + '">';
            cols_pa += $('#pa_form').html();
            cols_pa += '</div>';

            $("div#pa_wrap").append(cols_pa);

            $(".pa" + pa_counter + " .pa_amount").attr('name', "purchase[" + pa_counter + "][pa_amount]");
            $(".pa" + pa_counter + " .pa_note").attr('name', "purchase[" + pa_counter + "][pa_note]");

            pa_counter++;
        });


        $("div#pa_wrap").on("click", ".ibtnDelPa", function (event) {
            $(this).closest("div.columns").remove();
            counter -= 1
        });
    });

</script>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/taskrequisitionbill/resource_form/purchase_breakdown.blade.php ENDPATH**/ ?>