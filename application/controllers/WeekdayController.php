<?php
__autoloadDB('Db');
class WeekdayController extends AppController
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
		if(isset($arr['batchid'])){
			$this->view->batchid = $arr['batchid'];
		}
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;	
		
		$qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='0'";
		$weekdaylist=$db->runQuery("$qry");
		if(is_array($weekdaylist) && count($weekdaylist) > 0)
		{
			$weekday = explode(",",$weekdaylist[0]['weekday']);
		} else {
			$weekday = array();
		}

		$this->view->weekday = $weekday;	
	}
	
	public function weekAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$this->_helper->layout()->setLayout('ajaxlayout');
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batch_id'])
		{
			$batchid=$arr['batch_id'];
		} else {
			$batchid=0;
		}
		$this->view->batchid= $batchid;
		
		 $qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='".$batchid."'";
		$weekdaylist=$db->runQuery("$qry");
		if(is_array($weekdaylist) && count($weekdaylist) > 0)
		{
			$weekday = explode(",",$weekdaylist[0]['weekday']);
		} else {
			$weekday = array();
		}

		$this->view->weekday = $weekday;
		
	}
	
	public function createAction()
	{	
		
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batch_id'])
		{
			$batchid=$arr['batch_id'];
		} else {
			$batchid=0;
		}
		
		$condition3="batch_id='".$batchid."'";
		$db->delete('weekdays',$condition3);
		$modelobj = new Mainmodel();
		if(isset($arr['weekdays']) && is_array($arr['weekdays'])) {
			
			foreach($arr['weekdays'] as $weekday)
			{
				$Data='';
				$Data['batch_id']=$batchid;
				$Data['weekday']=$weekday;			
				$Data['schoolid']=$mySession->user['schoolid'];
				
				$insid = $modelobj->insertThis('weekdays',$Data);
								
			}
			
			/***********publish attendance register************/
			
			$qry="select Group_concat(weekday) as weekday from `weekdays` where batch_id='".$arr['batch_id']."'";
			$weekdaylist=$db->runQuery("$qry");
			 
			$weekdayarray = explode(",",$weekdaylist[0]['weekday']);
			$qry= "select DATE_FORMAT(start_date, '%Y-%m-%d') as fdate, DATE_FORMAT(end_date, '%Y-%m-%d') as tdate from batches where id='".$arr['batch_id']."'";
			$date=$db->runQuery("$qry");
			$fdate = $date[0]['fdate'];
			$tdate = $date[0]['tdate'];
			
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
					
				} else{
					$where="month_date='".$today."' and batch_id='".$arr['batch_id']."'";					
					$db->delete('period_entries',$where);
				}
				$i++;
			}
		}
		
		$mySession->sucMsg = LNG_WEEKDAY_UPDATED;
		$this->_redirect('weekday/index/');
		
	}
	
}
?>