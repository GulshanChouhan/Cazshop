<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 					 = 'page';
$route['404_override']       					 = 'page/_404';
$route['translate_uri_dashes'] 					 =  FALSE;
$route['behindthescreen']      					 = 'backend/superadmin/login';
$route['seller/(:any)']                          = "seller/seller/$1";
$route['seller/skip/(:any)']           			 = "seller/seller/skip/$1";
$route['seller/skip/(:any)/(:any)']           	 = "seller/seller/skip/$1/$2";
$route['seller/agreement_step/(:any)']           = "seller/seller/agreement_step/$1";
$route['seller/phone_verification/(:any)']       = "seller/seller/phone_verification/$1";
$route['seller/confirm_verification/(:any)']     = "seller/seller/confirm_verification/$1";
$route['seller/seller_information/(:any)']       = "seller/seller/seller_information/$1";
$route['seller/seller_interview/(:any)']         = "seller/seller/seller_interview/$1";
$route['seller/shipment_option/(:any)']          = "seller/seller/shipment_option/$1";
$route['seller/signature_or_licence/(:any)']     = "seller/seller/signature_or_licence/$1";
$route['seller/seller_dashboard/(:any)']         = "seller/seller/seller_dashboard/$1";
$route['seller/login_though_sellerDashboard/(:any)'] = "seller/seller/login_though_sellerDashboard/$1";
$route['seller/reset_password/(:any)'] 			 = "seller/seller/reset_password/$1";
$route['seller/page/(:any)'] 					 = "seller/seller/page/$1";

/*-----------------for country state city page-----------*/
$route['seller/country_rates/(:any)']           = "seller/seller/country_rates/$1";
$route['seller/country_rates/(:any)/(:any)']           = "seller/seller/country_rates/$1/$2";
$route['seller/country_rates/(:any)/(:any)/(:any)']           = "seller/seller/country_rates/$1/$2/$3";
$route['seller/country_rates/(:any)/(:any)/(:any)/(:any)']           = "seller/seller/country_rates/$1/$2/$3/$4";
$route['seller/country_rates/(:any)/(:any)/(:any)/(:any)/(:any)']           = "seller/seller/country_rates/$1/$2/$3/$4/$5";

$route['seller/province_rates/(:any)']           = "seller/seller/province_rates/$1";
$route['seller/province_rates/(:any)/(:any)']           = "seller/seller/province_rates/$1/$2";
$route['seller/province_rates/(:any)/(:any)/(:any)']           = "seller/seller/province_rates/$1/$2/$3";
$route['seller/province_rates/(:any)/(:any)/(:any)/(:any)']           = "seller/seller/province_rates/$1/$2/$3";
$route['seller/province_rates/(:any)/(:any)/(:any)/(:any)/(:any)']           = "seller/seller/province_rates/$1/$2/$3";

$route['seller/cities_rates/(:any)']             = "seller/seller/cities_rates/$1";
$route['seller/cities_rates/(:any)/(:any)']             = "seller/seller/cities_rates/$1/$2";
$route['seller/cities_rates/(:any)/(:any)/(:any)']             = "seller/seller/cities_rates/$1/$2/$3";
$route['seller/cities_rates/(:any)/(:any)/(:any)/(:any)']             = "seller/seller/cities_rates/$1/$2/$3/$4";
$route['seller/cities_rates/(:any)/(:any)/(:any)/(:any)/(:any)']             = "seller/seller/cities_rates/$1/$2/$3/$4/$5";

/* product details page */
$route['p']         	                           = "products/index";
$route['p/(:any)']                               = "products/index/$1";
$route['p/(:any)/(:any)']                        = "products/index/$1/$2";
$route['p/(:any)/(:any)/(:any)']                 = "products/index/$1/$2/$3";
$route['p/(:any)/(:any)/(:any)/(:any)']          = "products/index/$1/$2/$3/$4";

$route['pd']         	                          = "products/details";
$route['pd/(:any)']                               = "products/details/$1";
$route['pd/(:any)/(:any)']                        = "products/details/$1/$2";
$route['pd/(:any)/(:any)/(:any)']                 = "products/details/$1/$2/$3";
$route['pd/(:any)/(:any)/(:any)/(:any)']          = "products/details/$1/$2/$3/$4";

/* category listing page */
$route['rating']         	                      = "products/rating";
$route['rating/(:any)']                           = "products/rating/$1";
$route['rating/(:any)/(:any)']                    = "products/rating/$1/$2";
$route['page/(:any)/(:any)']                      = "page/$1/$2";

$route['(:any)']               					  = "category/index/$1";
//$route['All_orders']                              =  "seller/orders/index";

