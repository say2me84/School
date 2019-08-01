<?PHP
class Form_Classtiming extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		global $mySession;
		$db=new Db();		
		$name= new Zend_Form_Element_Text('name');
		$name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Please enter name.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		$name->setValue(@$formData['name']);
		$this->addElements(array($name));
	
		
			
			for($x=0; $x < 24; $x++)
			{
				$listh[$x]['key']=str_pad($x,2,0,STR_PAD_LEFT);
				$listh[$x]['value']=str_pad($x,2,0,STR_PAD_LEFT);
				
			}
			
			for($x=0; $x < 56; $x++)
			{
				$lists[$x]['key']=str_pad($x,2,0,STR_PAD_LEFT);
				$lists[$x]['value']=str_pad($x,2,0,STR_PAD_LEFT);
				$x=$x+4;
			}
			
			
			/*$user_school[0]['key']='';
			$user_school[0]['value']='Israel';*/	
		if(@$formData['start_time']!='') {
			$stime = explode(":",$formData['start_time']);
		}
		if(@$formData['end_time']!='') {
			$etime = explode(":",$formData['end_time']);
		}
						
		$start_time_1= new Zend_Form_Element_Select('start_time_1');
		$start_time_1->setValue(@$stime[0]);
		$start_time_1->addMultiOptions($listh);
		
		$this->addElements(array($start_time_1));
		
		$start_time_2= new Zend_Form_Element_Select('start_time_2');
		$start_time_2->setValue(@$stime[1]);
		$start_time_2->addMultiOptions($lists);
		$this->addElements(array($start_time_2));
		
		$end_time_1= new Zend_Form_Element_Select('end_time_1');
		$end_time_1->setValue(@$etime[0]);
		$end_time_1->addMultiOptions($listh);
		$this->addElements(array($end_time_1));
		
		$end_time_2= new Zend_Form_Element_Select('end_time_2');
		$end_time_2->setValue(@$etime[1]);
		$end_time_2->addMultiOptions($lists);
		$this->addElements(array($end_time_2));				
		
	}
	
	
}

?>