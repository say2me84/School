<?php
class Form_Admission21 extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
			if(empty($formData['userid'])) {
				$clause    = "schoolid ='".$mySession->user['schoolid']."' and usertype='P'";
				$parent_already_username= new Zend_Form_Element_Text('parent_already_username');
				$parent_already_username->setRequired(true)
					->addValidator('NotEmpty',true,array('messages' =>'Please enter the username.'))
					->addDecorator('Errors', array('class'=>'errormsg'))
					->setValue(@$formData['username'])
					->addValidator('Db_RecordExists',
									 false,
									 array('table' => 'users',
										   'field' => 'username',
										   'exclude' => $clause,
								   		   'messages' => array(Zend_Validate_Db_Abstract::ERROR_NO_RECORD_FOUND => 'Not match to any parent\'s username')));
				$this->addElements(array($parent_already_username));
			}
		
		
		
	}		
}

?>