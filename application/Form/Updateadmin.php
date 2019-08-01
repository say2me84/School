<?PHP
class Form_Updateadmin extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		$username= new Zend_Form_Element_Text('username');
		$username->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter username.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$username->setValue(@$formData['username']);
		$this->addElements(array($username));
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$first_name->setValue(@$formData['first_name']);
		$this->addElements(array($first_name));
		
		$last_name= new Zend_Form_Element_Text('last_name');
		$last_name->setValue(@$formData['last_name']);
		$this->addElements(array($last_name));
		
		if(is_array($formData) && $formData['id']!='') {
		
		} else {
		$password= new Zend_Form_Element_Password('password');
		$password->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter your password.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($password));
		}
		
		$email= new Zend_Form_Element_Text('email');
		$email->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter Email.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$email->setValue(@$formData['email']);
		$this->addElements(array($email));

	}
}

?>