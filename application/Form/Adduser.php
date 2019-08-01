<?PHP
class Form_Adduser extends Zend_Form
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
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$first_name->setValue(@$formData['first_name']);
		
		$last_name= new Zend_Form_Element_Text('last_name');
		$last_name->setValue(@$formData['last_name']);
		
		if(is_array($formData) && $formData['id']!='') {
		
		} else {
		$password= new Zend_Form_Element_Password('password');
		$password->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter your password.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		}
		
		$email= new Zend_Form_Element_Text('email');
		$email->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter Email.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$email->setValue(@$formData['email']);
		
			$user_school[0]['key']='';
			$user_school[0]['value']='---Select School---';
			$skul= $this->skul();
			if(is_array($skul) && count($skul) > 0)
			{ $i=1;
				foreach($skul as $slist)
				{
					$user_school[$i]['key']=$slist['id'];
					$user_school[$i]['value']=$slist['name'];		
					$i++;
				}
			}				
		$school= new Zend_Form_Element_Select('school');
		$school->addMultiOptions($user_school);
		$school->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please select the School.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$school->setValue(@$formData['schoolid']);
						
		$this->addElements(array($username,$first_name,$last_name,$password,$email,$school));
	}
	
	function skul()
	{
	$db= new Db();
	$qry= "select id, name from `school` where status='1' ";
	$gradarray=$db->runQuery("$qry");
	return $gradarray;
	}
}

?>