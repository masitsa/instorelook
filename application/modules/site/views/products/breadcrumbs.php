
  <a href="index.html"><i class="fa fa-home"></i>Home</a>
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
				echo '
				<span class="navigation-pipe"><i class="fa fa-angle-right"></i></span>
				<span class="navigation_page">'.$crumbs[$r]['name'].'</span>';
			}
		}
	?>
                            