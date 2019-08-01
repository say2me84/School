<?php

// We can create our custom functions here

function frame_1_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<div class="box_gradient"><table border="0" cellspacing="0" cellpadding="0" width="100%" >
		  <tr>
			<td class="frame_1_1" width="5"><img src="images/blank.gif" width="5"></td>
			<td style="border-top:1px solid #D9E9FF;"><img src="images/blank.gif" width="5"></td>
			<td class="frame_1_2" width="5" ><img src="images/blank.gif" width="5"></td>
		  </tr>
		  <tr>
			<td style="border-left:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
			<td style="font-family:Arial,Verdana,  Helvetica, sans-serif;">';
		echo $frmpre;
		
	}
	function frame_1_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="border-right:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
		  </tr>
		  <tr>
			<td class="frame_1_3" width="5" ><img src="images/blank.gif" width="5"></td>
			<td style="border-bottom:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
			<td class="frame_1_4" width="5" ><img src="images/blank.gif" width="5"></td>
		  </tr>
		</table></div>';
		echo $frmpost;
	}
	
	function tframe_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<table border="0" cellspacing="0" cellpadding="0" width="100%" >
		  <tr>
			<td width="21" style="background-image:url('.IMAGES_URL.'table-left-top.png)">&nbsp;</td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td width="21" style="background-image:url('.IMAGES_URL.'table-right-top.png)">&nbsp;</td>
		  </tr>
		  <tr>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td>';
		echo $frmpre;
		
	}
	function tframe_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
		  </tr>
		  <tr>
			<td width="21" style="background-image:url('.IMAGES_URL.'table-left-bottom.png); height:21px;">&nbsp;</td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td width="21" style="background-image:url('.IMAGES_URL.'table-right-bottom.png)">&nbsp;</td>
		  </tr>
		</table>';
		echo $frmpost;
	}

	function tframe1_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<table border="0" cellspacing="0" cellpadding="0" width="100%" >
		  <tr>
			<td width="21" ><img src="'.IMAGES_URL.'table-left-top.png" style="border:0px;"></td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td width="21"><img src="'.IMAGES_URL.'table-right-top.png" style="border:0px;"></td>
		  </tr>
		  <tr>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td>';
		return $frmpre;
		
	}
	function tframe1_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
		  </tr>
		  <tr>
			<td width="21" height="22"><img src="'.IMAGES_URL.'table-left-bottom.png" style="border:0px;"></td>
			<td style="background-color:#C3D9FF;"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td width="21" height="22"><img src="'.IMAGES_URL.'table-right-bottom.png" style="border:0px;"></td>
		  </tr>
		</table>';
		return $frmpost;
	}
	
