<?php

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
					  <th>Image</th>
					  <th>Code</th>
					  <th>Product Name</th>
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
						<td ><img src="'.base_url()."assets/images/products/images/".$thumb.'" height="100" width="80"></td>
						<td>'.$product_code.'</td>
						<td>'.$product_name.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->created)).'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->last_modified)).'</td>
						<td>'.$status.'</td>
						<td> </td>
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
			$result .= "There are no products";
		}
		
		echo $result;
?>