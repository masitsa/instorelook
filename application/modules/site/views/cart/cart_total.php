<?php 
$cart_total = $this->cart->total();

//check for discounts
$discount = 0;

foreach ($this->cart->contents() as $items):
	$product_id = $items['id'];
	
	$product_details = $this->products_model->get_product($product_id);
    
	if($product_details->num_rows() > 0)
	{
		$product = $product_details->row();
		
		$sale_price = $product->sale_price;
		$sale_price_type = $product->sale_price_type;
		$product_selling_price = $product->product_selling_price;
		
		$product_sale_price = number_format($this->products_model->get_product_discount_price($product_selling_price, $sale_price, $sale_price_type), 2);	
		
		$discount = $product_selling_price - $product_sale_price;
	}
endforeach;
$cart_total -= $discount;

$options_total = $this->load->view('site/cart/cart_features_total', '', TRUE);
$total = $cart_total + $options_total;
echo number_format($total, 2);

?>