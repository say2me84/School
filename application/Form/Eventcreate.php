<?PHP
class Form_EventCreate extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($formData['eventdate']) {
			$eventdatearray = explode('-',$formData['eventdate']);
			
			$startdate = date('F d, Y h:i A',mktime(0,0,0, $eventdatearray[1],$eventdatearray[2],$eventdatearray[0]));
			$enddate = date('F d, Y h:i A',mktime(0,0,0, $eventdatearray[1],$eventdatearray[2],$eventdatearray[0]));
		} elseif($formData['start_date']) { 
			$start_date = explode(' ',$formData['start_date']);
			$end_date = explode(' ',$formData['end_date']);
			
			$sdate = explode("-",$start_date[0]);
			$stime = explode(":",$start_date[1]);
			
			$edate = explode("-",$end_date[0]);
			$etime = explode(":",$end_date[1]);
			
			$startdate = date('F d, Y h:i A',mktime($stime[0],$stime[1],$stime[2], $sdate[1],$sdate[2],$sdate[0]));
			$enddate = date('F d, Y h:i A',mktime($etime[0],$etime[1],$etime[2], $edate[1],$edate[2],$edate[0]));
		}
		else {
			$startdate = date('F d, Y h:i A');
			$enddate = date('F d, Y h:i A');
		}
		
		$events_start_date= new Zend_Form_Element_Text('events_start_date');
		$events_start_date->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Event Start date is empty')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['admission_no']);
		$events_start_date->setValue($startdate);
		
		$events_end_date= new Zend_Form_Element_Text('events_end_date');
		$events_end_date->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Event End date is empty')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['admission_no']);
		$events_end_date->setValue($enddate);
		
		$events_title= new Zend_Form_Element_Text('events_title');
		$events_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Event title is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['admission_no']);
		$events_title->setValue(@$formData['title']);
		
		$events_description= new Zend_Form_Element_Textarea('events_description');
		$events_description->setAttrib('class','events_description');
		$events_description->setValue(@$formData['description']);
		
		$this->addElements(array($events_start_date,$events_end_date,$events_title,$events_description));
	}		
}

?>