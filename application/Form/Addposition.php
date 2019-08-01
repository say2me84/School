<?PHP
class Form_Addposition extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		$name= new Zend_Form_Element_Text('name');
		$name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter the Position Name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$name->setAttrib('onkeypress','return chk_alpha(event)');
		
		$categories = $this->getEmployeeCategory();
			
		$employee_category_id= new Zend_Form_Element_Select('employee_category_id'); 
			if(is_array($categories) && count($categories) > 0)
			{ 
				$employee_category_id->addMultiOptions($categories);
			}
				$employee_category_id->setRegisterInArrayValidator(false); 
			
		
		$status = new Zend_Form_Element_Radio('status'); 
    	$status->addMultiOptions(array(
        		'1' => 'Active',
        		'0' => 'Inactive'))
      		->setSeparator('')->setValue('1'); 
		
		
		if($formData)
		{ 
			//prd($formData);
			$id= new Zend_Form_Element_Hidden('id');
			
			$id->setValue($formData['id']);
			$name->setValue($formData['name']);
			$employee_category_id->setValue($formData['employee_category_id']);
			$status->setValue($formData['status']);
			
			$this->addElements(array($id, $name, $employee_category_id, $status));
			
		}
		
		else{
		$this->addElements(array($name, $employee_category_id, $status));
		}
	}		




public function getEmployeeCategory()
{
	global $mySession;
	/*$where = array();
	$where['status'] = 1;
	$CategoryObj = new Category();
	$categoryList = $CategoryObj->getCategoryList('',$where);
	prd($categoryList);
	$catarray = array();*/
	
	$db= new Db();
	$qry= "select id, name from `employee_categories` where status='1' and schoolid='".$mySession->user['schoolid']."'";
	$categoryList=$db->runQuery("$qry"); 
    
	
	$i=1;
	$emp_category_id = array();
		foreach($categoryList as $catlist)
		{ 
			$emp_category_id[$i]['key']=$catlist['id'];
			$emp_category_id[$i]['value']=$catlist['name'];		
			$i++;
		}
	
	//prd($emp_category_id);
	return $emp_category_id;
}

}

?>