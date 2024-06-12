<?php
defined('BASEPATH') or exit('No direct script access allowed');
 

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['api/demo'] = 'api/ApiDemoController/index';



// User
$route['user'] = 'User';
$route['login'] = 'User/login';
$route['user/find/(:any)'] = 'User/find/$1';
$route['user/update_login_status'] = 'User/update_login_status';
$route['user/update/(:any)'] = 'User/update/$1';
$route['user/delete/(:any)'] = 'User/delete/$1';

 


// Violation
$route['violation'] = 'Violation';
$route['violation/insert'] = 'Violation/insert';
$route['violation/get_violation'] = 'Violation/get_violation';
$route['violation/find/(:any)'] = 'Violation/find/$1';
$route['violation/update/(:any)'] = 'Violation/update/$1';
$route['violation/payment/(:any)'] = 'Violation/payment/$1';
$route['violation/delete/(:any)'] = 'Violation/delete/$1';
$route['violation/get_driver_violation'] = 'Violation/get_driver_violation';



// Community Engagement
$route['community_engagement'] = 'CommunityEngagement';
$route['community_engagement/insert'] = 'CommunityEngagement/insert';
$route['community_engagement/get_community_engagement'] = 'CommunityEngagement/get_community_engagement';

$route['community_engagement/approved_list'] = 'CommunityEngagement/approved_list';
$route['community_engagement/find/(:any)'] = 'CommunityEngagement/find/$1';
$route['community_engagement/update/(:any)'] = 'CommunityEngagement/update/$1';
$route['community_engagement/delete/(:any)'] = 'CommunityEngagement/delete/$1';



// Penalty
$route['penalty'] = 'Penalty';
$route['penalty/insert'] = 'Penalty/insert';
$route['penalty/find/(:any)'] = 'Penalty/find/$1';
$route['penalty/update/(:any)'] = 'Penalty/update/$1';
$route['penalty/delete/(:any)'] = 'Penalty/delete/$1';


