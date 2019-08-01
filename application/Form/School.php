<?PHP
class Form_School extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		global $mySession;
		$db=new Db();		
		$institution_name= new Zend_Form_Element_Text('institution_name');
		$institution_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$institution_name->setValue(@$formData['name']);
		
		$institution_address= new Zend_Form_Element_Text('institution_address');
		$institution_address->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the address.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$institution_address->setValue(@$formData['address']);
		
		$institution_phone_no= new Zend_Form_Element_Text('institution_phone_no');
		$institution_phone_no->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Contact Number.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$institution_phone_no->setValue(@$formData['phno']);
		
		$institution_fax_no= new Zend_Form_Element_Text('institution_fax_no');
		$institution_fax_no->setValue(@$formData['mhno']);
		
		
		$student_photo= new Zend_Form_Element_File('student_photo');
		$student_photo->setAttrib('onchange','return check_file_extension(this)');
		$this->addElements(array($student_photo));
				
		$this->addElements(array($institution_name,$institution_address,$institution_phone_no,$institution_fax_no));
	}		
}

?>