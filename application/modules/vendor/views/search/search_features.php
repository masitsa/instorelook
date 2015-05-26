<div class="row">
	<!-- Widget -->
	<div class="widget boxed">
	    <!-- Widget head -->
        <div class="widget-head">
            <h4 class="pull-left"><i class="fa fa-search"></i>Search all features</h4>
            <div class="clearfix"></div>
        </div>      
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	    	<div class="">
				<?php
				echo form_open("vendor/search-features", array("class" => "form-inline"));
	            ?>
                <div class="row">
                    <div class="col-md-12 col-lg-12 center-align">
                        <div class="form-group">
                            <label class="control-label">Feature Name: </label>
                            <input type="text" class="form-control" name="feature_name" placeholder="Feature name">
                        </div>
                        <div class="form-group">
                        	<label class="control-label">Category name: </label>
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-lg">Search</button>
                        </div>
                    </div>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>