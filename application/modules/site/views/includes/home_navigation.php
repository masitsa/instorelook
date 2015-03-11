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
			
			$categories .= '<li class="dropdown-header">'.$res->category_name.'</li>
			<li><a href="category/'.$res->category_id.'">All '.$res->category_name.'</a></li>
			';
			
			if($all_categories->num_rows() > 0)
			{
				foreach($all_categories->result() as $cat_res)
				{
					if($res->category_id == $cat_res->category_parent)
					{
						$categories .= '<li><a href="category/'.$cat_res->category_id.'">'.$cat_res->category_name.'</a></li>';
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
        <div class="header-top">
            <div class="container">
                <div class="pull-left auto-width-left">
                	<ul class="top-menu menu-beta l-inline">
                    	<li><a href="tel:0405486426"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> 0405 486 426</a></li>
                        <li><a href="mailto:info@instorelook.com.au"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> info@instorelook.com.au</a></li>
                    </ul>
                </div>
                
                <div class="pull-right auto-width-right">
                	<ul class="top-menu menu-beta l-inline">
                    	<?php
                        if($this->session->userdata('login_status'))
						{
							?>
                            <li><a href="<?php echo site_url().'account'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                            <?php
						}
						
						else
						{
							?>
                            <!--<li><a href="<?php echo site_url().'sign-in'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign in</a></li>-->
                            <li><a href="<?php echo site_url().'join'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Join</a></li>
                            <?php
						}
						?>
                    	
                    	<li><a href="<?php echo site_url().'account/wishlist'?>"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Wishlist</a></li>
                        <li><a href="<?php echo site_url().'customer-request'?>"><span class="glyphicon glyphicon-resize-small" aria-hidden="true"></span> Requests</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Title -->
        <div class="title">
        	<div class="container">
            <div class="clear"></div>
        		<!-- <h1>in store look</h1> -->
                <div class="pull-left">
                	<img class="img-responsive" src="<?php echo base_url().'assets/images/logo.png';?>"/>
                </div>
                <div class="pull-right">
                	<form id="searchform" action="/" method="get" role="search">
                        <input id="s" type="text" placeholder="Search entire store here..." name="s" value="">
                        <button id="searchsubmit" class="glyphicon glyphicon-search" type="submit"></button>
                    </form>
                </div>
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
                        
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="glyphicon glyphicon-shopping-cart"> </i> <span class="cartRespons colorWhite" id="menu_cart_total"> Cart ($<?php echo $this->load->view('site/cart/cart_total', '', TRUE);?>) </span> </button>
                
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
                                                      <?php
                                                      $this->load->model('vendor/products_model');
                                                        $products_path = realpath(APPPATH . '../assets/images/products/images');
                                                        $products_location = base_url().'assets/images/products/images/';
                                                      $latest = $this->products_model->get_latest_products();
                                                      if($latest->num_rows() > 0)
                                                        {
                                                            $latest_product = $latest->result();
                                                            $x = 0;
                                                            foreach($latest_product as $prods)
                                                            {
                                                                $sale_price = $prods->sale_price;
                                                                $thumb = $prods->product_image_name;
                                                                $product_id = $prods->product_id;
                                                                $product_name = $prods->product_name;
                                                                $brand_name = $prods->brand_name;
                                                                $product_price = $prods->product_selling_price;
                                                                $description = $prods->product_description;
                                                                $product_balance = $prods->product_balance;
                                                                $mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
                                                                $price = number_format($product_price, 2, '.', ',');
                                                                $image = $this->products_model->image_display($products_path, $products_location, $thumb);
                                                                $sale = '';
                                                                $button = '';
                                                                $balance_status = '';
                                                                $button = '<a class="btn btn-success add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>';

                                                                if($x > 0)
                                                                {
                                                                    ?>
                                                                    <div class="item">
                                                                        <a href="#"><img src="<?php echo $image;?>"> </a>
                                                                        <h4><small><?php echo $product_name;?></small></h4>                                        
                                                                        <button class="btn btn-primary" type="button">$ <?php echo $price;?></button> <?php echo $button;?> <a class="btn btn-warning add_to_cart_redirect " href="<?php echo $product_id;?>" product_id="<?php echo $product_id;?>"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span></a> <button href="#" class="btn btn-info" type="button"><span class="glyphicon glyphicon-heart"></span></button>
                                                                    </div><!-- End Item -->
                                                                <?php
                                                                }
                                                                else
                                                                {
                                                                     ?>
                                                                        <div class="item active">
                                                                            <a href="#"><img src="<?php echo $image;?>"></a>
                                                                            <h4><small><?php echo $product_name;?></small></h4>                                        
                                                                            <button class="btn btn-primary" type="button">$ <?php echo $price;?></button> <?php echo $button;?> <a class="btn btn-warning add_to_cart_redirect " href="<?php echo $product_id;?>" product_id="<?php echo $product_id;?>"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span></a> <button href="#" class="btn btn-info" type="button"><span class="glyphicon glyphicon-heart"></span></button>       
                                                                        </div><!-- End Item -->
                                                                    <?php
                                                                }
                                                                $x++;
                                                              
                                                            }
                                                        }
                                                        ?>
                                                                               
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
                                
                                <li><a href="#">Fashion</a></li>
                                <li><a href="#">Beauty</a></li>
                                <li><a href="#">Automotive</a></li>
                                <li><a href="<?php echo site_url().'products';?>">Products</a></li>
                                <li><a href="<?php echo site_url().'vendors/all-vendors';?>">Vendors</a></li>
                            </ul>
                            <?php echo $this->load->view('site/cart/mini_cart', '', TRUE);?>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
			</div><!-- /.Container -->
		</div><!-- /.Navigation -->