<?php $__env->startSection('title'); ?>
    Route Lists
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Route Lists',
            'spSubTitle' => 'add or edit route list',
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
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search routes...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <div class="columns is-multiline">
        <?php $__currentLoopData = $routelists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $routelist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="column is-4">
                <div class="borderedCol">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                                <p>
                                    <strong>
                                        <a href="javascript:void(0)"
                                           title="View route">
                                            <?php echo e($routelist->route_name); ?>

                                        </a>
                                    </strong>
                                    <br/>
                                    <small>
                                        <strong>Role: </strong>

                                        <?php
                                        $html = null;
                                        $datas = explode(',', $routelist->to_role);
                                        foreach ($datas as $d) {
                                            if ($d > 1 && count($datas) > 1) {
                                                $html .= ', ';
                                            }
                                            $html .= \App\Models\Role::where('id', $d)->first()->name;
                                        }
                                        echo $html;
                                        ?>
                                    </small>
                                    <br/>
                                    <?php if($routelist->parent_menu_id != NULL): ?>
                                        <small>
                                            <?php $route = \App\Models\Routelist::select('route_name')->where('id', $routelist->parent_menu_id)->get()->first(); ?>
                                            <strong>Parent Menu: </strong> <?php echo e($route['route_name'] ?? NULL); ?>

                                        </small>
                                    <?php else: ?>
                                        <small style="color: green;"> is a parent route</small>
                                    <?php endif; ?>
                                    <br/>
                                    <small><strong>Route Hash:</strong> <?php echo e($routelist->route_hash); ?></small>
                                    <br/>
                                    <small><strong>Details:</strong> <?php echo e($routelist->route_description); ?></small>
                                    <br/>
                                    <small>
                                        <strong>Will show on menu? : </strong>
                                        <?php echo e(($routelist->show_menu == 1) ? 'Yes' : 'No'); ?>

                                    </small>
                                </p>
                            </div>
                            <nav class="level is-mobile">
                                <div class="level-left">
                                    
                                    
                                    
                                    
                                    
                                    <a href="<?php echo e(route('routelists.edit', $routelist->id)); ?>"
                                       class="level-item"
                                       title="View all transaction">
                                        <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                    </a>
                                    <a class="level-item" title="Delete user" href="javascript:void(0)"
                                       onclick="confirm('Are you sure?')">
                                        <span class="icon is-small is-red"><i class="fas fa-times"></i></span>
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </article>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/resources/views/routelists/index.blade.php ENDPATH**/ ?>