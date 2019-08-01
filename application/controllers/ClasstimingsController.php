<?php
__autoloadDB('Db');
class ClasstimingsController extends AppController
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
		if($arr['batchid']) { $this->view->batchid= $arr['batchid']; }
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."' ".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;		
		
	}
	public function periodlistbydayAction()
	{
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batchid']!='') {
			if($arr['weekdayid']!='') { 
				$wcondition = "and weekday_id='".$arr['weekdayid']."'";
			} else {
				$wcondition ="";
			}
			$qry = "select * from `class_timings` where id in (select class_timing_id from timetable_entries where batch_id='".$arr['batchid']."' ".$wcondition." and schoolid='".$mySession->user['schoolid']."')";
			
			$classtimingarray = $db->runQuery("$qry");
			$this->view->timings=$classtimingarray;	
				
		}	
	}
	public function newAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->mode = 0;
		if(@$arr['batch_id']) {
		$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
		$weekdayarray=$db->runQuery("$qry");
		$this->view->weekdayarray = $weekdayarray;
		
		$Form = new Form_Classtiming();
		if(isset($arr['mode']) && $arr['mode']=='add') {
			$this->view->mode = 2;
			
			$request=$this->getRequest();			
			if ($Form->isValid($request->getPost())) 
			{
				$this->view->mode = 1;
				
				$modelobj = new Mainmodel();
				$Data='';
				if(@$arr['batch_id']) {
					$batchid=$arr['batch_id'];
				} else {
					$batchid=0;
				}
			
				$this->view->batchid = $batchid;
				$Data['batch_id']=$batchid;
				$Data['name']=$arr['name'];
				$Data['start_time']=$arr['start_time_1'].':'.$arr['start_time_2'].':00';
				$Data['end_time']=$arr['end_time_1'].':'.$arr['end_time_2'].':00';
				$Data['is_break']=@$arr['class_timing_is_break'];
				$Data['schoolid']=$mySession->user['schoolid'];
				
				$insid = $modelobj->insertThis('class_timings',$Data);
				// if all week day period can be diffrent
				if(is_array($arr['selweekday']) && count($arr['selweekday']) > 0) {
					foreach($arr['selweekday'] as $wdarray) {
						$chk = "select * from `timetable_entries` where batch_id='".$arr['batch_id']."' and weekday_id='".$wdarray."' and class_timing_id='".$insid."'";
						$ttentry=$db->runQuery("$chk");
						if(count($ttentry) < 1)
						{
							$Data='';
							$Data['weekday_id']=$wdarray;
							$Data['class_timing_id']=$insid;
							$Data['batch_id']=$arr['batch_id'];
							$Data['schoolid']=$mySession->user['schoolid'];
							
							$modelobj->insertThis('timetable_entries',$Data);
						}
					}
				}				
				$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
				$timings = $db->runQuery("$qry");
				$this->view->timings=$timings;
			}
		}
		if($this->view->mode!=1) {		
			if (isset($arr['batch_id'])) {
						
				if($arr['batch_id']) {
					$qry="select batches.id, concat(grades.code,' - ',batches.name) as batchname from `batches` left join grades on (grades.id=batches.grade_id) where batches.id='".$arr['batch_id']."'";
					$attend = $db->runQuery("$qry");
					$this->view->batch_id=$arr['batch_id'];
				} else {
					$attend[0]['id']=0;
					$attend[0]['batchname']='Common';
					$this->view->batch_id=0;
				}			
							
			} else {
				$attend[0]['id']=0;
				$attend[0]['batchname']='Common';
				$this->view->batch_id=0;
			}
			$this->view->form = $Form;	
			$this->view->batchdetail=$attend;
		} else {
				$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
				$classtimingarray = $db->runQuery("$qry");
				$this->view->timings=$classtimingarray;			
				
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
				}*/
			
				$mymodelobj = new Timetable();
				$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray,0);
				
				$myclasstiming = new Classtiming();
				$this->view->classtiminghtml = $myclasstiming->htmlstring($this->view->timetablehtml,$classtimingarray,$arr['batch_id'],$weekdayarray);
		}
		}
	}
	
	public function createAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
			$modelobj = new Mainmodel();
			$Data='';
			if(@$arr['batch_id']) {
				$batchid=$arr['batch_id'];
			} else {
				$batchid=0;
			}
		
			$this->view->batchid = $batchid;
			$Data['batch_id']=$batchid;
			$Data['name']=$arr['name'];
			$Data['start_time']=$arr['start_time_1'].':'.$arr['start_time_2'].':00';
			$Data['end_time']=$arr['end_time_1'].':'.$arr['end_time_2'].':00';
			$Data['is_break']=@$arr['class_timing_is_break'];
			$Data['schoolid']=$mySession->user['schoolid'];
			
			$modelobj->insertThis('class_timings',$Data);
			
			$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
			$timings = $db->runQuery("$qry");
			$this->view->timings=$timings;			
		
		
	}
	
	public function editAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->param = $arr;
		$this->view->showtype = 0;
		if($arr['batch_id']) {
			$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$weekdayarray=$db->runQuery("$qry");
			$this->view->weekdayarray = $weekdayarray;
			
			$qry="select batches.id, concat(grades.code,' - ',batches.name) as batchname from `batches` left join grades on (grades.id=batches.grade_id) where batches.id='".$arr['batch_id']."'";
			$attend = $db->runQuery("$qry");
			$this->view->batch_id=$arr['batch_id'];
		
		$this->view->batchdetail=$attend;
		
		$qry="select * from `class_timings` where id='".$arr['id']."'";
		$timings = $db->runQuery("$qry");
		
		$Form = new Form_Classtiming($timings[0]);
		if(isset($arr['mode']) && $arr['mode']=='update') {
			$request=$this->getRequest();			
			$this->view->showtype = 3;
			if ($Form->isValid($request->getPost())) 
			{
			$modelobj = new Mainmodel();	
				$Data['name']=$arr['name'];
				$Data['start_time']=$arr['start_time_1'].':'.$arr['start_time_2'].':00';
				$Data['end_time']=$arr['end_time_1'].':'.$arr['end_time_2'].':00';
				$Data['is_break']=@$arr['class_timing_is_break'];
				
				$wherecondition = "id='".$arr['id']."'";
				
				$modelobj->updateThis('class_timings',$Data,$wherecondition);
				$insid = $arr['id'];
				// if all week day period can be diffrent
				$updateweedday = array();
				if(is_array($arr['selweekday']) && count($arr['selweekday']) > 0) {
					foreach($arr['selweekday'] as $wdarray) {
						$updateweedday[]= $wdarray;
						$chk = "select * from `timetable_entries` where batch_id='".$arr['batch_id']."' and weekday_id='".$wdarray."' and class_timing_id='".$insid."'";
						$ttentry=$db->runQuery("$chk");
						if(count($ttentry) < 1)
						{
							$Data='';
							$Data['weekday_id']=$wdarray;
							$Data['class_timing_id']=$insid;
							$Data['batch_id']=$arr['batch_id'];
							$Data['schoolid']=$mySession->user['schoolid'];
							
							$modelobj->insertThis('timetable_entries',$Data);
						}
					}
				}
				if(count($updateweedday) > 0) {
					$wcondition = " class_timing_id='".$arr['id']."' and weekday_id not in (".implode(",",$updateweedday).")";
				} else {
					$wcondition = " class_timing_id='".$arr['id']."' ";
				}
				
				$db->delete("timetable_entries",$wcondition);
			$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
			$timings = $db->runQuery("$qry");
			$this->view->timings=$timings;
			$this->view->showtype = 1;
			}	
		} elseif(isset($arr['mode']) && $arr['mode']=='delete') {
			$condition="id in (".$arr['id'].")";
			$db->delete('class_timings',$condition);
			
			$condition="class_timing_id in (".$arr['id'].")";
			$db->delete('period_entries',$condition);			
			
			$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
			$timings = $db->runQuery("$qry");
			$this->view->timings=$timings;
			$this->view->showtype = 2;	
		}
		if($this->view->showtype==0 || $this->view->showtype==3){
		
			$this->view->timings=$timings;		
			$this->view->form = $Form;
			
			$qry="select group_concat(weekday_id) as weekid from `timetable_entries` where batch_id='".$arr['batch_id']."' and class_timing_id='".$arr['id']."'";
			$periodentry = $db->runQuery("$qry");
			$this->view->pentry = array();
						
			if(is_array($periodentry) && count($periodentry) > 0) {
				$this->view->pentry = explode(",",$periodentry[0]['weekid']);
			}
			
		
		}
		if($this->view->showtype!=0) {
			$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
			$classtimingarray = $db->runQuery("$qry");
						
			
			
			$mymodelobj = new Timetable();
			$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray,0);
			
			$myclasstiming = new Classtiming();
			$this->view->classtiminghtml = $myclasstiming->htmlstring($this->view->timetablehtml,$classtimingarray,$arr['batch_id'],$weekdayarray);
		}
		} /*else {
			$attend[0]['id']=0;
			$attend[0]['batchname']='Common';
			$this->view->batch_id=0;
		}	*/
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
		if($arr['batch_id']) {
			$this->view->batchid = $arr['batch_id'];
		} else {
			$this->view->batchid = 0;
		}
		if (isset($arr['batch_id'])) {
			$qry="select * from `class_timings` where batch_id='".$arr['batch_id']."'";
			$timings = $db->runQuery("$qry");
			$this->view->timings=$timings;
			
			$qry="select id, weekday from `weekdays` where batch_id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
			$weekdayarray=$db->runQuery("$qry");
			if(is_array($weekdayarray) && count($weekdayarray) > 0) {
			$totalperiod = count($timings)*count($weekdayarray);
			
			$chk = "select count(te.id) as cnt from timetable_entries as te where te.batch_id='".$arr['batch_id']."' and te.schoolid='".$mySession->user['schoolid']."'";
			$res_chk = $db->runQuery($chk);
			if(@$res_chk[0]['cnt']!=$totalperiod) {
			// if all week days same period
			/*$modelobj = new Mainmodel();	
				foreach($weekdayarray as $wdarray) {
					foreach($timings as $ctarray) {
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
				}*/
			}
			$mymodelobj = new Timetable();
			$this->view->timetablehtml = $mymodelobj->timetablehtml($arr['batch_id'],$weekdayarray,0);
			} else {
				$this->view->timetablehtml="You need to be set weekday - <a href='".BASE_PATH."weekday/index/batchid/".$arr['batch_id']."'>Click here</a>";
				
			}
			$myclasstiming = new Classtiming();
			$this->view->classtiminghtml = $myclasstiming->htmlstring($this->view->timetablehtml,$timings,$arr['batch_id'],$weekdayarray);
			
		}
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	
}
?>