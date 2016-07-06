<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

$act=$_POST['act'];

 
 
 
 if( $act == "profile_check" ){

 $usermail=$_POST['usermail'];

	$pquery = "SELECT usermail,userpass,usernick FROM club_users WHERE usermail='$usermail' AND active='1' ";
	$presult=$link->query($pquery);
	$parray=$presult->fetch();
    
	if( $parray[usernick] == '' ){
		   
		print('EMPTY');

		}else{  print('DONE');   }
 
	
 }

 
 if( $act == "check_nick" ){

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
 
	
 }
  if( $act == "update_profile" ){
 
  $firstname=$_POST['firstname'];
  $surname=$_POST['surname'];
  $usermail=$_POST['usermail'];
  $usernick=$_POST['usernick'];
  $lastnick=$_POST['lastnick'];
  $nick_mod=$_POST['nick_mod'];
  $birthdate=$_POST['birthdate'];
  $mobile=$_POST['mobile'];
  $usercity=$_POST['usercity'];
  $citystatus=trim($_POST['citystatus']);
  $region=$_POST['region'];
  $countryname=$_POST['countryname'];

  
  if( $usernick !== $lastnick){ $nick_mod = time(); }
  
  
    $upd= $link->prepare("UPDATE club_users SET username=?,surname=?,usercity=?,city_status=?,region=?,countryname=?,usernick=?,nick_mod=?,birthdate=?,mobile=?,modified=? WHERE usermail=? ");
	
    if( $upd ->execute(array($firstname,$surname,$usercity,$citystatus,$region,$countryname,$usernick,$nick_mod,$birthdate,$mobile,time(),$usermail)) )  { print('OK'); }


  
  }
  
    if( $act == "del_ava" ){
 
  $usermail=$_POST['usermail'];
  $lastnick=$_POST['lastnick'];
  $filename=$_POST['filename'];

  $oldpath = substr($filename,1);
  
	 $upd= $link->prepare("UPDATE club_users SET avafile=? WHERE usermail=? AND usernick=?");

             if( $upd ->execute(array('',$usermail,$lastnick)) )  {  unlink($oldpath);  print("OK"); }
			 
			 
  
  
	}
?>