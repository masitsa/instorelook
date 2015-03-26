<?php 
$v_data['view_type'] = 0;
echo $this->load->view('vendor/search/search_products', $v_data, TRUE); ?>
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
				
		$search = $this->session->userdata('product_search');
		
		if(!empty($search))
		{
			$search_result = '<a href="'.site_url().'vendor/close-product-search" class="btn btn-success">Close Search</a>';
		}


		$result = '<div class="padd">';	
		$result .= ''.$search_result2.'';
		$result .= '
					<div class="row" style="margin-bottom:8px;">
						<div class="pull-left">
						'.$search_result.'
						</div>
	            		<div class="pull-right">
							<a href="'.site_url().'vendor/import-product" class="btn btn-success " style="margin-left:10px;">Import Product</a>
							<a href="'.site_url().'vendor/export-product" class="btn btn-success " style="margin-left:10px;">Export Product</a>
							<a href="'.site_url().'vendor/add-product" class="btn btn-success ">Add Product</a>
						
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
					  <th class="table-sortable:default table-sortable" title="Click to sort">#</th>
					  <th>Image</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Code</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Product Name</th>
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
				$sale_price = $row->sale_price;
				$featured = $row->featured;
				$product_id = $row->product_id;
				$product_name = $row->product_name;
				$product_buying_price = $row->product_buying_price;
				$product_selling_price = $row->product_selling_price;
				$product_status = $row->product_status;
				$product_description = $row->product_description;
				$product_code = $row->product_code;
				$product_balance = $row->product_balance;
				$brand_id = $row->brand_id;
				$category_id = $row->category_id;
				$created = $row->created;
				$created_by = $row->created_by;
				$last_modified = $row->last_modified;
				$modified_by = $row->modified_by;
				$image = $row->product_image_name;
				$thumb = $row->product_thumb_name;
				$category_name = $row->category_name;
				$brand_name = $row->brand_name;
				$query = $this->products_model->get_gallery_images($product_id);
				$galleries = '';
				if ($query->num_rows() > 0)
				{
					$gallery_images = $query->result();
					
					foreach ($gallery_images as $gal)
					{
						$gallery_thumb = $gal->product_image_thumb;
						
						$galleries .= '<div class="col-md-1"><img src="'.base_url()."assets/images/products/gallery/".$gallery_thumb.'"></div>';
					}
				}
				
				//status
				if($product_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($product_status == 0)
				{
					$status = '<span class="label label-danger">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'vendor/activate-product/'.$product_id.'" onclick="return confirm(\'Do you want to activate '.$product_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($product_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'vendor/deactivate-product/'.$product_id.'" onclick="return confirm(\'Do you want to deactivate '.$product_name.'?\');">Deactivate</a>';
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
						<td><img src="'.base_url()."assets/images/products/images/".$thumb.'"></td>
						<td>'.$product_code.'</td>
						<td>'.$product_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						<td>
							
							<!-- Button to trigger modal -->
							<a href="#user'.$product_id.'" class="btn btn-primary" data-toggle="modal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
							
							<!-- Modal -->
							<div id="user'.$product_id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$product_name.'</h4>
										</div>
										
										<div class="modal-body">
											<table class="table table-stripped table-condensed table-hover">
												<tr>
													<th>Product Name</th>
													<td>'.$product_name.'</td>
												</tr>
												<tr>
													<th>Code</th>
													<td>'.$product_code.'</td>
												</tr>
												<tr>
													<th>Category</th>
													<td>'.$category_name.'</td>
												</tr>
												<tr>
													<th>Brand</th>
													<td>'.$brand_name.'</td>
												</tr>
												<tr>
													<th>Buying Price</th>
													<td>'.$product_buying_price.'</td>
												</tr>
												<tr>
													<th>Selling Price</th>
													<td>'.$product_selling_price.'</td>
												</tr>
												<tr>
													<th>Balance</th>
													<td>'.$product_balance.'</td>
												</tr>
												<tr>
													<th>Status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Description</th>
													<td>'.$product_description.'</td>
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
													<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
												</tr>
												<tr>
													<th>Modified By</th>
													<td>'.$modified_by.'</td>
												</tr>
												<tr>
													<th>product Image</th>
													<td><img src="'.base_url()."assets/images/products/images/".$image.'" height="150" width="120"></td>
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
											<a href="'.site_url().'vendor/edit-product/'.$product_id.'" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
											<a href="'.site_url().'products/view-product/'.$product_id.'" target="_blank" class="btn btn-sm btn-ifo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
											<a href="'.site_url().'vendor/duplicate-product/'.$product_id.'" class="btn btn-sm btn-warning">Duplicate</a>
											'.$button.'
											<a href="'.site_url().'vendor/delete-product/'.$product_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$product_name.'?\');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
										</div>
									</div>
								</div>
							</div>
						
						</td>
						<td><a href="'.site_url().'vendor/edit-product/'.$product_id.'" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
						<td><a href="'.site_url().'vendor/duplicate-product/'.$product_id.'" class="btn btn-sm btn-warning">Duplicate</a></td>
						<td><a href="'.site_url().'products/view-product/'.$product_id.'" target="_blank" class="btn btn-sm btn-ifo"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'vendor/delete-product/'.$product_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$product_name.'?\');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
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
			$result .= "There are no products";
		}
		
		$result .= '</div>';
		echo $result;
?>