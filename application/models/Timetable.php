<?php

 	class Timetable extends Db{
		public function __construct(){
			
		}
		
		public function timetablehtml($batchid,$weekdayarray,$candelete=1)
		{
			global $mySession;
			$layout='';
			$db= new Db();
			if(@$batchid!='')
			{
								
				$qry="select *, TIME_FORMAT(start_time,'%h:%i%p') as sttime, TIME_FORMAT(end_time,'%h:%i%p') as entime from `class_timings` where batch_id='".$batchid."'";
				$classtimingarray=$db->runQuery("$qry");
				$this->ctlist=$classtimingarray;
				$timetable_subject = array();
				
				$layout .=  tframe1_pre().'<div >
				  <table id="table" align="center" border="0" cellspacing="0" width="100%">
					<tbody><tr>
				
					  <td class="loader">
						<img alt="Loader" id="loader" src="'.IMAGES_URL.'loader.gif?'.UPDATE_KEY.'" style="display: none;" align="absmiddle" border="0">
						&nbsp;</td>
					  <td class="td-blank"></td>';
					   if(count($classtimingarray) > 0) { if($candelete==2) { $weekwidth = 888/count($classtimingarray);  } else {$weekwidth = 688/count($classtimingarray); } }
					   foreach($classtimingarray as $ctarray) { 
							$layout .= '<td class="td" style="width:'.$weekwidth.'px"><div class="top" title="'.$ctarray['name'].'">'.$ctarray['sttime'].'-'.$ctarray['entime'].'<br>'.$ctarray['name'].'</div></td>';
					   }
					   
					  
					$layout .= '</tr> 
					<tr class="blank">
					  <td></td>
					  <td></td>';
					  
					   foreach($classtimingarray as $ctarray) { 
						$layout .= '<td></td>';
					   } 
					  
					$layout .= '</tr>';					
					   
					 $wkd = '';
					 $tid = '';
					 $x=1;
				foreach($weekdayarray as $wdarray) {
					if($tid!='') {
						$layout .= '</tr><tr>';
					}
					$layout .= '';
					$layout .= '<td class="td"><div class="name" >'.strtoupper(getDayName($wdarray['weekday'])).'</div></td>';
					$layout .= '<td class="td-blank"></td>';
					$wkd = $wdarray['id'];
					
					foreach($classtimingarray as $ctarray) { 
					$tid = $ctarray['id'];
					$qry="select te.* from `timetable_entries` as te where te.batch_id='".$batchid."' and te.weekday_id='".$wkd."' and  te.class_timing_id = '".$tid."'";
								
					$resttarray=$db->runQuery("$qry");
					if(is_array($resttarray) && count($resttarray) > 0) {
						$ttarray = $resttarray[0];
						 //foreach($this->ttarray as $ttarray) { 
								
								
						$newbgcolor = '#ffffff';
						if($ttarray['subject_id'] && $ttarray['is_break']!='1') { 
							$qry="select * from `subjects` where id='".$ttarray['subject_id']."'";
							$subject=$db->runQuery("$qry");
							if(@$subject[0]['colorcode']) { $newbgcolor = @$subject[0]['colorcode']; }
							
							$qry="select * from `employees` where id='".$ttarray['employee_id']."'";
							$teacher=$db->runQuery("$qry");
						}
						if($ctarray['is_break']=='1') { $newbgcolor = '#e1e1e1'; }
							
						$layout .= '<td class="td">
								<div style="position: relative;" id="drop_'.$ttarray['id'].'" class="drop" >
								  <div class="tt-subject" id="subject_name_'.$ttarray['id'].'">
									<div class="subject" style="background-color:'.$newbgcolor.'">';
										if($ttarray['subject_id'] && $ctarray['is_break']!='1') { 
																			   
											$layout .= @$subject[0]['code'].'<span>'.@$subject[0]['name'].
											'<div class="emp-name">'.@$teacher[0]['first_name'].' '.@$teacher[0]['last_name'].'</div>
										  
											 </span>';
										} 
									  
									$layout .= '</div>
									<div class="employee">';
									if($ttarray['employee_id']) { 
									 $qry="select * from `employees` where id='".$ttarray['employee_id']."'";
									 $teacher=$db->runQuery("$qry");
										  if($candelete==1) { 		
											$layout .= '<a href="#" onclick="Element.show(\'loader\'); new Ajax.Updater(\'timetable\', \''.BASE_PATH.'timetable/deleteemployee2/tte_ids/'.$ttarray['id'].'\', {asynchronous:true, evalScripts:true, onComplete:function(request){clear_selected_divs();}, onSuccess:function(request){Element.hide(\'loader\')}, parameters:\'authenticity_token=\' + encodeURIComponent(\'c5Ve9KiFOIpEYVkpnaD55qe0RTAhRz5+e9fNn5c1+Ik=\')}); return false;"><img alt="Delete-new" src="'.IMAGES_URL.'buttons/delete-new.png?<?=UPDATE_KEY?>" border="0"></a>';
										  }
									  $layout .= @$teacher[0]['first_name'];
									  } 
						$layout .= '</div>
								  </div>
								</div>';
								if($ctarray['is_break']!='1') {
								$layout .= '<script type="text/javascript">
									//<![CDATA[
									Droppables.add("drop_'.$ttarray['id'].'", {accept:\'employees_subject\', onDrop:function(draggable_element, droppable_element) { $(droppable_element).highlight(); make_ajax_calls('.$ttarray['id'].', draggable_element.id.split(\'_\').last()); }})
									//]]>
									</script>';
								}
								$layout .= '</td>';
							
						 } else {
						 	$layout .= '<td class="td">&nbsp;</td>';
						 }
					 $x++;
					 }
				 } 
				 $layout .= '</tr>
			  </tbody></table>
			</div>'.tframe_post();
				
		    }
			return $layout;
		}
				
		public function timetablehtmlview_teacher($batchid)
		{
		
			$layout='';
			$db= new Db();
			if(@$batchid!='')
			{
				
				$qry="select *, TIME_FORMAT(start_time,'%h:%i%p') as sttime, TIME_FORMAT(end_time,'%h:%i%p') as entime from `class_timings` where batch_id='".$batchid."'";
				$classtimingarray=$db->runQuery("$qry");
				$this->ctlist=$classtimingarray;
				$timetable_subject = array();
				
				$qry="select te.*, wk.weekday  from `timetable_entries` as te inner join weekdays as wk on(te.weekday_id=wk.id) where te.batch_id='".$batchid."' order by te.weekday_id, te.class_timing_id";
				$ttarray=$db->runQuery("$qry");
				$this->ttarray = $ttarray;
								
				$layout .= '<div id="box3">
				  <table id="table" align="center" border="0" cellspacing="0" width="100%">
					<tbody><tr>
				
					  <td class="loader">
						<img alt="Loader" id="loader" src="'.IMAGES_URL.'loader.gif?'.UPDATE_KEY.'" style="display: none;" align="absmiddle" border="0">
						&nbsp;</td>
					  <td class="td-blank"></td>';
					
					   foreach($this->ctlist as $ctlist) { 
							$layout .= '<td class="td"><div class="top">'.$ctlist['sttime'].' - '.$ctlist['entime'].'</div></td>';
					   }
					   
					  
					$layout .= '</tr> 
					<tr class="blank">
					  <td></td>
					  <td></td>';
					  
					   foreach($this->ctlist as $ctlist) {
						$layout .= '<td></td>';
					   } 
					  
					$layout .= '</tr>';					
					   
					 $wkd = '';
					 $x=1;
					 
					 foreach($this->ttarray as $ttarray) { 
							if($wkd!=$ttarray['weekday_id'])
							{
								if($wkd!='') {
									$layout .= '</tr>';
								}
								$layout .= '<tr>';
								$layout .= '<td class="td"><div class="name">'.strtoupper(getDayName($ttarray['weekday'])).'</div></td>';
								$layout .= '<td class="td-blank"></td>';
								$wkd = $ttarray['weekday_id'];
							}
							
					
						
					$layout .= '<td class="td">
							<div style="position: relative;" id="drop_'.$ttarray['id'].'" class="drop" onclick="update_selected_divs(\''.$ttarray['id'].'\');">
							  <div class="tt-subject" id="subject_name_'.$ttarray['id'].'">
								<div class="subject">';
								    if($ttarray['subject_id']) { 
										$qry="select * from `subjects` where id='".$ttarray['subject_id']."'";
										$subject=$db->runQuery("$qry");
										
										$qry="select * from `employees` where id='".$ttarray['employee_id']."'";
										$teacher=$db->runQuery("$qry");
								   
										$layout .= @$subject[0]['code'].'<span>'.@$subject[0]['name'].
										'<div class="emp-name">'.@$teacher[0]['first_name'].' '.@$teacher[0]['last_name'].'</div>
									  
									</span>';
								  } 
								  
								$layout .= '</div>
								<div class="employee">';
								if($ttarray['employee_id']) { 
								 $qry="select * from `employees` where id='".$ttarray['employee_id']."'";
								 $teacher=$db->runQuery("$qry");
										
								  $layout .= @$teacher[0]['first_name'];
								  } 
					$layout .= '</div>
							  </div>
							</div>
							<script type="text/javascript">
				//<![CDATA[
				Droppables.add("drop_'.$ttarray['id'].'", {accept:\'employees_subject\', onDrop:function(draggable_element, droppable_element) { $(droppable_element).highlight(); make_ajax_calls('.$ttarray['id'].', draggable_element.id.split(\'_\').last()); }})
				//]]>
				</script>          </td>';
						
					 
					 $x++;
					 } 
					 $layout .= '</tr>
				  </tbody></table>
				</div>';
				
				
			}
			
			return $layout;
		}
	}
?>