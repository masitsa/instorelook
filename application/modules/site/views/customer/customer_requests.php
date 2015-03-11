 <!-- Join  -->
<div class="content light-grey-background">
	<div class="container">
		<div class="search-flights">
        	<div class="divider-line"></div>
        	<h1 class="center-align">Company Request</h1>
        	<div class="divider-line" style="margin-bottom:2%;"></div>
            
            <p class="center-align">Suggest the company you would like to be have products on the site.</p>
            
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
                	<div class="col-md-offset-3 col-md-5">
                        <div class="form-group">
                            <label for="vendor_email" class="col-sm-4 control-label">Company Name <span class="required">*</span></label>
                            <div class="col-sm-8">
                            	<?php
									//case of an input error
                                	if(!empty($company_name_error))
									{
										?>
                                        <input type="text" class="form-control alert-danger" name="company_name" placeholder="<?php echo $company_name_error;?>" onFocus="this.value = '<?php echo $company_name;?>';">
                                        <?php
									}
									
									else
									{
										?>
                                        <input type="text" class="form-control" name="company_name" placeholder="Company name" value="<?php echo set_value('company_name');?>">
                                        <?php
									}
								?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="vendor_password" class="col-sm-4 control-label">Company description <span class="required">*</span></label>
                            <div class="col-sm-8">
                            	<?php
									//case of an input error
                                	if(!empty($company_description_error))
									{
										?>
										<textarea class="form-control" name="company_description" ><?php echo set_value('company_description');?></textarea>
                                        <?php
									}
									
									else
									{
										?>
										<textarea class="form-control" name="company_description" ><?php echo set_value('company_description');?></textarea>
                                        <?php
									}
								?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 center-align">
                        <button type="submit" class="btn btn-red">Submit</button>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<!-- End Join -->