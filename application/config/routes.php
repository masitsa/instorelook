<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['about'] = 'site/about';
$route['privacy'] = 'site/privacy';
$route['terms'] = 'site/terms';
$route['sign-in'] = 'login/sign_in';
$route['join'] = 'login/sign_up';

/*
*	Settings Routes
*/
$route['settings'] = 'admin/settings';
$route['dashboard'] = 'admin/index';

/*
*	Login Routes
*/
$route['login-admin'] = 'login/login_admin';
$route['logout-admin'] = 'login/logout_admin';

/*
*	Users Routes
*/
$route['all-users'] = 'admin/users';
$route['all-users/(:num)'] = 'admin/users/index/$1';
$route['add-user'] = 'admin/users/add_user';
$route['edit-user/(:num)'] = 'admin/users/edit_user/$1';
$route['delete-user/(:num)'] = 'admin/users/delete_user/$1';
$route['activate-user/(:num)'] = 'admin/users/activate_user/$1';
$route['deactivate-user/(:num)'] = 'admin/users/deactivate_user/$1';
$route['reset-user-password/(:num)'] = 'admin/users/reset_password/$1';
$route['admin-profile/(:num)'] = 'admin/users/admin_profile/$1';
/*
*	Categories Routes
*/
$route['admin/all-categories'] = 'admin/categories/index';
$route['admin/all-categories/(:num)'] = 'admin/categories/index/$1';
$route['admin/add-category'] = 'admin/categories/add_category';
$route['admin/edit-category/(:num)'] = 'admin/categories/edit_category/$1';
$route['admin/delete-category/(:num)'] = 'admin/categories/delete_category/$1';
$route['admin/activate-category/(:num)'] = 'admin/categories/activate_category/$1';
$route['admin/deactivate-category/(:num)'] = 'admin/categories/deactivate_category/$1';
/*
*	Promotion charges Routes
*/
$route['admin/all-promotion-charges'] = 'admin/promotion_charges/index';
$route['admin/all-promotion-charges/(:num)'] = 'admin/promotion_charges/index/$1';
$route['admin/add-promotion-charge'] = 'admin/promotion_charges/add_promotion_charge';
$route['admin/edit-promotion-charge/(:num)'] = 'admin/promotion_charges/edit_promotion_charge/$1';
$route['admin/delete-promotion-charge/(:num)'] = 'admin/promotion_charges/delete_promotion_charge/$1';
$route['admin/activate-promotion-charge/(:num)'] = 'admin/promotion_charges/activate_promotion_charge/$1';
$route['admin/deactivate-promotion-charge/(:num)'] = 'admin/promotion_charges/deactivate_promotion_charge/$1';

/*
*	Banners Routes
*/
$route['admin/banners/revolving-banners'] = 'admin/banners/revolving_banners';
$route['admin/banners/revolving-banners/(:num)'] = 'admin/banners/revolving_banners/$1';
$route['admin/banners/static-banners'] = 'admin/banners/static_banners';
$route['admin/banners/static-banners/(:num)'] = 'admin/banners/static_banners/$1';
$route['admin/banners/delete-revolving-banners/(:num)/(:num)'] = 'admin/banners/delete_revolving_banner/$1/$2';
$route['admin/banners/activate-revolving-banner/(:num)/(:num)'] = 'admin/banners/activate_revolving_banner/$1/$2';
$route['admin/banners/deactivate-revolving-banner/(:num)/(:num)'] = 'admin/banners/deactivate_revolving_banner/$1/$2';
$route['admin/banners/delete-static-banner/(:num)/(:num)'] = 'admin/banners/delete_static_banner/$1/$2';
$route['admin/banners/activate-static-banner/(:num)/(:num)'] = 'admin/banners/activate_static_banner/$1/$2';
$route['admin/banners/deactivate-static-banner/(:num)/(:num)'] = 'admin/banners/deactivate_static_banner/$1/$2';

