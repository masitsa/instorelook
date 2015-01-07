<div class="row" style="background-color:#fff; margin-bottom:5px;">
	<!-- Widget -->
	<div class="widget boxed" >
	    <!-- Widget head -->
	    <div class="widget-head">
	        <h4 style="text-align:center;"><i class="icon-reorder"></i>Search All Products</h4>
	        <div class="widget-icons pull-right">
	            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
	            <a href="#" class="wclose"><i class="icon-remove"></i></a>
	        </div>
	    
	    	<div class="clearfix"></div>
	    
	    </div>             
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	    	<div class="padd">
				<?php
				
				
				echo form_open("vendor/search-products", array("class" => "form-horizontal"));
				
	            
	            ?>
	            <div class="row">
	           		<div class="col-md-11">
		                <div class="col-md-6">
		                    <div class="form-group">
		                        <label class="col-lg-5 control-label">Product Name: </label>
		                        
		                        <div class="col-lg-7">
		                            <input type="text" class="form-control" name="product_name" placeholder="Product Name">
		                        </div>
		                    </div>
		                     <div class="form-group">
		                        <label class="col-lg-5 control-label">Product Code: </label>
		                        
		                        <div class="col-lg-7">
		                            <input type="text" class="form-control" name="product_code" placeholder="Product code">
		                        </div>
		                    </div>
		                </div>
		                
		                <div class="col-md-6">
		                    
		                    <div class="form-group">
		                        <label class="col-lg-5 control-label">Product Category: </label>
		                        
		                        <div class="col-lg-7">
		                             <select name="category_id" id="category_id" class="form-control">
		                                <?php
		                                echo '<option value="0">No Category</option>';
		                                if($all_categories->num_rows() > 0)
		                                {
		                                    $result = $all_categories->result();
		                                    
		                                    foreach($result as $res)
		                                    {
		                                        if($res->category_id == set_value('category_id'))
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
		                    
		                    <div class="form-group">
		                        <label class="col-lg-5 control-label">Product Brand: </label>
		                        
		                        <div class="col-lg-7">
		                            <select name="brand_id" class="form-control">
		                                <?php
		                                echo '<option value="0">No Brand</option>';
		                                if($all_brands->num_rows() > 0)
		                                {
		                                    $result = $all_brands->result();
		                                    
		                                    foreach($result as $res)
		                                    {
		                                        if($res->brand_id == set_value('brand_id'))
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
		                </div>
		              </div>
	            </div>
	            
	            <div class="center-align">
	            	<button type="submit" class="btn btn-info btn-lg">Search</button>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>