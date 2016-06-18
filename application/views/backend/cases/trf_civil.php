<?php defined('BASEPATH') or die('Restricted access');?>

<div class="col-md-12 m-b-10">

	<h2 class="center urdu" id="User-Court"><?php echo $court_name->court_name.' '.'<small>'.$court_name->desgn_name.'</small>'; ?></h2>

</div>
	
<div class="row">
	<div class="col-sm-12">
    	<div class="card-box">
    	
    		<table id="demo-foo-filtering" class="table table-striped toggle-circle m-b-0" data-page-size="50">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="#" data-toggle="tooltip" title="Computer I.D Generated by Software!">Case<br />I.D</a></th>
						<?php if( $transfer == 'trf_from' ): ?>
						<th>Transfer From</th>
						<?php endif; ?>
						<?php if( $transfer == 'trf_to' ): ?>
						<th>Transfer To</th>
						<?php endif; ?>
						<th data-hide="phone">Institution<br>Date</th>
						<th data-hide="phone">Category</th>
						<th data-hide="phone">Sub Category</th>
						<th data-toggle="true">Case Title</th>
						<th data-hide="phone">Next Date</th>
						<th data-hide="phone" class="hidden-print">Case<br />Detail(s)</th>
						<th data-hide="phone" class="center actions hidden-print">Actions</th>
					</tr>
				</thead>
				
				<div class="form-inline m-b-20">
					<div class="row">
						<div class="col-sm-6 text-xs-center">
							<div class="form-group">
								<label class="control-label m-r-5">Filter by Category:</label>
								
								<?php 
									$options = array();
									$options[''] = 'Show All';
									foreach ($cases as $case) {
										$options[$case->cat_name] = $case->cat_name;
									}
									echo form_dropdown('cat_name', $options, 
											!isset($case->cat_name)? : set_value(''),
											array('id' => 'demo-foo-filter-status', 'class' => 'form-control input-sm'));
								?>
								
							</div>
						</div>
						
						<div class="col-sm-6 text-xs-center text-right">
							<div class="form-group">
								<input id="demo-foo-search" type="text" placeholder="Search" class="form-control input-sm" autocomplete="on">
							</div>
						</div>
						
					</div>
				</div>
				
				<tbody>
				
					<?php 
						$i=1; $sr=1; $s=1;
						foreach($cases as $case): 
						
						$vx = (count($case->nprocs)-1);
					?>
					
					<tr class="center">
						<td class="center"><?php echo $i++;?></td>
						<td><?php echo $case->case_id; ?></td>
						<?php if( $transfer == 'trf_from' ) : ?>
						<td><p class="urdu"><?php echo $case->nprocs[$vx-1]->court_name?></p></td>
						<?php endif; ?>
						<?php if( $transfer == 'trf_to' ) : ?>
						<td><p class="urdu"><?php echo $case->nprocs[$vx]->court_name?></p></td>
						<?php endif; ?>						
						<td class="<?php if (!empty($case->old_case)) {echo 'text-danger';} ?>"> <?php if ($case->inst_date!=0000-00-00){ echo @date('d-m-Y', @strtotime($case->inst_date));} ?></td>
						
						<td style="white-space:pre-wrap;max-width:160px;"><?php echo $case->cat_name; ?></td>
						<td><p class="urdu"><?php echo $case->cat_nature; ?></p></td>
						
						<td><p class="urdu"><?php echo $case->case_title?> </p></td>
						<td class="<?php if (!empty($case->nprocs)) { if($case->nprocs[$vx]->ndoh <= date("Y-m-d")){ echo 'text-warning'; } }?>"><?php if (!empty($case->nprocs)){ if ($case->nprocs[$vx]->ndoh != '0000-00-00') { echo @date('d-m-Y', @strtotime( $case->nprocs[$vx]->ndoh )); } } ?></td>
														
						<td>
							<button type="button" class="btn btn-xs btn-info hidden-print" data-toggle="modal" data-target="#myModalOpen<?php echo $s++;?>">Detail</button>
						</td>
						
						<td class="center hidden-print">
							<div class="btn-group-xs">
								<a href="<?php echo base_url('admin/cases/edit/'.$case->case_id); ?>" class="btn btn-primary btn-custom" data-toggle="tooltip" title="" data-original-title="Edit Case"><i class="fa fa-edit"></i></a>
							<?php if($this->ion_auth->is_admin()):?>
								<a href="<?php echo base_url('admin/cases/delete/'.$case->case_id); ?>" class="btn btn-danger btn-custom" data-toggle="tooltip" title="" data-original-title="Delete Case"><i class="fa fa-trash-o"></i></a>
							<?php endif; ?>
							</div>
						</td>
			
					</tr>
					<?php endforeach; ?>
				</tbody>
				
				<tfoot>
					<tr>
						<td colspan="11">
							<div class="text-right">
								<ul class="pagination pagination-split m-t-30 m-b-0"></ul>
							</div>
						</td>
					</tr>
				</tfoot>
				
			</table>
						
		</div>
	</div>
</div>

