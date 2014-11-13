          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the airport details
			$airport_id = $airport[0]->airport_id;
			$airport_name = $airport[0]->airport_name;
			$location_name = $airport[0]->location_name;
			$airport_status = $airport[0]->airport_status;
            
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
				
				$airport_name = set_value('airport_name');
				$location_name = set_value('location_name');
				$airport_status = set_value('airport_status');
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
            <!-- airport Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airport Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airport_name" placeholder="Airport Name" value="<?php echo $airport_name;?>" required>
                </div>
            </div>
            <!-- airport Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airport Location</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="location_name" placeholder="Airport Location" value="<?php echo $location_name;?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Airport?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($airport_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="airport_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="airport_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($airport_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="airport_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="airport_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit Airport
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>