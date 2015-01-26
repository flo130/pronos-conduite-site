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

//landing page
$route['default_controller'] = 'landing';
//pages d'erreurs
$route['404_override'] = 'error/notfound';
$route['500_override'] = 'error/problem';
//user
$route['connexion'] = 'user/login';
$route['deconnexion'] = 'user/logout';
$route['inscription'] = 'user/register';
$route['mot-de-passe-oublie'] = 'user/passwordForgot';
$route['utilisateur/profile/(:any)'] = "user/profil/$1";
$route['utilisateur/amis/(:any)'] = "user/friend/$1";
$route['utilisateur/statistiques/(:any)'] = "user/stat/$1";
$route['utilisateur/parametres/(:any)'] = "user/parameter/$1";
//stats
$route['equipe/statistiques/(:any)'] = "stat/get/$1";
//litige
$route['litiges'] = 'litige';
//faq
$route['foire-aux-questions'] = 'faq';
//notification
$route['notifications'] = 'notification';
//alertes
$route['alertes'] = 'alert';
//trajets
$route['trajets/ajouter'] = 'trip/add';
$route['trajets/voir'] = 'trip/get';
//pronostiques
$route['pronostiques/ajouter'] = 'bet/add';
$route['pronostiques/voir'] = 'bet/get';
//calendrier
$route['calendrier/ligue1'] = 'calendar/ligueOne';
$route['calendrier/ligue2'] = 'calendar/ligueTwo';
$route['calendrier/equipe/(:any)'] = "calendar/team/$1";
//classement
$route['classement/ligue1'] = 'rank/ligueOne';
$route['classement/ligue2'] = 'rank/ligueTwo';
//rechercher
$route['rechercher'] = 'search';


/* End of file routes.php */
/* Location: ./application/config/routes.php */