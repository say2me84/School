<?PHP
class Form_Empadmission2 extends Zend_Form
{
	
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		if(@$formData['editmode']!=2) {
			$employee_home_address_line1= new Zend_Form_Element_Text('employee_home_address_line1');
			$employee_home_address_line1->setAttrib('onkeypress','return chk_address(event)');
			$employee_home_address_line1->setValue(@$formData['home_address_line1']);
			
			$employee_home_address_line2= new Zend_Form_Element_Text('employee_home_address_line2');
			$employee_home_address_line2->setAttrib('onkeypress','return chk_address(event)');
			$employee_home_address_line2->setValue(@$formData['home_address_line2']);
			
			$employee_home_city= new Zend_Form_Element_Text('employee_home_city');
			$employee_home_city->setValue(@$formData['home_city']);
			
			$employee_home_state= new Zend_Form_Element_Text('employee_home_state');
			$employee_home_state->setValue(@$formData['home_state']);
			
				$country_id[0]['key']=1;
				$country_id[0]['value']='Israel';
			$employee_home_country_id= new Zend_Form_Element_Select('employee_home_country_id');
			$employee_home_country_id->addMultiOptions($country_id);
			$employee_home_country_id->setValue(@$formData['home_country_id']);
			
			$employee_home_pin_code= new Zend_Form_Element_Text('employee_home_pin_code');
			$employee_home_pin_code->setValue(@$formData['home_pin_code']);
			
			$employee_office_address_line1= new Zend_Form_Element_Text('employee_office_address_line1');
			$employee_office_address_line1->setAttrib('onkeypress','return chk_address(event)');
			$employee_office_address_line1->setValue(@$formData['office_address_line1']);
			
			$employee_office_address_line2= new Zend_Form_Element_Text('employee_office_address_line2');
			$employee_office_address_line2->setAttrib('onkeypress','return chk_address(event)');
			$employee_office_address_line2->setValue(@$formData['office_address_line2']);
			
			$employee_office_city= new Zend_Form_Element_Text('employee_office_city');
			$employee_office_city->setValue(@$formData['office_city']);	
			
			$employee_office_state= new Zend_Form_Element_Text('employee_office_state');
			$employee_office_state->setValue(@$formData['office_state']);
			
				$office_country_id[0]['key']=1;
				$office_country_id[0]['value']='Israel';
			$employee_office_country_id= new Zend_Form_Element_Select('employee_office_country_id');
			$employee_office_country_id->addMultiOptions($office_country_id);
			$employee_office_country_id->setValue(@$formData['office_country_id']);
			
			$employee_office_pin_code= new Zend_Form_Element_Text('employee_office_pin_code');
			$employee_office_pin_code->setValue(@$formData['office_pin_code']);
			
			$this->addElements(array($employee_home_address_line1,$employee_home_address_line2,$employee_home_city,$employee_home_state,$employee_home_country_id,$employee_home_pin_code,$employee_office_address_line1,$employee_office_address_line2,$employee_office_city,$employee_office_state,$employee_office_country_id,$employee_office_pin_code));
			
		}
		if(@$formData['editmode']!=1) {
			$employee_office_phone1= new Zend_Form_Element_Text('employee_office_phone1');
			$employee_office_phone1->setAttrib('onkeypress','return chk_numeric(event)');
			$employee_office_phone1->setValue(@$formData['office_phone1']);
			
			$employee_office_phone2= new Zend_Form_Element_Text('employee_office_phone2');
			$employee_office_phone2->setAttrib('onkeypress','return chk_numeric(event)');
			$employee_office_phone2->setValue(@$formData['office_phone2']);
			
			$employee_mobile_phone= new Zend_Form_Element_Text('employee_mobile_phone');
			$employee_mobile_phone->setAttrib('onkeypress','return chk_numeric(event)');
			$employee_mobile_phone->setValue(@$formData['mobile_phone']);
			
			$employee_home_phone= new Zend_Form_Element_Text('employee_home_phone');
			$employee_home_phone->setAttrib('onkeypress','return chk_numeric(event)');
			$employee_home_phone->setValue(@$formData['home_phone']);
			
			$employee_email= new Zend_Form_Element_Text('employee_email');
			$employee_email->setValue(@$formData['email']);
			
			$employee_fax= new Zend_Form_Element_Text('employee_fax');
			$employee_fax->setValue(@$formData['fax']);
				
			$this->addElements(array($employee_office_phone1,$employee_office_phone2,$employee_mobile_phone,$employee_home_phone,$employee_email,$employee_fax));
		}
	}		
}

?>