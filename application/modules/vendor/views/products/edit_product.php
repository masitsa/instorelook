          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
          <a href="<?php echo site_url().'vendor/all-products';?>" class="btn btn-sm btn-info">Back to products</a>
            <!-- Adding Errors -->
            <?php
			
			//the product details
			$sale_price = $product[0]->sale_price;
			$featured = $product[0]->featured;
			$category_id = $product[0]->category_id;
			$brand_id = $product[0]->brand_id;
			$product_id = $product[0]->product_id;
			$product_name = $product[0]->product_name;
			$product_buying_price = $product[0]->product_buying_price;
			$product_status = $product[0]->product_status;
			$product_selling_price = $product[0]->product_selling_price;
			$image = $product[0]->product_image_name;
			$thumb = $product[0]->product_thumb_name;
			$product_description = $product[0]->product_description;
			$product_balance = $product[0]->product_balance;
			$brand_name = $product[0]->brand_name;
			$category_name = $product[0]->category_name;
			$minimum_order_quantity = $product[0]->minimum_order_quantity;
			$maximum_purchase_quantity = $product[0]->maximum_purchase_quantity;
            $sale_price_type = $product[0]->sale_price_type;
            $product_image_name = $product[0]->product_image_name;
            $product_thumb_name = $product[0]->product_thumb_name;
			
			//product locations
			$total = $product_locations->num_rows();
			$count = 5;
			$r = 0;
			if($total > 0)
			{
				$result = $product_locations->result();
				while($r < $total)
				{
					$location[$r] = $result[$r]->post_code;
					$r++;
				}
			}
			
			while($r < $count)
			{
				$location[$r] = '';
				$r++;
			}
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
			{
				$locations = $this->input->post('product_locations');//var_dump($locations);
				$r = 0;
				while($r < 5)
				{
					$location[$r] = $locations[$r];
					$r++;
				}
				$sale_price = set_value('sale_price');
				$featured = set_value('featured');
				$product_name = set_value('product_name');
				$product_buying_price = set_value('product_buying_price');
				$product_status = set_value('product_status');
				$product_selling_price = set_value('product_selling_price');
				$image = set_value('product_image_name');
				$product_description = set_value('product_description');
				$product_balance = set_value('product_balance');
				$brand_name = set_value('brand_name');
				$category_name = set_value('category_name');
                $other_post_code_1 = set_value('other_post_code_1');
                $other_post_code_2 = set_value('other_post_code_2');
                $other_post_code_3 = set_value('other_post_code_3');
                $other_post_code_4 = set_value('other_post_code_4');
            }
			
			//product image
			if(!empty($image))
			{
				$image = base_url()."assets/images/products/images/".$image;
			}
			
			else
			{
				$image = 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image';
			}
			
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <input type="hidden" name="current_image" value="<?php echo $product_image_name;?>"/>
            <input type="hidden" name="current_thumb" value="<?php echo $product_thumb_name;?>"/>
            <!-- Adding Errors -->
            <?php
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger center-align"> Oh snap! '.$validation_errors.' </div>';
            }
			$error = $this->session->userdata('error_message');
			$success = $this->session->userdata('success_message');
			if(!empty($error))
			{
				echo '<div class="alert alert-danger">'.$error.'</div>';
				$this->session->unset_userdata('error_message');
			}
			
			if(!empty($success))
			{
				echo '<div class="alert alert-success">'.$success.'</div>';
				$this->session->unset_userdata('success_message');
			}
            ?>
         	<div class="row">
            	<div class="col-md-6">
                    
                    <!-- product Name -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Name <span class="required">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="product_name" placeholder="Product Name" value="<?php echo $product_name;?>">
                        </div>
                    </div>
                    <!-- Product Category -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Category <span class="required">*</span></label>
                        <div class="col-lg-8">
                            <select name="category_id" id="category_id" class="form-control">
                                <?php
                                echo '<option value="0">No Category</option>';
                                if($all_categories->num_rows() > 0)
                                {
                                    $result = $all_categories->result();
                                    
                                    foreach($result as $res)
                                    {
                                        if($res->category_id == $category_id)
                                        {
                                            echo '<option value="'.$res->category_id.'" selected>'.$res->category_name.'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$res->category_id.'">'.$res->category_name.'</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                    <!-- Product brand -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Brand</label>
                        <div class="col-lg-8">
                            <select name="brand_id" class="form-control">
                                <?php
                                echo '<option value="0">No Brand</option>';
                                if($all_brands->num_rows() > 0)
                                {
                                    $result = $all_brands->result();
                                    
                                    foreach($result as $res)
                                    {
                                        if($res->brand_id == $brand_id)
                                        {
                                            echo '<option value="'.$res->brand_id.'" selected>'.$res->brand_name.'</option>';
                                        }
                                        else
                                        {

                                            echo '<option value="'.$res->brand_id.'">'.$res->brand_name.'</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div> 
                    <!-- Product locations -->
                    <div class="form-group multiselect_items">
                        <label for="categories" class="col-sm-4 control-label">Post code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="product_locations[]" placeholder="E.g. 4231" value="<?php echo $location[0]?>">
                        </div>
                    </div>
                     <div class="form-group multiselect_items">
                        <label for="categories" class="col-sm-4 control-label">Other Post code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control col-lg-4" name="product_locations[]" size="4" placeholder="E.g. 4231" value="<?php echo $location[1]?>">

                        </div>
                         <div class="col-sm-4">
                            <input type="text" class="form-control col-lg-4" name="product_locations[]" size="4" placeholder="E.g. 4231"  value="<?php echo $location[2]?>">

                        </div>
                    </div>
                    <div class="form-group multiselect_items">
                        <label for="categories" class="col-sm-4 control-label">Other Post code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control col-lg-4" name="product_locations[]" size="4" placeholder="E.g. 4231"  value="<?php echo $location[3]?>">

                        </div>
                         <div class="col-sm-4">
                            <input type="text" class="form-control col-lg-4" name="product_locations[]" size="4" placeholder="E.g. 4231"  value="<?php echo $location[4]?>">
                        </div>
                    </div>
                    <!-- Product Buying Price -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Buying Price</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="product_buying_price" placeholder="Product Buying Price" value="<?php echo $product_buying_price;?>">
                        </div>
                    </div>
                    <!-- Product Selling Price -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Selling Price <span class="required">*</span></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="product_selling_price" placeholder="Product Selling Price" value="<?php echo $product_selling_price;?>">
                        </div>
                    </div>
                    <div class="form-group">
                         <label class="col-lg-4 control-label">Sale price type</label>
                          <div class="col-lg-8">
                            <?php
                             if($all_discount_types->num_rows() > 0)
                                {
                                    $result = $all_discount_types->result();
                                    
                                    foreach($result as $res)
                                    {
                                        $type_id = $res->discount_type_id;

                                        if($sale_price_type == $type_id)
                                        {
                                            ?>
                                                <input type="radio" name="sale_price_type_id" value="<?php echo $res->discount_type_id?>" checked="checked" onclick="discount_type(<?php echo $res->discount_type_id?>)"><?php echo $res->discount_type_name;?>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <input type="radio" name="sale_price_type_id" value="<?php echo $res->discount_type_id?>" onclick="discount_type(<?php echo $res->discount_type_id?>)"><?php echo $res->discount_type_name;?>
                                            <?php
                                        }
                                        
                                    }
                                }
                              ?>
                         
                        </div>
                    </div>
                    <!-- Product Sale Price -->

                    <div id="percentage_div" class="form-group" style="display:none;">
                        <label class="col-lg-4 control-label">Sale % Off</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="product_sale_price" placeholder="Product Sale Price" value="<?php echo $sale_price;?>">
                        </div>
                    </div>
                    <div id="amount_div" class="form-group" style="display:none;">
                        <label class="col-lg-4 control-label">Amount $ off</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="product_sale_price" placeholder="Product Sale Price" value="<?php echo $sale_price;?>">
                        </div>
                    </div>
                    <!-- Product Balance -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Balance <span class="required">*</span></label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" name="product_balance" placeholder="Product Balance" value="<?php echo $product_balance;?>">
                        </div>
                    </div>
                    <!-- Minimum order qty -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Minimum Order Quantity</label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" name="minimum_order_quantity" placeholder="Minimum Order Quantity" value="<?php echo $minimum_order_quantity;?>">
                        </div>
                    </div>
                    <!-- Maximum purchase qty -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Maximum Purchase Quantity</label>
                        <div class="col-lg-8">
                            <input type="number" class="form-control" name="maximum_purchase_quantity" placeholder="Maximum Purchase Quantity" value="<?php echo $maximum_purchase_quantity;?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                
                    <!-- Image -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Product Image</label>
                        <div class="col-lg-8">
                            
                            <div class="row">
                            
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="height:160px; width:212px;">
                                    		<img src="<?php echo $image;?>">
                                        </div>
                                        <div>
                                            <span class="btn btn-file btn-info"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="product_image"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Gallery Images -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Gallery Images</label>
                        <div class="col-lg-8">
                            <?php echo form_upload(array( 'name'=>'gallery[]', 'multiple'=>true, 'class'=>'btn'));?>
                            <?php
                            	if($gallery_images->num_rows() > 0)
								{
									$galleries = $gallery_images->result();
									
									foreach($galleries as $gal)
									{
										$thumb = $gal->product_image_thumb;
										$gal_image = $gal->product_image_thumb;
										$product_image_id = $gal->product_image_id;
										?>
                                        <div class="col-md-4">
                                        	<a href="<?php echo site_url()."vendor/products/delete_gallery_image/".$product_image_id.'/'.$product_id.'/'.$gal_image.'/'.$thumb;?>" style="color:red;"><img src="<?php echo base_url()."assets/images/products/gallery/".$thumb;?>"/>Delete</a>
                                        </div>
                                        <?php
									}
								}
							?>
                        </div>
                    </div>
                    <!-- Activate checkbox -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Activate product?</label>
                        <div class="col-lg-8">
                            <div class="radio">
                                <label>
                                    <?php
                                    if($product_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="product_status">';}
                                    else{echo '<input id="optionsRadios1" type="radio" value="1" name="product_status">';}
                                    ?>
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <?php
                                    if($product_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="product_status">';}
                                    else{echo '<input id="optionsRadios1" type="radio" value="0" name="product_status">';}
                                    ?>
                                    No
                                </label>
                            </div>
                        </div>
                    </div> 
                    <!-- Featured checkbox -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Featured product?</label>
                        <div class="col-lg-8">
                            <div class="radio">
                                <label>
                                    <?php
                                    if($featured == 1){echo '<input id="optionsRadios3" type="radio" checked value="1" name="featured">';}
                                    else{echo '<input id="optionsRadios3" type="radio" value="1" name="featured">';}
                                    ?>
                                    Yes
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <?php
                                    if($featured == 0){echo '<input id="optionsRadios4" type="radio" checked value="0" name="featured">';}
                                    else{echo '<input id="optionsRadios4" type="radio" value="0" name="featured">';}
                                    ?>
                                    No
                                </label>
                            </div>
                        </div>
                    </div> 
                    
                    <!-- Features -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Features</label>
                        <div class="col-lg-8">
                            <button class="submit btn btn-success" type="button" data-toggle="modal" data-target="#features_modal">
                                Edit Features
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12">
                    <!-- Product Description -->
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Product Description <span class="required">*</span></label>
                      <div class="col-lg-10">
                         <textarea name="product_description"><?php echo $product_description;?></textarea>
                      </div>
                    </div>
            	</div>
            </div>
            
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit product
                </button>
            </div>
            <?php echo form_close();?>
            
            <div class="modal fade" id="features_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Product Features</h4>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <!-- Features -->
                                <div class="col-md-12" id="features">
                                	<div class="alert alert-warning">Remember to click the <button type="button" class="btn btn-primary btn-sm">Edit product</button> button to update your features</div>
                                    <?php $this->load->view('products/edit_features');?>
                                </div>
                                <!-- End features -->
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
<?php echo $this->load->view('vendor/multiselect_js');?>
<script src="<?php echo base_url().'assets/themes/tinymce/js/';?>tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
<script type="text/javascript">
    $(document).ready(function(){
      discount_type(<?php echo $sale_price_type;?>);
    });
    function discount_type(id){

        var myTarget1 = document.getElementById("percentage_div");
        var myTarget2 = document.getElementById("amount_div");
        if(id == 1)
        {
          myTarget1.style.display = 'none';
          myTarget2.style.display = 'none';
        }
        else if(id == 2)
        {
          myTarget1.style.display = 'block';
          myTarget2.style.display = 'none';
        }
        else if(id == 3)
        {
          myTarget1.style.display = 'none';
          myTarget2.style.display = 'block';
        }
        else
        {
          myTarget1.style.display = 'none';
          myTarget2.style.display = 'none';
        }
        
    }
	$(document).on("change","select#category_id",function()
	{			
		value = $(this).val();
		
		var features = $.ajax(
		{
			url: '<?php echo site_url();?>vendor/products/get_category_features/'+value,
			processData: false,
			contentType: false,
			cache: true
		});
		features.done(function(code) {
			if((code == "null") || (code == null)){
				$('div#features').fadeIn('slow').html('');
			}
			else{
				$('div#features').fadeIn('slow').html(code);
			}
		});
	});
	
	//Add Feature
	$(document).on("submit","div.tab-content form",function(e)
	{
		e.preventDefault();
		
		var formData = new FormData(this);
		
		var category_feature_id = $(this).attr('name');

		$.ajax({
			type:'POST',
			url: $(this).attr('action'),
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(data){
				
				if(data.result == "success")
				{
					$("#new_features"+category_feature_id).html(data.result_options);
					$("#cat_feature"+category_feature_id)[0].reset();
				}
				else
				{
					$("#new_features"+category_feature_id).html(data);
				}
			},
			error: function(xhr, status, error) {
				alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				$("#new_features"+category_feature_id).html(error);
			}
		});
		return false;
	});
	
	//Delete Feature
	$(document).on("click","a.delete_product_feature",function()
	{
		var product_feature_id = $(this).attr('href');
		
		var row = $.ajax(
		{
			url: '<?php echo site_url();?>vendor/products/delete_product_feature/'+product_feature_id,
			processData: false,
			contentType: false,
			cache: true
		});
		row.done(function(data) {
			$("div#features").html(data);
		});
		return false;
	});
</script>