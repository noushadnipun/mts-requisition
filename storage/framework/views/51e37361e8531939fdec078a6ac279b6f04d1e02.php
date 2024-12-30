<?php $__env->startSection('title'); ?>
    Single Material
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
            'spTitle' => 'Single Material',
            'spSubTitle' => 'view a Material',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
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
    
    
    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account default"></i></span>
                Main Material Data
            </p>
        </header>
        <div class="card-content">
            <div class="card-data">
                <div class="columns">
                    <div class="column is-2">Name</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($material->name); ?></div>
                </div>
                <div class="columns">
                    <div class="column is-2">Unit</div>
                    <div class="column is-1">:</div>
                    <div class="column"><?php echo e($material->unit); ?></div>
                </div>
            </div>
        </div>
    </div>

	<?php
		$daterange = request()->get('daterange');
		if(!empty(request()->get('daterange'))) {
			$dates = explode(' - ', $daterange);
			$start = $dates[0];
			$end = $dates[1];
			$materials = \Tritiyo\Task\Models\TaskMaterial::leftJoin('tasks', 'tasks.id', 'tasks_material.task_id')
					->where('tasks_material.material_id', $material->id)
					->whereBetween('tasks.task_for', [$start, $end])
					->paginate(50);
		} else {
		    $start = date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'));
            $end = date('Y-m-d');
			$materials = \Tritiyo\Task\Models\TaskMaterial::leftJoin('tasks', 'tasks.id', 'tasks_material.task_id')
					->where('tasks_material.material_id', $material->id)
				    ->whereBetween('tasks.task_for', [$start, $end])
					->paginate('50');
		}

		//dd($materials);
    ?>

	<div class="card tile is-child" style="margin-top: 15px !important;">
		<header class="card-header">
			<p class="card-header-title">
				<span class="icon"><i class="fas fa-tasks default"></i></span>
				Material Used

				<?php echo e(Form::open(array('url' => route('materials.show', $material->id), 'method' => 'GET', 'value' => 'PATCH', 'class' => 'dateFilter',  'id' => 'tasks_advanced_search', 'autocomplete' => 'off'))); ?>

					<div class="columns">
                        <div class="column">
                            <a href="<?php echo e(route('download_excel_material')); ?>?id=<?php echo e($material->id); ?>&daterange=<?php echo e(request()->get('daterange') ?? date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days'))  . ' - ' . date('Y-m-d')); ?>"
                               class="button is-primary is-small">
                                Download as excel
                            </a>
                        </div>
						<div class="column">
							<input class="input is-small" type="text" name="daterange" value="" />
						</div>
						<div class="column">
							<input name="search" type="submit" class="button is-small is-primary has-background-primary-dark" value="Search"/>
						</div>
					</div>
				<?php echo e(Form::close()); ?>

			</p>
		</header>
		<div class="card-content">
			<div class="card-data">
				<?php if($materials->count() > 0): ?>
					<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
						<tr>
                            <th title="Task date">Task Name</th>
                            <th title="Task date">Task For</th>
                            <th title="Task Type">Task Type</th>
                            <th title="Site Code">Site Code</th>
                            <th title="Project Name">Project Name</th>
                            <th title="Project Manager">Project Manager</th>
                            <th title="Site head">Site Head</th>
                            <th title="Material Amount">Material Amount</th>
                            <th title="Material Qty">Material Qty</th>
                            <th title="Material Note">Material Note</th>
                            <th title="Resource Used">Resource Used</th>
						</tr>
						<?php
							$in_total = [];
						?>

						<?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $task =  \Tritiyo\Task\Models\Task::where('id', $material->task_id)->first();
                            ?>
							<tr>
								<td title="Task ID">
									<a href="<?php echo e(route('tasks.show', $material->task_id)); ?>" target="_blank">
                                        <?php echo e($task->task_name); ?>

									</a>
								</td>
                                <td title="Task date">
                                    <?php echo e($task->task_for); ?>

                                </td>
                                <td>
                                    <?php echo e($task->task_type); ?>

                                </td>
                                <td title="Site Code">
                                    <?php
                                        $siteUsed = \Tritiyo\Task\Models\TaskSite::leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                                                  ->select('sites.site_code')
                                                  ->where('tasks_site.task_id', $material->task_id)
                                                  ->get()->toArray();
                                            echo implode('<br>',array_column($siteUsed, 'site_code'));
                                    ?>
                                </td>

                                <td title="Project Name">
                                    <a href="<?php echo e(route('projects.show', $task->project_id)); ?>"
                                       target="_blank">
                                        <?php echo e(\Tritiyo\Project\Models\Project::where('id', $task->project_id)->first()->name); ?>

                                    </a>
                                </td>

                                <td title="Project Manager">
                                    <a href="<?php echo e(route('hidtory.user', $task->user_id)); ?>" target="_blank">
                                        <?php echo e(\App\Models\User::where('id', $task->user_id)->first()->name); ?>

                                    </a>
                                </td>

								<td title="Task head">
                                    <a href="<?php echo e(route('hidtory.user', $task->site_head)); ?>"  target="_blank">
									    <?php echo e(\App\Models\User::where('id', $task->site_head)->first()->name); ?>

                                    </a>
								</td>

								<td title="Material Amount">
									<?php echo e($in_total[] = $material->material_amount); ?>

								</td>
                                <td title="Material Qty">
                                    <?php echo e($material->material_qty); ?>

                                </td>
                                <td title="Material Note">
                                    <?php echo e($material->material_note); ?>

                                </td>
								<td title="Resource Used">
                                    <?php
                                        $rseourceUse = \Tritiyo\Task\Models\TaskSite::leftJoin('users', 'users.id', 'tasks_site.resource_id')
                                                ->select('users.name')
                                                ->where('task_id', $material->task_id)
                                                ->groupBy('resource_id')
                                                ->get()
                                                ->toArray();
                                        echo implode(',', array_column($rseourceUse, 'name'));
                                        //dump($data);
                                    ?>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>








					</table>
                    <div class="pagination_wrap pagination is-centered">
                        <?php echo e($materials->links('pagination::bootstrap-4')); ?>

                    </div>
				<?php else: ?>

					<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
						<tr>
							<td title="Task date" width="20%">No material used based on your selected date range.</th>
						</tr>
					</table>

				<?php endif; ?>
			</div>
		</div>
	</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('cusjs'); ?>
    <script type="text/javascript"
    src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript"
    src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


	<script>
	$(function() {
	  $('input[name="daterange"]').daterangepicker({
		opens: 'left',
		locale: {
		  format: 'YYYY-MM-DD'
		}
	  }, function(start, end, label) {
		console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	  });
	});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/material/src/views/show.blade.php ENDPATH**/ ?>