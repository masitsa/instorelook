<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->load->view('site/includes/header', '', TRUE); ?>
    </head>

	<body>
    	<!-- Top Navigation -->
        <?php echo $this->load->view('site/includes/home_navigation', '', TRUE); ?>
        <?php //echo $this->load->view('site/includes/top_navigation', '', TRUE); ?>
        
        <?php echo $content;?>
        
        <?php echo $this->load->view('site/includes/footer', '', TRUE); ?>
</body>
</html>