function formatDate($date)
{
	//$date Y-m-d
	$explode=explode("-",$date);
	return $explode[1]."-".$explode[2]."-".$explode[0];
}
function changeDate($date)
	{
		if($date=='00-00-0000' || $date=='0000-00-00')
		{
			return "";
		}
		else
		{
		$date = str_replace(",","",$date);
		$split=explode(" ",$date);
		if(is_array($split) && count($split)==3) {
		return $split[2]."-".str_pad(getMonthNo($split[0]),2,0,STR_PAD_LEFT)."-".$split[1];
		} else {
			return '';
		}
		}
	}
	function changeDateTime($date)
	{
		if($date=='00-00-0000 00:00:00' || $date=='0000-00-00')
		{
			return "";
		}
		else
		{
			$date = str_replace(",","",$date);
			$split=explode(" ",$date);
			if(is_array($split) && count($split)==5) {
				$time = explode(":",$split[3]);
				if($split[4]=='PM') {
					if($time[0]==12) {
						$time[0] = '00';
					} else {
						$time[0] = $time[0]+12;
					}
				}
			return $split[2]."-".str_pad(getMonthNo($split[0]),2,0,STR_PAD_LEFT)."-".str_pad($split[1],2,0,STR_PAD_LEFT).' '.$time[0].':'.$time[1].':00';
			} else {
				return '';
			}
		}
	}
	function getMonthNo($m)
	{
		switch($m)
		{
			case "January":return 1;break;
			case "February":return 2;break;
			case "March":return 3;break;
			case "April":return 4;break;
			case "May":return 5;break;
			case "June":return 6;break;
			case "July":return 7;break;
			case "August":return 8;break;
			case "September":return 9;break;
			case "October":return 10;break;
			case "November":return 11;break;
			case "December":return 12;break;
		}
	}
	function getDayName($d)
	{
		switch($d)
		{
			case 0: return "Sun";break;
			case 1: return "Mon";break;
			case 2: return "Tue";break;
			case 3: return "Wed";break;
			case 4: return "Thu";break;
			case 5: return "Fri";break;
			case 6: return "Sat";break;
		}
	}
	function sucessMsg($text){
		$sucessMsg='<div id="msgdiv1" onclick="divremove(1)"  style="cursor:pointer; margin-top:0px" class="msgsecuss" align="left"> <div class="msgsecussimg"> <img src="'.IMAGES_URL.'success_icon.png" border="0" alt="Success" /> </div>
				 <div class="msgsecusstext">'.$text.'</div></div>';
		return $sucessMsg;
	}
		
	
	function warningMsg($text)
	{
	$warningMsg='<div id="msgdiv2" onclick="divremove(2)"  style="display:bloccursor:pointer" class="msgwarning" align="left"> <div class="msgwarningimg"> <img src="'.IMAGES_URL.'Button-Warning-icon.png" border="0" alt="Sucess" /> </div>
			 <div class="msgwarningtext">'.$text.'</div></div>';
	return $warningMsg;
	}
	function errorMsg($text){
		$errorMsg='<div id="msgdiv3" onclick="divremove(3)"  style="cursor:pointer" class="msgerror" align="left"> <div class="msgerrorimg"> <img src="'.IMAGES_URL.'redmsg.png" border="0" alt="Sucess" /> </div>
				 <div class="msgerrortext">'.$text.'</div></div>';
		return $errorMsg;
	}
function array2json($arr) {
    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array();
    $is_list = false;

    //Find out if the given array is a numerical array
    $keys = array_keys($arr);
    $max_length = count($arr)-1;
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true;
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
            if($i != $keys[$i]) { //A key fails at position check.
                $is_list = false; //It is an associative array.
                break;
            }
        }
    }

    foreach($arr as $key=>$value) {
        if(is_array($value)) { //Custom handling for arrays
            if($is_list) $parts[] = array2json($value); /* :RECURSION: */
            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
        } else {
            $str = '';
            if(!$is_list) $str = '"' . $key . '":';

            //Custom handling for multiple data types
            if(is_numeric($value)) $str .= $value; //Numbers
            elseif($value === false) $str .= 'false'; //The booleans
            elseif($value === true) $str .= 'true';
            else $str .= '"' . addslashes($value) . '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

            $parts[] = $str;
        }
    }
    $json = implode(',',$parts);
    
    if($is_list) return '[' . $json . ']';//Return numerical JSON
    return '{' . $json . '}';//Return associative JSON
} 


