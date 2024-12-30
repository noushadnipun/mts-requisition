<?php $__env->startSection('column_left'); ?>

    <div class="columns is-vcentered  pt-2">
        <div class="column is-6 mx-auto">
            <div class="card tile is-child xquick_view">
                <header class="card-header">
                    <p class="card-header-title">
                    <span class="icon">
                        <i class="fas fa-tasks default"></i>
                    </span>
                        Report of sites
                </header>

                <div class="card-content">
                    <div class="card-data">
                        <form method="post" action="<?php echo e(route('download_excel_site_accountant')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="field has-addons">
                                <div class="control">
                                    <input class="input is-small" type="text" name="daterange" id="textboxID"
                                           value="<?php echo e($date ?? null); ?>">
                                </div>
                                <div class="control">
                                    <?php
                                    $projects = \Tritiyo\Project\Models\Project::pluck('name', 'id');//->prepend('Select Project', '');
                                    //dd($projects);
                                    ?>
                                    <select name="project_id" class="select" id="project_select" required>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                value="<?php echo e($key ?? NULL); ?>"
                                                <?php echo e((!empty($task->project_id) && ($project->id == $task->project_id)) ? 'selected="selected"' : NULL); ?>>
                                                <?php echo e($project ?? NULL); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="control">
                                    <input name="search" type="submit"
                                           class="button is-small is-primary has-background-primary-dark"
                                           value="Download As Excel"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="card-content">
                    <div class="card-data">
                        <?php
                        //$shellexec = shell_exec('getmac');
                        //echo $shellexec;
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('cusjs'); ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/excel/site_by_accountant.blade.php ENDPATH**/ ?>