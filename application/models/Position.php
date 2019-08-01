<?php
 	class Position extends Db
	{
		
		protected $_table;
		
		public function __construct()
		{
			$this->_table = 'employee_positions';
		}

	
		function getPositionList($columns='*',$where=NULL,$whereNot=NULL,$orderby=NULL,$tblJoin=NULL,$joinCondition=NULL,$group=NULL,$having=NULL)
		{
			 
			
			try
			{
				
				$Position = new Db();
				
				$PositionRecords = $Position->showAll($this->_table,$columns,$where,$whereNot,$orderby,$tblJoin,$joinCondition,$group,$having);
				
				if(is_array($PositionRecords) && count($PositionRecords) > 0)
				{
					return $PositionRecords; 
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
		
 
 
		
		function getPositionDetail($where,$whereNot=NULL)	
		{
			try
			{
				$Position = new Db();
				$PositionRecords = $Position->showAll($this->_table,'',$where,$whereNot);

				if(is_array($PositionRecords) && count($PositionRecords) == 1)
				{
					return $PositionRecords[0];
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
		
		
		function insertPosition($data)
		{
			try{
					$Position = new Db();
					
					
					
					
					
					$insertResult = $Position->save($this->_table, $data);
					
					if($insertResult)
					{
						return $Position->lastInsertId();
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
		
		function updatePosition($data,$condition)
		{ 
			try{
					//print_r($condition);exit;
					$Position = new Db();
					
					$updateResult = $Position->modify($this->_table,$data,$condition);
					
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
		
 
			
 	function deletePosition($condition) {
			
			try{
					$PositionDelete = new Db();
					
					$deleteStatus = $PositionDelete->delete($this->_table,$condition);
					
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