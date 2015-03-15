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
                            <li><a href="<?php echo site_url().'vendor/account'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account</a></li>
                            <?php
						}
						
						else
						{
							?>
                            <li><a href="<?php echo site_url().'sign-in'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Sign in</a></li>
                            <li><a href="<?php echo site_url().'join'?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Join</a></li>
                            <?php
						}
						?>
                    	
                    	<li><a href="#"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Wishlist</a></li>
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
                        <button id="searchsubmit" class="fa fa-search" type="submit"></button>
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
                        
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <!--<li class="active"><a href="#">Home</a></li>-->
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Products <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo site_url().'vendor/all-brands';?>">Brands</a></li>
                                        <li><a href="<?php echo site_url().'vendor/all-categories';?>">Categories</a></li>
                                        <li><a href="<?php echo site_url().'vendor/all-features';?>">Features</a></li>
                                        <li><a href="<?php echo site_url().'vendor/all-products';?>">Products</a></li>
                                        <li><a href="<?php echo site_url().'vendor/all-product-bundle';?>">Product Bundles</a></li>
                                        <!--<li class="divider"></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>-->
                                    </ul>
                                </li>
                                
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Promotional Banners <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo site_url().'vendor/all-banners';?>">Revolving Banners</a></li>
                                        <li><a href="<?php echo site_url().'vendor/all-static-banners';?>">Static Banners</a></li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url().'vendor/all-orders';?>" > Customer Orders</a>
                                </li>
                                <li class="">
                                    <a href="<?php echo site_url().'vendor/all-product-reviews';?>" > Product Reviews</a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $this->session->userdata('first_name');?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo site_url().'vendor/account-profile';?>">Profile</a></li>
                                        <li><a href="<?php echo site_url().'vendor/sign-out';?>">Sign out</a></li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
			</div><!-- /.Container -->
		</div><!-- /.Navigation -->

 