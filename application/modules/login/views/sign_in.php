 <!-- Join  -->
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                	<div class="divider-line"></div>
                	<h1 class="center-align">Sign in</h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    
                    <div class="row">
                    	<div class="col-md-6">
                        	<h2 class="center-align">I want to sell</h2>
                            <p class="center-align">Sign into your vendor account.</p>
                            
                            <?php
                                $error_message = $this->session->userdata('error_message');
                                if(!empty($error_message))
                                {
                                    echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
                                    $this->session->unset_userdata('error_message');
                                }
                                
                                $success_message = $this->session->userdata('success_message');
                                if(!empty($success_message))
                                {
                                    echo '<div class="alert alert-success center-align"> '.$success_message.' </div>';
                                    $this->session->unset_userdata('success_message');
                                    
                                }
                                $attributes = array(
                                                'class' => 'form-horizontal',
                                                'role' => 'form',
                                            );
                                echo form_open('vendor/sign-in', $attributes);
                            ?>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="form-group">
                                            <label for="vendor_email" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    //case of an input error
                                                    if(!empty($vendor_email_error))
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control alert-danger" name="vendor_email" placeholder="<?php echo $vendor_email_error;?>" onFocus="this.value = '<?php echo $vendor_email;?>';">
                                                        <?php
                                                    }
                                                    
                                                    else
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control" name="vendor_email" placeholder="Email" value="<?php echo set_value('vendor_email');?>">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vendor_password" class="col-sm-4 control-label">Password <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    //case of an input error
                                                    if(!empty($vendor_password_error))
                                                    {
                                                        ?>
                                                        <input type="password" class="form-control alert-danger" name="vendor_password" placeholder="<?php echo $vendor_password_error;?>" onFocus="this.value = '<?php echo $vendor_password;?>';">
                                                        <?php
                                                    }
                                                    
                                                    else
                                                    {
                                                        ?>
                                                        <input type="password" class="form-control" name="vendor_password" placeholder="Password" value="<?php echo set_value('vendor_password');?>">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12 center-align">
                                        <button type="submit" class="btn btn-red">Continue</button>
                                        <p>Don't have an account?</p>
                                        <a href="<?php echo site_url().'vendor/sign-up/user-details';?>">Sign Up</a>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                        
                        
                    	<div class="col-md-6">
                        
                        	<h2 class="center-align">I want to buy</h2>
                            <p class="center-align">Sign into your shopper account.</p>
                            
                            <?php
                                $error_message = $this->session->userdata('error_message');
                                if(!empty($error_message))
                                {
                                    echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
                                    $this->session->unset_userdata('error_message');
                                }
                                
                                $success_message = $this->session->userdata('success_message');
                                if(!empty($success_message))
                                {
                                    echo '<div class="alert alert-success center-align"> '.$success_message.' </div>';
                                    $this->session->unset_userdata('success_message');
                                    
                                }
                                $attributes = array(
                                                'class' => 'form-horizontal',
                                                'role' => 'form',
                                            );
                                echo form_open('#', $attributes);
                            ?>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="form-group">
                                            <label for="vendor_email" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    //case of an input error
                                                    if(!empty($vendor_email_error))
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control alert-danger" name="vendor_email" placeholder="<?php echo $vendor_email_error;?>" onFocus="this.value = '<?php echo $vendor_email;?>';">
                                                        <?php
                                                    }
                                                    
                                                    else
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control" name="vendor_email" placeholder="Email" value="<?php echo set_value('vendor_email');?>">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="vendor_password" class="col-sm-4 control-label">Password <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    //case of an input error
                                                    if(!empty($vendor_password_error))
                                                    {
                                                        ?>
                                                        <input type="password" class="form-control alert-danger" name="vendor_password" placeholder="<?php echo $vendor_password_error;?>" onFocus="this.value = '<?php echo $vendor_password;?>';">
                                                        <?php
                                                    }
                                                    
                                                    else
                                                    {
                                                        ?>
                                                        <input type="password" class="form-control" name="vendor_password" placeholder="Password" value="<?php echo set_value('vendor_password');?>">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12 center-align">
                                        <button type="submit" class="btn btn-red">Continue</button>
                                        <p>Don't have an account?</p>
                                        <a href="<?php echo site_url().'vendor/sign-up/user-details';?>">Sign Up</a>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Join -->