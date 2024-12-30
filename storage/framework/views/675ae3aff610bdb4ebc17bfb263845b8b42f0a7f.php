<?php $__env->startSection('title'); ?>
    Multiple Site Invoice Generate Together
<?php $__env->stopSection(); ?>


<?php $__env->startSection('column_left'); ?>
	<?php
			$list = request()->get('from');
			if($list == 'list') {
					$check = TRUE;
			} else {
					$check = FALSE;
			}
	?>

    <div class="column is-10 mx-auto">
        <div class="card tile is-child">
            <header class="card-header">
                <p class="card-header-title">
                <span class="icon">
                    <i class="fas fa-file-invoice"></i>
                </span>
                     <?php echo e(($check == TRUE) ? 'Site Invoice List' : 'Site Invoice Generate Together'); ?>

                </p>
            </header>
            <div class="card-content">
                <div class="card-data">
                  	<div class="columns">
                      	<div class="column is-7">
                          <section class="hero is-">
                            <div class="hero-body">
                              <h1 style="font-size: 20px;"><?php echo e(($check == TRUE) ? 'Site Invoice List' : 'Invoices created'); ?></h1>
                              <h2 style="font-size: 15px;"><?php echo e(($check == TRUE) ? 'You just can see the invoices here' : 'Now, Please edit invoices as you need'); ?></h2>
                            </div>
                          </section>
                        </div>
                      	<div class="column is-3">
                          	<table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                              	<tbody>
                                  	<tr>
                                      	<td>
                                          		<b>Project Name:</b>
                                                <?php
                                                      $project_name = \Tritiyo\Project\Models\Project::where('id', $invoiceInfo->project_id)->first()->name;
                                                ?>
                                                <?php echo e($project_name ?? NULL); ?>

                                      	</td>
                                  	</tr>
                                 	<tr>
                                      	<td>
                                          		<b>Invoice Date:</b>
                                          		<?php echo e($invoiceInfo->invoice_date ?? NULL); ?>

                                      	</td>
                                  	</tr>
                                  	<tr>
                                      	<td>
                                          		<b>Created Date:</b>
                                          		<?php echo e($invoiceInfo->created_at ?? NULL); ?>

                                      	</td>
                                  	</tr>
                                  	<tr>
                                      	<td>                                          		
                                          		<b>PO/WO No.:</b>
                                          		<?php echo e($invoiceInfo->invoice_powo ?? NULL); ?>

                                      	</td>
                                  	</tr>
                                    <tr>
                                          <td>                                          		
                                                  <b>Invoice No.:</b>
                                            	 <?php echo e($invoiceInfo->invoice_info_no ?? NULL); ?>

                                          </td>
                                      </tr>
                                      <tr>
                                            <td>                                          		
                                                    <b>Total Amount:</b>
                                              		<?php echo e($invoiceInfo->invoice_total_amount ?? NULL); ?>

                                            </td>
                                        </tr>
                              	</tbody>
                          	</table>
                        </div>
                      	<div class="column is-3">
                          	&nbsp;
                      	</div>
                  </div>
                  
                  
                  <?php
                      $route =  route('multiple.site.invoice.together.update');
                      $total = Tritiyo\Site\Models\SiteInvoice::where('invoice_no', $invoiceInfo->invoice_info_no)->get()->sum('invoice_amount');
                                    
                      $tot = number_format($total, 2);
                      $invoiceInfoTotal = number_format($invoiceInfo->invoice_total_amount, 2);                          			
                  ?>
                  
                  <?php if($invoiceInfo->completion_status == 'Done'): ?>
                  
                  <?php else: ?>
                      <?php if($tot == $invoiceInfoTotal): ?>                          			
                  			<?php echo e(Form::open(array('url' => route('invoice.edit.done'), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

                      <?php else: ?>
							<?php echo e(Form::open(array('url' => $route, 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_route', 'files' => true, 'autocomplete' => 'off'))); ?>

                      <?php endif; ?>
                  <?php endif; ?>
                  
                  
                  <div class="columns">
                      	<div class="column is-9">                          		
                                  <div class="reload_me">                    	
                                          <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                                            <tbody>
                                                <tr>
                                                    <th width="350">Project Name</th>
                                                    <th width="180">Site Name</th>
                                                    <th width="100">Invoice No.</th>
                                                    <th width="100">Invoice Date</th>
                                                    <th width="100">Invoice Amount</th>
                                                    <th width="100">Invoice Type</th>
                                                </tr>
                                              	<?php
                                              			$i_total = [];
                                              	?>
                                                <?php $__currentLoopData = $invoiceSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              	 <input type="hidden" name="invoiceNo[]" value="<?php echo e($value->id); ?>" />
                                                <tr>
                                                    <td>                                                      
                                                      <?php
                                                            $project = \Tritiyo\Project\Models\Project::where('id', $value->project_id)->get()->first();
                                                      ?>
                                                      <?php echo e($project->name); ?>

                                                    </td>
                                                    <td>
                                                      <?php
                                                            $sites = \Tritiyo\Site\Models\Site::where('id', $value->site_id)->latest()->first()
                                                      ?>
                                                      <?php echo e($sites->site_code); ?>

                                                    </td>
                                                    <td><?php echo e($value->invoice_no); ?></td>
                                                    <td><?php echo e($value->invoice_date); ?></td>
                                                    <td>
                                                      <?php
                                                      	if($invoiceInfo->completion_status == 'Done') {
                                                      		$readonly = 'disabled';
                                                      	} else {
                                                      		$readonly = null;
                                                      	}
                                                      ?>
                                                      <?php echo e(Form::text('invoice_amount[]', $value->invoice_amount ?? NULL, ['required', 'class' => 'input is-small', 'id' => 'invoice_amount_' . $value->id, 'placeholder' => 'Enter invoice amount...', $readonly])); ?>

                                                      <?php
                                                      		$i_total[] = $value->invoice_amount;
                                                      ?>
                                                  </td>
                                                    <td>
                                                      <?php $invoice_types = ['Partial' => 'Partial', 'Full' => 'Full']; ?>
                                                      <?php echo e(Form::select('invoice_type[]', $invoice_types, $value->invoice_type ?? NULL, ['class' => 'input is-small', 'id'=>'site_invoice_' .  $value->id, 'required', $readonly])); ?>                                      
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              	<tr>
                                                  	<td colspan="4">
                                                  	</td>
                                                  	<td>
                                                      	<?php echo e($total = array_sum($i_total)); ?>

                                                  	</td>
                                                  	<td></td>
                                              	</tr>
                                            </tbody>
                                        </table>
                                  </div>                                 
                    	</div>
                    	<div class="column is-3">
                          
                          		<?php if($invoiceInfo->completion_status == 'Done'): ?>
                          				<div class="button is-success is-small">Final Saved</div>
                                <?php else: ?>                          			
                                    <?php if($tot == $invoiceInfoTotal): ?>
                                              <input type="hidden" name="invoice_info_id" value="<?php echo e($invoiceInfo->id); ?>" />
                                              <button class="button is-primary is-small">Final Save</button>
                                    <?php else: ?>
                                          		<button class="button is-primary is-small">Save</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                          
                          		<a href="<?php echo e(($check == TRUE) ? route('multiple.site.invoices.list')  : route('multiple.site.invoice.together')); ?>" class="button is-info is-small ml-2">
                                  	<?php echo e(($check == TRUE) ? 'Back to Site Invoice List' : 'Back to invoice generator'); ?>                                  	
                          		</a>
                          		
                    	</div>
                  </div>
                  <?php echo e(Form::close()); ?>				                  
                  
              </div>
          </div>
      </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('cusjs'); ?>
	<script type="text/javascript">
            	      
      	function saveInvoiceData(id) {
          		var url = "<?php echo e(route('multiple.site.invoice.together.single.edit', ['', ''])); ?>/"+ id    
          
          		var datas = {
                        invoice_amount: $('#invoice_amount_' + id).val(),
                        invoice_type: $( "#site_invoice_" + id + " option:selected").val()
                }
          
                $.ajax({
                      url: url,
                      type: "GET",
                      headers: {
                        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      beforeSend: function(xhr){
                            xhr.setRequestHeader("Content-Type","application/json");
                            xhr.setRequestHeader("Accept","application/json");
                      },
                      data: datas,
                      dataType:"json",
                  	  success: function() {
                        	$('#reload_me').load( document.URL + ' #reload_me');
                      }
                });
        }
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/domains/mtsbd.net/public_html/employee/vendor/tritiyo/site/src/views/multiple_site_invoice_another_edit_view.blade.php ENDPATH**/ ?>