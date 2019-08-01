<?php
__autoloadDB('Db');
class UserController extends AppController
{
	
	public function indexAction()
	{	
		global $mySession;		
	}
	public function dashboardAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		//print_r($mySession->user['userstudentid']);
		if(is_array($mySession->user['userstudentid']) && count($mySession->user['userstudentid'])>0){	
			$wherecondition = '';	
			$studentids = implode(",",$mySession->user['userstudentid']);
			$wherecondition .= " and id in (".$studentids.")";
			
			$qry="select * from `students` where schoolid='".$mySession->user['schoolid']."' ".$wherecondition;			
			$studentlist=$db->runQuery("$qry");
			$this->view->studentlist=$studentlist;
		}
	}
	public function createAction()
	{	
		global $mySession;	
			//	exit;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$form = new Form_Adduser();		
		
		$this->view->form = $form;
		
		 if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				$data['username'] = $formData['username'];
				$data['first_name'] = $formData['first_name'];
				$data['last_name'] = $formData['last_name'];
				$data['hashed_password'] = md5($formData['password']);
				$data['email'] = $formData['email'];
				$data['schoolid'] = $formData['school'];
				$data['usertype'] = 'S';
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('users',$data);
				
				$mySession->sucMsg = LNG_SECRETARY_ADDED;
				$this->_redirect('user/manage');
			}
		 }
		
	}
	public function editAction()
	{	
		global $mySession;	
			//	exit;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
		if($arr['profileid']) { 
		$this->view->profileid = $arr['profileid'];
			$qry = "select * from users where id='".$arr['profileid']."' and usertype='S'";
			$detail = $db->runQuery($qry);
			
			$form = new Form_Adduser(@$detail[0]);
			$this->view->form = $form;
			
			 if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();			
				if ($form->isValid($formData)) {
				
					$data='';
					$data['username'] = $formData['username'];
					$data['first_name'] = $formData['first_name'];
					$data['last_name'] = $formData['last_name'];
					$data['hashed_password'] = md5($formData['password']);
					$data['email'] = $formData['email'];
					$data['schoolid'] = $formData['school'];
									
					$modelobj = new Mainmodel();
					$condition = "id='".$arr['profileid']."'";
					$insid = $modelobj->updateThis('users',$data,$condition);
					
					$mySession->sucMsg = LNG_SECRETARY_UPDATED;
					$this->_redirect('user/profile/profileid/'.$arr['profileid']);
				}
			 }
		 }
		
	}
	public function manageAction()
	{	
		global $mySession;
	}
	
	public function allAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry = "select id, name from school where 1";
		$detail = $db->runQuery("$qry");
		$this->view->schooldetail = $detail;
		if(isset($arr['schoolid']) && $arr['schoolid']!='') {
			$this->view->schoolid = $arr['schoolid'];
		}
	}
	public function listuserbyschoolAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($arr['school_id']) {
			$qry = "select * from users where schoolid='".$arr['school_id']."' and usertype='S'";
			$detail = $db->runQuery("$qry");
			$this->view->userdetail = $detail;
		}
	}
	public function listuserbysearchAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($arr['query']) {
			$qry = "select u.id, u.first_name, u.last_name, u.username, s.name as schoolname from users as u left join school as s on (s.id=u.schoolid)where (u.first_name like '%".$arr['query']."%' or u.last_name like '%".$arr['query']."%' or u.username like '%".$arr['query']."%') and u.usertype='S'";
			$detail = $db->runQuery("$qry");
			$this->view->userdetail = $detail;
		}
	}
	public function profileAction()
	{	
		global $mySession;	
		$objRequest = $this->getRequest();
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['profileid']) {
			$qry = "select u.*, s.name as schoolname from users as u left join school as s on (s.id=u.schoolid) where u.id='".$arr['profileid']."' and u.usertype='S'";
			$detail = $db->runQuery($qry);
			$this->view->detail = $detail[0];
		}
	}
	
	public function changepasswordAction()
	{	
		global $mySession;
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->chps = 1;
		if ($this->_request->isPost()) {	
			$Data = array();
			if($arr['user_new_password']==$arr['user_new_password']) {
				$Data['hashed_password']=md5($arr['user_new_password']);
							
				$where="id='".$mySession->user['userid']."'";
				$modelobj = new Mainmodel();
				$modelobj->updateThis('users',$Data,$where);
				
				$this->view->chps = 0;
				$mySession->sucMsg="Password has been updated successfully";
			} else {
				$mySession->errorMsg="Confirm password should be same";
			}
		}
	}
	
	public function userchangepasswordAction()
	{	
		global $mySession;
		
		$objRequest = $this->getRequest();
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['profileid']) {
			$qry = "select u.*, s.name as schoolname from users as u left join school as s on (s.id=u.schoolid) where u.id='".$arr['profileid']."' and u.usertype='S'";
			$detail = $db->runQuery($qry);
			$this->view->detail = $detail[0];
		}
	}
	public function deleteAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['profileid']) {
			$condition = "id='".$arr['profileid']."'";
			$db->delete('users',$condition);
			
			$mySession->sucMsg = LNG_SECRETORY_DELETED;
			$this->_redirect('users/all/');
		}
		exit;
	}
	public function changestatusAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['profileid']) {
			if($arr['status']=='enable') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
			
			$modelobj = new Mainmodel();
			$condition = "id='".$arr['profileid']."'";
			$modelobj->updateThis('users',$data,$condition);
			
			$info = $db->runQuery("select schoolid from users where id='".$arr['profileid']."'");
			
			$mySession->sucMsg = LNG_SCHOOL_STATUS_UPDATED;
			$this->_redirect('user/all/schoolid/'.@$info[0]['schoolid']);
		}		
	}
	
}
?>