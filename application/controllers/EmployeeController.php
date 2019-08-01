<?php
__autoloadDB('Db');
class EmployeeController extends AppController
{

	public function hrAction()
	{	
		global $mySession;		
	}
	
	public function settingsAction()
	{	
		global $mySession;		
	}
	
	public function employeemanagementAction()
	{	
		global $mySession;		
	}
	
	public function addcategoryAction()
	{	
		global $mySession;
		$db = new Db();
		
		$formObj = new Form_Addcategory();
		
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost(); 
			if($formObj->isValid($postData))
			{ 
				$filteredValues = $formObj->getValues(); 
				$data = array(); 
				$data['name'] = $filteredValues['student_category_name']; 
				$data['prefix'] = $filteredValues['prefix']; 
				$data['status'] = $filteredValues['status']; 
				$data['schoolid'] = $mySession->user['schoolid'];
				
				/*$categoryObj = new Category(); 
				$insertResult = $categoryObj->insertCategory($data);	*/
				$modelobj = new Mainmodel();
			
				$insertResult = $modelobj->insertThis('employee_categories',$data);
				
				$mySession->sucMsg = LNG_EMPLOYEE_CATEGORY_ADDED;
				$this->_redirect('employee/addcategory');
			}
		}
		$qry = "select * from employee_categories where schoolid='".$mySession->user['schoolid']."' and status='1'";
		$CategoryList = $db->runQuery("$qry");
		$this->view->categoryList = $CategoryList;
		
		$this->view->form = $formObj;
		
