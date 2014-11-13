          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
            }
            
            $success = $this->session->userdata('success_message');
            
            if(!empty($success))
            {
                echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
				$this->session->unset_userdata('success_message');
            }
            
            $error = $this->session->userdata('error_message');
            
            if(!empty($error))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
				$this->session->unset_userdata('error_message');
            }
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- airline Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airline_name" placeholder="Airline Name" value="<?php echo set_value('airline_name');?>" required>
                </div>
            </div>
            <!-- airline Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Phone</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airline_phone" placeholder="Airline Phone" value="<?php echo set_value('airline_phone');?>" required>
                </div>
            </div>
            <!-- airline Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Email</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airline_email" placeholder="Airline Email" value="<?php echo set_value('airline_email');?>" required>
                </div>
            </div>
            <!-- Image -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Logo</label>
                <div class="col-lg-4">
                    
                    <div class="row">
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:200px; height:200px;">
                                    <img src="http://placehold.it/200x200">
                                </div>
                                <div>
                                    <span class="btn btn-file btn-warning"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="airline_image"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate airline?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                            <input id="optionsRadios1" type="radio" checked value="1" name="airline_status">
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input id="optionsRadios2" type="radio" value="0" name="airline_status">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Airline
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>