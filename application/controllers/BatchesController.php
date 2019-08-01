<?php
__autoloadDB('Db');
class BatchesController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['batchid'])) {
		
			$qry="select * from `students` where batch_id='".$arr['batchid']."' order by first_name";
			$studentlist=$db->runQuery("$qry");
			$this->view->studentlist=$studentlist;
			
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry = "Select b.*, c.grade_name from batches as b left join grades as c on (b.grade_id=c.id)  where b.id='".$arr['batchid']."'".$batchdate_condition." order by name";
			$res = $db->runQuery($qry);			
			$this->view->batchdetail = $res[0];
			
		}
	}
	
	public function newAction()
	{	
		global $mySession;
		
		$form = new Form_NewBatch();
		$this->view->form = $form;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
			$this->view->gradeid=$arr['gradeid'];
			$this->view->batchid=$arr['batchid'];
		
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();
			//echo "<pre>";print_r($formData);exit;		
			if($form->isValid($formData)){
				$Data['name']=$formData['batch_name'];
				$Data['employee_id'] = $formData['batches_employee_id'];
				$Data['start_date']=changeDate($formData['batch_startdate']);
				$Data['sec_sem_start_date']=changeDate($formData['batch_second_sem_start']);
				$Data['end_date']=changeDate($formData['batch_enddate']);
				$Data['grade_id']=$arr['gradeid'];
				$Data['schoolid'] = $mySession->user['schoolid'];
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('batches',$Data);
				
				$mySession->sucMsg=LNG_BATCH_SAVED;
				$this->_redirect('grades/show/gradeid/'.$arr['gradeid']);
			}
		}
			
			$qry="select * from `grades` where id='".$arr['gradeid']."'";
			$classdetail=$db->runQuery("$qry");
			$this->view->classdetail =  $classdetail;
	}
	public function newelactiveAction()
	{	
		global $mySession;
		
		$form = new Form_AddBatch();		
		$this->view->form = $form;		
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
		
		if(isset($arr['batchid']) && $arr['batchid']!='')
		{
			//$form = new Form_CreateClass($arr['gradeid']);
			//$this->view->form = $form;
			
			$qry = "Select b.*, DATE_FORMAT(start_date,'%M %d, %Y') as startdate, DATE_FORMAT(end_date,'%M %d, %Y') as enddate, c.grade_name from batches as b left join grades as c on (b.grade_id=c.id)  where b.id='".$arr['batchid']."'";
			$res = $db->runQuery($qry);			
			$this->view->batchdetail = $res[0];
			
			$form = new Form_NewBatch($res[0]);
			$this->view->form = $form;
		
			$this->view->gradeid=$arr['gradeid'];
			$this->view->batchid=$arr['batchid'];
			
			if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();
				//echo "<pre>";print_r($formData);exit;		
				if($form->isValid($formData)){			
					$batchData['name'] = $formData['batch_name'];
					$batchData['employee_id'] = $formData['batches_employee_id'];
					$batchData['start_date'] = changeDate($formData['batch_startdate']);
					$batchData['sec_sem_start_date'] = changeDate($formData['batch_second_sem_start']);
					$batchData['end_date'] = changeDate($formData['batch_enddate']);					
					//echo"<pre>";print_r($batchData);exit;
					$wcondition = "id='".$arr['batchid']."'";
					
					$modelobj = new Mainmodel();
					$modelobj->updateThis('batches',$batchData,$wcondition);
					
					$mySession->sucMsg=LNG_BATCH_UPDATED;
					$this->_redirect('grades/show/gradeid/'.$arr['gradeid']);
				}
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
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['batchid'])) {
		
			$qry="select * from `students` where batch_id='".$arr['batchid']."' order by first_name";
			$studentlist=$db->runQuery("$qry");
			$this->view->studentlist=$studentlist;
			
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry = "Select b.*, c.grade_name from batches as b left join grades as c on (b.grade_id=c.id) where b.id='".$arr['batchid']."'".$batchdate_condition." order by name";
			
			$res = $db->runQuery($qry);			
			$this->view->batchdetail = $res[0];
			
		}	
	}
	
	public function destroyAction()
	{	
		global $mySession;
		
		$arr=$this->getRequest()->getParams();
				
		$condition= "id = '".$arr['batchid']."'";
		$db= new Db();
		$db->delete('batches',$condition);
		
		$mySession->sucMsg = LNG_BATCH_DELETED;
		if($arr['gradeid']) {
			$this->_redirect('grades/show/gradeid/'.$arr['gradeid']);
		} else {
			$this->_redirect('user/dashboard');
		}
		
		exit;
	}
	
	public function assigntutorAction()
	{	
		global $mySession;		
	}
	
	public function updateemployeesAction()
	{	
		global $mySession;		
	}
	
	public function assignemployeeAction()
	{	
		global $mySession;		
	}
	
	public function removeemployeeAction()
	{	
		global $mySession;		
	}
	
	public function initdataAction()
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
		$arr=$this->getRequest()->getParams();
		// file name for download	

		$filename = "classes_list_" . date('Ymdh') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"$filename\""); 
		header("Content-Type: application/vnd.ms-excel"); 
		$flag = false; 
		$result = $db->runQuery("SELECT 
		a.name as Class_Name, 
		c.grade_name as Grade_Name, 
		concat(b.first_name,' ',b.last_name) as Teacher_Name,
		DATE_FORMAT(start_date, '%Y-%m-%d') as Start_Date,
		DATE_FORMAT(end_date, '%Y-%m-%d') as End_Date
		from batches as a
		left join employees as b on(a.employee_id=b.id) 
		left join grades as c on (a.grade_id=c.id)
		WHERE a.schoolid='".$mySession->user['schoolid']."' and a.grade_id='".$arr['gradeid']."'
		ORDER BY name");
		
	
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