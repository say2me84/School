<?php
__autoloadDB('Db');
class QuestionaireController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$qry="select *, DATE_FORMAT(createon,'%M %d, %Y %r') as dt from `ticket` where id in(select ticketid from `ticket_assigned` where userid='".$mySession->user['userid']."' and status='1') ";
		$ticketlist=$db->runQuery("$qry");
		$this->view->ticketlist=$ticketlist;
	}
		
	public function archiveAction()
	{	
		global $mySession;		
	}
	
	public function createAction()
	{	
		global $mySession;

		$db=new Db();
		if($mySession->user['usertype']!='A'){
		
		if($mySession->user['usertype']!='P'){
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry2="select b.*, c.code from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
	
		$batcheslist=$db->runQuery("$qry2");
		$this->view->detail=$batcheslist;
		}
		
		$qry = "select concat(e.first_name,' ',e.last_name) as name, u.id, d.name as dept_name, e.employee_department_id from employees as e left join employee_departments as d on (e.employee_department_id=d.id) left join users as u on (u.id=e.userid) where e.schoolid='".$mySession->user['schoolid']."' and e.status='1' and u.id!='".$mySession->user['userid']."' order by e.employee_department_id";
		
		$elist = $db->runQuery($qry);
		$this->view->elist = $elist;
		
		
		$qry = "select concat(e.first_name,' ',e.last_name) as name, e.id from users as e where e.schoolid='".$mySession->user['schoolid']."' and e.usertype='S' and e.id!='".$mySession->user['userid']."' order by e.first_name";
		
		$slist = $db->runQuery($qry);
		$this->view->slist = $slist;
		
		}else{
			
		$qry = "select concat(e.first_name,' ',e.last_name) as name, u.id, d.name as dept_name, e.employee_department_id from employees as e left join employee_departments as d on (e.employee_department_id=d.id) left join users as u on (u.id=e.userid) where e.status='1' order by e.schoolid, e.employee_department_id";
		$elist = $db->runQuery($qry);
		$this->view->elist = $elist;
		
		$qry = "select concat(e.first_name,' ',e.last_name) as name, s.name as sname, e.id from users as e left join school as s on (e.schoolid=s.id) where e.usertype='S' and e.id!='".$mySession->user['userid']."' order by s.name, e.first_name";
		
		$slist = $db->runQuery($qry);
		$this->view->slist = $slist;
		
		$qry = "select id, name from school where 1";
		$detail = $db->runQuery("$qry");
		$this->view->schooldetail = $detail;
		}
	}
	
	public function selectstudentcourseAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if (isset($arr['cls_id'])) {
		
		$cl_id = explode('|',$arr['cls_id']);
		$clsId = 'NULL';
		foreach($cl_id as $ci) { if($ci !='')  $clsId .= ' OR b.id = '.$ci; }

		
 		$qry="SELECT b.id, b.name, a.id as stu_id, a.first_name, a.middle_name, a.last_name 
			FROM students a
			LEFT JOIN batches b ON (a.batch_id = b.id)
			WHERE b.id = ".$clsId." ORDER BY b.name, a.first_name";

			$viewrem=$db->runQuery("$qry");
			
			//print_r($viewrem);
			
			$this->view->viewrem=$viewrem;
			
		}
		
		
		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}

	public function listschooluserAction()
	{	
		global $mySession;		
	}

	public function guardiansAction()
	{	
		global $mySession;		
	}
	
	public function ticketdetailAction()
	{	
		global $mySession;		
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$this->view->showpage = 0;
		if($arr['ticketid']) {
			if(isset($arr['mode']) && $arr['mode']=='addcomment'){
				$Data['ticketid']=$arr['ticketid'];
				$Data['userid']=$mySession->user['userid'];
				$Data['usercomment']=$arr['usercomment'];
				$Data['date']=date('Y-m-d h:i:s');
				
					$modelobj = new Mainmodel();
					$modelobj->insertThis('ticket_commented',$Data);
					$mySession->sucMsg =LNG_COMMENT_SUCCESSFULLY_POSTED;
					$this->_redirect('questionaire/ticketdetail/ticketid/'.$arr['ticketid']);
					exit;
			}
			$this->view->showpage = 1;
			$db=new Db();
				
			$qry="select *, DATE_FORMAT(createon,'%M %d, %Y %r') as dt from `ticket` where id ='".$arr['ticketid']."'";
			$ticketdetail=$db->runQuery("$qry");
			$this->view->ticketdetail=$ticketdetail;
			
			$qry="select t.*, u.usertype, concat(u.first_name,' ',u.last_name) as username, DATE_FORMAT(date,'%M %d, %Y %r') as dt from `ticket_commented` as t left join users as u on (u.id=t.userid) where t.ticketid ='".$arr['ticketid']."'";
			$comments=$db->runQuery("$qry");
			$this->view->comments=$comments;
		}
	}
	
	public function sendticketAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		$arr=$this->getRequest()->getParams();
		
		$modelobj = new Mainmodel();
		
		$TData['title'] = $arr['reminder']['subject'];
		$TData['description'] = $arr['reminder']['body'];
		$TData['createon'] = date("Y-m-d H:i:s");
		$TData['notifydate'] = $arr['questionaire_create_date'];
		$TData['created_by'] = $mySession->user['userid'];
		
		$lastInsId = $modelobj->insertThis('ticket',$TData);
		
		
		for($i=1;$i<=$arr['totCls'];$i++)
		{
			foreach($arr['stu_id'.$i] as $stuId)
			{
				//$db=new Db();
				
				$Data['ticketid'] = $lastInsId;
				$Data['userid'] = $stuId;
				
				$this->view->instid = $modelobj->insertThis('ticket_assigned',$Data);
				
			}
		}
		
		echo '<div style="color:#FF2323;" >messege/s sent successfully.</div>';
	
	}
	
	
}
?>