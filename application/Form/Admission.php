<?php
class Form_Admission extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		/*if(@$formData['editmode']!=1) 
		{
			$getautonumber = "select max(admission_no) as mxid from students";
			$resautonumber = $db->runQuery($getautonumber);
			$maxid = @$resautonumber[0]['mxid']+1;
		} else {
			$maxid = $formData['admission_no'];
		}	*/	
		$clause    = "schoolid ='".$mySession->user['schoolid']."'";
		
		if(is_array($formData) && $formData['id']!=0){
			$clause    = "id!='".$formData['id']."' and schoolid='".$mySession->user['schoolid']."'";
		}
		//echo $clause; exit;
		$student_admission_no= new Zend_Form_Element_Text('student_admission_no'); 
		$student_admission_no->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Admission no. is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['admission_no'])
				->addValidator('Db_NoRecordExists',
							 false,
							 array('table' => 'students',
								   'field' => 'admission_no',
								   'exclude' => $clause));
		$this->addElements(array($student_admission_no));
		
		$passport_or_id_opt[0]['key']=1;
		$passport_or_id_opt[0]['value']='Passport';	
		$passport_or_id_opt[1]['key']=2;
		$passport_or_id_opt[1]['value']='ID Card';	
		
		$passport_or_id= new Zend_Form_Element_Select('passport_or_id');
		$passport_or_id->addMultiOptions($passport_or_id_opt);
		$passport_or_id->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Admission date is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['passport_or_id']);		
		$passport_or_id->setValue(@$formData['passport_or_id']);
		$this->addElements(array($passport_or_id));
		
		$student_passport_no= new Zend_Form_Element_Text('student_passport_no'); 
		$student_passport_no->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student Enter ID Code.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['student_passport_no']);
		$this->addElements(array($student_passport_no));
		
		if(@$formData['doa']) {
			$admissiondatevalue = $formData['doa'];
		} else {
			$admissiondatevalue = date("F d, Y");
		}
		$admission_date= new Zend_Form_Element_Text('admission_date');
		$admission_date->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Admission date is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue($admissiondatevalue);
		$this->addElements(array($admission_date));
		
		$title_opt[0]['key']='Mr';
		$title_opt[0]['value']='Mr';	
		$title_opt[1]['key']='Miss';
		$title_opt[1]['value']='Miss';	
		$title= new Zend_Form_Element_Select('title');
		$title->addMultiOptions($title_opt);
		$title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$title->setValue(@$formData['title']);
		$this->addElements(array($title));
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
				   ->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'First Name is empty.')))
				   ->addDecorator('Errors', array('class'=>'errormsg'));
		$first_name->setValue(@$formData['first_name']);
		$first_name->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($first_name));
		
		$middle_name= new Zend_Form_Element_Text('middle_name');
		$middle_name->setValue(@$formData['middle_name']);
		$middle_name->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($middle_name));
		
		$last_name= new Zend_Form_Element_Text('last_name');
		$last_name->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Last Name is empty.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$last_name->setValue(@$formData['last_name']);
		$last_name->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($last_name));
		
		$getcoursebatchlist = $this->getcoursebatch();
		
		if(is_array($getcoursebatchlist) && count($getcoursebatchlist) > 0)
		{
		$i=0;
			foreach($getcoursebatchlist as $list)
			{
				$batch_id[$i]['key']=$list['id'];
				$batch_id[$i]['value']=$list['grade_name'].'-'.$list['name'];		
				$i++;
			}
		}
		$student_batch_id= new Zend_Form_Element_Select('student_batch_id');
		if(is_array($batch_id)) { $student_batch_id->addMultiOptions($batch_id); }
		$student_batch_id->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student class is empty.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$student_batch_id->setValue(@$formData['batch_id']);
		$this->addElements(array($student_batch_id));
		
		if(@$formData['dob']) {
			$dobvalue = $formData['dob'];
		} else {
			$dobvalue = date("F d, Y");
		}
		$date_of_birth= new Zend_Form_Element_Text('date_of_birth');
		$date_of_birth
			->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date of birth is empty.')))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue($dobvalue);
		$this->addElements(array($date_of_birth));
		
			$country= $this->nationality();
			if(is_array($country) && count($country) > 0)
			{
				
			$i=0;
				foreach($country as $clist)
				{
					$nationality_id[$i]['key']=$clist['id'];
					$nationality_id[$i]['value']=$clist['name'];		
					$i++;
				}
			}else{
					$nationality_id[0]['key']='';
					$nationality_id[0]['value']='Select';
			}
		$student_nationality= new Zend_Form_Element_Select('student_nationality');
		$student_nationality->addMultiOptions($nationality_id);
		$student_nationality->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student nationality is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));	
		$student_nationality->setValue(@$formData['nationality_id']);
		$this->addElements(array($student_nationality));
		
			/*$gender[0]='Male';
			$gender[1]='Female';			
		$student_gender= new Zend_Form_Element_Radio('student_gender');
		$student_gender->addMultiOptions($gender);
		$student_gender->setValue(@$formData['gender']);
		$student_gender->setDecorators(array(array('ViewHelper',array(array('data'=>'HtmlTag'),array('tag'=>'label','class'=>'label_for_status')))));*/
			
			$blood_group[0]['key']=1;
			$blood_group[0]['value']='Select';
			$blood_group[1]['key']='Islam';
			$blood_group[1]['value']='Islam';
			$blood_group[2]['key']='Hindu';
			$blood_group[2]['value']='Hindu';				
		$student_religion= new Zend_Form_Element_Select('student_religion');
		$student_religion->addMultiOptions($blood_group);
		$student_religion->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student religion is empty.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$student_religion->setValue(@$formData['religion']);
		$this->addElements(array($student_religion));
		
		$student_illness= new Zend_Form_Element_Text('student_illness');
		$student_illness->setValue(@$formData['student_illness']);
		$this->addElements(array($student_illness));
				
		$student_address_line1= new Zend_Form_Element_Text('student_address_line1');
		$student_address_line1->setValue(@$formData['address_line1']);
		$student_address_line1->setAttrib('onkeypress','return chk_address(event)');
		$this->addElements(array($student_address_line1));
		
		$student_phone1= new Zend_Form_Element_Text('student_phone1');
		$student_phone1->setValue(@$formData['phone1']);
		$student_phone1->setAttrib('onkeypress','return chk_numeric(event)');
		$this->addElements(array($student_phone1));
		
		$student_photo= new Zend_Form_Element_File('student_photo');
		$student_photo->setAttrib('onchange','return check_file_extension(this)');
		$this->addElements(array($student_photo));
		
		$birth_certificate= new Zend_Form_Element_File('birth_certificate');
		$birth_certificate->setAttrib('onchange','return check_file_extension(this)');
		$this->addElements(array($birth_certificate));
		
	}
	
	function getcoursebatch()
	{
		global $mySession;
		$db=new Db();
		
		$qry2="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'";		
		return $batcheslist=$db->runQuery("$qry2");
	}
	
	function category()
	{
	$db= new Db();
	$qry= "select id, name from `student_categories` where is_deleted=0 ";
	$classtimingarray=$db->runQuery("$qry");
	return $classtimingarray;
	}
	
	function nationality()
	{
	$db= new Db();
	$qry= "select * from `countries` ";
	$nationality=$db->runQuery("$qry");
	return $nationality;
	}
}

?>