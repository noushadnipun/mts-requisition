<?php
    $taskproofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->get();
 	$proofs = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
    //$proofs  variable assign in show.blade
?>

<?php if($taskproofs->count() > 0): ?>
<section id="proofAccordion" class="accordions">
    <div class="card tile is-child quick_view accordion">
        <header class="card-header accordion-header toggle">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Proof Images Panel
            </p>
        </header>
        <div class="accordion-body">
            <div class="card-content">
            <div class="card-data accordion-content">
                <div class="columns">
                    <div class="column is-6">
                      
                        <?php if(!empty($taskStatus) && $taskStatus->code == 'head_accepted' && auth()->user()->id == $taskStatus->action_performed_by): ?>
                            <div class="notification is-success">
                                Task Accepted. Please submit your proof
                            </div>
                        <?php endif; ?>


                        <?php if(!empty($proofs->resource_proof)): ?>
                            <div class="columns">
                                <div class="column is-12">
                                    <strong>Resource Proof</strong><br/>
                                    <?php if(($proofs != NULL)): ?>
                                        <?php $__currentLoopData = explode(' | ', $proofs->resource_proof); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <figure class="image is-48x48 is-inline-block">
                                                <a class="modal-button" data-target="resource_proof<?php echo e($key); ?>">
                                                    <img src="<?php echo e(url('public/proofs/' .   $img_link)); ?>" class="image_wrap"/>
                                                </a>
                                                <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('resource_proof' . $key, url('public/proofs/' . $img_link));?>
                                            </figure>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($proofs->vehicle_proof)): ?>
                        <div class="columns">
                            <div class="column is-12">
                                <strong>Vehicle Proof</strong><br/>
                                <?php if(($proofs != NULL)): ?>
                                    <?php $__currentLoopData = explode(' | ', $proofs->vehicle_proof); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <figure class="image is-48x48 is-inline-block">
                                            <a class="modal-button" data-target="vehicle_proof<?php echo e($key); ?>">
                                                <img src="<?php echo e(url('public/proofs/' .   $img_link)); ?>" class="image_wrap"/>
                                            </a>
                                            <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('vehicle_proof' . $key, url('public/proofs/' . $img_link));?>
                                        </figure>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>
                    <div class="column is-6">

                        <?php if(!empty($proofs->material_proof)): ?>
                            <div class="columns">
                                <div class="column is-12">
                                    <strong>Material Proof</strong><br/>
                                    <?php if(($proofs != NULL)): ?>
                                        <?php $__currentLoopData = explode(' | ', $proofs->material_proof); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <figure class="image is-48x48 is-inline-block">
                                                <a class="modal-button" data-target="material_proof<?php echo e($key); ?>">
                                                    <img src="<?php echo e(url('public/proofs/' .   $img_link)); ?>" class="image_wrap"/>
                                                </a>
                                                <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('material_proof' . $key, url('public/proofs/' . $img_link));?>
                                            </figure>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(!empty($proofs->anonymous_proof)): ?>
                            <div class="columns">
                                <div class="column is-12">
                                    <strong>Anonymous Proof</strong><br/>
                                    <?php if(($proofs != NULL)): ?>
                                        <?php $__currentLoopData = explode(' | ', $proofs->anonymous_proof); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img_link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <figure class="image is-48x48 is-inline-block">
                                                <a class="modal-button" data-target="anonymous_proof<?php echo e($key); ?>">
                                                    <img src="<?php echo e(url('public/proofs/' .   $img_link)); ?>" class="image_wrap"/>
                                                </a>
                                                <?php echo Tritiyo\Task\Helpers\TaskHelper::modalImage('anonymous_proof' . $key, url('public/proofs/' . $img_link));?>
                                            </figure>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
<?php endif; ?>
<script type="text/javascript" src="https://unpkg.com/bulma-modal-fx/dist/js/modal-fx.min.js"></script>
<style>
    img.image_wrap {
        height: 48px;
        width: 48px;
        background: #dddddd;
        padding: 3px;
    }
    .card-header-title {
        padding: .25rem 1rem !important;
    }


    /* Accordion */
    section#proofAccordion.accordions .accordion .accordion-header {
        align-items: center;
        background-color: rgba(0, 0, 0, .03) !important;
        border-radius: 4px 4px 0 0;
        color: #fff;
        display: flex;
        line-height: 0em;
        padding: 0em .0em !important;
        position: relative;
        border: 0px;
    }

    section#proofAccordion.accordions .accordion {
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
        border-radius: 4px;
        font-size: 13px;
        border: 0px;
    }

    section#proofAccordion.accordions .accordion .accordion-header + .accordion-body .accordion-content {
        padding: 0em 0em;
    }

    section#proofAccordion.accordions .accordion a:not(.button):not(.tag) {
        text-decoration: none;
    }
</style>
<?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\task\src/views/taskaction/task_proof_images.blade.php ENDPATH**/ ?>