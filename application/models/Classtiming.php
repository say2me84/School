<?php

 	class Classtiming extends Db{
		public function __construct(){
			
		}
		
		public function htmlstring($timetablehtml,$timings,$batchid,$weekdayarray=array()) {
		    $this->timings = $timings;
			$this->batchid = $batchid;
			$layout = '<div id="timetable">'.$timetablehtml.'</div>';
			$layout .= '<div id="period_list">
			<div class="text-input-bg">  
					<select id="timetable_entries_subject_id" name="timetable_entries[subject_id]" onchange="getajax(\''.BASE_PATH.'classtimings/periodlistbyday/batchid/'.$batchid.'\',\'?weekdayid=\'+this.value,\'period_list_name\');" style="width:180px; margin:0px"><option value="">'.LNG_SELECT_DAY.'</option>';
					
					foreach($weekdayarray as $wdar) { 
						$layout .= '<option value="'.$wdar['id'].'">'.getDayName($wdar['weekday']).'</option>';
					} 
					$layout .= '</select>
						  </div>';
			if(isset($this->timings) && count($this->timings) > 0) {
				$layout .= '<div id="period_list_name">';
				$i=1; 
				foreach($this->timings as $timings) { 
					$m=$i%2; 
					if($m==0)
					{
						$class="tr-odd";	
					}else{
						$class="tr-even";	
					}
					
					$layout .= '<div class="periodname" style="text-align:left;"><input type="checkbox" name="chkperiod" id="chkperiod'.$i.'" value="'.$timings['id'].'"  /><span class="name">'.$timings['name'].'</span><br /><span class="time">'.$timings['start_time'].'-'.$timings['end_time'].'</span></div>';
					$i++;
				}
				$layout .= '<input type="hidden" name="totalrec" id="totalrec" value="'.count($this->timings).'" />';
			}
			$layout .= '</div>
			<div>
			
			<div style="float:left; text-align:left; width:180px" class="period_button">
				  
				  <a href="#" onclick="if(checktoedit()) { getajax(\''.BASE_PATH.'classtimings/edit/batch_id/'.$this->batchid.'/id/\'+editrecid, \'\',\'modal-box\',\'2\'); }" title="Edit"><span class="submit-button" title="Edit"><img src="'.IMAGES_URL.'edit_icon.png" border="0" /></span></a>
				  <a href="#" onclick="if(checktodelete()) { getajax(\''.BASE_PATH.'classtimings/edit/mode/delete/batch_id/'.$this->batchid.'/id/\'+deleterecid, \'\',\'modal-box\',\'2\'); }" title="Delete"><span class="submit-button" title="Delete"><img src="'.IMAGES_URL.'delete_icon.png" border="0" /></span></a>
				  <a href="#" onclick="getajax(\''.BASE_PATH.'classtimings/new/batch_id/'.$this->batchid.'\', \'\',\'modal-box\',\'2\');" title="Add New"><span class="submit-button" title="Add New"><img src="'.IMAGES_URL.'add_icon.png" border="0" /></span></a>
				</div>
			</div>
			</div>';
		
		
		return $layout;
	}
}
?>