<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

$act=$_POST['act'];

 
 	function link_it($text){

    $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" >$3</a>", $text);

    $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);

    $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);

    return($text);
    }

 
 if( $act == "save_post" ){

  foreach( $_POST as $key=>$post){ $$key = $post; }
  
  
   $timepoint = mktime(substr($date_time,11,2)+0,substr($date_time,14,2)+0,0,substr($date_time,3,2)+0,substr($date_time,0,2)+0,substr($date_time,6,4)+0 );

   $post_body = strip_tags($post_body, '<b><i><u><a><img>');
   
   $post_header = strip_tags($post_header);
   
   $post_tags = strip_tags($post_tags);

   $post_body = link_it( $post_body );
   
   
   $ins= $link->prepare("INSERT INTO postbase(user_id,post_time,header,body,mod_time,post_tags) VALUES (?,?,?,?,?,?)");

   if( $ins ->execute(array($idval,$timepoint,$post_header,$post_body,$timepoint,$post_tags)) )  {    
   
   $post_id = $link->lastInsertId();     

   $root = $_SERVER['DOCUMENT_ROOT'];
 
 
   $upd= $link->prepare("UPDATE imgbase SET file_name=?,file_path=?,post_id=?,src=? WHERE file_id=? ");

   if( is_array($images) ){
   
   foreach( $images as $key=>$imgitem ){
	   
	 $newname =   $post_id.':'.$imgitem['file_name'];
	   $abs_file = $root.$imgitem['src'];
	   $abs_thumb = $root.$imgitem['thumb_src'];
	   
	   $new_file = $root.'/upl/img/'.$newname;
	   $new_thumb = $root.'/upl/img/thumbnail/'.$newname;
	   
	   
	 $upd ->execute(array($newname,'/upl/img/',$post_id,$imgitem['rel_src'],$imgitem['file_id']));  
   
     copy($abs_file,$new_file);  copy($abs_thumb,$new_thumb);
	 
	 unlink($abs_file); unlink($abs_thumb); 
    }
   }
 
  updateSitemap($link);
 
 print("OK");
 
  } 
 
 }
  
 if( $act == "update_post" ){

  foreach( $_POST as $key=>$post){ $$key = $post; }
  
  
   $timepoint = mktime(substr($date_time,11,2)+0,substr($date_time,14,2)+0,0,substr($date_time,3,2)+0,substr($date_time,0,2)+0,substr($date_time,6,4)+0 );

   $post_body = strip_tags($post_body, '<b><i><u><a><img>');
   
   $post_header = strip_tags($post_header);

   $post_tags = strip_tags($post_tags);
   
   $post_body = link_it( $post_body );
   
   
   $upd= $link->prepare("UPDATE postbase SET header=?,body=?,post_time=?,mod_time=?,post_tags=? WHERE post_id=? AND user_id=?");

   if( $upd ->execute(array($post_header,$post_body,$timepoint,time(),$post_tags,$post_id,$idval)) )  {

   $root = $_SERVER['DOCUMENT_ROOT'];
   
   $query="SELECT file_id,file_name,file_path,post_id FROM imgbase WHERE post_id='$post_id' ORDER BY file_id";
   $result=$link->query($query);
   $array=$result->fetchAll();
 
    $del= $link->prepare("DELETE FROM imgbase WHERE file_id=? AND post_id=? ");

  foreach( $array as $imgline ){
 
       $abs_file = $root.$imgline[file_path].$imgline[file_name];
	   $abs_thumb = $root.$imgline[file_path].'thumbnail/'.$imgline[file_name];
 
       unlink($abs_file); unlink($abs_thumb); 
 
  
  $del ->execute(array($imgline[file_id],$imgline[post_id] ));
  }
    
   
  
   $upd= $link->prepare("UPDATE imgbase SET file_name=?,file_path=?,post_id=?,src=? WHERE file_id=? ");

   if( is_array($images) ){
   
   foreach( $images as $key=>$imgitem ){
	   
	   $newname =   $post_id.':'.$imgitem['file_name'];
	   $abs_file = $root.$imgitem['src'];
	   $abs_thumb = $root.$imgitem['thumb_src'];
	   
	   $new_file = $root.'/upl/img/'.$newname;
	   $new_thumb = $root.'/upl/img/thumbnail/'.$newname;
	   
	   
	 $upd ->execute(array($newname,'/upl/img/',$post_id,$imgitem['rel_src'],$imgitem['file_id']));  
   
     copy($abs_file,$new_file);  copy($abs_thumb,$new_thumb);
	 
	 unlink($abs_file); unlink($abs_thumb); 
    }
   }
 
   updateImagemap($link);
   
    print("OK"); }
   
 }
 
 
 ?>