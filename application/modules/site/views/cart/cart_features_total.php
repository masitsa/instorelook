<?php

$options_total = 0;

foreach ($this->cart->contents() as $items):
	if(isset($items['options']['additional_price']))
	{
		//var_dump($items['options']['product_features']);
		$options_total += $items['options']['additional_price'] * $items['qty'];
	}
endforeach;

echo $options_total;
?>