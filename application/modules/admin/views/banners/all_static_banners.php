<div class="padd">
	<p class="center-align">Long banners cost $<?php echo $long_cost;?> per day and short banners cost $<?php echo $short_cost;?> per day.</p>
<?php	

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
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>Banner</th>
                        <th>Type</th>
                    	<th>Created</th>
                    	<th>Starts</th>
                    	<th>Expires</th>
                    	<th>Title</th>
                    	<th>Description</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($query->result() as $cat){
					
					$static_banner_id = $cat->static_banner_id;
					$static_banner_status = $cat->static_banner_status;
					$static_banner_name = $cat->static_banner_name;
					$static_banner_description = $cat->static_banner_description;
					$static_banner_image_name = 'thumbnail_'.$cat->static_banner_image_name;
					$created = date('jS M Y', strtotime($cat->created));
					$expiry = $cat->static_banner_expiry;
					$start = $cat->static_banner_start;
					$static_banner_type = $cat->static_banner_type;
					
					if($expiry != NULL)
					{
						$static_banner_expiry = date('jS M Y', strtotime($expiry));
						$static_banner_start = date('jS M Y', strtotime($start));
					}
					
					else
					{
						$static_banner_expiry = $expiry;
						$static_banner_start = $start;
					}
					
					if($static_banner_status == 1){
						$status = '<span class="label label-success">Active</span>';
					}
					else{
						$status = '<span class="label label-warning">Deactivated</span>';
					}
					
					if($static_banner_type == 1)
					{
						$static_banner_type = 'Long';
					}
					else
					{
						$static_banner_type = 'Short';
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo $static_banner_location.$static_banner_image_name;?>" width="" class="img-responsive img-thumbnail">
                        </td>
                    	<td><?php echo $static_banner_type?></td>
                    	<td><?php echo $created?></td>
                    	<td><?php echo $static_banner_start?></td>
                    	<td><?php echo $static_banner_expiry?></td>
                    	<td><?php echo $static_banner_name?></td>
                    	<td><?php echo $static_banner_description?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                            <?php
								//make new payment
								if($static_banner_status == 0)
								{
									?>
                                        <a href="<?php echo site_url()."admin/banners/activate-static-banner/".$static_banner_id.'/'.$page;?>" class="i_size" title="Activate" onclick="return confirm('Do you want to activate this banner?');">
                                        	<button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Activate</button>
                                            
                                        </a>
                                    <?php
								}
								
								//renew payment
								else
								{
									?>
                                        <a href="<?php echo site_url()."admin/banners/deactivate-static-banner/".$static_banner_id.'/'.$page;?>" class="i_size" title="Deactivate" onclick="return confirm('Do you want to deactivate this banner?');">
                            				<button class="btn btn-info btn-sm" type="button" ><i class="fa fa-money"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
							?>
                        </td>
                    </tr>
                    <?php
				}
				?>
                </table>
                <?php
			}
			
			else{
				echo "There are no static banners";
			}
		?>
</div>