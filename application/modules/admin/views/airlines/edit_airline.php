          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the airline details
			$airline_id = $airline[0]->airline_id;
			$airline_name = $airline[0]->airline_name;
			$airline_phone = $airline[0]->airline_phone;
			$airline_email = $airline[0]->airline_email;
			$airline_status = $airline[0]->airline_status;
			$image = $airline[0]->airline_logo;
			$thumb = $airline[0]->airline_thumb;
            
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
				
				$airline_name = set_value('airline_name');
				$airline_phone = set_value('airline_phone');
				$airline_email = set_value('airline_email');
				$airline_status = set_value('airline_status');
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
                	<input type="text" class="form-control" name="airline_name" placeholder="airline Name" value="<?php echo $airline_name;?>" required>
                </div>
            </div>
            <!-- airline Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Phone</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airline_phone" placeholder="Airline Phone" value="<?php echo $airline_phone;?>" required>
                </div>
            </div>
            <!-- airline Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Email</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airline_email" placeholder="Airline Email" value="<?php echo $airline_email;?>" required>
                </div>
            </div>
            <!-- Image -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airline Logo</label>
                <input type="hidden" value="<?php echo $image;?>" name="current_image"/>
                <div class="col-lg-4">
                    
                    <div class="row">
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:200px; height:200px;">
                                    <img src="<?php echo $image_location.$image;?>">
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
                        	<?php
                            if($airline_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="airline_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="airline_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($airline_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="airline_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="airline_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit Airline
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>