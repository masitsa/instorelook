
  <!-- Main component call to action -->
  
  <div class="row" style="margin:0;">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="breadcrumbDiv ">
      <ul class="breadcrumb">
      	<?php
        	$total_crumbs = count($crumbs);
			
			if($total_crumbs > 0)
			{
				for($r = 0; $r < $total_crumbs; $r++)
				{
					$class = '';
					if($r == ($total_crumbs - 1))
					{
						$class = 'class="active"';
					}
					echo '<li '.$class.'><a href="'.site_url().$crumbs[$r]['link'].'">'.$crumbs[$r]['name'].'</a> </li>';
				}
			}
		?>
      </ul>
    </div>
    </div>
  </div>  <!-- /.row  --> 