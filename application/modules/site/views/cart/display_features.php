<?php
if($feature_names->num_rows() > 0)
{
	foreach($feature_names->result() as $feat)
	{
		$feature_name = $feat->feature_name;
		$feature_id = $feat->feature_id;
		
		//display product features
		if($product_features->num_rows() > 0)
		{
			$prod_feat_count = 0;
			foreach($product_features->result() as $prod_feat)
			{
				$feat_name = $prod_feat->feature_name;
				
				if($feat_name == $feature_name)
				{
					//check if feature has images
					$feature_image = $prod_feat->thumb;
					$feature_value = $prod_feat->feature_value;
					$product_feature_id = $prod_feat->product_feature_id;
					
					if($cart_product_feature_id == $product_feature_id)
					{
						$feature_location = base_url().'assets/images/products/features/';
						$feature_path = realpath(APPPATH . '../assets/images/products/features');
						$feature_image_display = $this->products_model->image_display($feature_path, $feature_location, $feature_image);
						
						//display feature images
						if($feature_image != 'None')
						{
							echo '
								<tr>
									<td>'.$feature_name.'</td>
									<td><img src="'.$feature_image_display.'" /></td>
									<td>'.number_format($added_price, 2).'</td>
								</tr>';
						}
						
						//display features in dropdown
						else
						{
							echo '
								<tr>
									<td>'.$feature_name.'</td>
									<td>'.$feature_value.'</td>
									<td>'.number_format($added_price, 2).'</td>
								</tr>';
						}
					}
				}
			}
		}
	}
}
?>