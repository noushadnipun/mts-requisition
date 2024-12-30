<?php $__env->startSection('title'); ?>
    Materials
<?php $__env->stopSection(); ?>
<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('materials.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Materials',
            'spSubTitle' => 'all materials here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spTitle' => 'Materials',
            'spAddUrl' => $addUrl,
            'spAllData' => route('materials.index'),
            'spSearchData' => route('materials.search'),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spAddUrl' => route('materials.create'),
            'spAllData' => route('materials.index'),
            'spSearchData' => route('materials.search'),
            'spPlaceholder' => 'Search materials...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <?php if(!empty($materials)): ?>
        <div class="columns is-multiline">
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="column is-2">
                    <div class="borderedCol">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <a href="<?php echo e(route('materials.show', $material->id)); ?>"
                                               title="View route">
                                                <strong><?php echo e($material->name); ?> </strong>
                                            </a>
                                        </strong>
                                        <br/>
                                        <small>
                                            <strong>Unit: </strong> <?php echo e($material->unit); ?>

                                        </small>
                                        <br/>
                                    </p>
                                </div>
                                <nav class="level is-mobile">
                                    <div class="level-left">
                                        <a href="<?php echo e(route('materials.show', $material->id)); ?>"
                                           class="level-item"
                                           title="View user data">
                                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                        </a>
                                        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
                                            <a href="<?php echo e(route('materials.edit', $material->id)); ?>"
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
                <?php echo e($materials->appends(['key' => Request::get('key')])->links('pagination::bootstrap-4')); ?>

            <?php else: ?>
                <?php echo e($materials->links('pagination::bootstrap-4')); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\material\src/views/index.blade.php ENDPATH**/ ?>