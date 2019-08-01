<?php
 	class Mainmodel extends Db{
		
		
		public function __construct(){
			
		}	
		
		function runThisQuery($query = null)
		{
			try
			{
				
				$User = new Db();
				$UserRecords = $User->runQuery($query);
				
				if(is_array($UserRecords) && count($UserRecords) > 0)
				{
					return $UserRecords; 
				}
				else
				{
					return false;
				}		
			}
			catch (Exception $e)
			{
				//echo "Exception occured ::".$e->getMessage();
				return false;
			}
		}
		function insertThis($_table,$data)
		{
			try{
					$User = new Db();
					
					
					//$data['UserCstmp'] = date('Y-m-d H:i:s');
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$insertResult = $User->save($_table, $data);
				
					if($insertResult)
					{
						return $User->lastInsertId();
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
		function updateThis($_table,$data,$condition)
		{		
			
			try{
					$User = new Db();
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$updateResult = $User->modify($_table,$data,$condition);
					
					
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
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
	
	}
	?>