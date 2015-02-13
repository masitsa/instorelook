<div class="padd">
	<p class="center-align">Add promotional banners to appear on the home page slide show. They will cost $<?php echo $promotion_cost;?> per day.</p>
<a href="<?php echo site_url().'vendor/add-banner';?>" class="btn btn-success pull-right">Add Banner</a>
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
					
					$slideshow_id = $cat->slideshow_id;
					$slideshow_status = $cat->slideshow_status;
					$slideshow_name = $cat->slideshow_name;
					$slideshow_description = $cat->slideshow_description;
					$slideshow_image_name = 'thumbnail_'.$cat->slideshow_image_name;
					$created = date('jS M Y', strtotime($cat->created));
					$expiry = $cat->slideshow_expiry;
					$start = $cat->slideshow_start;
					
					if($expiry != NULL)
					{
						$slideshow_expiry = date('jS M Y', strtotime($expiry));
						$slideshow_start = date('jS M Y', strtotime($start));
					}
					
					else
					{
						$slideshow_expiry = $expiry;
						$slideshow_start = $start;
					}
					
					if($slideshow_status == 1){
						$status = '<span class="label label-success">Active</span>';
					}
					else{
						$status = '<span class="label label-warning">Deactivated</span>';
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo $slideshow_location.$slideshow_image_name;?>" width="" class="img-responsive img-thumbnail">
                        </td>
                    	<td><?php echo $created?></td>
                    	<td><?php echo $slideshow_start?></td>
                    	<td><?php echo $slideshow_expiry?></td>
                    	<td><?php echo $slideshow_name?></td>
                    	<td><?php echo $slideshow_description?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."vendor/delete-banner/".$slideshow_id.'/'.$page;?>" class="i_size" title="Delete" onclick="return confirm('Do you really want to delete this banner?');">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								//make new payment &/or edit banner
								if($slideshow_status == 0){
									?>
                                        <a href="<?php echo site_url()."vendor/edit-banner/".$slideshow_id.'/'.$page;?>" class="i_size" title="Edit">
                                        <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                                            
                                        </a>
                                        <a href="<?php echo site_url()."vendor/purchase-banner/".$slideshow_id.'/'.$page;?>" class="i_size" title="Deactivate" onclick="return confirm('Do you want to make a payment for this banner?');">
                            				<button class="btn btn-info btn-sm" type="button" ><i class="fa fa-money"></i> Purchase</button>
                                        </a>
                                    <?php
								}
								
								//renew payment
								else if(($expiry != NULL) && ($expiry < date('Y-m-d'))){
									?>
                                        <a href="<?php echo site_url()."vendor/renew-banner/".$slideshow_id.'/'.$page;?>" class="i_size" title="Activate" onclick="return confirm('Do you want to renew?');">
                            				<button class="btn btn-info btn-sm" type="button" ><i class="fa fa-money"></i> Renew</button>
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
				echo "You have not added any banners";
			}
		?>
</div>