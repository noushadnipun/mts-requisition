<?php $__env->startSection('title'); ?>
    Sites
<?php $__env->stopSection(); ?>
<?php $__env->startSection('full_width_content'); ?>

    <?php
        $todayDate = date('Y-m-d');
        $last2DaysDate = date('Y-m-d', strtotime($todayDate. ' - 1 days'));
        $manager_id = auth()->user()->id;

        //dd($last2DaysDate);
        $sites = Tritiyo\Task\Models\Task::leftjoin('tasks_site', 'tasks_site.task_id', 'tasks.id')
                                    ->leftjoin('sites', 'sites.id', 'tasks_site.site_id')
                                    ->select('tasks.id as task_id', 'tasks.task_for as task_for', 'tasks_site.site_id as site_id', 'sites.*')
                                    ->where('tasks.user_id', $manager_id)
                                    ->where('sites.completion_status', 'Running')
                                    ->where(function ($query) {
                                        $query->where('sites.site_type',  NULL)
                                              ->orWhere('sites.site_type',  'Fresh')
                                              ->orWhere('sites.site_type',  'Old');
                                    })
                                    //->where('tasks.task_for', [$last2DaysDate, $todayDate])
                                    ->where('tasks.task_for', '<', $last2DaysDate)
                                    ->groupBy('tasks_site.site_id')
                                    ->get();
        //dd($sites);
    ?>
                                      
                                      
    <?php if(count($sites) > 0): ?>
        <div class="columns mt-5">
            <div class="column is-10 mx-auto">
                <article class="message is-warning">
                    <div class="message-body">
                        আপনি এই প্যানেল থেকে সাইটের কাজ শেষ হয়েছে কিনা সেই স্ট্যাটাস হালনাগাদ করতে পারবেন। এখান থেকে
                        আপনি প্রথমে সাইট গুলোর পাশে থাকা চেকবক্স চেক করে সাবমিট এজ কমপ্লিট বাটন চাপ দিয়েই স্ট্যাটাস
                        হালনাগাদ করতে পারবেন। তবে যদি দেখুন প্রতিটি সাইট এখনো রানিং অবস্থায় আছে সেক্ষেত্রে সিলেক্ট অল
                        চেক দিয়ে সাবমিট এজ রানিং দিয়ে দেয়ার মাধ্যমে সাইটের স্ট্যাটাস হালনাগাদ করতে পারবেন।
                    </div>
                </article>


                <form action="<?php echo e(route('site.status.update')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="columns is-multiline mt-3">
                        <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="column is-2">
                                <div class="borderedCol has-background--light">
                                    <label class="checkbox"
                                           style="display: block; -webkit-box-align: center;-ms-flex-align: center; align-items: center;">
                                        <div class="columns">
                                            <div class="column is-2">
                                                <input type="hidden" value="<?php echo e($manager_id); ?>"
                                                       name="batch_status_update[<?php echo e($key); ?>][user_id]">
                                                <input type="hidden" value="<?php echo e($site->task_id); ?>"
                                                       name="batch_status_update[<?php echo e($key); ?>][task_id]">
                                                <input type="hidden" value="<?php echo e($site->task_for); ?>"
                                                       name="batch_status_update[<?php echo e($key); ?>][task_for]">
                                                <input type="checkbox" value="<?php echo e($site->site_id); ?>"
                                                       class="status_update_all"
                                                       name="batch_status_update[<?php echo e($key); ?>][site_id]">
                                            </div>
                                            <div class="column is-10">
                                                <strong>Site Code: </strong>
                                                <?php echo e($site->site_code); ?>

                                                <br/>
                                                <strong>Location: </strong>
                                                <?php echo e($site->location); ?>

                                                <br/>

                                                <strong>Status: </strong>
                                                <?php echo e($site->completion_status); ?>

                                                <br/>
                                                <strong>Project: </strong>
                                                <?php
                                                    $project = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()
                                                ?>
                                                <?php echo e($project->name); ?>

                                                <br/>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <label for="select_all" class="button is-small ml-2">
                        <input type="checkbox" id="select_all" class="mr-1"> Select All
                    </label>
                    <input xtype="button" class="button sc is-link is-small"  value="Submit as completed" />

                    <input xtype="button" class="button sr is-link is-light is-small"  value="Submit as Running">
                </form>
            </div>
        </div>
    <?php else: ?>
        <?php echo redirect()->route('dashboard'); ?>
    <?php endif; ?>

    <?php  //dump($t); ?>
    <script>
        document.getElementById('select_all').onclick = function () {
            var checkboxes = document.getElementsByClassName('status_update_all');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
                                      
      
    </script>

<?php $__env->stopSection(); ?>
                                      
                                      
<?php $__env->startSection('cusjs'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
 <script>   
         $('input.sc').on("click", function(){
            if ($('.status_update_all').is(':checked')) {
              $('input.sr').attr('name', '')
           	  $(this).attr('name', "status_completed")
              confirmAlert('Are you sure to confirm Your selected sites has been completed')  
            }else {
              alert('You did not select any site');
            }
         })
                                      
         $('input.sr').on('click', function(){
           //alert('ok');
           //let s = $('.status_update_all').is(':checked');
            if ($('.status_update_all').is(':checked')) {
           		$('input.sc').attr('name', '')
           		$(this).attr('name', "status_running")
              	confirmAlert('Are you sure Your selected sites are still running')
            }else {
              alert('You did not select any site');
            }
         })                 
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.noapp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/site_status_update.blade.php ENDPATH**/ ?>