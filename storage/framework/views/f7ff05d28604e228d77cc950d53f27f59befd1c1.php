<?php $__env->startSection('title'); ?>
    Edit Task
<?php $__env->stopSection(); ?>

<section class="hero is-white borderBtmLight">
    <nav class="level">
        <?php echo $__env->make('component.title_set', [
            'spTitle' => 'Edit Task',
            'spSubTitle' => 'Edit a single task',
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
            'spAddUrl' => route('tasks.create'),
            'spAllData' => route('tasks.index'),
            'spSearchData' => route('tasks.search'),
            'spPlaceholder' => 'Search tasks...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </nav>
</section>
<?php $__env->startSection('column_left'); ?>

    <article class="panel is-primary">
        
        
        
        <?php echo $__env->make('task::layouts.tab', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="customContainer">
            <?php echo e(Form::open(array('url' => route('tasks.update', $task->id), 'method' => 'PUT', 'value' => 'PATCH', 'id' => 'add_route', 'class' => 'task_table', 'files' => true, 'autocomplete' => 'off'))); ?>


            <?php echo e(Form::hidden('task_type', $task->task_type ?? '')); ?>

            <?php echo e(Form::hidden('task_assigned_to_head', $task->task_assigned_to_head != null ?? 'Yes')); ?>


            <div class="columns">

                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('project_id', 'Project', array('class' => 'label', 'style' => 'display: inline-block'))); ?>


                        <div class="control">
                            <?php if(auth()->user()->isManager(auth()->user()->id) || auth()->user()->isHR(auth()->user()->id)): ?>
                                <?php $projects = \Tritiyo\Project\Models\Project::where('manager', auth()->user()->id)->pluck('name', 'id')->prepend('Select Project', ''); ?>
                            <?php else: ?>
                                <?php $projects = \Tritiyo\Project\Models\Project::pluck('name', 'id')->prepend('Select Project', ''); ?>
                            <?php endif; ?>
                            <?php //$projects = \Tritiyo\Project\Models\Project::pluck('name', 'id')->prepend('Select Project', ''); ?>
                            <?php echo e(Form::select('project_id', $projects, $task->project_id ?? NULL, ['class' => 'input', 'id' => 'project_select'])); ?>

                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('site_head', 'Site Head', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php
                            /**
                            $today = date('Y-m-d');
                            $current_user = auth()->user()->id;
                            //$siteHead = \App\Models\User::where('role', 2)->get();
                            $siteHead = \DB::select("SELECT * FROM (SELECT *, (SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS site_head,
                                    (SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND DATE_FORMAT(`tasks`.`created_at`, '%Y-%m-%d') = '$today') AS manager,
                                    (SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND DATE_FORMAT(`tasks_site`.`created_at`, '%Y-%m-%d') = '$today' GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                                    users.id AS useriddddd
                                FROM users WHERE users.role = 2) AS mm WHERE mm.site_head IS NULL AND mm.resource_used IS NULL");
                            **/
                            $task_type = $task->task_type;
                            if($task_type == 'emergency') {
                            		/** if(request()->get('type') == 'emergency') { **/
                				$date = date('Y-m-d');
            				} else {
                				$date = date("Y-m-d", strtotime("+1 day"));
            				}

                            $siteHead = \DB::select("SELECT * FROM (SELECT *,
                              			(SELECT site_head FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$date' LIMIT 0,1) AS site_head,
                                    	(SELECT user_id FROM tasks WHERE tasks.site_head = users.id AND tasks.task_for = '$date' LIMIT 0,1) AS manager,
                                    	(SELECT resource_id FROM tasks_site WHERE tasks_site.resource_id = users.id AND tasks_site.task_for = '$date' GROUP BY tasks_site.site_id LIMIT 0,1) AS resource_used,
                                    	users.id AS useriddddd
                                FROM users WHERE users.role = 2 AND users.employee_status  NOT IN ( 'Terminated', 'Left Job', 'Long Leave', 'On Hold')
                            ) AS mm WHERE mm.site_head IS NULL AND mm.resource_used IS NULL");


                            ?>
                            <select class="input" name="site_head" id="sitehead_select">
                                <option value="<?php echo e($task->site_head ?? NULL); ?>" selected>
                                    <?php echo e(\App\Models\User::where('id', $task->site_head)->first()->name ?? NULL); ?>

                                </option>
                                <?php $__currentLoopData = $siteHead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $count_result = \Tritiyo\Task\Helpers\TaskHelper::getPendingBillCountStatus($resource->id);
                                    ?>
                                    <option
                                        data-result="<?php echo e($count_result); ?>"
                                        value="<?php echo e($resource->id); ?>" <?php echo e($resource->id == $task->site_head ? 'selected=""' : NULL); ?>>
                                        <?php echo e($resource->name ?? NULL); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>


                            <?php //$siteHead = \App\Models\User::where('role', 2)->pluck('name', 'id')->prepend('Select Site Head', ''); ?>
                            
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <?php echo e(Form::label('task_name', 'Task Name', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::text('task_name', $task->task_name ?? NULL, ['class' => 'input is-small', 'placeholder' => 'Enter Task Name...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-9">
                    <div id="remaining_project_budget">

                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-9">
                    <div class="field">
                        <?php echo e(Form::label('task_details', 'Task Details', array('class' => 'label'))); ?>

                        <div class="control">
                            <?php echo e(Form::textarea('task_details', $task->task_details ?? NULL, ['class' => 'textarea', 'rows' => 5, 'placeholder' => 'Enter task details...'])); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control button-save">
                            <button id="task_create_btn" class="button is-success is-small">Save Changes</button>
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
        $task = \Tritiyo\Task\Models\Task::where('id', $task->id)->first();
    ?>

    <?php echo $__env->make('task::task_status_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('cusjs'); ?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script>
        $('#sitehead_select').select2({
            placeholder: "Select Head of Site",
            //allowClear: true
        });
        $('#project_select').select2({
            placeholder: "Select Project",
            //allowClear: true
        });
    </script>


    
    
    
    
     <script>
        $('select#sitehead_select').on('change', function () {
            $('button#task_create_btn').attr('style', 'display:none');
            var v = $(this).find(':selected').attr('data-result')
            if (v == 'Yes') {
                alert('Your selected resource has atleast 3 pending bills. You can\'t select this resource.');
                $('button#task_create_btn').attr('style', 'display:none');
                 //$("#project_select").select2().val(null).trigger("change");
                 $("#sitehead_select").select2().val(null).trigger("change");
            }
            if (v == 'No') {
                $('button#task_create_btn').attr('style', 'display:block');
            }
        })
    </script>


    <script>
        //Remain Budget Balanace of a project
        $('#project_select').change(function(){
            $("button#task_create_btn").attr('style', 'display: none');
            //alert($(this).val());
            $(".tap2").show();
            $(".tap1").show();
            
            let projectId = $(this).val();
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('project.remain.balance', '')); ?>/"+projectId,
                success: function(data){
                   // console.log(data);
                    let html = '<div class="statusSuccessMessage is-warning mb-2" style="height: 26px; display: block; padding: 11px;">'
                    html += '<div class="columns">';
                    html += '<div class="column is-4 has-text-weight-bold">Total Balance BDT '+data.total;
                    html += '</div>';
                    html += '<div class="column is-4has-text-centered has-text-weight-bold">Usage Balance BDT '+data.usage;
                    html += '</div>';
                    html += '<div class="column is-4 has-text-right has-text-weight-bold">Remaining Balance BDT '+data.remain;
                    html += '</div>';
                    html += '</div></div>';
                    $(".tap2").hide();
                    $(".tap1").hide();
                    $("#remaining_project_budget").empty().append(html);
                        
                  
                   let projectLockPercent = "<?php echo e(\Tritiyo\Project\Helpers\ProjectHelper::projectLockPercentage()); ?>"; 
                  
                    if(data.usage * 100 / data.total >= projectLockPercent){
                        alert('Already you have used '+projectLockPercent+'% of budget. So you can not create any task under this project.')
                        $('a#closeBtn').click(function(e){
                        	e.preventDefault();
                            $(".tap2").attr('style', 'display:none');
                   			 $(".tap1").attr('style', 'display:none');
                        })
                        $("#task_create_btn").attr('style', 'display: none');
                             $("#project_select").select2().val(null).trigger("change");
                 			//$("#sitehead_select").select2().val(null).trigger("change");
                    } else {
                        $("#task_create_btn").attr('style', 'display: block');
                        //$(".control").attr('style', 'display: block');
                    }

                    if(data.total == 0){
                        alert('Budget has not assigned in this project yet');
                        $("#task_create_btn").attr('style', 'display: none');
                        $("#project_select").select2().val(null).trigger("change");
                        //$("#sitehead_select").select2().val(null).trigger("change");
                    } else {
                        //$("#task_create_btn").attr('style', 'display: block');
                    }
                }
            })
        })

    </script>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/edit.blade.php ENDPATH**/ ?>