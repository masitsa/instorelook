<?php
$shipping_cost =0;
if(isset($items['options']))
{
	if(isset($items['options']['shipping']))
	{
		$shipping = $items['options']['shipping'];
		
		if($shipping >= 1)
		{
			$shipping_cost += $items['options']['cost'];
		}
	}
}

echo number_format($shipping_cost,2);
?>