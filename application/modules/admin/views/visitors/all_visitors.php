<?php
		
		$result = '<a href="'.site_url().'administration/add-visitor" class="btn btn-success pull-right">Add Visitor</a>';
            
		$success = $this->session->userdata('success_message');
		
		if(!empty($success))
		{
			echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
			$this->session->unset_userdata('success_message');
		}
		
		$error = $this->session->userdata('error_message');
		
		if(!empty($error))
		{
			echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
			$this->session->unset_userdata('error_message');
		}
		
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
					  <th>First Name</th>
					  <th>Last Name</th>
					  <th>Visitor Type</th>
					  <th>Registered On</th>
					  <th>Last Login</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$visitor_id = $row->visitor_id;
				$visitor_first_name = $row->visitor_first_name;
				$visitor_last_name = $row->visitor_last_name;
				$visitor_email = $row->visitor_email;
				$visitor_phone = $row->visitor_phone;
				$visitor_status = $row->visitor_status;
				$visitor_type_name = $row->visitor_type_name;
				$created = $row->created;
				$last_login = $row->last_login;
				
				//status
				if($visitor_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($visitor_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/activate-visitor/'.$visitor_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$visitor_first_name.' '.$visitor_last_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($visitor_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/deactivate-visitor/'.$visitor_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$visitor_first_name.' '.$visitor_last_name.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$visitor_first_name.'</td>
						<td>'.$visitor_last_name.'</td>
						<td>'.$visitor_type_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($last_login)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$visitor_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$visitor_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$visitor_first_name.' '.$visitor_last_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>First Name</th>
													<td>'.$visitor_first_name.'</td>
												</tr>
												<tr>
													<th>Last Name</th>
													<td>'.$visitor_last_name.'</td>
												</tr>
												<tr>
													<th>Phone</th>
													<td>'.$visitor_phone.'</td>
												</tr>
												<tr>
													<th>Email</th>
													<td>'.$visitor_email.'</td>
												</tr>
												<tr>
													<th>Visitor Type</th>
													<td>'.$visitor_type_name.'</td>
												</tr>
												<tr>
													<th>Status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Date Created</th>
													<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
												</tr>
												<!--<tr>
													<th>Last Login</th>
													<td>'.date('jS M Y H:i a',strtotime($last_login)).'</td>
												</tr>
												<tr>
													<th>Last Modified</th>
													<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
												</tr>-->
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'administration/edit-visitor/'.$visitor_id.'" class="btn btn-sm btn-success">Edit</a>
											'.$button.'
											<a href="'.site_url().'administration/delete-visitor/'.$visitor_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$visitor_first_name.' '.$visitor_last_name.'?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'administration/edit-visitor/'.$visitor_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'administration/delete-visitor/'.$visitor_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$visitor_first_name.' '.$visitor_last_name.'?\');">Delete</a></td>
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
			$result .= "There are no visitors";
		}
		
		echo $result;
?>