<?php
__autoloadDB('Db');
class ExamgroupsController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['batchid']) { $this->view->batchid= $arr['batchid']; }
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";		
		if($mySession->user['usertype']=='T') {
			$batchdate_condition .= " and b.id in (select distinct(batch_id) as batchid from `timetable_entries` where schoolid='".$mySession->user['schoolid']."' and employee_id='".$mySession->user['userownid']."') ";
		}
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."' ".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;
		if(!isset($arr['batchid'])) {
				$qry="select id as bid from batches where start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' and schoolid='".$mySession->user['schoolid']."' limit 0,1";
			$batchid=$db->runQuery("$qry");
				$arr['batchid']=$batchid[0]['bid'];		
		}
		if($arr['batchid']) {
			if(isset($arr['mode']) && $arr['mode']=='delete') {
				
				$condition = "id='".$arr['examgroupid']."' and batch_id='".$arr['batchid']."'";
				$db->delete('exam_groups',$condition);
				
				$condition = "exam_group_id='".$arr['examgroupid']."' ";
				$db->delete('exams',$condition);
				
			}
			$this->view->batchid = $arr['batchid'];
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$arr['batchid']."' and b.schoolid='".$mySession->user['schoolid']."'";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];
			
			$qry="select * from `exam_groups` where batch_id='".$arr['batchid']."' ";
			$elist=$db->runQuery("$qry");
			$this->view->elist=$elist;
			
		}
	}
	
	public function newAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$this->view->name = $arr['name'];	
		if($arr['batchid']) {
			
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$arr['batchid']."' and b.schoolid='".$mySession->user['schoolid']."'";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];
		}
	}
	
	public function createAction()
	{	
		global $mySession;		
	}
	
	public function editAction()
	{	
		global $mySession;		
	}
	
	public function updateAction()
	{	
		global $mySession;		
	}
	
	public function showAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$this->view->examgroupid = $arr['examgroupid'];	
		if($arr['examgroupid']) {
		
			if(isset($arr['mode']) && $arr['mode']=='delete') {
				$qry = "select * from exam_groups where id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
				$checkexam = $db->runQuery($qry);
				if(is_array($checkexam) && count($checkexam) > 0) {
					$condition = "id='".$arr['examid']."' and exam_group_id='".$arr['examgroupid']."' ";
					$db->delete('exams',$condition);
				}
			}
			
			$qry = "select * from exam_groups where id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
			$detail = $db->runQuery("$qry");
			$this->view->examgroupdetail = $detail[0];
			
			$qry = "select e.*, s.name, DATE_FORMAT(start_time, '%M %d, %Y %h:%i %p') as dtstart_time, DATE_FORMAT(end_time, '%M %d, %Y %h:%i %p') as dtend_time from exams as e left join subjects as s on(s.id=e.subject_id) where e.exam_group_id='".$detail[0]['id']."' ";
			$slist = $db->runQuery("$qry");
			$this->view->slist = $slist;
			
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$detail[0]['batch_id']."' and b.schoolid='".$mySession->user['schoolid']."'";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];
		}
	}
	public function setexammaximummarksAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['examid']) {
			$data['maximum_marks']=$arr['value'];
			$condition = "id='".$arr['examid']."'";
			
			$modelobj = new Mainmodel();
			$modelobj->updateThis('exams',$data,$condition);
		}
		echo $arr['value'];
		exit;	
	}
	public function setexamminimummarksAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['examid']) {
			$data['minimum_marks']=$arr['value'];
			$condition = "id='".$arr['examid']."'";
			
			$modelobj = new Mainmodel();
			$modelobj->updateThis('exams',$data,$condition);
		}
		echo $arr['value'];
		exit;	
	}
	public function setexamgroupnameAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['examgroupid']) {
			$data['name']=$arr['value'];
			$condition = "id='".$arr['examgroupid']."'";
			
			$modelobj = new Mainmodel();
			$modelobj->updateThis('exam_groups',$data,$condition);
		}
		echo $arr['value'];
		exit;	
	}
	public function destroyAction()
	{	
		global $mySession;		
	}
	
	public function initialqueriesAction()
	{	
		global $mySession;		
	}
}
?>