          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the visitor details
			$visitor_id = $visitor[0]->visitor_id;
			$visitor_first_name = $visitor[0]->visitor_first_name;
			$visitor_last_name = $visitor[0]->visitor_last_name;
			$visitor_phone = $visitor[0]->visitor_phone;
			$visitor_email = $visitor[0]->visitor_email;
			$visitor_status = $visitor[0]->visitor_status;
			$visitor_type_id = $visitor[0]->visitor_type_id;
            
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
				
				$visitor_first_name = set_value('visitor_first_name');
				$visitor_last_name = set_value('visitor_last_name');
				$visitor_phone = set_value('visitor_phone');
				$visitor_email = set_value('visitor_email');
				$visitor_status = set_value('visitor_status');
				$visitor_type_id = set_value('visitor_type_id');
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
            <!-- visitor Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Visitor Type</label>
                <div class="col-lg-4">
                    <select name="visitor_type_id" id="visitor_type_id" class="form-control" required>
                        <?php
                        if($visitor_types->num_rows() > 0)
                        {
                            $result = $visitor_types->result();
                            
                            foreach($result as $res)
                            {
                                if($res->visitor_type_id == $visitor_type_id)
                                {
                                    echo '<option value="'.$res->visitor_type_id.'" selected="selected">'.$res->visitor_type_name.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$res->visitor_type_id.'">'.$res->visitor_type_name.'</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <!-- visitor Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">First Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="visitor_first_name" placeholder="First Name" value="<?php echo $visitor_first_name;?>" required>
                </div>
            </div>
            <!-- visitor Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Last Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="visitor_last_name" placeholder="Last Name" value="<?php echo $visitor_last_name;?>" required>
                </div>
            </div>
            <!-- visitor Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Email</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="visitor_email" placeholder="Email" value="<?php echo $visitor_email;?>" required>
                </div>
            </div>
            <!-- visitor Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Phone</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="visitor_phone" placeholder="Phone" value="<?php echo $visitor_phone;?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate visitor?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($visitor_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="visitor_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="visitor_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($visitor_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="visitor_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="visitor_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit visitor
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>