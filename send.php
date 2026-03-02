<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
  <meta charset="utf-8" />
</head>
<body>
<?
function sendHTMLemail($to, $subject, $body) { 
	
if (ereg("(.*)< (.*)>", $from, $regs)) {
	   $from = '=?UTF-8?B?'.base64_encode($regs[1]).'?= < '.$regs[2].'>';
	} else {
	   $from = $from;
	}
	
    $headers = "";
	//$headers = "From: $from\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n"; 
    $boundary = uniqid("HTMLEMAIL"); 
    $headers .= "Content-Type: multipart/alternative;".
                "boundary = $boundary\r\n\r\n"; 
    $headers .= "This is a MIME encoded message.\r\n\r\n"; 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/plain; UTF-8\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n";         
    $headers .= chunk_split(base64_encode(strip_tags($body))); 
    $headers .= "--$boundary\r\n".
                "Content-Type: text/html; charset=UTF-8\r\n".
                "Content-Transfer-Encoding: base64\r\n\r\n";    
    $headers .= chunk_split(base64_encode($body)); 

    $result = mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',"",$headers);
    return $result;
}

// Here we get all the information from the fields sent over by the form.
$name = ($_POST['yourName']);
$phone = $_POST['phoneNumber'];
$content = $_POST['msgContent'];
 
$to = 'iris.troyaner@gmail.com';
$subject = 'הודעה מהאתר - איריס טרוינר';
$message = '<html><body dir=rtl>';
$message .= 'מאת: '.stripslashes($name). '<br>'.' טלפון: '.stripslashes($phone). '<br>'.' ההודעה: '.stripslashes($content);
$message .= '</body></html>';

if (strlen(trim($_POST['msgContent']))) { // this line checks that we have a valid textarea
    sendHTMLemail($to, $subject, $message) or die('Error'); //This method sends the mail.
	echo '<p><i style="color:rgb(31, 117, 19);" class="icon foundicon-checkmark"></i>ההודעה נשלחה</p>'; // success message
}else{
	echo '<p>כתבו משהו בתוכן ההודעה</p>';
}

?>
</body>
</html>