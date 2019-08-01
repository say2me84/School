<?php
 	class SystemUser extends Db
	{
		
		protected $_table;
		
		public function __construct()
		{
			$this->_table = 'users';
		}

		public function filterSystemUserData($where,$order,$like=NULL){
 			try
			{
				$SiteField = new Db();
		
				$wherestring=' id = id';
				foreach($where as $key=>$val){
					$wherestring .=" and ".$key." = '".$val."'";
			
				}
				
		
				 $orderby='order By ';
				foreach($order as $key=>$val){
					$orderby .="  ".$key.'    '.$val.' ';
			
			 	}
			
			 if($like){
				foreach($like as $key=>$val){
					$wherestring .=" and ".$key." like '%".trim($val)."%'";
			
				}		
			 }
//echo "select * FROM ".$this->_table." WHERE ".$wherestring." ".$orderby;exit;
				
			$SiteFieldRecords = $SiteField->runQuery("select * FROM ".$this->_table." WHERE ".$wherestring." ".$orderby);
		
		
				if(is_array($SiteFieldRecords) && count($SiteFieldRecords) > 0)
				{
					return $SiteFieldRecords; 
				}
				else
				{
					return false;
				}	
		}
			catch (Exception $e)
			{
				//$msg[] = $e->getMessage();
				//echo "Exception occured ::".$e->getMessage();
				return false;
			}
		
		}
		
		
		
		function getSystemUserList($columns='*',$where=NULL,$whereNot=NULL,$orderby=NULL,$tblJoin=NULL,$joinCondition=NULL,$group=NULL,$having=NULL)
		{
			 
			
			try
			{
				
				$SystemUser = new Db();
				
				$SystemUserRecords = $SystemUser->showAll($this->_table,$columns,$where,$whereNot,$orderby,$tblJoin,$joinCondition,$group,$having);
				
				if(is_array($SystemUserRecords) && count($SystemUserRecords) > 0)
				{
					return $SystemUserRecords; 
				}
				else
				{
					return false;
				}		
			}
			catch (Exception $e)
			{
				//$msg[] = $e->getMessage();
				//echo "Exception occured ::".$e->getMessage();
				return false;
			}
		}
		
 
 
		
		function getSystemUserDetail($where,$whereNot=NULL)	
		{
			try
			{
				$SystemUser = new Db();
				$SystemUserRecords = $SystemUser->showAll($this->_table,'',$where,$whereNot);

				if(is_array($SystemUserRecords) && count($SystemUserRecords) == 1)
				{
					return $SystemUserRecords[0];
				}
				else
				{				
					return false;
				}
			}
			catch (Exception $e)
			{
 
				return false;
			}
		}
		
		
		function insertSystemUser($data)
		{
			try{
					$SystemUser = new Db();
					
					$data['user_createdate'] =  date('Y-m-d H:i:s');
					$data['user_updatedate'] = date('Y-m-d H:i:s');
					
					
					
					$insertResult = $SystemUser->save($this->_table, $data);
					
					if($insertResult)
					{
						return $SystemUser->lastInsertId();
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
 					return false;
				}
		}
		
		function updateSystemUser($data,$condition)
		{ 
			try{
					//print_r($condition);exit;
					$SystemUser = new Db();
					$data['user_updatedate'] = date('Y-m-d H:i:s');
					$updateResult = $SystemUser->modify($this->_table,$data,$condition);
					
					if($updateResult)
					{
						return true;
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//$msg[] = $e->getMessage();
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
 
			
 	function deleteSystemUser($condition) {
			
			try{
					$SystemUserDelete = new Db();
					
					$deleteStatus = $SystemUserDelete->delete($this->_table,$condition);
					
					if($deleteStatus) {
					
						return true;
					
					} else {
					
						return false;
					}
				}
				catch (Exception $e)
				{
					//$msg[] = $e->getMessage();
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
	function authenticateLogin($dataForm)
	{		
		global $mySession;
		try 
		{
			//echo '<pre>';print_r($dataForm); exit;
			$db = new Db();
			$columns='*';
			$where['username']=$dataForm['login_id'];
			  $where['hashed_password']=md5($dataForm['login_password']);
			//$where['user_role']='A';
			$record = $db->showAll($this->_table,$columns,$where);
			//exit;
			if($record){
			return $record;
			} else {
				return false;
			}
		} catch(Exception $e) {
			return false;
		}
	}	
	
			
	function authenticateLoginfront($dataForm)
	{	
		global $mySession;
		try 
		{
			//echo '<pre>';print_r($dataForm); exit;
			$db = new Db();
			$columns='*';
			$where['username']=$dataForm['_uname'];
			$where['password']=$dataForm['_pass'];
			$where['status']=1;
			
			$record = $db->showAll($this->_table,$columns,$where);
				//echo '<pre>';print_r($record); exit;
			if($record){
			return $record[0];
			} else {
				return false;
			}
		} catch(Exception $e) {
			return false;
		}
	}	
 	
	
	function dateonly($wherestring)
	{
		
		$SiteField = new Db();
		
		
		/*$SiteFieldRecords = $SiteField->runQuery("select DATE(user_createdate) FROM b4b_systemuser where userId=="); */
		$SiteFieldRecords = $SiteField->runQuery("select DATE('user_createdate') FROM ".$this->_table." WHERE ".$wherestring);
	
		return $SiteFieldRecords;
		
		
	}	
	
	}
	?>