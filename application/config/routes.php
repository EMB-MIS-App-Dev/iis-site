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
$route['default_controller'] = 'Index';
$route['dashboard'] = 'Index';
$route['attachment'] = "Attachment";


$route['404_override'] = 'Index/error_404';
$route['translate_uri_dashes'] = FALSE;

// DMS CUSTOM ROUTING
$route['test/documents/(:any)'] = 'Dms/Main_TestController';
$route['dms/test'] = 'Dms/Test';

$route['dms/documents/process/(:any)/(:any)/(:any)/(:any)'] = 'Dms/Process'; // (?i)
$route['dms/documents/new/(:num)'] = 'Dms/Create';
$route['dms/documents/revise/(:any)/(:any)/(:any)/(:any)'] = 'Dms/Revise';
$route['dms/documents/migrate/(:num)'] = 'Dms/migrate';

$route['dms/documents'] = 'Dms/Main';
$route['dms/documents/(:any)'] = 'Dms/Main';
$route['dms/documents/(:any)/(:any)'] = 'Dms/Main';

$route['dms/data/ajax/(:any)'] = 'Dms/Ajax_Data/$1';
// $route['dms/forms/(:any)'] = 'Dms/Form_Data/$1';

// UNIVERSE ROUTE
$route['univ/(:any)'] = 'Universe/Main';
$route['universe/(:any)'] = 'Universe/Main2';

$route['travel/printto/(:any)'] = 'Travel/PrintTO/index/$1';
$route['travel/dashboard'] = 'Travel/Dashboard/index';
$route['travel/forapproval'] = 'Travel/Dashboard/Forapproval';
$route['travel/forapprovalred'] = 'Travel/Dashboard/Forapprovalred';
$route['travel/ticket'] = 'Travel/Ticket/Index';
$route['travel/allapproved'] = 'Travel/Dashboard/Allapproved';

$route['administrative/userlist'] = 'Admin/User_accounts/User_list';
$route['administrative/uploads'] = 'Admin/Uploads';

$route['schedule/dashboard'] = 'Schedule/Dashboard/Index';

$route['swm/dashboard'] = 'Swm/Sweet/index';
$route['swm/form'] = 'Swm/Form';
$route['swm/Letter/pdf/(:any)'] = 'Swm/Letter/pdf/$1';
$route['swm/reports'] = 'Swm/Reports/index';

$route['pbsapi'] = 'api/Pbs/json';
$route['ptaasapiauth'] = 'api/Pbs/ptsapiauth';
$route['burapiauth'] = 'api/Pbs/burapiauth';

$route['iisqrcode'] = 'Repository/index';

$route['dtr/dashboard'] = 'Admin/DTR/index';
$route['dtr/pdf/(:any)'] = 'Admin/DTR/Pdf/$1';
$route['dtr/pdfprev'] = 'Admin/DTR/PdfPrev';

// $route['pds/main'] = 'Admin/Pds/index';
// $route['pds/form/(:any)'] = 'Admin/Pds/index';

$route['api/mobile/dtr'] = 'api/Mobile/dtr';
// companies
$route['company/company_list'] = 'Company/Company_list';
$route['company/approved'] = 'Company/Company_list/approved_company_request';
$route['company/for_approval'] = 'Company/Company_list/for_approval_company_request';
$route['company/disapproved'] = 'Company/Company_list/disapproved_company_request';

$route['support/tickets'] = 'Support/Emb_support';
$route['client/lists'] = 'Clients/Clients/userlist';
$route['vehicle/tickets'] = 'Vehicle/Main';


$route['downloadables'] = 'Downloadables/Dashboard/index';


// SSO
$route['test'] = "SSO/Ssocontroller/test";
$route['ssoenrollment'] = "SSO/Ssocontroller/enrollment";
$route['ssoenroll'] = "SSO/Ssocontroller/enroll";
$route['ssoget'] = "SSO/Ssocontroller/getsubsys";
$route['ssorem/(:num)'] = "SSO/Ssocontroller/remsubsys/$1";

// SSO login

$route['logout'] = "Index/logout_user";
$route['emailtoken/(:any)'] = "SSO/Ssocontroller/emailtoken/$1";
$route['emailtokenverify'] = "SSO/Ssocontroller/emailtokenverify";
