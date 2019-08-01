<?php
//created and developed by Shakti Singh
$_CONFIG['environment'] = 'development';

define('APPLICATION_URL', "http://localhost/sites/msschool/");
//define('APPLICATION_URL', "http://192.168.137.2/sites/smportal/");
define('APPLICATION_URL_ADMIN', APPLICATION_URL."admin/");
define('UPDATE_KEY', '369');
define('BASE_PATH', '/sites/msschool/');
define('FILE_URL', '/sites/msschool/');

define('IMAGES_URL', APPLICATION_URL.'images/');
define('CSS_URL', APPLICATION_URL.'css/');
define('JS_URL', APPLICATION_URL.'js/');

define('IMAGES_URL_ADMIN', APPLICATION_URL_ADMIN.'images/');
define('CSS_URL_ADMIN', APPLICATION_URL_ADMIN.'css/');
define('JS_URL_ADMIN', APPLICATION_URL_ADMIN.'js/');

$_CONFIG['homeDir'] = realpath(dirname(dirname(dirname(__FILE__)))).'/'; 

define('SITE_ROOT', $_CONFIG['homeDir']);

define("ADMIN_EMAIL", "mscosian@gmail.com");
define("MAIL_SITE_NAME", "My School");

$_CONFIG['homeDir'] = realpath(dirname(dirname(dirname(__FILE__)))).'/';
?>