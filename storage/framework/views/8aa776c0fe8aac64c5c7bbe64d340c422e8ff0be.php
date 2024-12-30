<?php $__env->startSection('title'); ?>
    Tasks Advanced Search
<?php $__env->stopSection(); ?>

<?php
    if (auth()->user()->isManager(auth()->user()->id)) {
        $addbtn = route('tasks.create');
        $alldatas = route('tasks.index');
    } else {
        $addbtn = '#';
        $alldatas = '#';
    }
?>
<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Tasks Advanced Search',
            'spSubTitle' => 'view a Task',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => false,
            'spAddUrl' => null,
            'spAddUrl' => $addbtn,
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'Tasks',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => false,
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
<div class="card tile is-child xquick_view pt-0">

    <header class="card-header">
        <p class="card-header-title">
            <span class="icon"><i class="fas fa-tasks default"></i></span>
                Task Advanced Search
        </p>
    </header>
    <div class="card-content">
        <div class="card-data">
        <?php echo e(Form::open(array('url' => route('tasks.search'), 'method' => 'GET', 'value' => 'PATCH', 'id' => 'tasks_advanced_search', 'autocomplete' => 'off'))); ?>

            <div class="columns">
                <div class="column is-5">
                    <input type="text" name="key" class="input is-small" id="textboxID" placeholder="Search by any keyword" value="<?php echo e(request()->key ? request()->key : null); ?>" />
                </div>
                <div class="column">
                    <?php
                        $projects = \Tritiyo\Project\Models\Project::get();
                    ?>
                    <select id="task_type" class="input is-small" name="task_type">
                        <option value="">Select task type</option>
                      	<option value="NoneTT">Deselect site head</option>
                        <option value="general" <?php echo e(request()->get('task_type') == 'general' ? 'selected' : ''); ?>>General</option>
                        <option value="emergency" <?php echo e(request()->get('task_type') == 'emergency' ? 'selected' : ''); ?>>Emergency</option>
                    </select>
                </div>
                <div class="column">
                    <?php $projects = \Tritiyo\Project\Models\Project::get(); ?>
                    <select id="project_id" class="input is-small" name="project_id">
                        <option value=""></option>
                      	<option value="NonePrj">Deselect site head</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($data->id); ?> <?php echo e($data->id == request()->get('project_id') ? 'selected' : ''); ?>>
                                <?php echo e($data->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="column">
                    <select id="site_head_id" class="input is-small" name="site_head_id">
                    <?php $resources = \App\Models\User::where('role', '2')->get(); ?>
                        <option value="">Select site head</option>
                      	<option value="None">Deselect site head</option>
                        <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        	<?php if($data->id != 2): ?>
                                <option value=<?php echo e($data->id); ?> <?php echo e($data->id == request()->get('site_head_id') ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="column">
                    <select id="" class="input is-small" name="bill_status">

                        <option value="">Filter By Bill Status</option>

                        <option value='pending_bill'>Pending Bill</option>

                    </select>
                </div>
                <div class="column">
                    <input class="input is-small" type="text" name="daterange" value="<?php echo e(request()->get('daterange') ?? NULL); ?>" />
                </div>
                <div class="column">
                    <input name="search" type="submit" class="button is-small is-primary has-background-primary-dark" value="Search"/>
                </div>
            </div>
        <?php echo e(Form::close()); ?>


        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <tr>
                <th>Task Basic</th>
                <th>Task & Bill Status</th>
                <th>Project and Site Info</th>
                <th>Transaction</th>
            </tr>
            <?php if(!empty($search_result)): ?>
          
          		
          		
          
                <?php $__currentLoopData = $search_result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($task->main_task_id)): ?>
          				<?php $task_status = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->main_task_id)->orderBy('id', 'desc')->first(); ?>
          
                        <?php if(auth()->user()->isManager(auth()->user()->id)): ?>

                            <?php if(auth()->user()->id == $task->user_id): ?>
                                <?php echo $__env->make('task::tasklist.task_search_result_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
          
          				<?php elseif(auth()->user()->isApprover(auth()->user()->id)): ?>
          					<?php if(isset($task_status) && ($task_status->code == 'proof_given' || $task_status->code == 'approver_declined' || $task_status->code == 'task_override_data') ): ?>
          						 <?php echo $__env->make('task::tasklist.task_search_result_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          					<?php endif; ?>
                        <?php else: ?>
                            <?php echo $__env->make('task::tasklist.task_search_result_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
          
          
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">
                        No results found
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <?php
            //dump($search_result);
        ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById('textboxID').select();
</script>
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
    //autoUpdateInput: false,
    locale: {
        format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $('select#project_id').select2({
        placeholder: "Select Project",
        allowClear: true,
    });
    $('select#site_head_id').select2({
        placeholder: "Select Site Head",
        allowClear: true,
    });
    $('select#task_type').select2({
        placeholder: "Select task type",
        allowClear: true,
    });
</script>

    <style type="text/css">
        .table.is-fullwidth {
            width: 100%;
            font-size: 15px;
        }

        .task_status {
            padding: .30rem .50rem;
            margin-bottom: .30rem;
            border: 1px solid transparent;
            border-radius: .25rem;
            font-size: 11px;
        }

        .task_status.success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .task_status.danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/tasklist/search.blade.php ENDPATH**/ ?>