<?php
__autoloadDB('Db');
class CalendarController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		
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
		
	}
	public function showAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$arr=$this->getRequest()->getParams();
		
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
			
	}
	
	public function newcalendarAction()
	{	
		global $mySession;		
	}
	
	public function showeventtooltipAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$arr=$this->getRequest()->getParams();
		
		if($arr['day']) {
			$fd=$arr['day'];
			$qry = "SELECT *, DATE_FORMAT(start_date, '%M %d, %Y') as sdate, DATE_FORMAT(end_date, '%M %d, %Y') as edate FROM `events` WHERE `start_date` <= '".$fd." 23:59:59' and `end_date`>='".$fd." 00:00:00' and is_holiday='0' and is_exam ='0'";
			$e_eventdetail = $db->runQuery($qry);
			
			$string = $this->geteventlisthtml($e_eventdetail,$arr['day']);
			echo $string;
		}
		exit;
	}
	
	public function showholidayeventtooltipAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$arr=$this->getRequest()->getParams();
		
		if($arr['day']) {
			$fd=$arr['day'];
			$qry = "SELECT *, DATE_FORMAT(start_date, '%M %d, %Y') as sdate, DATE_FORMAT(end_date, '%M %d, %Y') as edate FROM `events` WHERE `start_date` <= '".$fd." 23:59:59' and `end_date`>='".$fd." 00:00:00' and is_holiday='1' and schoolid='".$mySession->user['schoolid']."'";
			$e_eventdetail = $db->runQuery($qry);
			
			$string = $this->geteventlisthtml($e_eventdetail,$arr['day']);
			echo $string;
		}
		exit;
	}
	
	public function showexameventtooltipAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		$arr=$this->getRequest()->getParams();
		
		if($arr['day']) {
			$fd=$arr['day'];
			$qry = "SELECT *, DATE_FORMAT(start_date, '%M %d, %Y') as sdate, DATE_FORMAT(end_date, '%M %d, %Y') as edate FROM `events` WHERE `start_date` <= '".$fd." 23:59:59' and `end_date`>='".$fd." 00:00:00' and is_exam ='1'";
			$e_eventdetail = $db->runQuery($qry);
			
			$string = $this->geteventlisthtml($e_eventdetail,$arr['day']);
			echo $string;
		}
		exit;
	}
	
	public function showduetooltipAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		exit;
	}
	public function showlistAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');
		exit;
	}
	public function eventdeleteAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			$condition = "schoolid='".$mySession->user['schoolid']."' and id='".$arr['eventid']."'";
			$db->delete('events',$condition);
			$mySession->sucMsg='Event deleted sucessfully';
		}		
		$this->_redirect('calendar');
		exit;
	}
	
	public function buildcommoneventshashAction($e,$key,$today)
	{	
		global $mySession;		
	}
	
	public function buildstudenteventshashAction($h,$key,$batch_id,$today)
	{	
		global $mySession;		
	}
	
	public function buildemployeeeventshashAction($h,$key,$department_id,$today)
	{	
		global $mySession;		
	}
	
	public function loadnotificationsAction()
	{	
		global $mySession;		
	}
	
	public function geteventlisthtml($evtlist,$day)
	{
	global $mySession;
		if(is_array($evtlist) && count($evtlist) > 0)
		{
			$expdate = explode("-",$day);
			$string = '<div class="current-date"> '.date('F Y',mktime(0,0,0,$expdate[1],$expdate[2],$expdate[0])).'</div>';
			foreach($evtlist as $elist) {
    
				  $string .= '<div class="events">
					<div class="title">
					<div style="width:12px;height:12px;background:#00b400; -moz-border-radius:2px; -webkit-border-radius:2px; margin:4px 3px 3px 3px; float:left;"></div>'.$elist['title'].'</div>
					<div class="extender"></div>
					<div class="desc">From :'.$elist['sdate'].'<br>To :'.$elist['sdate'].'</div>
					<div class="extender"></div>
					<div class="desc">'.$elist['description'].'</div>';
					if($mySession->user['usertype']=='S') {
						$string .= '<div class="extender"></div>
						<a href="'.BASE_PATH.'event/editevent/eventid/'.$elist['id'].'" class="delete">Edit</a>
						
						
						<a href="'.BASE_PATH.'calendar/eventdelete/eventid/'.$elist['id'].'" class="delete" onclick="return confirm(\'Are you sure?\');"> Delete</a>';
					}
					$string .= '<div class="extender"></div>
				  </div>';
		 	}
			return $string;
		}
	}
}
?>