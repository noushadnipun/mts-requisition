<?php $__env->startSection('title'); ?>
      Site Invoices List
<?php $__env->stopSection(); ?>


<?php $__env->startSection('column_left'); ?>
    <div class="column is-10 mx-auto">
        <div class="card tile is-child">          
            <header class="card-header">
                  <p class="card-header-title">
                  <span class="icon">
                      <i class="fas fa-file-invoice"></i>
                  </span>
                  Site Invoice List
                </p>              	
            </header>      
            <div class="card-content">              
                <div class="card-data">
                      <div class="level-right">
                        <div class="level-item ">
                          <form method="get" action="<?php echo e(route('multiple.site.invoices.list')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="field has-addons">
                              <?php /** <a href="{{ route('download_excel_project') }}?id={{ $project->id }}&daterange={{ request()->get('daterange') ?? date('Y-m-d', strtotime(date('Y-m-d'). ' - 30 days')) . ' - ' . date('Y-m-d') }}"
                                     class="button is-primary is-small">
                                    Download as excel
                                  </a>
                                  **/ ?>
                              <div class="control">
                                <input class="input is-small" type="text" name="invoice_no"
                                       value="<?php echo e(request()->get('invoice_no') ?? null); ?>" placeholder="Search with invoice no...">
                              </div>
                              <div class="control">
                                <input name="search" type="submit"
                                       class="button is-small is-primary has-background-primary-dark"
                                       value="Search"/>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
               		<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                      		<tr>
                              		<th>Project Manager</th>
                              		<th>Invoice Info</th>
                              		<th>Project Name</th>
                              		<th>Bill for</th>
                              		<th>Invoice Total Amount</th>
                              		<th>Invoice Date</th>
                              		<th>PO/WO no.</th>
                              		<th>Completion Status</th>
                      		</tr>
                            <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr>
                                          <td><?php echo e(App\Models\User::where('id', $value->action_performed_by)->first()->name ?? NULL); ?></td>
                                          <td>
                                            	<a href="<?php echo e(route('multiple.site.invoice.together.edit.view', $value->id)); ?>?from=list"><?php echo e($value->invoice_info_no ?? NULL); ?></a>
                  						 </td>
                                          <td>
                                            	<?php echo e(Tritiyo\Project\Models\Project::where('id', $value->project_id)->first()->name ?? NULL); ?>

                                    	 </td>
                                          <td>
                                            	<?php
                                            			$start = Tritiyo\Project\Helpers\ProjectHelper::get_range_by_status_key($value->range_status_key, 'Active');
                                            			$end = Tritiyo\Project\Helpers\ProjectHelper::get_range_by_status_key($value->range_status_key, 'Inactive');
                                            	?>
                                            	<?php echo e($start . " - " . ($end ?? date('Y-m-d'))); ?>

                                    	  </td>                                    	
                                          <td><?php echo e($value->invoice_total_amount ?? NULL); ?></td>
                                    	  <td><?php echo e($value->invoice_date ?? NULL); ?></td>
                                    	  <td><?php echo e($value->invoice_powo ?? NULL); ?></td>
                                    	  <td><?php echo e($value->completion_status ?? NULL); ?></td>
                                  </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  	</table>
                    <div class="pagination_wrap pagination is-centered">
                      <?php echo e($lists->links('pagination::bootstrap-4')); ?>

                    </div>
              	</div>
          </div>
      </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/invoices_list.blade.php ENDPATH**/ ?>