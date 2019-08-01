<?PHP
class Form_Gradinglevel extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		global $mySession;
		$db=new Db();		
		$name= new Zend_Form_Element_Text('name');
		$name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$name->setValue(@$formData['name']);
		$this->addElements(array($name));
	
		
		$min_score= new Zend_Form_Element_Text('min_score');
		$min_score->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter min score.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$min_score->setValue(@$formData['min_score']);
		
		$this->addElements(array($min_score));
						
		
	}
	
	
}

?>