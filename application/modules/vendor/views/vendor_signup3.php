<!-- Join  -->
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                    
                    <?php
                    if($page == 1)
					{
					?>
                	<div class="divider-line"></div>
                	<h1 class="center-align">Business sign up</h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    
                    <!-- Steps -->
                    <div class="container">
                        <div class="process">
                            <div class="process-row">
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-user fa-2x"></i></button>
                                    <p>Account</p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-building-o fa-2x"></i></button>
                                    <p>Business</p>
                                </div>
                                 <div class="process-step">
                                    <button type="button" class="btn blue-background btn-circle" disabled="disabled"><i class="fa fa-dollar fa-2x"></i></button>
                                    <p>Subscription</p>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- End: Steps -->
                    <?php
					}
					
					else
					{
					?>
                	<div class="divider-line"></div>
                	<h1 class="center-align">Change subscription plan</h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    <?php
					}
					?>
                    
                    <p class="center-align">Subscribe to the unlimited plan FREE.</p>

                    <div class="container">
                        <div class="row subscribe-header">
                            <div class="col-xs-12 col-sm-offset-4 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 my_planHeader my_plan2">
                                        <div class="my_planTitle">Free</div>
                                        <div class="my_planPrice">Ksh 0</div>
                                        <div class="my_planDuration"> </div>
                                        <?php
                                        if($current_plan != 1)
										{
										?>
                                        <a type="button" class="btn btn-default" href="<?php echo site_url().'vendor/subscribe/free';?>">Subscribe</a>
                                        <p></p>
                                        <a type="button" href="<?php echo site_url().'vendor/subscribe/free';?>" class="more-details">More details</a>
                                        <?php
                                        }
										?>
                                    </div>
                                    <div class="col-xs-6 my_planHeader my_plan1">
                                        <div class="my_planTitle">Unlimited</div>
                                        <div class="my_planPrice">Ksh 1,000*</div>
                                        <div class="my_planDuration">per month</div>
                                        <?php
                                        if($current_plan != 3)
										{
										?>
                                        <a type="button" class="btn btn-default" href="<?php echo site_url().'vendor/subscribe/unlimited';?>">Subscribe</a>
                                        <p></p>
                                        <a type="button" href="<?php echo site_url().'vendor/subscribe/unlimited';?>" class="more-details">More details</a>
                                        <?php
                                        }
										?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Company profile
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                               	Upload company logo
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Product discount advertisment
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Analytics
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Request For More Categories
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Marketing campaigns
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Featured merchant status
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!--<div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Multi Geographical Product Sales
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-meh-o my_times"></i>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <i class="fa fa-smile-o my_check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Listing categories
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">5</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <span class="feature-text">Unlimited</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Listed products
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">20</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                       	<span class="feature-text">Unlimited</span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <!--<div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Product Tags
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">2</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">5</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <span class="feature-text">Unlimited</span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Links to social media
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">1</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan1">
                                        <span class="feature-text">5</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row my_featureRow">
                            <div class="col-xs-12 col-sm-4 my_feature">
                                Email Account
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">0</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">2</span>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 my_planFeature my_plan2">
                                        <span class="feature-text">10</span>
                                    </div>
                                </div>
                            </div>
                        </div>       
                    </div> -->
                    
                    <?php
                    if($page == 1)
					{
					?>
                    <div class="row center-align">
                        <div class="col-sm-12">
                            <a href="<?php echo site_url().'vendor/sign-up/store-details';?>">Back</a> 
                            <p>already have an account?</p>
                            <a href="<?php echo site_url().'sign-in';?>">Sign In</a>
                        </div>
                    </div>
                    <?php
					}
					?>
                </div>
            </div>
        </div>
        <!-- End Join -->