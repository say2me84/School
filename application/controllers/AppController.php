<?php 
class AppController extends Zend_Controller_Action 
{	
	public function init()
    {
	
		global $mySession;
		
		$myControllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();		
		$myActionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
		
		if($myControllerName=='index' && $myActionName=='changelanguage') {
			$arr=$this->getRequest()->getParams();
			if(!empty($arr['lngid'])) {
				if($arr['lngid']==2) {
					$mySession->setlanguage=2;
				} else {
					$mySession->setlanguage=1;
				}
			} else {
				$mySession->setlanguage=1;
			}
			echo "window.location.reload();";
		}
		
		if(!isset($mySession->setlanguage)) {
			$mySession->setlanguage=1;
		}
		
		if($mySession->setlanguage!=2) {
			include_once(APPLICATION_PATH.'application/configs/language_en.php');
		} else {
			include_once(APPLICATION_PATH.'application/configs/language_ar.php');
		}
		
		$lngdefine = new cls_language();
		$lngdefine->define_lng_var();
		
		if($myControllerName=='index' && $myActionName=='index') {
			
		} else {
			if(!isLogged())
			{ 
				echo "<script>window.location='".APPLICATION_URL."'</script>";
				exit;				
			}
			$this->checkusercontroller($myControllerName);
			$this->checkuseraction($myControllerName,$myActionName);
			
			if($mySession->user['usertype']=='A') {
				$this->_helper->layout()->setLayout('amain');	
			}
			if($mySession->user['usertype']=='P') {
				$this->_helper->layout()->setLayout('pmain');	
			}
			if($mySession->user['usertype']=='T') {
			
				$this->_helper->layout()->setLayout('tmain');	
			}
		}
		$db=new Db();
		$qry="select count(id) as cnt from `reminders` where recipient='".$mySession->user['userid']."' and is_read='0'";
		$countmsg=$db->runQuery("$qry");
		$mySession->msgcont = $countmsg[0]['cnt'];
				
		if(empty($mySession->user['myschool'])) {
			$mySession->user['myschool'] = 'School Portal';
		}
    }
	public function checkusercontroller($myControllerName)
	{
		global $mySession;
		if($myControllerName=='subjectstemplate' && $mySession->user['usertype']!='A') {
			$this->_redirect('index');
		}
		if($myControllerName=='school' && $mySession->user['usertype']!='A') {
			$this->_redirect('index');
		}
	}
	public function checkuseraction($myControllerName,$myActionName)
	{
		global $mySession;
		if($myControllerName=='student') {
			if($myActionName=='edit' && $mySession->user['usertype']!='S') {
				$this->_redirect('index');
			}
			if($myActionName=='editguardian' && $mySession->user['usertype']!='S') {
				$this->_redirect('index');
			}
		}
	}
}
?>