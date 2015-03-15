<?php
	$all_categories = $this->site_model->get_all_categories();
	$parent_categories = $this->site_model->get_parent_categories();
	$count = 0;
	$per_column = round($parent_categories->num_rows()/3);
	
	if($parent_categories->num_rows() > 0)
	{
		$categories = '';
		
		foreach($parent_categories->result() as $res)
		{
			$category_name = $res->category_name;
			$category_id = $res->category_id;
			$category_web_name = $this->site_model->create_web_name($category_name);
			
			if(($count % $per_column) == 0)
			{
				if($count == 0)
				{
					$categories .= '<li class="col-sm-3"><ul>';
				}
				
				else
				{
					$categories .= '</ul></li><li class="col-sm-3"><ul>';
				}
			}
			
			else
			{
				$categories .= '';
			}
			$count++;
			
			$categories .= '<li class="dropdown-header">'.$category_name.'</li>
			<li><a href="category/'.$category_web_name.'">All '.$category_name.'</a></li>
			';
			
			if($all_categories->num_rows() > 0)
			{
				foreach($all_categories->result() as $cat_res)
				{
					$category_parent = $cat_res->category_parent;
					$child_id = $cat_res->category_parent;
					$child_name = $cat_res->category_parent;
					$child_web_name = $this->site_model->create_web_name($child_name);
					
					if($category_id == $category_parent)
					{
						$categories .= '<li><a href="category/'.$child_web_name.'">'.$child_name.'</a></li>';
					}
				}
			}
			$categories .= '<li class="divider"></li>';
		}
		$categories .= '</ul></li>';
	}
	
	else
	{
		$categories = '';
	}
?>
 		<!-- Title -->
        <div class="title">
        	<div class="container">
        		<!-- <h1>in store look</h1> -->
                <img class="img-responsive" src="<?php echo base_url().'assets/images/logo.png';?>"/>
            </div>
        </div>
        <!-- End Title -->
        
        <div class="clear-both"></div>
        
        <!-- Navigation -->
        <div class="navigation">
        	<div class="container">
                <nav class="navbar navbar-default blue-background" role="navigation">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <a class="navbar-brand" href="#">Categories</a>
                            </button>
                        </div>
                        
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="fa fa-shopping-cart colorWhite"> </i> <span class="cartRespons colorWhite" id="menu_cart_total"> Cart (KES <?php echo $this->load->view('site/cart/cart_total', '', TRUE);?>) </span> </button>
                
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse js-navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                            	
                                <li class="dropdown mega-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">All Categories <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                                    
                                    <ul class="dropdown-menu mega-dropdown-menu row">

                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">New in Stores</li>                            
                                                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                  <div class="carousel-inner">
                                                    <div class="item active">
                                                        <a href="#"><img src="http://placehold.it/254x150/3498db/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 1"></a>
                                                        <h4><small>Summer dress floral prints</small></h4>                                        
                                                        <button class="btn btn-primary" type="button">$49.99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>       
                                                    </div><!-- End Item -->
                                                    <div class="item">
                                                        <a href="#"><img src="http://placehold.it/254x150/ef5e55/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 2"></a>
                                                        <h4><small>Gold sandals with shiny touch</small></h4>                                        
                                                        <button class="btn btn-primary" type="button">$9.99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>        
                                                    </div><!-- End Item -->
                                                    <div class="item">
                                                        <a href="#"><img src="http://placehold.it/254x150/2ecc71/f5f5f5/&text=New+Collection" class="img-responsive" alt="product 3"></a>
                                                        <h4><small>Denin jacket stamped</small></h4>                                        
                                                        <button class="btn btn-primary" type="button">$49.99</button> <button href="#" class="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Wishlist</button>      
                                                    </div><!-- End Item -->                                
                                                  </div><!-- End Carousel Inner -->
                                                </div><!-- /.carousel -->
                                                <li class="divider"></li>
                                                <li><a href="#">View all products <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
                                            </ul>
                                        </li>
                                        <?php echo $categories;?>
                                        <!--<li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Dresses</li>
                                                <li><a href="#">Unique Features</a></li>
                                                <li><a href="#">Image Responsive</a></li>
                                                <li><a href="#">Auto Carousel</a></li>
                                                <li><a href="#">Newsletter Form</a></li>
                                                <li><a href="#">Four columns</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Tops</li>
                                                <li><a href="#">Good Typography</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Jackets</li>
                                                <li><a href="#">Easy to customize</a></li>
                                                <li><a href="#">Glyphicons</a></li>
                                                <li><a href="#">Pull Right Elements</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Pants</li>
                                                <li><a href="#">Coloured Headers</a></li>
                                                <li><a href="#">Primary Buttons & Default</a></li>
                                                <li><a href="#">Calls to action</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-sm-3">
                                            <ul>
                                                <li class="dropdown-header">Accessories</li>
                                                <li><a href="#">Default Navbar</a></li>
                                                <li><a href="#">Lovely Fonts</a></li>
                                                <li><a href="#">Responsive Dropdown </a></li>							
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Newsletter</li>
                                                <form class="form" role="form">
                                                  <div class="form-group">
                                                    <label class="sr-only" for="email">Email address</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter email">                                                              
                                                  </div>
                                                  <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                                </form>                                                       
                                            </ul>
                                        </li> -->
                                    </ul>
                                    
                                </li>
                                 <li><a href="<?php echo site_url().'home';?>">Home</a></li>
                                
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Beauty</a></li>
                                <li><a href="#">Automotive</a></li>
                                <li><a href="<?php echo site_url().'products';?>">Products</a></li>
                                <li><a href="<?php echo site_url().'vendors';?>">Vendors</a></li>
                            </ul>
                            <?php echo $this->load->view('site/cart/mini_cart', '', TRUE);?>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
			</div><!-- /.Container -->
		</div><!-- /.Navigation -->