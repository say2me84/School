<?php
__autoloadDB('Db');
class SubjectstemplateController extends AppController
{
	
	public function indexAction()
	{	
		global $mySession;		
	}
	public function manageclassAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$arr=$this->getRequest()->getParams();
		$db=new Db();
		
		$qry="select * from `grades_template` where 1";		
		$classeslist=$db->runQuery("$qry");
		
		$this->view->classeslist =  $classeslist;	
		
	}
	public function managesubjectsAction()
	{	
		global $mySession;
		$db=new Db();
		
		$qry="select * from `grades_template`";
		$glist=$db->runQuery("$qry");
		$this->view->glist=$glist;	
		
	}
	public function newAction()
	{	
		
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$form = new Form_CreateClassTemp();
		$this->view->form = $form;
		
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();	
				
			if($form->isValid($formData)){
				$Data['grade_name'] = $formData['grade_name'];
				
				$modelobj = new Mainmodel();
				$modelobj->insertThis('grades_template',$Data);
				
				$mySession->sucMsg=LNG_GRADE_CREATED;
				$this->_redirect('subjectstemplate/new');
			}
		}
	}
	
	public function editAction()
	{	
		global $mySession;
	}
	
	public function showAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		if($arr['gradeid']) {
			$qry="select * from `subjects_template` where grade_id ='".$arr['gradeid']."'";
			$list = $db->runQuery("$qry");
			$this->view->slist=$list;
		}
		
	}
	
	public function newsubjectAction()
	{	
		global $mySession;
		
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		$this->view->mode=0;
		
		if(@$arr['gradeid']) {
			if(isset($arr['mode']) && $arr['mode']=='add') {
		
				$this->view->mode=1;
				$modelobj = new Mainmodel();
				
				$Data='';
				$Data['name']=$arr['name'];
				$Data['code']=$arr['code'];
				$Data['grade_id']=$arr['gradeid'];
				$Data['created_at']=date('Y-m-d h:i:s');		
				$Data['updated_at']=date('Y-m-d h:i:s');
				
				$modelobj->insertThis('subjects_template',$Data);
				
				$qry="select * from `subjects_template` where grade_id ='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			} elseif(isset($arr['mode']) && $arr['mode']=='deletesubject') {
				$this->view->mode=2; 
				
				$condition="id='".$arr['subjectid']."'";
				
				$db->delete('subjects_template',$condition);	
				
				$qry="select * from `subjects_template` where grade_id='".$arr['gradeid']."'";
				
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
			} else {
			
				$qry="select * from `grades_template` where id='".$arr['gradeid']."'";
				$detail = $db->runQuery("$qry");
				$this->view->detail=$detail[0];
			}
		}
	}
	
	public function editsubjectAction()
	{	
		global $mySession;
		
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		$this->view->subjectid = $arr['subjectid'];
		$this->view->mode=0;
		
		if(@$arr['gradeid']) {
			if(isset($arr['mode']) && $arr['mode']=='update') {
			
				$this->view->mode=1;
				$modelobj = new Mainmodel();
				
				$Data='';
				$Data['name']=$arr['name'];
				$Data['code']=$arr['code'];
				$Data['updated_at']=date('Y-m-d h:i:s');
				
				$condition="id='".$arr['subjectid']."'";
				$modelobj->updateThis('subjects_template',$Data,$condition);		
				
				
				$qry="select * from `subjects_template` where grade_id='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			} else {
				$qry="select * from `subjects_template` where id='".$arr['subjectid']."'";
				$sdetail = $db->runQuery("$qry");
				$this->view->sdetail=$sdetail[0];
				
				$qry="select * from `grades_template` where id='".$arr['gradeid']."'";
				$detail = $db->runQuery("$qry");
				$this->view->detail=$detail[0];
			}
			
		}
	}
	
	public function deletesubjectAction()
	{	
		global $mySession;
	}
	
	
}
?>