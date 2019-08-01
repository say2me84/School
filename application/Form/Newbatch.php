<?PHP
class Form_NewBatch extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
				
		$batch_name= new Zend_Form_Element_Text('batch_name');
		$batch_name
			->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$batch_name->setValue(@$formData['name']);
		
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
		
		if(@$formData['startdate']) {
			$startdate = $formData['startdate'];
		} else {
			$startdate = date("F d, Y");
		}
		$batch_startdate= new Zend_Form_Element_Text('batch_startdate');
		$batch_startdate
			->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Start date field is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$batch_startdate->setValue(@$startdate);
		
		if(@$formData['sec_sem_date']) {
			$sec_sem_date = $formData['sec_sem_date'];
		} else {
			$sec_sem_date = date("F d, Y");
		}
		$batch_second_sem_start= new Zend_Form_Element_Text('batch_second_sem_start');
		$batch_second_sem_start
			->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Second Sem start date field is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$batch_second_sem_start->setValue(@$sec_sem_date);
		
		if(@$formData['enddate']) {
			$enddate = $formData['enddate'];
		} else {
			$enddate = date("F d, Y",mktime(0,0,0,date('m'),date('d'),date('Y')+1));
		}
		$batch_enddate= new Zend_Form_Element_Text('batch_enddate');
		$batch_enddate
			->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'End Date field is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$batch_enddate->setValue(@$enddate);
		
		$this->addElements(array($batch_name,$batch_startdate,$batch_second_sem_start,$batch_enddate));
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