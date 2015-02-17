<div class="row" style="background-color:#fff; margin-bottom:5px;">
	<!-- Widget -->
	<div class="widget boxed" >
	    <!-- Widget head -->
	    <div class="widget-head">
	        <h3 style="text-align:center;"><i class="icon-reorder"></i>Search All Features
	        </h3>
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
				
				
				echo form_open("vendor/search-features", array("class" => "form-horizontal"));
				
	            
	            ?>
	            <div class="row">
		                <div class="col-md-6 col-lg-6">
		                    <div class="form-group center-align">
		                        <label class="col-sm-4 control-label">Feature Name: </label>
		                        
		                        <div class="col-sm-6">
		                            <input type="text" class="form-control" name="feature_name" placeholder="Feature Name">
		                        </div>
		                    </div>
		                </div>
		                <div class="col-md-6 col-lg-6">
		                    <div class="form-group center-align">
		                        <label class="col-sm-4 control-label">Category name: </label>
		                        
		                        <div class="col-sm-6">
		                            <select name="category_id" class="form-control" required>
				                        <?php
				                        echo '<option value="0">All Categories</option>';
				                        if($all_categories->num_rows() > 0)
				                        {
				                            $result = $all_categories->result();
				                            
				                            foreach($result as $res)
				                            {
												$category = $res->category_name;
												if($category == 'No Category'){$category = 'All Categories';}
												
				                                if($res->category_id == set_value('category_id'))
				                                {
				                                    echo '<option value="'.$res->category_id.'" selected>'.$category.'</option>';
				                                }
				                                else
				                                {
				                                    echo '<option value="'.$res->category_id.'">'.$category.'</option>';
				                                }
				                            }
				                        }
				                        ?>
				                    </select>
		                        </div>
		                    </div>
		                </div>
	            </div>
	            
	            <div class="row center-align">
	            	<button type="submit" class="btn btn-info btn-lg">Search</button>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>