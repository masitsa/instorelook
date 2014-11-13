<?php
		
		$result = '<a href="'.site_url().'administration/add-airline" class="btn btn-success pull-right">Add Airline</a>';
            
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
					  <th>Logo</th>
					  <th>Airline</th>
					  <th>Email</th>
					  <th>Phone</th>
					  <th>Registered On</th>
					  <th>Last Login</th>
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
				$airline_id = $row->airline_id;
				$airline_name = $row->airline_name;
				$airline_email = $row->airline_email;
				$airline_phone = $row->airline_phone;
				$airline_status = $row->airline_status;
				$thumb = $row->airline_thumb;
				$created = $row->created;
				$last_login = $row->last_login;
				
				//status
				if($airline_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($airline_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/activate-airline/'.$airline_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$airline_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($airline_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'administration/deactivate-airline/'.$airline_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$airline_name.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td><img src="'.base_url()."assets/images/airlines/".$thumb.'"></td>
						<td>'.$airline_name.'</td>
						<td>'.$airline_email.'</td>
						<td>'.$airline_phone.'</td>
						<td>'.date('jS M Y H:i a',strtotime($created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($last_login)).'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'administration/edit-airline/'.$airline_id.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'administration/delete-airline/'.$airline_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$airline_name.'?\');">Delete</a></td>
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
			$result .= "There are no airlines";
		}
		
		echo $result;
?>