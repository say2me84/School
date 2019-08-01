<?php
__autoloadDB('Db');
class AdminController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	public function profileAction()
	{	
		global $mySession;
		
		$objRequest = $this->getRequest();
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		
			$qry = "select * from users where id='".$mySession->user['userid']."' and usertype='A'";
			$detail = $db->runQuery($qry);
			$this->view->detail = $detail;
		
	}
	
	public function editAction()
	{	
		global $mySession;
		
		$form = new Form_Adduser(@$detail[0]);
		$this->view->form = $form;
	}
	
	public function changepasswordAction()
	{	
		global $mySession;		
	}
	
	public function configAction()
	{	
		global $mySession;
	}
	
}
?>