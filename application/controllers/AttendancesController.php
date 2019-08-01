<?php
__autoloadDB('Db');
class AttendancesController extends AppController
{
	public function indexAction()
	{	
		global $mySession;	
		
		$db=new Db();
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";	
		$qry="select b.id, b.name, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";	
		if($mySession->user['usertype']=='T') {
			$qry="select b.id, b.name, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."' and  b.employee_id='".$mySession->user['userownid']."' and b.is_active='1' and b.is_deleted='0'".$batchdate_condition." order by name";
		}
		$batchlist=$db->runQuery("$qry");
		$this->view->batchlist=$batchlist;
		
	}
	public function registerAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."' ".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;	
	}
	public function listsubjectAction()
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
		$this->view->batch_id = $arr['batch_id'];
		if (isset($arr['batch_id'])) {
			$qry="select * from `weekdays` where batch_id='".$arr['batch_id']."'";
			$periodentry= $db->runQuery("$qry");
			
			if(is_array($periodentry) && count($periodentry)>0)
				{
				$qry="select * from `students` where batch_id='".$arr['batch_id']."' order by first_name";
				$attend = $db->runQuery("$qry");
				$this->view->attend=$attend;
			
				$y=date('Y');
				$m=date('m');
				if(isset($arr['nextmonth']) && $arr['nextmonth']!='')
				{
					$nextmonth = explode("-",$arr['nextmonth']);
					if(is_array($nextmonth) && count($nextmonth) > 1)
					{
						$y=$nextmonth[0];
						$m=$nextmonth[1];
					}
				}
				$this->view->y=$y;
				$this->view->m=$m;
				$this->view->publishregister = 1; 
				 $qry="select *, DATE_FORMAT(month_date, '%d') as day from `period_entries` where batch_id='".$arr['batch_id']."' and month_date like '".$y.'-'.$m."%' order by month_date";
				$register=$db->runQuery("$qry");
				if(count($register) < 1)
				{
					$qry="select * from `period_entries` where batch_id='".$arr['batch_id']."' limit 0, 2";
					$checkset=$db->runQuery("$qry");
					if(count($checkset) < 1)
					{
						$this->view->publishregister = 0;
					}
				}	
				$this->view->register=$register;
			}else{
				echo "<div style=\"background:#fff; font-size:14px; font-weight:600;\">".LNG_SET_WEEKDAY_BEFORE_ATTENDANCE_PROCESS."<a href=\"".BASE_PATH."weekday/index/batchid/".$arr['batch_id']."\">".LNG_CLICK_HERE."</a></div>";
				exit;
			}
		}
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function manageattendancesregisterAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->batchid = $arr['batch_id'];
		if (isset($arr['batch_id'])) {
			 $qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='".$arr['batch_id']."'";
			 $weekdaylist=$db->runQuery("$qry");
			 if(count($weekdaylist) < 1) {
			 	$qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='0'";
			 	$weekdaylist=$db->runQuery("$qry");
			 }
			 $this->view->weekdayarray = explode(",",$weekdaylist[0]['weekday']);
			 
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	public function publishattendancesregisterAction()
	{
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['batch_id'])) {
			$qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='".$arr['batch_id']."'";
			 $weekdaylist=$db->runQuery("$qry");
			 if($weekdaylist['weekday']=='') {
				 $qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='0'";
				$weekdaylist=$db->runQuery("$qry");
			 }
			 $weekdayarray = explode(",",$weekdaylist[0]['weekday']);
				 
			$fdate = changeDate($arr['fdate']);
			$tdate = changeDate($arr['tdate']);
			
			$fdatearray = explode('-',$fdate);
			$tdatearray = explode('-',$tdate);
			
			$ftime = mktime(0,0,0,$fdatearray[1],$fdatearray[2],$fdatearray[0]); //Gets Unix timestamp START DATE
			$ttime = mktime(0,0,0,$tdatearray[1],$tdatearray[2],$tdatearray[0]); //Gets Unix timestamp END DATE
			
			$difference = $ttime-$ftime; //Calcuates Difference
			$daysago = floor($difference /60/60/24); //Calculates Days Old
			$i = 0;
			$modelobj = new Mainmodel();
			while ($i < $daysago +1) {
				if ($i != 0) { $ftime = $ftime + 86400; }
				else { $ftime = $ftime ; }
				$today = date('Y-m-d',$ftime);
				$wkday = date('w',$ftime);
				if(in_array($wkday,$weekdayarray))
				{
					$qry="select * from `period_entries` where month_date='".$today."' and batch_id='".$arr['batch_id']."'";
					$period=$db->runQuery("$qry");
					if(count($period) < 1)
					{
						$Data='';
						$Data['month_date']=$today;
						$Data['batch_id']=$arr['batch_id'];
						$Data['schoolid']=$mySession->user['schoolid'];
						
						$modelobj->insertThis('period_entries',$Data);/*	*/
					}
					//echo "$i) Day: $today and $wkday<br>";
					
				}
				$i++;
			}
			echo 'Register published successfully';  
		}
		exit;
	}	
	public function newAction()
	{	
		global $mySession;
		
		$form = new Form_Studentleave();		
		
		
		$this->_helper->layout()->setLayout('ajaxlayout');
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->anew=0;
		$this->view->periodid = $arr['periodid'];
		$this->view->profileid = $arr['profileid'];
		
		$qry="select concat(first_name,' ',middle_name,' ',last_name) as name from `students` where id='".$arr['profileid']."' order by first_name";
		$this->view->studentdetail = $db->runQuery("$qry");	
		$objRequest = $this->getRequest();
		
		if($arr['attendance_reason']) {	
			if($objRequest->isPost()) {
				$this->view->anew=2;	
				$formData = $objRequest->getPost();	
				//echo "<pre>";print_r($formData);exit;				
				if($form->isValid($formData)){
					
					$modelobj = new Mainmodel();
					$this->view->anew=1;
					$Data['student_id']=$arr['profileid'];
					$Data['period_table_entry_id']=$arr['periodid'];
					if(is_array($arr['forenoon']) && $arr['forenoon'][0]==1) {
						$Data['forenoon']=1;		
					} else {
						$Data['forenoon']=0;		
					}
					if(is_array($arr['afternoon']) && $arr['afternoon'][0]==1) {
						$Data['afternoon']=1;		
					} else {
						$Data['afternoon']=0;		
					}
					$Data['schoolid']=$mySession->user['schoolid'];
					$Data['reason']=$arr['attendance_reason'];	
					$this->view->instid = $modelobj->insertThis('attendances',$Data);
					
					$qry="select DATE_FORMAT(month_date, '%w') as day, DATE_FORMAT(month_date, '%d') as daydigit from `period_entries` where id='".$arr['periodid']."'";
					$this->view->perioddetail = $db->runQuery("$qry");	
				}
			}
		}
		$this->view->form = $form; 
	}
	
	public function createAction()
	{	
		global $mySession;		
	}
	
	public function editAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->mode=0;
		$this->view->attid=$arr['attid'];
		
		$qry="select * from `attendances` where id='".$arr['attid']."'";
		$this->view->attdetail = $db->runQuery("$qry");	
		$form = new Form_Studentleave($this->view->attdetail[0]);
		
		$qry="select DATE_FORMAT(month_date, '%w') as day, DATE_FORMAT(month_date, '%d') as daydigit from `period_entries` where id='".$this->view->attdetail['period_table_entry_id']."'";
		$this->view->perioddetail = $db->runQuery("$qry");
		
		$qry="select concat(first_name,' ',middle_name,' ',last_name) as name from `students` where id='".$this->view->attdetail[0]['student_id']."' order by first_name";
		$this->view->studentdetail = $db->runQuery("$qry");
				
		if(isset($arr['mode']))
		{
			if($arr['mode']=='delete') {
				$this->view->mode=1;
				$condition2="id='".$arr['attid']."'";
				$db->delete('attendances',$condition2);
			}
			if($arr['mode']=='update') {
			$this->view->mode=2;			
			$modelobj = new Mainmodel();
			
			$Data['reason']=$arr['attendance_reason'];	
			if(is_array($arr['forenoon']) && $arr['forenoon'][0]==1) {
				$Data['forenoon']=1;		
			} else {
				$Data['forenoon']=0;		
			}
			if(is_array($arr['afternoon']) && $arr['afternoon'][0]==1) {
				$Data['afternoon']=1;		
			} else {
				$Data['afternoon']=0;		
			}
			$condition = "id='".$arr['attid']."'";
			$modelobj->updateThis('attendances',$Data,$condition);
			
			
			
			}
		} 
		$this->view->form = $form; 
	}
	
	public function updateAction()
	{	
		global $mySession;		
	}
	
	public function destroyAction()
	{	
		global $mySession;		
	}
	
}
?>