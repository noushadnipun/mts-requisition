<?php $__env->startSection('title'); ?>
    Vehicles
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('vehicles.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Vehicles',
            'spSubTitle' => 'all vehicles here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spTitle' => 'Vehicles',
            'spAddUrl' => $addUrl,
            'spAllData' => route('vehicles.index'),
            'spSearchData' => route('vehicles.search'),
            'spTitle' => 'Vehicles',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('vehicles.create'),
            'spAllData' => route('vehicles.index'),
            'spSearchData' => route('vehicles.search'),
            'spPlaceholder' => 'Search vehicles...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <?php if(!empty($vehicles)): ?>
        <div class="columns is-multiline">
            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="column is-2">
                    <div class="borderedCol">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <a href="<?php echo e(route('vehicles.show', $vehicle->id)); ?>"
                                               title="View route">
                                                <strong> <?php echo e($vehicle->name); ?> </strong>
                                            </a>
                                        </strong>
                                        <br/>
                                        <small>
                                            <strong>Size: </strong> <?php echo e($vehicle->size); ?>,
                                        </small>
                                        <br/>
                                        <small>
                                            <strong>Probably Cost:</strong> <?php echo e($vehicle->probably_cost); ?>

                                        </small>
                                        <br/>
                                    </p>
                                </div>
                                <nav class="level is-mobile">
                                    <div class="level-left">
                                        <a href="<?php echo e(route('vehicles.show', $vehicle->id)); ?>"
                                           class="level-item"
                                           title="View user data">
                                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                        </a>
                                        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
                                            <a href="<?php echo e(route('vehicles.edit', $vehicle->id)); ?>"
                                            class="level-item"
                                            title="View all transaction">
                                                <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                            </a>
                                        <?php endif; ?>

                                        
                                    </div>
                                </nav>
                            </div>
                        </article>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        <div class="pagination_wrap pagination is-centered">
            <?php if(Request::get('key')): ?>
                <?php echo e($vehicles->appends(['key' => Request::get('key')])->links('pagination::bootstrap-4')); ?>

            <?php else: ?>
                <?php echo e($vehicles->links('pagination::bootstrap-4')); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/vehicle/src/views/index.blade.php ENDPATH**/ ?>