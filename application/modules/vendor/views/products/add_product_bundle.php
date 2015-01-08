          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
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
                        <label class="col-lg-4 control-label">Bundle name <span class="required">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="product_bundle_name" placeholder="Product bundle name" value="<?php echo set_value('product_name');?>">
                        </div>
                    </div>
                    
                    
                    <!-- Product Buying Price -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Bundle price</label>
                        <div class="col-lg-7">
                            <input type="number" class="form-control" name="product_bundle_price" placeholder="Product bundle Price" value="<?php echo set_value('product_buying_price');?>">
                        </div>
                    </div>
                  	  <!-- Activate checkbox -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Activate product bundle?</label>
                        <div class="col-lg-7">
                            <input id="optionsRadios1" type="radio" checked value="1" name="product_bundle_status">Yes
                            <input id="optionsRadios2" type="radio" value="0" name="product_bundle_status">No 
                        </div>
                    </div> 
                   
                   
                
                </div>
                <div class="col-md-6">
                
                    <!-- Image -->
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Bundle Image</label>
                        <div class="col-lg-7">
                            
                            <div class="row">
                            
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="height:160px; width:212px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" />
                                        </div>
                                        <div>
                                            <span class="btn btn-file btn-info"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="product_bundle_image"></span>
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
                        <div class="col-lg-7">
                            <?php echo form_upload(array( 'name'=>'gallery[]', 'multiple'=>true, 'class'=>'btn'));?>
                        </div>
                    </div>
                  
                
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12">
                    <!-- Product Description -->
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Bundle Description <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <textarea name="product_bundle_description"><?php echo set_value('product_bundle_description');?></textarea>
                      </div>
                    </div>
            	</div>
            </div>
            
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add product bundle
                </button>
            </div>
            <?php echo form_close();?>
            
           
		</div>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
<script type="text/javascript">
	
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
	$(document).on("click","a.delete_feature",function()
	{
		var category_feature_id = $(this).attr('id');
		var delete_row = $(this).attr('href');
		var row = $.ajax(
		{
			url: '<?php echo site_url();?>vendor/products/delete_new_feature/'+category_feature_id+'/'+delete_row,
			processData: false,
			contentType: false,
			cache: true
		});
		row.done(function(data) {
			$("#new_features"+category_feature_id).html(data);
		});
		return false;
	});
</script>