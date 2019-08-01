// JavaScript Document
function checknummsp(e)
{

	evt=e || window.event;
	var keypressed=evt.which || evt.keyCode;
	//alert(keypressed);
	if(keypressed!="48" &&  keypressed!="49" && keypressed!="50" && keypressed!="51" && keypressed!="52" && keypressed!="53" && keypressed!="54" && keypressed!="55" && keypressed!="8" && keypressed!="56" && keypressed!="57" && keypressed!="45" && keypressed!="46" && keypressed!="37" && keypressed!="39" && keypressed!="9")
	{
 		return false;
	}	
}
function chk_numeric(e)
{
 evt=e || window.event;
 var keypressed=evt.which || evt.keyCode;
 //alert(keypressed);
 if(keypressed!="48" &&  keypressed!="49" && keypressed!="50" && keypressed!="51" && keypressed!="52" && keypressed!="53" && keypressed!="54" && keypressed!="55" && keypressed!="8" && keypressed!="56" && keypressed!="57" && keypressed!="45" && keypressed!="9"){
   return false;
 }
 return true;
	
}

function chk_alpha(e)
{
  var key;
 var keychar;
 if (window.event){
  key = window.event.keyCode;  
 }else if (e){
  key = e.which;  
 }

 if((key == 8) || (key == 0))
  return true;
  
 keychar = String.fromCharCode(key);
 keychar = keychar.toLowerCase();
 if(key!=32)
 { 
  
 invalids = "`~@#$%^*()_+=\|{}[]:;'\"<>&?/!,.-1234567890\\";
 // invalids = "`~@#$%^*()_+=\|\,{}[]:;'\"<>&?/!\\";
    for(i=0; i<invalids.length; i++) {
   if(keychar.indexOf(invalids.charAt(i)) >= 0 || keychar==false) {                    
       return false;               
   }
    }
	
}
}
function chk_zero(obj,no)
{
	//alert(obj.value.length);
	
	if(obj.value.length >= no)
	{
		if(no==5)
		{
			chno='00000';	
		}
		if(no==9)
		{
			chno='000000000';	
		}
		if(obj.value==chno)
		{
			alert("Please enter valid no.");
			obj.value='';
			obj.focus();
		}
		
	}
}
function chk_alpha_numeric(e)
{
 var key;
 var keychar;
 if (window.event){
  key = window.event.keyCode;  
 }else if (e){
  key = e.which;  
 }

 if((key == 8) || (key == 0))
  return true;
  
 keychar = String.fromCharCode(key);
 keychar = keychar.toLowerCase();
 if(key!=32)
 { 
  
 invalids = "`~@#$%^*()_+=\|{}[]:;'\"<>&?/!,.-\\";
 // invalids = "`~@#$%^*()_+=\|\,{}[]:;'\"<>&?/!\\";
    for(i=0; i<invalids.length; i++) {
   if(keychar.indexOf(invalids.charAt(i)) >= 0 || keychar==false) {                    
       return false;               
   }
    }
	
}
	
}

function chk_address(e)
{
 var key;
 var keychar;
 if (window.event){
  key = window.event.keyCode;  
 }else if (e){
  key = e.which;  
 }

 if((key == 8) || (key == 0))
  return true;
  
 keychar = String.fromCharCode(key);
 keychar = keychar.toLowerCase();
 if(key!=32)
	 { 
	  
	 invalids = "`~@#$%^*()_+=\|{}[]:;'\"<>&?/!-\\";
	 // invalids = "`~@#$%^*()_+=\|\,{}[]:;'\"<>&?/!\\";
		for(i=0; i<invalids.length; i++) {
		   if(keychar.indexOf(invalids.charAt(i)) >= 0 || keychar==false) {                    
			   return false;               
		   }
		}
		
	}
	
}

function chk_phone(e)
{
  evt=e || window.event;
 var keypressed=evt.which || evt.keyCode;
 //alert(keypressed);
 if(keypressed!="48" &&  keypressed!="49" && keypressed!="50" && keypressed!="51" && keypressed!="52" && keypressed!="53" && keypressed!="54" && keypressed!="55" && keypressed!="8" && keypressed!="56" && keypressed!="57" && keypressed!="43" && keypressed!="45" && keypressed!="9"){
   return false;
 }
 return true;

}

function check_special(e){
 evt=e || window.event;
 var keypressed=evt.which || evt.keyCode;
 //alert (keypressed);
	 if(keypressed=="33" ||  keypressed=="64" || keypressed=="35" || keypressed=="36" || keypressed=="37" || keypressed=="94" || keypressed=="38" || keypressed=="42" || keypressed=="40" || keypressed=="41" || keypressed=="60" || keypressed=="62" || keypressed=="63" || keypressed=="126" || keypressed=="96" || keypressed=="59"){
   return false;
 }
 return true;
}
function check_username(e){
 evt=e || window.event;
 var keypressed=evt.which || evt.keyCode;
 //alert (keypressed);
  if(keypressed=="32"){
	 
   	return false;
 } else {
	 
	 if(check_special(e))
	 {
		 return true;
	 } else {
		 return false;
	 }
 }
}
function trim(value) {
 //alert(value);
   var temp = value;
   var obj = /^(\s*)([\W\w]*)(\b\s*$)/;
   //document.write(obj); exit;
   if (obj.test(temp)) { temp = temp.replace(obj, '$2'); }
   var obj = / +/g;
   temp = temp.replace(obj, " ");
   if (temp == " ") { temp = ""; }
   return temp;
 }
function check_file_extension(obj)
{
	if(obj.value.length!=0){
		var aFile = obj.value.split( "." );
		var n = aFile.length; 
		sExt = aFile[n-1];
		sExt = sExt.toLowerCase();	
		if(sExt=="jpg" || sExt=="png" || sExt=="gif" || sExt=="jpeg" || sExt=="pdf" || sExt=="doc" || sExt=="xls" || sExt=="odt" || sExt=="ods" || sExt=="txt" || sExt=="rtf"){
			
		}
		else{
		   alert("You are uploading an invalid file.");
		   obj.value="";
		   obj.focus();
		   return false;
		}
	}
	return true;
}
function hrefHandler()
{
	var a=window.location.pathname;
	var b=a.match(/[\/|\\]([^\\\/]+)$/);
	var ans=confirm("Are you sure? You want to delete.");
	return ans;
}
function setUnsetBlankValue(sEvent,sId,sValue)
{
	if(sEvent=='1')
	{
		if(document.getElementById(sId).value==sValue)
		{		
		document.getElementById(sId).value='';
		}
	}
	else
	{
		if(document.getElementById(sId).value=='')
		{		
		document.getElementById(sId).value=sValue;
		}
	}
}
