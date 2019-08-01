<?php
__autoloadDB('Db');
class SubjectsController extends AppController
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
		if(!empty($arr['batchid'])) {
			$this->view->batchid = $arr['batchid'];
		} else {
			$this->view->batchid = 0;	
		}
		$qry="select * from `grades` where is_deleted='0' and schoolid='".$mySession->user['schoolid']."'";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;		
	}
	
	public function newAction()
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
				$qry="select colorcode from `subjects` where grade_id !='".$arr['gradeid']."' and schoolid='".$mySession->user['schoolid']."' and name='".$arr['name']."'";
				$res_othergradecolor = $db->runQuery("$qry");
				$othergradecolor='';
				if(is_array($res_othergradecolor) && count($res_othergradecolor) > 0) {
					if($res_othergradecolor[0]['colorcode']!='#ffffff') { $othergradecolor = $res_othergradecolor[0]['colorcode']; }
				}
				$qry="select colorcode from `subjects` where grade_id ='".$arr['gradeid']."' and schoolid='".$mySession->user['schoolid']."'";
				$colorcode = $db->runQuery("$qry");
				$colorcodearray = array();
				if(is_array($colorcode) && count($colorcode)) {
					foreach($colorcode as $cc) {
						$colorcodearray[] = $cc['colorcode'];
					}
				}
				if($othergradecolor!='' && !in_array($othergradecolor,$colorcodearray)) {
					$thiscolorcode = $othergradecolor;
					
				} else {
					$allcolor  = subjectcolor();
					$filterarray = array_diff($allcolor, $colorcodearray);
										
					if(is_array($filterarray) && count($filterarray)) {
						$thiscolorcode = current($filterarray);
					} else {
						$thiscolorcode = rand_colorCode();
					}
					
				}
				
				$Data='';
				$Data['name']=$arr['name'];
				$Data['code']=$arr['code'];
				$Data['grade_id']=$arr['gradeid'];
				$Data['colorcode']=$thiscolorcode;
				$Data['created_at']=date('Y-m-d h:i:s');		
				$Data['updated_at']=date('Y-m-d h:i:s');
				$Data['schoolid']=$mySession->user['schoolid'];
				
				$modelobj->insertThis('subjects',$Data);
				
				
				$qry="select * from `subjects` where grade_id ='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			}  elseif(isset($arr['mode']) && $arr['mode']=='delete') {
				$this->view->mode=2;
				
				$condition="id='".$arr['subjectid']."'";
				$db->delete('subjects',$condition);	
				
				$qry="select * from `subjects` where grade_id='".$arr['gradeid']."'";
				
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
			} else {
				$qry="select * from `grades` where id='".$arr['gradeid']."'";
				$detail = $db->runQuery("$qry");
				$this->view->detail=$detail[0];
			}
		}
	}
	public function newslistAction()
	{	
		
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		$this->view->mode=0;
		
		if(@$arr['gradeid']) {
			if(isset($arr['mode']) && $arr['mode']=='add') {
				
			}
		}
		$qry="select * from `grades_template`";
		$glist=$db->runQuery("$qry");
		$this->view->glist=$glist;
	}
	
	public function subjecttemplateAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		$this->view->mode=0;
				
		if($arr['gradeid']) {
			if(isset($arr['mode']) && $arr['mode']=='add') {
				$this->view->mode=1;
				$modelobj = new Mainmodel();
				
				
				foreach($arr['temp_subject'] as $temp_sub){
					$qry="select * from `subjects_template` where id='".$temp_sub."'";
					$list = $db->runQuery("$qry");
					
					///---- get color code
					$qry="select colorcode from `subjects` where grade_id !='".$arr['gradeid']."' and schoolid='".$mySession->user['schoolid']."' and name='".$list[0]['name']."'";
					$res_othergradecolor = $db->runQuery("$qry");
					$othergradecolor='';
					if(is_array($res_othergradecolor) && count($res_othergradecolor) > 0) {
						if($res_othergradecolor[0]['colorcode']!='#ffffff') { $othergradecolor = $res_othergradecolor[0]['colorcode']; }
					}
					$qry="select colorcode from `subjects` where grade_id ='".$arr['gradeid']."' and schoolid='".$mySession->user['schoolid']."'";
					$colorcode = $db->runQuery("$qry");
					$colorcodearray = array();
					if(is_array($colorcode) && count($colorcode)) {
						foreach($colorcode as $cc) {
							$colorcodearray[] = $cc['colorcode'];
						}
					}
					if($othergradecolor!='' && !in_array($othergradecolor,$colorcodearray)) {
						$thiscolorcode = $othergradecolor;
					} else {
						$allcolor  = subjectcolor();
						$filterarray = array_diff($allcolor, $colorcodearray);
						if(is_array($filterarray) && count($filterarray)) {
							$thiscolorcode = current($filterarray);
						} else {
							$thiscolorcode = rand_colorCode();
						}
					}
					///--- end get color code
					
						$Data='';
						$Data['name']=$list[0]['name'];
						$Data['code']=$arr['subcode_'.$temp_sub];
						$Data['grade_id']=$arr['gradeid'];
						$Data['colorcode']=$thiscolorcode;
						$Data['created_at']=date('Y-m-d h:i:s');		
						$Data['updated_at']=date('Y-m-d h:i:s');
						$Data['schoolid']=$mySession->user['schoolid'];
						
						$modelobj->insertThis('subjects',$Data);
					}
				$qry="select * from `subjects` where grade_id ='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			}
			
			if($this->view->mode==0){
			$qry="select * from `subjects_template` where grade_id ='".$arr['gradeid']."'";
			$list = $db->runQuery("$qry");
			$this->view->slist=$list;
			}
		}
	}
	
	public function createAction()
	{	
		global $mySession;		
	}
	
	public function editAction()
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
				$modelobj->updateThis('subjects',$Data,$condition);		
				
				
				$qry="select * from `subjects` where grade_id='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			} else {
				$qry="select * from `subjects` where id='".$arr['subjectid']."'";
				$sdetail = $db->runQuery("$qry");
				$this->view->sdetail=$sdetail[0];
				
				$qry="select * from `grades` where id='".$arr['gradeid']."'";
				$detail = $db->runQuery("$qry");
				$this->view->detail=$detail[0];
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
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		if($arr['gradeid']) {
			$qry="select * from `subjects` where grade_id ='".$arr['gradeid']."'";
			$list = $db->runQuery("$qry");
			$this->view->slist=$list;
		}
	}
	
	public function destroyAction()
	{	
		global $mySession;		
	}
	
}
?>