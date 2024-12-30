<?php $__env->startSection('title'); ?>
    Edit a route
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Edit a route',
            'spSubTitle' => 'edit route',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('routelists.create'),
            'spAllData' => route('routelists.index'),
            'spSearchData' => route('routelists.search'),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => false,
            'spPlaceholder' => 'Search routes...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a class="is-active">Route Information</a>
        </p>

        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('routelists.update', $routelist->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

            <div class="columns">

                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('to_role','Software Role',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select is-multiple">
                                <?php
                                $role = \App\Models\Role::pluck('name', 'id')->prepend('Select Role', '');
                                $selected = explode(",", $routelist->to_role);
                                ?>
                                <select name="to_role[]" multiple="multiple">
                                    <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($key); ?>" <?php echo e((in_array($key, $selected)) ? 'selected' : ''); ?>>
                                            <?php echo e($val); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                                <small>Use CTRL + Click to select multiple role</small>
                            </div>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('parent_route_id','Parent Route',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php $routes = \App\Models\Routelist::pluck('route_name', 'id')->prepend('Select parent if needed', ''); ?>
                                <?php echo e(Form::select('parent_route_id', $routes ?? NULL, $routelist->parent_menu_id, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('route_name', 'Route Name in Capitalized Form', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('route_name', $routelist->route_name, ['required', 'class' => 'input', 'placeholder' => 'Enter route name...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('route_url', 'Route URL', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('route_url', $routelist->route_url, ['class' => 'input', 'placeholder' => 'Enter route URL...'])); ?>

                        </div>
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="field">
                        <?php echo e(Form::label('show_menu','Will show as menu?',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php
                                $condition = [
                                    '' => 'Select one',
                                    '1' => 'Yes',
                                    '0' => 'No'
                                ]
                                ?>
                                <?php echo e(Form::select('show_menu', $condition ?? NULL, $routelist->show_menu, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('skip_sub','Skip Sub Menu',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php
                                $condition = [
                                    '' => 'Select one',
                                    '1' => 'Yes',
                                    '0' => 'No'
                                ]
                                ?>
                                <?php echo e(Form::select('skip_sub', $condition ?? NULL, $routelist->skip_sub, ['class' => 'input'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('dashboard_menu','Will show as dashboard menu?',['class' => 'label'])); ?>

                        <div class="control">
                            <div class="select">
                                <?php
                                $dashboard = [
                                    '' => 'Select one',
                                    '1' => 'Yes',
                                    '0' => 'No'
                                ]
                                ?>
                                <?php echo e(Form::select('dashboard_menu', $dashboard ?? NULL, $routelist->dashboard_menu, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('font_awesome', 'Font awesome class for icon', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('font_awesome', $routelist->font_awesome, ['required', 'class' => 'input', 'placeholder' => 'Enter font awesome...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('bulma_class_icon_bg', 'Bulma class for background', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('bulma_class_icon_bg', $routelist->bulma_class_icon_bg, ['class' => 'input', 'placeholder' => 'Enter BG bulma class...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('route_description', 'Route Description', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::textarea('route_description', $routelist->route_description, ['required', 'class' => 'textarea', 'rows' => 5, 'placeholder' => 'Enter route details...'])); ?>

                        </div>
                    </div>
                    <div class="field">
                        <?php echo e(Form::label('route_note', 'Route Note', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::textarea('route_note', $routelist->route_note, ['class' => 'textarea', 'rows' => 5, 'placeholder' => 'Enter route notes...'])); ?>

                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-success is-small">Save Changes</button>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <article class="panel is-primary">
                        <p class="panel-tabs">
                            <a class="is-active">Click to edit</a>
                        </p>
                        <div style="padding: 20px; max-height: 400px; overflow: scroll;">
                            <?php
                            $routelists = \App\Models\Routelist::get()->toArray();
                            //dump($routelists);
                            ?>
                            <?php echo route_list_sidebar($routelists, $parent = 0, $seperator = '--'); ?>

                        </div>
                    </article>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <article class="is-primary">
        <div class="box">
            <h1 class="title is-5"> গুরুত্বপুর্ণ তথ্য </h1>
            <p>
                এই পেইজে শুধু এডমিন ছাড়া বাকিদের জন্য উন্মুক্ত না। এই পেইজে কাজ করার ক্ষেত্রে সতর্কতা অবলম্বণ করতে হবে।
            </p>
        </div>
    </article>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/routelists/edit.blade.php ENDPATH**/ ?>