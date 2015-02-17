<?php 
$v_data['view_type'] = 0;
echo $this->load->view('vendor/search/search_features', $v_data, TRUE); ?>
<?php

		$error = $this->session->userdata('error_message');
		$success = $this->session->userdata('success_message');
		$search_result ='';
		$search_result2  ='';
		if(!empty($error))
		{
			$search_result2 = '<div class="alert alert-danger">'.$error.'</div>';
			$this->session->unset_userdata('error_message');
		}
		
		if(!empty($success))
		{
			$search_result2 ='<div class="alert alert-success">'.$success.'</div>';
			$this->session->unset_userdata('success_message');
		}
				
		$search = $this->session->userdata('feature_search');
		
		if(!empty($search))
		{
			$search_result = '<a href="'.site_url().'vendor/close-features-search" class="btn btn-danger">Close Search</a>';
		}


		$result = '<div class="padd">';	
		$result .= ''.$search_result2.'';
		$result .= '
					<div class="row" style="margin-bottom:8px;">
						<div class="pull-left">
						'.$search_result.'
						</div>
	            		<div class="pull-right">
							<a href="'.site_url().'vendor/add-feature" class="btn btn-primary pull-right">Add Feature</a>
						
						</div>
					</div>
				';
			
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
				  <thead>
					<tr>
					  <th class="table-sortable:default table-sortable" title="Click to sort">#</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Category</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Feature Name</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Date Created</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Last Modified</th>
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
				$feature_id = $row->feature_id;
				$category_name = $row->category_name;
				$feature_name = $row->feature_name;
				$feature_status = $row->feature_status;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				
				if($category_name == 'No Category'){$category_name = 'All Categories';}
				
				//status
				if($feature_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($feature_status == 0)
				{
					$status = '<span class="label label-danger">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'vendor/activate-feature/'.$feature_id.'" onclick="return confirm(\'Do you want to activate '.$feature_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($feature_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'vendor/deactivate-feature/'.$feature_id.'" onclick="return confirm(\'Do you want to deactivate '.$feature_name.'?\');">Deactivate</a>';
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
				
				if($created_by == $this->session->userdata('vendor_id'))
				{
					$actions = '
					<td><a href="'.site_url().'vendor/edit-brand/'.$brand_id.'" class="btn btn-sm btn-success">Edit</a></td>
					<td>'.$button.'</td>
					<td><a href="'.site_url().'vendor/delete-brand/'.$brand_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$brand_name.'?\');">Delete</a></td>
					';
				}
				
				else
				{
					$actions = '<td colspan="3"></td>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$category_name.'</td>
						<td>'.$feature_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						'.$actions.'
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
					</div>
			';
		}
		
		else
		{
			$result .= "There are no features";
		}
		$result .= '</div>';
		echo $result;

?>