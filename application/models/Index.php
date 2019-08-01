<?php
__autoloadDB('Db');
class Index extends Db
{
	public function SendMail($message)
	{
	$subject = 'Contact Us From Lesson Giant Website';
	$to  = 'info@lessongiant.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
	$headers .= 'To: info@lessongiant.com' . "\r\n";
	$headers .= 'From: Lesson Giant <info@lessongiant.com>' . "\r\n";
	$message_body='<table width="80%" cellpadding="0" cellspacing="0" style="border: solid 2px #3F6C19;font-size:12px;font-family:Arial, Helvetica, sans-serif;">
	<tr>
	<td align="left" valign="top"><img src="'.APPLICATION_URL.'image.php?image=images/lesson_giant_logo.jpg&height=150&width=150" border="0"></td>
	</tr>
	<tr>
	<td align="left" valign="top" style="padding:5px;">'.$message.'</td>
	</tr>
	<tr>
	<td align="center" valign="middle" style="background-color:#3F6C19;color:#ffffff;height:25px;">Copyright &copy; Lesson Giant. All Right Reserved.</td>
	</tr>
	</table>';	
	mail($to, $subject, $message_body, $headers);
	return true;
	}
	
	
	public function SendMailFromSite($to,$subject,$message)
	{	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
	$headers .= 'To: '.$to.'' . "\r\n";
	$headers .= 'From: Lesson Giant <info@lessongiant.com>' . "\r\n";
	$message_body='<table width="50%" cellpadding="0" cellspacing="0" style="border: solid 2px #3F6C19;font-size:12px;font-family:Arial, Helvetica, sans-serif;">
	<tr>
	<td align="left" valign="top"><img src="'.APPLICATION_URL.'image.php?image=images/lesson_giant_logo.jpg&height=150&width=150" border="0"></td>
	</tr>
	<tr>
	<td align="left" valign="top" style="padding:5px;">'.$message.'</td>
	</tr>
	<tr>
	<td align="center" valign="middle" style="background-color:#3F6C19;color:#ffffff;height:25px;">Copyright &copy; Lesson Giant. All Right Reserved.</td>
	</tr>
	</table>';
	//echo $message_body;exit();
	mail($to, $subject, $message_body, $headers);
	return true;
	}
	
	public function send_request_via_fsockopen($host,$path,$content)
	{
	$posturl = "ssl://" . $host;
	$header = "Host: $host\r\n";
	$header .= "User-Agent: PHP Script\r\n";
	$header .= "Content-Type: text/xml\r\n";
	$header .= "Content-Length: ".strlen($content)."\r\n";
	$header .= "Connection: close\r\n\r\n";
	$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
	if (!$fp)
	{
		$response = false;
	}
	else
	{
		error_reporting(E_ERROR);
		fputs($fp, "POST $path  HTTP/1.1\r\n");
		fputs($fp, $header.$content);
		fwrite($fp, $out);
		$response = "";
		while (!feof($fp))
		{
			$response = $response . fgets($fp, 128);
		}
		fclose($fp);
		error_reporting(E_ALL ^ E_NOTICE);
	}
	return $response;
	}
	
	//function to send xml request via curl
	public function send_request_via_curl($host,$path,$content)
	{
	$posturl = "https://" . $host . $path;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $posturl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	return $response;
	}
	
	
	//function to parse Authorize.net response
	public function parse_return($content)
	{
	$refId = $this->substring_between($content,'<refId>','</refId>');
	$resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
	$code = $this->substring_between($content,'<code>','</code>');
	$text = $this->substring_between($content,'<text>','</text>');
	$subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
	return array ($refId, $resultCode, $code, $text, $subscriptionId);
	}
	
	//helper function for parsing response
	public function substring_between($haystack,$start,$end) 
	{
	if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) 
	{
		return false;
	} 
	else 
	{
		$start_position = strpos($haystack,$start)+strlen($start);
		$end_position = strpos($haystack,$end);
		return substr($haystack,$start_position,$end_position-$start_position);
	}
	}
}
?>