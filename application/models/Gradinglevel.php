<?php
 	class Gradinglevel extends Db{
		public function __construct(){
			
		}
		
		public function gradinglevellist($batchid,$listarray)
		{
			$layout='';
			
			$db= new Db();
			$layout .= '<div class="add_grade">
			<a onclick="getajax(\''.BASE_PATH.'gradinglevels/new/batch_id/'.$batchid.'\',\'\',\'modal-box\',\'2\');return false;" href="#">'.LNG_ADD_GRADES.'</a>
			
			</div>';
			if(is_array($listarray) && count($listarray) > 0) { 
			  $layout .= '<table width="100%" cellspacing="1" cellpadding="1" align="center" id="listing">
				<tr class="tr-head">
				  <td>'.LNG_NAME.'</td>
				  <td>'.LNG_MIN_SCORE.'</td>
				  <td></td>
				</tr>';
				$x=0;
				foreach($listarray as $list) { 
				  $layout .= '<tr class="tr-odd" id="grading-level-'.$x.'">
					<td class="col-2">'.$list['name'].'</td>
					<td class="col-2">'.$list['min_score'].'</td>
					<td class="col-1"><small><a onclick="getajax(\''.BASE_PATH.'gradinglevels/edit/batch_id/'.$list['batch_id'].'/id/'.$list['id'].'\',\'\',\'modal-box\',\'2\')" href="#">'.LNG_EDIT.'</a>
						| <a onclick="if (confirm(\'Are you sure?\')) { getajax(\''.BASE_PATH.'gradinglevels/delete/x/'.$x.'/id/'.$list['id'].'\', \'\',\'grading-level-'.$x.'\',\'2\'); } " href="#">'.LNG_DELETE.'</a></small></td>
				  </tr>';
				 $x++; }
				  
				
			  $layout .= '</table>';
			 } 				
			
			return $layout;
		}
	}
?>