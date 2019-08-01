<?PHP
class Form_Addcategory extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		parent::__construct();

		$student_category_name= new Zend_Form_Element_Text('student_category_name');
		$student_category_name->setValue(@$formData['name']);
		$student_category_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Category Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$student_category_name->setAttrib('onkeypress','return chk_alpha(event)');
		$student_prefix_name= new Zend_Form_Element_Text('prefix');
		
		$status = new Zend_Form_Element_Radio('status');
    	$status->addMultiOptions(array(
        		'1' => 'Active',
        		'0' => 'Inactive'))
      		->setSeparator('')->setValue('1');
		
		
		if($formData)
		{
			
			$id= new Zend_Form_Element_Hidden('id');
			
			$id->setValue($formData['id']);
			$student_category_name->setValue($formData['name']);
			$student_prefix_name->setValue($formData['prefix']);
			$status->setValue($formData['status']);
			
			$this->addElements(array($id, $student_category_name, $student_prefix_name, $status));
			
		}
		
		else{
		$this->addElements(array($student_category_name, $student_prefix_name, $status)); 
		}
	}		
}

?>