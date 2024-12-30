<?php $__env->startSection('title'); ?>
    Other setting
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Payment setting',
            'spSubTitle' => 'add or edit payment setting data',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => false,
            'spAddUrl' => null,
            'spAllData' => route('settings.index'),
            'spSearchData' => null,
            'spExportCSV' => null,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => false,
            'spPlaceholder' => 'Search setting...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>


<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a href="<?php echo e(route('settings.global', 1)); ?>">
                <i class="fas fa-wrench"></i>&nbsp; Global Settings
            </a>
            <a href="<?php echo e(route('settings.payment', 2)); ?>">
                <i class="fas fa-dollar-sign"></i>&nbsp; Payment Settings
            </a>
            <a href="<?php echo e(route('settings.time', 3)); ?>">
                <i class="fas fa-clock"></i>&nbsp; Time Settings
            </a>
            <a href="<?php echo e(route('settings.email', 4)); ?>" class="">
                <i class="fas fa-envelope"></i>&nbsp; Email Settings
            </a>
            <a href="<?php echo e(route('settings.other', 5)); ?>" class="is-active">
                <i class="fas fa-cog"></i>&nbsp; Other Settings
            </a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('settings.other', 5), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off'))); ?>

   

            <?php
            if (!empty($setting)) {
                $fields = json_decode($setting->settings);
            }
            ?>

            <div class="columns">
                <div class="column is-12">
                    <div class="field">
                        <?php echo e(Form::label('email_address', 'Percentage of project lock', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('project_lock_percentage', $fields->project_lock_percentage ?? NULL, ['required', 'class' => 'input', 'rows' => 2, 'cols' => 40, 'placeholder' => '95', 'style' => 'height: auto !important'])); ?>

                        </div>
                        <small class="lead"></small>
                    </div>
                  
                  
                  <div class="field">
                        <?php echo e(Form::label('email_address', 'CFO restriction', array('class' => 'label'))); ?>

                        <div class="control">                   
                           <input type="checkbox" name="cfo_restriction" value="1" <?php echo e($fields->cfo_restriction == '1' ? 'checked' : null); ?>> 
                        </div>
                        <small class="lead"></small>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/settings/other.blade.php ENDPATH**/ ?>