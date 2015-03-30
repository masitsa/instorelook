
<div class="panel-group" id="accordionNo">
	
    <!-- Postcode --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-location" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Location 
                </h4>
            </a>
		</div>
        
        <div id="collapse-location" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php 
				echo form_open('businesses/filter-postcode', array('class' => 'form-horizontal', 'role' => 'form'));
				echo form_hidden('filter_categories', $filter_categories);
				echo form_hidden('filter_search', $filter_search);
				?>
                    <li>
                        <input class="form-control" type="text" placeholder="Search post code" name="search_item">
                        <div class="center-align" style="margin-top:10px;">
                            <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter post code</button>
                        </div>
                    </li>
                <?php
                echo form_close();
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End postcode --> 
	
    <!-- Search --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-location" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Business name 
                </h4>
            </a>
		</div>
        
        <div id="collapse-location" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php 
				echo form_open('businesses/filter-business-name', array('class' => 'form-horizontal', 'role' => 'form'));
				echo form_hidden('filter_categories', $filter_categories);
				echo form_hidden('filter_postcode', $filter_postcode);
				?>
                    <li>
                        <input class="form-control" type="text" placeholder="Search business name" name="search_item">
                        <div class="center-align" style="margin-top:10px;">
                            <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter business name</button>
                        </div>
                    </li>
                <?php
                echo form_close();
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End search --> 
	
    <!-- sellers --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-latest-sellers" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Categories
                </h4>
            </a> 
		</div>
        
        <div id="collapse-latest-sellers" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php
                    echo form_open('businesses/filter-categories');
					echo form_hidden('filter_postcode', $filter_postcode);
					echo form_hidden('filter_search', $filter_search);
                    
                    if($parent_categories->num_rows() > 0)
                    {
                        $parent_categories_result = $parent_categories->result();
                        
                        foreach($parent_categories_result as $sel)
                        {
                            $category_name = $sel->category_name;
                            $category_id = $sel->category_id;
                            $web_name = $this->site_model->create_web_name($category_name);
							
                            if(is_array($categories_array))
                            {
                                $total_categories = count($categories_array);
                                $checked = '';
                                
                                for($r = 0; $r < $total_categories; $r++)
                                {
                                    if($categories_array[$r] == $web_name)
                                    {
                                        $checked = 'checked = "checked"';
                                        break;
                                    }
                                }
                            
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="category_name[]" value="'.$web_name.'" id="category_name'.$category_id.'" '.$checked.'/>
                                        <label for="category_name'.$category_id.'"><span></span> '.$category_name.'</label>
                                    </li>
                    
                                ';
                            }
                            
                            else
                            {
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="category_name[]" value="'.$web_name.'" id="category_name'.$category_id.'"/>
                                        <label for="category_name'.$category_id.'"><span></span> '.$category_name.'</label>
                                    </li>
                    
                                ';
                            }
                        }
                        
                        echo 
                        '
                            <div class="center-align">
                                <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter categories</button>
                            </div>
                        ';
                    }
                    
                    else
                    {
                        echo '<p>There are no top sellers :-(</p>';
                    }
                    echo form_close();
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End sellers --> 
    
</div><!-- End panel group -->

            