/*
*	Admin Blog Routes
*/
$route['posts'] = 'admin/blog';
$route['all-posts'] = 'admin/blog';
$route['blog-categories'] = 'admin/blog/categories';
$route['add-post'] = 'admin/blog/add_post';
$route['edit-post/(:num)'] = 'admin/blog/edit_post/$1';
$route['delete-post/(:num)'] = 'admin/blog/delete_post/$1';
$route['activate-post/(:num)'] = 'admin/blog/activate_post/$1';
$route['deactivate-post/(:num)'] = 'admin/blog/deactivate_post/$1';
$route['post-comments/(:num)'] = 'admin/blog/post_comments/$1';
$route['comments/(:num)'] = 'admin/blog/comments/$1';
$route['comments'] = 'admin/blog/comments';
$route['add-comment/(:num)'] = 'admin/blog/add_comment/$1';
$route['delete-comment/(:num)/(:num)'] = 'admin/blog/delete_comment/$1/$2';
$route['activate-comment/(:num)/(:num)'] = 'admin/blog/activate_comment/$1/$2';
$route['deactivate-comment/(:num)/(:num)'] = 'admin/blog/deactivate_comment/$1/$2';
$route['add-blog-category'] = 'admin/blog/add_blog_category';
$route['edit-blog-category/(:num)'] = 'admin/blog/edit_blog_category/$1';
$route['delete-blog-category/(:num)'] = 'admin/blog/delete_blog_category/$1';
$route['activate-blog-category/(:num)'] = 'admin/blog/activate_blog_category/$1';
$route['deactivate-blog-category/(:num)'] = 'admin/blog/deactivate_blog_category/$1';
$route['delete-comment/(:num)'] = 'admin/blog/delete_comment/$1';
$route['activate-comment/(:num)'] = 'admin/blog/activate_comment/$1';
$route['deactivate-comment/(:num)'] = 'admin/blog/deactivate_comment/$1';

/*
*	Blog Routes
*/
$route['blog'] = 'blog';
$route['blog/(:num)'] = 'blog/index/$1';
$route['blog/(:num)/(:num)'] = 'blog/index/$1/$2';
$route['blog/post/(:num)'] = 'blog/view_post/$1';
$route['blog/category/(:num)'] = 'blog/index/$1';
$route['blog/category/(:num)/(:num)'] = 'blog/index/$1/$2';

/*
*	Vendor Routes
*/
$route['vendor/sign-up/user-details'] = 'vendor/vendor_signup1';
$route['vendor/sign-up/personal-details'] = 'vendor/vendor_signup1';
$route['vendor/sign-up/store-details'] = 'vendor/vendor_signup2';
$route['vendor/sign-up/subscribe'] = 'vendor/vendor_signup3';
$route['vendor/subscribe/free'] = 'vendor/subscribe/1';
$route['vendor/subscribe/basic'] = 'vendor/subscribe/2';
$route['vendor/subscribe/unlimited'] = 'vendor/subscribe/3';
$route['vendor/sign-in'] = 'vendor/vendor_signin';
$route['vendor/sign-out'] = 'vendor/vendor_signout';
$route['confirm-account/(:any)'] = 'vendor/verify_email/$1';
$route['vendor/account-profile'] = 'vendor/account/vendor_profile';
$route['vendor/account-profile/(:any)'] = 'vendor/account/vendor_profile/$1';
$route['vendor/update-password'] = 'vendor/account/update_vendor_password';
$route['vendor/update-details'] = 'vendor/account/update_vendor_details';
$route['vendor/update-store'] = 'vendor/account/update_store_details';
$route['vendor/deactivate-account'] = 'vendor/account/deactivate_account';
$route['vendor/goodbye'] = 'vendor/goodbye';
$route['vendor/change-subscription'] = 'vendor/vendor_signup3/2';

/*
*	Categories Routes
*/
$route['vendor/all-categories'] = 'vendor/categories/index';
$route['vendor/add-category'] = 'vendor/categories/add_category';
$route['vendor/search-categories'] = 'vendor/categories/search_categories';
$route['vendor/close-categories-search'] = 'vendor/categories/close_categories_search';
$route['vendor/edit-category/(:num)'] = 'vendor/categories/edit_category/$1';
$route['vendor/update-categories'] = 'vendor/account/update_categories';
$route['vendor/delete-category/(:num)'] = 'vendor/categories/delete_category/$1';
$route['vendor/activate-category/(:num)'] = 'vendor/categories/activate_category/$1';
$route['vendor/deactivate-category/(:num)'] = 'vendor/categories/deactivate_category/$1';

/*
*	Orders Routes
*/
$route['vendor/all-orders'] = 'vendor/orders/index';
$route['vendor/add-order'] = 'vendor/orders/add_order';
$route['vendor/edit-order/(:num)'] = 'vendor/orders/edit_order/$1';
$route['vendor/delete-order/(:num)'] = 'vendor/orders/delete_order/$1';
$route['vendor/deactivate-order/(:num)'] = 'vendor/orders/deactivate_order/$1';
$route['vendor/finish-order/(:num)'] = 'vendor/orders/finish_order/$1';
$route['vendor/cancel-order/(:num)'] = 'vendor/orders/cancel_order/$1';
$route['vendor/orders/add-product/(:num)/(:num)/(:num)/(:num)'] = 'vendor/orders/add_product/$1/$2/$3/$4';
$route['vendor/orders/update-cart/(:num)/(:num)/(:num)'] = 'vendor/orders/update_cart/$1/$2/$3';
$route['vendor/orders/delete-order-item/(:num)/(:num)'] = 'vendor/orders/delete_order_item/$1/$2';