		$qry2="select * from `employee_categories` where status='0' and schoolid='".$mySession->user['schoolid']."'";
		$CategoryList = $db->runQuery("$qry2");
		$this->view->categoryList2 = $CategoryList;
			
	}
	
	public function editcategoryAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->catId = $id;
		
		
	/*	$where  = array();
		$where['id'] = $id;
		$categoryObj = new Category(); 
		$CategoryDetail = $categoryObj->getCategoryDetail($where);	*/
		
		
		$formObj = new Form_Addcategory($CategoryDetail); 
		if($this->getRequest()->isPost())
		{ 
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				$data = array();
				$data['name'] = $filteredValues['student_category_name'];
				$data['prefix'] = $filteredValues['prefix'];
				$data['status'] = $filteredValues['status'];
				$condition[] = "id = ".$filteredValues['id'];
				
				$db= new Db();
				$db->update('employee_categories',$data,$condition);
				
				/*$categoryObj = new Category();
				$updateResult = $categoryObj->updateCategory($data,$condition);*/
				$mySession->sucMsg = LNG_EMPLOYEE_CATEGORY_UPDATED;
				$this->_redirect('employee/addcategory');
			}
		}
		
	
		
		$this->view->form = $formObj;		
	}
	
	public function deletecategoryAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->catId = $id;
		
		
		$condition= "id = '".$id."'";
		$db= new Db();
		$db->delete('employee_categories',$condition);
		
		$mySession->sucMsg = LNG_EMPLOYEE_CATEGORY_DELETED;
		$this->_redirect('employee/addcategory');
				
	}
	
	public function adddepartmentAction()
	{	
			
		global $mySession;
		
		$formObj = new Form_Adddepartment(); 
		$this->view->form = $formObj;
		
		if($this->getRequest()->isPost())
		{	
			
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				//prd($filteredValues);
				
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['code'] = $filteredValues['code'];
				$data['status'] = $filteredValues['status'];
				$data['schoolid'] = $mySession->user['schoolid'];
				
				$Department = new Department();
				$insertResult = $Department->insertDepartment($data);
				
				$mySession->sucMsg = LNG_EMPLOYEE_DEPARTMENT_ADDED;
				$this->_redirect('employee/adddepartment');
			}
		}
		
		/*$where  = array();
		$where['status'] = 1;
		$where['schoolid'] = $mySession->user['schoolid'];
		$DepartmentObj = new Department();
		$DepartmentList = $DepartmentObj->getDepartmentList('',$where);	*/
		$db= new Db();
		$qry = "select * from employee_departments where schoolid='".$mySession->user['schoolid']."' and status='1'";
		$DepartmentList = $db->runQuery("$qry");
		$this->view->departmentList = $DepartmentList;
		
		$qry2 = "select * from employee_departments where schoolid='".$mySession->user['schoolid']."' and status='0'";
		$DepartmentList2 = $db->runQuery("$qry2");
		$this->view->departmentList2 = $DepartmentList2;
			
			
	}
	
	public function editdepartmentAction()
	{	
			
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->depId = $id;
		
		
		$where  = array();
		$where['id'] = $id;
		$DepartmentObj = new Department();
		$DepartmentDetail = $DepartmentObj->getDepartmentDetail($where);	
		
		
		$formObj = new Form_Adddepartment($DepartmentDetail);
		if($this->getRequest()->isPost())
		{
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['code'] = $filteredValues['code'];
				$data['status'] = $filteredValues['status'];
				$condition[] = "id = ".$filteredValues['id'];
				
				
				
				$Department = new Department();
				$updateResult = $Department->updateDepartment($data,$condition);
				
				$mySession->sucMsg = LNG_EMPLOYEE_DEPARTMENT_UPDATED;
				$this->_redirect('employee/adddepartment');
			}
		}
		
	
		
		$this->view->form = $formObj;		
			
	}
	
	public function deletedepartmentAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->depId = $id;
		
		
		$condition[] = "id = ".$id;		
		$DepartmentObj = new Department();
		$deleteResult = $DepartmentObj->deleteDepartment($condition);
		
		$mySession->sucMsg = LNG_EMPLOYEE_DEPARTMENT_DELETED;
		$this->_redirect('employee/adddepartment');	
	}
	
	
	public function addgradeAction()
	{	
		global $mySession;
		$formObj = new Form_Addgrade();
		
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['priority'] = $filteredValues['priority'];
				$data['status'] = $filteredValues['status'];
				$data['max_hours_day'] = $filteredValues['max_hours_day'];
				$data['max_hours_week'] = $filteredValues['max_hours_week'];
				
				$GradeObj = new Grade();
				$insertResult = $GradeObj->insertGrade($data);	
			}
		}
		
		$where  = array();
		$where['status'] = 1;
		$GradeObj = new Grade();
		$GradeList = $GradeObj->getGradeList('',$where);	
		$this->view->gradeList = $GradeList;
		
		$this->view->form = $formObj;
					
	}
	
	public function editgradeAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->gradeId = $id;
		
		
		$where  = array();
		$where['id'] = $id;
		$GradeObj = new Grade();
		$GradeDetail = $GradeObj->getGradeDetail($where);	
		
		
		$formObj = new Form_Addgrade($GradeDetail);
		if($this->getRequest()->isPost())
		{
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['priority'] = $filteredValues['priority'];
				$data['status'] = $filteredValues['status'];
				$data['max_hours_day'] = $filteredValues['max_hours_day'];
				$data['max_hours_week'] = $filteredValues['max_hours_week'];
				
				$condition[] = "id = ".$filteredValues['id'];
				
				$GradeObj = new Grade();
				$updateResult = $GradeObj->updateGrade($data,$condition);
				
				$this->_redirect('employee/addgrade');
			}
		}
		
	
		
		$this->view->form = $formObj;				
	}
	
	public function deletegradeAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->gradeId = $id;
		
		
		$condition[] = "id = ".$id;
		
		$GradeObj = new Grade();
		$deleteResult = $GradeObj->deleteGrade($condition);
		
		$this->_redirect('employee/addgrade');		
	}
	
	public function addpositionAction()
	{	
		global $mySession;
		$formObj = new Form_Addposition();
		
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['employee_category_id'] = $filteredValues['employee_category_id'];
				$data['status'] = $filteredValues['status'];
				$data['schoolid'] = $mySession->user['schoolid'];
				
				$PositionObj = new Position();
				$insertResult = $PositionObj->insertPosition($data);
				
				$mySession->sucMsg = LNG_EMPLOYEE_POSITION_ADDED;
				$this->_redirect('employee/addposition');
			}
		}
		
		$db= new Db();
		$qry = "select a.*, b.name as catname from employee_positions as a left join employee_categories as b on (a.employee_category_id=b.id) where a.schoolid='".$mySession->user['schoolid']."' and a.status='1'";
		$positionList = $db->runQuery("$qry"); 
		
		$this->view->positionList = $positionList; 
		
		$this->view->form = $formObj;
		
		
		$qry = "select a.*, b.name as catname from employee_positions as a left join employee_categories as b on (a.employee_category_id=b.id) where a.schoolid='".$mySession->user['schoolid']."' and a.status='0'";
		$positionList2 = $db->runQuery("$qry"); 
		
		$this->view->positionList2 = $positionList2; 
		
		
	}
	
	public function editpositionAction()
	{	
			
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->positionId = $id;
		
		
		$where  = array();
		$where['id'] = $id;
		$PositionObj = new Position();
		$PositionDetail = $PositionObj->getPositionDetail($where);	
		
		
		$formObj = new Form_Addposition($PositionDetail);
		if($this->getRequest()->isPost())
		{
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				$filteredValues = $formObj->getValues();
				
				$data = array();
				$data['name'] = $filteredValues['name'];
				$data['employee_category_id'] = $filteredValues['employee_category_id'];
				$data['status'] = $filteredValues['status'];
				
				
				$condition[] = "id = ".$filteredValues['id'];
				
				$PositionObj = new Position();
				$updateResult = $PositionObj->updatePosition($data,$condition);
				
				$mySession->sucMsg = LNG_EMPLOYEE_POSITION_UPDATED;
				$this->_redirect('employee/addposition');
			}
		}
		
	
		
		$this->view->form = $formObj;				
		
	}
	
	public function deletepositionAction()
	{	
		global $mySession;
		
		$id = $this->getRequest()->id;
		$this->view->gradeId = $id;
		
		
		$condition[] = "id = ".$id;
		
		$PositionObj = new Position();
		$deleteResult = $PositionObj->deletePosition($condition);
		
		$mySession->sucMsg = LNG_EMPLOYEE_POSITION_DELETED;		
		$this->_redirect('employee/addposition');	
	}
	
	
	public function admission1Action()
	{	
		global $mySession;
		
		$formObj = new Form_Empadmission();
		
		
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
			$modelobj = new Mainmodel();
							
				$filteredValues = $formObj->getValues();
				//prd($postData);
				
				$data = array();
				$data['username'] = $postData['employee_username'];
				$data['schoolid'] = $mySession->user['schoolid'];
				$data['hashed_password'] = md5($postData['employee_password']);
				$data['usertype'] = 'T';
				
				$userid = $modelobj->insertThis('users',$data);
				
				$data = array();
				$data['schoolid'] = $mySession->user['schoolid'];
				$data['userid'] = $userid;
				$data['employee_number'] = $postData['employee_number'];
				$data['joining_date'] = changeDate($postData['employee_joining_date']);
				$data['first_name'] = $postData['employee_first_name'];
				//$data['middle_name'] = $postData['employee_middle_name'];
				$data['last_name'] = $postData['employee_last_name'];
				$data['gender'] = $postData['employee_gender'];
				$data['date_of_birth'] = changeDate($postData['emp_date_of_birth']);
				$data['employee_department_id'] = $postData['employee_department'];
				$data['employee_category_id'] = $postData['employee_category'];
				$data['employee_position_id'] = $postData['employee_position'];
				/*$data['employee_grade_id'] = $postData['employee_grade_id'];*/
				$data['job_title'] = $postData['employee_job_title'];
				$data['qualification'] = $postData['employee_qualification'];
				$data['experience_detail'] = $postData['employee_experience'];
				$data['experience_year'] = $postData['employee_experience_year'];
				$data['experience_month'] = $postData['employee_experience_month'];
				$data['status'] = $postData['employee_status'];
				$data['marital_status'] = $postData['employee_marital_status'];
				$data['children_count'] = $postData['employee_children_count'];
				$data['father_name'] = $postData['employee_father_name'];
				$data['mother_name'] = $postData['employee_mother_name'];
				$data['husband_name'] = $postData['employee_husband_name'];
				$data['blood_group'] = $postData['employee_blood_group'];
				$data['nationality_id'] = $postData['employee_nationality_id'];
				$data['marital_status'] = $postData['employee_marital_status'];

				
				
			
				$insid = $modelobj->insertThis('employees',$data);
				
				if(is_array($_FILES['employee_photo']) && $_FILES['employee_photo']['name']!='') {
					$ftype = $_FILES['employee_photo']['type'];
					$fname = $_FILES['employee_photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/employeephoto/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['employee_photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['photo_file_name'] = $filename;
					  $condition = "id='".$insid."'";
					  
					  $modelobj->updateThis('employees',$data,$condition);
					 }
				 }
				 
				if($insid)
				{
					$mySession->sucMsg = LNG_EMPLOYEE_ADDED;
					$this->_redirect('employee/admission2/admission1Id/'.$insid);
				}
			}
		}
		
		
		
		$this->view->form = $formObj;				
	}
	
	public function admission2Action()
	{	
			
		global $mySession;
		
		$params = $this->getRequest()->getParams();
		
		$admission1Id = $this->getRequest()->admission1Id;
		
		
		$formObj = new Form_Empadmission2();
		
		$this->view->admission1Id = $admission1Id;
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			if($formObj->isValid($postData))
			{
				
				$filteredValues = $formObj->getValues();
				
				$data = array();
				$data['home_address_line1'] = $postData['employee_home_address_line1'];
				$data['home_address_line2'] = $postData['employee_home_address_line2'];
				$data['home_city'] = $postData['employee_home_city'];
				$data['home_state'] = $postData['employee_home_state'];
				$data['home_country_id'] = $postData['employee_home_country_id'];
				$data['home_pin_code'] = $postData['employee_home_pin_code'];
				$data['office_address_line1'] = $postData['employee_office_address_line1'];
				$data['office_address_line2'] = $postData['employee_office_address_line2'];
				$data['office_city'] = $postData['employee_office_city'];
				$data['office_state'] = $postData['employee_office_state'];
				$data['office_country_id'] = $postData['employee_office_country_id'];
				$data['office_pin_code'] = $postData['employee_office_pin_code'];
				$data['office_phone1'] = $postData['employee_office_phone1'];
				$data['office_phone2'] = $postData['employee_office_phone2'];
				$data['mobile_phone'] = $postData['employee_mobile_phone'];
				$data['home_phone'] = $postData['employee_home_phone'];
				$data['email'] = $postData['employee_email'];
				$data['fax'] = $postData['employee_fax'];
				
				$condition = "id = ".$postData['admission1Id'];

			    $modelobj = new Mainmodel();
			
				$modelobj->updateThis('employees',$data,$condition);
			
				
				$this->_redirect('employee/profile/profileid/'.$postData['admission1Id']);
				//$this->_redirect('employee/editprivilege/admissionId/'.$postData['admission1Id']);
			}
		}
		
		
		
		$this->view->form = $formObj;				
			
	}
	
	
	public function editprivilegeAction()
	{	
			
			
		global $mySession;
		
		$params = $this->getRequest()->getParams();
		
		$admissionId = $this->getRequest()->admissionId;
		
		
		
		$userId = $this->getRequest()->userId;
		
		$this->view->admission1Id = $userId;
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			
				
				$privilegeIds = $postData['user']['privilege_ids'];
				
				
				foreach($privilegeIds as $privileges)
				{
					
					$data = array();
					$data['user_id'] = $userId;
					$data['privilege_id'] = $privileges;
					
					$db = new Db();
					$insertResult = $db->save('privileges_users',$data);
				}
				
				$mySession->sucMsg = LNG_EMPLOYEE_PRIVILEGES_UPDATED;
				$this->_redirect('employee/admission4/admissionId/'.$admissionId);
			
		}
		
		
	}
	
	
	public function admission4Action()
	{	
		global $mySession;
		
		$params = $this->getRequest()->getParams();
		
		$admissionId = $this->getRequest()->admissionId;
		
		
			
	}
	
	
	
	public function edit1Action()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->profileid=$arr['profileid'];
			$qry="select e.*, u.username, DATE_FORMAT(e.joining_date,'%M %d, %Y') as jdate from `employees` as e left join users as u on (e.userid=u.id) where e.id='".$arr['profileid']."'";	
			
			$detail=$db->runQuery("$qry");
			$data=$detail[0];
			$data['editmode'] = 1;
			$formObj = new Form_Empadmission($data);	
			
			$this->view->employeenumber = $data['employee_number'];
		if($this->getRequest()->isPost())
		{
			
			$postData = $this->getRequest()->getPost();
			
			if($formObj->isValid($postData))
			{
			
				$modelobj = new Mainmodel();
				$filteredValues = $formObj->getValues();
				//prd($postData);
				$data = array();
				
				$data['username'] = $postData['employee_username'];
				if($postData['employee_password']) {
					$data['hashed_password'] = md5($postData['employee_password']);
				}
				$condition = "id = ".$arr['hid_userid'];
				$updateResult = $modelobj->updateThis('users',$data,$condition);
				
				$data = array();
				
				$data['joining_date'] = changeDate($postData['employee_joining_date']);
				$data['first_name'] = $postData['employee_first_name'];
				//$data['middle_name'] = $postData['employee_middle_name'];
				$data['last_name'] = $postData['employee_last_name'];
				$data['gender'] = $postData['employee_gender'];
				
				$data['employee_department_id'] = $postData['employee_department'];
				$data['employee_category_id'] = $postData['employee_category'];
				$data['employee_position_id'] = $postData['employee_position'];
				$data['employee_grade_id'] = $postData['employee_grade_id'];
				$data['job_title'] = $postData['employee_job_title'];
				$data['qualification'] = $postData['employee_qualification'];
				$data['experience_detail'] = $postData['employee_experience'];
				$data['experience_year'] = $postData['employee_experience_year'];
				$data['experience_month'] = $postData['employee_experience_month'];
				$data['status'] = $postData['employee_status'];
				
				$condition = "id = ".$arr['profileid'];
	
				$updateResult = $modelobj->updateThis('employees',$data,$condition);
				
				if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					$ftype = $_FILES['student_photo']['type'];
					$fname = $_FILES['student_photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/employeephoto/';
					$ext = end(explode(".", $fname));
					$filename = $arr['profileid'].rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['photo_file_name'] = $filename;
					  $condition = "id='".$arr['profileid']."'";
					  
					  $modelobj->updateThis('employees',$data,$condition);
					 }
				 }
				
				 $this->_redirect('employee/profile/profileid/'.$arr['profileid']);
				
			}
			
		}
		$this->view->form = $formObj;	
	}
	
	public function editpersonalAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->profileid=$arr['profileid'];
		if($arr['profileid']) {
				$qry="select *, DATE_FORMAT(date_of_birth 	,'%M %d, %Y') as dobdate from `employees` where id='".$arr['profileid']."'";	
				
				$detail=$db->runQuery("$qry");
				$data=$detail[0];
				$data['editmode'] = 2;
				$formObj = new Form_Empadmission($data);	
				$this->view->employeenumber = $data['employee_number'];
			if($this->getRequest()->isPost())
			{
				
				$postData = $this->getRequest()->getPost();
				if($formObj->isValid($postData))
				{
					
					$filteredValues = $formObj->getValues();
					//prd($postData);
					
					$data = array();
					
					$data['date_of_birth'] = changeDate($postData['emp_date_of_birth']);
					
					$data['marital_status'] = $postData['employee_marital_status'];
					$data['children_count'] = $postData['employee_children_count'];
					$data['father_name'] = $postData['employee_father_name'];
					$data['mother_name'] = $postData['employee_mother_name'];
					$data['husband_name'] = $postData['employee_husband_name'];
					$data['blood_group'] = $postData['employee_blood_group'];
					$data['nationality_id'] = $postData['employee_nationality_id'];
					$data['marital_status'] = $postData['employee_marital_status'];
					
					
					$condition = "id = ".$arr['profileid'];					
					
					$modelobj = new Mainmodel();
					$updateResult = $modelobj->updateThis('employees',$data,$condition);
					
					$this->_redirect('employee/profile/profileid/'.$arr['profileid']);
					
				}
				
			}
			$this->view->form = $formObj;
		}	
	}
	
	
	
	public function edit2Action()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->profileid=$arr['profileid'];
		if($arr['profileid']) {
				$qry="select *, DATE_FORMAT(date_of_birth 	,'%M %d, %Y') as dobdate from `employees` where id='".$arr['profileid']."'";	
				
				$detail=$db->runQuery("$qry");
				$data=$detail[0];
				$data['editmode'] = 1;
				$formObj = new Form_Empadmission2($data);	
				$this->view->employeenumber = $data['employee_number'];
					
			$this->view->admission1Id = $admission1Id;
			if($this->getRequest()->isPost())
			{
				
				$postData = $this->getRequest()->getPost();
				if($formObj->isValid($postData))
				{
					
					$filteredValues = $formObj->getValues();
					
					$data = array();
					$data['home_address_line1'] = $postData['employee_home_address_line1'];
					$data['home_address_line2'] = $postData['employee_home_address_line2'];
					$data['home_city'] = $postData['employee_home_city'];
					$data['home_state'] = $postData['employee_home_state'];
					$data['home_country_id'] = $postData['employee_home_country_id'];
					$data['home_pin_code'] = $postData['employee_home_pin_code'];
					$data['office_address_line1'] = $postData['employee_office_address_line1'];
					$data['office_address_line2'] = $postData['employee_office_address_line2'];
					$data['office_city'] = $postData['employee_office_city'];
					$data['office_state'] = $postData['employee_office_state'];
					$data['office_country_id'] = $postData['employee_office_country_id'];
					$data['office_pin_code'] = $postData['employee_office_pin_code'];
					
					
					$condition = "id = ".$arr['profileid'];					
					
					$modelobj = new Mainmodel();
					$updateResult = $modelobj->updateThis('employees',$data,$condition);
					
					$this->_redirect('employee/profile/profileid/'.$arr['profileid']);
					//$this->_redirect('employee/editprivilege/admissionId/'.$postData['admission1Id']);
				}
			}
			$this->view->form = $formObj;	
		}	
	}
	
	public function editcontactAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->profileid=$arr['profileid'];
		if($arr['profileid']) {
				$qry="select *, DATE_FORMAT(date_of_birth 	,'%M %d, %Y') as dobdate from `employees` where id='".$arr['profileid']."'";	
				
				$detail=$db->runQuery("$qry");
				$data=$detail[0];
				$data['editmode'] = 2;
				$formObj = new Form_Empadmission2($data);	
				$this->view->employeenumber = $data['employee_number'];
					
			$this->view->admission1Id = $admission1Id;
			if($this->getRequest()->isPost())
			{
				
				$postData = $this->getRequest()->getPost();
				if($formObj->isValid($postData))
				{
					
					$filteredValues = $formObj->getValues();
					
					$data = array();
					$data['office_phone1'] = $postData['employee_office_phone1'];
					$data['office_phone2'] = $postData['employee_office_phone2'];
					$data['mobile_phone'] = $postData['employee_mobile_phone'];
					$data['home_phone'] = $postData['employee_home_phone'];
					$data['email'] = $postData['employee_email'];
					$data['fax'] = $postData['employee_fax'];
					
					$condition = "id = ".$arr['profileid'];					
					
					$modelobj = new Mainmodel();
					$updateResult = $modelobj->updateThis('employees',$data,$condition);
					
					$this->_redirect('employee/profile/profileid/'.$arr['profileid']);
					//$this->_redirect('employee/editprivilege/admissionId/'.$postData['admission1Id']);
				}
			}
			$this->view->form = $formObj;
		}		
	}
	
	
	public function searchAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry = "select * from employee_departments where schoolid='".$mySession->user['schoolid']."' ";
		$department = $db->runQuery("$qry");
		$this->view->department = $department;
		
		$qry = "select * from employee_categories where schoolid='".$mySession->user['schoolid']."' ";
		$categories = $db->runQuery("$qry");
		$this->view->categories = $categories;
	}
	public function positionlistAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($arr['catid']) {
			$qry = "select * from employee_positions where employee_category_id='".$arr['catid']."' and  schoolid='".$mySession->user['schoolid']."' ";
			$rlist = $db->runQuery("$qry");
			$this->view->rlist = $rlist;
		}	
	}
	public function searchajaxAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$wherecondition='';
		
		if (!empty($arr['employee_department_id'])) {
			$wherecondition .= " and a.employee_department_id='".$arr['employee_department_id']."'";
		}
		if (!empty($arr['employee_category_id'])) {
			$wherecondition .= " and a.employee_category_id='".$arr['employee_category_id']."'";
		} 
		if(!empty($arr['employee_position_id'])) {
			$wherecondition .= " and a.employee_position_id='".$arr['employee_position_id']."'";
		}
		if (!empty($arr['search_keyword'])) {
			$wherecondition .= " and (first_name like '%".$arr['search_keyword']."%' or 
						last_name like '%".$arr['search_keyword']."%' or
						employee_number = '".$arr['search_keyword']."' or 
						qualification = '".$arr['search_keyword']."') 
						";
		}
		
		$qry="select a.*, concat(a.first_name,' ',a.last_name) as name, b.name as deptname from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) where a.schoolid='".$mySession->user['schoolid']."' and a.status='1' ".$wherecondition;	
				
			$emplist=$db->runQuery("$qry");
			$this->view->emplist=$emplist;
	}
	
	public function profileAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, u.username,
			b.name as deptname, c.name as catname, e.name as gradename, e.name as posname  
			from `employees` as a 
			left join users as u on (a.userid=u.id)
			left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}	
	}
	
	public function profilegeneralAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, 
			b.name as deptname, c.name as catname, e.name as posname  
			from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
		
	}
	
	public function profilepersonalAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.date_of_birth, '%d %M, %Y') as dob, b.name as countryname			
			from `employees` as a left join countries as b on (a.nationality_id=b.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function profileaddressAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.date_of_birth, '%d %M, %Y') as dob, b.name as countryname, c.name as officecountryname			
			from `employees` as a left join countries as b on (a.home_country_id=b.id)
			left join countries as c on (a.office_country_id=c.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function profilecontactAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.date_of_birth, '%d %M, %Y') as dob, b.name as countryname			
			from `employees` as a left join countries as b on (a.nationality_id=b.id)
			where a.id='".$arr['profileid']."'";	
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function profilebankdetailsAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, 
			b.name as deptname, c.name as catname, e.name as gradename, e.name as posname  
			from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join employee_grades as d on (a.employee_position_id=d.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function profileadditionaldetailsAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, 
			b.name as deptname, c.name as catname, e.name as gradename, e.name as posname  
			from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join employee_grades as d on (a.employee_position_id=d.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	
	public function viewallAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry="select * from `employee_departments` where status ='1' and schoolid='".$mySession->user['schoolid']."'";		
		$deptlist=$db->runQuery("$qry");
		$this->view->deptlist=$deptlist;
			
		
	}
	
	public function employeeslistAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$wherecondition='';
		
		if (!empty($arr['employee_first_name'])) {
			$wherecondition .= " and (a.first_name like '%".$arr['employee_first_name']."%' || a.last_name like '%".$arr['employee_first_name']."%')";
		}
		if (!empty($arr['employee_number'])) {
			$wherecondition .= " and a.employee_number='".$arr['employee_number']."'";
		} 
		if(isset($arr['search_gender']) && $arr['search_gender']!='') {
			$wherecondition .= " and a.gender='".$arr['search_gender']."'";
		}
		if(!empty($arr['employee_blood_group'])) {
			$wherecondition .= " and a.blood_group='".$arr['employee_blood_group']."'";
		}
		if(!empty($arr['employee_marital_status'])) {
			$wherecondition .= " and a.marital_status='".$arr['employee_marital_status']."'";
		}
		if(!empty($arr['employee_country'])) {
			$wherecondition .= " and a.home_country_id='".$arr['employee_country']."'";
		}
		if(!empty($arr['employee_category'])) {
			$wherecondition .= " and a.employee_category_id='".$arr['employee_category']."'";
		}
		if(!empty($arr['employee_department_id'])) {
			$wherecondition .= " and a.employee_department_id='".$arr['employee_department']."'";
		}
		if(!empty($arr['employee_position'])) {
			$wherecondition .= " and a.employee_position_id='".$arr['employee_position']."'";
		}
		if(!empty($arr['employee_joining_date']) && !empty($arr['employee_joining_date_to'])) {
			$wherecondition .= " and a.joining_date >= '".changedate($arr['employee_joining_date'])."' and a.joining_date <= '".changedate($arr['employee_joining_date_to'])."'";
		} elseif(!empty($arr['employee_joining_date'])) {
			$wherecondition .= " and a.joining_date >='".changedate($arr['employee_joining_date'])."'";
		} elseif(!empty($arr['employee_joining_date_to'])) {
			$wherecondition .= " and a.joining_date < '".changedate($arr['employee_joining_date_to'])."'";
		}
		
		if(!empty($arr['employee_dob']) && !empty($arr['employee_dob_to'])) {
			$wherecondition .= " and a.date_of_birth >= '".changedate($arr['employee_dob'])."' and a.date_of_birth <= '".changedate($arr['employee_dob_to'])."'";
		} elseif(!empty($arr['employee_dob'])) {
			$wherecondition .= " and a.date_of_birth >='".changedate($arr['employee_dob'])."'";
		} elseif(!empty($arr['employee_dob_to'])) {
			$wherecondition .= " and a.date_of_birth < '".changedate($arr['employee_dob_to'])."'";
		}
		$this->view->wherecondition=$wherecondition;
		$qry="select a.*, concat(a.first_name,' ',a.last_name) as name, b.name as deptname from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) where a.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;	
				
			$emplist=$db->runQuery("$qry");
			$this->view->emplist=$emplist;
	}
	
	public function subjectassignmentAction()
	{	
		global $mySession;
		
		$db=new Db();
		
		$qry="select g.*,b.name as batch_name from `grades` as g left join `batches` as b on (g.id=b.grade_id) where b.schoolid='".$mySession->user['schoolid']."' ";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;
		
	}
	public function classassignmentAction()
	{	
		global $mySession;
		
		$db=new Db();
		
		$qry="select * from `employee_departments` where status ='1' and schoolid='".$mySession->user['schoolid']."'";
		$dept = $db->runQuery("$qry");
		$this->view->deptlist=$dept;
		/*
		$qry="select * from `grades` where schoolid='".$mySession->user['schoolid']."' "; 
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;*/
		
	}
	
	public function selectemployeesAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['department_id'])) {
		
		$qry="select a.*, concat(a.first_name,' ',a.last_name) as name, b.name as deptname from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) where a.employee_department_id='".$arr['department_id']."'";
		$emplist=$db->runQuery("$qry");
		$this->view->emplist=$emplist;
		}
		
	}
	
	
	public function selectgradesAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['emp_id'])) {
			if(isset($arr['mode']) && $arr['mode']=='assignbatch') {
				$data = array();
				$data['schoolid'] = $mySession->user['schoolid'];
				$data['batch_id'] = $arr['batch_id'];
				$data['empid'] = $arr['emp_id'];
				$data['status'] = 1;
				
				$modelobj = new Mainmodel();
				
				$modelobj->insertThis('teacher_to_grade',$data);
			}
			
			$qry="select * from `batches` where is_active ='1' and is_deleted='0' and schoolid='".$mySession->user['schoolid']."'";
			
			$this->view->emp_id = $arr['emp_id'];
			$qry="select * from `grades` where is_deleted ='0' and schoolid='".$mySession->user['schoolid']."'";
			
			$glist = $db->runQuery("$qry");
			$this->view->glist=$glist;
		}
	}
	public function updatebatchAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['grade_id'])) {
		$this->view->emp_id = $arr['emp_id'];
			$qry = "select * from batches where grade_id='".$arr['grade_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$batchlist = $db->runQuery($qry);
			
			$this->view->batchlist = $batchlist;
		}
	}
	
	public function updatesubjectsAction()
	{	
		global $mySession;		
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		if (isset($arr['grade_id'])) {
			$qry="select * from `subjects` where grade_id='".$arr['grade_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$attend = $db->runQuery("$qry");
			$this->view->subject=$attend;
			
		}
	}
	
	public function selectdepartmentAction()
	{	
		global $mySession;		
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		$this->view->subject_id = $arr['subject_id'];
		if (isset($arr['subject_id'])) {
			$qry="select a.*, concat(b.first_name,' ',b.last_name) as ename, c.name as deptname from `employees_subjects` as a left join employees as b on(a.employee_id=b.id) left join employee_departments as c on(b.employee_department_id=c.id) where a.subject_id='".$arr['subject_id']."' and a.schoolid='".$mySession->user['schoolid']."'";
			$emp_subject_list = $db->runQuery("$qry");
			
			$this->view->emp_subject_list=$emp_subject_list;
			
		}
		
		
		$qry="select * from `employee_departments` where status ='1' and schoolid='".$mySession->user['schoolid']."'";
		$dept = $db->runQuery("$qry");
		$this->view->deptlist=$dept;
			
		
	}
	
	public function updateemployeesAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		$this->view->subject_id = $arr['subject_id'];
		$this->view->department_id = $arr['department_id'];
		
		
		if (isset($arr['department_id'])) {
			$qry="select b.id, concat(b.first_name, ' ',b.last_name) as ename, c.name as deptname from employees as b left join employee_departments as c on(b.employee_department_id=c.id) where b.employee_department_id='".$arr['department_id']."' and b.id not in(select employee_id from employees_subjects where subject_id='".$arr['subject_id']."' and schoolid='".$mySession->user['schoolid']."') and b.schoolid='".$mySession->user['schoolid']."'";
			$emp_list = $db->runQuery("$qry");
			//echo "<pre>";
			//print_r($emp_list);
			
			$this->view->emp_list=$emp_list;
		}	
	}
