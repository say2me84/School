<?php
__autoloadDB('Db');
class IndexController extends AppController
{
	public function changelanguageAction()
	{
		exit;
	}
	public function indexAction()
	{	
		global $mySession;	
		if(isset($mySession->user['userid'])){	
			$this->_redirect('user/dashboard');		
			exit;
		}
		$this->_helper->layout()->setLayout('login');	
		$form = new Form_Login();
		
		$this->view->loginform = $form;
		 if ($this->_request->isPost()) {
		 
	
            $formData = $this->_request->getPost();
			
			if ($form->isValid($formData)) {
			
				$user 		= 	new SystemUser();
				
				 $result 	= 	$user->authenticateLogin($formData);	
							
				
				if($result){	
					$db = new Db();				
					if($result[0]['usertype']=='A' || $result[0]['usertype']=='S') {
						$mySession->user['userid']=$result[0]['id'];
						$mySession->user['fname']=$result[0]['first_name'];
						$mySession->user['lname']=$result[0]['last_name'];
						$mySession->user['usertype']=$result[0]['usertype'];
						$mySession->user['schoolid']=$result[0]['schoolid'];
						
					} elseif($result[0]['usertype']=='P') {
					
						$mySession->user['userid']=$result[0]['id'];
						$mySession->user['usertype']=$result[0]['usertype'];
						$mySession->user['schoolid']=$result[0]['schoolid'];
						
						$qry = "select parentlogin from school where id='".$result[0]['schoolid']."'";
						$sdetail = $db->runQuery($qry);
						if($sdetail[0]['parentlogin']==0) {
							unset($mySession->user);
							$mySession->sucMsg =LNG_LOGIN_DISABLED; 	
							$this->_redirect('index');
							exit;
						}
						$qry = "select * from guardians where userid='".$result[0]['id']."'";
						$detail = $db->runQuery($qry);
						
							if(is_array($detail) && count($detail) > 0)
							{
							$qry = "select id from students where guardian_id='".$detail[0]['id']."'"; 
							$stdentlist = $db->runQuery($qry);
								if(is_array($stdentlist) && count($stdentlist) > 0) {
									
									$mySession->user['fname']=$detail[0]['first_name'];
									$mySession->user['lname']=$detail[0]['last_name'];
									$mySession->user['userownid']=$detail[0]['id'];
									for($j = 0; $j < count($stdentlist); $j++) {
										$mySession->user['userstudentid'][]=$stdentlist[$j]['id'];
									}
								} else {
									unset($mySession->user);
									$mySession->sucMsg =LNG_INVALID_EMAILID_PASSWORD; 	
									$this->_redirect('index');
									exit;
								}
							} else {
								unset($mySession->user);
								$mySession->sucMsg =LNG_INVALID_EMAILID_PASSWORD; 	
								$this->_redirect('index');
								exit;
							}
						
					} elseif($result[0]['usertype']=='T') {
						$mySession->user['userid']=$result[0]['id'];
						$mySession->user['usertype']=$result[0]['usertype'];
						$mySession->user['schoolid']=$result[0]['schoolid'];
						
						$qry = "select emplogin from school where id='".$result[0]['schoolid']."'";
						$sdetail = $db->runQuery($qry);
						if($sdetail[0]['emplogin']==0) {
							unset($mySession->user);
							$mySession->sucMsg =LNG_LOGIN_DISABLED; 	
							$this->_redirect('index');
							exit;
						}
						
						$qry = "select * from employees where userid='".$result[0]['id']."'";
						$detail = $db->runQuery($qry);
							if(is_array($detail) && count($detail) > 0)
							{
								$mySession->user['fname']=$detail[0]['first_name'];
								$mySession->user['lname']=$detail[0]['last_name'];
								$mySession->user['userownid']=$detail[0]['id'];
							} else {
								unset($mySession->user);	
								$mySession->sucMsg =LNG_INVALID_EMAILID_PASSWORD; 	
								$this->_redirect('index');
								exit;
							}
					}
					if($result[0]['usertype']!='A')
					{
						
						$qry="select * from school where id='".$mySession->user['schoolid']."' and status ='1' ";
						
						$sdetail=$db->runQuery("$qry");	
						
						if(is_array($sdetail) && count($sdetail) > 0) 
						{	
									
							$mySession->user['schoollogo']=$sdetail[0]['logo'];
							$mySession->user['schoolname']=$sdetail[0]['name'];
						} else {
							unset($mySession->user);	
							$mySession->sucMsg =LNG_INVALID_EMAILID_PASSWORD; 	
							$this->_redirect('index');
							exit;
						}
						
					}
					$this->_redirect('user/dashboard');								
					
				} else {
						unset($mySession->dmemail);		
						$mySession->sucMsg =LNG_INVALID_EMAILID_PASSWORD; 
						$this->_redirect('index');	
				}
			}
		}
	}
	public function logoutAction()
	{
		global $mySession;
		unset($mySession->user);	
		$mySession->sucMsg =LNG_YOU_ARE_LOGGED_OUT; 	
		$this->_redirect('index');	
	}
}
?>