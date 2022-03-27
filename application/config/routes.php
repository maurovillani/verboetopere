<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

/**
 * Tutto ciò che è inerente la sicurezza 
 */
$route['edit_user/(:any)'] = 'auth/edit_user/$1';
$route['edit_group/(:any)'] = 'auth/edit_group/$1';

$route['create_group'] = 'auth/create_group';
$route['create_user'] = 'auth/create_user';
//$route['create_user_preiscrizione'] = 'auth/create_user_preiscrizione'; 
$route['imposta_lingua/(:any)/(:any)'] = 'auth/imposta_lingua/$1/$2'; 
$route['Preiscrizione'] = 'auth/create_user_preiscrizione'; 
$route['create_email_richiesta_certificato_preiscrizione/(:any)/(:any)/(:any)'] = 'auth/create_email_richiesta_certificato_preiscrizione/$1/$2/$3'; 
$route['create_email_invio_certificato_preiscrizione/(:any)'] = 'auth/create_email_invio_certificato_preiscrizione/$1'; 

//amf
$route['recupera_password'] = 'auth/recupera_password'; 
$route['email_recupera_password'] = 'auth/email_recupera_password'; 
//$route['imposta_nuova_password/(:any)'] = 'auth/imposta_nuova_password/$1';
$route['imposta_nuova_password/(:any)'] = 'auth/imposta_nuova_password/$1';
$route['modifica_password_dimenticata/(:any)'] = 'auth/modifica_password_dimenticata/$1';

//amf

$route['change_password'] = 'auth/change_password';
$route['forgot_password'] = 'auth/forgot_password';
$route['reset_password/(:any)'] = 'auth/reset_password/$1';


$route['activatebyemail/(:any)/(:any)'] = 'auth/activate/$1/$2';
$route['activate/(:any)'] = 'auth/activate/$1';

$route['deactivate/(:any)'] = 'auth/deactivate/$1';

$route['redirect'] = 'auth/redirectUser';

$route['logout'] = 'auth/logout';
$route['login'] = 'auth/login';
$route['auth'] = 'auth';

$route['preiscrizione_ok'] = 'auth/preiscrizione_ok';
$route['preiscrizione_ko'] = 'auth/preiscrizione_ko';
$route['ServiziOnLine'] = 'auth/ServiziOnLine';

$route['menu/group'] = 'menu/group';
$route['menu/test'] = 'menu/test';
$route['menu'] = 'menu';

/**
 * Questa sezione è inerente alle attivita di backoffice
 */
$route['backend/datatable/(:any)'] = 'backend/datatable/$1';
$route['backend/diocesi/(:any)'] =  'backend/diocesi/$1'; 

$route['backend/report/(:any)'] =    'backend/report/$1';

$route['backend/edit_record/(:any)/(:any)'] = 'backend/edit_record/$1/$2';
$route['backend/new_record/(:any)/(:any)'] = 'backend/new_record/$1/$2';
$route['backend/delete_record/(:any)'] = 'backend/delete_record/$1';

$route['backend/studente/(:any)'] =  'backend/studente/$1'; 
$route['backend/studente_preiscrizione/(:any)'] =  'backend/studente_preiscrizione/$1'; 
$route['backend/self_studente/(:any)'] =  'backend/self_studente/$1'; 
$route['backend/self_professore/(:any)'] =  'backend/self_professore/$1'; 
$route['backend/pianostudi'] = 'backend/pianostudi';
$route['backend/pianostudi_studente/(:any)/(:any)'] = 'backend/pianostudi_studente/$1/$2';
$route['backend/scelta_corsi_studente/(:any)/(:any)/(:any)/(:any)'] = 'backend/scelta_corsi_studente/$1/$2/$3/$4';

$route['backend/professore/(:any)'] =  'backend/professore/$1'; 

$route['backend/modulo_iscrizione_corsi/(:any)/(:any)/(:any)/(:any)'] =  'backend/modulo_iscrizione_corsi/$1/$2/$3/$4'; 
$route['backend/modulo_certificato_preiscrizione/(:any)'] =  'backend/modulo_certificato_preiscrizione/$1'; 

//$route['backend/provincia/(:any)'] = 'backend/provincia/$1'; 
$route['backend/collegio/(:any)'] =  'backend/collegio/$1'; 
//$route['backend/collegio_new'] =  'backend/collegio_new'; 

$route['backend' . '/(:any)'] = 'backend/$1';
$route['backend'] = 'backend';

/**
 * Front End
 */
//$route['preiscrizione/studente/(:any)'] =  'frontend/studente/$1'; 
$route['preiscrizione/salva'] = 'frontend/save';
//$route['preiscrizione'] = 'frontend/preiscrizione';

$route['frontend' . '/(:any)'] = 'frontend';
$route['frontend'] = 'frontend';

$route['sendemail'] = 'sendemail';

$route['language' . '/(:any)'] = 'languageswitcher/switchLang/$1';

/**
 * Routing di default del framework CI
 */
$route['default_controller'] = 'frontend';
$route['404_override'] = 'backend/error404';
$route['translate_uri_dashes'] = FALSE;