function cleanData(&$str) { 
	$str = preg_replace("/\t/", "\\t", $str); 
	$str = preg_replace("/\r?\n/", "\\n", $str); 
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

//MWW Functions
	function pr($string_to_print) {
		echo "<pre>";
		print_r($string_to_print);
		echo "</pre>";		
	}
	
	function prd($string_to_print) {
		echo "<pre>";
		print_r($string_to_print);
		echo "</pre>";		
		die;
	}
	
	function encrypt($password)
	{
		$len=strlen($password);
		if($len > 0)
		{
			for($i=0;$i<$len;$i++)
			{
				$password[$i]=chr((ord($password[$i])+$len-$i));
			}
			for($i=0;$i<3;$i++)
			{
				$password .= chr(ord($password[$i])+$len);
			}
		}
		
		return $password;
	}
		
	function decrypt($password)
	{
		$len=strlen($password)-3;
		$passwd = "";
		for($i=0;$i<$len;$i++)
		{
			$temp = ord($password[$i])-($len-$i);
			if($temp < 0)
				$temp += 128;
			$passwd .= chr($temp);
		}
		return $passwd;
	}
		
	function ArraySearch($haystack, $needle, $index = null) 
	{ 
    $aIt     = new RecursiveArrayIterator($haystack); 
    $it    = new RecursiveIteratorIterator($aIt); 
    
    while($it->valid()) 
    {        
        if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) { 
            return $aIt->key(); 
        } 
        
        $it->next(); 
    } 
    
    return false; 
	} 			
	function sanisitize_input($input_string)
	{
		$san_input=trim(htmlspecialchars(stripslashes($input_string)));
		return $san_input;
	}
	
			
		function implodeData($data)
		{
			$req_value = '';
			foreach ($data as $key=>$value)
			{
		         if(is_array($value))
		         {
		            foreach ($value as $key1=>$value1)
		            {
										if(is_array($value1))
										{
											foreach ($value1 as $key2=>$value2)
											{
													$req_value .= $key2.'=>'.$value2.' , ';
											}
						 			  }
						 			  else
						 			  {
												$req_value .= $key1.'=>'.$value1.' , ';
						 				}
		           }
		         }
		         else
		         {
								$req_value .= $key.'=>'.$value.' , ';
				 			}
			}
			return $req_value;
		}
		
		
		
		function addslashesInputVar($input_string=null)
		{
			if($input_string)
			{
				$p = array();
				foreach ($input_string as $key=>$value)
				{
					 if(is_array($value))
					 {
					   $temp=array();
					   foreach ($value as $key1=>$value1)
					   {
						$temp[$key1]=addslashes($value1);
					   }
					   $p[$key]=$temp;
					 }
					 else
						$p[$key] = addslashes($value);
				}
				return $p;
			}
		}
		
		function stripslashesInputVar($input_string=null)
		{
			if($input_string)
			{
				$p = array();
				foreach ($input_string as $key=>$value)
				{
					 if(is_array($value))
					 {
					   $temp=array();
					   foreach ($value as $key1=>$value1)
					   {
						$temp[$key1]=stripslashes($value1);
					   }
					   $p[$key]=$temp;
					 }
					 else
						$p[$key] = stripslashes($value);
				}
				return $p;
			}
		}
		
		function unhtmlentities($string)
		{
			$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
			$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
			$trans_tbl = get_html_translation_table(HTML_ENTITIES);
			$trans_tbl = array_flip($trans_tbl);
			return strtr($string, $trans_tbl);
		}
		
		
	
	function dateDiff($startDate,$endDate)
	{
		if($startDate=='0000-00-00'||$startDate=='0000-00-00 00:00:00')
		{
			$startDate=0;
		}
		if($endDate=='0000-00-00'||$endDate=='0000-00-00 00:00:00')
		{
			$endDate=0;
		}
	  	if(trim($startDate)!=0 && $startDate!=NULL)
	 	 {
		  	$startDate = str_replace("/","-",$startDate);
		  	$startDate = explode(' ',$startDate);
		  	$startDate = strtotime($startDate[0]);
	  	 }
	    if(trim($endDate)!=0 && $endDate!=NULL)
	 	 {
		  	$endDate = str_replace("/","-",$endDate);
		  	$endDate = explode(' ',$endDate);
		  	$endDate = strtotime($endDate[0]);
	  	 }
	    //return ($endDate-$startDate);
	    $datediff = $endDate - $startDate ;
	    
	    $day = $datediff / (60*60*24);
	    
	    return $day;
	    
	}
	
	function endDate($date=null,$monthToAdd=null,$yearToAdd=null)
	{
		
		$addDate = 0;
		$addMonth = 0;
		$addYear = 0;
		
		if($date != null && !empty($date) )
		{
			$currentDate = strtotime($date);
		} else {
			$currentDate = time();
		}
	
		if($monthToAdd != null && !empty($monthToAdd))
		{
			$currentDate = strtotime("+".$monthToAdd." month", $currentDate);
		}
		
		if($yearToAdd != null && !empty($yearToAdd))
		{
			$currentDate = strtotime("+".$yearToAdd." year", $currentDate);;
		}		
	
		//pr($currentDate);
		
		$expiredate = date("Y-m-d", $currentDate);
		
		return $expiredate;
		
	}
	
	function findSpaces($value)
		{
		 	if(strpos($value," ")=== false)
		 	{
		 		return false;
		 	}
		 	else
		 	{
		 		return true;
		 	}
		 }
		 
		 
		function createDirectory($dir_name)
		{
			global $CONFIG_VAR;
			if (!file_exists($dir_name))
			{
				mkdir($dir_name, 0777);
				return true;
			}
			else
				return false;
		}
		
		
		function renameDirectory($previousName,$newName)
		{
			global $CONFIG_VAR;
			
			if (rename($previousName,$newName))
				return true;
			else 
				return false;	
		}
		
		
		
		function removeDirectory($dir_name)
		{
			global $CONFIG_VAR;
			
			if ($handle = opendir($dir_name)) 
			{
				while (false !== ($file = readdir($handle))) 
				{
						if($file!='.' && $file!='..')
							unlink($dir_name."/".$file);   						
				}
				closedir($handle);
			}
			if(rmdir($dir_name))
				return true;
			else 
				return false;
		}
		
		
		
		
		function FileExtention($f)
		{
			$arr=explode(".",$f);
			return $arr[count($arr)-1];
		}
		
		
		function createPath($path)
		{
				if(!trim($path))
						return false;
				$dir_ext = substr($path, 0, strrpos($path,'/'));
				if(!is_dir($dir_ext))
				{
					//echo "<BR/>dir_ext:".$dir_ext;
						createPath($dir_ext); //call itself means recursive loop
						if(!is_dir($path))
						{
								mkdir($path);
								chmod($path, 0777);
						}
						return true;
				}
				else
				{
					clearstatcache();
					if(!is_dir($path))
					{
						mkdir($path);
						chmod($path, 0777);
					}
					return true;
				}
		}					
	
	function __autoloadModels($class_name) 
	{
    	require_once APPLICATION_PATH.'application/models/'.$class_name . '.php';
	}
	//spl_autoload_register(__autoloadModels);
	function __autoloadDB($class_name) 
	{
    	require_once APPLICATION_PATH.'application/models/DbTable/'.$class_name . '.php';
	}	
	function create_random_value($length, $type = 'chars') 
	{
		if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;
	
		$rand_value = '';
		while (strlen($rand_value) < $length) {
		  if ($type == 'digits') {
			$char = rand(0,9);
		  } else {
			$char = chr(rand(0,255));
		  }
		  if ($type == 'mixed') {
			if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
		  } elseif ($type == 'chars') {
			if (eregi('^[a-z]$', $char)) $rand_value .= $char;
		  } elseif ($type == 'digits') {
			if (ereg('^[0-9]$', $char)) $rand_value .= $char;
		  }
		}
	
		return $rand_value;
  	}
	//createjpg($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function createjpg($old_image, $new_image, $new_height, $new_width)
	{	
			if(copy($old_image,$new_image))
			{
			}
			$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
				//echo "<br />destimgthumb =".$destimgthumb ;
			$srcimg=imagecreatefromjpeg($old_image) or die("Problem In opening Source Image"); 
				//echo "<br />srcimg =".$srcimg ; 
			ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
			//ImageCopyResized($destimgthumb,$old_image,0,0,0,0,$new_width,$new_height,imagesx($old_image),imagesy($old_image))  or die("Problem In resizing");
					
			 ImageJPEG($destimgthumb,$new_image) or die("Problem In saving"); 	
			//die;
		return; 
	}
	
	//creategif($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function creategif($old_image, $new_image, $new_height, $new_width)
	{	
		if(copy($old_image,$new_image))
		{
		}
		$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
		$srcimg=imagecreatefromgif($old_image) or die("Problem In opening Source Image"); 
		ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
		ImageGIF($destimgthumb,$new_image) or die("Problem In saving"); 	
		return; 
	}
	
	//createpng($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function createpng($old_image, $new_image, $new_height, $new_width)
	{	
		if(copy($old_image,$new_image))
		{
		}
		$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
		$srcimg=imagecreatefrompng($old_image) or die("Problem In opening Source Image"); 
		ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
		ImagePNG($destimgthumb,$new_image) or die("Problem In saving"); 	
		return; 
	}
	
	
	function sortWorkDate($a=NULL, $b=NULL) 
	{
		 return strcmp($b["DateAdded"],$a["DateAdded"]);
	}
	
	function showLanguageEncode( $string ) {

		return $string;
		if(mb_detect_order($string) ) {
		  return utf8_decode(html_entity_decode(stripslashes($string)));
		} else {
		  return stripslashes(html_entity_decode($string));					  
		}
	}
	
	function myPaging($self,$nume,$start,$limit,$sstring='')
	{
		if($nume!=0)
		{
			$maxpage = ceil($nume/$limit);   
			$current = ($start-1)*$limit;		
	   		$qstring=$sstring;		    	  
			?>		
			<table cellpadding="0" cellspacing="0">
			<tr>
			<td align="left" valign="middle" class="pageText"><strong>Page :</strong>
		  <?
			if($start<=5) 
			{ 
				if($start==1)
				echo "First&nbsp;&nbsp;";
				else
				echo "<a href='$self/start/1/$qstring' class='pagelink'>First</a>&nbsp;&nbsp;"; 
			}
			else 
			echo "<a href='$self/start/1/$qstring' class='pagelink'>First</a>&nbsp;&nbsp;";
			
			$starting=((int)(($start-1)/5)*5)+1;
			if ($starting>5)
			{
				$startpoint=$starting-1;
				$previous=$start-1;
				echo "<a href='$self/start/$previous/$qstring' class='pagelink'>Previous</a>&nbsp;&nbsp;&nbsp;";
			}
			else
			{
				if($start==1)
				echo "Previous&nbsp;&nbsp;&nbsp;";
				else
				{
				$previous=$start-1;
				echo "<a href='$self/start/$previous/$qstring' class='pagelink'>Previous</a>&nbsp;&nbsp;&nbsp;";
				}
			}
			for($i=$starting; $i<=$starting+4; $i++)
			{
				if($start==$i)
					echo "$i&nbsp;";
				else
				{
					if($i<=$maxpage)
					echo "<a href='$self/start/$i/$qstring' class='pagelink'>$i</a>&nbsp;";
					else
					break;
				}
			}
			if ($starting+4<$maxpage)
			{
				$nextstart=$i/5;
				$next=$start+1;
				echo "&nbsp;&nbsp;&nbsp;<a href='$self/start/$next/$qstring' class='pagelink'>Next</a>";
			}
			else
			{
				if($start==$maxpage)
				echo "&nbsp;&nbsp;&nbsp;Next";
				else
				{
					$next=$start+1;
					echo "&nbsp;&nbsp;&nbsp;<a href='$self/start/$next/$qstring' class='pagelink'>Next</a>";
				}
			}		
			if($start>$maxpage-4)
			{ 
				if($start==$maxpage)
				echo "&nbsp;&nbsp;Last";
				else
				echo "&nbsp;&nbsp;<a href='$self/start/".$maxpage."/$qstring' class='pagelink'>Last</a>";
			}
			else 
			echo "&nbsp;&nbsp;<a href='$self/start/".$maxpage."/$qstring' class='pagelink'>Last</a>"; 
			?>
			</td>
			<?php /*?><td width="200" align="left" valign="middle" class="pageText">
			<div align="right">Showing
			<? 
			if ($start*10>$nume)
			{
				$upperlimit=$nume;
				echo ($current+1 ." - ". $upperlimit ." of ". $nume); 
			}
			else 
			echo ($current+1 ." - ". $start*10 ." of ". $nume);
			?>
			</div></td><?php */?>
			</tr>
		</table>
		<? 
		}
	}
	function isLogged()
	{
		global $mySession;

		if (isset($mySession->user['userid'])) 
		{	
				return true;
		}
		else 
		{
				return false;
		}
	
	}
	
