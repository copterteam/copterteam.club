<?

$env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'prod';

if( ENV == 'prod' ) {
	
    $db_user = 'u61668';
    $db_pass = 'tip9tnxyw4';
    $db_name = 'u61668_copterteam';

}else{
	
	$db_user = 'root';
    $db_pass = '';
    $db_name = 'copterteam';
	
	
}	
  try{ $link = new PDO("mysql:host=localhost;dbname=".$db_name,$db_user,$db_pass); } 

  catch (Exception $e) { die("MySQL NOT connected!: " . $e->getMessage()); }

  $link->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $link->query("SET NAMES 'utf8'");
  
  
  
  
  if($_COOKIE['user_name']){



   $usermail = $_COOKIE['user_name'];

   $pquery = $link->query("SELECT clid,usercity,city_status,region,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified,nick_mod FROM club_users WHERE usermail='$usermail' AND active='1' ");

   $parray = $pquery->fetch();
	
	
  if( $parray[city_status] == 'capital city'){
    $user_place = $parray[usercity].', '.$parray[countryname];
    }else{   $user_place = $parray[usercity].', '.$parray[countryname].' ( '.$parray[region].' )';  }
	 
	if( $_COOKIE['session'] == $parray[userpass] ){   // КЉуки в порядке, пароль совпадает

	$welcome = true ;  
	
	
	if($parray[avafile]!=''){
	
	$avatar_file = '/photos/avatars/'.$parray[avafile];  }else{
		
	$avatar_file = '/img/noavatar.png'; 
		
	}
	
	if($parray[username] !=''){ $fullname = $parray[surname].' '.$parray[username]; }else{  $fullname = $parray[username]; }
	
	clearstatcache();

	if( !file_exists($_SERVER['DOCUMENT_ROOT'].$avatar_file)){ $avatar_file = '/img/noavatar.png'; }
	
	
	}else{    // Пароль не совпадает с куки

	setcookie('user_name','',time()-1,'/');
     setcookie('session','',time()-1,'/');

	$welcome = false;  
	
	}

	
	
	
	
	}
  
  ?>