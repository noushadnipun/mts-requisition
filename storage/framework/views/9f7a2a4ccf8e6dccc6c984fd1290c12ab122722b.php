<?php if(!empty($task->id)): ?>
    <div class="column is-3 zoom" style="min-width: 20%">
        <div class="borderedCol p-0 <?php echo e($task->task_type == 'emergency' ? 'has-background-danger-light' : ''); ?>"
             style="position: relative;">
            <?php
            $latest = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->where('code', 'approver_approved')->orderBy('id', 'desc')->first();
            $requisition = \Tritiyo\Task\Models\TaskRequisitionBill::where('task_id', $task->id)->first();

            if ($latest) {
                if ($requisition) {
                    $taskEditUrl = url('taskrequisitionbill/' . $requisition->id . '/edit/?task_id=' . $task->id . '&information=requisitionbillInformation');
                } else {
                    $taskEditUrl = url('taskrequisitionbill/create?task_id=' . $task->id . '&information=requisitionbillInformation');
                }
            } else {
                $taskEditUrl = route('tasks.edit', $task->id) . '?task_id=' . $task->id . '&information=taskinformation';
            }

            ?>

            <article class="media" style="display: block">
                <div class="media-content"
                     style="box-shadow: 6px 5px 5px 0px rgb(165 165 165); border-radius: 5px;">

                    <div style="width: 70%" class="is-inline-block content px-3 mt-1 mb-0">
                      
                        <strong title="Task Name">TN: </strong>
                        <a href="<?php echo e(route('tasks.show', $task->id)); ?>" title="View route">
                            <?php echo e($task->task_name); ?>

                        </a>
                        <br/>
                            
                       <small>
                            <strong title="Task ID">ID: </strong>
                            <?php echo e($task->id); ?>

                        </small>
                      <br/>
                      
                        <small>
                            <strong title="Project">PR: </strong>
                            <?php $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first() ?>
                            <a href="<?php echo e(route('projects.show', $task->project_id)); ?>" target="_blank">
                              <?php echo e($project->name); ?>

                            </a>
                        </small>
                        <br/>
                    
                        <small>
                            <strong title="Project Manager">PM: </strong>
                            <?php
                                $project = \Tritiyo\Project\Models\Project::where('id', $task->project_id)->first();
                            ?>
                            <a href="<?php echo e(route('hidtory.user', $project->manager)); ?>" target="_blank">
                                <?php echo e(\App\Models\User::where('id', $project->manager)->first()->name ?? NULL); ?>

                            </a>
                        </small>
                        <br/>
                        <small>
                            <strong title="Site Head">SH: </strong>
                            <?php if(!empty($task->site_head)) { ?>
                            <a href="<?php echo e(route('hidtory.user', $task->site_head)); ?>" target="_blank">
                                <?php echo e(\App\Models\User::where('id', $task->site_head)->first()->name ?? NULL); ?>

                            </a>
                            <?php } ?>
                        </small>
                        <br/>
                     
                        <strong title="Task Type">TT: </strong>
                        <?php echo e($task->task_type ?? NULL); ?>

                        <br/>
                        <strong title="Task Date">TD: </strong>
                        <?php echo e($task->task_for ?? NULL); ?>


                    </div>


                    <div class="is-inline-block onMouseHover<?php echo e($task->id); ?>"
                         style="position: absolute; top: 0px; right: 2px; width: 30%;">

                    </div>


                    <nav class="level is-mobile mb-0 px-3" style="background: #efefef; height: 2em">
                        <div class="level-left">

                            <a href="<?php echo e(route('tasks.show', $task->id)); ?>"
                               class="level-item"
                               title="View task and requisition data">
                                <span class="icon is-small"><i class="fas fa-eye"></i></span>
                            </a>

                            <!-- userAccess() assign to  index.blade   -->
                            <?php if(userAccess('isManager') || userAccess('isApprover') || userAccess('isCFO') || userAccess('isAccountant') || userAccess('isAdmin')): ?>

                                <a href="<?php echo e($taskEditUrl); ?>" class="level-item" title="Edit task and requisition data">
                                    <span class="icon is-info is-small"><i class="fas fa-edit"></i></span>
                                </a>
                                <?php if(auth()->user()->isApprover(auth()->user()->id)): ?>

                                    <?php echo delete_data('tasks.destroy',  $task->id, 'You can delete the task before site head submit proof'); ?>

                                <?php endif; ?>

                                <?php if(auth()->user()->ismanager(auth()->user()->id)): ?>
                                    <?php
                                        $checkProof = \Tritiyo\Task\Models\TaskProof::where('task_id', $task->id)->first();
                                    ?>
                                    <?php if($checkProof): ?>
                                    <?php else: ?>
                                        <?php echo delete_data('tasks.destroy',  $task->id, 'You can delete the task before site head submit proof'); ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <a id="trb"
                               class="level-item is-rounded is-link icon"
                               title="View Total Requisition and Bill"
                                value="<?php echo e($task->id); ?>">
                                <span class="icon is-small tk_button"><i class="fas dfa-dollar-sign">&#2547;</i>

                                </span>
                            </a>
                        </div>


                        <div style="position: relative; right: -12px; top: 0px; text-align: right;">
                            <?php if(!empty($requisition->requisition_approved_by_accountant) && $requisition->requisition_approved_by_accountant == 'Yes'): ?>
                                <?php if(auth()->user()->isResource(auth()->user()->id)): ?>
                                    <?php if($requisition->bill_submitted_by_resource == NULL): ?>
                                        <a href="<?php echo e(route('tasks.add_bill', $task->id)); ?>"
                                           class="tag is-small is-tag is-link is-light is-rounded">
                                            Submit&nbsp;Bill
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if($requisition->bill_submitted_by_resource == 'Yes'): ?>

                                    <?php if($requisition->bill_approved_by_accountant == Null): ?>
                                        <?php if(auth()->user()->isResource(auth()->user()->id) && $requisition->bill_submitted_by_resource == 'Yes'): ?>
                                            <span
                                                class="tag is-small is-tag has-text-light has-background-primary-dark is-rounded">
                                                    Bill Submitted
                                                </span>
                                        <?php elseif(auth()->user()->isManager(auth()->user()->id) && $requisition->bill_approved_by_manager == 'Yes'): ?>

                                            <span
                                                class="tag is-small is-tag has-text-light has-background-primary-dark is-rounded">
                                                    Bill Submitted
                                                </span>
                                        <?php elseif(auth()->user()->isCFO(auth()->user()->id) && $requisition->bill_approved_by_cfo == 'Yes'): ?>
                                            <span
                                                class="tag is-small is-tag has-text-light has-background-primary-dark is-rounded">
                                                    Bill Submitted
                                                </span>
                                        <?php else: ?>

                                            <?php if(auth()->user()->isManager(auth()->user()->id)): ?>
                                                <?php if($requisition->bill_submitted_by_resource == 'Yes'): ?>
                                                    <a href="<?php echo e(route('tasks.add_bill', $task->id)); ?>"
                                                       class="tag is-small is-tag is-link is-dark is-rounded">
                                                        Approve&nbsp;Bill
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if(auth()->user()->isCFO(auth()->user()->id)): ?>
                                                <?php if($requisition->bill_submitted_by_resource == 'Yes' && $requisition->bill_approved_by_manager == 'Yes' ): ?>
                                                    <a href="<?php echo e(route('tasks.add_bill', $task->id)); ?>"
                                                       class="tag is-small is-tag is-link is-dark is-rounded">
                                                        Approve&nbsp;Bill
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if(auth()->user()->isAccountant(auth()->user()->id)): ?>
                                                <?php if($requisition->bill_submitted_by_resource == 'Yes' && $requisition->bill_approved_by_manager == 'Yes' && $requisition->bill_approved_by_cfo == 'Yes' ): ?>
                                                    <a href="<?php echo e(route('tasks.add_bill', $task->id)); ?>"
                                                       class="tag is-small is-tag is-link is-dark xis-rounded">
                                                        Approve&nbsp;Bill
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        <?php endif; ?>


                                    <?php elseif($requisition->bill_approved_by_accountant == 'Yes'): ?>
                                        <span
                                            class="tag is-small is-tag has-text-light has-background-primary-dark is-rounded">
                                            Bill Approved
                                        </span>
                                    <?php endif; ?>

                                <?php endif; ?>
                            <?php endif; ?>


                        </div>

                    </nav>
                    <?php
                        $task_status = \Tritiyo\Task\Models\TaskStatus::where('task_id', $task->id)->orderBy('id', 'desc')->first();
                  		//dump($task_status);
                        $task_decline_reason = \Tritiyo\Task\Models\TaskDecline::where('task_id', $task->id)->orderBy('id', 'desc')->first();
                    ?>
                    <?php if(isset($task_status->message)): ?>
                        <?php if($task_status->code == 'head_declined' || $task_status->code == 'approver_declined' || $task_status->code == 'requisition_declined_by_cfo' || $task_status->code == 'requisition_declined_by_accountant'): ?>
                            <?php
                                $red = 'statusDangerMessage';
                            ?>
                        <?php endif; ?>
                        <div class="<?php echo e(!empty($red) ? $red : 'statusSuccessMessage'); ?> is-block">
                            <?php echo e($task_status->message ?? NULL); ?><br>
                            <?php echo e(!empty($task_decline_reason->decline_reason) &&  $task_status->code == $task_decline_reason->code ? 'Reason:'. $task_decline_reason->decline_reason : Null); ?>

                          	   <?php if(auth()->user()->isAdmin(auth()->user()->id)): ?>
                                  <div class="has-text-black-ter has-text-weight-medium">
                                        Action performed by: <?php echo e(\App\Models\User::where('id', $task_status->action_performed_by)->first()->name); ?>

                                    </div>
                              <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </article>
        </div>
    </div>
