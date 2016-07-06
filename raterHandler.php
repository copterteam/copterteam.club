<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

$act=$_POST['act'];


if($act=='vote_post'){
	
	$stars=$_POST['rating'];
	
	
$url_string=$_SERVER['HTTP_REFERER'];

$get = strrpos($url_string,"post/");

$postid = substr($url_string,$get+5);  



if (!empty($_SERVER["HTTP_CLIENT_IP"]))
{
 //check for ip from share internet
 $real_ip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
 // Check for the Proxy User
 $real_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
 $real_ip = $_SERVER["REMOTE_ADDR"];
}




   $ins= $link->prepare("INSERT INTO rating_votes(vote_time,stars,user_ip,post_id) VALUES (?,?,?,?)");

  if( $ins ->execute(array(time(),$stars,$real_ip,$postid))  ){




$vote_query = $link->query("SELECT count(user_ip),sum(stars) FROM rating_votes WHERE post_id='$postid' ");

$voter = $vote_query->fetch();

$average = $voter[1]/$voter[0];


 $upd= $link->prepare("UPDATE postbase SET rating=? WHERE post_id=? ");
 
  $upd ->execute(array($average,$postid));  

print($average);

  }
}

?>