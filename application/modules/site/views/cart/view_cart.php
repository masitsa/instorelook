<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-7">
      <div class="shopping-cart">
        <h4><i class="glyphicon glyphicon-shopping-cart"></i>Shopping cart</h4>
        <div class="box">
        	<form  enctype="multipart/form-data"  action="<?php echo site_url().'cart/update-cart';?>" method="post">
                
            <div class="box-header">
                <h3><i class="glyphicon glyphicon-shopping-cart"></i>Shopping cart</h3>
                <h5>You currently have <strong><?php echo $this->cart->total_items();?></strong> item(s) in your cart</h5>
            </div>
            <?php echo $this->load->view('cart/cart');?>
    
            <div class="box-footer">
                <div class="pull-left">
                    <a href="<?php echo base_url()?>products" class="btn btn-primary btn-small">
                         <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> &nbsp; Continue shopping
                    </a>      
                </div>
            
                <div class="pull-right">
                    <button type="submit" class="btn btn-small mm20">
                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> &nbsp; Update cart
            
                    </button>
            
                     <a href="<?php echo site_url().'checkout';?>" class="btn btn-primary btn-small">
                        Proceed to checkout &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </form>
        </div>
        </div>
      <!--/row end--> 
        <?php echo $this->load->view('cart/shipping_estimator', '', TRUE);?>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
              	<?php echo $this->load->view('cart/cart_summary', '', TRUE);?>
    </div>
    <!--/rightSidebar--> 
    
  </div><!--/row-->
  
  <div style="clear:both"></div>
</div><!-- /.main-container -->

<div class="gap"> </div>
