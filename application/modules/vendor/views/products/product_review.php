<?php 

//echo $this->load->view('vendor/search/search_orders', '' , TRUE); ?>
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
				
		$search = $this->session->userdata('orders_search');
		
		if(!empty($search))
		{
			$search_result = '<a href="'.site_url().'vendor/close-orders-search" class="btn btn-danger">Close Search</a>';
		}


		$result = '<div class="padd">';	
		$result .= ''.$search_result2.'';
		$result .= '
					<div class="row" style="margin-bottom:8px;">
						<div class="pull-left">
						'.$search_result.'
						</div>
	            		<div class="pull-right">
							
						
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
					  <th class="table-sortable:default table-sortable" title="Click to sort">Date Created</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Product Name</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Customer Name</th>
					  <th>Status</th>
					 
					  <th colspan="3">Actions</th>
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
				$product_review_id = $row->product_review_id;
				$product_name = $row->product_name;
				$product_review_status = $row->product_review_status;
				$product_review_rating = $row->product_review_rating;
				$product_review_reviewer_email = $row->product_review_reviewer_email;
				$product_review_reviewer_name = $row->product_review_reviewer_name;
				$product_review_created = $row->product_review_created;
				$product_review_reviewer_phone = $row->product_review_reviewer_phone;
				$product_review_content = $row->product_review_content;

				$button = '';				
				//create deactivated status display
				if(empty($product_review_status))
				{
					$status = '<span class="label label-primary">Pending</span>';
					$button = '<a href="'.site_url().'vendor/activate-review/'.$product_review_id.'" class="btn btn-sm btn-success" onclick="return confirm(\'Do you really want to activate this review '.$product_name.'?\');">Activate Review</a>';
				}
				//create activated status display
				else if($product_review_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a href="'.site_url().'vendor/deactivate-review/'.$product_review_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to deactivate this review '.$product_name.'?\');">Deactivate Review</a>';

				}
				else
				{
					$status = '<span class="label label-danger">Deactivated</span>';
					$button = '<a href="'.site_url().'vendor/deactivate-review/'.$product_review_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to deactivate this review '.$product_name.'?\');">Deactivate Review</a>';

				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.date('jS M Y H:i a',strtotime($product_review_created)).'</td>
						<td>'.$product_name.'</td>
						<td>'.$product_review_reviewer_name.'</td>
						<td>'.$status.'</td>
						<td>
							<!-- Button to trigger modal -->
							<a href="#user'.$product_review_id.'" class="btn btn-primary" data-toggle="modal">View</a>
							
							<!-- Modal -->
							<div id="user'.$product_review_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$product_name.'</h4>
										</div>
										
										<div class="modal-body">
											'.$product_review_content.'<br/>
											'.$product_review_rating.'
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											'.$button.'
										</div>
									</div>
								</div>
							</div>
						</td>
						<td>'.$button.'</td>
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
			$result .= "There are no orders";
		}
		$result .= '</div>';
		echo $result;
?>