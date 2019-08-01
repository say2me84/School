<?php
__autoloadDB('Db');
class GradinglevelsController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
		$db=new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;
	}
	
	public function newAction()
	{	
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();	
		$this->view->batch_id = $arr['batch_id'];
		$Form = new Form_Gradinglevel();
		if(isset($arr['mode']) && $arr['mode']=='add') {
			$request=$this->getRequest();
			$this->view->mode = 2;
			if ($Form->isValid($request->getPost())) 
			{
				$this->view->mode = 1;
				
				$Data='';
				$Data['name']=$arr['name'];
				$Data['min_score']=$arr['min_score'];
				$Data['batch_id']=$arr['batch_id'];
				$Data['created_at']=date('Y-m-d h:i:s');
				$Data['schoolid']=$mySession->user['schoolid'];
								
				$modelobj = new Mainmodel();
				$modelobj->insertThis('grading_levels',$Data);
				
				$qry="select * from `grading_levels` where batch_id='".$arr['batch_id']."'";
				$glist=$db->runQuery("$qry");
			
				$this->view->batchid = $batchid;
				$thisobj = new Gradinglevel();
				$this->view->listhtml = $thisobj->gradinglevellist($arr['batch_id'],$glist);
			}
		}
		$this->view->form = $Form;
	}
	
	public function editAction()
	{	
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();	
		$this->view->batch_id = $arr['batch_id'];
		if(isset($arr['id'])) {
			$this->view->id = $arr['id'];
			$qry = "select * from grading_levels where id='".$arr['id']."'";
			$glist = $db->runQuery($qry);
			if(is_array($glist) && count($glist) > 0) {
				$Form = new Form_Gradinglevel($glist[0]);
				if(isset($arr['mode']) && $arr['mode']=='add') {
					$request=$this->getRequest();
					$this->view->mode = 2;
					if ($Form->isValid($request->getPost())) 
					{
						$this->view->mode = 1;
						
						$Data='';
						$Data['name']=$arr['name'];
						$Data['min_score']=$arr['min_score'];
						$Data['updated_at']=date('Y-m-d h:i:s');
						
						$condition = "id='".$arr['id']."'";
						$modelobj = new Mainmodel();
						$modelobj->updateThis('grading_levels',$Data,$condition);
						
						$qry="select * from `grading_levels` where batch_id='".$arr['batch_id']."'";
						$glist=$db->runQuery("$qry");
					
						$this->view->batchid = $batchid;
						$thisobj = new Gradinglevel();
						$this->view->listhtml = $thisobj->gradinglevellist($arr['batch_id'],$glist);
					}
				}
				$this->view->form = $Form;
			}
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
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();
		if(@$arr['batch_id']) {
			$batchid = $arr['batch_id'];
		} else {
			$batchid = 0;
		}
		if(isset($arr['mode']) && $arr['mode']=='delete')
		{
			if($arr['id']) {
				$condition = "id='".$arr['id']."'";
				$db->delete('grading_levels',$condition);
			}
		}
		$qry="select * from `grading_levels` where batch_id='".$batchid."'";
		$glist=$db->runQuery("$qry");
		$this->view->glist=$glist;
		$this->view->batchid = $batchid;
		$thisobj = new Gradinglevel();
		$this->view->listhtml = $thisobj->gradinglevellist($batchid,$glist);
	}
	
	public function deleteAction()
	{	
		global $mySession;
		$db=new Db();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$arr=$this->getRequest()->getParams();
		if(isset($arr['x']))
		{
			if($arr['id']) {
				$this->view->x=$arr['x'];
				$condition = "id='".$arr['id']."'";
				$db->delete('grading_levels',$condition);
			}
		}
	}
	
}
?>