<?php $__env->startSection('title'); ?>
    Edit Vehicle
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
            'spTitle' => 'Edit Vehicle',
            'spSubTitle' => 'Edit a single vehicle',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
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
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Vehicle Information</a>
        </p>


        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('vehicles.update', $vehicle->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('name', 'Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('name', $vehicle->name ?? NULL, ['class' => 'input', 'placeholder' => 'Enter name...'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('size', 'Vehicle Size', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('size', $vehicle->size ?? NULL, ['class' => 'input', 'placeholder' => 'Enter Vehicle Size...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                 <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('probably_cost', 'Probably Cost', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('probably_cost', $vehicle->probably_cost ?? NULL, ['class' => 'input', 'placeholder' => 'Enter probably cost...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <article class="is-primary">
        <div class="box">
            <h1 class="title is-5">Important Note</h1>
            <p>
                Please select project manager and budget properly
            </p>
        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/vehicle/src/views/edit.blade.php ENDPATH**/ ?>