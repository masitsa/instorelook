<?php
		
		$result = '<a href="'.site_url().'administration/add-flight-type" class="btn btn-success pull-right">Add Flight Type</a>';
            
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
					  <th>Flight Type Name</th>
					  <th>Created</th>
					  <th>Created By</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$flight_type_id = $row->flight_type_id;
				$flight_type_name = $row->flight_type_name;
				$flight_type_status = $row->flight_type_status;
				$created = $row->created;
				$created_by = $row->created_by;
				$user_type_id = $row->user_type_id;
				
				//status
				if($flight_type_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
			
				//get creator
				if($user_type_id == 3)
				{
					$creators = $this->users_model->get_user($created_by);
				}
				//airline
				if($user_type_id == 2)
				{
					$creators = $this->airlines_model->get_airline($created_by);
				}
				
				if ($creators->num_rows() > 0)
				{
					$creator = $creators->row();
					//airline
					if($user_type_id == 2)
					{
						$created_by = $creator->airline_name;
					}
					
					else
					{
						$created_by = $creator->first_name;
					}
				}
				
				//create deactivated status display
				if($flight_type_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/activate-flight-type/'.$flight_type_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$flight_type_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($flight_type_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/deactivate-flight-type/'.$flight_type_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$flight_type_name.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$flight_type_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.$created_by.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'administration/edit-flight-type/'.$flight_type_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'administration/delete-flight-type/'.$flight_type_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$flight_type_name.'?\');">Delete</a></td>
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
			$result .= "There are no flight types";
		}
		
		echo $result;
?>