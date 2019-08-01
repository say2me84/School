<?php
__autoloadDB('Db');
class TimetableController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	public function viewAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.name, b.id, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batchlist=$db->runQuery("$qry");
		$this->view->batchlist=$batchlist;
			
	}
	
	
	public function updatetimetableviewAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['batch_id']) {
			$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$weekdayarray=$db->runQuery("$qry");
			
			$mymodelobj = new Timetable();
			$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray,2);
					
		}
		$this->view->batchid = $arr['batch_id'];		
		
		$this->_helper->layout()->setLayout('ajaxlayout');	
	}
	
	public function studentviewAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(!isset($arr['studentid'])) {
			$arr['studentid'] = $mySession->user['userstudentid'][0];
		}	
		$this->view->studentid = $arr['studentid'];
		if(count($mySession->user['userstudentid']) > 1) {
			
			$wherecondition = '';		
			$studentids = implode(",",$mySession->user['userstudentid']);
			$wherecondition .= " and stu.id in (".$studentids.")";
			
			$qry="select stu.*, b.id as batchid, b.name as batchname from `students` as stu left join `batches` as b on (stu.batch_id=b.id) where stu.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;
			
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
	}
	
	public function selectclass2Action()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();

		if ($this->_request->isPost()) {
			$qry="select * from `weekdays` where batch_id='".$arr['batch_id']."'";
			$weekdayarray=$db->runQuery("$qry");
			if(count($weekdayarray) < 1) {
				$qry="select * from `weekdays` where batch_id='0'";
				$weekdayarray=$db->runQuery("$qry");
				
			}
			$qry="select *, TIME_FORMAT(start_time,'%h:%i%p') as sttime, TIME_FORMAT(end_time,'%h:%i%p') as entime from `class_timings` where batch_id='".$arr['batch_id']."'";
			$classtimingarray=$db->runQuery("$qry");
			
			$modelobj = new Mainmodel();
			// if all week days same period
			/*foreach($weekdayarray as $wdarray) {
				foreach($classtimingarray as $ctarray) {
					$chk = "select * from `timetable_entries` where batch_id='".$arr['batch_id']."' and weekday_id='".$wdarray['id']."' and class_timing_id='".$ctarray['id']."'";
					$ttentry=$db->runQuery("$chk");
					if(count($ttentry) < 1)
					{
						$Data='';
						$Data['weekday_id']=$wdarray['id'];
						$Data['class_timing_id']=$ctarray['id'];
						$Data['batch_id']=$arr['batch_id'];
						$Data['schoolid']=$mySession->user['schoolid'];
						
						$modelobj->insertThis('timetable_entries',$Data);
					}
				}
			}	*/
			
			$this->_redirect('timetable/edit2/batch_id/'.$arr['batch_id']);	
			exit;
		}
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;	
	}
	
	public function edit2Action()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->batchid = $arr['batch_id'];
		if($arr['batch_id']) {
		$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
		$weekdayarray=$db->runQuery("$qry");
		
		if(is_array($weekdayarray) && count($weekdayarray) > 0 ) {
			$qry="select id from `class_timings` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$classtimingarray=$db->runQuery("$qry");
			if(is_array($classtimingarray) && count($classtimingarray) > 0 ) {
				$idarray = array();
				$modelobj = new Mainmodel();
				// if all week days same period
				/*foreach($weekdayarray as $wdarray) {
					foreach($classtimingarray as $ctarray) {
						$chk = "select id from `timetable_entries` where batch_id='".$arr['batch_id']."' and weekday_id='".$wdarray['id']."' and class_timing_id='".$ctarray['id']."' and schoolid='".$mySession->user['schoolid']."'";
						$ttentry=$db->runQuery("$chk");
						if(count($ttentry) < 1)
						{
							$Data='';
							$Data['weekday_id']=$wdarray['id'];
							$Data['class_timing_id']=$ctarray['id'];
							$Data['batch_id']=$arr['batch_id'];
							$Data['schoolid']=$mySession->user['schoolid'];
							
							$insid = $modelobj->insertThis('timetable_entries',$Data);
							$idarray[] = $insid;
						} else {
							$idarray[] = $ttentry[0]['id'];
						}
					}
				}*/	
				if(is_array($idarray) && count($idarray) > 0) { 
					$idstring = implode(",",$idarray);
					$condition = "batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."' and id not in (".$idstring.")";
					$db->delete('timetable_entries',$condition);
				}
				$mymodelobj = new Timetable();
				$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray);		
				
				$qry="select * from `subjects` where grade_id in (select grade_id from batches where id='".$arr['batch_id']."') and schoolid='".$mySession->user['schoolid']."'";
				
				$subjectarray=$db->runQuery("$qry");
				$this->view->subjectarray = $subjectarray;
			} else {
				$this->view->needclasstiming = 1;
			}
		} else {
			$this->view->needweekday = 1;
		}	
	  }
	}
	
	public function updateemployeesAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['subject_id']) {
			$qry="select es.id as emp_sub_id, e.id, e.first_name, e.last_name from `employees_subjects` as es left join employees as e on (e.id=es.employee_id) where subject_id='".$arr['subject_id']."'";
			$employee=$db->runQuery("$qry");
			$this->view->employee = $employee;
				
			$qry = "select colorcode from subjects where id='".$arr['subject_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$colorcode = $db->runQuery($qry);
			$this->view->colorcode = $colorcode;
		}
		$this->_helper->layout()->setLayout('ajaxlayout');	
	}
	
	public function updatemultipletimetableentries2Action()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
	
		if(@$arr['emp_sub_id']!='' && $arr['tte_ids']!='')
		{	
			$qry="select * from `employees_subjects` where id='".$arr['emp_sub_id']."'";
			$empsub=$db->runQuery("$qry");
				
			$Data='';
			$Data['subject_id'] = @$empsub[0]['subject_id'];
			$Data['employee_id'] = @$empsub[0]['employee_id'];
			
			$wcondition = "id='".$arr['tte_ids']."'";
			
			$modelobj = new Mainmodel();
			$modelobj->updateThis('timetable_entries',$Data,$wcondition);
			
		}
		$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
		$weekdayarray=$db->runQuery("$qry");
		
		$mymodelobj = new Timetable();
		$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray);
		
		$this->view->weekdayarray=$weekdayarray;
		$this->_helper->layout()->setLayout('ajaxlayout');	
	}
	
	public function deleteemployee2Action()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(@$arr['tte_ids']!='')
		{	
			$qry="select batch_id from `timetable_entries` where id='".$arr['tte_ids']."'";
			$getbatchid=$db->runQuery("$qry");
			
			$Data='';
			$Data['subject_id'] = $getbatchid[0]['subject_id'];
			$Data['employee_id'] = $getbatchid[0]['employee_id'];
			
			$wcondition = "id='".$arr['tte_ids']."'";
			//echo"<pre>";print_r($getbatchid);exit;
			$modelobj = new Mainmodel();
			$modelobj->updateThis('timetable_entries',$Data,$wcondition);
			
				
			$qry="select id, weekday from `weekdays` where batch_id='".$getbatchid[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$weekdayarray=$db->runQuery("$qry");
			
			$mymodelobj = new Timetable();
			$this->view->timetablehtml = $mymodelobj->timetablehtml($getbatchid[0]['batch_id'],$weekdayarray);
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');	
	}
	public function teacherAction()
	{	
		global $mySession;
	}
	
	
}
?>