<?php endif; ?>



<?php $__env->startSection('cusjs'); ?>
    <style>
        html {
            background: unset;
            background-color: #eee;
        }

        div.content {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        div.content a {
            color: #1a202c;
        }

        .media-content .tag {
            border-radius: 0px;
        }

        .media-content a .icon i {
            color: #728390;
        }

        .borderedCol {
            border-radius: 6px;
        }

        .statusSuccessMessage {
            padding: 5px 8px;
            border-radius: 0px 0px 5px 5px;
            color: #155724;
            background-color: #d1efd3;
            border-color: #c3e6cb;
        }
        .table td, .table th {
            border: 1px solid #e0e0e0;
        }
        .navbar.is-navbar-bg {
            background: linear-gradient(to left bottom, #222b3ad6, #222b3ad6);
            color: #fff;
            backdrop-filter: blur(5px);
        }
        .level-item.is-5 > div > h3 {
            color: #000000;
        }
        .tag:not(body).is-rounded {
            border-radius: 3px;
            margin-right: 2px;
            margin-top: 2px;
            margin-bottom: 2px;
        }
        .zoom {
            transition: transform .2s;
        }
        .zoom:hover {
            transform: scale(1.04);
        }
        .tk_button{
            background: #c8d8f5;
            color: #fff;
            border-radius: 50%;
        }
        .tk_button:hover{
            background: #f0f5c8;
            color: #fff;
            border-radius: 50%;
        }
    </style>
    <script>
        $('a#trb').click(function(){
            //e.preventDefault();
            let taskID = $(this).attr('value');
            $.ajax({
                method: 'GET',
                url:    '<?php echo e(route('total.requisition.bill.index', '')); ?>/'+taskID,
                success: function (data){
                    $('.onMouseHover'+taskID).empty().append(data).slideUp();
                }
            })
        })
    </script>

    <script>
        $('i').mouseover(function(){
            $(this).addClass('fa-pulse')
        })
        $('i').mouseout(function(){
            $(this).removeClass('fa-pulse')
        })
    </script>
<?php $__env->stopSection(); ?>



<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/task/src/views/tasklist/index_template.blade.php ENDPATH**/ ?>