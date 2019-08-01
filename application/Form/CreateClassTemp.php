<?PHP
class Form_CreateClassTemp extends Zend_Form
{
	public function __construct($iid="")
	{
		$this->init($iid);
	}
	public function init($iid)
	{
		
		global $mySession;
		$db=new Db();
			if($iid!="")
			{
				$formData=$db->runQuery("select * from `grades` where id='".$iid."'");
				$class_name_value = $formData[0]['grade_name'];
				$code_value = $formData[0]['code'];
				$section_name_value = $formData[0]['section_name'];
				
			}		
		$grade_name= new Zend_Form_Element_Text('grade_name');
		$grade_name->setValue(@$class_name_value);
		$grade_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter grade name.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
				
		$this->addElements(array($grade_name));
		
				
		
	}
	
}

?>