<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('site/includes/header', '', TRUE);?>
    </head>

	<body>
    	<!-- Top Navigation -->
        <?php echo $this->load->view('site/includes/account_navigation', '', TRUE); ?>
        <!-- Join  -->
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                    
                    <div class="center-align">
                    <?php
                    	$success = $this->session->userdata('success_message');
						$error = $this->session->userdata('error_message');
						
						if(!empty($success))
						{
							echo '
								<div class="alert alert-success">'.$success.'</div>
							';
							$this->session->unset_userdata('success_message');
						}
						
						if(!empty($error))
						{
							echo '
								<div class="alert alert-danger">'.$error.'</div>
							';
							$this->session->unset_userdata('error_message');
						}
					?>
                    </div>
        			<?php echo $content;?>
                    <?php if(isset($links)){echo $links;}?>
                </div>
            </div>
        </div>
        <!-- End Join -->
        
        <?php echo $this->load->view('site/includes/footer', '', TRUE); ?>
</body>
</html>