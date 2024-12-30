<table class="mt-2 table is-bordered xis-striped is-narrow is-fullwidth"
       style="text-align: right;display: table; background: transparent; float: right">
    <tr>
        <td style="width: 10%"></td>
        <?php if(auth()->user()->isResource(auth()->user()->id)): ?>

        <?php else: ?>
        <td style="width: 45%" title="Requisition">R</td>
        <?php endif; ?>
        <td title="Bill">B</td>
    </tr>
    <tr>
        <td style="width: 10%" title="Resource">R</td>
        <?php if(auth()->user()->isResource(auth()->user()->id)): ?>

        <?php else: ?>
            <td></td>
        <?php endif; ?>
        <td title="Bill Submit By Resource">
            <?php echo e($calculate->bpbr_amount ?? 0); ?>

        </td>
    </tr>
    <tr>
        <td title="Manager">M</td>
        <?php if(auth()->user()->isResource(auth()->user()->id)): ?>

        <?php else: ?>
            <td title="Requisition By Manager">
                <?php echo e($calculate->rpbm_amount ?? 0); ?>

            </td>
        <?php endif; ?>
        <td title="Bill Edited By Manager">
            <?php echo e($calculate->bebm_amount ?? 0); ?>

        </td>
    </tr>
    <tr>
        <td title="CFO">C</td>
        <?php if(auth()->user()->isResource(auth()->user()->id)): ?>

        <?php else: ?>
            <td title="Requisition By CFO">
                <?php echo e($calculate->rebc_amount ?? 0); ?>

            </td>
        <?php endif; ?>
        <td title="Bill Edited By CFO">
            <?php echo e($calculate->bebc_amount ?? 0); ?>

        </td>
    </tr>
    <tr>
        <td title="Accountant">A</td>
        <?php if(auth()->user()->isResource(auth()->user()->id)): ?>

        <?php else: ?>
            <td title="Requisition By Accountant">
                <?php echo e($calculate->reba_amount ?? 0); ?>

            </td>
        <?php endif; ?>
        <td title="Bill Edited By Accountant">
            <?php echo e($calculate->beba_amount ?? 0); ?>

        </td>
    </tr>
</table>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/tasklist/ajax_rb_total_index.blade.php ENDPATH**/ ?>