<?php 
$v_data['view_type'] = 0;
echo $this->load->view('vendor/search/search_product_bundle', $v_data, TRUE); ?>
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
				
		$search = $this->session->userdata('product_bundle_search');
		
		if(!empty($search))
		{
			$search_result = '<a href="'.site_url().'vendor/close-product-bundle-search" class="btn btn-success">Close Search</a>';
		}


		$result = '<div class="padd">';	
		$result .= ''.$search_result2.'';
		$result .= '
					<div class="row" style="margin-bottom:8px;">
						<div class="pull-left">
						'.$search_result.'
						</div>
	            		<div class="pull-right">
							<a href="'.site_url().'vendor/add-product-bundle" class="btn btn-success ">Add Product bundle</a>
						
						</div>
					</div>
				';

		
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			$result .= 
			'
			<div class="row">
				<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
				  <thead>
					<tr>
					  <th>#</th>
					  <th >Bundle Image</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Bundle Name</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Date Created</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Last Modified</th>
					  <th>Status</th>
					  <th colspan="6">Actions</th>
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
				$product_bundle_id = $row->product_bundle_id;
				$product_bundle_name = $row->product_bundle_name;
				$product_bundle_status = $row->product_bundle_status;
				$product_bundle_description = $row->product_bundle_description;
				$created = $row->created_on;
				$created_by = $row->created_by;
				$last_modified = $row->last_modified;
				$modified_by = $row->last_modified_by;
				$image = $row->product_bundle_image_name;
				$thumb = $row->product_bundle_thumb_name;
				$query = $this->products_model->get_gallery_images($product_bundle_id);
				$galleries = '';
				if ($query->num_rows() > 0)
				{
					$gallery_images = $query->result();
					
					foreach ($gallery_images as $gal)
					{
						$gallery_thumb = $gal->product_image_thumb;
						
						$galleries .= '<div class="col-md-1"><img src="'.base_url()."assets/images/product_bundle/gallery/".$gallery_thumb.'"></div>';
					}
				}
				
				//status
				if($product_bundle_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				//create deactivated status display
				if($product_bundle_status == 0)
				{
					$status = '<span class="label label-danger">Deactivated</span>';

					$button = '<a class="btn btn-info" href="'.site_url().'vendor/activate-product/'.$product_bundle_id.'" onclick="return confirm(\'Do you want to activate '.$product_bundle_name.'?\');">Activate</a>';

				}
				//create activated status display
				else if($product_bundle_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'vendor/deactivate-product/'.$product_bundle_id.'" onclick="return confirm(\'Do you want to deactivate '.$product_bundle_name.'?\');">Deactivate</a>';
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
						<td><img src="'.base_url()."assets/images/product_bundle/images/".$thumb.'"></td>
						<td>'.$product_bundle_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created_on)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$product_bundle_id.'" class="btn btn-primary" data-toggle="modal">View bundle</a>
							
							<!-- Modal -->
							<div id="user'.$product_bundle_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$product_bundle_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>Product Name</th>
													<td>'.$product_bundle_name.'</td>
												</tr>
												
												<tr>
													<th>Status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Description</th>
													<td>'.$product_bundle_description.'</td>
												</tr>
												<tr>
													<th>Date Created</th>
													<td>'.date('jS M Y H:i a',strtotime($row->created_on)).'</td>
												</tr>
												<tr>
													<th>Created By</th>
													<td>'.$created_by.'</td>
												</tr>
												<tr>
													<th>Date Modified</th>
													<td>'.date('jS M Y H:i a',strtotime($row->last_modified_by)).'</td>
												</tr>
												<tr>
													<th>Modified By</th>
													<td>'.$modified_by.'</td>
												</tr>
												<tr>
													<th>Product bundle Image</th>
													<td><img src="'.base_url()."assets/images/product_bundle/images/".$image.'" height="150" width="120"></td>
												</tr>
												<tr>
													<th>Gallery Images</th>
													<td>
														<div class="row">
															'.$galleries.'
														</div>
														
													</td>
												</tr>
											</table>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
											<a href="'.site_url().'vendor/edit-product-bundle/'.$product_bundle_id.'" class="btn  btn-success">Edit bundle details</a>

											'.$button.'
											<a href="'.site_url().'vendor/delete-product-bundle/'.$product_bundle_id.'" class="btn  btn-danger" onclick="return confirm(\'Do you really want to delete '.$product_bundle_name.'?\');">Delete</a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'vendor/add-product-bundle-items/'.$product_bundle_id.'" class="btn  btn-success">Add bundle items</a></td>
						<td><a href="'.site_url().'vendor/edit-product-bundle/'.$product_bundle_id.'" class="btn  btn-success">Edit bundle details</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'vendor/delete-product/'.$product_bundle_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$product_bundle_name.'?\');">Delete</a></td>
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
			$result .= "There are no product bundles";
		}
		
		$result .= '</div>';
		echo $result;
?>