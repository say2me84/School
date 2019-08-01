<?php
__autoloadDB('Db');
class GradesController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	public function newAction()
	{	
		
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$form = new Form_CreateClass();
		
		$this->view->form = $form;
		
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if($form->isValid($formData)){
				$Data['grade_name'] = $formData['grade_name'];
				//$Data['section_name'] = $formData['section_name'];
				$Data['code'] = $formData['grade_code'];
				$Data['created_at'] = date('Y-m-d h:i:s');
				$Data['schoolid'] = $mySession->user['schoolid'];
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('grades',$Data);
				
				$batchData['name'] = $formData['batches_attributes'];
				$batchData['employee_id'] = $formData['batches_employee_id'];
				$batchData['start_date'] = changeDate($formData['batches_attributes_startdate']);
				$batchData['sec_sem_start_date'] = changeDate($formData['batches_attributes_sec_sem_start']);
				$batchData['end_date'] = changeDate($formData['batches_attributes_enddate']);
				$batchData['grade_id'] = $insid;
				
				$batchData['schoolid'] = $mySession->user['schoolid'];
				
				$modelobj->insertThis('batches',$batchData);
				
				$mySession->sucMsg=LNG_GRADE_CREATED;
				$this->_redirect('grades/new');
			}
		}
		
	}
	
	public function manageclassAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
		$qry="select * from `grades` where schoolid='".$mySession->user['schoolid']."'";		
		$classeslist=$db->runQuery("$qry");
		
		$this->view->classeslist =  $classeslist;
				
	}
	
	public function managebatchesAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		$qry="select grade_name,id from `grades` where schoolid='".$mySession->user['schoolid']."'";		
		$classeslist=$db->runQuery("$qry");
		$this->view->classeslist =  $classeslist;
		
	}
	
	public function updatebatchAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if ($arr['grade_name']) {
		$this->view->gradeid=$arr['grade_name'];
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.grade_id='".$arr['grade_name']."'".$batchdate_condition." order by name";
			$batchlist=$db->runQuery("$qry");
			$this->view->batchlist=$batchlist;
			
		} 
	}
	
	public function createAction()
	{	
		global $mySession;		
	}
	
	public function editAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
		if(isset($arr['gradeid']) && $arr['gradeid']!='')
		{
			$form = new Form_CreateClass($arr['gradeid']);
			$this->view->form = $form;
		
			$this->view->gradeid=$arr['gradeid'];
			
			if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();			
				$Data['grade_name'] = $formData['grade_name'];
				$Data['section_name'] = $formData['section_name'];
				$Data['code'] = $formData['grade_code'];
				
				$wcondition = "id='".$arr['gradeid']."'";
				
				$modelobj = new Mainmodel();
				$modelobj->updateThis('grades',$Data,$wcondition);
				
				$mySession->sucMsg=LNG_GRADE_UPDATED;
				$this->_redirect('grades/manageclass');
				
			}
		} else {
			$this->_redirect('index');
		}
	}
	
	public function updateAction()
	{	
		global $mySession;		
	}
	
	public function showAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
			
		
		if(isset($arr['gradeid']) && $arr['gradeid']!='')
		{
			$qry="select * from `grades` where id='".$arr['gradeid']."'";
			$classdetail=$db->runQuery("$qry");
		
			$this->view->classdetail =  $classdetail;
			
			$qry2="select a.*, a.name as gr_name, concat(b.first_name,' ',b.last_name) as ename, b.id as empid from `batches` as a left join `employees` as b on (b.id=a.employee_id) where a.grade_id='".$arr['gradeid']."' order by name";
			$batcheslist=$db->runQuery("$qry2");
		
			$this->view->batcheslist =  $batcheslist;
			
			$this->view->gradeid=$arr['gradeid'];
		
		} else {
			$this->_redirect('index');
		}
	}
	
	public function destroyAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
		if(isset($arr['gradeid']) && $arr['gradeid']!='')
		{
			$condition2="id='".$arr['gradeid']."'";
			$db->delete('grades',$condition2);
		
			$mySession->sucMsg=LNG_GRADE_DELETED;
			$this->_redirect('grades/manageclass');
		} else {
			$this->_redirect('index');
		}
		 
	
	}
	
	public function findcourseAction()
	{	
		global $mySession;		
	}
	
	public function exportxlsAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		
		// file name for download			
		$filename = "grades_list_" . date('Ymdh') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"$filename\""); 
		header("Content-Type: application/vnd.ms-excel"); 
		$flag = false; 
		$result = $db->runQuery("SELECT 
		grade_name as Grade_Name, 
		code as Grade_Code, 
		DATE_FORMAT(created_at, '%Y-%m-%d') as Created_At
		from grades
		WHERE schoolid='".$mySession->user['schoolid']."'
		ORDER BY grade_name");
		
	
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