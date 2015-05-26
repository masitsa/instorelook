<link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script>
<?php
	if($features->num_rows() > 0){
		$feature = $features->result();
?>
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
<?php
			$count = 0;
			foreach($feature as $feat){
				
				$category_feature_id = $feat->feature_id;
				$category_feature_name = $feat->feature_name;
				$_SESSION['category_feature'][$count] = $category_feature_id;
				$count++;
				if($count == 1)
				{
					echo '<li class="active"><a href="#tab'.$count.'" data-toggle="tab">'.$category_feature_name.'</a></li>';
				}
				else
				{
					echo '<li><a href="#tab'.$count.'" data-toggle="tab">'.$category_feature_name.'</a></li>';
				}
			}
			$_SESSION['count'] = $count;
?>
            </ul>
            <div class="tab-content" id="features_tab">
<?php
			for($r = 0; $r < $_SESSION['count']; $r++)
			{
				$category_feature_id = $_SESSION['category_feature'][$r];
				$ct = $r+1;
				
				$options = form_open_multipart("vendor/products/add_new_feature/".$category_feature_id.'/'.$product_id, array('id' => 'cat_feature'.$category_feature_id, 'name' => $category_feature_id)).'
					<div class="row">
						<div class="col-md-6">
							<div class="form-group"><input type="text" class="form-control feature_input" placeholder="Feature Name" id="sub_feature_name'.$category_feature_id.'" name="sub_feature_name'.$category_feature_id.'"/></div>
							<div class="form-group"><input type="text" class="form-control feature_input" placeholder="Quantity" id="sub_feature_qty'.$category_feature_id.'" name="sub_feature_qty'.$category_feature_id.'"/></div>
							<div class="form-group"><input type="text" class="form-control feature_input" placeholder="Additional Price" id="sub_feature_price'.$category_feature_id.'" name="sub_feature_price'.$category_feature_id.'"/></div>
						</div>
						<div class="col-md-6">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="height:160px;">
									<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" class="img-responsive" />
								</div>
								<div>
									<span class="btn btn-file btn-warning"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="feature_image'.$category_feature_id.'"></span>
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
							
						</div><div class="center-align"><button type="submit" class="btn btn-success add_feature">Add Feature</button></div>'.form_close().'
						</div>
						<div class="row">
						<div class="col-md-12">
							<h4>Added Features</h4>
							<div id="new_features'.$category_feature_id.'">
				';
				
				if($product_features)
				{
					$count = 0;
					$ct = $r+1;
					
					$options .= '
						<table class="table table-condensed table-responsive table-hover table-striped">
							<tr>
								<th></th>
								<th>Name</th>
								<th>Quantity</th>
								<th>Additional Price</th>
								<th>Image</th>
								<th colspan="2"></th>
							</tr>';
							
					if($product_features->num_rows() > 0)
					{
						foreach($product_features->result() as $res)
						{
							$feature_id = $res->feature_id;
							
							if($feature_id == $category_feature_id)
							{
								$count++;
								$image = '<img src="'. base_url().'assets/images/products/features/'.$res->thumb.'"/>';
								$options .= '
								<tr>
									'.form_open_multipart('vendor/products/update_feature/'.$product_id.'/'.$res->product_feature_id.'/'.$res->image.'/'.$res->thumb).'
									<td>'.$ct.'</td>
									<td><input type="text" class="form_control" name="feature_value'.$res->product_feature_id.'" value="'.$res->feature_value.'"/></td>
									<td><input type="text" class="form_control" name="quantity'.$res->product_feature_id.'" value="'.$res->quantity.'"/></td>
									<td><input type="text" class="form_control" name="price'.$res->product_feature_id.'" value="'.$res->price.'"/></td>
									<td>
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="max-width:100px;">
											'.$image.'
										</div>
										
										<div>
											<span class="btn btn-file btn-warning"><span class="fileinput-new">Update image</span><span class="fileinput-exists">Change</span><input type="file" name="feature_image'.$res->product_feature_id.'"></span>
											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
									</td>
									
									<td><button type="submit" class="btn btn-success">Update feature</button></td>
									<td><a class="btn btn-danger" href="'.site_url().'vendor/products/delete_product_feature/'.$product_id.'/'.$res->product_feature_id.'/'.$res->image.'/'.$res->thumb.'" onClick="return confirm(\'Do you want to delete the '.$res->feature_value.' feature?\')"><span class="fa fa-trash"></span></a></td>
									'.form_close().'
								</tr>
								';
							}
						}
					}
					
					$options .= '</table>';
				}
				
				else
				{
					$options .= '<p>You have not added any features</p>';
				}
				
				$options .= '</div></div></div>';
				
				if($r == 0)
				{
					echo '
					<div class="tab-pane active" id="tab'.$ct.'">
						'.$options.'
					</div>';
				}
				
				else
				{
					echo '
					<div class="tab-pane" id="tab'.$ct.'">
						'.$options.'
					</div>';
				}
			}
			
?>
  </div>
</div>
<?php
	}
?>