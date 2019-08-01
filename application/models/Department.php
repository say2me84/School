<?php
 	class Department extends Db
	{
		
		protected $_table;
		
		public function __construct()
		{
			$this->_table = 'employee_departments';
		}

	
		function getDepartmentList($columns='*',$where=NULL,$whereNot=NULL,$orderby=NULL,$tblJoin=NULL,$joinCondition=NULL,$group=NULL,$having=NULL)
		{
			 
			
			try
			{
				
				$Department = new Db();
				
				$DepartmentRecords = $Department->showAll($this->_table,$columns,$where,$whereNot,$orderby,$tblJoin,$joinCondition,$group,$having);
				
				if(is_array($DepartmentRecords) && count($DepartmentRecords) > 0)
				{
					return $DepartmentRecords; 
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
		
 
 
		
		function getDepartmentDetail($where,$whereNot=NULL)	
		{
			try
			{
				$Department = new Db();
				$DepartmentRecords = $Department->showAll($this->_table,'',$where,$whereNot);

				if(is_array($DepartmentRecords) && count($DepartmentRecords) == 1)
				{
					return $DepartmentRecords[0];
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
		
		
		function insertDepartment($data)
		{
			try{
					$Department = new Db();
					
					
					
					
					
					$insertResult = $Department->save($this->_table, $data);
					
					if($insertResult)
					{
						return $Department->lastInsertId();
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
		
		function updateDepartment($data,$condition)
		{ 
			try{
					//print_r($condition);exit;
					$Department = new Db();
					
					$updateResult = $Department->modify($this->_table,$data,$condition);
					
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
		
 
			
 	function deleteDepartment($condition) {
			
			try{
					$DepartmentDelete = new Db();
					
					$deleteStatus = $DepartmentDelete->delete($this->_table,$condition);
					
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
		
	
	
	}
	?>