function jschars($str)
{
    $str = mb_ereg_replace("\\\\", "\\\\", $str);
    $str = mb_ereg_replace("\"", "\\\"", $str);
    $str = mb_ereg_replace("'", "\\'", $str);
    $str = mb_ereg_replace("\r\n", "\\n", $str);
    $str = mb_ereg_replace("\r", "\\n", $str);
    $str = mb_ereg_replace("\n", "\\n", $str);
    $str = mb_ereg_replace("\t", "\\t", $str);
   // $str = mb_ereg_replace("<", "\\x3C", $str); // for inclusion in HTML
   // $str = mb_ereg_replace(">", "\\x3E", $str);
    return $str;
}
function getsubadmin_role($rolename)
	{
		global $mySession;
		if($mySession->user['usertype']=='SA') {
			if($mySession->user['rights'] && $mySession->user['rights']!='') {
				if(strstr($mySession->user['rights'],$rolename)) {
					return true;
				}
			} 
		} 
		return false;		
	}
	function getfinalresult($sid,$bid,$exids)
	{
		global $mySession;
		$db = new Db();
		if($exids!='') {
			//$qry="select es.*, e.maximum_marks as maxmarks, e.minimum_marks as minmarks, e.subject_id, e.exam_group_id from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$sid."' order by e.subject_id";
			$qry="select es.marks, e.maximum_marks as maxmarks from `exam_scores` as es left join exams as e on(e.id=es.exam_id) where e.exam_group_id in(".$exids.") and es.student_id = '".$sid."' order by e.subject_id";
			$examscoreresult = $db->runQuery($qry);
			$totalmarks = 0;
			$obtainmarks = 0;
			if(is_array($examscoreresult) && count($examscoreresult) > 0) {
				foreach($examscoreresult as $esr) {
					$obtainmarks = $obtainmarks + $esr['marks'];
					$totalmarks = $totalmarks + $esr['maxmarks'];
				}
			}
			echo $obtainmarks.'/'.$totalmarks.' ('.number_format(($obtainmarks*100)/$totalmarks,2).'%)';
			
		}
	
	}

