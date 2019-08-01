<?PHP
class Form_Newexamform extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		$name= new Zend_Form_Element_Text('name');
		$name->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Name.')))
					->addDecorator('Errors', array('class'=>'errormsg'))
					->setValue(@$formData['name']);
		$this->addElements(array($name));
		
		$maximum_marks= new Zend_Form_Element_Text('maximum_marks');
		$maximum_marks->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Maximum Marks.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$maximum_marks->setAttrib('onblur','setminmax(\'max_marks\',this.value);');
		$this->addElements(array($maximum_marks));
		
		$minimum_marks= new Zend_Form_Element_Text('minimum_marks');
		$minimum_marks->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Minimum Marks.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$minimum_marks->setAttrib('onblur','setminmax(\'min_marks\',this.value);');
		$this->addElements(array($minimum_marks));
		
	}		
}

?>