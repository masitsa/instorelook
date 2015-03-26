<div class="container main-container headerOffset" style="margin-bottom: 5px;"> 
 <!-- Join  -->
        <div class="content light-grey-background product-content">
        	<div class="container">
            	<div class="row">
                	<div class="col-lg-8 col-md-8 col-sm-12">
                        
                    <?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-4">
                                <div class="center-align">
                                    <h3 class="center-align">Send us an email</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="sender_name" class="col-sm-4 control-label">Name <span class="required">*</span></label>
                           	<div class="col-sm-8">
								<?php
                                    //case of an input error
                                    if(!empty($sender_name_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="sender_name" placeholder="<?php echo $sender_name_error;?>" onFocus="this.value = '<?php echo $sender_name;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="sender_name" placeholder="Name" value="<?php echo $sender_name;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sender_email" class="col-sm-4 control-label">Email address <span class="required">*</span></label>
                            <div class="col-sm-8">
								<?php
                                    //case of an input error
                                    if(!empty($sender_email_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="sender_email" placeholder="<?php echo $sender_email_error;?>" onFocus="this.value = '<?php echo $sender_email;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="sender_email" placeholder="Email" value="<?php echo $sender_email;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sender_phone" class="col-sm-4 control-label">Phone</label>
                            <div class="col-sm-8">
								<?php
                                    //case of an input error
                                    if(!empty($sender_phone_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="sender_phone" placeholder="<?php echo $sender_phone_error;?>" onFocus="this.value = '<?php echo $sender_phone;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="sender_phone" placeholder="Phone" value="<?php echo $sender_phone;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="message" class="col-sm-4 control-label">Message <span class="required">*</span></label>
                            <div class="col-sm-8">
								<?php
                                    //case of an input error
                                    if(!empty($message_error))
                                    {
                                        ?>
                                        <textarea class="form-control alert-danger" name="message" onFocus="this.value = '<?php echo $message;?>';" placeholder="<?php echo $message_error;?>"></textarea>
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <textarea class="form-control" name="message" placeholder="Message"><?php echo $message;?></textarea>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-sm-8 col-sm-offset-4">
                            	<div class="center-align">
                                	<button type="submit" class="btn btn-red">Send Message</button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                     </div>
                	<div class="col-lg-4 col-md-4 col-sm-12">
                        <h3 class="center-align">Contact Details</h3>
                        <div class="center-align">
							<ul>
                            	<li><i class="fa fa-phone"></i> : <a href="tel:0405486426">0405 486 426</a></li>
                            	<li><i class="fa fa-envelope-o"></i> : <a href="mailto:info@instorelook.com.au"> info@instorelook.com.au </a></li>
                            	<li> ABN: 25 997 516 795</li>
                            </ul>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>