/*
*	Features Routes
*/
$route['vendor/all-features'] = 'vendor/features/index';
$route['vendor/add-feature'] = 'vendor/features/add_feature';
$route['vendor/search-features'] = 'vendor/features/search_features';
$route['vendor/close-features-search'] = 'vendor/features/close_features_search';
$route['vendor/edit-feature/(:num)'] = 'vendor/features/edit_feature/$1';
$route['vendor/delete-feature/(:num)'] = 'vendor/features/delete_feature/$1';
$route['vendor/activate-feature/(:num)'] = 'vendor/features/activate_feature/$1';
$route['vendor/deactivate-feature/(:num)'] = 'vendor/features/deactivate_feature/$1';

/*
*	Products Routes
*/
$route['vendor/all-products'] = 'vendor/products/index';
$route['vendor/search-products'] = 'vendor/products/search_products';
$route['vendor/close-product-search'] = 'vendor/products/close_product_search';
$route['vendor/add-product'] = 'vendor/products/add_product';
$route['vendor/export-product'] = 'vendor/products/export_products';
$route['vendor/import-product'] = 'vendor/products/import_products';
$route['vendor/import-template'] = 'vendor/products/import_template';
$route['vendor/validate-import'] = 'vendor/products/do_products_import';
$route['vendor/import-categories'] = 'vendor/products/import_categories';
$route['vendor/edit-product/(:num)'] = 'vendor/products/edit_product/$1';
$route['vendor/duplicate-product/(:num)'] = 'vendor/products/duplicate_product/$1';
$route['vendor/delete-product/(:num)'] = 'vendor/products/delete_product/$1';
$route['vendor/activate-product/(:num)'] = 'vendor/products/activate_product/$1';
$route['vendor/deactivate-product/(:num)'] = 'vendor/products/deactivate_product/$1';

/*
*	Product bundles Routes
*/
$route['vendor/all-product-bundle'] = 'vendor/products/all_product_bundles';
$route['vendor/search-products-to-bundle/(:num)'] = 'vendor/products/search_product_to_bundles/$1';
$route['vendor/close-product-to-bundle-search/(:num)'] = 'vendor/products/close_product_to_bundle_search/$1';
$route['vendor/search-product-bundle'] = 'vendor/products/search_product_bundles';
$route['vendor/close-product-bundle-search'] = 'vendor/products/close_product_bundles_search';
$route['vendor/add-product-bundle'] = 'vendor/products/add_product_bundle';
$route['vendor/add-product-bundle-items/(:num)'] = 'vendor/products/add_product_bundle_items/$1';
$route['vendor/add-product-to-bundle/(:num)/(:num)'] = 'vendor/products/add_product_to_bundle/$1/$2';
$route['vendor/activate-product-from-bundle/(:num)/(:num)'] = 'vendor/products/activate_product_from_bundle/$1/$2';
$route['vendor/deactivate-product-from-bundle/(:num)/(:num)'] = 'vendor/products/deactivate_product_from_bundle/$1/$2';

/*
*	Brands Routes
*/
$route['vendor/all-brands'] = 'vendor/brands/index';
$route['vendor/add-brand'] = 'vendor/brands/add_brand';
$route['vendor/edit-brand/(:num)'] = 'vendor/brands/edit_brand/$1';
$route['vendor/search-brands'] = 'vendor/brands/search_brands';
$route['vendor/close-brands-search'] = 'vendor/brands/close_brands_search';
$route['vendor/delete-brand/(:num)'] = 'vendor/brands/delete_brand/$1';
$route['vendor/activate-brand/(:num)'] = 'vendor/brands/activate_brand/$1';
$route['vendor/deactivate-brand/(:num)'] = 'vendor/brands/deactivate_brand/$1';

//slides
$route['vendor/all-banners'] = 'vendor/slideshow/index';
$route['vendor/all-banners/(:num)'] = 'vendor/slideshow/index/$1';//with a page number
$route['vendor/add-banner'] = 'vendor/slideshow/add_slide';
$route['vendor/edit-banner/(:num)/(:num)'] = 'vendor/slideshow/edit_slide/$1/$2';
$route['vendor/purchase-banner/(:num)/(:num)'] = 'vendor/slideshow/purchase_slide/$1/$2';
$route['vendor/renew-banner/(:num)/(:num)'] = 'vendor/slideshow/renew_slide/$1/$2';
$route['vendor/delete-banner/(:num)/(:num)'] = 'vendor/slideshow/delete_slide/$1/$2';
$route['banner/purchase-success/(:num)/(:num)'] = 'vendor/slideshow/purchase_success/$1/$2';
$route['banner/purchase-cancel/(:num)/(:num)'] = 'vendor/slideshow/purchase_cancel/$1/$2';

