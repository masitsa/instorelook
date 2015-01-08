<?php
foreach ($bundle_query->result() as $row)
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
	$product_bundle_price = $row->product_bundle_price;
	$query = $this->products_model->get_gallery_images($product_bundle_id);
	$galleries = '';
	if ($query->num_rows() > 0)
	{
		$gallery_images = $query->result();
		
		foreach ($gallery_images as $gal)
		{
			$gallery_thumb = $gal->product_image_thumb;
			
			$galleries .= '<div class="col-md-4"><img src="'.base_url()."assets/images/product_bundle/gallery/".$gallery_thumb.'"></div>';
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
}	

?>
<div class="row" style="background-color:#fff; margin-bottom:5px;">
	<!-- Widget -->
	<div class="widget boxed" >
	    <!-- Widget head -->
	    <div class="widget-head">
	        <h4 style="text-align:center;"><i class="icon-reorder"></i><?php echo $product_bundle_name;?></h4>
	        <div class="widget-icons pull-right">
	            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
	            <a href="#" class="wclose"><i class="icon-remove"></i></a>
	        </div>
	    
	    	<div class="clearfix"></div>
	    
	    </div>             
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	          <div class="padd">
	          	<a href="<?php echo site_url().'vendor/all-product-bundle';?>" class="btn btn-sm btn-info">Back to product bundles</a>
				<?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
	         	<div class="row">
	            	<div class="col-md-6">
	                    <!-- Adding Errors -->
	                    <?php
	                    if(isset($error)){
	                        echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
	                    }
	                    
	                    $validation_errors = validation_errors();
	                    
	                    if(!empty($validation_errors))
	                    {
	                        echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
	                    }
	                    ?>
	                    
	                    <!-- product Name -->
	                    <div class="form-group">
	                        <div class="col-lg-11">
	                            
	                              <?php echo '<img src="'.base_url()."assets/images/product_bundle/images/".$image.'">';?>
	                        </div>
	                    </div>
	                    
	                </div>
	                <div class="col-md-6">
	                
	                     <!-- Product Buying Price -->
	                    <div class="form-group">
	                        <label class="col-lg-4 control-label">Bundle price :</label>
	                        <div class="col-lg-7">
	                           <?php echo $product_bundle_price;?>
	                        </div>
	                    </div>
	                  	  <!-- Activate checkbox -->
	                    <div class="form-group">
	                        <label class="col-lg-4 control-label">Activate product bundle : </label>
	                        <div class="col-lg-7">
	                            <?php echo $status;?>
	                        </div>
	                    </div> 
	                    <!-- Gallery Images -->
	                    <div class="form-group">
	                        <label class="col-lg-4 control-label">Gallery Images</label>
	                        <div class="col-lg-7">
	                            <?php echo $galleries;?>
	                        </div>
	                    </div>
	                  	<div class="form-group">
	                      <label class="col-lg-4 control-label">Bundle Description <span class="required">*</span></label>
	                      <div class="col-lg-7">
	                        <?php echo $product_bundle_description;?>
	                      </div>
	                    </div>
	                
	                </div>
	            </div>
	           
	            <?php echo form_close();?>
	            
	           
			</div>
	    </div>
	</div>
</div>