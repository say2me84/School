<?PHP
class Form_Adddepartment extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		parent::__construct();

		$name= new Zend_Form_Element_Text('name');
		$name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Department Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$name->setAttrib('onkeypress','return chk_alpha(event)');
		
		$code= new Zend_Form_Element_Text('code');
		$code->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Code.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		
		$status = new Zend_Form_Element_Radio('status');
    	$status->addMultiOptions(array(
        		'1' => 'Active',
        		'0' => 'Inactive'))
      		->setSeparator('')->setValue('1');
		
		
		if($formData)
		{
			
			$id= new Zend_Form_Element_Hidden('id');
			
			$id->setValue($formData['id']);
			$name->setValue($formData['name']);
			$code->setValue($formData['code']);
			$status->setValue($formData['status']);
			
			$this->addElements(array($id, $name, $code, $status));
			
		}
		
		else{
		$this->addElements(array($name, $code, $status)); 
		}
	}		
}

?>