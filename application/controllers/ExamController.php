<?php
__autoloadDB('Db');
class ExamController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
	}
	
	public function updateexamformAction()
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
		
		if(!isset($arr['batchid'])){
			$qry="select id as bid from batches where start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' and schoolid='".$mySession->user['schoolid']."' limit 0,1";
			$batchid=$db->runQuery("$qry");
				$arr['batchid']=$batchid[0]['bid'];				
		}
		
		if($arr['batchid']) {
			$data['name']=$arr['name'];
			$form = new Form_Newexamform($data);		
			if(isset($arr['mode']) && $arr['mode']=='add') {
				$request=$this->getRequest();
				
				if($form->isValid($request->getPost())) 
				{
				
					$totalsubject = $arr['totalsubject'];
					$examvalid = 1;
					for($x=0; $x < $totalsubject; $x++)
					{
						if($examvalid) {
						
							if(@$arr['exam_group_'.$x.'_delete']=='') {
								if($arr['exam_group_'.$x.'_start_time']=='')
								{
									$examvalid = 0;
								}
								if($arr['exam_group_'.$x.'_end_time']=='')
								{
									$examvalid = 0;
								}
								
								if($examvalid) {
									$starttime = $arr['exam_group_'.$x.'_start_time'];
									$endtime = $arr['exam_group_'.$x.'_end_time'];
								}
								if($arr['exam_type']!='Grades') {
									if($arr['exam_group_'.$x.'_maximum_marks']=='')
									{
										$examvalid = 0;
									}
									if($arr['exam_group_'.$x.'_minimum_marks']=='')
									{
										$examvalid = 0;
									}
								}
							}
						}
					}
					
					if($examvalid) {
						$modelobj = new Mainmodel();
						$Data['batch_id']=$arr['batchid'];
						$Data['name']=$arr['name'];	
						$Data['exam_type']=$arr['exam_type'];
						$Data['schoolid']=$mySession->user['schoolid'];
						
						$insid = $modelobj->insertThis('exam_groups',$Data);
						for($x=0; $x < $totalsubject; $x++)
						{
					
							if(@$arr['exam_group_'.$x.'_delete']=='') {
								$Data='';
								$Data['exam_group_id']=$insid;
								$Data['subject_id']=$arr['exam_group_'.$x.'_subject_id'];							
								$Data['start_time']=changeDateTime($arr['exam_group_'.$x.'_start_time']);
								$Data['end_time']=changeDateTime($arr['exam_group_'.$x.'_end_time']);								
								if($arr['exam_type']!='Grades') {
									$Data['maximum_marks']=$arr['exam_group_'.$x.'_maximum_marks'];
									$Data['minimum_marks']=$arr['exam_group_'.$x.'_minimum_marks'];
								} else {
									//$Data['grading_level_id']=$arr['batchid'];
								}
								$Data['schoolid']=$mySession->user['schoolid'];
								
								$modelobj->insertThis('exams',$Data);
							}
						}
						$mySession->sucMsg = LNG_EXAM_CREATED;
						$this->_redirect('examgroups/index/batchid/'.$arr['batchid']);		
						exit;
					}
					
				}
			}
			$this->view->form = $form;
			
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$arr['batchid']."' and b.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];
			
			$qry="select * from `subjects` where grade_id in (select grade_id from batches where id='".$arr['batchid']."')";
			$slist=$db->runQuery("$qry");
			$this->view->slist=$slist;
			
			$this->view->batchid = $arr['batchid'];	
			$this->view->name = $arr['name'];
			//$this->view->exam_type=$arr['exam_type'];
			$this->view->exam_type='Marks';
		}
	}
	
	public function publishAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();		
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		if($arr['examgroupid']) {
		$this->view->examgroupid = $arr['examgroupid'];
		$this->view->status = $arr['status'];
			$condition = "id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
			if($arr['status']=='schedule') { 
				$data['is_published'] = '1';
			} else {
				$data['result_published'] = '1';
			}
			$modelobj = new Mainmodel();
			
			$modelobj->updateThis('exam_groups',$data,$condition);
		}
	}
	
	public function groupingAction()
	{	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();		
		
		if($arr['batchid']) { 
			$objRequest = $this->getRequest();
			if ($objRequest->isPost()) {
				$condition = "batch_id='".$arr['batchid']."'";
				$db->delete('grouped_exams',$condition);
				
				$modelobj = new Mainmodel();
				
				if(is_array($arr['exam_group_ids']) && count($arr['exam_group_ids']) >0)
				{
					foreach($arr['exam_group_ids'] as $ids)
					{
						$data = array();
						$data['exam_group_id'] = $ids;
						$data['batch_id'] = $arr['batchid'];
						$data['schoolid'] = $mySession->user['schoolid'];
						
						$modelobj->insertThis('grouped_exams',$data);
						$mySession->sucMsg = LNG_EXAM_GROUPED;
					}
				}
			}
			$this->view->batchid = $arr['batchid'];
			$qry="select e.*, ge.id as gid from `exam_groups` as e left join grouped_exams as ge on(e.id=ge.exam_group_id) where e.batch_id='".$arr['batchid']."' and e.schoolid='".$mySession->user['schoolid']."'";
			$elist=$db->runQuery("$qry");
			$this->view->elist=$elist;
		}	
		
	}
	
	public function examwisereportAction()
	{	
		global $mySession;
		$db = new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry2="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batcheslist=$db->runQuery("$qry2");
		
		$this->view->batcheslist = $batcheslist;
	}
	
	public function listexamtypesAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		if($arr['batch_id']) {
			$this->view->batchid = $arr['batchid'];
			
			$qry="select id, name from `exam_groups` where batch_id='".$arr['batch_id']."' and result_published='1' and is_published='1' and schoolid='".$mySession->user['schoolid']."'";
			
			$elist=$db->runQuery("$qry");
			$this->view->elist=$elist;
		}
	}
	
	public function generatedreportAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(!empty($arr['exam_group_id'])) {
			$qry = "select batch_id, result_published from exam_groups where id='".$arr['exam_group_id']."'";
			$exambatch = $db->runQuery("$qry");	
			
			if(is_array($exambatch) && count($exambatch) > 0) {	
			
				$arr['batch_id'] = $exambatch[0]['batch_id'];
			
				if($arr['student']) {
					$student_getid = $arr['student'];				
				} else {				
					$student_getid = 0;
					$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id limit 0,1";
							
					$resid = $db->runQuery("$qry");
					if(is_array($resid) && count($resid) > 0) {
						$student_getid = $resid[0]['id'];
					}
				}
				
				if($exambatch[0]['result_published']==1) {
				$this->view->resultpublish = 1;
				if($student_getid) {
					$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' and id < '".$student_getid."' order by id desc limit 0,1";
					$prvid = $db->runQuery("$qry");
					$prv_studentid = 0;
					if(is_array($prvid) && count($prvid) > 0) {
						$prv_studentid = $prvid[0]['id'];
					}
					
					$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' and id > '".$student_getid."' order by id limit 0,1";
					$nextid = $db->runQuery("$qry");
					$next_studentid = 0;
					if(is_array($nextid) && count($nextid) > 0) {
						$next_studentid = $nextid[0]['id'];
					}
					
					$this->view->prvnext = 1;
					if($next_studentid==0 && $prv_studentid==0) {
						$this->view->prvnext = 0;
					}
					if($next_studentid!=0 && $prv_studentid==0) {
						$qry ="select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id desc limit 0,1";
					
						$resid = $db->runQuery("$qry");
						if(is_array($resid) && count($resid) > 0) {
							$prv_studentid = $resid[0]['id'];
						}
					}
					if($next_studentid==0 && $prv_studentid!=0) {
						$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id limit 0,1";
					
						$resid = $db->runQuery("$qry");
						if(is_array($resid) && count($resid) > 0) {
							$next_studentid = $resid[0]['id'];
						}
					}
					
					$this->view->student_getid = $student_getid;
					$this->view->prv_studentid = $prv_studentid;
					$this->view->next_studentid = $next_studentid;
					
					$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name, g.code  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.id='".$student_getid."' and s.schoolid='".$mySession->user['schoolid']."'";
					$studentinfo = $db->runQuery($qry);
					$this->view->studentinfo = $studentinfo;
					
					//// exam 
					$this->view->exam_group_id = $arr['exam_group_id'];
					
					$qry="select * from `exam_groups` where id='".$arr['exam_group_id']."' and batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."' and result_published='1' and is_published='1'";
					$examgroup = $db->runQuery($qry);
					$this->view->examgroup = $examgroup;
					
					$exid = array();
					foreach($examgroup as $eg) {
						$exid[] = $eg['id'];
					}
					
					$qry="select id, name, code from `subjects` where id in(select subject_id from exams where exam_group_id in (select id from `exam_groups` where batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."' and result_published='1' and is_published='1'))";
					$subjects = $db->runQuery($qry);
					$this->view->subjects = $subjects;
					
					if(is_array($exid) && count($exid) > 0) {
					$exids = implode(",",$exid);
					$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$student_getid."' order by e.subject_id";
						$examscoreresult = $db->runQuery($qry);
						foreach($examscoreresult as $es) {
							$examscore[$es['subject_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['marks'] = $es['marks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
						}
						$this->view->examscore = $examscore;
						
						
					}
				}		
			} else {
				$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name, g.code  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.id='".$student_getid."' and s.schoolid='".$mySession->user['schoolid']."'";
				$studentinfo = $db->runQuery($qry);
				$this->view->studentinfo = $studentinfo;
				
				$qry="select * from `exam_groups` where id='".$arr['exam_group_id']."' and batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."' ";
					$examgroup = $db->runQuery($qry);
					$this->view->examgroup = $examgroup;
				
				$this->view->resultpublish = 0;
			}
			}
		}
	}
	
	
	
	public function subjectwisereportAction()
	{	
		global $mySession;
		$db = new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry2="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batcheslist=$db->runQuery("$qry2");
		
		$this->view->batcheslist = $batcheslist;
	}
	
	public function listsubjectsAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		if($arr['batch_id']) {
			$this->view->batchid = $arr['batchid'];
			
			$qry="select id, name, code from `subjects` where grade_id in(select grade_id from batches where id='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."') and is_deleted='0'";
			
			$elist=$db->runQuery("$qry");
			$this->view->elist=$elist;
		}
		
	}
	
	public function generatedreport2Action()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(!empty($arr['subject_id']) && !empty($arr['batch_id'])) {
			$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name, g.code  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.batch_id='".$arr['batch_id']."' and s.schoolid='".$mySession->user['schoolid']."'";
			$studentinfo = $db->runQuery($qry);
			$this->view->studentinfo = $studentinfo;
			
			$qry="select * from `subjects` where id ='".$arr['subject_id']."'";
				$subject = $db->runQuery($qry);
				$this->view->subject = $subject;
				
			$qry="select * from `exam_groups` where batch_id ='".$arr['batch_id']."' and schoolid='".$mySession->user['schoolid']."' and result_published='1' and is_published='1'";
				$examgroup = $db->runQuery($qry);
				$this->view->examgroup = $examgroup;
				
				$exid = array();
				foreach($examgroup as $eg) {
					$exid[] = $eg['id'];
				}
			
			if(is_array($exid) && count($exid) > 0) {
				$exids = implode(",",$exid);
				$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and e.subject_id='".$arr['subject_id']."' order by e.subject_id";
				$examscoreresult = $db->runQuery($qry);
				foreach($examscoreresult as $es) {
					$examscore[$es['student_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['marks'] = $es['marks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
					$examscore[$es['student_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
				}
				$this->view->examscore = $examscore;					
					
			}
		}
	}
	
	
	public function generatedreport3Action()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(!empty($arr['subject_id']) && !empty($arr['student_id'])) {
			$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name, g.code  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.id='".$arr['student_id']."' and s.schoolid='".$mySession->user['schoolid']."'";
			$studentinfo = $db->runQuery($qry);
			$this->view->studentinfo = $studentinfo;
			
			$qry="select * from `subjects` where id ='".$arr['subject_id']."'";
				$subject = $db->runQuery($qry);
				$this->view->subject = $subject;
				
			$qry="select * from `exam_groups` where batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."' and result_published='1' and is_published='1'";
				$examgroup = $db->runQuery($qry);
				$this->view->examgroup = $examgroup;
				
				$exid = array();
				foreach($examgroup as $eg) {
					$exid[] = $eg['id'];
				}
			
			if(is_array($exid) && count($exid) > 0) {
				$exids = implode(",",$exid);
				$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and e.subject_id='".$arr['subject_id']."' order by e.subject_id";
				$examscoreresult = $db->runQuery($qry);
				foreach($examscoreresult as $es) {
					$examscore[$es['student_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['marks'] = $es['marks'];
					$examscore[$es['student_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
					$examscore[$es['student_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
				}
				$this->view->examscore = $examscore;					
					
			}
		}	
	}
	
	public function finalreporttypeAction()
	{	
		global $mySession;
		$db = new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry2="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batcheslist=$db->runQuery("$qry2");
		
		$this->view->batcheslist = $batcheslist;
	}
	public function studentresultinfoAction()
	{
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($arr['batch_id']!='' || $arr['student']!='') {
			if($arr['student']) {
				$student_getid = $arr['student'];
				$qry = "select batch_id from students where schoolid='".$mySession->user['schoolid']."' and id='".$arr['student']."' limit 0,1";
						
				$resid = $db->runQuery("$qry");
				if(is_array($resid) && count($resid) > 0) {				
					$arr['batch_id'] =  $resid[0]['batch_id'];
				}				
			} else {				
				$student_getid = 0;
				$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id limit 0,1";
						
				$resid = $db->runQuery("$qry");
				if(is_array($resid) && count($resid) > 0) {
					$student_getid = $resid[0]['id'];
					
					$arr['student'] = $student_getid;
				}
				
			}
			
			
			if($student_getid) {
				
						
				//// --- exam detail
				$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.id='".$arr['student']."' and s.schoolid='".$mySession->user['schoolid']."'";
				$studentinfo = $db->runQuery($qry);
				if(is_array($studentinfo) && count($studentinfo) > 0)
				{
				$this->view->studentinfo = $studentinfo;
					$qry="select Group_concat(exam_group_id) as ids from `grouped_exams` where batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."'"; 
					$groupedexams = $db->runQuery($qry);
				
					if(is_array($groupedexams) && count($groupedexams) > 0 && @$groupedexams[0]['ids']!='') {
						$where = " and id in (".$groupedexams[0]['ids'].")";
					} else {
						$where = " and batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
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
					
						$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$arr['student']."' order by e.subject_id";
						$examscoreresult = $db->runQuery($qry);
						foreach($examscoreresult as $es) {
							$examscore[$es['subject_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['marks'] = $es['marks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
						}
						$this->view->examscore = $examscore;
						
						
					}
					
				}			
			}
		}
	}
	public function generatedreport4Action()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		if($arr['batch_id']!='' || $arr['student']!='') {
			if($arr['student']) {
				$student_getid = $arr['student'];
				$qry = "select batch_id from students where schoolid='".$mySession->user['schoolid']."' and id='".$arr['student']."' limit 0,1";
						
				$resid = $db->runQuery("$qry");
				if(is_array($resid) && count($resid) > 0) {				
					$arr['batch_id'] =  $resid[0]['batch_id'];
				}				
			} else {				
				$student_getid = 0;
				$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id limit 0,1";
						
				$resid = $db->runQuery("$qry");
				if(is_array($resid) && count($resid) > 0) {
					$student_getid = $resid[0]['id'];
					
					$arr['student'] = $student_getid;
				}
				
			}
			
			
			if($student_getid) {
				/// / --- get next previous student id
				
						$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' and id < '".$student_getid."' order by id desc limit 0,1";
						$prvid = $db->runQuery("$qry");
						$prv_studentid = 0;
						if(is_array($prvid) && count($prvid) > 0) {
							$prv_studentid = $prvid[0]['id'];
						}
						
						$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' and id > '".$student_getid."' order by id limit 0,1";
						$nextid = $db->runQuery("$qry");
						$next_studentid = 0;
						if(is_array($nextid) && count($nextid) > 0) {
							$next_studentid = $nextid[0]['id'];
						}
						
						$this->view->prvnext = 1;
						if($next_studentid==0 && $prv_studentid==0) {
							$this->view->prvnext = 0;
						}
						if($next_studentid!=0 && $prv_studentid==0) {
							$qry ="select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id desc limit 0,1";
						
							$resid = $db->runQuery("$qry");
							if(is_array($resid) && count($resid) > 0) {
								$prv_studentid = $resid[0]['id'];
							}
						}
						if($next_studentid==0 && $prv_studentid!=0) {
							$qry = "select id from students where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."' order by id limit 0,1";
						
							$resid = $db->runQuery("$qry");
							if(is_array($resid) && count($resid) > 0) {
								$next_studentid = $resid[0]['id'];
							}
						}
						
						$this->view->student_getid = $student_getid;
						$this->view->prv_studentid = $prv_studentid;
						$this->view->next_studentid = $next_studentid;
						
				//// --- exam detail
				$qry = "select s.id, concat(title,' ',first_name,' ',middle_name,' ',last_name) as name, s.batch_id, b.grade_id, b.name as batchname, g.grade_name  from students as s left join batches as b on (b.id=s.batch_id) left join grades as g on (g.id=b.grade_id) where s.id='".$arr['student']."' and s.schoolid='".$mySession->user['schoolid']."'";
				$studentinfo = $db->runQuery($qry);
				if(is_array($studentinfo) && count($studentinfo) > 0)
				{
				$this->view->studentinfo = $studentinfo;
					$qry="select Group_concat(exam_group_id) as ids from `grouped_exams` where batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."'"; 
					$groupedexams = $db->runQuery($qry);
				
					if(is_array($groupedexams) && count($groupedexams) > 0 && @$groupedexams[0]['ids']!='') {
						$where = " and id in (".$groupedexams[0]['ids'].")";
					} else {
						$where = " and batch_id ='".$studentinfo[0]['batch_id']."' and schoolid='".$mySession->user['schoolid']."'";
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
					
						$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$arr['student']."' order by e.subject_id";
						$examscoreresult = $db->runQuery($qry);
						foreach($examscoreresult as $es) {
							$examscore[$es['subject_id']][$es['exam_group_id']]['maxmarks'] = $es['maxmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['minmarks'] = $es['minmarks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['marks'] = $es['marks'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['is_failed'] = $es['is_failed'];
							$examscore[$es['subject_id']][$es['exam_group_id']]['grading_level_id'] = $es['grading_level_id'];
						}
						$this->view->examscore = $examscore;
						
						
					}
					
				}			
			}
		}	
	}
	
	public function createexamAction()
	{	
		global $mySession;
		$db=new Db();
		
		$qry="select * from `grades` where schoolid='".$mySession->user['schoolid']."'";
		$glist=$db->runQuery("$qry");
		$this->view->glist=$glist;
		
	}
	
	
	public function updatebatchAction()
	{	
		global $mySession;	
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();
		
		if($arr['grade_id']) {
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.grade_id='".$arr['grade_id']."' and b.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist;
		}	
	}
	
	public function generatefinalAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$objRequest = $this->getRequest();
		
		if ($objRequest->isPost()) {
			$this->view->batchid = $arr['search_batchid'];
			$this->view->semid = $arr['search_semid'];
			
			if($arr['search_semid']==1)
			{
				$sem_condition = " and e.start_time >= b.start_date and end_time < b.sec_sem_start_date ";
			} else {
				$sem_condition = " and e.start_time >= b.sec_sem_start_date and end_time <= b.end_date ";
			}
			$qry = "select stu.id as stuid, b.id as batchid, es.id as esid, SUM(es.marks) as marksobt, SUM(e.maximum_marks) as maxmarks from `students` as stu left join `batches` as b on (stu.batch_id=b.id) left join `exam_scores` as es on (es.student_id=stu.id) left join `exams` as e on (e.id=es.exam_id) where stu.schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['search_batchid']."' ".$sem_condition." GROUP BY stu.id";
			$finalscore = $db->runQuery("$qry");			
				
				$delete_pre = " schoolid='".$mySession->user['schoolid']."' and batchid='".$arr['search_batchid']."' and sem_id='".$arr['search_semid']."'";				
				$db->delete('generate_final_score',$delete_pre);
				//echo"aaaaaaaaaa";exit;
				foreach($finalscore as $final)
				{
				$percent = ($final['marksobt']/ $final['maxmarks']) * 100;
					$Data['schoolid'] = $mySession->user['schoolid'];
					$Data['batchid'] = $final['batchid'];
					$Data['sem_id'] = $arr['search_semid'];
					$Data['student_id'] = $final['stuid'];				
					if($final['marksobt']){
						$Data['stu_max_marks'] = $final['maxmarks'];
					} else {
						$Data['stu_max_marks'] = 0;
					}
					if($final['maxmarks']){
						$Data['stu_obt_marks'] = $final['marksobt'];
					} else {
						$Data['stu_obt_marks'] = 0;
					}
					$Data['percentage'] = $percent;
					//echo"<pre>";print_r($Data);exit;
					$modelobj = new Mainmodel();
					$insid = $modelobj->insertThis('generate_final_score',$Data);
				}
			
		}
		
	}
	
	public function batchlistcomboAction()
	{	
		global $mySession;
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($arr['search_year'])
		{
			$batchdate_condition = '';
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." and YEAR(b.start_date)='".$arr['search_year']."' order by name";		
			$blist = $db->runQuery($qry);
			$this->view->batchlist = $blist;
		}
		
	}
}
?>