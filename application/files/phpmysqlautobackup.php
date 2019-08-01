<?php
/*******************************************************************************************
    phpMySQLAutoBackup  -  Author:  http://www.DWalker.co.uk - released under GPL License
           For support and help please try the forum at: http://www.dwalker.co.uk/forum/
********************************************************************************************
Version    Date              Comment
0.2.0      7th July 2005     GPL release
0.3.0      June 2006  Upgrade - added ability to backup separate tables
0.4.0      Dec 2006   removed bugs/improved code
1.4.0      Dec 2007   improved faster version
1.5.0      Dec 2008   improved and added FTP backup to remote site
********************************************************************************************/

$phpMySQLAutoBackup_version="1.5.0";
// ---------------------------------------------------------
if(($db=="")OR($mysql_username==""))
{
 echo "Configure your installation BEFORE running, add your details to the file /phpmysqlautobackup/run.php";
 exit;
}
$backup_type="\n\n BACKUP Type: Full database backup (all tables included)\n\n";
if (isset($table_select))
{
 $backup_type="\n\n BACKUP Type: partial, includes tables:\n";
 foreach ($table_select as $key => $value) $backup_type.= "  $value;\n";
}
if (isset($table_exclude))
{
 $backup_type="\n\n BACKUP Type: partial, EXCLUDES tables:\n";
 foreach ($table_exclude as $key => $value) $backup_type.= "  $value;\n";
}
$already=0;
include_once(APPLICATION_PATH.'application/files/phpmysqlautobackup_extras.php');
include_once(APPLICATION_PATH.'application/files/schema_for_export.php');

if($already==1) {
$mySession->sucMsg = LNG_BACKUP_ALREADY_MESSAGE;
} else {
	// zip the backup and email it
	$backup_file_name = 'mysql_'.$db.strftime("_%d_%b_%Y_time_%H_%M_%S.sql",time()).'.gz';
	$dump_buffer = gzencode($buffer);
	if ($from_emailaddress>"") xmail($to_emailaddress,$from_emailaddress, "phpMySQLAutoBackup: $backup_file_name", $dump_buffer, $backup_file_name, $backup_type, $newline);
	if ($save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
	
	//FTP backup file to remote server
	if (isset($ftp_username))
	{
	 //write the backup file to local server ready for transfer if not already done so
	 if (!$save_backup_zip_file_to_server) write_backup($dump_buffer, $backup_file_name);
	 $transfer_backup = new transfer_backup();
	 $transfer_backup->transfer_data($ftp_username,$ftp_password,$ftp_server,$ftp_path,$backup_file_name);
	 if (!$save_backup_zip_file_to_server) unlink(LOCATION."../backups/".$backup_file_name);
	}
	$this->view->backup_file_name = $backup_file_name;
	$mySession->sucMsg = LNG_BACKUP_COMPLETED;
}


?>