<?php foreach($cases as $case):	?>

	<!-- Modal -->
	<div id="myModalOpen<?php echo $sr++;?>" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">
	
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        
	        <h2 class="center urdu" id="User-Court"><?php echo $case->court_name.' '.'<small>'.$case->desgn_name.'</small>'; ?></h2>
	        
	        <table class="modal-title table table-striped table-bordered table-hover">
	        	<thead>
		        	<tr>
		        		<th><h3 class="modal-title urdu"> <?php echo $case->case_title ?></h3></th>
		        	</tr>
	        	</thead>
	        </table>

	        <table class="table table-striped table-bordered">
	        
	        	<tbody>
	        		<tr>
	        			<th>Institution Date</th>
	        			<th>Category</th>
	        			<th>Sub Category</th>
	        			<th>Register No.</th>
	        			<th>Register Date</th>
		        	</tr>
	        	
		        	<tr class="center">
		        		<td class="<?php if(!empty($case->old_case)) {echo 'text-danger font-strong'; } ?>"><?php echo @date('d-m-Y', @strtotime($case->inst_date)); ?></td>
		        		<td><?php echo $case->cat_name; ?></td>
		        		<td><p class="urdu m-b-0"><?php echo $case->cat_nature; ?></p></td>
		        		<td><?php if (!empty($case->reg_no)){ echo $case->reg_no.'-'.$case->cat_reg_no; } ?></td>
		        		<td><?php if ($case->reg_date!=0000-00-00){ echo @date('d-m-Y', @strtotime($case->reg_date));} ?></td>
		        		
		        	</tr>
		        </tbody>
		        
		   </table>
		   
		   <table class="left table table-bordered table-hover table-left">
				<tbody>
				
					<tr>
		        		<th rowspan="" class="col-md-3">Plaintiff's Name</th>
		        		<td colspan=""><?php echo $case->plt_name; ?></td>
		        	</tr>
		        	<tr>
		        		<th rowspan="" class="">Plaintiff's CNIC</th>
		        		<td colspan=""><?php echo $case->plt_cnic; ?></td>
		        	</tr>
		        	<tr>
		        		<th rowspan="" class="">Plaintiff's Address</th>
		        		<td colspan=""><?php echo $case->plt_addr; ?></td>
		        	</tr>
		        	
		        	<tr>
		        		<th rowspan="2">Plaintiff Advocate's Name<br> &amp; Lience #</th>
		        		<td colspan=""><?php echo $case->plt_adv; ?></td>
		        	</tr>
		        	<tr>
		        		<td colspan=""><?php echo $case->plt_adv_lic; ?></td>
		        	</tr>
		        	
		        	<tr>
		        		<th rowspan="" class="col-md-3">Defendant's Name</th>
		        		<td colspan=""><?php echo $case->def_name; ?></td>
		        	</tr>
		        	<tr>
		        		<th rowspan="" class="">Defendant's CNIC</th>
		        		<td colspan=""><?php echo $case->def_cnic; ?></td>
		        	</tr>
		        	<tr>
		        		<th rowspan="" class="">Defendant's Address</th>
		        		<td colspan=""><?php echo $case->def_addr; ?></td>
		        	</tr>
		        	
		        	<tr>
		        		<th rowspan="2">Defendant's Advocate's Name<br> &amp; Lience #</th>
		        		<td colspan=""><?php echo $case->def_adv; ?></td>
		        	</tr>
		        	<tr>
		        		<td colspan=""><?php echo $case->def_adv_lic; ?></td>
		        	</tr>

		        </tbody>
	        </table>
	        
	      </div>
	      <div class="modal-body">
	        <table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Date of<br>Hearing</th>
						<th>Order Sheet</th>
						<th>Next<br>Proceeding</th>
						<th>Next Date<br>of Hearing</th>
						<th>Remarks</th>
						<th class="hidden-print">Action</th>
					</tr>
				</thead>
	        	<tbody>
	        		
	        		<?php 
	        		$printed_court_id = 0;
	        			foreach ( $case->nprocs as $nproc ) :

						if ($printed_court_id != $nproc->court_id ):
	        		?>
						<tr>
							<td colspan="6"><h3 class="center urdu"><?php echo $nproc->court_name.' '; ?><small><?php echo $nproc->desgn_name; ?></small></h3></td>
						</tr>
					<?php endif; ?>
						
						<tr>
							<td class="center"><?php if ($nproc->doh!=='0000-00-00'){echo @date('d-m-Y', @strtotime($nproc->doh)); } ?></td>
							<td><?php echo $nproc->order_sheet; ?></td>
							<td class="center"><p class="urdu m-b-0"><?php echo $nproc->nproc_name; ?></p></td>
							<td class="center"><?php if ( $nproc->ndoh != '0000-00-00'){ echo @date('d-m-Y', @strtotime($nproc->ndoh)); } ?></td>
							<td><?php echo $nproc->remarks; ?></td>
							
							<td class="center hidden-print">
								<div class="btn-group-xs">
									<a href="<?php echo base_url('admin/cases/edit_ndoh/'.$nproc->id); ?>" class="btn btn-primary btn-custom btn-xs" data-toggle="tooltip" title="" data-original-title="Edit Next Date of Hearing"><i class="fa fa-edit"></i></a>
								<?php if($this->ion_auth->is_admin()):?>
									<a href="<?php echo base_url('admin/cases/delete_ndoh/'.$nproc->id); ?>" class="btn btn-danger btn-custom" data-toggle="tooltip" title="" data-original-title="Delete This Date of Hearing"><i class="fa fa-trash-o"></i></a>
								<?php endif; ?>
								</div>
							</td>
							
						</tr>
							
					<?php
					$printed_court_id = $nproc->court_id;
					endforeach; ?>
					
				</tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	      	<a class="btn btn-primary" href="<?php echo base_url('admin/cases_list/case_detail/'.$case->case_id); ?>"><span class="glyphicon glyphicon-print"></span> Print</a>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	
	  </div>
	</div>
<?php endforeach; ?>