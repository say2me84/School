<?PHP
class Form_CreateClass extends Zend_Form
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
		
		/*$section_name= new Zend_Form_Element_Text('section_name');
		$section_name->setValue(@$section_name_value);
		$this->addElements(array($section_name));*/
		
		$grade_code= new Zend_Form_Element_Text('grade_code');
		$grade_code->setValue(@$code_value);
		$grade_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter grade code.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->addValidator('Db_NoRecordExists',
                             false,
                             array('table' => 'grades',
                                   'field' => 'code',
                                   'exclude' => array ('field' => 'id', 'value' => @$iid)));
		$this->addElements(array($grade_code));
		
		$batches_attributes= new Zend_Form_Element_Text('batches_attributes');
		$batches_attributes->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter class name.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($batches_attributes));
		
		$getemployeelist = $this->getemployeelist();
		
		$employeelist[0]['key']=0;
		$employeelist[0]['value']='Select Teacher';
		
		if(is_array($getemployeelist) && count($getemployeelist) > 0)
		{
		$i=1;
			foreach($getemployeelist as $list)
			{
				$employeelist[$i]['key']=$list['id'];
				$employeelist[$i]['value']=$list['code'].'-'.$list['name'];		
				$i++;
			}
		}
		$batches_employee_id= new Zend_Form_Element_Select('batches_employee_id');
		$batches_employee_id->addMultiOptions($employeelist);
		$batches_employee_id->setValue(@$formData['employee_id']);
		$this->addElements(array($batches_employee_id));
		
		$batches_attributes_startdate= new Zend_Form_Element_Text('batches_attributes_startdate');
		$batches_attributes_startdate->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter class start date.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($batches_attributes_startdate));
		
		$batches_attributes_sec_sem_start= new Zend_Form_Element_Text('batches_attributes_sec_sem_start');
		$batches_attributes_sec_sem_start->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter Second Sem start date.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($batches_attributes_sec_sem_start));
		
		$batches_attributes_enddate= new Zend_Form_Element_Text('batches_attributes_enddate');
		$batches_attributes_enddate->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please Enter class end date.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($batches_attributes_enddate));
		
		
	}
	function getemployeelist()
	{
		global $mySession;
		$db=new Db();
		
		$qry2="select e.id, concat(e.first_name,' ',e.last_name) as name, d.code from `employees` as e inner join `employee_departments` as d on (d.id=e.employee_department_id) where e.schoolid='".$mySession->user['schoolid']."' and e.status='1'";		
		return $emplist=$db->runQuery("$qry2");
	}
}

?>