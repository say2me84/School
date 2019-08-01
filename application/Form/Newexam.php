<?PHP
class Form_Newexam extends Zend_Form
{
	
	public function __construct($formData = NULL,$batchid=0)
	{
		
		global $mySession;
		$db=new Db();
		
		$subList = $this->getsubjectlist($batchid);
		$subject_id = array();
		$i=0;
		foreach($subList as $slist)
		{ 
			$subject_id[$i]['key']=$slist['id'];
			$subject_id[$i]['value']=$slist['name'];		
			$i++;
		}
				
		$exam_subject= new Zend_Form_Element_Select('exam_subject');
		$exam_subject->addMultiOptions($subject_id);
		$exam_subject->setValue($formData['subject_id']);
		$this->addElements(array($exam_subject));
			
		$exam_start_time= new Zend_Form_Element_Text('exam_start_time');
		$exam_start_time->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Start Time.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$exam_start_time->setValue($formData['dtstart_time']);
		$this->addElements(array($exam_start_time));
		
		$exam_end_time= new Zend_Form_Element_Text('exam_end_time');
		$exam_end_time->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The End Time.')))
					->addDecorator('Errors', array('class'=>'errormsg'));
		$exam_end_time->setValue($formData['dtend_time']);
		$this->addElements(array($exam_end_time));
		
		if(@$formData['exam_type']!='Grades') {
			$maximum_marks= new Zend_Form_Element_Text('maximum_marks');
			$maximum_marks->setRequired(true)
						->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Maximum Marks.')))
						->addDecorator('Errors', array('class'=>'errormsg'));
			$maximum_marks->setValue($formData['maximum_marks']);
			$this->addElements(array($maximum_marks));
			
			$minimum_marks= new Zend_Form_Element_Text('minimum_marks');
			$minimum_marks->setRequired(true)
						->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Minimum Marks.')))
						->addDecorator('Errors', array('class'=>'errormsg'));
			$minimum_marks->setValue($formData['minimum_marks']);
			$this->addElements(array($minimum_marks));
		}
		
	}
	function getsubjectlist($bid)
	{
		global $mySession;
		$db=new Db();
		
		$qry="select id,name from `subjects` where grade_id in (select grade_id from batches where id='".$bid."')";
		$slist=$db->runQuery("$qry");
		return $slist;
		
		
	}	
}

?>