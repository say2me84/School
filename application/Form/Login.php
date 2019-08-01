<?PHP
class Form_Login extends Zend_Form
{
	public function init()
	{
		global $mySession;
		$db=new Db();		
		$login_id= new Zend_Form_Element_Text('login_id');
		$login_id->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter your login id.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		
		$login_password= new Zend_Form_Element_Password('login_password');
		$login_password->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter your password.'))
		->addDecorator('Errors', array('class'=>'errormsg'));		
				
		$this->addElements(array($login_id,$login_password));
	}		
}

?>