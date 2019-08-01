<?PHP
class Form_EmpAdmission extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();		
		
		if(@$formData['editmode']!=1 && @$formData['editmode']!=2) {
		
			$employee_number= new Zend_Form_Element_Text('employee_number');
			$employee_number->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please enter the employee no.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			$employee_number->setValue("");
			$this->addElements(array($employee_number));
		}
		if(@$formData['editmode']!=2)
		{
			if(@$formData['userid']) {
				$userid= $formData['userid'];
			} else {
				$userid=0;
			}
			$employee_username= new Zend_Form_Element_Text('employee_username');
			$employee_username->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please enter the username.'))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->addValidator('Db_NoRecordExists',
                             false,
                             array('table' => 'users',
                                   'field' => 'username',
                                   'exclude' => array ('field' => 'id', 'value' => @$userid)));
			$employee_username->setValue(@$formData['username']);
			$this->addElements(array($employee_username));
			
			
			
			$employee_password= new Zend_Form_Element_Password('employee_password');
			if(is_array($formData) && count($formData) > 0) {		
				$hid_userid= new Zend_Form_Element_Hidden('hid_userid');
				$hid_userid->setValue(@$formData['userid']);
				$this->addElements(array($hid_userid));
			} else {
				$employee_password->setRequired(true)
					->addValidator('NotEmpty',true,array('messages' =>'Please enter the password.'))
					->addDecorator('Errors', array('class'=>'errormsg'));
			}
			$this->addElements(array($employee_password));
			
			$employee_joining_date= new Zend_Form_Element_Text('employee_joining_date');
			if(@$formData['jdate']) { $jdate = $formData['jdate']; } else { $jdate=date('F d, Y'); }
			$employee_joining_date->setValue($jdate);
			$employee_joining_date->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please enter the joining date.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			$this->addElements(array($employee_joining_date));
			
			$employee_first_name= new Zend_Form_Element_Text('employee_first_name');
			$employee_first_name->setValue(@$formData['first_name']);
			$employee_first_name->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please enter the first name.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			$employee_first_name->setAttrib('onkeypress','return chk_alpha(event)');
			$this->addElements(array($employee_first_name));
						
			/*$employee_middle_name= new Zend_Form_Element_Text('employee_middle_name');		
			$employee_middle_name->setValue(@$formData['middle_name']);
			$this->addElements(array($employee_middle_name));*/
			
			$employee_last_name= new Zend_Form_Element_Text('employee_last_name');
			$employee_last_name->setValue(@$formData['last_name']);
			$employee_last_name->setAttrib('onkeypress','return chk_alpha(event)');
			$this->addElements(array($employee_last_name));
			
				$empgender[0]='Male';
				$empgender[1]='Female';			
			$employee_gender= new Zend_Form_Element_Radio('employee_gender');
			$employee_gender->addMultiOptions($empgender);
			$employee_gender->setSeparator('');
			$employee_gender->removeDecorator('label')->removeDecorator('HtmlTag');
			$employee_gender->setValue(@$formData['gender']);
			$employee_gender->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please select the gender.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			$this->addElements(array($employee_gender));
			
			
			$dept= $this->department();
			if(is_array($dept) && count($dept) > 0)
			{$i=0;
				foreach($dept as $list)
				{
					$department_id[$i]['key']=$list['id'];
					$department_id[$i]['value']=$list['name'];		
					$i++;
				}
			} else {
				$department_id[0]['key']=1;
				$department_id[0]['value']='Select';
			}
			
				/*$department_id[0]['key']=1;
				$department_id[0]['value']='Select';
				$department_id[1]['key']=2;
				$department_id[1]['value']='Fedena Admin';*/
			$employee_department= new Zend_Form_Element_Select('employee_department');
			$employee_department->addMultiOptions($department_id);
			$employee_department->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please select the Department.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			
			
			$employee_department->setValue(@$formData['employee_department_id']);
			$this->addElements(array($employee_department));
			
			$cat= $this->category();
			if(is_array($cat) && count($cat) > 0)
			{ $i=1;
				foreach($cat as $catlist)
				{
					$emp_category_id[$i]['key']=$catlist['id'];
					$emp_category_id[$i]['value']=$catlist['name'];		
					$i++;
				}
			} else {
				$emp_category_id[0]['key']=1;
				$emp_category_id[0]['value']='Select';
			}		
				/*$emp_category_id[0]['key']=1;
				$emp_category_id[0]['value']='Select';
				$emp_category_id[1]['key']=2;
				$emp_category_id[1]['value']='Fedena Admin';*/
			$employee_category= new Zend_Form_Element_Select('employee_category');
			$employee_category->addMultiOptions($emp_category_id);
			$employee_category->setValue(@$formData['employee_category_id']);
			$this->addElements(array($employee_category));
			
			$pos= $this->position();
			if(is_array($pos) && count($pos) > 0)
			{ $i=1;
				foreach($pos as $poslist)
				{
					$emp_position[$i]['key']=$poslist['id'];
					$emp_position[$i]['value']=$poslist['name'];		
					$i++;
				}
			} else {
				$emp_position[0]['key']=1;
				$emp_position[0]['value']='Select';
			}
				
				/*$emp_position[0]['key']=1;
				$emp_position[0]['value']='Select';
				$emp_position[1]['key']=2;
				$emp_position[1]['value']='Fedena Admin';*/
			$employee_position= new Zend_Form_Element_Select('employee_position');
			$employee_position->addMultiOptions($emp_position);
			$employee_position->setValue(@$formData['employee_position_id']);
			$this->addElements(array($employee_position));
			
			/*$employee_job_title= new Zend_Form_Element_Text('employee_job_title');
			$employee_job_title->setValue(@$formData['job_title']);
			$this->addElements(array($employee_job_title));*/
			
			$employee_qualification= new Zend_Form_Element_Text('employee_qualification');
			$employee_qualification->setValue(@$formData['qualification']);
			$this->addElements(array($employee_qualification));
			
			$employee_experience= new Zend_Form_Element_Textarea('employee_experience');
			$employee_experience->setAttrib('ROWS', '24');
			$employee_experience->setAttrib('COLS', '80');
			$employee_experience->setAttrib('STYLE', 'width:266px; height:90px;');
			//$employee_experience->setAttrib('HEIGHT', '85');
			$employee_experience->setValue(@$formData['experience_detail']);
			$this->addElements(array($employee_experience));
			
				$experience_year[0]['key']="";
				$experience_year[0]['value']='Year';
				for($i=1;$i<=20;$i++)
				{
					$experience_year[$i]['key']=$i;
					$experience_year[$i]['value']=$i;
				}		
			$employee_experience_year= new Zend_Form_Element_Select('employee_experience_year');
			$employee_experience_year->addMultiOptions($experience_year);
			$employee_experience_year->setValue(@$formData['experience_year']);
			$this->addElements(array($employee_experience_year));
			
				$experience_month[0]['key']="";
				$experience_month[0]['value']='Month';
				for($j=1;$j<=11;$j++)
				{
					$experience_month[$j]['key']=$j;
					$experience_month[$j]['value']=$j;
				}
			$employee_experience_month= new Zend_Form_Element_Select('employee_experience_month');
			$employee_experience_month->addMultiOptions($experience_month);
			$employee_experience_month->setValue(@$formData['experience_month']);
			$this->addElements(array($employee_experience_month));
			
				$empstatus[1]='Active';
				$empstatus[0]='Inactive';	
				if($formData['status']) {
					$status = $formData['status'];
				} else {
					$status = 1;
				}		
			$employee_status= new Zend_Form_Element_Radio('employee_status');
			$employee_status->addMultiOptions($empstatus);
			$employee_status->setSeparator('');
			$employee_status->removeDecorator('label')->removeDecorator('HtmlTag');
			$employee_status->setValue($status);
			$this->addElements(array($employee_status));
			
			
		}
		if(@$formData['editmode']!=1) 
		{
			$emp_date_of_birth= new Zend_Form_Element_Text('emp_date_of_birth');
			if(@$formData['dobdate']) { $dobdate = $formData['dobdate']; } else { $dobdate=date('F d, Y'); }
			$emp_date_of_birth->setValue($dobdate);
			$emp_date_of_birth->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please Enter the Date of Birth.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
			$this->addElements(array($emp_date_of_birth));
			
			$marital_status[0]['key']='Single';
			$marital_status[0]['value']='Single';
			$marital_status[1]['key']='Married';
			$marital_status[1]['value']='Married';
			$marital_status[2]['key']='Divorced';
			$marital_status[2]['value']='Divorced';
			
						
			$employee_marital_status= new Zend_Form_Element_Select('employee_marital_status');
			$employee_marital_status->addMultiOptions($marital_status);
			$employee_marital_status->setValue(@$formData['marital_status']);
			$this->addElements(array($employee_marital_status));
			
			$employee_children_count= new Zend_Form_Element_Text('employee_children_count');
			$employee_children_count->setValue(@$formData['children_count']);
			$employee_children_count->setAttrib('onkeypress','return chk_numeric(event)');
			$this->addElements(array($employee_children_count));
			
			$employee_father_name= new Zend_Form_Element_Text('employee_father_name');
			$employee_father_name->setValue(@$formData['father_name']);
			$employee_father_name->setAttrib('onkeypress','return chk_alpha(event)');
			$this->addElements(array($employee_father_name));
			
			$employee_mother_name= new Zend_Form_Element_Text('employee_mother_name');
			$employee_mother_name->setValue(@$formData['mother_name']);
			$employee_mother_name->setAttrib('onkeypress','return chk_alpha(event)');
			$this->addElements(array($employee_mother_name));
			
			$employee_husband_name= new Zend_Form_Element_Text('employee_husband_name');
			$employee_husband_name->setValue(@$formData['husband_name']);
			$employee_husband_name->setAttrib('onkeypress','return chk_alpha(event)');
			$this->addElements(array($employee_husband_name));
			
				$blood_group[0]['key']=1;
				$blood_group[0]['value']='Unknown';
				$blood_group[1]['key']=2;
				$blood_group[1]['value']='A+';
				$blood_group[2]['key']=3;
				$blood_group[2]['value']='A-';
				$blood_group[3]['key']=4;
				$blood_group[3]['value']='B+';
				$blood_group[4]['key']=5;
				$blood_group[4]['value']='B-';
				$blood_group[5]['key']=6;
				$blood_group[5]['value']='O+';
				$blood_group[6]['key']=7;
				$blood_group[6]['value']='O-';
				$blood_group[7]['key']=8;
				$blood_group[7]['value']='AB+';
				$blood_group[8]['key']=9;
				$blood_group[8]['value']='AB-';
				
			$employee_blood_group= new Zend_Form_Element_Select('employee_blood_group');
			$employee_blood_group->addMultiOptions($blood_group);
			$employee_blood_group->setValue(@$formData['blood_group']);
			$this->addElements(array($employee_blood_group));
			
				$nationality_id[0]['key']=1;
				$nationality_id[0]['value']='Israel';
			$employee_nationality_id= new Zend_Form_Element_Select('employee_nationality_id');
			$employee_nationality_id->addMultiOptions($nationality_id);
			$employee_nationality_id->setValue(@$formData['nationality_id']);
			$this->addElements(array($employee_nationality_id));
			
			
		}
		
	}	
	function department()
	{
	global $mySession;
	$db= new Db();
	$qry= "select id, name from `employee_departments` where schoolid='".$mySession->user['schoolid']."' and status='1'";
	$classtimingarray=$db->runQuery("$qry");
	return $classtimingarray;
	}
	
	function category()
	{
	global $mySession;
	$db= new Db();
	$qry= "select id, name from `employee_categories` where schoolid='".$mySession->user['schoolid']."' and status='1'";
	$catarray=$db->runQuery("$qry");
	return $catarray;
	}
	
	function position()
	{
	global $mySession;
	$db= new Db();
	$qry= "select id, name from `employee_positions` where schoolid='".$mySession->user['schoolid']."' and status='1'";
	$posarray=$db->runQuery("$qry");
	return $posarray;
	}
	
	
	
}

?>