<?php $__env->startSection('title'); ?>
    Include site information for task
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'include Site Of Task',
            'spSubTitle' => 'Add a Site of task',
            'spShowTitleSet' => true
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spTitle' => 'Tasks',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>
    <article class="panel is-primary" id="app">
        <?php
        $task_id = request()->get('task_id');
        if (empty($taskSites)) {
            $taskId = $task_id; //taskId variable asign in tasksite controller
        }
        //$taskId = !empty($task_id) ?? $task_id;
        ?>

        <?php echo $__env->make('task::layouts.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="customContainer">
            <?php
            if (!empty($tasksite) && $tasksite->id) {
                $routeUrl = route('tasksites.update', $task->id);
                $method = 'PUT';
            } elseif (!empty($taskId)) {
                $routeUrl = route('tasksites.update', $taskId);
                $method = 'PUT';
            } else {
                $routeUrl = route('tasksites.store');
                $method = 'post';
            }
            ?>
            <?php echo e(Form::open(array('url' => $routeUrl, 'method' => $method, 'value' => 'PATCH', 'id' => 'add_route', 'class' => 'task_site_table',  'files' => true, 'autocomplete' => 'off'))); ?>


            <?php if($task_id): ?>
                <?php echo e(Form::hidden('task_id', $task_id ?? '')); ?>

            <?php endif; ?>
            <?php if(!empty($taskId)): ?>
                <?php echo e(Form::hidden('task_id', $taskId ?? '')); ?>

            <?php endif; ?>

            <div class="columns">
                <div class="column is-6">

                    <div class="field">

                        <?php echo e(Form::label('site_id', 'Sites', array('class' => 'label'))); ?>

                        <div class="control">
                            <div dclass="select is-multiple">
                                <?php
                                    $projectId = \Tritiyo\Task\Models\Task::where('id', $task_id)->first()->project_id;

                                  $sites = \Tritiyo\Site\Models\Site::where('project_id', $projectId)
                                                        ->where(function($query){
                                                        $query->whereNull('completion_status')
                                                        ->orWhere('completion_status',  'Running');
                                                        })
                                                        ->get();
                                ?>
                                <select id="site_select" multiple="multiple" name="site_id[]" class="input" required>
                                    <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option id="site<?php echo e($site->id); ?>" value="<?php echo e($site->id); ?>" data-result="<?php echo e($site->id); ?>"

                                        <?php if(isset($taskSites)): ?>
                                            <?php $__currentLoopData = $taskSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($data->site_id == $site->id ? 'selected' : ''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        ><?php echo e($site->site_code); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <div class="field">
                        <?php echo e(Form::label('resource_id', 'Site Resources', array('class' => 'label'))); ?>

                        <div class="control">
                            <div sclass="select is-multiple">

                                <?php
                                    $task_type = \Tritiyo\Task\Models\Task::where('id', $task_id)->first()->task_type;
                                    if($task_type == 'emergency') {
                                        $date = date('Y-m-d');
                                    } else {
                                        $date = date("Y-m-d", strtotime("+1 day"));
                                    }

                                    $resources = \DB::select("SELECT * FROM (SELECT *,
                                                (SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$date'   LIMIT 0,1) AS site_head,
                                                (SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$date'   LIMIT 0,1) AS manager,
                                                (SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND tasks_site.task_for = '$date'
                                                GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                                                users.id AS useriddddd
                                        FROM users WHERE users.role = 2 AND users.employee_status  NOT IN ( 'Terminated', 'Left Job', 'Long Leave', 'On Hold')
                                    ) AS mm WHERE mm.site_head IS NULL AND mm.resource_used IS NULL ORDER BY id ASC");
                                ?>
                                <select id="resource_select" multiple="multiple" name="resource_id[]" class="input" required>
                                    <option value="2" data-resultx="No">None</option>
                                    <?php
                                        $all_resources = \Tritiyo\Task\Models\TaskSite::where('task_id', $task_id)->groupBy('resource_id')->get();
                                    ?>


                                    <?php $__currentLoopData = $all_resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $count_result = \Tritiyo\Task\Helpers\TaskHelper::getPendingBillCountStatus($resource->id);
                                        ?>
                                        <option value="<?php echo e($resource->resource_id); ?>"
                                                data-result="<?php echo e($count_result ?? NULL); ?>" selected>
                                            <?php echo e(\App\Models\User::where('id', $resource->resource_id)->first()->name ?? NULL); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $count_result = \Tritiyo\Task\Helpers\TaskHelper::getPendingBillCountStatus($resource->id);
                                        ?>
                                        <option value="<?php echo e($resource->id); ?>" data-resultx="<?php echo e($count_result ?? NULL); ?>"
                                        <?php if(isset($taskSites)): ?>
                                            <?php $__currentLoopData = $taskSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($data->resource_id == $resource->id ? 'selected' : ''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?> >
                                            <?php echo e($resource->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control button_set">

                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </article>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>
    <?php
        $task = \Tritiyo\Task\Models\Task::where('id', $taskId)->first();
    ?>
    <?php echo $__env->make('task::task_status_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('cusjs'); ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#resource_select').select2({
                placeholder: "Select Resource",
                allowClear: true,
            });
            $('#site_select').select2({
                placeholder: "Select Site",
                allowClear: true
            });
        });
    </script>


    <script>

        $('select#resource_select').on('select2:select', function (e) {
            // let v = $(this).find(':selected').data("resultx");
            //let v = $(this).find(':selected:last').val()
            //console.log("select2:select", e);
            $('.button_set').empty();
            if (!e) {
                var args = "{}";
            } else {
                var args = JSON.stringify(e.params, function (key, value) {
                    if (value && value.nodeName) return "[DOM node]";
                    if (value instanceof $.Event) return "[$.Event]";
                    //console.log(value.data);
                    let resourceId = value.data.id;
                    let name = value.data.text;
                    $.ajax({
                        type: "GET",
                        url: "<?php echo e(route('project.check.resource.pending.bills', '')); ?>/" + resourceId,
                        success: function (data) {
                            if (data == 'Yes') {
                                //console.log(value.data.text);
                                alert(value.data.text+'<br/>Your selected resource has atleast 3 pending bills. You can\'t select this resource.');
                                $('.button_set').empty();
                                $('#closeBtn').click(function(){
                                    $('#resource_select option[value=' +resourceId+ ']:selected').prop('selected', false);
                                    $("#resource_select").select2();
                                })
                            }else{
                                let submitBtn = ' <button id="task_create_btn" class="button is-success is-small">Save Changes</button>';
                                $('.button_set').empty().append(submitBtn);
                            }

                        }
                    })

                });
            }
        });

        $('select#site_select').on('change', function () {
            //let siteId = $(this).find(':selected').attr('data-result');
            $('.button_set').empty();
            let siteId = $(this).find(':selected:last').val();
            //alert(siteId);
            console.log(siteId);
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('project.check.limit.site', '')); ?>/" + siteId,
                success: function (data) {
                    if (data == 'false') {
                        console.log(data);
                        alert('You exceeded limit of task for this site.');
                        $('.button_set').empty();
                        $('#closeBtn').click(function(){
                            $('#site_select option[value = ' + siteId + ']').prop('selected', false);
                            $("#site_select").select2();
                        })
                    }
                    if (data == 'true') {
                        let submitBtn = ' <button id="task_create_btn" class="button is-success is-small">Save Changes</button>';
                        $('.button_set').empty().append(submitBtn);
                    }
                }
            })
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/tasksite/create.blade.php ENDPATH**/ ?>