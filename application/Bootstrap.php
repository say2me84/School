<?php
// APPLICATION CONSTANTS - Set the constants to use in this application.
// These constants are accessible throughout the application, even in ini 
// files. We optionally set APPLICATION_PATH here in case our entry point 
// isn't index.php (e.g., if required from our test suite or a script).
defined('APPLICATION_PATH')    or define('APPLICATION_PATH', dirname(__FILE__));

include_once(APPLICATION_PATH.'application/configs/config.inc.php');

include_once(APPLICATION_PATH.'application/configs/general.php');


defined('APPLICATION_ENVIRONMENT')
    or define('APPLICATION_ENVIRONMENT', 'development');
    
ini_set('display_errors','on');
//error_reporting(E_ALL);
error_reporting(0);
		
		
// FRONT CONTROLLER - Get the front controller.
// The Zend_Front_Controller class implements the Singleton pattern, which is a
// design pattern used to ensure there is only one instance of
// Zend_Front_Controller created on each request.
$frontController = Zend_Controller_Front::getInstance();

//Zend_Controller_Front::run('../application/controllers');

//echo "<pre>";
//print_r($frontController); die;

// CONTROLLER DIRECTORY SETUP - Point the front controller to your action
// controller directory.
$frontController->setControllerDirectory(APPLICATION_PATH . 'application/controllers');

// APPLICATION ENVIRONMENT - Set the current environment
// Set a variable in the front controller indicating the current environment --
// commonly one of development, staging, testing, production, but wholly
// dependent on your organization and site's needs.
$frontController->setParam('env', APPLICATION_ENVIRONMENT);

// LAYOUT SETUP - Setup the layout component
// The Zend_Layout component implements a composite (or two-step-view) pattern
// In this call we are telling the component where to find the layouts scripts.
Zend_Layout::startMvc(APPLICATION_PATH . 'application/layouts/scripts', false, "layout");

// VIEW SETUP - Initialize properties of the view object
// The Zend_View component is used for rendering views. Here, we grab a "global"
// view instance from the layout object, and specify the doctype we wish to
// use -- in this case, XHTML1 Strict.
//$view = Zend_Layout::getMvcInstance()->getView();
//$view->setEncoding('UTF-8');
//$view->doctype('XHTML1_STRICT');

// Add helpers prefixed with Helper in helpers/
Zend_Controller_Action_HelperBroker::addPath('application/helpers/','Zend_Controller_Action_Helper_');
//$value = Zend_Controller_Action_HelperBroker::getStaticHelper('Myhelper')->displaythis();
//$value = Zend_Controller_Action_HelperBroker::getStaticHelper('Myhelper')->liscenceInfo();
				

// CONFIGURATION - Setup the configuration object
// The Zend_Config_Ini component will parse the ini file, and resolve all of
// the values for the given section.  Here we will be using the section name
// that corresponds to the APP's Environment
$configuration = new Zend_Config_Ini(APPLICATION_PATH . 'application/configs/application.ini', 'development');
// DATABASE ADAPTER - Setup the database adapter
// Zend_Db implements a factory interface that allows developers to pass in an
// adapter name and some parameters that will create an appropriate database
// adapter object.  In this instance, we will be using the values found in the
// "database" section of the configuration obj.
$dbAdapter = Zend_Db::factory($configuration->database);

// DATABASE TABLE SETUP - Setup the Database Table Adapter
// Since our application will be utilizing the Zend_Db_Table component, we need 
// to give it a default adapter that all table objects will be able to utilize 
// when sending queries to the db.

$dbAdapter->query("SET NAMES 'utf8'");
Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);


// REGISTRY - setup the application registry
// An application registry allows the application to store application 
// necessary objects into a safe and consistent (non global) place for future 
// retrieval.  This allows the application to ensure that regardless of what 
// happends in the global scope, the registry will contain the objects it 
// needs.
$registry = Zend_Registry::getInstance();
$registry->configuration = $configuration;
$registry->dbAdapter     = $dbAdapter;

//$helper = new Zend_Controller_Action_Helper_MWWMaster;
//$helper->preDispatch();
//Zend_Controller_Action_HelperBroker::addHelper('MWWMaster');
//$hb = new Zend_Controller_Action_HelperBroker;
//$hb->getHelper('MWWMaster');


//$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('MWWMaster');
//$viewRenderer->setView($view);



// CLEANUP - remove items from global scope
// This will clear all our local boostrap variables from the global scope of 
// this script (and any scripts that called bootstrap).  This will enforce 
// object retrieval through the Applications's Registry
unset($frontController, $view, $configuration, $dbAdapter, $registry);