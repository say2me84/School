<?php
class Form_Admission2 extends Zend_Form
{
	
	public function __construct($formData = NULL,$alreadycheck = '')
	{
		
		global $mySession;
		$db=new Db();
		
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Please enter the first name.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue(@$formData['first_name']);
		$first_name->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($first_name));
				
		$last_name = new Zend_Form_Element_Text('last_name');
		$last_name->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Please enter the last name.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$last_name->setValue(@$formData['last_name']);
		$last_name->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($last_name));
				
		$relation= new Zend_Form_Element_Text('relation');
		$relation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Guardian Relation Field is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setValue(@$formData['relation']);
		$relation->setAttrib('onkeypress','return chk_alpha(event)');
		$this->addElements(array($relation));
				
		$parent_id_card= new Zend_Form_Element_Text('parent_id_card');
		$parent_id_card->setValue(@$formData['parent_id_card']);
		$this->addElements(array($parent_id_card));
		
		
		if(@$formData['userid']) {
			$userid= $formData['userid'];
		} else {
			$userid=0;
		}
		
		$parent_username= new Zend_Form_Element_Text('parent_username');
		$parent_username->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Please enter the username.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue(@$formData['username'])
			->addValidator('Db_NoRecordExists',
							 false,
							 array('table' => 'users',
								   'field' => 'username',
								   'exclude' => array ('field' => 'id', 'value' => @$userid)));
		$this->addElements(array($parent_username));
		
	
		$parent_password= new Zend_Form_Element_Password('parent_password');
		if(is_array($formData) && count($formData) > 0) {
			$hid_userid= new Zend_Form_Element_Hidden('hid_userid');
			$hid_userid->setValue(@$formData['userid']);
			$this->addElements(array($hid_userid));
			$hid_id= new Zend_Form_Element_Hidden('hid_id');
			$hid_id->setValue(@$formData['id']);
			$this->addElements(array($hid_id));		
		} else {
			$parent_password->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Please enter the password.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
		}
		$this->addElements(array($parent_password));
		
		$parent_id_card= new Zend_Form_Element_File('parent_id_card');
		$parent_id_card->setAttrib('onchange','return check_file_extension(this)');
		$this->addElements(array($parent_id_card));
	
		/*$date_of_birth= new Zend_Form_Element_Text('date_of_birth');
		$date_of_birth->setRequired(true)
			->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date of birth is empty.')))
			->setValue(@$formData['guardian_dob']);
		
		
		$this->addElement('text', 'projected-start', array(
			'required'   => false,
			'validators'  => array (
				new Zend_Validate_Date(array('format' => 'MM/dd/yyyy'))
			),
			'label'      => 'Projected Start:',
			'class'      => 'form-date'
		));

		$education = new Zend_Form_Element_Text('education');
		$education->setValue(@$formData['education']);
		
		$occupation = new Zend_Form_Element_Text('occupation');
		$occupation->setValue(@$formData['occupation']);
		
		$income = new Zend_Form_Element_Text('income');
		$income->setValue(@$formData['income']);
		
		$email = new Zend_Form_Element_Text('email');
		$email->setValue(@$formData['email']);
		
		$office_address_line1 = new Zend_Form_Element_Text('office_address_line1');
		$office_address_line1->setValue(@$formData['office_address_line1']);
		
		$office_address_line2 = new Zend_Form_Element_Text('office_address_line2');
		$office_address_line2->setValue(@$formData['office_address_line2']);
		
		$city = new Zend_Form_Element_Text('city');
		$city->setValue(@$formData['city']);
		
		$state = new Zend_Form_Element_Text('state');
		$state->setValue(@$formData['state']);
		
		$country_id[0]['key']='';
		$country_id[0]['value']='Israel';
		$country= new Zend_Form_Element_Select('country_id');
		$country->addMultiOptions($country_id);
		$country->setValue(@$formData['country_id']);
		
		$office_phone1 = new Zend_Form_Element_Text('office_phone1');
		$office_phone1->setValue(@$formData['office_phone1']);
		
		$office_phone2 = new Zend_Form_Element_Text('office_phone2');
		$office_phone2->setValue(@$formData['office_phone2']);
		
		$mobile_phone = new Zend_Form_Element_Text('mobile_phone');
		$mobile_phone->setValue(@$formData['mobile_phone']);		*/
		
	}		
}

?>