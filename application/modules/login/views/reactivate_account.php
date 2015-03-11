 <!-- Join  -->
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                	<div class="divider-line"></div>
                	<h1 class="center-align">Reactivate account</h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    
                    <div class="row">
                        
                    	<div class="col-md-12">
                            <p class="center-align">Enter your email address and we will send you a link to reactivate your account</p>
                            
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
                                echo form_open($this->uri->uri_string(), $attributes);
                            ?>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="form-group">
                                            <label for="customer_email" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                            <div class="col-sm-8">
                                                <?php
                                                    //case of an input error
                                                    if(!empty($customer_email_error))
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control alert-danger" name="customer_email" placeholder="<?php echo $customer_email_error;?>" onFocus="this.value = '<?php echo $customer_email;?>';">
                                                        <?php
                                                    }
                                                    
                                                    else
                                                    {
                                                        ?>
                                                        <input type="text" class="form-control" name="customer_email" placeholder="Email" value="<?php echo set_value('customer_email');?>">
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-8 col-md-offset-4">
                                                <div class="center-align">
                                                    <button type="submit" class="btn btn-red">Reactivate account</button>
                                                    <p>Don't have an account?</p>
                                                    <a href="<?php echo site_url().'customer/join';?>">Sign up</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                        <!-- End business -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Join -->