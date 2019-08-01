<?php
__autoloadDB('Db');
class BackupController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
		
	public function allAction()
	{	
		global $mySession;
		if($mySession->user['usertype']!='A') {
			echo "<script>window.location='".APPLICATION_URL."'</script>";
			exit;
		}
		/*$config = Zend_Registry::get('config');		
        $dbUsername = $config->database->params->username;
        $dbPassword = $config->database->params->password;
        $dbName = $config->database->params->dbname;*/
		$phpMySQLAutoBackup_version="1.5.0";
		
		$db_server = 'localhost'; // your MySQL server - localhost will normally suffice
		$db = 'smportal'; // your MySQL database name
		$mysql_username = 'root';  // your MySQL username
		$mysql_password = '';  // your MySQL password
		
		$time_internal=3600;
		$save_backup_zip_file_to_server = 1;
		
		$newline="\r\n";
		$limit_to=10000000;
		$limit_from=0;
		
		include_once(APPLICATION_PATH.'application/files/phpmysqlautobackup.php');
		
	}
	
	
	
}
?>