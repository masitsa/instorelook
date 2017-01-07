<?php
	$all_categories = $this->site_model->get_all_categories();
	$parent_categories = $this->site_model->get_parent_categories();
	$count = 0;
	$per_column = round($parent_categories->num_rows()/3);
	$parents = '';
	
	if($parent_categories->num_rows() > 0)
	{
		$categories = '';
		
		foreach($parent_categories->result() as $res)
		{
			$category_name = $res->category_name;
			$category_id = $res->category_id;
			$category_web_name = $this->site_model->create_web_name($category_name);
			$parents.= '<option value='.$category_id.'>'.$category_name.'</option>';
			$class = $sub_categories = '';
			
			if($all_categories->num_rows() > 0)
			{
				foreach($all_categories->result() as $cat_res)
				{
					$category_parent = $cat_res->category_parent;
					$child_id = $cat_res->category_id;
					$child_name = $cat_res->category_name;
					$child_web_name = $this->site_model->create_web_name($child_name);
					
					if($category_id == $category_parent)
					{
						$class = 'sub-category';
						$sub_categories .= '<li><a href="'.site_url().'products/category/'.$child_web_name.'"><i class="fa fa-angle-double-right"></i>'.$child_name.'</a></li>';
					}
				}
			}
			
			//no children
			if($class == '')
			{
				$categories .= '<li><a href="'.site_url().'products/category/'.$category_web_name.'"><img src="'.base_url().'assets/themes/timeplus/img/icon/sport.jpg" alt="'.$category_name.'">'.$category_name.'</a></li>';
			}
			
			else
			{
				$categories .= '
					<li class="sub-category">
						<a href="'.site_url().'products/category/'.$category_web_name.'"><img src="'.base_url().'assets/themes/timeplus/img/icon/phone.jpg" alt="">'.$category_name.'</a>
						<ul class="sub-menu clearfix">
							<li class="sub-sec col-md-6">
								<ul>   
									<li><a href="index.html'.site_url().'products/category/'.$category_web_name.'" class="title">'.$category_name.'</a></li>
									'.$sub_categories.'
								</ul>    
							</li>
						</ul>
					</li>
				';
			}
		}
	}
	
	else
	{
		$categories = '';
	}
?>
        <!-- header start -->
        <header class="header_area">
            <div class="header_top_area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 hidden-xs">
                            <div class="header_top_left">
                                <p> <i class="fa fa-envelope"></i> <span>info@shopyard.co.ke</span></p>
                            </div>
                        </div>
                        <div class="col-sm-6 hidden-xs">
                            <div class="header_top_right">
                                <nav>
                                    <ul>
                                        <li class="currency"><a id="header_sub_cur" href="index.html#">KES</a>
                                            <ul id="header_submenu_cur">
                                                <li><a href="index.html#">Dollar(USD)</a></li>
                                                <li><a href="index.html#">Euro(EUR)</a></li>
                                                <li><a href="index.html#">Shilling(KES)</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Title -->
        <div class="title">
        	<div class="container">
            	<div class="clear"></div>
                
                <div class="row">
                	<div class="col-md-8 col-sm-8">
                	<a href="<?php echo site_url();?>" style="color:#e65100;">SHOP YARD<!--<img class="img-responsive" src="<?php echo base_url().'assets/images/logo.jpg';?>"/>--></a>
                	</div>
                	<div class="col-md-4 col-sm-4 hide-mobile2" style="padding-right:0;">
						<?php echo form_open('products/search', array('role' => 'search', 'id' => 'searchform'));?>
                            <input id="s" type="text" placeholder="Search entire store here..." name="search_item" value="">
                            <button id="searchsubmit" class="glyphicon glyphicon-search" type="submit"></button>
                        <?php echo form_close(); ?>
                	</div>
            <div class="header_middle_area">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="header_logo">
                               <a href="<?php echo site_url();?>"><img class="img-responsive pull-left logo" src="<?php echo base_url().'assets/images/logo.png';?>"/></a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-6">
                            <div class="header_cat_search">
								<?php echo form_open('products/search', array('class' => 'search_form', 'id' => 'searchbox'));?>
                                    <input type="search" placeholder="Enter your search key ..." name="search_item">
                                    <button type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <div class="header_cat">
                                        <select name="category" id="cat_items">
                                            <?php echo $parents;?>
                                        </select>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <div class="hidden-xs hidden-sm col-md-2">
                            <div class="cart_header">
                                <h2 class="cart_info" id="account_sub">My Account</h2>
                                <div class="user_info">
                                    <ul id="account_submenu">
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
											<li><a href="<?php echo site_url().'join'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign in/Join</a></li>
											<?php
										}
										?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-1 col-md-1 clearfix">
							<?php echo $this->load->view('site/cart/mini_cart', '', TRUE);?>
						</div>
                    </div>
                </div>
            </div>
            <!-- MainMenu Area start -->
            <div class="mainmenu_area">
                <div class="container">
                    <div class="row">
                        <div class="hidden-xs hidden-sm col-md-3">
                            <div class="category_menu hidden-xs">
								<?php if(isset($home)){?>
                                <div class="category_title">
                                    <h3>Category</h3>
                                </div>
                                <div class="category_menu_content">
                                   <ul>
                                       <?php echo $categories;?>
                                   </ul> 
                                </div>
								<?php } else{?>
                                <div class="category_title show-submenu">
                                    <h3>Category</h3>
                                </div>
                                <div class="category_menu_content submenu">
                                   <ul>
                                       <?php echo $categories;?>
                                   </ul> 
                                </div>
								<?php }?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-sm-9 hidden-xs">
                            <div class="mainmenu">
                                <nav>   
                                    <ul>
										<li><a href="<?php echo site_url().'home';?>">Home</a></li>
										<li><a href="<?php echo site_url().'products';?>">Products</a></li>
										<li><a href="<?php echo site_url().'businesses';?>">Businesses</a></li>
                                        <li><a href="about.html">About Us</a></li>
										<li><a href="blog.html">Blog</a></li>
										<li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </nav>       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MainMenu Area end -->            
            <!-- Mobile Menu Area start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
										<li><a href="<?php echo site_url().'home';?>">Home</a></li>
										<li><a href="<?php echo site_url().'products';?>">Products</a></li>
										<li><a href="<?php echo site_url().'businesses';?>">Businesses</a></li>
                                        <li><a href="about.html">About Us</a></li>
										<li><a href="blog.html">Blog</a></li>
										<li><a href="contact.html">Contact</a></li>
                                </nav>
                            </div>					
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area end -->		
        </header>
        <!-- header end -->
        