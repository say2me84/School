<?php
__autoloadDB('Db');
class EventController extends AppController
{
	public function indexAction()
	{	
		global $mySession;
		$arr=$this->getRequest()->getParams();
		$formdata['eventdate'] = $arr['eventdate'];
		$form = new Form_EventCreate($formdata);
		$this->view->form = $form;
		
		if ($this->_request->isPost()) {
			
			$formData = $this->_request->getPost();				
			$Data['schoolid'] = $mySession->user['schoolid'];
			$Data['start_date'] = changeDateTime($formData['events_start_date']);
			$Data['end_date'] = changeDateTime($formData['events_end_date']);
			$Data['title'] = $formData['events_title'];
			$Data['description'] = $formData['events_description'];
			$Data['created_at'] = date('Y-m-d h:i:s');
			if($formData['is_holiday']) {
				$Data['is_holiday'] = 1;
			} else {
				$Data['is_holiday'] = 0;
			}
			if($formData['is_common']) {
				$Data['is_common'] = 1;
			} else {
				$Data['is_common'] = 0;
			}
			
			$modelobj = new Mainmodel();
			$insid = $modelobj->insertThis('events',$Data);
			
			/*$mySession->sucMsg="Event Created Sucessfully";*/
			$this->_redirect('event/show/eventid/'.$insid);
			
		}
	}
	
	public function eventgroupAction()
	{	
		global $mySession;		
	}
	
	public function selectcourseAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			$batchdate_condition=" and start_date <= '".date('Y-m-d 00:00:00')."' and end_date >= '".date('Y-m-d 00:00:00')."' ";
 			$qry="select b.*, c.code, c.grade_name as cname from `batches` as b inner join `grades` as c on (c.id=b.grade_id) where b.id not in (select batch_id from `batch_events` where event_id='".$arr['eventid']."')".$batchdate_condition." order by name";
			
			$coursebathclist=$db->runQuery("$qry");
			$this->view->cblist=$coursebathclist;
			
			$this->view->eventid = $arr['eventid'];
		}	
		$this->_helper->layout()->setLayout('ajaxlayout');		
	}
	
	public function courseeventAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			foreach($arr['batch_id'] as $bid)
			{
				$Data='';
				$Data['event_id'] = $arr['eventid'];
				$Data['batch_id'] = $bid;
				$Data['created_at'] = date('Y-m-d h:i:s');
				
				$modelobj = new Mainmodel();
				$insid = $modelobj->insertThis('batch_events',$Data);
			}
			
			$this->_redirect('event/show/eventid/'.$arr['eventid']);
			
		}
		
		exit;	
	}
	
	public function removebatchAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['batch_eventid']) {
		
			$qry = "select * from `batch_events` where id='".$arr['batch_eventid']."'";
			$evt = $db->runQuery($qry);
			
			if(is_array($evt) && count($evt) > 0 )
		    {
				$condition = "id='".$arr['batch_eventid']."'";
				$db->delete('batch_events',$condition);
				
				$this->_redirect('event/show/eventid/'.$evt[0]['event_id']);
			} else {
				$this->_redirect('calendar');
			}			
		}	
	}
	
	public function selectemployeedepartmentAction()
	{	
		global $mySession;		
	}
	
	public function departmenteventAction()
	{	
		global $mySession;		
	}
	
	public function removedepartmentAction()
	{	
		global $mySession;		
	}
	
	public function showAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			$this->view->eventid = $arr['eventid'];
			$qry = "select * from `events` where id='".$arr['eventid']."' and schoolid='".$mySession->user['schoolid']."'";
			$reclist = $db->runQuery($qry);
			$this->view->eventData = $reclist[0];
			
			
			$qry = "select a.*, b.name as bname, c.grade_name from `batch_events` as a left join `batches` as b on (a.batch_id=b.id) left join `grades` as c on (b.grade_id=c.id) where a.event_id='".$arr['eventid']."' ";
			$batchlist = $db->runQuery($qry);
			$this->view->batchlist = $batchlist;
			
			
		}
		
	}
	
	public function confirmeventAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			
			$qry = "select * from `events` where id='".$arr['eventid']."'";
			$evt = $db->runQuery($qry);
			
			if(is_array($evt) && count($evt) > 0 )
		    {
				$Data['is_active']=1;
				$condition = "id='".$arr['eventid']."'";
				
				$modelobj = new Mainmodel();
				$modelobj->updateThis('events',$Data,$condition);
				
				$this->_redirect('calendar');
			}
			
			$this->_redirect('calendar');
		}
		exit;
			
	}
	
	public function canceleventAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
						
			$condition = "id='".$arr['eventid']."'";			
			$db->delete('event',$condition);		
			$this->_redirect('calendar');		
			
		}
		exit;	
	}
	
	public function editeventAction()
	{	
		global $mySession;
		$db = new Db();
		$arr=$this->getRequest()->getParams();
		
		if($arr['eventid']) {
			$this->view->eventid = $arr['eventid'];
			
			$qry = "select * from events where id='".$arr['eventid']."'";
			$detail = $db->runQuery($qry);
			
			if(is_array($detail) && count($detail) > 0) {
				$eventdata = $detail[0];
			} else {
				$eventdata = array();
			}
			//pr($arr);
			$form = new Form_EventCreate($eventdata);
			
			
			if ($this->_request->isPost()) {
				
				$formData = $this->_request->getPost();		
				
				$Data['start_date'] = changeDateTime($formData['events_start_date']);
				$Data['end_date'] = changeDateTime($formData['events_end_date']);
				$Data['title'] = $formData['events_title'];
				$Data['description'] = $formData['events_description'];
				$Data['created_at'] = date('Y-m-d h:i:s');
				
				if($formData['is_holiday']) {
					$Data['is_holiday'] = 1;
				} else {
					$Data['is_holiday'] = 0;
				}
				if($formData['is_common']) {
					$Data['is_common'] = 1;
				} else {
					$Data['is_common'] = 0;
				}
				//pr($Data);
				$modelobj = new Mainmodel();
				$condition = "id='".$arr['eventid']."'";
				
				$modelobj->updateThis('events',$Data,$condition);
			
				$mySession->sucMsg=LNG_EVENT_UPDATED;
				if($formData['is_common']) {
					$this->_redirect('calendar');
				} else {
					$this->_redirect('event/show/eventid/'.$arr['eventid'].'/mode/edit');
				}
				
			}
			$this->view->form = $form;
			$this->view->eventdata = $eventdata;
		}
	}
}
?>