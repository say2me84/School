<?php
__autoloadDB('Db');
class FinanceController extends AppController
{
	public function indexAction()
	{	
		global $mySession;		
	}
	
	public function manageAction()
	{	
		global $mySession;
			
	}
	public function feessubmissionindexAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.name, b.id, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batchlist=$db->runQuery("$qry");
		$this->view->batchlist=$batchlist;
			
	}
	
	public function studentlistAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batch_id'])
		{
			$this->view->batch_id = $arr['batch_id'];
		}
				
		$qry="select id as sid, concat(title,' ',first_name,' ',middle_name,' ',last_name) as sname, admission_no from `students` where schoolid='".$mySession->user['schoolid']."' and batch_id='".$arr['batch_id']."'";	
		
		$studentlist=$db->runQuery("$qry");
		$this->view->studentlist=$studentlist;
	}
	
	public function paystudentfeesAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$studentid = $arr['student_id'];
		$this->view->studentid = $studentid;
		$dt = date('Y-m-d',mktime(0,0,0, date('m'),date('d')+10, date('Y')));
		if ($this->_request->isPost()) {
		if(isset($arr['check']) && $arr['check']=='check') {			
		
			$formData = $this->_request->getPost();
			$modelobj = new Mainmodel();
			if($arr['receiptno']) {
				if(is_array($arr['chk']) && count($arr['chk']) > 0) {
					
					$Data='';
					
					$Data['student_id']= $arr['student_id'];
					$Data['trdate']=date('Y-m-d h:i:s');
					$Data['receipno']= (empty($arr['receiptno'])) ? 0 : $arr['receiptno'];
					$Data['penalty']= (empty($arr['panalty_amount'])) ? 0 : $arr['panalty_amount'];
					
					$insid = $modelobj->insertThis('fees_transaction',$Data);
					
					foreach($arr['chk'] as $chk) {
						$Data='';
						$Data['student_id']= $arr['student_id'];
						$Data['trid']= $insid;
						$Data['fst_inst_id']= $arr['fstid'.$chk];
						$Data['fst_inst_detail_id']= $chk;
						$Data['inst']=$arr['inst'.$chk];
						//echo"<pre>";print_r($Data);
						$insid = $modelobj->insertThis('fees_transactiondetail',$Data);
						
						$Data='';
						$Data['paystatus']= 1;
						$Data['payon']=date('Y-m-d h:i:s');
						$Data['receiptno']=(empty($arr['receiptno'])) ? 0 : $arr['receiptno'];
						$Data['trno']=$insid;
						//prd($Data);
						$wherecondition = "id='".$chk."'";
						$modelobj->updateThis('fees_studentdetail',$Data,$wherecondition);
						
						$mySession->sucMsg = "Installment paid successfully.";
					    //$this->_redirect('student/profile/studentid/'.$arr['studentid']);
						$this->_redirect('finance/feessubmissionindex');						
					}
				} else {
					$mySession->warningMsg = "Please select atleast one installment to pay.";
				}
			} else {
				$mySession->warningMsg = "Please fill the local receipt no.";
			}		
			
		}
	}
		
		
		$inst="SELECT stu.id, CONCAT(stu.first_name,' ',stu.middle_name,' ',stu.last_name) as stname, stu.admission_no, CONCAT(guard.first_name,' ',guard.last_name) as Gaurdian, guard.relation, DATE_FORMAT(admission_date, '%d %M, %Y') as ad_dt, DATE_FORMAT(date_of_birth, '%d %M, %Y') as dob_dt 
			FROM `students` as stu
			LEFT JOIN guardians as guard ON guard.ward_id = stu.id
			WHERE stu.id='".$arr['studentid']."'";		
		$cb=$db->runQuery($inst);
		$this->view->cb=$cb[0];	
		
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
		$qry="select b.*, b.name as bname, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.schoolid ='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$batch=$db->runQuery("$qry");		
		$this->view->batch=$batch[0];		
		
		$qry = "select a.*, c.name as catname from fees_studentdetail as a left join fees_student as b on (a.fstid=b.id) left join fees_categories as c on (b.catid=c.id) where a.student_id='".$studentid."' and a.dueon < '".$dt."' and a.paystatus=0";
		$stfees=$db->runQuery($qry);
		$this->view->stfees=$stfees;
		
	}
	
	public function feesdefaultersAction()
	{	
		global $mySession;
			
	}
	public function feescategoriesAction()
	{	
		global $mySession;
		
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$form = new Form_FeesCategory();		
		$this->view->form = $form;
		
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		//$form = new Form_Login();
		if (isset($arr['mode']) && $arr['mode']=='delete' && $arr['catid']!='') {
			$condition = "id='".$arr['catid']."'";
			$db->delete('fees_categories',$condition);
			$mySession->sucMsg="Fees category has been deleted.";
		}
		//$this->view->loginform = $form;
		if ($this->_request->isPost()) {
				
            $formData = $this->_request->getPost();
			if($form->isValid($formData)){
			
			$Data['name']=$formData['category_name'];
			
			$modelobj = new Mainmodel();
			$modelobj->insertThis('fees_categories',$Data);
			
			$mySession->sucMsg="Fees category has been saved.";
			$this->_redirect('finance/feescategories');
			}
		}
		$qry="select * from `fees_categories` ";		
		$list=$db->runQuery("$qry");
		
		$this->view->clist=$list; 
			
	}
	public function feescategorieseditAction()
	{
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry="select * from `fees_categories` where id='".$arr['catid']."'";		
		$list=$db->runQuery("$qry");
		
		$this->view->detail=$list; 
		$this->view->catid=$arr['catid']; 
		$form = new Form_FeesCategory($list[0]);		
		$this->view->form = $form;
		
		//$form = new Form_Login();
		
		//$this->view->loginform = $form;
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();
			if($form->isValid($formData)){
			
			$Data['name']=$formData['category_name'];
			
			$modelobj = new Mainmodel();
			$condition = "id='".$arr['catid']."'";
			$modelobj->updateThis('fees_categories',$Data,$condition);
			
			$mySession->sucMsg="Fees category has been updated.";
			$this->_redirect('finance/feescategories');
			}
		}
		
	
	}
	public function feesstructureAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batchid']) { 
			$batchid = $arr['batchid'];
		} else {
			$batchid = 0;
		}
		$this->view->batchid = $batchid;
		$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";	
		$qry="select b.id as bid, b.name, c.grade_name from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where c.schoolid='".$mySession->user['schoolid']."'".$batchdate_condition." order by name";
		$coursebathclist=$db->runQuery("$qry");
		$this->view->cblist=$coursebathclist;
		
		$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
		$list = $db->runQuery($qry);
		$this->view->slist = $list;		
		
	}
	public function showAction()
	{
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$this->_helper->layout()->setLayout('ajaxlayout');
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['batchid']) { 
			$batchid = $arr['batchid'];
		} else {
			$batchid = 0;
		}
		$this->view->batchid = $batchid;
		if(@$arr['mode']=='delete') {
			$condition = "fsid='".$arr['fsid']."'";
			$db->delete('fees_structuredetail',$condition);
			
			$condition = "id='".$arr['fsid']."'";
			$db->delete('fees_structurelist',$condition);
			
			$mySession->sucMsg = "Deleted successfully.";
		}
		$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
		$list = $db->runQuery($qry);
		$this->view->slist = $list;
	}
	public function feescreateAction()
	{	
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		if($arr['batchid']) { 
			$batchid = $arr['batchid'];
		} else {
			$batchid = 0;
		}
		
					if($batchid) {
							$qry="select batches.id, concat(grades.code,' - ',batches.name) as batchname from `batches` left join grades on (grades.id=batches.grade_id) where batches.id='".$batchid."'";
							$attend = $db->runQuery("$qry");
							$this->view->batch_id=$batchid;
						} else {
							$attend[0]['id']=0;
							$attend[0]['batchname']='Common';
							$this->view->batch_id=0;
						}
						$this->view->batchdetail=$attend;
		$this->view->mode = 0;
		$this->view->batchid = $batchid;
		if ($this->_request->isPost()) {
			
			if(@$arr['mode']=='add') {
			
				$modelobj = new Mainmodel();
				$Data='';
				$Data['batch_id']= $batchid;
				$Data['catid']= (empty($arr['catlist'])) ? 0 : $arr['catlist'];
				$Data['noofinst']=$arr['noofinst'];
				$Data['createon']=date('Y-m-d h:i:s');
				$Data['updatedon']=date('Y-m-d h:i:s');
				
				
				$fsid = $modelobj->insertThis('fees_structurelist',$Data);
			
				for($i=1; $i <= $arr['noofinst']; $i++) {
					if(!empty($arr['inst_'.$i]))
					{
						$Data='';
						$Data['fsid']=$fsid;
						$Data['inst']=$arr['inst_'.$i];
						$Data['dueon']=changedate($arr['duedate_'.$i]);
						
						$modelobj->insertThis('fees_structuredetail',$Data);
					}
				}
				$this->view->mode = 1;
				
				$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
				$list = $db->runQuery($qry);
				$this->view->slist = $list;
			}
		}
		
		$qry="select * from `fees_categories` where is_deleted!='1'";
		$list=$db->runQuery("$qry");
		$this->view->clist=$list;
		
		
	}
	public function feeseditAction()
	{
		global $mySession;
		if(!isset($mySession->user['userid'])){	
			$this->_redirect('index');		
			exit;
		}
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');
		if($arr['batchid']) { 
			$batchid = $arr['batchid'];
		} else {
			$batchid = 0;
		}
						if($batchid) {
							$qry="select batches.id, concat(grades.code,' - ',batches.name) as batchname from `batches` left join grades on (grades.id=batches.grade_id) where batches.id='".$batchid."'";
							$attend = $db->runQuery("$qry");
							$this->view->batch_id=$batchid;
						} else {
							$attend[0]['id']=0;
							$attend[0]['batchname']='Common';
							$this->view->batch_id=0;
						}
						$this->view->batchdetail=$attend;
		
		$this->view->mode = 0;
		$this->view->batchid = $batchid;
		$this->view->fsid = $arr['fsid'];
		if($arr['fsid']) {
			if ($this->_request->isPost()) {
				if(@$arr['mode']=='update') {
				
					$modelobj = new Mainmodel();
					$Data='';
					
					$Data['catid']= (empty($arr['catlist'])) ? 0 : $arr['catlist'];
					$Data['noofinst']=$arr['noofinst'];
					
					$Data['updatedon']=date('Y-m-d h:i:s');
					
					$condition = "id='".$arr['fsid']."'";
					$modelobj->updateThis('fees_structurelist',$Data,$condition);
					$fsid=$arr['fsid'];
					$delcondition = "fsid='".$arr['fsid']."'";
					$db->delete('fees_structuredetail',$delcondition);
					for($i=1; $i <= $arr['noofinst']; $i++) {
						if(!empty($arr['inst_'.$i]))
						{
							$Data='';
							$Data['fsid']=$fsid;
							$Data['inst']=$arr['inst_'.$i];
							$Data['dueon']=changedate($arr['duedate_'.$i]);
							
							$modelobj->insertThis('fees_structuredetail',$Data);
						}
					}
					$this->view->mode = 1;
					
					$qry = "select a.*, b.name as catname from fees_structurelist as a left join fees_categories as b on (a.catid=b.id) where batch_id='".$batchid."'";
					$list = $db->runQuery($qry);
					$this->view->slist = $list;
					
					
				} else {		
					$qry="select * from `fees_categories` where is_deleted!='1'";
					$list=$db->runQuery("$qry");
					$this->view->clist=$list;
					
					$qry="select * from `fees_structurelist` where id='".$arr['fsid']."'";
					$fees=$db->runQuery("$qry");
					$this->view->fees=$fees;
					
					$qry="select *, DATE_FORMAT(dueon, '%M %d, %Y') as dueondt from `fees_structuredetail` where fsid='".$arr['fsid']."' order by dueon";
					$installment=$db->runQuery("$qry");
					$this->view->installment=$installment;
			}
		} 
	  }
	}
	
}
?>