<div id="checkout-content">
<div class="box-header">                                                                                                    
    <h3>Order Review</h3>
    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>                                                    
</div>



<div class="box-content">
    <div class="shipping-methods">
        <div class="row">
            <div class="col-lg-12 col-md-12  col-sm-12">
                <div class="cart-items">
                        
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th class="col_product text-left">Product</th>
                                    <th class="col_qty text-left">Qty</th>
                                    <th class="col_single text-left">Price</th>
                                    <th class="col_discount text-left">Discount</th>
                                    <th class="col_total text-left">Total</th>
                                    <th class="col_remove text-left">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody> 
                             <?php
                              foreach ($this->cart->contents() as $items): 

                                  $cart_product_id = $items['id'];
            
                                  //get product details
                                  $product_details = $this->products_model->get_product($cart_product_id);
            
                                  if($product_details->num_rows() > 0)
                                  {
                                      $product = $product_details->row();
              
                                      $product_thumb = $product->product_thumb_name;
                                      $sale_price = $product->sale_price;
                                      $product_selling_price = $product->product_selling_price;
                                      $discount = 0;
              
                                      if($sale_price > 0)
                                      {
                                        $discount = $product_selling_price - ($product_selling_price * ($sale_price/100));
                                      }
              
                                      $total = number_format($items['qty']*$items['price'], 0, '.', ',');  

                                      echo'              
                                        <tr>
                                            <td data-title="Product" class="col_product text-left">
                                                <div class="image visible-desktop">
                                                    <a href="'.site_url().'products/view-product/'.$items['id'].'">
                                                        <img src="'.base_url().'assets/images/products/images/'.$product_thumb.'" alt="'.$items['name'].'">
                                                    </a>
                                                </div>

                                                <h5>
                                                    <a href="'.site_url().'products/view-product/'.$items['id'].'">'.$items['name'].'</a>
                                                </h5>

                                            </td>

                                            <td data-title="Qty" class="col_qty text-left">
                                                <input type="text" name="quantity'.$items['rowid'].'" value="'.$items['qty'].'" class="form-control quanitySniper">
                                            </td>

                                            <td data-title="Single" class="col_single text-left">
                                                <span class="single-price">$'.number_format($items['price'], 0, '.', ',').'</span>
                                            </td>

                                            <td data-title="Discount" class="col_discount text-left">
                                                <span class="single-price">$'.$discount.'</span>
                                            </td>

                                            <td data-title="Total" class="col_total text-left">
                                                <span class="total-price">$'.$total.'</span>
                                            </td>

                                            <td data-title="Remove" class="col_remove text-left">
                                                <a href="'.site_url().'cart/delete-item/'.$items['rowid'].'/2">
                                               
                                                   <span class=" glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                  
                                                </a>
                                            </td>
                                        </tr>';
                                     
                                      }
                                 endforeach;
                                ?>
                               
                            </tbody>
                        </table>
                    </div>
            </div>
            
        </div>
    </div>
</div>



<div class="box-footer">
    <div class="pull-left">
        <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-default btn-small">
            <i class="icon-chevron-left"></i> &nbsp; Payment method
        </a>
    </div>

    <div class="pull-right">                            
        <a href="<?php echo site_url().'checkout/confirm-order';?>" class="btn btn-primary btn-small">
            Confirm Order &nbsp; <i class="icon-chevron-right"></i>
        </a>
    </div>
</div>					
</div>