//====================================================================================================	
	public function assignemployeeAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		$qry="select * from `employees_subjects` where employee_id='".$arr['employeeid']."' and subject_id='".$arr['subject_id']."'";
		$chkrec = $db->runQuery("$qry");
		if(count($chkrec) < 1) {	
			$data['employee_id']=$arr['employeeid'];
			$data['subject_id']=$arr['subject_id'];
			$data['schoolid']=$mySession->user['schoolid'];
			
			$modelobj = new Mainmodel();
			$modelobj->insertThis('employees_subjects',$data);
		}
		$this->_redirect('employee/selectdepartment/subject_id/'.$arr['subject_id']);
		exit;
	}
	
	public function advancedsearchAction()
	{	
		global $mySession;
	}
	
	public function removeemployeeAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		
		$qry = "select employee_id, subject_id from employees_subjects where id='".$arr['id']."'";
		prd($qry);
		$empid = $db->runQuery("$qry");
		
		$condition  = "id='".$arr['id']."'";
		$db->delete('employees_subjects',$condition);
		
		$tcondition  = "employee_id='".$empid[0]['employee_id']."' and subject_id='".$empid[0]['subject_id']."'";		
		$db->delete('timetable_entries',$tcondition);
		
		$this->_redirect('employee/selectdepartment/subject_id/'.$arr['subject_id']);
		exit;
	}
	
	
	public function removeAction()
	{	
		global $mySession;	
		
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();	
		$this->view->profileid=$arr['profileid'];
		if (isset($arr['profileid'])) {
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, 
			b.name as deptname, c.name as catname, e.name as gradename, e.name as posname  
			from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join grades as d on (a.employee_position_id=d.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
	
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
		
	}
	
	
	public function changetoformerAction()
	{	
		global $mySession;
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();	
		$this->view->profileid=$arr['profileid'];
		
		if (isset($arr['profileid'])) {
			if (isset($arr['mode']) && $arr['mode']=='former') {
				
				
				$userdata['status']=0;
				
				$modelobj = new Mainmodel();
				$wherercondition = "id in (select userid from employees where id='".$arr['profileid']."')";
				$modelobj->updateThis('users',$userdata,$wherercondition);
				
				$data['status_description']=$arr['status_description'];
				$data['status']=0;
				
				$wherercondition = "id='".$arr['profileid']."'";
				$modelobj->updateThis('employees',$data,$wherercondition);
				$this->_redirect('user/dashboard');
				exit;
			}
		
			$qry="select a.*, DATE_FORMAT(a.joining_date, '%d %M, %Y') as jdate, 
			concat(a.first_name,' ',a.last_name) as name, 
			b.name as deptname, c.name as catname, e.name as gradename, e.name as posname  
			from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) 
			left join employee_categories as c on (a.employee_category_id=c.id)
			left join grades as d on (a.employee_position_id=d.id)
			left join employee_positions as e on (a.employee_position_id=e.id)
			where a.id='".$arr['profileid']."'";		
			
			$detail=$db->runQuery("$qry");
			$this->view->detail=$detail[0];
			
		}
	}
	
	public function deleteAction()
	{	
		global $mySession;	
		
		
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();	
		$this->view->profileid=$arr['profileid'];
		
		if (isset($arr['profileid'])) {
				$wherercondition = "id in (select userid from employees where id='".$arr['profileid']."')";
				$db->delete('users',$wherercondition);
				
						
				$wherercondition = "id='".$arr['profileid']."'";
				$db->delete('employees',$wherercondition);
				$this->_redirect('user/dashboard');
				exit;
		}	
	}
	
	
	public function exportxlsAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		// file name for download			
		
		$filename = "employee_list_" . date('Ymdh') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"$filename\""); 
		header("Content-Type: application/vnd.ms-excel"); 
		$flag = false; 
		
		$wherecondition='';
		
		if(isset($arr['wherecondition']))
		{
			$wherecondition = stripslashes($arr['wherecondition']);
			
		}else{
			if (!empty($arr['employee_department_id'])) {
				$wherecondition .= " and a.employee_department_id='".$arr['employee_department_id']."'";
			}
			if (!empty($arr['employee_category_id'])) {
				$wherecondition .= " and a.employee_category_id='".$arr['employee_category_id']."'";
			} 
			if(!empty($arr['employee_position_id'])) {
				$wherecondition .= " and a.employee_position_id='".$arr['employee_position_id']."'";
			}
			if (!empty($arr['search_keyword'])) {
				$wherecondition .= " and (a.first_name like '%".$arr['search_keyword']."%' or 
							a.last_name like '%".$arr['search_keyword']."%' or
							a.employee_number = '".$arr['search_keyword']."' or 
							a.qualification = '".$arr['search_keyword']."') 
							";
			}
		}
		
		$result = $db->runQuery("SELECT 
		a.employee_number as Employee_No, 
		concat(a.first_name,' ',a.last_name) as Name, 
		a.gender as Gender, 
		a.job_title as Job_Title,
		b.id as Employee_Department, 
		c.id as Employee_Category,
		e.id as Employee_Position,
		a.qualification as Qualification,
		a.experience_detail as Experience_Detail, 
		a.home_address_line1 as Address, 
		a.mobile_phone as Contact_No 
		FROM employees as a
		left join employee_departments as b on(a.employee_department_id=b.id) 
		left join employee_categories as c on (a.employee_category_id=c.id)
		left join employee_positions as e on (a.employee_position_id=e.id)
		WHERE a.schoolid='".$mySession->user['schoolid']."' ".$wherecondition."
		ORDER BY a.first_name");
		
	
		foreach($result as $row) { 
			if(!$flag) { 
				# display field/column names as first row 
				echo str_replace('_',' ',implode("\t", array_keys($row)) . "\r\n"); 
				$flag = true; 
			} 
			array_walk($row, 'cleanData'); 
			echo implode("\t", array_values($row)) . "\r\n"; 
		} 
		exit;
	}
}
?>