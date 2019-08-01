<?php
__autoloadDB('Db');
class ExamsController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
	}
	
	public function newAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		$this->view->examgroupid=$arr['examgroupid'];
		
		$qry = "select * from exam_groups where id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
		$detail = $db->runQuery("$qry");
		$this->view->examgroupdetail = $detail[0];		
		
		$this->view->exam_type = $detail[0]['exam_type'];
		$data[0]['exam_type']= $detail[0]['exam_type'];
		$form = new Form_Newexam($data[0],$detail[0]['batch_id']);
			
		if($arr['examgroupid']) {
		
		    if ($this->_request->isPost()) {	
            $formData = $this->_request->getPost();
				if($form->isValid($formData))
				{ 
					$Data='';
					$Data['exam_group_id']=$arr['examgroupid'];	
					$Data['subject_id']=$arr['exam_subject'];							
					$Data['start_time']=changeDateTime($arr['exam_start_time']);
					$Data['end_time']=changeDateTime($arr['exam_end_time']);
					if($data[0]['exam_type']!='Grades') {
						$Data['maximum_marks']=$arr['maximum_marks'];
						$Data['minimum_marks']=$arr['minimum_marks'];
					} else {
						//$Data['grading_level_id']=$arr['batchid'];
					}
					$Data['schoolid']=$mySession->user['schoolid'];
					
					
					$modelobj = new Mainmodel();
					$modelobj->insertThis('exams',$Data);
					
					$this->_redirect('examgroups/show/examgroupid/'.$arr['examgroupid']);		
					exit;
				}
			}
			
			
 			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$detail[0]['batch_id']."' and b.schoolid='".$mySession->user['schoolid']."'";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];	
		
			
			$this->view->form = $form;	
		
		}

	}
	
	public function createAction()
	{	
		global $mySession;		
	}
	
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$this->view->examid=$arr['examid'];
		$this->view->examgroupid=$arr['examgroupid'];
		
		$qry = "select * from exam_groups where id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
		$detail = $db->runQuery("$qry");
		$this->view->examgroupdetail = $detail[0];
		
		$qry="select *, DATE_FORMAT(start_time, '%M %d, %Y %h:%i %p') as dtstart_time, DATE_FORMAT(end_time, '%M %d, %Y %h:%i %p') as dtend_time from `exams` where id='".$arr['examid']."'"; 
		$data=$db->runQuery("$qry");
		$this->view->exam_type = $detail[0]['exam_type'];
		$data[0]['exam_type']= $detail[0]['exam_type'];
		$form = new Form_Newexam($data[0],$detail[0]['batch_id']);
			
		if($arr['examid']) {
		
		    if ($this->_request->isPost()) {	
            $formData = $this->_request->getPost();
				if($form->isValid($formData))
				{ 
					$Data='';
				
					$Data['subject_id']=$arr['exam_subject'];							
					$Data['start_time']=changeDateTime($arr['exam_start_time']);
					$Data['end_time']=changeDateTime($arr['exam_end_time']);
					if($data[0]['exam_type']!='Grades') {
						$Data['maximum_marks']=$arr['maximum_marks'];
						$Data['minimum_marks']=$arr['minimum_marks'];
					} else {
						//$Data['grading_level_id']=$arr['batchid'];
					}
					$condition = "id='".$arr['examid']."'";
					$modelobj = new Mainmodel();
					$modelobj->updateThis('exams',$Data,$condition);
					$mySession->sucMsg =LNG_EXAM_UPDATED; 
					$this->_redirect('examgroups/show/examgroupid/'.$arr['examgroupid']);		
					exit;
				}
			}
			
			
 			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$detail[0]['batch_id']."' and b.schoolid='".$mySession->user['schoolid']."'";
			$blist=$db->runQuery("$qry");
			$this->view->blist=$blist[0];	
		
			
			$this->view->form = $form;	
		
		}
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
		$this->_helper->layout()->setLayout('ajaxlayout');
		$this->view->examid=$arr['examid'];
		$this->view->examgroupid=$arr['examgroupid'];
		
		if($arr['examid']) {
			$qry = "select * from exam_groups where id='".$arr['examgroupid']."' and schoolid='".$mySession->user['schoolid']."'";
			$detail = $db->runQuery("$qry");
			$this->view->examgroupdetail = $detail[0];
			
			$qry="select b.*, c.code, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id='".$detail[0]['batch_id']."' and b.schoolid='".$mySession->user['schoolid']."'";
				$blist=$db->runQuery("$qry");
				$this->view->blist=$blist[0];
			
			$qry="select e.*, s.name from `exams` as e left join `subjects` as s on (s.id=e.subject_id) where e.id='".$arr['examid']."'";
			$edetail=$db->runQuery("$qry");
			$this->view->edetail=$edetail[0];
			
		 	if($detail[0]['exam_type']=='Marks') {
				$qry="select s.id as sid, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as name, es.* from `students` as s left join exam_scores as es on(s.id=es.student_id and es.exam_id='".$arr['examid']."') where s.batch_id='".$detail[0]['batch_id']."' and s.schoolid='".$mySession->user['schoolid']."'";
			} else {
				$qry="select s.id as sid, concat(s.title,' ',s.first_name,' ',s.middle_name,' ',s.last_name) as name, es.* from `students` as s left join exam_scores as es on(s.id=es.student_id and es.exam_id='".$arr['examid']."') left join grading_levels as g on(es.grading_level_id=g.id) where s.batch_id='".$detail[0]['batch_id']."' and s.schoolid='".$mySession->user['schoolid']."'";
			}
		
			$slist=$db->runQuery("$qry");
			$this->view->slist=$slist;
		}
	}
	
	public function destroyAction()
	{	
		global $mySession;		
	}
	
	public function savescoresAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');		
		$this->view->examid=$arr['examid'];
		$this->view->examgroupid=$arr['examgroupid'];
		if($arr['examid']) {
		
			$sids = explode(",",$arr['sids']);
			$modelobj = new Mainmodel();
			
			$qry="select * from `exams` where id='".$arr['examid']."'";
			$edetail=$db->runQuery("$qry");
							
			foreach($sids as $sid) {
				$data = array();
				$data['student_id'] = $sid;
				$data['exam_id'] = $arr['examid'];
				$data['grading_level_id'] = '';
				if($arr['examtype']!='Grades') {
					$data['marks'] = $arr['exam_'.$sid.'_marks'];
					if($arr['exam_'.$sid.'_marks'] < $edetail[0]['minimum_marks'] && $arr['exam_'.$sid.'_marks']!='') {
						$data['is_failed'] = 1;
					} else {
						$data['is_failed'] = 0;
					}
				}
				if($arr['examtype']!='Marks' && $arr['exam_'.$sid.'_marks']!='') {
					 $sub_persent = ($arr['exam_'.$sid.'_marks'] / $edetail[0]['maximum_marks']) * 100;
					 $qry = "select id from grading_levels where min_score <= '". $sub_persent."' and batch_id='".$arr['batchid']."' order by min_score desc limit 0,1";
					$resgrading =$db->runQuery($qry);
					
					if(count($resgrading)< 1) {
						$qry = "select id from grading_levels where min_score <= '". $sub_persent."' and batch_id='0' order by min_score desc limit 0,1";
					$resgrading = $db->runQuery($qry);
					}
					if(is_array($resgrading) && count($resgrading) > 0) {
						$data['grading_level_id'] = $resgrading[0]['id'];
					}
				}
				$data['remarks'] = $arr['exam_'.$sid.'_remarks'];				
				$data['schoolid'] = $mySession->user['schoolid'];
								
				if($arr['exam_'.$sid.'_scoreid']) {
					$data['updated_at'] = date('Y-m-d h:i:s');
					
					$condition = "id='".$arr['exam_'.$sid.'_scoreid']."'";					
					$modelobj->updateThis('exam_scores',$data,$condition);
				} else {
					$data['created_at'] = date('Y-m-d h:i:s');
					$modelobj->insertThis('exam_scores',$data);
				}
				
				
			}
			//$mySession->sucMsg =LNG_EXAM_SCORES_UPDATED; 
			//$this->_redirect('exams/show/examgroupid/'.$arr['examgroupid'].'/examid/'.$arr['examid']);		
			
					
		}
	}
	
	public function querydataAction()
	{	
		global $mySession;		
	}
}
?>