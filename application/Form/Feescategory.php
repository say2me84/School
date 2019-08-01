<?PHP
class Form_Feescategory extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		parent::__construct();

		$category_name= new Zend_Form_Element_Text('category_name');
		$category_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the category.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		
		$prefix_name= new Zend_Form_Element_Text('prefix');
		
		$status = new Zend_Form_Element_Radio('status');
    	$status->addMultiOptions(array(
        		'1' => 'Active',
        		'0' => 'Inactive'))
      		->setSeparator('')->setValue('1');
		
		
		if($formData)
		{
			
			$id= new Zend_Form_Element_Hidden('id');
			
			$id->setValue($formData['id']);
			$category_name->setValue($formData['name']);
			$prefix_name->setValue($formData['prefix']);
			$status->setValue($formData['status']);
			
			$this->addElements(array($id, $category_name, $prefix_name, $status));
			
		}
		
		else{
		$this->addElements(array($category_name, $prefix_name, $status)); 
		}
	}		
}

?>