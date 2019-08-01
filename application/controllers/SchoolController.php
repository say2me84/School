<?php
__autoloadDB('Db');
class SchoolController extends AppController
{
	
	public function indexAction()
	{	
		global $mySession;		
	}
	public function admission1Action()
	{	
		global $mySession;
		
		$this->view->pagetitle = 'Add School';
		$form = new Form_School();
		$this->view->Form=$form;		
		
		 if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				$data['name'] = $formData['institution_name'];
				$data['address'] = $formData['institution_address'];
				$data['phno'] = $formData['institution_phone_no'];
				$data['mhno'] = $formData['institution_fax_no'];
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('school',$data);
				
				if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					
					$ftype = $_FILES['student_photo']['type'];
					$fname = $_FILES['student_photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/school/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['logo'] = $filename;
					  $condition = "id='".$insid."'";
					  
					  $modelobj->updateThis('school',$data,$condition);
					 }
				}
				$mySession->sucMsg = LNG_SCHOOL_ADDED;
				$this->_redirect('school/viewall');
			}
		 }
	}
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['schoolid']) {
		$this->view->schoolid = $arr['schoolid'];
		$qry = "select * from school where id='".$arr['schoolid']."'";
			$detail = $db->runQuery($qry);
			
			$this->view->pagetitle = 'Edit School';
			$form = new Form_School($detail[0]);
			$this->view->Form=$form;		
			
			 if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();			
				if ($form->isValid($formData)) {
				
					$data='';
					$data['name'] = $formData['institution_name'];
					$data['address'] = $formData['institution_address'];
					$data['phno'] = $formData['institution_phone_no'];
					$data['mhno'] = $formData['institution_fax_no'];
					
					$modelobj = new Mainmodel();
					$condition = "id='".$arr['schoolid']."'";
					$modelobj->updateThis('school',$data,$condition);
					
					if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					$insid = $arr['schoolid'];
						$ftype = $_FILES['student_photo']['type'];
						$fname = $_FILES['student_photo']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = 'upload/school/';
						$ext = end(explode(".", $fname));
						$filename = $insid.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						
						if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadfile)) {
											  
						  $data = '';
						  $data['logo'] = $filename;
						  $condition = "id='".$insid."'";
						  
						  $modelobj->updateThis('school',$data,$condition);
						 }
					}
					$mySession->sucMsg = LNG_SCHOOL_UPDATED;
					$this->_redirect('school/show/schoolid/'.$arr['schoolid']);
				}
			 }
		}
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
		
			$qry="select * from school ";			
			$sdetail=$db->runQuery("$qry");			
			$this->view->sdetail=$sdetail;
			
		
	}
	public function showAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['schoolid']) {
		
			$qry="select * from school where id='".$arr['schoolid']."' ";			
			$sdetail=$db->runQuery("$qry");
			
			
			$this->view->sdetail=$sdetail;
		}
		
	}
	public function createAction()
	{	
		global $mySession;		
	}
	public function removeAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['schoolid']) {
			$condition = "id='".$arr['schoolid']."'";
			$db->delete('school',$condition);
			
			///  grades subjects 
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('grades',$condition);
			
			///  subjects 
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('subjects',$condition);
			
			///  batches grouped_exams period_entries timetable_entries weekdays 
			
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('batches',$condition);
			
			///  grouped_exams
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('grouped_exams',$condition);
				
			///  period_entries
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('period_entries',$condition);
			
			///  timetable_entries
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('timetable_entries',$condition);
			
			///  weekdays
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('weekdays',$condition);
							
			///  employees
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('employees',$condition);
			
			///  employee_categories
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('employee_categories',$condition);
			
			///  employee_departments
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('employee_departments',$condition);
			
			///  employees_subjects
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('employees_subjects',$condition);
			
			///  employee_positions
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('employee_positions',$condition);
			
			///  events
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('events',$condition);
			
			///  exam_groups   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('exam_groups',$condition);
			
			///  exam_scores   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('exam_scores',$condition);
			
			///  grading_levels   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('grading_levels',$condition);
			
			///  exams   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('exams',$condition);
			
			///  students   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('students',$condition);
			
			///  guardians   
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('guardians',$condition);
			
			///  users  reminders  ticket_commented ticket_assigned ticket
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('users',$condition);
			
			///  teacher_to_grade
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('teacher_to_grade',$condition);
			
			///  exam_groups  exam 
			$condition = "schoolid='".$arr['schoolid']."'";
			$db->delete('exam_groups',$condition);
			
			$mySession->sucMsg = LNG_SCHOOL_DELETED;
			$this->_redirect('school/viewall/');
		}
		exit;
	}
	public function changestatusAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['schoolid']) {
			if($arr['status']=='enable') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
			
			$modelobj = new Mainmodel();
			$condition = "id='".$arr['schoolid']."'";
			$modelobj->updateThis('school',$data,$condition);
			
			$mySession->sucMsg = LNG_SCHOOL_STATUS_UPDATED;
			$this->_redirect('school/viewall/');
		}		
	}
	
}
?>