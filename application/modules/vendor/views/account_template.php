<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('airline/account/header', '', TRUE); ?>
    </head>

	<body>

    	<div id="wrapper">
            <!-- Top Navigation -->
            <?php echo $this->load->view('airline/account/top_navigation', '', TRUE); ?>

        	<div id="page-wrapper">
            	<?php echo $this->load->view('airline/account/summary', '', TRUE); ?>
            	<?php echo $this->load->view('airline/account/left_navigation', '', TRUE); ?>
                
				<?php echo $content;?>
                
            </div>
        </div>
        <?php echo $this->load->view('airline/account/footer', '', TRUE); ?>
</body>
</html>
