<?php $__env->startSection('column_left'); ?>

    <div class="columns is-vcentered  pt-2">
        <div class="column is-6 mx-auto">
            <div class="card tile is-child xquick_view">
                <header class="card-header">
                    <p class="card-header-title">
                    <span class="icon">
                        <i class="fas fa-tasks default"></i>
                    </span>
                        Report of Requisiition
                </header>

                <div class="card-content">
                    <div class="card-data">
                        <form method="post" action="<?php echo e(route('download_excel_requisition_accountant')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="field has-addons">
                                <div class="control">
                                    <input class="input is-small" type="text" name="daterange" id="textboxID"
                                           value="<?php echo e($date ?? null); ?>">
                                </div>
                                <div class="control">
                                    <div class="field">                                          
                                          <?php
                                              if(auth()->user()->isCFO(auth()->user()->id) || auth()->user()->isAccountant(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id) ){
                                                  $projects = \Tritiyo\Project\Models\Project::latest()->get();
                                              } else {
                                                  $projects = \Tritiyo\Project\Models\Project::where('manager', auth()->user()->id)->latest()->get();
                                              }
                                          ?>
                                          <select class="input is-small" name="project_id" id="project_select" date-project="<?php echo e(!empty($projectId) ? $projectId : ''); ?>">
                                              <option value="">Select a project</option>
                                              <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <option value="<?php echo e($project->id); ?>" <?php echo e(!empty($projectId) && $projectId == $project->id ? 'selected': ''); ?> ><?php echo e($project->name); ?></option>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </select>
                                      </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/excel/requisition_by_accountant.blade.php ENDPATH**/ ?>