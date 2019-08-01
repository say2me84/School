<?php
__autoloadDB('Db');
class ReminderController extends AppController
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

		$qry="SELECT a.*, DATE_FORMAT(a.created_at, '%d %M, %Y') as rdate, b.username, b.first_name, b.last_name, b.usertype	 
		FROM reminders a
		LEFT JOIN users b ON (a.sender = b.id)
		WHERE recipient = '".$mySession->user['userid']."' and is_deleted_by_recipient='0'
		ORDER BY created_at desc";
		
		$detail=$db->runQuery("$qry");
		$this->view->detail=$detail;

	}
	
	public function createreminderAction()
	{	
		
		global $mySession;	
		$db=new Db();
		if($mySession->user['usertype']!='A'){
		if($mySession->user['usertype']!='P'){
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry2="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
	
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
	
	public function sendtoteacherAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
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
		$qry = "select b.*, b.name as batchname, gr.grade_name, e.id as empid, concat(e.first_name,' ',e.last_name) as ename, concat(stu.first_name,' ',stu.last_name) as stu_name from `batches` as b left join `grades` as gr on (b.grade_id=gr.id) left join `employees` as e on (b.employee_id=e.id) left join `students` as stu on (stu.batch_id=b.id) where stu.id='".$arr['studentid']."'";
		$elist = $db->runQuery($qry);
		$this->view->elist = $elist[0];
		
		if($elist[0]['employee_id']==0){			
			$qry = "select *,concat(first_name,'',last_name) as sec_name from `users` where schoolid='".$mySession->user['schoolid']."' and usertype='S'";
			$sec = $db->runQuery($qry);
			$this->view->sec = $sec;
		}
		
		if(isset($arr['mode']) && $arr['mode']=='sendmsg'){
				
				$Data['sender'] = $mySession->user['userownid'];
				$Data['recipient'] = $arr['recipientid'];
				$Data['body'] = $arr['sendtoteacher'];
				$Data['created_at'] = date("Y-m-d H:i:s");
				$Data['updated_at'] = date("Y-m-d H:i:s");
				
				//echo"<pre>";print_r($Data); exit;
				$modelobj = new Mainmodel();
				$modelobj->insertThis('reminders',$Data);
				$mySession->sucMsg =LNG_MESSAGE_SUCCESSFULLY_SEND;
				$this->_redirect('reminder/sentreminder');
				exit;
		}
	}
	
	public function listschooluserAction()
	{	
		global $mySession;
	}
	
	public function selectemployeedepartmentAction()
	{	
		global $mySession;		
	}
	
	public function selectusersAction()
	{	
		global $mySession;		
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
	
	public function toemployeesAction()
	{	
		global $mySession;		
	}
	
	public function tostudentsAction()
	{	
		global $mySession;		
	}
	
	public function updaterecipientlistAction()
	{	
		global $mySession;		
	}
	
	public function sentreminderAction()
	{	
		global $mySession;		
				if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();

		$qry="SELECT a.*, DATE_FORMAT(a.created_at, '%d %M, %Y') as rdate, b.username, b.first_name, b.last_name, b.usertype	 
		FROM reminders a
		LEFT JOIN users b ON (a.recipient = b.id)
		WHERE sender = '".$mySession->user['userid']."' and is_deleted_by_sender='0'
		ORDER BY created_at desc";
		
		$detail=$db->runQuery("$qry");
		$this->view->detail=$detail;


	}
	
	public function viewsentreminderAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		if (isset($arr['msg_id'])) {
			$qry="SELECT a.*, DATE_FORMAT(a.created_at, '%d %M, %Y at %h:%i %p') as rdate, b.username, b.first_name, b.last_name	 
			FROM reminders a
			LEFT JOIN users b ON (a.recipient = b.id)
			WHERE a.id = '".$arr['msg_id']."'";

			$viewrem=$db->runQuery("$qry");
			
			$this->view->viewrem=$viewrem;
			
		}
		
		

	}
	
	public function deletereminderbysenderAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['reminderid']) && $arr['reminderid']!='') { 
			$data['is_deleted_by_sender'] = 1;
			$condition = "id='".$arr['reminderid']."' and sender='".$mySession->user['userid']."'";			
			$modelobj = new Mainmodel();
				
			$modelobj->updateThis('reminders',$data,$condition);
			$mySession->sucMsg = 'Message deleted successfully';
		} 
			
			$this->_redirect('reminder/sentreminder');
		
	}
	
	public function deletereminderbyrecipientAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['reminderid']) && $arr['reminderid']!='') { 
			$data['is_deleted_by_sender'] = 1;
			$condition = "id='".$arr['reminderid']."' and sender='".$mySession->user['userid']."'";			
			$modelobj = new Mainmodel();
				
			$modelobj->updateThis('reminders',$data,$condition);
			$mySession->sucMsg = 'Message deleted successfully';
		} 
			
			$this->_redirect('reminder');	
	}
	
	public function viewreminderAction()
	{	
		global $mySession;	
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		if (isset($arr['msg_id'])) {
			$qry="SELECT a.*, DATE_FORMAT(a.created_at, '%d %M, %Y at %h:%i %p') as rdate, b.username, b.first_name, b.last_name	 
			FROM reminders a
			LEFT JOIN users b ON (a.sender = b.id)
			WHERE a.id = '".$arr['msg_id']."'";

			$viewrem=$db->runQuery("$qry");
			
			$this->view->viewrem=$viewrem;
			if($viewrem[0]['is_read']==0) {
				$data['is_read'] = 1;
				
				$modelobj = new Mainmodel();
				$condition = "id = '".$arr['msg_id']."'";
				
				$modelobj->updateThis('reminders',$data,$condition);
			} 
		}
		
		
		
	}
	
	public function markunreadAction()
	{	
		global $mySession;		
	}
	
	public function pullreminderformAction()
	{	
		global $mySession;		
	}
	
	public function sendreminderAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		
		
		$arr=$this->getRequest()->getParams();
		
		$modelobj = new Mainmodel();
		$Data = array();
		$Data['senderID'] = $mySession->user['userid'];
					
		$groupid = $modelobj->insertThis('reminder_group',$Data);
				
		if(is_array($arr['management']) && count($arr['management']) > 0) {
			foreach($arr['management'] as $managementId)
			{			
				$Data = array();
				$Data['sender'] = $mySession->user['userid'];
				$Data['groupid'] = $groupid;
				$Data['recipient'] = $managementId;
				$Data['subject'] = $arr['reminder']['subject'];
				$Data['body'] = $arr['reminder']['body'];
				$Data['created_at'] = date("Y-m-d H:i:s");
				$Data['updated_at'] = date("Y-m-d H:i:s");
				
				$modelobj->insertThis('reminders',$Data);
			}
			$Data = array();
			$Data['rec_m_IDs'] = implode(",",$arr['management']);
			$condition = "id='".$groupid."'";
			$modelobj->updateThis('reminder_group',$Data,$condition);
			
		}
		if(is_array($arr['staff']) && count($arr['staff']) > 0) {
			foreach($arr['staff'] as $stafId)
			{			
				$Data = array();
				$Data['sender'] = $mySession->user['userid'];
				$Data['groupid'] = $groupid;
				$Data['recipient'] = $stafId;
				$Data['subject'] = $arr['reminder']['subject'];
				$Data['body'] = $arr['reminder']['body'];
				$Data['created_at'] = date("Y-m-d H:i:s");
				$Data['updated_at'] = date("Y-m-d H:i:s");
				
				$modelobj->insertThis('reminders',$Data);
			}
			$Data = array();
			$Data['rec_s_IDs'] = implode(",",$arr['staff']);
			$condition = "id='".$groupid."'";
			$modelobj->updateThis('reminder_group',$Data,$condition);
		}
		
		if(is_array($arr['totCls']) && count($arr['totCls']) > 0) {
		$prid_array= array();
			for($i=1;$i<=$arr['totCls'];$i++)
			{
				foreach($arr['stu_id'.$i] as $stuId)
				{
					//$db=new Db();
					$Data = array();
					$Data['sender'] = $mySession->user['userid'];
					$Data['groupid'] = $groupid;
					$Data['recipient'] = $stuId;
					$Data['subject'] = $arr['reminder']['subject'];
					$Data['body'] = $arr['reminder']['body'];
					$Data['created_at'] = date("Y-m-d H:i:s");
					$Data['updated_at'] = date("Y-m-d H:i:s");
					
					$this->view->instid = $modelobj->insertThis('reminders',$Data);
					$prid_array[] = $stuId; 
				}
			}
			if(count($prid_array) > 0) {
				$Data = array();
				$Data['rec_p_IDs'] = implode(",",$prid_array);
				$condition = "id='".$groupid."'";
				$modelobj->updateThis('reminder_group',$Data,$condition);
			}
		}
		
		$mySession->sucMsg = LNG_MESSAGE_SUCCESSFULLY_SEND;
		$this->_redirect('reminder');
	
	}
}
?>