<style type="text/css">
	div.brand-checkbox input[type="checkbox"] {
		display: none;
		margin: 4px 0 0 -20px;
	}
</style>
<!--left column-->
  
    <div class="col-lg-3 col-md-3 col-sm-12">
      <div class="panel-group" id="accordionNo">
       <!--Category--> 
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> 
            <a data-toggle="collapse"  href="#collapseCategory" class="collapseWill"> 
            <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Category 
            </a> 
            </h4>
          </div>
          
          <div id="collapseCategory" class="panel-collapse collapse in">
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked tree">
                
                <?php
                	if($parent_categories->num_rows() > 0)
					{
						$count = 0;
						$parents = $parent_categories->result();
						
						foreach($parents as $par)
						{
							$count++;
							$category_id = $par->category_id;
							$category_name = $par->category_name;
							$total_products = $this->users_model->count_items('product, category', 'product.category_id = category.category_id AND (category.category_id = '.$category_id.' OR category.category_parent = '.$category_id.')');
							$total_children = $this->users_model->count_items('category', 'category_parent = '.$category_id);
							
							if($count == 1)
							{
								$open = 'active open-tree';
							}
							else
							{
								$open = '';
							}
							
							if($total_children > 0)
							{
								echo
								'
								<li class="dropdown-tree '.$open.'" > 
									<a  class="dropdown-tree-a" > <span class="badge pull-right">'.$total_products.'</span> '.$category_name.' </a>
									<ul class="category-level-2 dropdown-menu-tree">
										<li > <a href="'.base_url().'products/category/'.$category_id.'"> All '.$category_name.' </a> </li>
								';
								//level 2
								if($all_children->num_rows() > 0)
								{
									$children = $all_children->result();
									
									foreach($children as $child)
									{
										$parent_id = $child->category_parent;
										
										if($parent_id == $category_id)
										{
											$child_id = $child->category_id;
											$child_name = $child->category_name;
											$total_child_products = $this->users_model->count_items('product, category', 'product.category_id = category.category_id AND (category.category_id = '.$child_id.' OR category.category_parent = '.$child_id.')');
											$total_child_children = $this->users_model->count_items('category', 'category_parent = '.$child_id);
											
											//level 3
											if($total_child_children > 0)
											{
												echo '
												<li class="dropdown-tree"> 
													<a class="dropdown-tree-a">  All '.$child_name.'</a>
														<ul class="category-level-2 dropdown-menu-tree">
															<li><a href="'.base_url().'products/category/'.$child_id.'"> All '.$child_name.'</a></li>';
												
												foreach($children as $child2)
												{
													$child_parent_id = $child2->category_parent;
													
													if($child_parent_id == $child_id)
													{
														$child_id2 = $child2->category_id;
														$child_name2 = $child2->category_name;
														$total_child_products2 = $this->users_model->count_items('product, category', 'product.category_id = category.category_id AND (category.category_id = '.$child_id2.' OR category.category_parent = '.$child_id2.')');
														echo '<li > <a href="'.base_url().'products/category/'.$child_id2.'"> '.$child_name2.' </a> </li>';
													}
												}
												
												echo '</ul></li>';
											}
											
											//no level 3 children
											else
											{
												echo '<li > <a href="'.base_url().'products/category/'.$child_id.'">'.$child_name.' </a> </li>';
											}
										}
										
									}
								}
								echo '</ul></li>';
							}
							
							else
							{
								echo
								'
								<li> <a href="'.base_url().'products/category/'.$category_id.'" > <span class="badge pull-right">'.$total_products.'</span> '.$category_name.' </a> </li>
								';
							}
						}
					}
				?>
              </ul>
            </div>
          </div>
        </div> <!--/Category menu end--> 
        
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> <a class="collapseWill" data-toggle="collapse"  href="#collapsePrice"> Price <span class="pull-left"> <i class="fa fa-caret-right"></i></span> </a> <span class="pull-right clearFilter  label-danger"> Clear </span> </h4>
          </div>
          <div id="collapsePrice" class="panel-collapse collapse in">
            <div class="panel-body priceFilterBody"> 
              <!-- -->
              <form action="<?php echo site_url().'products/price_range';?>" id="filter_price">
              <?php echo $price_range;?>
              <button type="submit" class="btn btn-default">Filter Price</button>
              </form>
              <hr>
              <p>Enter a Price range </p>
              <form class="form-inline price_range" role="form" action="<?php echo site_url().'products/price_range';?>" id="filter_custom_price">
                <div class="form-group">
                  <input type="text" class="form-control" name="start_price" placeholder="2000">
                </div>
                <div class="form-group sp"> - </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="end_price" placeholder="3000">
                </div>
                <button type="submit" class="btn btn-default pull-right">Filter</button>
              </form>
            </div>
          </div>
        </div> <!--/price panel end--> 
        
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"> <a data-toggle="collapse"  href="#collapseBrand" class="collapseWill"> Brand <span class="pull-left"> <i class="fa fa-caret-right"></i></span> </a> </h4>
          </div>
          <div id="collapseBrand" class="panel-collapse collapse in">
            <div class="panel-body smoothscroll maxheight300 brand-checkbox">
              <form action="<?php echo site_url().'products/filter-brands';?>" id="filter_brand" method="POST">
            <?php
            	if($brands->num_rows() > 0)
				{
					$brands_result = $brands->result();
					
					foreach($brands_result as $brand)
					{
						$brand_name = $brand->brand_name;
						$brand_id = $brand->brand_id;
						
						echo 
						'
							<div class="block-element">
								<label> <input type="checkbox" name="brand[]" value="'.$brand_id.'"  /> '.$brand_name.' </label>
                            </div>

						';
					}
				}
			?>
              <button type="submit" class="btn btn-default">Filter Brands</button>
              </form>
            </div>
          </div>
        </div> <!--/brand panel end-->
        
      </div>
    </div>
    
<script type="text/javascript">

//Sort by price range
$(document).on("submit","form#filter_price",function(e)
{
	e.preventDefault();
	
	var range = $('input[name="agree"]:checked').val();
	
	window.location.href = '<?php echo site_url();?>products/price-range/'+range;
});

//Sort by custom price range
$(document).on("submit","form#filter_custom_price",function(e)
{
	e.preventDefault();
	
	var start = $('input[name="start_price"]').val();
	var end = $('input[name="end_price"]').val();
	
	window.location.href = '<?php echo site_url();?>products/price-range/'+start+'-'+end;
});
</script>