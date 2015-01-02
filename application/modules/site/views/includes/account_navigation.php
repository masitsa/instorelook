 <!-- Title -->
        <div class="title">
        	<div class="container">
        		<h1>in store look</h1>
            </div>
        </div>
        <!-- End Title -->
        
        <div class="clear-both"></div>
        
        <!-- Navigation -->
        <div class="navigation">
            <nav class="navbar navbar-default blue-background" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
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
                                    <!--<li class="divider"></li>
                                    <li class="divider"></li>
                                    <li><a href="#">One more separated link</a></li>-->
                                </ul>
                            </li>
                            <li><a href="<?php echo site_url().'vendor/sign-out';?>">Sign Out</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
		</div><!-- /.Navigation -->