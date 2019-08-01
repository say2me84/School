<?php
__autoloadDB('Db');
class AttendancereportController extends AppController
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
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.schoolid ='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;
	}
		
	public function subjectAction()
	{	
		global $mySession;		
	}
	
	public function modeAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		$arr=$this->getRequest()->getParams();
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];
		}
	}
	
	public function showAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];

			$qry = "select 
					DATE_FORMAT(start_date, '%m') as st_month, 
					DATE_FORMAT(start_date, '%Y') as st_year, 
					DATE_FORMAT(end_date, '%m') as end_month, 
					DATE_FORMAT(end_date, '%Y') as end_year 
					from batches where id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";	
			$resdate = $db->runQuery($qry);
			$this->view->resdate = $resdate[0];
			
			if(is_array($resdate) && count($resdate) > 0) 
			{
				$startdate = $resdate[0];
			}			
		}
	}
	
	public function monthAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');		
		$arr=$this->getRequest()->getParams();
		
		$this->view->mode = $arr['mode'];
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];
		}
	}
	
	public function yearAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];
		}
	}
	
	public function reportAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$db = new Db();
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];
			if($arr['month_id'])
			{
			$monthyear = explode("-",$arr['month_id']);
			$nextmonth = date("Y-m",mktime(0,0,0,($monthyear[1]+1),1,$monthyear[0]));
				$qry = "select DATE_FORMAT(month_date, '%d') as wdate, id from period_entries where month_date like '".$arr['month_id']."-%' and batch_id='".$arr['batch_id']."'";
				$res = $db->runQuery($qry);
			}else{
				$qry = "select DATE_FORMAT(month_date, '%d') as wdate, id from period_entries where batch_id='".$arr['batch_id']."'";
				$res = $db->runQuery($qry);
			}
							
				$work_date = array();
				$perion_id = array();
				foreach($res as $result)
				{
					$dt = $result['wdate'];
					//if(isset($arr['month_id']) && !in_array($dt,$work_date)) {
						$work_date[] = $dt;
						$perion_id[] = $result['id'];
					//}
				}
				
				$this->view->periodid = implode(",",$perion_id);
				$classday = count($work_date);
				if($arr['month_id'])
				{
					$qry = "SELECT DATE_FORMAT(start_date, '%Y-%m-%d') as sdate, DATE_FORMAT(end_date, '%Y-%m-%d') as edate FROM `events` 
					WHERE (
					(`start_date` < '".$nextmonth."-01 00:00:00' and `start_date`>='".$arr['month_id']."-01 00:00:00') or 
					(`end_date` < '".$nextmonth."-01 00:00:00' and `end_date`>='".$arr['month_id']."-01 00:00:00') or 
					(`start_date` < '".$arr['month_id']."-01 00:00:00' and `end_date`>='".$nextmonth."-01 00:00:00')) 
					and is_holiday='1' and schoolid='".$mySession->user['schoolid']."'";
				}else{
					$qry = "SELECT DATE_FORMAT(start_date, '%Y-%m-%d') as sdate, DATE_FORMAT(end_date, '%Y-%m-%d') as edate FROM `events` 
					WHERE is_holiday='1' and schoolid='".$mySession->user['schoolid']."'";
				}
				
				$starttime = mktime(0,0,0,$monthyear[1],1,$monthyear[0]);				
				$endtime = mktime(0,0,0,($monthyear[1]+1),1,$monthyear[0]);
				$sec_per_day = 86400;
				
				$holiday_dates = $db->runQuery($qry);
				$holiday_dates;
				$leave_date = array();
				
				foreach($holiday_dates as $hdates)
				{
					$startmonthyear = explode("-",$hdates['sdate']);
					$endmonthyear = explode("-",$hdates['edate']);
					
					$thisstarttime = mktime(0,0,0,$startmonthyear[1],$startmonthyear[2],$startmonthyear[0]);				
					$thisendtime = mktime(0,0,0,$endmonthyear[1],$endmonthyear[2],$endmonthyear[0]);
					
					if($thisstarttime < $starttime) { $thisstarttime = $starttime; }
					if($thisendtime > ($endtime-1)) { $thisendtime = $endtime; }
					
					for($t=$thisstarttime; $t <= $thisendtime;)
					{
						$dt = date('d',$t);
						if(!in_array($dt,$leave_date)) {
							$leave_date[] = $dt;
						}
						$t=$t+$sec_per_day;
					}
				}
				$totalholiday = count($leave_date);
				//echo"<pre>";print_r($work_date);exit;
				$working_day = array_diff($work_date,$leave_date);		
				
				$this->view->totalworking_day = count($working_day);
				
				$qry="select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as name from `students` as s where s.batch_id='".$arr['batch_id']."' order by first_name";						
				$studentlist=$db->runQuery("$qry");
				$this->view->studentlist=$studentlist;
			
		}
	}
	
	public function studentdetailsAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		
		$db = new Db();
		if($arr['profileid'])
		{
			$qry = "select s.id, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as name from students as s where s.id='".$arr['profileid']."' and s.schoolid='".$mySession->user['schoolid']."'";
			$detail = $db->runQuery($qry);
			$this->view->detail = $detail;
			if(is_array($detail) && count($detail) > 0)
			{
				$qry = "select a.*, p.month_date from attendances as a left join period_entries as p on(a.period_table_entry_id=p.id) where a.student_id='".$arr['profileid']."' and (a.forenoon='1' or a.afternoon='1') order by p.month_date";
				$res = $db->runQuery($qry);
				$this->view->abs_detail = $res;
			}
		}
	}
	
	public function reportforparentAction()
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
			if($arr['semno'] && $arr['year']){
				$this->view->semno = $arr['semno'];
				$this->view->year = $arr['year'];
			}else{ 
				$this->view->semno =2;
				$this->view->year = $studentdetail[0]['sem1_start'];
			}
			
			$qry = "select ars.studentid as studentid, ars.batch_id as batchid, DATE_FORMAT(b.start_date,'%Y') as sem1_start from `archive_students` as ars left join `batches` as b on (ars.batch_id=b.id) where ars.admission_no='".$studentdetail[0]['admission_no']."' and ars.schoolid='".$mySession->user['schoolid']."' order by b.start_date desc";
			$olddetail=$db->runQuery($qry);
			$this->view->olddetail=$olddetail;
			
			/*---for batch id---*/
			
			if($arr['year']){
				$this->view->year = $arr['year'];
			}else{
				$this->view->year = $studentdetail[0]['sem1_start'];
			}
			//echo $this->view->year."---".$this->view->batchid;
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
			
			if($arr['semno']==1)
			{
				$sem_condition = " and p.month_date >= b.start_date and p.month_date < b.sec_sem_start_date ";
			} else {
				$sem_condition = " and p.month_date >= b.sec_sem_start_date and p.month_date <= b.end_date ";
			}
			
			if($is_old==0){
				$qry = "select a.*, DATE_FORMAT(p.month_date, '%m-%d-%Y') AS monthdate from attendances as a left join period_entries as p on(a.period_table_entry_id=p.id) left join `batches` as b on (p.batch_id=b.id) where a.student_id='".$arr['studentid']."' and (a.forenoon='1' or a.afternoon='1') and p.batch_id='".$thisbatch."' ".$sem_condition." order by p.month_date";
			} else {
				$qry = "select a.*, DATE_FORMAT(p.month_date, '%m-%d-%Y') AS monthdate from archive_attendances as a left join period_entries as p on(a.period_table_entry_id=p.id) left join `batches` as b on (p.batch_id=b.id) where a.student_id='".$stuid."' and (a.forenoon='1' or a.afternoon='1') and p.batch_id='".$thisbatch."' ".$sem_condition." order by p.month_date";
			}
				$abs_detail = $db->runQuery($qry);
				$this->view->abs_detail = $abs_detail;
	}
	
	public function filterAction()
	{	
		global $mySession;		
	}
	
	public function advancesearchAction()
	{	
		global $mySession;		
	}
	
	public function reportpdfAction()
	{	
		global $mySession;		
	}
	
	public function filterreportpdfAction()
	{	
		global $mySession;		
	}
	
}
?>