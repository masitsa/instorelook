
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Charge Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Charge Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="promotion_charge_name" placeholder="Charge Name" value="<?php echo set_value('promotion_charge_name');?>" required>
                </div>
            </div>
            <!-- Charge Preffix -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Charge Cost</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="promotion_charge_cost" placeholder="Charge Cost" value="<?php echo set_value('promotion_charge_cost');?>" required>
                </div>
            </div>
            
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Charge?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                            <input id="optionsRadios1" type="radio" checked value="1" name="promotion_charge_status">
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input id="optionsRadios2" type="radio" value="0" name="promotion_charge_status">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Charge
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>