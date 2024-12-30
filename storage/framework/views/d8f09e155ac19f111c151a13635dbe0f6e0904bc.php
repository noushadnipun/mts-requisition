<?php $__env->startSection('title'); ?>
    Projects
<?php $__env->stopSection(); ?>

<?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
    <?php
        $addUrl = route('projects.create');
    ?>
<?php else: ?>
    <?php
        $addUrl = '#';
    ?>
<?php endif; ?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Projects',
            'spSubTitle' => 'all projects here',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => $addUrl,
            'spAllData' => route('projects.index'),
            'spSearchData' => route('projects.search'),
            'spTitle' => 'Projects',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search projects...',
            'spAddUrl' => route('projects.create'),
            'spAllData' => route('projects.index'),
            'spSearchData' => route('projects.search'),
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>

<?php $__env->startSection('column_left'); ?>
    <div class="columns is-multiline">
        <?php
            if(auth()->user()->isManager(auth()->user()->id)) {
                $manager_id = auth()->user()->id;
                $projectsss = \DB::table('projects')
                                ->where('projects.manager', $manager_id)
                                ->paginate(30);
            } else {
                $projectsss = $projects;
            }
        ?>
        <?php if(!empty($projectsss)): ?>
            <?php $__currentLoopData = $projectsss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      			<?php
      				$project_status = \Tritiyo\Project\Helpers\ProjectHelper::project_status($project->id);      				
      			?> 
                <div class="column is-3">                  
                    <div class="borderedCol <?php echo e(($project_status != 'Active') ? 'has-background-danger-light' : ''); ?>">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <a href="<?php echo e(route('projects.show', $project->id)); ?>"
                                               title="View project">
                                                <?php echo e($project->name); ?>                                              	
                                            </a>
                                        </strong>
                                        <br/>
                                        <small> 
                                          	<strong>ID: </strong> <?php echo e($project->id); ?>

                                            <br/>
                                            <strong>Type: </strong> <?php echo e($project->type); ?>

                                            <br/>
                                            <strong>Project Manager:</strong>
                                            <?php
                                                $pm = \Tritiyo\Project\Models\Project::where('id', $project->id)->first()->manager ?? 0;
                                                $pm_name = \App\Models\User::where('id', $pm)->first()->name ?? null;
                                            ?>
                                            <a href="<?php echo e(route('hidtory.user', $pm)); ?>"
                                               target="_blank"
                                               title="View project manager">
                                                <?php echo e(\App\Models\User::where('id', $project->manager)->first()->name ?? null); ?>

                                            </a>
                                            
                                        </small>
                                        <br/>
                                        <small>

                                            <strong>Customer:</strong> <?php echo e($project->customer); ?>

                                        <!-- <strong>Vendor:</strong> <?php echo e($project->vendor); ?>,
                                            <strong>Supplier:</strong> <?php echo e($project->supplier); ?> -->
                                        </small>
                                      	<br/>
                                      	<small>
                                          <strong>Status:</strong> <?php echo e($project_status ?? 'Inactive'); ?>

                                      	</small>
                                        <br/>

                                        <?php
                                            $exists = \Tritiyo\Project\Models\ProjectRange::where('project_id', $project->id)->orderBy('id', 'desc')->get();
                                            //dd($exists);
                                        ?>
                                        
                                    <strong>Current Range Budget Information Till Today</strong>
                                  	<br/>
                                    <small>
                                      <table class="table is-striped is-bordered is-narrow is-size-7">
                                        <thead>
                                          <tr class="is-selected has-background-link-light has-text-link-dark">
                                            <td>Total Budget</td>
                                            <td>Used Budget</td>
                                            <td>Mobile Bill</td>
                                            <td>Total Used</td>
                                          </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <tr>
                                            <td>
                                                    <?php
                                                        $allCurrentBudgets = \Tritiyo\Project\Helpers\ProjectHelper::current_range_budgets($project->id);
                                                    ?>
                                            		BDT. <?php echo e($allCurrentBudgets ?? NULL); ?>

                                          	</td>
                                          
                                          	<?php
                                                 $current_range_id = \Tritiyo\Project\Helpers\ProjectHelper::current_range_id($project->id);
                                           		 $mobileBill = \Tritiyo\Project\Models\MobileBill::where('project_id', $project->id)->where('range_id', $current_range_id)->get()->sum('received_amount');
                                          		 $budgetuse = \Tritiyo\Project\Helpers\ProjectHelper::ttrbGetTotalByProject('reba_amount', $project->id, $current_range_id);
                                            ?>
                                           <td> BDT. <?php echo e(number_format($budgetuse)); ?> </td>
                                           <td>  BDT . <?php echo e(number_format($mobileBill)); ?> </td>
                                           <td> BDT. <?php echo e(number_format($budgetuse + $mobileBill  )); ?> </td>
                                        </tr>
                                        </tbody>

                                      </table>
                                    </small>
                                  </p>
                                </div>
                                <nav class="level is-mobile">
                                    <div class="level-left">
                                        <a href="<?php echo e(route('projects.show', $project->id)); ?>"
                                           class="level-item"
                                           title="View project">
                                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                                        </a>
                                        <?php if(auth()->user()->isAdmin(auth()->user()->id) || auth()->user()->isApprover(auth()->user()->id)): ?>
                                            <a href="<?php echo e(route('projects.edit', $project->id)); ?>"
                                               class="level-item"
                                               title="Edit Project Information">
                                                <span class="icon is-info is-small">
                                                  <i class="fas fa-edit"></i>
                                              	</span>
                                            </a>
                                            <?php
                                                $project_status = \Tritiyo\Project\Helpers\ProjectHelper::project_status($project->id);
                                            ?>
                                            <?php if($project_status == 'Active'): ?>
                                                <a href="<?php echo e(route('project_budgets.create')); ?>?project_id=<?php echo e($project->id); ?>"
                                                   class="level-item"
                                                   title="Add Project Budget">
                                                <span class="icon is-small" style="color: green; font-size: 15px;">
                                                  <i class="fas fa-plus"></i>
                                              	</span>
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?php echo e(route('project_ranges.create')); ?>?project_id=<?php echo e($project->id); ?>"
                                               class="level-item"
                                               title="Edit Project Status">
                                                <span class="icon is-small" style="color: red; font-size: 17px;">
                                                  <i class="fas fa-pen-square"></i>
                                              	</span>
                                            </a>

                                            <a href="<?php echo e(route('target.projects.kpi.create')); ?>?project_id=<?php echo e($project->id); ?>"
                                               class="level-item"
                                               style="display: none"
                                               title="Key Performance indicators">
                                                <span class="icon is-small" style="color: #ff5400; font-size: 17px;">
                                                   <i class="far fa-chart-bar"></i>
                                                </span>
                                            </a>

                                            
                                        <?php endif; ?>
                                        <!-- For Only Accountant -->
                                        <?php if(auth()->user()->isAccountant(auth()->user()->id)): ?>
                                            <?php
                                                $project_status = \Tritiyo\Project\Helpers\ProjectHelper::project_status($project->id);
                                            ?>
                                            <?php if($project_status == 'Active'): ?>
                                                <a href="<?php echo e(route('project_budgets.create')); ?>?project_id=<?php echo e($project->id); ?>"
                                                   class="level-item"
                                                   title="Add Project Budget">
                                                    <span class="icon is-small" style="color: green; font-size: 15px;">
                                                      <i class="fas fa-plus"></i>
                                                    </span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </nav>
                            </div>
                        </article>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
    <div class="pagination_wrap pagination is-centered">

        <?php if(Request::get('key')): ?>
            <?php echo e($projects->appends(['key' => Request::get('key')])->links('pagination::bootstrap-4')); ?>

        <?php else: ?>
            <?php echo e($projects->links('pagination::bootstrap-4')); ?>

        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mts\requisition\vendor\tritiyo\project\src/views/index.blade.php ENDPATH**/ ?>