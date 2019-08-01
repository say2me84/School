<?php
__autoloadDB('Db');
class StudentController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	
	public function admission1Action()
	{	
		global $mySession; 
		
		$objRequest = $this->getRequest();
		$form = new Form_Admission();		
		
		$this->view->form = $form;		
		if ($objRequest->isPost()) {	
			$formData = $objRequest->getPost();	
			//echo "<pre>";print_r($formData);exit;		
			if($form->isValid($formData)){
				$formData = $this->_request->getPost();			
				$Data['admission_no'] = $formData['student_admission_no'];
				$Data['schoolid'] = $mySession->user['schoolid'];
				$Data['class_roll_no'] = '';
				$Data['admission_date'] = changedate($formData['admission_date']);
				$Data['passport_or_id'] = $formData['passport_or_id'];
				$Data['student_passport_no'] = $formData['student_passport_no'];
				$Data['title'] = $formData['title'];
				$Data['first_name'] = $formData['first_name'];
				$Data['middle_name'] = $formData['middle_name'];
				$Data['last_name'] = $formData['last_name'];
				$Data['nationality_id'] = $formData['student_nationality'];
				$Data['batch_id'] = $formData['student_batch_id'];
				$Data['date_of_birth'] = changedate($formData['date_of_birth']);
				$Data['student_illness'] = $formData['student_illness'];
				$Data['religion'] = $formData['student_religion'];
				$Data['address_line1'] = $formData['student_address_line1'];
				$Data['phone1'] = $formData['student_phone1'];
				/*$Data['gender'] = $formData['student_gender'];
				$Data['blood_group'] = $formData['student_blood_group'];
				$Data['birth_place'] = $formData['student_birth_place'];
				$Data['student_category_id'] = $formData['student_category_id'];
				$Data['language'] = $formData['student_language'];
				$Data['address_line2'] = $formData['student_address_line2'];
				$Data['city'] = $formData['student_city'];
				$Data['state'] = $formData['student_state'];
				$Data['pin_code'] = $formData['student_pin_code'];
				$Data['country_id'] = $formData['student_country'];
				
				$Data['phone2'] = $formData['student_phone2'];
				$Data['email'] = $formData['student_email'];			
				$Data['user_id'] = $formData['addmission_no'];*/			
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('students',$Data);
				
				if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					$ftype = $_FILES['student_photo']['type'];
					$fname = $_FILES['student_photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/photo/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['photo_file_name'] = $filename;
					  $condition = "id='".$insid."'";
					  
					  $modelobj->updateThis('students',$data,$condition);
					 }
				 }
				 
				 if(is_array($_FILES['birth_certificate']) && $_FILES['birth_certificate']['name']!='') {
					$ftype = $_FILES['birth_certificate']['type'];
					$fname = $_FILES['birth_certificate']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/document/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['birth_certificate']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['birth_certificate'] = $filename;
					  $condition = "id='".$insid."'";
					  
					  $modelobj->updateThis('students',$data,$condition);
					 }
				 }
				 
				if ($insid) {
					$mySession->StudentID = $insid;
					$mySession->sucMsg = LNG_STUDENT_ADDED;
					$this->_redirect('student/admission2/studentid/'.$insid);
				}
					
			}
			
		}
			
	}
	
	public function admission2Action()
	{	
		global $mySession;	
		//echo "<pre>";print_r($mySession->StudentID);exit;
		/*if(!isset($mySession->dmemail['user'])){	
			$this->_redirect('index');		
			exit;
		}*/
		$db = new Db();
		$form = new Form_Admission2();		
		$this->view->form = $form;
		
		$formalready = new Form_Admission21();		
		$this->view->formalready = $formalready;
		
		$objRequest = $this->getRequest();
		$params = $objRequest->getParams();
		if (isset($params['studentid']) && !empty($params['studentid'])) {
			$studentid = $params['studentid'];
		}elseif (isset($mySession->StudentID) && !empty($mySession->StudentID)) {
			$studentid = $mySession->StudentID;
		}
		else{
			$this->_redirect('index');
			
		}
		
		$qry = "select * from students where id='".$studentid."'"; 
		$detail = $db->runQuery($qry); 
		$this->view->detail = $detail[0]; 
		$this->view->StudentID = $studentid;
		
		$modelobj = new Mainmodel();	
		$this->view->showalreadyform= 0;
		
							
		if ($objRequest->isPost()) {	
			$formData = $objRequest->getPost();	
			//echo "<pre>";print_r($formData);exit;	
			if(isset($formData['alradyparent']) && $formData['alradyparent']==1)
			{
			$this->view->showalreadyform= 1;
				if($formalready->isValid($formData)){
					$qry = "select id from guardians where userid in (select id from users where username='".$formData['parent_already_username']."' and schoolid='".$mySession->user['schoolid']."' and usertype='P')";
					$guardian = $db->runQuery($qry);
					if(is_array($guardian) && count($guardian) > 0)
					{
						$data['guardian_id'] = $guardian[0]['id'];
						$condition = "id='".$studentid."'";
						$modelobj->updateThis('students',$data,$condition);
						
						$mySession->sucMsg = LNG_STUDENT_ADDED;
						$this->_redirect('student/profile/studentid/'.$studentid);
					}
				}
			} else {	
				if($form->isValid($formData)){
					//if(1==2) {
					$data = array();
					$data['username'] = $formData['parent_username'];
					$data['schoolid'] = $mySession->user['schoolid'];
					$data['hashed_password'] = md5($formData['parent_password']);
					$data['usertype'] = 'P';
					
					$userid = $modelobj->insertThis('users',$data);
					
					//$Data['ward_id'] 				= 	$studentid;
					
					$Data['first_name'] 			= 	$formData['first_name'];
					$Data['last_name'] 				= 	$formData['last_name'];
					$Data['relation'] 				= 	$formData['relation'];
					/*$Data['dob'] 					= 	changeDate($formData['guardian_dob']);
					$Data['education'] 				= 	$formData['education'];
					$Data['occupation'] 			= 	$formData['occupation'];
					$Data['income'] 				= 	$formData['income'];
					$Data['email'] 					= 	$formData['email']; 
					$Data['office_address_line1'] 	= 	$formData['office_address_line1']; 
					$Data['office_address_line2']   = 	$formData['office_address_line2']; 
					$Data['city'] 					= 	$formData['city'];
					$Data['state'] 					= 	$formData['state'];
					$Data['country_id']	 			= 	$formData['country_id'];
					$Data['office_phone1'] 			=  	$formData['office_phone1'];
					$Data['office_phone2'] 			=  	$formData['office_phone2'];
					$Data['mobile_phone'] 			= 	$formData['mobile_phone'];*/
					$Data['userid'] 				= 	$userid;
					
					$Data['created_at'] 			= 	date('Y-d-m h:m:s');
					$Data['updated_at'] 			= 	date('Y-d-m h:m:s');
					$Data['schoolid']=$mySession->user['schoolid'];
					
								
					$insid = $modelobj->insertThis('guardians',$Data);
					
					$data='';
					$data['guardian_id'] = $insid;
					$condition = "id='".$studentid."'";
					$modelobj->updateThis('students',$data,$condition);
					
					if ($insid) {
						if(is_array($_FILES['parent_id_card']) && $_FILES['parent_id_card']['name']!='') {
							$ftype = $_FILES['parent_id_card']['type'];
							$fname = $_FILES['parent_id_card']['name'];
							
							$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
							
							$uploaddir = 'upload/document/';
							$ext = end(explode(".", $fname));
							$filename = $insid.rand(100,900).'.'.$ext;
							$uploadfile = $uploaddir . $filename;
							
							if (move_uploaded_file($_FILES['parent_id_card']['tmp_name'], $uploadfile)) {
												  
							 $data='';
							  $data['parent_id_card'] = $filename;
							  $condition = "id='".$insid."'";
							  
							  $modelobj->updateThis('guardians',$data,$condition);
							 }
						 }
						 
						$mySession->sucMsg = LNG_STUDENT_ADDED;
						$this->_redirect('student/profile/studentid/'.$studentid);		
					}else{
						$mySession->sucMsg = LNG_STUDENT_NOT_ADDED;
					}
					//}
				}
			}
			
		}
			
	}
	
	public function gaurdiansAction(){
		global $mySession;		
		$objRequest = $this->getRequest();
		$params = $objRequest->getParams();
		
		
			if (isset($params['studentid']) && !empty($params['studentid'])) {
				$studentid = $params['studentid'];
			}elseif (isset($mySession->StudentID) && !empty($mySession->StudentID)) {
				$studentid = $mySession->StudentID;
			}
			else{
				$this->_redirect('index');		
				exit;
			}
		
		$modelobj = new Gaurdian();
		$data = $modelobj->runThisQuery("SELECT CONCAT(first_name,' ',last_name) as GaurdianName FROM guardians WHERE ward_id = '".$studentid."'");
		$this->view->GData = $data;
		$StudentName = $modelobj->runThisQuery("SELECT CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as StudentName 
					FROM students as stu
					LEFT JOIN batches as b ON b.id = stu.batch_id
					LEFT JOIN grades as c ON c.id = b.grade_id WHERE stu.id = '".$studentid."'");
		
		$Student = $StudentName[0]['StudentName'];
		
		$this->view->StudentName = $Student;
		$this->view->StudentID = $studentid;
		
	}
	
	public function previousdataAction()
	{	
		
		global $mySession;		
		$objRequest = $this->getRequest();
		$params = $objRequest->getParams();
		if (isset($params['studentid']) && !empty($params['studentid'])) {
			$studentid = $params['studentid'];
		}elseif (isset($mySession->StudentID) && !empty($mySession->StudentID)) {
			$studentid = $mySession->StudentID;
		}
		else{
			$this->_redirect('index');		
			exit;
		}
		
		$modelobj = new Previousdata();
		
		$objForm = new Form_Previousdata();
		
		if ($objRequest->isPost()) {
			$formData = $objRequest->getPost();
			if ($objForm->isValid($formData)) {
				$Data['student_id'] = $studentid;
				$Data['institution'] = $formData['institute_name'];
				$Data['year'] = $formData['year'];
				$Data['course'] = $formData['course'];
				$Data['total_mark'] = $formData['total_mark'];
				
				$insert = $modelobj->insertThis("student_previous_datas",$Data);
				if ($insert) {
					$mySession->StudentID = $Data['ward_id'];
					$mySession->sucMsg = LNG_STUDENT_ADDED;
					$this->_redirect('student/submitfees/studentid/'.$studentid);	
				}else{
					$mySession->sucMsg = LNG_STUDENT_NOT_ADDED;
				}
			}else{
				$mySession->sucMsg = LNG_STUDENT_NOT_ADDED;
			}
		}
		$this->view->form = $objForm;
		$this->view->StudentID = $studentid;
	}
	public function feescreateAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$this->view->mode = 0;
		
		if ($this->_request->isPost()) {
			if(@$arr['mode']=='add') {
			
				$modelobj = new Mainmodel();
				$Data='';
				
				$Data['catid']= (empty($arr['catlist'])) ? 0 : $arr['catlist'];
				$Data['noofinst']=$arr['noofinst'];
				$Data['createon']=date('Y-m-d h:i:s');
				$Data['updatedon']=date('Y-m-d h:i:s');
				
				$qry="select * from `fees_categories` where id='".$Data['catid']."'";
				$catdetail=$db->runQuery("$qry");
				
				
				$Data['catname']=$catdetail[0]['name'];				
		
				for($i=1; $i <= $arr['noofinst']; $i++) {
					if(!empty($arr['inst_'.$i]))
					{
						$Data['inst'][$i-1]['no']=$i;
						$Data['inst'][$i-1]['inst']=$arr['inst_'.$i].'.00';
						$Data['inst'][$i-1]['dueon']=$arr['duedate_'.$i];
					}
				}
				//$mySession->StudentInst='';
				$mySession->StudentInst[] =$Data;
				$this->view->mode = 1;
			}
		}
		
		$qry="select * from `fees_categories` where is_deleted!='1'";
		$list=$db->runQuery("$qry");
		$this->view->clist=$list;
		
		
	}
	public function feescreatetemplateAction(){
		global $mySession;
		$db=new Db();
		$arr = $this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$studentid = $arr['studentid'];
		$this->view->studentid = $studentid;
		$qry= "select batch_id, CONCAT(first_name,' ',middle_name,' ',last_name) as stname  from students where id='".$studentid."'";
		$stu_info = $db->runQuery($qry); 
		$this->view->stu_info=$stu_info;
		$batchid=$stu_info[0]['batch_id'];
		
		if ($this->_request->isPost()) {
			if(@$arr['mode']=='add') {
				$modelobj = new Mainmodel();	
				$this->view->mode = 1;
				foreach($arr['chk'] as $chk)
				{
					if(strstr($chk,'b_')) {
						$id=str_replace("b_","",$chk);
						$qry = "select * from fees_structurelist where id='".$id."'";
						$list = $db->runQuery($qry);
						$list = $list[0];						
						$qry = "select inst, DATE_FORMAT(dueon,'%M %d, %Y') as dueon, fsid from fees_structuredetail where fsid='".$id."'";
						$listdetail = $db->runQuery($qry);
						
						
					} else {
						$id=str_replace("s_","",$chk);
						
						$list = $mySession->StudentInst[$id];
						$listdetail = $mySession->StudentInst[$id]['inst'];
						
					}
					
					
					$Data='';
					$Data['student_id']= $studentid;
					$Data['catid']= (empty($list['catid'])) ? 0 : $list['catid'];
					$Data['noofinst']= (empty($list['noofinst'])) ? 0 : $list['noofinst'];
					$Data['createon']=date('Y-m-d h:i:s');
					$Data['updatedon']=date('Y-m-d h:i:s');
					
					$fsid = $modelobj->insertThis('fees_student',$Data);
				//	$fsid=4;
					foreach($listdetail as $list) {
						$Data='';
						$Data['fstid']=$fsid;
						$Data['student_id']= $studentid;
						$Data['inst']=$list['inst'];
						$Data['refid']= (empty($list['fsid'])) ? 0 : $list['fsid'];
						$Data['dueon']=changedate($list['dueon']);
						
						$modelobj->insertThis('fees_studentdetail',$Data);
					}
				}
			}
			
		}
		if($this->view->mode) {
			$qry = "select a.*, c.name as catname from fees_student as a left join fees_categories as c on (a.catid=c.id) where a.student_id='".$studentid."'";
			$list = $db->runQuery($qry);
				
			$this->view->slist = $list;
		} else {
			$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
			$list = $db->runQuery($qry);
			if(count($list) < 1) {
				$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='0'";
				$list = $db->runQuery($qry);
			}
			$this->view->slist = $list;
		}
	}
	public function feeseditAction()
	{
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		if($arr['batchid']) { 
			$batchid = $arr['batchid'];
		} else {
			$batchid = 0;
		}
						if($batchid) {
							$qry="select batches.id, concat(grades.code,' - ',batches.name) as batchname from `batches` left join grades on (grades.id=batches.grade_id) where batches.id='".$batchid."'";
							$attend = $db->runQuery("$qry");
							$this->view->batch_id=$batchid;
						} else {
							$attend[0]['id']=0;
							$attend[0]['batchname']='Common';
							$this->view->batch_id=0;
						}
						$this->view->batchdetail=$attend;
		
		$this->view->mode = 0;
		$this->view->batchid = $batchid;
		$this->view->fsid = $arr['fsid'];
		if($arr['fsid']) {
			if ($this->_request->isPost()) {
				if(@$arr['mode']=='update') {
				
					$modelobj = new Mainmodel();
					$Data='';
					
					$Data['catid']= (empty($arr['catlist'])) ? 0 : $arr['catlist'];
					$Data['noofinst']=$arr['noofinst'];
					
					$Data['updatedon']=date('Y-m-d h:i:s');
					
					$condition = "id='".$arr['fsid']."'";
					$modelobj->updateThis('fees_structurelist',$Data,$condition);
					$fsid=$arr['fsid'];
					$delcondition = "fsid='".$arr['fsid']."'";
					$db->delete('fees_structuredetail',$delcondition);
					for($i=1; $i <= $arr['noofinst']; $i++) {
						if(!empty($arr['inst_'.$i]))
						{
							$Data='';
							$Data['fsid']=$fsid;
							$Data['inst']=$arr['inst_'.$i];
							$Data['dueon']=changedate($arr['duedate_'.$i]);
							
							$modelobj->insertThis('fees_structuredetail',$Data);
						}
					}
					$this->view->mode = 1;
					
					$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
					$list = $db->runQuery($qry);
					$this->view->slist = $list;
					
					
				} else {		
					$qry="select * from `fees_categories` where is_deleted!='1'";
					$list=$db->runQuery("$qry");
					$this->view->clist=$list;
					
					$qry="select * from `fees_structurelist` where id='".$arr['fsid']."'";
					$fees=$db->runQuery("$qry");
					$this->view->fees=$fees;
					
					$qry="select *, DATE_FORMAT(dueon, '%M %d, %Y') as dueondt from `fees_structuredetail` where fsid='".$arr['fsid']."' order by dueon";
					$installment=$db->runQuery("$qry");
					$this->view->installment=$installment;
			}
		} 
	  }
	}
	public function addsubjectAction(){
		$objRequest = $this->getRequest();
		$objParam = $objRequest->getParams();
		
		$objSubID = time();
		$return = '
		<div class="label-field-pair">
          <label for="parent_detail_country">Subject</label>
          
            <div class="text-input-bg"> 
            <input type="text" id="subjectname" name="subjectname" value="" >
            
          </div>
		</div>

        <div class="label-field-pair">
          <label for="parent_detail_country">Mark</label>
          
            <div class="text-input-bg"> 
            <input type="text" id="mark" name="mark" value="" >
          </div>
		</div>
		
		<div class="save-proceed-button">
          <input type="button" name="save" id = "save" onclick="javascript:savethis();" value="Add">
		</div>
		';
		
		echo $return;
		exit;
		
	}
	public function savesubjectAction(){
		$objRequest = $this->getRequest();
		$objParam = $objRequest->getParams();
		
		$StudentID = $objParam['sid'];
		$objModel = new Studentpresubject();
		$data['mark'] = $objParam['mark'];
		$data['subject'] = $objParam['subject'];
		$data['student_id'] = $objParam['sid'];
		
		
		$insData = $objModel->insertThis('student_previous_subject_marks',$data);
		if ($insData) {
			$query = "SELECT subject,mark FROM student_previous_subject_marks WHERE student_id = '".$StudentID."'";
			$GatData = $objModel->runThisQuery($query);
			$li="";
			foreach($GatData as $value):
				$subject = $value['subject'];
				$mark = $value['mark'];
				$li .= "<li><span style='width:100px'>".$subject."</span><span style='width:50px;'>".$mark."</span></li>";
			endforeach;
			echo $li;exit;
		}
		
		//student_previous_subject_marks
	}
	
	public function submitfeesAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$studentid = $mySession->StudentID;
		$this->view->studentid = $studentid;
		$qry= "select batch_id from students where id='".$studentid."'"; 
		 $list = $db->runQuery($qry); 
		$batchid=$list[0]['batch_id'];
		if ($this->_request->isPost()) {	
			$formData = $this->_request->getPost();
			$modelobj = new Mainmodel();	
			
			foreach($arr['chk'] as $chk)
			{
				if(strstr($chk,'b_')) {
					$id=str_replace("b_","",$chk);
					$qry = "select * from fees_structurelist where id='".$id."'";
					$list = $db->runQuery($qry);
					$list = $list[0];
					
					$qry = "select inst, DATE_FORMAT(dueon,'%M %d, %Y') as dueon, fsid from fees_structuredetail where fsid='".$id."'";
					$listdetail = $db->runQuery($qry);
					
					
				} else {
					$id=str_replace("s_","",$chk);
					
					$list = $mySession->StudentInst[$id];
					$listdetail = $mySession->StudentInst[$id]['inst'];
					
				}
				
				
				$Data='';
				$Data['student_id']= $studentid;
				$Data['catid']= (empty($list['catid'])) ? 0 : $list['catid'];
				$Data['noofinst']= (empty($list['noofinst'])) ? 0 : $list['noofinst'];
				$Data['createon']=date('Y-m-d h:i:s');
				$Data['updatedon']=date('Y-m-d h:i:s');
				
				$fsid = $modelobj->insertThis('fees_student',$Data);
			//	$fsid=4;
				foreach($listdetail as $list) {
					$Data='';
					$Data['fstid']=$fsid;
					$Data['student_id']= $studentid;
					$Data['inst']=$list['inst'];
					$Data['refid']= (empty($list['fsid'])) ? 0 : $list['fsid'];
					$Data['dueon']=changedate($list['dueon']);
					
					$modelobj->insertThis('fees_studentdetail',$Data);
				}
			}
			$mySession->StudentID ='';
			$mySession->StudentInst = '';
			$mySession->sucMsg = LNG_SCHOOL_ADDED;
			$this->_redirect('student/profile/studentid/'.$studentid);
			
		}
		$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
		$list = $db->runQuery($qry);
		if(count($list) < 1) {
			$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='0'";
			$list = $db->runQuery($qry);
		}
		$this->view->slist = $list;
	}
	
	public function passportAction()
	{	
		global $mySession;		
		$objRequest = $this->getRequest();
		
		$modelobj = new Previousdata();
		
		$objForm = new Form_Previousdata();
		$this->view->form = $objForm;
		//echo "exit";exit;
		/*if (isset($objRequest->isPost())) {
			$formData = $objRequest->getPost();
			if ($objForm->isValid($formData)) {
				$data['student_id'] = $formData['student_id'];			
				$data['institution'] = $formData['institution'];			
				$data['year'] = $formData['year'];			
				$data['course'] = $formData['course'];			
				$data['total_mark'] = $formData['total_mark'];			
				
				$modelobj->insertThis("tudent_previous_datas",$data);
				
				$mySession->sucMsg = "Student admission successfully.";
				$this->_redirect('student/profile/studentid/'.$insid);	
			}			
		}*/	
	}
	
	public function previousdataeditAction()
	{	
		global $mySession;		
		$objRequest = $this->getRequest();
		$params = $objRequest->getParams();
		if (isset($params['studentid']) && !empty($params['studentid'])) {
			$studentid = $params['studentid'];
		}elseif (isset($mySession->StudentID) && !empty($mySession->StudentID)) {
			$studentid = $mySession->StudentID;
		}
		else{
			$this->_redirect('index');		
			exit;
		}
		$this->view->studentid = $studentid;
		$modelobj = new Previousdata();
		$db = new Db();
		$qry = "select * from student_previous_datas where student_id='".$params['studentid']."'";
		$dataarray = $db->runQuery($qry);
		$data = @$dataarray[0];
		$objForm = new Form_Previousdata($data);
		
		if ($objRequest->isPost()) {
			$formData = $objRequest->getPost();
			if ($objForm->isValid($formData)) {
				$Data['student_id'] = $studentid;
				$Data['institution'] = $formData['institute_name'];
				$Data['year'] = $formData['year'];
				$Data['course'] = $formData['course'];
				$Data['total_mark'] = $formData['total_mark'];
				
				if(count($dataarray) > 0) {
					$condition = "student_id ='".$studentid."'";
					$insert = $modelobj->updateThis("student_previous_datas",$Data,$condition);
				} else {
					$insert = $modelobj->insertThis("student_previous_datas",$Data);
				}
				if ($insert) {
					$mySession->StudentID = $Data['ward_id'];
					$mySession->sucMsg = "Student admission successfully.";
					$this->_redirect('student/profile/studentid/'.$studentid);	
				}else{
					$mySession->sucMsg = LNG_STUDENT_NOT_ADDED;
				}
			}else{
				$mySession->sucMsg = LNG_STUDENT_NOT_ADDED;
			}
		}
		$this->view->form = $objForm;
		$this->view->StudentID = $studentid;
			
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
	
	public function changetoformerAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if (isset($arr['studentid'])) {
			if (isset($arr['mode']) && $arr['mode']=='former') {				
				
				$qry="select * from students where id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'";
				$formData = $db->runQuery($qry);
				$formData =$formData[0] ;
				
				$Data['admission_no'] = $formData['admission_no'];
				$Data['studentid'] = $formData['id'];
				$Data['schoolid'] = $formData['schoolid'];
				$Data['passport_or_id'] = $formData['passport_or_id'];
				$Data['student_passport_no'] = $formData['student_passport_no'];
				$Data['class_roll_no'] = $formData['class_roll_no'];
				$Data['admission_date'] = $formData['admission_date'];
				$Data['title'] = $formData['title'];
				$Data['first_name'] = $formData['first_name'];
				$Data['middle_name'] = $formData['middle_name'];
				$Data['last_name'] = $formData['last_name'];
				$Data['batch_id'] = $formData['batch_id'];
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
				$Data['is_active'] = $formData['is_active'];
				$Data['student_illness'] = $formData['student_illness'];				
				
				$modelobj = new Mainmodel();
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
				
				$mySession->sucMsg = LNG_STUDENT_REMOVED_SUCCESSFULLY;
				$this->_redirect('user/dashboard');
				exit;
			}
			 $qry="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, 
				stu.admission_no, b.name as batchname, c.grade_name
				FROM `students` as stu
				LEFT JOIN batches as b ON b.id = stu.batch_id
				LEFT JOIN grades as c ON c.id = b.grade_id 
				WHERE stu.id='".$arr['studentid']."'";
				
				$studentdetail=$db->runQuery($qry);
			$this->view->studentdetail=$studentdetail[0];
		}
	}
	
	
	public function destroyAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		
		if(isset($arr['studentid']) && ($mySession->user['usertype']=='S' || $mySession->user['usertype']=='T')) {
			$chkres = $db->runQuery("select id from students where id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'");
			if(is_array($chkres) && count($chkres) > 0) {
				$wherercondition = "id in (select userid from employees where id='".$arr['profileid']."')";
				$db->delete('users',$wherercondition);
				
				$wherercondition = "student_id='".$arr['studentid']."'";
				$db->delete('attendances',$wherercondition);
				
				$wherercondition = "student_id='".$arr['studentid']."'";
				$db->delete('exam_scores',$wherercondition);
						
				$wherercondition = "id='".$arr['studentid']."'";
				$db->delete('students',$wherercondition);
				
				$mySession->sucMsg = 'Student deleted successfully';
				$this->_redirect('user/dashboard');
				
			} else {
				$this->_redirect('index');
				exit;
			}
		} else {
			$this->_redirect('index');
			exit;
		}
	}
	
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
				
		$this->view->studentid=$arr['studentid'];
			$qry="select *, DATE_FORMAT(date_of_birth,'%M %d, %Y') as dob, DATE_FORMAT(admission_date,'%M %d, %Y') as doa from `students` where id='".$arr['studentid']."'";	
			
			$detail=$db->runQuery("$qry");
			$data=$detail[0];
			$data['editmode'] = 1;
			
		$form = new Form_Admission($data);
		
		$this->view->form = $form;
		$objRequest = $this->getRequest();
		if($objRequest->isPost()) {	
			$formData = $objRequest->getPost();	
			//$formData = $this->_request->getPost();	
			//echo "<pre>";pr($_FILES);print_r($formData);exit;	
			//$formData['student_photo'] = $_FILES['student_photo'];
			//$formData['birth_certificate'] = $_FILES['birth_certificate'];
			//echo "jjj".$form->isValid($formData);
				//echo "ttttt";
			//	exit;
			if($form->isValid($formData)){
				$formData = $this->_request->getPost();	
					
				$Data['admission_no'] = $formData['student_admission_no'];
				$Data['class_roll_no'] = '';
				$Data['admission_date'] = changedate($formData['admission_date']);
				$Data['passport_or_id'] = $formData['passport_or_id'];
				$Data['student_passport_no'] = $formData['student_passport_no'];
				$Data['title'] = $formData['title'];
				$Data['first_name'] = $formData['first_name'];
				$Data['middle_name'] = $formData['middle_name'];
				$Data['last_name'] = $formData['last_name'];
				$Data['nationality_id'] = $formData['student_nationality'];
				$Data['batch_id'] = $formData['student_batch_id'];
				$Data['date_of_birth'] = changedate($formData['date_of_birth']);
				$Data['student_illness'] = $formData['student_illness'];
				$Data['religion'] = $formData['student_religion'];
				$Data['address_line1'] = $formData['student_address_line1'];
				$Data['phone1'] = $formData['student_phone1'];		
				
				$modelobj = new Mainmodel();
				$condition="id='".$arr['studentid']."'";
				$modelobj->updateThis('students',$Data,$condition);
				
				if(is_array($_FILES['student_photo']) && $_FILES['student_photo']['name']!='') {
					$ftype = $_FILES['student_photo']['type'];
					$fname = $_FILES['student_photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/photo/';
					$ext = end(explode(".", $fname));
					$filename = $arr['studentid'].rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['student_photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['photo_file_name'] = $filename;
					  $condition = "id='".$arr['studentid']."'";
					  
					  $modelobj->updateThis('students',$data,$condition);
					 }
				 }
				 
				if(is_array($_FILES['birth_certificate']) && $_FILES['birth_certificate']['name']!='') {
					$ftype = $_FILES['birth_certificate']['type'];
					$fname = $_FILES['birth_certificate']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/document/';
					$ext = end(explode(".", $fname));
					$filename = $arr['studentid'].rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					
					if (move_uploaded_file($_FILES['birth_certificate']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['birth_certificate'] = $filename;
					  $condition = "id='".$arr['studentid']."'";
					  
					  $modelobj->updateThis('students',$data,$condition);
					 }
				 }
				
					$mySession->sucMsg = LNG_STUDENT_UPDATED;
					$this->_redirect('student/profile/studentid/'.$arr['studentid']);
				
					
			}
			
		}
		
	}
	
	
	public function reportsAction()
	{	
	global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($mySession->user['usertype']=='P'){
			if(!in_array($arr['studentid'],$mySession->user['userstudentid'])) {
				$this->_redirect('index');		
				exit;
			}
		}
		if($arr['studentid']) {
		  $this->view->studentid = $arr['studentid'];
			$qry = "select batch_id from students where schoolid = '".$mySession->user['schoolid']."' and id='".$arr['studentid']."'";
			$res = $db->runQuery($qry);
			if(is_array($res) && count($res) > 0) {
				$qry = "select * from exam_groups where batch_id = '".$res[0]['batch_id']."'";
				$recentexam = $db->runQuery($qry);
				$this->view->recentexam = $recentexam;
				
				$qry = "select s.name, s.code, s.id from subjects as s where s.id in (select subject_id from exams where exam_group_id in (select id from exam_groups where batch_id = '".$res[0]['batch_id']."'))";
				
				$examsubject = $db->runQuery($qry);
				$this->view->examsubject = $examsubject;
			} else {
				$this->_redirect('index');		
				exit;
			}
		} else {
			$this->_redirect('index');		
			exit;
		}
	}
	
	public function searchajaxAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		if(isset($arr['query']) && $arr['query']!='')
		{
			$where = '';
			if($arr['option']=='active') {
				$status = 1;
			} else {
				$status = 0;
			}
			$where .= " and (s.first_name like '%".$arr['query']."%' or 
						s.middle_name like '%".$arr['query']."%' or 
						s.last_name like '%".$arr['query']."%' or
						s.admission_no = '".$arr['query']."' or 
						s.passport_or_id = '".$arr['query']."') 
						";
			$where .= " and s.is_active='".$status."'";
			$qry="select s.id, concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name, concat(g.code,' - ',b.name) as batchname, s.admission_no from `students` as s Left Join `batches` as b on(s.batch_id=b.id) left join grades as g on (b.grade_id=g.id) where s.schoolid='".$mySession->user['schoolid']."' ".$where;		
			$studentlist=$db->runQuery("$qry");
			
			$this->view->studentlist=$studentlist;
			
		}
			
		$this->_helper->layout()->setLayout('ajaxlayout');			
	}
	
	
	public function addguardianAction()
	{	
		global $mySession;
		$form = new Form_Addguardian();		
		$this->view->form = $form;
		
		/*if ($objRequest->isPost()) 
		{	
			$formData = $objRequest->getPost();	
				
			if($form->isValid($formData))
			{
				$formData = $this->_request->getPost();
				
				$Data['first_name'] = $formData['parent_first_name'];
				$Data['last_name'] = $formData['parent_last_name'];
				$Data['relation'] = $formData['parent_detail_relation'];
				$Data['dob'] = $formData['parent_detail_dob'];
				$Data['education'] = $formData['parent_detail_education'];
				$Data['occupation'] = $formData['parent_detail_occupation'];
				$Data['income'] = $formData['parent_detail_income'];
				$Data['email'] = $formData['parent_detail_email'];
				$Data['office_address_line1'] = $formData['office_address_line1'];
				$Data['office_address_line2'] = $formData['office_address_line2'];
				$Data['city'] = $formData['parent_detail_city'];
				$Data['state'] = $formData['parent_detail_state'];
				$Data['country_id'] = $formData['parent_detail_country'];
				$Data['office_phone1'] = $formData['office_phone1'];
				$Data['office_phone2'] = $formData['office_phone2'];
				$Data['mobile_phone'] = $formData['mobile_phone'];
				$Data['schoolid']=$mySession->user['schoolid'];
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('guardians',$Data);
				if ($insid) {
					$mySession->sucMsg = "Student admission successfully.";
					$this->_redirect('student/addguardian/studentid/'.$studentid);		
				}
			}
		}*/	
	}
	
	public function editguardianAction()
	{	
		global $mySession;		
		
		$db=new Db();
			
		$objRequest = $this->getRequest();
		$params = $objRequest->getParams();
		if (isset($params['studentid']) && !empty($params['studentid'])) {
			$studentid = $params['studentid'];
		} else{
			$this->_redirect('index');
			exit;
		}
		
		$this->view->StudentID = $studentid;
		//$modelobj = new Mainmodel();
		
			
		$qry="select g.*, u.username
		from `guardians` as g 
		left join users as u on (u.id=g.userid) 
		where g.id in (select guardian_id from students where id='".$studentid."')";	
			$detail=$db->runQuery("$qry");
			if(is_array($detail) && count($detail) > 0) {
				$data=$detail[0];
			} else {
				$data = array();
				$formalready = new Form_Admission21();		
				$this->view->formalready = $formalready;
				$this->view->viewalreadyform= 1;
			}

		$form = new Form_Admission2($data);
		$this->view->form = $form;
		$this->view->showalreadyform= 0;
		
		$qry="select admission_no from `students` where id='".$studentid."'";	
		$studentdetail=$db->runQuery("$qry");
			
		$this->view->detail = $studentdetail[0]; 	
				
	
		if ($objRequest->isPost()) {	
		$modelobj = new Mainmodel();
		
			$formData = $objRequest->getPost();	
			if(isset($formData['alradyparent']) && $formData['alradyparent']==1)
			{
				$this->view->showalreadyform= 1;
				if($formalready->isValid($formData)){
					$qry = "select id from guardians where userid in (select id from users where username='".$formData['parent_already_username']."' and schoolid='".$mySession->user['schoolid']."' and usertype='P')";
					$guardian = $db->runQuery($qry);
					if(is_array($guardian) && count($guardian) > 0)
					{
						$data='';
						$data['guardian_id'] = $guardian[0]['id'];
						$condition = "id='".$studentid."'";
						$modelobj->updateThis('students',$data,$condition);
						
						$mySession->sucMsg = LNG_STUDENT_GUARDIAN_DETAIL_UPDATED;
						$this->_redirect('student/guardians/studentid/'.$studentid);
						exit;
					}
				}
			} else {
				if($form->isValid($formData)){
					
					
					
					$userData = array();
					$Data = array();
					
					$userData['username'] 				= 	$formData['parent_username'];
					if($formData['parent_password']) {
						$userData['hashed_password'] 		= 	md5($formData['parent_password']);
					}
					if(@$formData['hid_userid']) {
						$condition = "id='".$formData['hid_userid']."'";
						$insid = $modelobj->updateThis('users',$userData,$condition);
					} else {
						$userData['usertype'] 		= 	'P';
						$insid = $modelobj->insertThis('users',$userData);
						$Data['userid'] 			= 	$insid;
					}
					
					$Data['first_name'] 			= 	$formData['first_name'];
					$Data['last_name'] 				= 	$formData['last_name'];
					$Data['relation'] 				= 	$formData['relation'];					
					$Data['created_at'] 			= 	date('Y-d-m h:m:s');
					$Data['updated_at'] 			= 	date('Y-d-m h:m:s');
					$Data['schoolid'] 				=   $mySession->user['schoolid'];
					
					if(@$formData['hid_id']) {
						$condition = "id='".$formData['hid_id']."'";
						$modelobj->updateThis('guardians',$Data,$condition);
					} else {
						
						$insid = $modelobj->insertThis('guardians',$Data);
						$data='';
						$data['guardian_id'] = $insid;
						$condition = "id='".$studentid."'";
						$modelobj->updateThis('students',$data,$condition);
					}				
					
					
					$mySession->sucMsg = LNG_STUDENT_GUARDIAN_DETAIL_UPDATED;
					$this->_redirect('student/guardians/studentid/'.$studentid);		
				
				}
		    }
		}
	}
	public function parentliststudentAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$wherecondition = '';
		
		$studentids = implode(",",$mySession->user['userstudentid']);
		$wherecondition .= " and id in (".$studentids.")";
		
		$qry="select * from `students` where schoolid='".$mySession->user['schoolid']."' ".$wherecondition;	
		
		$studentlist=$db->runQuery("$qry");
		$this->view->studentlist=$studentlist;		
		
	}
	
	public function studentmarksAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		
		if(!isset($arr['studentid'])) {
			$arr['studentid'] = $mySession->user['userstudentid'][0];
		}	
		$this->view->studentid = $arr['studentid'];			
		if(count($mySession->user['userstudentid']) > 1) {
			
			$wherecondition = '';		
			$studentids = implode(",",$mySession->user['userstudentid']);
			$wherecondition .= " and id in (".$studentids.")";
			
			$qry="select * from `students` where schoolid='".$mySession->user['schoolid']."' ".$wherecondition;			
			$studentlist=$db->runQuery("$qry");
			$this->view->studentlist=$studentlist;
			
		}
			if($mySession->user['usertype']=='P'){
				if(!in_array($arr['studentid'],$mySession->user['userstudentid'])) {
					$this->_redirect('index');		
					exit;
				}
			}
			$qry="SELECT stu.id as stuid, stu.admission_no, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, b.id as batchid, b.name as batchname, 
					UNIX_TIMESTAMP(b.sec_sem_start_date) AS secondsem, DATE_FORMAT(b.start_date,'%Y') as sem1_start, c.grade_name
					FROM `students` as stu							
					LEFT JOIN batches as b ON b.id = stu.batch_id
					LEFT JOIN grades as c ON c.id = b.grade_id 
					WHERE stu.id='".$arr['studentid']."' and stu.schoolid='".$mySession->user['schoolid']."'";
			$studentdetail=$db->runQuery($qry);
			$this->view->studentdetail=$studentdetail[0];
			
			$qry = "select ars.studentid as studentid, ars.batch_id as batchid, DATE_FORMAT(b.start_date,'%Y') as sem1_start from `archive_students` as ars left join `batches` as b on (ars.batch_id=b.id) where ars.admission_no='".$studentdetail[0]['admission_no']."' and ars.schoolid='".$mySession->user['schoolid']."' order by b.start_date desc";
			$olddetail=$db->runQuery($qry);
			$this->view->olddetail=$olddetail;
			
			/*---for batch id---*/
			
			if($arr['year']){
				$this->view->year = $arr['year'];
			}else{
				$this->view->year = $studentdetail[0]['sem1_start'];
			}
			
			$is_old = 0;
			if($studentdetail[0]['sem1_start']==$this->view->year){
				$thisbatch = $studentdetail[0]['batchid'];
			} else {
				foreach($olddetail as $old){
					if($old['sem1_start']==$this->view->year){
						$thisbatch = $old['batchid'];
						$stuid = $old['studentid'];
						$is_old = 1;
					}		
				}
			}				
				$qry = "select *, UNIX_TIMESTAMP(sec_sem_start_date) as secondsem from `batches` where id='".$thisbatch."' ";
				$batches = $db->runQuery($qry);				
			if($arr['semno']){
				$this->view->semno = $arr['semno'];						
			}else{ 				
				
				if(time() >= $batches[0]['secondsem']){
					$this->view->semno = 2;
				} else {
					$this->view->semno = 1;
				}
				$arr['semno'] = $this->view->semno;
							
			}
			//echo $this->view->year."---".$this->view->batchid;
			
			
			if(is_array($studentdetail) && count($studentdetail) > 0)
				{
				
					$qry="select Group_concat(exam_group_id) as ids from `grouped_exams` where batch_id ='".$thisbatch."' and schoolid='".$mySession->user['schoolid']."'"; 
					$groupedexams = $db->runQuery($qry);
				
					if(is_array($groupedexams) && count($groupedexams) > 0 && @$groupedexams[0]['ids']!='') {
						$where = " and id in (".$groupedexams[0]['ids'].")";
					} else {
						$where = " and batch_id ='".$thisbatch."' and schoolid='".$mySession->user['schoolid']."'";
					}
					$qry="select * from `exam_groups` where result_published='1' and is_published='1' ".$where;					
					$examgroup = $db->runQuery($qry);
					$this->view->examgroup = $examgroup;
					
					$exid = array();
					foreach($examgroup as $eg) {
						$exid[] = $eg['id'];
					}
					if(is_array($exid) && count($exid) > 0) {
					$exids = implode(",",$exid);
					
					$qry="select id, name, code from `subjects` where id in(select subject_id from exams where exam_group_id in (".$exids."))";
					$subjects = $db->runQuery($qry);
					$this->view->subjects = $subjects;
					
					if($arr['semno']==1)
					{
						$sem_condition = " and e.start_time >= '".$batches[0]['start_date']."' and end_time < '".$batches[0]['sec_sem_start_date']."' ";
					} else {
						$sem_condition = " and e.start_time >= '".$batches[0]['sec_sem_start_date']."' and end_time <= '".$batches[0]['end_date']."' ";
					}
					
					if($is_old==0){
						$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$arr['studentid']."' ".$sem_condition." order by e.subject_id";
					} else {
						$qry="select es.*, es.arc_student_id as studentid, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `archive_exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$stuid."' ".$sem_condition." order by e.subject_id";
					}
						$examscoreresult = $db->runQuery($qry);
						foreach($examscoreresult as $es) {
							$examscore[$es['subject_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['marks'] = $es['marks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
						}
						$this->view->examscore = $examscore;
					
						if($is_old==0){	
							$qry = "select * from `generate_final_score` where schoolid='".$mySession->user['schoolid']."' and student_id='".$arr['studentid']."' and batchid='".$thisbatch."' and sem_id='".$arr['semno']."' ";
							$score_total = $db->runQuery($qry);
							$this->view->score_total = $score_total[0];
							
							$stu_rank = "select count(id) as cnt from `generate_final_score` where schoolid='".$mySession->user['schoolid']."' and batchid='".$thisbatch."' and stu_obt_marks > '".$score_total[0]['stu_obt_marks']."' and sem_id='".$arr['semno']."' ";
							$stu_rank = $db->runQuery($stu_rank);
							$this->view->stu_rank = $stu_rank[0];
							
							
						} else {
							$qry = "select * from `generate_final_score` where schoolid='".$mySession->user['schoolid']."' and student_id='".$stuid."' and batchid='".$thisbatch."' and sem_id='".$arr['semno']."' ";
							$score_total = $db->runQuery($qry);
							$this->view->score_total = $score_total[0];
						}
						
					}
					
				}
	}
	
	public function liststudentsbyclassAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$wherecondition = '';
		
		if (!empty($arr['search_batchid'])) {
			$wherecondition .= " and s.batch_id='".$arr['search_batchid']."'";
		} elseif(!empty($arr['search_gradeid'])) {
			$wherecondition .= " and s.batch_id in (select id from batches where grade_id='".$arr['search_gradeid']."' and start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
		} elseif(!empty($arr['search_year']))
		{
			$wherecondition .= " and s.batch_id in (select id from batches where start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
		}
		if (!empty($arr['search_religion'])) {
			$wherecondition .= " and s.religion='".$arr['search_religion']."'";
		}
		if (!empty($arr['search_keyword'])) {
			$wherecondition .= " and (s.first_name like '%".$arr['search_keyword']."%' or 
						s.middle_name like '%".$arr['search_keyword']."%' or 
						s.last_name like '%".$arr['search_keyword']."%' or
						s.admission_no = '".$arr['search_keyword']."' or 
						s.passport_or_id = '".$arr['search_keyword']."') 
						";
		}
		$qry="select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as sname, s.admission_no, b.name as bname, g.grade_name as gname, DATE_FORMAT(b.start_date, '%Y') as batch_yr from `students` as s left join batches as b on (s.batch_id=b.id) left join grades as g on (g.id=b.grade_id) where s.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;	
		
		$studentlist=$db->runQuery("$qry");
		$this->view->studentlist=$studentlist;
		
		$qry="select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as sname, s.admission_no, b.name as bname, g.grade_name as gname, DATE_FORMAT(b.start_date, '%Y') as batch_yr from `archive_students` as s left join batches as b on (s.batch_id=b.id) left join grades as g on (g.id=b.grade_id) where s.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;
		
		$alumnistudentlist=$db->runQuery("$qry");
		$this->view->alumnistudentlist=$alumnistudentlist;
		
		$this->_helper->layout()->setLayout('ajaxlayout');		
	}
	public function advancesearchlistAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$wherecondition = '';
		
		if (!empty($arr['search_batchid'])) {
			$wherecondition .= " and s.batch_id='".$arr['search_batchid']."'";
		} elseif(!empty($arr['search_gradeid'])) {
			$wherecondition .= " and s.batch_id in (select id from batches where grade_id='".$arr['search_gradeid']."' and start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
		} elseif(!empty($arr['search_year']))
		{
			$wherecondition .= " and s.batch_id in (select id from batches where start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
		}
		if (!empty($arr['student_passport_no'])) {
			$wherecondition .= " and s.student_passport_no like '%".$arr['student_passport_no']."%'";
		}
		if (!empty($arr['title'])) {
			$wherecondition .= " and s.religion='".$arr['title']."'";
		}
		if (!empty($arr['first_name'])) {
			$wherecondition .= " and (s.first_name like '%".$arr['first_name']."%' or s.middle_name like '%".$arr['first_name']."%' or s.last_name like '%".$arr['first_name']."%')";
		}
		if (!empty($arr['student_admission_no'])) {
			$wherecondition .= " and s.admission_no like '%".$arr['student_admission_no']."%'";
		}
		if (!empty($arr['student_nationality'])) {
			$wherecondition .= " and s.nationality_id='".$arr['student_nationality']."'";
		}
		if (!empty($arr['search_religion'])) {
			$wherecondition .= " and s.religion='".$arr['search_religion']."'";
		}
		if (!empty($arr['student_address_line1'])) {
			$wherecondition .= " and (s.address_line1 like '%".$arr['student_address_line1']."%' or s.address_line2 like '%".$arr['student_address_line1']."%' s.city like '%".$arr['student_address_line1']."%') ";
		}
		if(!empty($arr['admission_date']) && !empty($arr['admission_date_to'])) {
			$wherecondition .= " and s.admission_date >= '".changedate($arr['admission_date'])."' and s.admission_date <= '".changedate($arr['admission_date_to'])."'";
		} elseif(!empty($arr['admission_date'])) {
			$wherecondition .= " and s.admission_date >='".changedate($arr['admission_date'])."'";
		} elseif(!empty($arr['admission_date_to'])) {
			$wherecondition .= " and s.admission_date < '".changedate($arr['admission_date_to'])."'";
		}
		
		if(!empty($arr['date_of_birth']) && !empty($arr['date_of_birth_to'])) {
			$wherecondition .= " and s.date_of_birth >= '".changedate($arr['date_of_birth'])."' and s.date_of_birth <= '".changedate($arr['date_of_birth_to'])."'";
		} elseif(!empty($arr['date_of_birth'])) {
			$wherecondition .= " and s.date_of_birth >='".changedate($arr['date_of_birth'])."'";
		} elseif(!empty($arr['date_of_birth_to'])) {
			$wherecondition .= " and s.date_of_birth < '".changedate($arr['date_of_birth_to'])."'";
		}
		$this->view->wherecondition=$wherecondition;
		$qry="select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as sname, s.admission_no, b.name as bname, g.grade_name as gname from `students` as s left join batches as b on (s.batch_id=b.id) left join grades as g on (g.id=b.grade_id) where s.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;	
		
		$studentlist=$db->runQuery("$qry");
		$this->view->studentlist=$studentlist;
		
				
	}
	public function profileAction()
	{	
		global $mySession;	
		$objRequest = $this->getRequest();
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		$params = $objRequest->getParams();
		if (isset($params['studentid']) && !empty($params['studentid'])) {
			$studentid = $params['studentid'];
		}elseif (isset($mySession->StudentID) && !empty($mySession->StudentID)) {
			$studentid = $mySession->StudentID;
		}
		else{
			$this->_redirect('index');		
			exit;
		}
		if($mySession->user['usertype']=='P'){
			if(!in_array($studentid,$mySession->user['userstudentid'])) {
				$this->_redirect('index');		
				exit;
			}
		}
		$this->view->SrudentID = $studentid;
		//$objModel = new Gaurdian();
		
		if (isset($studentid) && !empty($studentid)) {
			$qry="SELECT stu.*, CONCAT(guard.first_name) as Gaurdian, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt, stpre.institution, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id
			LEFT JOIN student_previous_datas as stpre ON stpre.student_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";
			
			$studentdetail=$db->runQuery($qry);
			
			$this->view->studentdetail=$studentdetail[0];
		}
		
	}
	
	public function showpreviousdetailsAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		$qry="SELECT stu.id, stpre.institution, stpre.year, stpre.course, stpre.total_mark, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as name, admission_no
			FROM `students` as stu
			LEFT JOIN student_previous_datas as stpre ON stpre.student_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";
			$studentdetail=$db->runQuery($qry);
			$this->view->studentdetail=$studentdetail[0];
	}
	
	
	public function feesstructureAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$studentid = $arr['studentid'];
		$this->view->studentid=$studentid;
		if ($this->_request->isPost()) {	
			$formData = $this->_request->getPost();
			$modelobj = new Mainmodel();	
			
			
			$s=0;
			$already = array();
			foreach($arr['chk'] as $chk)
			{
				if(strstr($chk,'b_')) {
					$id=str_replace("b_","",$chk);
					$already[] = $id;				
					
				} else {
					$id=str_replace("s_","",$chk);
					
					$listnew[$s] = $mySession->StudentInst[$id];
					$listnewdetail[$s] = $mySession->StudentInst[$id]['inst'];
					$s++;
					
				}	
				
			}
			
			if(count($already) > 0) {
				$ids = implode(",",$already);
				$condition = "id not in (".$ids.") and `student_id`='".$studentid."'";
				$db->delete('fees_student',$condition);
				
				$condition = "fstid not in (".$ids.") and `student_id`='".$studentid."'";
				$db->delete('fees_studentdetail',$condition);
			}
			
			$s=0;
			foreach($listnew as $lista) {
				$Data='';
				$Data['student_id']= $studentid;
				$Data['catid']= (empty($lista['catid'])) ? 0 : $lista['catid'];
				$Data['noofinst']= (empty($lista['noofinst'])) ? 0 : $lista['noofinst'];
				$Data['createon']=date('Y-m-d h:i:s');
				$Data['updatedon']=date('Y-m-d h:i:s');
				
				$fsid = $modelobj->insertThis('fees_student',$Data);
			//	$fsid=4;
				foreach($listnewdetail[$s] as $list) {
					$Data='';
					$Data['fstid']=$fsid;
					$Data['student_id']= $studentid;
					$Data['inst']=$list['inst'];
					$Data['refid']= (empty($list['fsid'])) ? 0 : $list['fsid'];
					$Data['dueon']=changedate($list['dueon']);
					
					$modelobj->insertThis('fees_studentdetail',$Data);
				}
			}
				
			$mySession->StudentInst = '';
			$mySession->sucMsg = LNG_FEES_STRUCTURE_UPDATED;
			$this->_redirect('student/profile/studentid/'.$studentid);
			
		}
		
		
		$qry= "select batch_id from students where id='".$studentid."'"; 
		$list = $db->runQuery($qry); 
		$batchid=$list[0]['batch_id'];
		
		$qry = "select a.*, c.name as catname from fees_student as a left join fees_categories as c on (a.catid=c.id) where a.student_id='".$studentid."'";
		$list = $db->runQuery($qry);
			
		$this->view->slist = $list;
		
		$inst="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt 
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";
		
		$cb=$db->runQuery($inst);
		$this->view->cb=$cb[0];
	}
	
	public function feesreportAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$studentid = $arr['studentid'];
		
		$inst="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt 
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";
		
		$cb=$db->runQuery($inst);
		$this->view->cb=$cb[0];
		
		$qry = "select a.*, DATE_FORMAT(dueon, '%M %d, %Y') as dueondt, c.name as catname from fees_studentdetail as a left join fees_student as b on (a.fstid=b.id) left join fees_categories as c on (b.catid=c.id) where a.student_id='".$studentid."' and paystatus='0' order by a.dueon";
		$stfees=$db->runQuery($qry);
		$this->view->stfees=$stfees;
		
		$qry = "select trd.*, tr.trdate, tr.receipno, tr.penalty, DATE_FORMAT(tr.trdate, '%M %d, %Y') as payondt, c.name as catname, fs.catid from fees_transactiondetail as trd left join fees_transaction as tr on (trd.trid=tr.id) left join fees_structurelist as fs on (trd.fst_inst_id=fs.id) left join fees_categories as c on (fs.catid=c.id) where trd.student_id='".$studentid."' order by tr.trdate";
		$paidfees=$db->runQuery($qry);
		$this->view->paidfees=$paidfees;
		
	}
	
	public function payfeesAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$studentid = $arr['studentid'];
		$this->view->studentid = $studentid;
		$dt = date('Y-m-d',mktime(0,0,0, date('m'),date('d')+10, date('Y')));
		if ($this->_request->isPost()) {
		
			$formData = $this->_request->getPost();
			$modelobj = new Mainmodel();
			if($arr['receiptno']) {
				if(is_array($arr['chk']) && count($arr['chk']) > 0) {
					
					$Data='';
					
					$Data['student_id']= $arr['studentid'];
					$Data['trdate']=date('Y-m-d h:i:s');
					$Data['receipno']= (empty($arr['receiptno'])) ? 0 : $arr['receiptno'];
					$Data['penalty']= (empty($arr['panalty_amount'])) ? 0 : $arr['panalty_amount'];
					
					$insid = $modelobj->insertThis('fees_transaction',$Data);
					
					foreach($arr['chk'] as $chk) {
						$Data='';
						$Data['student_id']= $arr['studentid'];
						$Data['trid']= $insid;
						$Data['fst_inst_id']= $arr['fstid'.$chk];
						$Data['fst_inst_detail_id']= $chk;
						$Data['inst']=$arr['inst'.$chk];
						//echo"<pre>";print_r($Data);
						$insid = $modelobj->insertThis('fees_transactiondetail',$Data);
						
						$Data='';
						$Data['paystatus']= 1;
						$Data['payon']=date('Y-m-d h:i:s');
						$Data['receiptno']=(empty($arr['receiptno'])) ? 0 : $arr['receiptno'];
						$Data['trno']=$insid;
						//prd($Data);
						$wherecondition = "id='".$chk."'";
						$modelobj->updateThis('fees_studentdetail',$Data,$wherecondition);
						
						$mySession->sucMsg = "Installment paid successfully.";
					    $this->_redirect('student/profile/studentid/'.$arr['studentid']);
						
					}
				} else {
					$mySession->warningMsg = "Please select atleast one installment to pay.";
				}
			} else {
				$mySession->warningMsg = "Please fill the local receipt no.";
			}			
		}
		
		$inst="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt 
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";		
		$cb=$db->runQuery($inst);
		$this->view->cb=$cb[0];	
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, b.name as bname, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.schoolid ='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batch=$db->runQuery("$qry");		
		$this->view->batch=$batch[0];		
		
		$qry = "select a.*, c.name as catname from fees_studentdetail as a left join fees_student as b on (a.fstid=b.id) left join fees_categories as c on (b.catid=c.id) where a.student_id='".$studentid."' and a.dueon < '".$dt."' and a.paystatus=0";		
		$stfees=$db->runQuery($qry);
		$this->view->stfees=$stfees;
		
	}
	
	public function guardiansAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($mySession->user['usertype']=='P') {
			$studentid = $mySession->user['userstudentid'][0];
		} else {
			$studentid = $arr['studentid'];
		}
		 $qry="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, u.username, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.id = stu.guardian_id
			LEFT JOIN users as u ON guard.userid = u.id
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id 
			WHERE stu.id='".$studentid."' and stu.schoolid='".$mySession->user['schoolid']."'";	
			//exit;
			$studentdetail=$db->runQuery($qry);
			//echo "<pre>";
			//print_r($studentdetail);
		$this->view->studentdetail=$studentdetail[0];
		
	}
	
	public function categoriesAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$form = new Form_AddCategory();		
		$this->view->form = $form;
		$db = new Db();
		//$form = new Form_Login();
		
		//$this->view->loginform = $form;
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();
			
			$Data['name']=$formData['student_category_name'];
			
			$modelobj = new Mainmodel();
			$modelobj->insertThis('student_categories',$Data);
			
			$mySession->sucMsg=LNG_STUDENT_CATEGORY_SAVED;
			$this->_redirect('student/categories');
		}
		$qry="select * from `student_categories` ";		
		$list=$db->runQuery("$qry");
		
		$this->view->clist=$list; 
		 
	}
	
	public function categorydeleteAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if ($arr['catid']) {
		$condition = "id='".$arr['catid']."'";
				
				$db->delete('student_categories',$condition);
				$mySession->sucMsg=LNG_STUDENT_CATEGORY_DELETED;
		}
		
				$this->_redirect('student/categories');
	}
	
	public function categoryeditAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		
		if ($arr['catid']) {
			$qry="select * from `student_categories` where id='".$arr['catid']."' ";		
			$detail=$db->runQuery("$qry");
			$this->view->detail = $detail;
			
			$form = new Form_AddCategory($detail[0]);		
			$this->view->form = $form;
			$db = new Db();
			
			if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();
				
				$Data['name']=$formData['student_category_name'];
				
				$condition = "id='".$arr['catid']."'";
				$modelobj = new Mainmodel();
				$modelobj->updateThis('student_categories',$Data,$condition);
				
				$mySession->sucMsg=LNG_STUDENT_CATEGORY_UPDATED;
				$this->_redirect('student/categories');
			}
			$this->view->catid=$arr['catid'];
			
		}
	}
	
	public function categoryupdateAction()
	{	
		global $mySession;		
	}
	
	public function viewallAction()
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
		
		$filename = "student_list_" . date('Ymdh') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"$filename\""); 
		header("Content-Type: application/vnd.ms-excel"); 
		$flag = false; 
		
		
		if(isset($arr['wherecondition']))
		{
			$wherecondition = stripslashes($arr['wherecondition']);
			
		}else{
			if (!empty($arr['search_batchid'])) {
				$wherecondition .= " and stu.batch_id='".$arr['search_batchid']."'";
			} elseif(!empty($arr['search_gradeid'])) {
				$wherecondition .= " and stu.batch_id in (select id from batches where grade_id='".$arr['search_gradeid']."' and start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
			} elseif(!empty($arr['search_year']))
			{
				$wherecondition .= " and stu.batch_id in (select id from batches where start_date like  '".$arr['search_year']."-%' and schoolid='".$mySession->user['schoolid']."')";
			}
			if (!empty($arr['search_religion'])) {
				$wherecondition .= " and stu.religion='".$arr['search_religion']."'";
			}
			if (!empty($arr['search_keyword'])) {
				$wherecondition .= " and (stu.first_name like '%".$arr['search_keyword']."%' or 
							stu.middle_name like '%".$arr['search_keyword']."%' or 
							stu.last_name like '%".$arr['search_keyword']."%' or
							stu.admission_no = '".$arr['search_keyword']."' or 
							stu.passport_or_id = '".$arr['search_keyword']."') 
							";
			}
		}
		
		$result = $db->runQuery("SELECT
		stu.admission_no as Admission_No, 
		stu.student_passport_no as ID_or_Passport_No, 
		stu.nationality_id as Nationality, 
		CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as Student_Name, 
		b.name as Batch_Name,
		c.grade_name as Grade_Name,
		stu.religion as Religion,
		CONCAT(guard.first_name,' ',guard.last_name) as Guardian,
		stu.address_line1 as Address, 
		stu.phone1 as Contact_No 
		FROM students as stu
		LEFT JOIN guardians as guard ON guard.ward_id = stu.id
		LEFT JOIN batches as b ON b.id = stu.batch_id
		LEFT JOIN grades as c ON c.id = b.grade_id 
		WHERE stu.schoolid='".$mySession->user['schoolid']."' ".$wherecondition."
		ORDER BY stu.first_name"); 
		
	
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
	
	public function advancedsearchAction()
	{	
		global $mySession;
		$form = new Form_Searchstudent();
		$this->view->form = $form;
		$db = new Db();
		
		$qry="select * from `grades` where schoolid='".$mySession->user['schoolid']."'";	
		$batchlist=$db->runQuery("$qry");
		
		$this->view->batchlist=$batchlist;	
		
	}
	
	public function searchfromotherAction()
	{	
		global $mySession;
	}
	
	public function liststudentsofotherAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
				
		$qry="select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as sname, s.admission_no, sc.name as schoolname from `students` as s left join `school` as sc on (s.schoolid=sc.id) left join batches as b on (s.batch_id=b.id) left join grades as g on (g.id=b.grade_id) where s.student_passport_no = '".@$arr['search_keyword']."'";	
		
		$studentlist=$db->runQuery("$qry");
		$this->view->studentlist=$studentlist;
	}
	
	public function askforstudentAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();

		if($arr['studentid']) {
			
			$qry="SELECT stu.*, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, sc.name as stschool from `students` as stu left join `school` as sc on (sc.id=stu.schoolid)
				WHERE stu.id='".$arr['studentid']."'";
				$studentdetail=$db->runQuery($qry);
				
			$this->view->studentdetail=$studentdetail[0];
			
		
		if(isset($arr['mode']) && $arr['mode']=='reqnote'){
		
			$qry="SELECT u.id as secid, sc.id as schoolid from `users` as u left join `students` as stu on (stu.schoolid=u.schoolid) left join `school` as sc on (stu.schoolid=sc.id)
				WHERE stu.id='".$arr['studentid']."' and u.usertype='S'";
				$studentdetail=$db->runQuery($qry);
			
				if(is_array($studentdetail) && count($studentdetail) > 0){			
					$Data['curr_school_id']=$mySession->user['schoolid'];
					$Data['to_school']=$studentdetail[0]['schoolid'];
					$Data['student_id']=$arr['studentid'];				
					$Data['message']=$arr['requestnote'];
					$Data['sec_id']=$studentdetail[0]['secid'];							
						//echo"<pre>";print_r($Data); exit;
						$modelobj = new Mainmodel();
						$modelobj->insertThis('request_student',$Data);
						$mySession->sucMsg =LNG_REQUEST_SUCCESSFULLY_SEND;
						$this->_redirect('student/searchfromother');
						exit;
				}
			}
		}
	}
	
	public function studentrequestAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
				
		$qry="select rs.*, sc.name as sc_name, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname from `request_student` as rs left join `school` as sc on (rs.curr_school_id=sc.id) left join `students` as stu on (rs.student_id=stu.id) where to_school='".$mySession->user['schoolid']."' order by rs.id DESC";		
		$request=$db->runQuery("$qry");
		$this->view->request=$request;
		
		$qry="select rs.*, sc.name as sc_name, stu.id as studentid, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname from `request_student` as rs left join `school` as sc on (rs.curr_school_id=sc.id) left join `students` as stu on (rs.student_id=stu.id) where curr_school_id='".$mySession->user['schoolid']."'  order by rs.id DESC";		
		$sentrequest=$db->runQuery("$qry");
		$this->view->sentrequest=$sentrequest;
	}
	
	public function requestedstudentAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry="SELECT stu.*, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt, stpre.institution, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id
			LEFT JOIN student_previous_datas as stpre ON stpre.student_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";			
			$studentdetail=$db->runQuery($qry);			
			$this->view->studentdetail=$studentdetail[0];
		
	}
	
	public function changestatusAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['requestid']) {
			if($arr['status']=='accept') {
				$data['act_status'] = 2;
			} else {
				$data['act_status'] = 1;
			}
			
			$modelobj = new Mainmodel();
			$condition = "id='".$arr['requestid']."'";
			$modelobj->updateThis('request_student',$data,$condition);
			
			$mySession->sucMsg = LNG_STATUS_UPDATED;
			$this->_redirect('student/studentrequest');
		}		
	}
	
	public function deletereqAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
			$condition = "id='".$arr['requestid']."'";
			$db->delete('request_student',$condition);
			
			$mySession->sucMsg = LNG_STATUS_UPDATED;
			$this->_redirect('student/studentrequest');
	
	}
	
	public function removeAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		 $qry="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id 
			WHERE stu.id='".$arr['studentid']."'";	
			
			$studentdetail=$db->runQuery($qry);
		$this->view->studentdetail=$studentdetail[0];	
	}
	public function addnoteAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		
		if($arr['studentid']) {
			if($mySession->user['usertype']=='P'){
				if(!in_array($arr['studentid'],$mySession->user['userstudentid'])) {
					$this->_redirect('index');		
					exit;
				}
			}
			$qry="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, u.username, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			LEFT JOIN users as u ON guard.userid = u.id
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id 
			WHERE stu.id='".$arr['studentid']."' and stu.schoolid='".$mySession->user['schoolid']."'";			
			$studentdetail=$db->runQuery($qry);
			
			if(count($studentdetail) < 1) {
				$this->_redirect('index');		
				exit;
			}
			$this->view->studentdetail=$studentdetail[0];
		
		if(isset($arr['mode']) && $arr['mode']=='addnote'){
				$Data['student_id']=$arr['studentid'];
				$Data['schoolid']=$mySession->user['schoolid'];
				$Data['write_by']=$mySession->user['userid'];
				$Data['note']=$arr['usernote'];
				$Data['write_dt']=date('Y-m-d h:i:s');
				
					$modelobj = new Mainmodel();
					$modelobj->insertThis('student_note',$Data);
					$mySession->sucMsg =LNG_NOTE_SUCCESSFULLY_CREATED;
					$this->_redirect('student/notes/studentid/'.$arr['studentid']);
					exit;
			}
		}
		
	}
	public function notesAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		
		if($arr['studentid']) {
			if($mySession->user['usertype']=='P'){
				if(!in_array($arr['studentid'],$mySession->user['userstudentid'])) {
					$this->_redirect('index');		
					exit;
				}
			}
			$qry="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, u.username, b.name as batchname, c.grade_name
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			LEFT JOIN users as u ON guard.userid = u.id
			LEFT JOIN batches as b ON b.id = stu.batch_id
			LEFT JOIN grades as c ON c.id = b.grade_id 
			WHERE stu.id='".$arr['studentid']."' and stu.schoolid='".$mySession->user['schoolid']."'";			
			$studentdetail=$db->runQuery($qry);
			
			if(count($studentdetail) < 1) {
				$this->_redirect('index');		
				exit;
			}
			$this->view->studentdetail=$studentdetail[0];
			
			
			$qry="select s.*, concat(u.first_name,' ',u.last_name) as username, u.usertype, DATE_FORMAT(write_dt,'%M %d, %Y %r') as dt from `student_note` as s left join users as u on(u.id=s.write_by) where s.student_id='".$arr['studentid']."' and s.schoolid='".$mySession->user['schoolid']."' order by s.write_dt desc";	
			$noteslist=$db->runQuery("$qry");
			$this->view->noteslist = $noteslist;
		} else {
			$this->_redirect('index');
		}
		
		$this->view->batchlist=$batchlist;	
	}
	public function deleteAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		
		if(isset($arr['studentid']) && ($mySession->user['usertype']=='S' || $mySession->user['usertype']=='T')) {
			$chkres = $db->runQuery("select id from students where id='".$arr['studentid']."' and schoolid='".$mySession->user['schoolid']."'");
			if(is_array($chkres) && count($chkres) > 0) {
				$this->view->studentid = $arr['studentid'];
			} else {
				$this->_redirect('index');
				exit;
			}
		} else {
			$this->_redirect('index');
			exit;
		}		
	}
	
}
?>