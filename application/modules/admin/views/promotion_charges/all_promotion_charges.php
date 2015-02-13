<?php
		
		$result = '<a href="'.site_url().'admin/add-promotion-charge" class="btn btn-success pull-right">Add Charge</a>';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Charge Name</th>
					  <th>Charge Cost($)</th>
					  <th>Date Created</th>
					  <th>Last Modified</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$promotion_charge_id = $row->promotion_charge_id;
				$promotion_charge_name = $row->promotion_charge_name;
				$promotion_charge_cost = number_format($row->promotion_charge_cost, 2);
				$promotion_charge_status = $row->promotion_charge_status;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				
				//status
				if($promotion_charge_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($promotion_charge_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/activate-promotion-charge/'.$promotion_charge_id.'" onclick="return confirm(\'Do you want to activate '.$promotion_charge_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($promotion_charge_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/deactivate-promotion-charge/'.$promotion_charge_id.'" onclick="return confirm(\'Do you want to deactivate '.$promotion_charge_name.'?\');">Deactivate</a>';
				}
				
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->user_id;
						
						if($user_id == $created_by)
						{
							$created_by = $adm->first_name;
						}
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->first_name;
						}
					}
				}
				
				else
				{
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$promotion_charge_name.'</td>
						<td>'.$promotion_charge_cost.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->modified)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$promotion_charge_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$promotion_charge_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$promotion_charge_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>Charge Name</th>
													<td>'.$promotion_charge_name.'</td>
												</tr>
												<tr>
													<th>Charge Cost</th>
													<td>'.$promotion_charge_cost.'</td>
												</tr>
												<tr>
													<th>Status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Date Created</th>
													<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
												</tr>
												<tr>
													<th>Created By</th>
													<td>'.$created_by.'</td>
												</tr>
												<tr>
													<th>Date Modified</th>
													<td>'.date('jS M Y H:i a',strtotime($row->modified)).'</td>
												</tr>
												<tr>
													<th>Modified By</th>
													<td>'.$modified_by.'</td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'admin/edit-promotion-charge/'.$promotion_charge_id.'" class="btn btn-sm btn-success">Edit</a>
											'.$button.'
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'admin/edit-promotion-charge/'.$promotion_charge_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no charges";
		}
		
		echo $result;
?>