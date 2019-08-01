<?php
__autoloadDB('Db');
class ConfigurationController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	public function settingsAction()
	{	
		global $mySession;
		$db=new Db();
		
		$qry = "select * from school where id='".$mySession->user['schoolid']."'";
		$detail = $db->runQuery($qry);
		$this->view->detail = $detail[0];
			
		$form = new Form_School($detail[0]);
		$this->view->Form=$form;
			
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();			
				if ($form->isValid($formData)) {
				
					$data='';
					$data['name'] = $formData['institution_name'];
					$data['address'] = $formData['institution_address'];
					$data['phno'] = $formData['institution_phone_no'];
					$data['mhno'] = $formData['institution_fax_no'];
					$data['emplogin'] = $formData['emplogin'];
					$data['parentlogin'] = $formData['parentlogin'];
					
					$modelobj = new Mainmodel();
					$condition = "id='".$mySession->user['schoolid']."'";
					$modelobj->updateThis('school',$data,$condition);
					
					if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					$insid = $mySession->user['schoolid'];
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
					$this->_redirect('configuration/settings');
				}
			 }
	}
	
	public function transferstudentAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();		
		$qry="select * from `grades` where schoolid='".$mySession->user['schoolid']."'";	
		$batchlist=$db->runQuery("$qry");
		$this->view->batchlist=$batchlist;
		
		
	}
	public function transferstudent2Action()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if(isset($arr['mode']) && $arr['mode']=='transfer') {
			$newbatch_id = $arr['newbatch_id'];
			foreach($arr['chk'] as $chk) {
				$arr['studentid'] = $chk;
				$qry="select * from students where id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$formData = $db->runQuery($qry);
				$formData =$formData[0] ;
				
				$Data = array();
				$Data['admission_no'] = $formData['admission_no'];				
				$Data['schoolid'] = $formData['schoolid'];
				$Data['passport_or_id'] = $formData['passport_or_id'];
				$Data['student_passport_no'] = $formData['student_passport_no'];	
				$Data['guardian_id'] = $formData['guardian_id'];			
				$Data['admission_date'] = $formData['admission_date'];
				$Data['title'] = $formData['title'];
				$Data['first_name'] = $formData['first_name'];
				$Data['middle_name'] = $formData['middle_name'];
				$Data['last_name'] = $formData['last_name'];
				$Data['batch_id'] = $newbatch_id;
				$Data['date_of_birth'] = $formData['date_of_birth'];
				$Data['gender'] = $formData['gender'];
				$Data['blood_group'] = $formData['blood_group'];
				$Data['nationality_id'] = $formData['nationality_id'];
				$Data['religion'] = $formData['religion'];
				$Data['address_line1'] = $formData['address_line1'];
				$Data['phone1'] = $formData['phone1'];
				$Data['photo_file_name'] = $formData['photo_file_name'];
				$Data['photo_content_type'] = $formData['photo_content_type'];
				$Data['photo_data'] = $formData['photo_data'];
				$Data['birth_certificate'] = $formData['birth_certificate'];
				$Data['status_description'] = $formData['status_description'];				
								
				
				$modelobj = new Mainmodel();
				$modelobj->insertThis('students',$Data);
				
				
				$Data['studentid'] = $formData['id'];				
				$Data['batch_id'] = $formData['batch_id'];
				$Data['is_active'] = $formData['is_active'];
				$Data['student_illness'] = $formData['student_illness'];
				$Data['class_roll_no'] = $formData['class_roll_no'];
				
				$insid = $modelobj->insertThis('archive_students',$Data);
				$wherecondition = "id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$db->delete('students',$wherecondition);
				
				// -- Archive attandance detail
				$qry="select * from attendances where student_id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$attandencedetail = $db->runQuery($qry);
				foreach($attandencedetail as $atdetail) {
					$Data = array();
					$Data['arc_student_id'] = $insid;
					$Data['student_id'] = $atdetail['student_id'];
					$Data['schoolid'] = $atdetail['schoolid'];
					$Data['period_table_entry_id'] = $atdetail['period_table_entry_id'];
					$Data['forenoon'] = $atdetail['forenoon'];
					$Data['afternoon'] = $atdetail['afternoon'];
					$Data['reason'] = $atdetail['reason'];
					
					$modelobj->insertThis('archive_attendances',$Data);
				}
				$wherecondition = "student_id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$db->delete('attendances',$wherecondition);
				
				// -- Archive Exam detail
				$qry="select * from exam_scores where student_id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$examscoredetail = $db->runQuery($qry);
				foreach($examscoredetail as $esdetail) {
					$Data = array();
					$Data['arc_student_id'] = $insid;
					$Data['student_id'] = $esdetail['student_id'];
					$Data['schoolid'] = $esdetail['schoolid'];
					$Data['exam_id'] = $esdetail['exam_id'];
					$Data['marks'] = $esdetail['marks'];
					$Data['grading_level_id'] = $esdetail['grading_level_id'];
					$Data['remarks'] = $esdetail['remarks'];
					$Data['is_failed'] = $esdetail['is_failed'];
					$Data['created_at'] = $esdetail['created_at'];
					$Data['updated_at'] = $esdetail['updated_at'];
					
					$modelobj->insertThis('archive_exam_scores',$Data);
				}
				$wherecondition = "student_id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$db->delete('exam_scores',$wherecondition);
				
				$mySession->sucMsg = 'Student transferred successfully to new batch';
				
			}
		}
		if($arr['search_batchid']) {
			$this->view->batchid = $arr['search_batchid'];
			$qry = "select b.id, b.name, b.start_date, DATE_FORMAT(b.start_date, '%M %d, %Y') as sdate, DATE_FORMAT(b.end_date, '%M %d, %Y') as edate, c.grade_name, c.grade_name from batches as b left join grades as c on (b.grade_id=c.id) where b.id='".$arr['search_batchid']."' and b.schoolid='".$mySession->user['schoolid']."'";
			
			$batchdetail = $db->runQuery($qry);
			$this->view->batchdetail = $batchdetail[0];
			
			$qry = "select id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, admission_no from students where batch_id='".$arr['search_batchid']."' and schoolid='".$mySession->user['schoolid']."'";
			
			$studentlist = $db->runQuery($qry);
			$this->view->studentlist = $studentlist;
			
			$qry = "select b.id, b.name, b.start_date, DATE_FORMAT(b.start_date, '%M %d, %Y') as sdate, DATE_FORMAT(b.end_date, '%M %d, %Y') as edate, c.code, c.grade_name from batches as b left join grades as c on (b.grade_id=c.id) where b.schoolid='".$mySession->user['schoolid']."' and b.start_date > '".$batchdetail[0]['start_date']."'";
			$newbatchlist = $db->runQuery($qry);
			$this->view->newbatchlist = $newbatchlist;
		} else {
			$this->_redirect('index');
		}
	}
	public function batchlistcomboAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$batchdate_condition = '';
		if($arr['gradeid']) {
			if($arr['search_year']) {
				$batchdate_condition=" and start_date like  '".$arr['search_year']."-%'";
			}
			$qry = "select * from batches where grade_id='".$arr['gradeid']."' and schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
			$blist = $db->runQuery($qry);
			$this->view->batchlist = $blist;
		}
	}
	
	public function transfertonewAction()
	{	
		global $mySession;
	}
}
?>