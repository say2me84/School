<?php
class Form_Searchstudent extends Zend_Form
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
		$student_admission_no= new Zend_Form_Element_Text('student_admission_no'); 
		$this->addElements(array($student_admission_no));
		
		$student_passport_no= new Zend_Form_Element_Text('student_passport_no'); 
		$this->addElements(array($student_passport_no));
		
		
		$admission_date= new Zend_Form_Element_Text('admission_date');
		$this->addElements(array($admission_date));
		
		$admission_date_to= new Zend_Form_Element_Text('admission_date_to');
		$this->addElements(array($admission_date_to));
		
		$title_opt[0]['key']='';
		$title_opt[0]['value']='Select title';
		$title_opt[1]['key']='Mr';
		$title_opt[1]['value']='Mr';	
		$title_opt[2]['key']='1';
		$title_opt[2]['value']='Miss';	
		$title= new Zend_Form_Element_Select('title');
		$title->addMultiOptions($title_opt);
		$this->addElements(array($title));
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$this->addElements(array($first_name));
		
		$getcoursebatchlist = $this->getcoursebatch();
		if(is_array($getcoursebatchlist) && count($getcoursebatchlist) > 0)
		{
		$i=0;
			foreach($getcoursebatchlist as $list)
			{
				$batch_id[$i]['key']=$list['id'];
				$batch_id[$i]['value']=$list['code'].'-'.$list['name'];		
				$i++;
			}
		}
		$student_batch_id= new Zend_Form_Element_Select('student_batch_id');
		$student_batch_id->addMultiOptions($batch_id);
		$this->addElements(array($student_batch_id));
		
		if(@$formData['dob']) {
			$dobvalue = $formData['dob'];
		} else {
			$dobvalue = date("F d, Y");
		}
		$date_of_birth= new Zend_Form_Element_Text('date_of_birth');
		$this->addElements(array($date_of_birth));
		
		$date_of_birth_to= new Zend_Form_Element_Text('date_of_birth_to');
		$this->addElements(array($date_of_birth_to));
		
			$nationality_id[0]['key']=1;
			$nationality_id[0]['value']='Israel';	
		$student_nationality= new Zend_Form_Element_Select('student_nationality');
		$student_nationality->addMultiOptions($nationality_id);
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
		$this->addElements(array($student_religion));
				
		$student_address_line1= new Zend_Form_Element_Text('student_address_line1');
		$student_address_line1->setValue(@$formData['address_line1']);
		$student_address_line1->setAttrib('onkeypress','return chk_address(event)');
		$this->addElements(array($student_address_line1));
		
	}
	
	function getcoursebatch()
	{
		global $mySession;
		$db=new Db();
		
		$qry2="select b.*, c.code from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'";		
		return $batcheslist=$db->runQuery("$qry2");
	}
	
	function category()
	{
	$db= new Db();
	$qry= "select id, name from `student_categories` where is_deleted=0 ";
	$classtimingarray=$db->runQuery("$qry");
	return $classtimingarray;
	}
}

?>