          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the flight_type details
			$flight_type_id = $flight_type[0]->flight_type_id;
			$flight_type_name = $flight_type[0]->flight_type_name;
			$flight_type_status = $flight_type[0]->flight_type_status;
            
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
				
				$flight_type_name = set_value('flight_type_name');
				$flight_type_status = set_value('flight_type_status');
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
            <!-- flight_type Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Flight Type Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="flight_type_name" placeholder="Flight Type Name" value="<?php echo $flight_type_name;?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Flight Type?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($flight_type_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="flight_type_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="flight_type_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($flight_type_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="flight_type_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="flight_type_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit Flight Type
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>