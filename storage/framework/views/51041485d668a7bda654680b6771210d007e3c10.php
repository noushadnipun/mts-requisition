<?php $__env->startSection('title'); ?>
    Site import
<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_left'); ?>

    <div class="card tile is-child">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="fas fa-tasks default"></i></span>
                Site import
              <form method="post" action="<?php echo e(route('sites.import.excel')); ?>" enctype="multipart/form-data" class="m-0">
                <?php echo csrf_field(); ?>
                <a href="<?php echo e(asset('/downloads/site-import-format-download.xlsx')); ?>">Excel Format Download</a>
                    <input type="submit" name="reset" value="Reset" class="button is-small is-warning mt-0">
              </form>
            </p>
        </header>
        <div class="card-content">
            <div class="control">
                <form method="post" action="<?php echo e(route('sites.import.excel')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <p>Upload Excel File</p>
                    <input type="file" name="import" class="input is-samll" required>
                    <input type="submit" name="upload" value="Upload" class="button is-small is-link mt-2">
                </form>
            </div>

            <?php if(session()->get('siteunmatched')): ?>
                <form method="post" action="<?php echo e(route('sites.unmatched.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth mt-2">
                        <tr>
                            <th class="has-background-primary-dark" colspan="7">New Site Found (<?php echo e(count(session()->get('siteunmatched'))); ?>)</th>
                            <td><button type="submit" class="button is-small is-link">Insert</button></td>
                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Site Code</th>
                            <th>Location</th>
                            <th>Project Id</th>
                            <th>Task Limit</th>
                        </tr>
                        <?php $__currentLoopData = session()->get('siteunmatched'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e(++$key); ?>

                                </td>
                                <td>
                                    <input type="hidden" name="unmatched[<?php echo e($key); ?>][site_code]" value="<?php echo e($data['site_code']); ?>">
                                    <?php echo e($data['site_code']); ?>

                                </td>
                                <td>
                                    <input type="hidden" name="unmatched[<?php echo e($key); ?>][location]" value="<?php echo e($data['location']); ?>">
                                    <?php echo e($data['location']); ?>

                                </td>
                                <td>
                                    <input type="hidden" name="unmatched[<?php echo e($key); ?>][project_id]" value="<?php echo e($data['project_id']); ?>">
                                    <input type="hidden" name="unmatched[<?php echo e($key); ?>][pm]" value="<?php echo e($data['pm']); ?>">
                                    <?php echo e($data['project_id']); ?>

                                </td>

                                <td>
                                    <?php if(!empty($data['task_limit'])): ?>
                                        <input type="hidden" name="unmatched[<?php echo e($key); ?>][task_limit]" value="<?php echo e($data['task_limit']); ?>">
                                        <?php echo e($data['task_limit']); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </form>
            <?php endif; ?>
			<?php if(session()->get('matechedSiteButNotPending')): ?>
          		 <?php $__currentLoopData = session()->get('matechedSiteButNotPending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          			 <div class="has-background-danger-light mb-2 p-2"><?php echo $data['message']; ?></div>
          		 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          	<?php endif; ?>

            <?php if(session()->get('sitematched')): ?>
                <?php //dd(session()->get('sitematched'));?>
                <form method="post" action="<?php echo e(route('sites.matched.update')); ?>">
                    <?php echo csrf_field(); ?>
                    <table class="table is-bordered is-striped is-narrow is-fullwidth is-hoverable mt-2">
                        
                        <?php if(!empty(session()->get('sitematched')[0]['message'])): ?>
                        <?php else: ?>
                      <tr>
                            <th class="has-background-danger-dark" colspan="7">Existing Pending Site Found (<?php echo e(count(session()->get('sitematched'))); ?>)</th>
                        </tr>
                            <tr>
                                <th class="">Site Code</th>
                                <th class="has-background-warning-dark">Completion Status</th>
                                <th class="has-background-warning-dark">Pending Note</th>
                                <th class="has-background-warning-dark">Project Id</th>
                                <th>Task Limit</th>
                                <th class="">Site Type</th>
                                <th class="">Activity Details</th>
                            </tr>
                            <?php $__currentLoopData = session()->get('sitematched'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(!empty($data['message']) && $data['message']): ?>
                                        <td><?php echo e($data['site_code']); ?></td>
                                        <td colspan="5"><?php echo e($data['message']); ?></td>
                                    <?php else: ?>
                                        <input type="hidden" name="matched[<?php echo e($key); ?>][site_id]" value="<?php echo e($data['site_id']); ?>" />
                                        
                                        <td><?php echo e($data['site_code']); ?></td>
                                        <td><?php echo e($data['completion_status']); ?></td>
                                        <td><?php echo e($data['pending_note']); ?></td>
                                        <td>
                                            <input type="hidden" name="matched[<?php echo e($key); ?>][project_id]" value="<?php echo e($data['project_id']); ?>">
                                            <input type="hidden" name="unmatched[<?php echo e($key); ?>][pm]" value="<?php echo e($data['pm']); ?>">
                                            <?php echo e($data['project_id']); ?>

                                        </td>
                                        <td>
                                            <input type="hidden" name="matched[<?php echo e($key); ?>][task_limit]" value="<?php echo e($data['task_limit']); ?>">
                                            <?php echo e($data['task_limit']); ?>

                                        </td>
                                        <td>
                                            <select name="matched[<?php echo e($key); ?>][site_type]" class="input is-small" required>
                                                <option value="">select</option>
                                                <option value="Fresh">Fresh</option>
                                                <option value="Old">Old</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="input is-small" name="matched[<?php echo e($key); ?>][activity_details]">
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      <tr>
                            
                            <?php if(!empty(session()->get('sitematched')[0]['message'])): ?>
                         		 <th class="has-background-danger-dark" colspan ="7"><?php echo session()->get('sitematched')[0]['message']; ?></th>
                            <?php else: ?>
                        		<td colspan="6">&nbsp;</td>
                                <td style="text-align: end"><button type="submit" class="button is-small is-link">update</button></td>
                            <?php endif; ?>
                        </tr>
                    </table>
                </form>
            <?php endif; ?>

        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('column_right'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/import.blade.php ENDPATH**/ ?>