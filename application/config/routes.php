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

$route['default_controller'] = "blog";
$route['404_override'] = '';

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['about'] = 'site/about';
$route['terms'] = 'site/terms';

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

/*
*	Categories Routes
*/
$route['vendor/all-categories'] = 'vendor/categories/index';
$route['vendor/add-category'] = 'vendor/categories/add_category';
$route['vendor/edit-category/(:num)'] = 'vendor/categories/edit_category/$1';
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
$route['vendor/delete-product/(:num)'] = 'vendor/products/delete_product/$1';
$route['vendor/activate-product/(:num)'] = 'vendor/products/activate_product/$1';
$route['vendor/deactivate-product/(:num)'] = 'vendor/products/deactivate_product/$1';

/*
*	Brands Routes
*/
$route['vendor/all-brands'] = 'vendor/brands/index';
$route['vendor/add-brand'] = 'vendor/brands/add_brand';
$route['vendor/edit-brand/(:num)'] = 'vendor/brands/edit_brand/$1';
$route['vendor/delete-brand/(:num)'] = 'vendor/brands/delete_brand/$1';
$route['vendor/activate-brand/(:num)'] = 'vendor/brands/activate_brand/$1';
$route['vendor/deactivate-brand/(:num)'] = 'vendor/brands/deactivate_brand/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */