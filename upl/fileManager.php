<?
include_once("../admin/pdo_connect.php");


$act=$_GET['act'];



if($act=='thumblist'){
	
	  foreach ($_GET as $key => $value){ 	 
   $$key=$value;
  }	
  
	
   $query="SELECT file_id,file_name,file_path,post_id,src,post_time,width,height,filesize,usermail FROM imgbase WHERE usermail='$usermail' AND post_id='0' ORDER BY file_id";
   $result=$link->query($query);
   $sr=$result->rowCount();
	
	   
	$jsonanswer='({"file_num":"'.$sr.'","img":[';
	
	
	for($m=0;$m<$sr;$m++){  $array=$result->fetch();	
		 
$rel_path = str_replace($_SERVER['DOCUMENT_ROOT'],'', $array[file_path]);

	 
		 
$resarray=array(

"file_id"=>$array[file_id],
"file_name"=>$array[file_name],
"file_path"=>$rel_path,
"src"=>$rel_path.$array[file_name],
"thumb_path"=>$rel_path.'thumbnail/',
"thumb_src"=>$rel_path.'thumbnail/'.$array[file_name],
"usermail"=>$array[usermail]

);



$jsonanswer.=json_encode($resarray).",";

		 

}
	
	
if($sr>0){$jsonanswer=substr($jsonanswer,0,-1);}



$jsonanswer.=']})';

		
	
	
	
	
	
	
	echo $_GET['callback'].$jsonanswer; 
	
}


?>