//static banners
$route['vendor/all-static-banners'] = 'vendor/static_banners/index';
$route['vendor/all-static-banners/(:num)'] = 'vendor/static_banners/index/$1';//with a page number
$route['vendor/add-static-banner'] = 'vendor/static_banners/add_static_banner';
$route['vendor/edit-static-banner/(:num)/(:num)'] = 'vendor/static_banners/edit_static_banner/$1/$2';
$route['vendor/purchase-static-banner/(:num)/(:num)'] = 'vendor/static_banners/purchase_static_banner/$1/$2';
$route['vendor/renew-static-banner/(:num)/(:num)'] = 'vendor/static_banners/renew_static_banner/$1/$2';
$route['vendor/delete-static-banner/(:num)/(:num)'] = 'vendor/static_banners/delete_static_banner/$1/$2';
$route['static-banner/purchase-success/(:num)/(:num)'] = 'vendor/static_banners/purchase_success/$1/$2';
$route['static-banner/purchase-cancel/(:num)/(:num)'] = 'vendor/static_banners/purchase_cancel/$1/$2';

/*
*	Products Routes
*/
$route['products/new-products'] = 'site/products/__/0/0/created/1';
$route['products/new-category'] = 'site/products/__/0/0/created/0/1';
$route['products/new-brand'] = 'site/products/__/0/0/created/0/0/1';
$route['products/category/(:num)'] = 'site/products/__/$1';
$route['products/brand/(:num)'] = 'site/products/__/0/$1';
$route['products/category'] = 'site/products/__/0';
$route['products/brand'] = 'site/products/__/0';
$route['products/brand/(:num)'] = 'site/products/__/0/$1';
$route['products/all-products'] = 'site/products/__/0';
$route['products'] = 'site/products/__/0';
$route['products/search'] = 'site/search';
$route['products/search/(:any)'] = 'site/products/$1';
$route['products/price-range/(:any)'] = 'site/products/__/0/0/created/0/0/0/$1';
$route['products/filter-brands/(:any)'] = 'site/products/__/0/0/created/0/0/0/__/$1';
$route['products/filter-brands'] = 'site/filter_brands';
$route['products/sort-by/(:any)'] = 'site/products/__/0/0/$1';
$route['products/view-product/(:num)'] = 'site/view_product/$1';

/*
*	Cart Routes
*/
$route['cart'] = 'site/cart/view_cart';
$route['cart/delete-item/(:any)/(:num)'] = 'site/cart/delete_cart_item/$1/$2';
$route['cart/update-cart'] = 'site/cart/update_cart';

/*
*	Customer Routes
*/
$route['customer/deactivate-account'] = 'login/deactivate_account';
$route['customer/join'] = 'login/register_customer';
$route['customer/sign-in'] = 'login/sign_in_customer';
$route['customer/sign-in/(:num)'] = 'login/sign_in_customer/$1';
$route['account'] = 'login/redirect_account';
$route['customer/account'] = 'site/account/my_account';
$route['account/orders-list'] = 'site/account/orders_list';
$route['account/personnal-information'] = 'site/account/my_details';
$route['account/edit-shipping'] = 'site/account/edit_shipping';
$route['account/wishlist'] = 'site/account/wishlist';
$route['account/update-details'] = 'site/account/update_account';
$route['account/my-addresses'] = 'site/account/my_addresses';
$route['account/update-password'] = 'site/account/update_password';
$route['account/sign-out'] = 'login/logout_user';
$route['account/update-billing-details'] = 'site/checkout/update_billing_details/1';
$route['account/update-shipping-details'] = 'site/checkout/update_shipping_details/1';

/*
*	Checkout Routes
*/
$route['checkout'] = 'site/checkout/checkout_user';
$route['checkout/register'] = 'site/checkout/register';
$route['checkout/update-billing-details'] = 'site/checkout/update_billing_details';
$route['checkout/update-shipping-details'] = 'site/checkout/update_shipping_details';
$route['checkout/login'] = 'site/checkout/login_user/1';
$route['checkout/my-details'] = 'site/checkout/my_details';
$route['checkout-progress'] = 'site/checkout/checkout_progress';
$route['checkout-progress/(:any)'] = 'site/checkout/checkout_progress/$1';
$route['checkout/delivery'] = 'site/checkout/delivery';
$route['checkout/payment'] = 'site/checkout/payment_options';
$route['checkout/order'] = 'site/checkout/order_details';
$route['checkout/add-delivery-instructions'] = 'site/checkout/add_delivery_instructions';
$route['checkout/add-payment-options'] = 'site/checkout/add_payment_options';
$route['checkout/confirm-order'] = 'site/checkout/confirm_order';
$route['checkout/order-complete'] = 'site/checkout/order_complete';

$route['forgot-password'] = 'site/checkout/forgot_password';


/* End of file routes.php */
/* Location: ./application/config/routes.php */