<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

$act=$_POST['act'];

 
 
switch($act){
 

 case "begin":

$username=$_POST['username'];
$usermail=$_POST['usermail'];


$query = $link->query("SELECT clid,username,usermail,actcode,active FROM club_users WHERE usermail='$usermail' ");

$sr = $query->rowCount();

$array = $query->fetch();

if($array[active]=='1'){   print("DOUBLE");   }else{	

$actcode = substr(md5(time()),-6);

if($array[active]=='0'){
	
		
$upd= $link->prepare("UPDATE club_users SET username=?,actcode=? WHERE usermail=? ");

    if( $upd ->execute(array($username,$actcode,$usermail)) )  { print("OK"); }

	
	
}else{
	
$ins= $link->prepare("INSERT INTO club_users(username,usermail,actcode,active) VALUES (?,?,?,?)");

    if( $ins ->execute(array($username,$usermail,$actcode,'0')) )  { print("OK"); }

}	

 
		   $headers="Content-type:text/html;charset=utf-8\r\n";
           $headers.="From: COPTERTEAM <info@copterteam.ru>\r\n";
           $headers.="Reply-To: info@copterteam.ru\r\n";

           $mail_status=mail($usermail, "Завершение регистрации в клубе COPTERTEAM", "

<!doctype html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta charset='utf-8' />
<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
</head>
<body style='margin:0;padding:0;'>
	 <div style='margin:0;padding:5px;width:100%;background:url(http://club.copterteam.ru/img/linen.png) left top repeat rgb(40,40,40);min-height:300px;'>
	   
	   <div class='header-content' style='max-width:600px;height:68px;margin:0px auto;margin-top:50px;border-bottom:1px solid rgb(40,40,40);font-family:Ubuntu,Tahoma,sans-serif;background-color:#FFF;'>
          <a href='http://www.copterteam.ru'><img src='http://www.copterteam.ru/img/r3logo.png' style='float:left;width:50px;height:50px;margin-top:9px;margin-left:40px;margin-right:30px;' />
		  <span style='float:left;display:inline-block;position:relative;margin-top:21px;margin-left:0px;font-size:21px;letter-spacing:1px;color:rgb(30,30,40);text-transform:uppercase;font-weight:bold;'>Copterteam
		  </span></a>
		  </div>
	   <div style='max-width:600px;margin:0px auto;font-family:Ubuntu,Tahoma,sans-serif;background-color:#FFF;'>
	    <div style='padding:50px;font-size:15px;line-height:30px;'>
		 Здравствуйте! <br/>По заявке с сайта COPTERTEAM.ru высылаем Вам код для завершения регистрации в системе. Скопируйте его и вставьте в соответствующее поле в форме регистрации на сайте.
          <br/>Код подтверждения: 
	      <span style='display:block;width:150px;margin:50px auto;padding:20px;text-align:center;background-color:#FFF;color:rgb(37,37,37); font-size:33px;border-bottom:1px solid rgb(40,40,40);'>$actcode</span>
          <div style='text-align:right;font-size:15px;'>С уважением, команда COPTERTEAM.<br/><a href='mailto:info@copterteam.ru'>info@copterteam.ru</a><br/><a href='http://www.copterteam.ru'>http://www.copterteam.ru</a> </div>       
		</div>
	   </div>
	   <div style='max-width:600px;margin:0px auto;margin-bottom:70px;border-top:1px solid rgb(40,40,40);font-family:Ubuntu,Tahoma,sans-serif;text-align:center;font-size:15px;background-color:#FFF;line-height:50px;'>
	   Это письмо отправлено автоматически. Отвечать на него не требуется.
	   </div>
	</div>
	</body>
</html> 
", $headers);
  }

  break;

   case "validate":

$usermail=$_POST['usermail'];
$val=$_POST['val'];

$query = $link->query("SELECT clid,username,usermail,actcode,active FROM club_users WHERE usermail='$usermail' ");

$array = $query->fetch();


if($array[actcode] == $val ){ print('OK');  }else{  print('WRONG');  }


break;

 case "registr":

$usermail=$_POST['usermail'];
$userpass=$_POST['userpass'];

$regdate = date("Y-m-d H:i:s",time());

$userpass = password_hash($userpass,PASSWORD_BCRYPT);


$upd= $link->prepare("UPDATE club_users SET userpass=?,active=?,regdate=? WHERE usermail=? ");

    if( $upd ->execute(array($userpass,'1',$regdate,$usermail)) )  { 
	
	setcookie('user_name',$usermail,time()+2592000,'/');
     setcookie('session',$userpass,time()+2592000,'/');
	
	
	print("OK"); }else{ print("ERROR");}

	

break;

 case "login":

 $usermail=$_POST['usermail'];
 $userpass=$_POST['userpass'];
 $url=$_POST['url'];

	$pquery = "SELECT usermail,userpass FROM club_users WHERE usermail='$usermail' AND active='1' ";
	$presult=$link->query($pquery);
	$psr=$presult->rowCount();
	
		
	if($psr==0){
	
	print('NO');
		
	}else{
		
	$passarray=$presult->fetch();
    
	if( password_verify($userpass,$passarray[userpass]) ){
		
		setcookie('user_name',$usermail,time()+2592000,'/');
           setcookie('session',$passarray[userpass],time()+2592000,'/');
		   
		print('OK');

		}else{  print('WRONG');   }
 
	}

 break;
 
 case "profile_check":

 $usermail=$_POST['usermail'];

	$pquery = "SELECT usermail,userpass,usernick FROM club_users WHERE usermail='$usermail' AND active='1' ";
	$presult=$link->query($pquery);
	$parray=$presult->fetch();
    
	if( $parray[usernick] == '' ){
		   
		print('EMPTY');

		}else{  print('DONE');   }
 
	
 break;

 
 case "check_nick":

 $usermail=$_POST['usermail'];
  $usernick=$_POST['usernick'];

	$pquery = "SELECT usermail,userpass,usernick FROM club_users WHERE usernick='$usernick'  ";
	$presult=$link->query($pquery);
	$psr = $presult->rowCount();
	
	if($psr > 0 ){
		
	$parray=$presult->fetch();
    
	if( $parray[usermail] == $usermail ){
		   
		print('OK');

		}else{  print('FAIL');   }
 
    }else{  print('OK');   } 
 
	
 break;
 
 
 case "remind":

 $usermail=$_POST['usermail'];

 	$pquery = "SELECT usermail,userpass FROM club_users WHERE usermail='$usermail' AND active='1' ";
	$presult=$link->query($pquery);
	$psr=$presult->rowCount();
	
		
	if($psr==0){
	
	print('NO');
		
	}else{
 
    $newpass = generate_password(6);
     
	$inspass = password_hash($newpass,PASSWORD_BCRYPT);
    
	
 
    $upd= $link->prepare("UPDATE club_users SET userpass=? WHERE usermail=? ");

    if( $upd ->execute(array($inspass,$usermail)) )  { 
	
	
		   $headers="Content-type:text/html;charset=utf-8\r\n";
           $headers.="From: COPTERTEAM <info@copterteam.ru>\r\n";
           $headers.="Reply-To: info@copterteam.ru\r\n";

           $mail_status=mail($usermail, "Сброс пароля для входа в клуб COPTERTEAM", "


<!doctype html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta charset='utf-8' />
<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
</head>
<body style='margin:0;padding:0;'>
	 <div style='margin:0;padding:5px;width:100%;background:url(http://club.copterteam.ru/img/linen.png) left top repeat rgb(40,40,40);min-height:300px;'>
	   
	   <div class='header-content' style='max-width:600px;height:68px;margin:0px auto;margin-top:50px;border-bottom:1px solid rgb(40,40,40);font-family:Ubuntu,Tahoma,sans-serif;background-color:#FFF;'>
          <a href='http://www.copterteam.ru'><img src='http://www.copterteam.ru/img/r3logo.png' style='float:left;width:50px;height:50px;margin-top:9px;margin-left:40px;margin-right:30px;' />
		  <span style='float:left;display:inline-block;position:relative;margin-top:21px;margin-left:0px;font-size:21px;letter-spacing:1px;color:rgb(30,30,40);text-transform:uppercase;font-weight:bold;'>Copterteam
		  </span></a>
		  </div>
	   <div style='max-width:600px;margin:0px auto;font-family:Ubuntu,Tahoma,sans-serif;background-color:#FFF;'>
	    <div style='padding:50px;font-size:15px;line-height:30px;'>
		 Здравствуйте! <br/>По заявке с сайта COPTERTEAM.ru высылаем Вам новый пароль для входа в систему. Рекомендуем сменить его на свой пароль в разделе 'Настройки' после входа.
          <br/>С этого момента Ваш новый пароль: 
	      <span style='display:block;width:150px;margin:50px auto;padding:20px;text-align:center;background-color:#FFF;color:rgb(37,37,37); font-size:33px;border-bottom:1px solid rgb(40,40,40);'>$newpass</span>
          <div style='text-align:right;font-size:15px;'>С уважением, команда COPTERTEAM.<br/><a href='mailto:info@copterteam.ru'>info@copterteam.ru</a><br/><a href='http://www.copterteam.ru'>http://www.copterteam.ru</a> </div>       
		</div>
	   </div>
	   <div style='max-width:600px;margin:0px auto;margin-bottom:70px;border-top:1px solid rgb(40,40,40);font-family:Ubuntu,Tahoma,sans-serif;text-align:center;font-size:15px;background-color:#FFF;line-height:50px;'>
	   Это письмо отправлено автоматически. Отвечать на него не требуется.
	   </div>
	</div>
	</body>
</html> 

", $headers);
	
	
	
	print("OK"); }else{ print("ERROR");  }
 
	}
 
 break;
 
 case "logout":


	setcookie('user_name','',time()-1,'/');
     setcookie('session','',time()-1,'/');
	
	
	print("OK"); 
	

break;


 
 case "submitform":

$username=$_POST['username'];
$usermail=$_POST['usermail'];
$userphone=$_POST['userphone'];
$usertext=$_POST['usertext'];

	$submitmail = 'rucopterteam@gmail.com';

           $headers="Content-type:text/html;charset=utf-8\r\n";
           $headers.="From: COPTERTEAM <info@copterteam.ru>\r\n";
           $headers.="Reply-To: info@copterteam.ru\r\n";

           $mail_status=mail($submitmail, "Заявка с COPTERTEAM landing page", "
		   
		   $usertext  \r\n
		   
		   $username \r\n
		   ------------------------------- \r\n
		   
		   $userphone    /    $usermail
		   
		   ", $headers);

	print("OK"); 
	

break;
   }
   

?>