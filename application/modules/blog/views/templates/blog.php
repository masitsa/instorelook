<!DOCTYPE html>

<html dir="ltr" lang="en-US" class="no-js">
	<?php echo $this->load->view('includes/header', '', TRUE);?>
	
    <body class="home">
		<?php echo $this->load->view('includes/navigation', '', TRUE);?>
		<!-- ***************** - MAIN - ***************** -->
     	<div id="mainwrap">
          <div id="main" class="clearfix">
               <div class="pad"></div>
				<!-- ***************** - CONTENT - ***************** -->
				<div class="content blog">
					<?php echo $content; ?>
				</div>
				<!-- ***************** - SIDEBAR - ***************** -->
				<?php echo $this->load->view('includes/sidebar', '', TRUE); ?>
			</div>
		</div>
		<?php echo $this->load->view('includes/footer', '', TRUE);?>
	</body>
</html>