function subjectcolor()
{
	$colorarray[0]='#F6D524';  /// yello;
	$colorarray[1]='#225D09';  /// hard green;
	$colorarray[2]='#FA8E2B';  /// orrange;
	$colorarray[3]='#BC1713';  /// hard red;
	$colorarray[4]='#8705A7';  /// bengani;
	$colorarray[5]='#085CF0';  /// blue;
	$colorarray[6]='#97D603';  /// green;
	$colorarray[7]='#FF1406';  /// red;
	$colorarray[8]='#F6ACE9';  /// purpal;
	$colorarray[9]='#F360CB';  /// ;
	$colorarray[10]='#08C0E2';  /// piggen;
	$colorarray[11]='#0DBAE5';  /// sky blue;
	$colorarray[12]='#C2EDAF';  /// light green;
	$colorarray[13]='#782B6B';  /// hard purpal;
	$colorarray[14]='#FC8F88';  /// light red;
	$colorarray[15]='#8C4E10';  /// matiya;
	$colorarray[16]='#267C8E';  /// hard piggen;
	return $colorarray;
}
function rand_colorCode(){
	$r = dechex(mt_rand(0,255)); // generate the red component
	$g = dechex(mt_rand(0,255)); // generate the green component
	$b = dechex(mt_rand(0,255)); // generate the blue component
	$rgb = $r.$g.$b;
	if($r == $g && $g == $b){
		$rgb = substr($rgb,0,3); // shorter version
	}
	$colorarray = subjectcolor();
	if(in_array('#'.$rgb,$colorarray)) {
		return rand_colorCode();
	} else {	
		return '#'.$rgb;
	}
}
?>