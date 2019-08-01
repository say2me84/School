<?PHP
class Form_Studentleave extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
			
		$attendance_reason= new Zend_Form_Element_Text('attendance_reason');
		$attendance_reason->setRequired(true)
					->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Enter The Subject Name.')));
		$attendance_reason->setValue(@$formData['reason']);
		$this->addElements(array($attendance_reason));
			
			/*$leave[0]['key']='Forenoon';
			$leave[0]['value']='Forenoon';
			$leave[1]['key']='Afternoon';
			$leave[1]['value']='Afternoon';
			$leave[0]='Forenoon';
			$leave[0]='Forenoon';*/
		
			
		$forenoon= new Zend_Form_Element_MultiCheckbox('forenoon');
		$forenoon->addMultiOption('1','Forenoon');
		$forenoon->setValue(@$formData['forenoon']);
		
		$afternoon= new Zend_Form_Element_MultiCheckbox('afternoon');
		$afternoon->addMultiOption('1','Afternoon');
		$afternoon->setValue(@$formData['afternoon']);

		/*$student_leave->setAttrib('style','color:#444; font-size:14px; font-weight:600;');*/
		
		
		$this->addElements(array($attendance_reason,$forenoon,$afternoon));
	}		
}

?>