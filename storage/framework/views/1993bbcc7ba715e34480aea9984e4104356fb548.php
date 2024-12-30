<div class="column is-2">
    <?php
    if ($site->completion_status == 'Rejected') {
        $siteStatus = 'danger';
    } elseif ($site->completion_status == 'Completed') {
        $siteStatus = 'completed';
    } elseif ($site->completion_status == 'Running') {
        $siteStatus = 'running';
    } else {
        $siteStatus = '';
    }
  
  
  	$checkSiteInvoice = DB::table('site_invoices')->where('site_id', $site->id)->get();
  	if(count($checkSiteInvoice) > 0){
    	$hasSiteInvoice = 'border: 6px solid #ff9800';
    }
    ?>
    <div class="borderedCol <?php echo e($siteStatus); ?>" style="<?php echo e($hasSiteInvoice ?? null); ?>">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>
                            <strong>Code: </strong>
                            <a href="<?php echo e(route('sites.show', $site->id)); ?>"
                               title="View site">
                                <?php echo e($site->site_code); ?>

                            </a>
                        </strong>
                        <br/>

                        <small>
                            <strong>Location: </strong>
                            <?php echo e($site->location); ?>

                            <br/>
                            <strong>Project: </strong>
                            <?php
                                $project = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()
                            ?>
                            <a href="<?php echo e(route('projects.show', $site->project_id)); ?>"
                               target="_blank"
                               title="View project">
                                <?php echo e($project->name); ?>

                            </a>
                            <br/>
                            <strong>Project Manager:</strong>
                            <?php
                                $pm = \Tritiyo\Project\Models\Project::where('id', $site->project_id)->first()->manager;
                                $pm_name = \App\Models\User::where('id', $pm)->first()->name;
                            ?>
                            <a href="<?php echo e(route('hidtory.user', $pm)); ?>"
                               target="_blank"
                               title="View project manager">
                                <?php echo e($pm_name); ?>

                            </a>
                            <br/>
                            <strong>Task Created: </strong>
                            <?php echo e($site->created_at); ?>

                            <br/>
                            <strong>Status: </strong>
                            <?php echo e($site->completion_status ?? NULL); ?>

                          	<br>
                          <?php if(count($checkSiteInvoice) > 0): ?>
                          <strong>Total Invoice </strong>
                          <?php echo e(count($checkSiteInvoice)); ?>

                          <?php endif; ?>
                        </small>
                        <br/>
                    </p>
                </div>
                <nav class="level is-mobile">
                    <div class="level-left">
                        <a href="<?php echo e(route('sites.show', $site->id)); ?>"
                           class="level-item"
                           title="View user data">
                            <span class="icon is-small"><i class="fas fa-eye"></i></span>
                        </a>
                        <?php if(auth()->user()->isApprover(auth()->user()->id)): ?>
                            <?php if($site->completion_status == 'Completed'): ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('sites.edit', $site->id)); ?>"
                                   class="level-item"
                                   title="View all transaction">
                                <span class="icon is-info is-small">
                                    <i class="fas fa-edit"></i>
                                </span>
                                </a>
                            <?php endif; ?>
                      	<?php elseif(auth()->user()->isAdmin(auth()->user()->id)): ?>
                      	  		<a href="<?php echo e(route('sites.edit', $site->id)); ?>"
                                   class="level-item"
                                   title="View all transaction">
                                <span class="icon is-info is-small">
                                    <i class="fas fa-edit"></i>
                                </span>
                                </a>
                        <?php endif; ?>
						<?php if(auth()->user()->isAdmin(auth()->user()->id)): ?>
                             <?php echo delete_data('sites.destroy',  $site->id); ?>

                      	<?php endif; ?>
                    </div>
                </nav>
            </div>
        </article>
    </div>
</div>
<?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/index_template.blade.php ENDPATH**/ ?>