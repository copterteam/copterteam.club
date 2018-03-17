<?
include_once("../admin/func.php");
include_once("../admin/pdo_connect.php");

$postid = substr($_SERVER['REQUEST_URI'],6);



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



$vote_query = $link->query("SELECT post_id,user_ip,stars FROM rating_votes WHERE post_id='$postid' AND user_ip='$real_ip' ");

$vote_sr = $vote_query->rowCount();

$mark = $vote_query->fetch();


$votes_query = $link->query("SELECT post_id,user_ip FROM rating_votes WHERE post_id='$postid' ");

$votes_sr = $votes_query->rowCount();


$bquery = $link->query("SELECT post_id,user_id,post_time,header,body,mod_time,rating,post_tags FROM postbase WHERE post_id='$postid' ");

$bsr = $bquery->rowCount();

$barray = $bquery->fetch();


$posting_body = $barray[body];

  $posting_body =  str_replace("\n<img","<img", $posting_body);
  
  $posting_body =  str_replace('<a','<a rel="nofollow"', $posting_body);
  
  $posting_body =  str_replace('<a rel="nofollow" href="http://www.copterteam.ru/','<a href="http://www.copterteam.ru/', $posting_body);
  
  $posting_body =  str_replace('<a rel="nofollow" href="http://copterteam.ru/','<a href="http://copterteam.ru/', $posting_body);
   
   $posting_body =  '<p>'.str_replace("\n","<br>", $posting_body).'</p>';
   

if( $bsr == 0  OR  $postid=='' ){  header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); /* Выдаем страницу 404 */  ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<meta name="description" content="Запрашиваема страница не найдена" />
<title>Страница не найдена | COPTERTEAM.club </title>
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/404.css" type="text/css" media="screen">
</head>
<body>
<?include("../header.php"); ?>
<div class="main_content">
<div class="error_message">
Ошибка: запрашиваемая страница сайта не найдена.<br>Возможно, материал был удален из системы.
</div>
</div>
<?include("../footer.php"); ?>
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/main.js"></script>
</body>
</html>
<? exit; }

/* Парсим картинки в тексте */
 
preg_match_all('/<img[^>]+>/i',$posting_body, $img_array);

 $img2 = array();
 
foreach( $img_array[0] as $img_tag)
{
    preg_match_all('/(alt|src)=("[^"]*")/i',$img_tag, $img2[$img_tag]);
}


$fquery = $link->query("SELECT file_id,file_name,file_path,post_id,src,post_time,height,width,filesize FROM imgbase WHERE post_id='$postid' ");

$fsr = $fquery->rowCount();

$farray = $fquery->fetchAll(PDO::FETCH_ASSOC);

$file_array = array();

foreach($farray as $file_info){   	$file_array[$file_info[src]] = $file_info ;  }

$parse_array = array();

$alt_array = array();



foreach($img2 as $tag => $img_info){   

 $parse_array[substr($img_info[2][0],1,-1)] = $tag ;      /*  Массив значений соответсвий src => <img>   */

   $alt_array[substr($img_info[2][0],1,-1)] = substr($img_info[2][1],1,-1) ;        /*  Массив значений соответсвий src => alt   */

                                          }


foreach($parse_array as $src_key=>$parse_img){
	
	if( $file_array[$src_key]['file_id'] > 0 ){

	$img_style='width:100%;max-width:'.$file_array[$src_key]['width'].'px;';

	if( $alt_array[$src_key] !='' ){  $alt_space='<figcaption style="'.$img_style.'" itemprop="headline">'.$alt_array[$src_key].'</figcaption>'; }else{  $alt_space=''; }
	
	if( $file_array[$src_key]['width'] < 1171){ $img_class = 'slim'; }else{ $img_class = 'wide'; }
	
		 $posting_body = str_replace($parse_img,'</p><figure class="'.$img_class.'" itemprop="image" itemscope itemtype="http://schema.org/ImageObject" ><img itemprop="url" itemprop="contentUrl" src="'.$file_array[$src_key]['file_path'].$file_array[$src_key]['file_name'].'" style="'.$img_style.'" alt="'.$alt_array[$src_key].'">'.$alt_space.'<meta itemprop="height" content="'.$file_array[$src_key]['height'].'"><meta itemprop="width" content="'.$file_array[$src_key]['width'].'"><span itemprop="thumbnail" itemscope itemtype="http://schema.org/ImageObject"><a itemprop="url" itemprop="contentUrl" href="'.$file_array[$src_key]['file_path'].'thumbnail/'.$file_array[$src_key]['file_name'].'"></a></span></figure><p>',$posting_body);
				
	}else{  $posting_body = str_replace($parse_img,"",$posting_body);  } 
		
}

$altdesc = "";

foreach($alt_array as $alts){
	
	$altdesc .= $alts.'. ';
	
}

if( $altdesc == ""){ $altdesc = substr ( strip_tags($barray[body]),0,500).'...'; }



$uquery = $link->query("SELECT clid,usercity,city_status,region,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified FROM club_users WHERE clid='$barray[user_id]' ");

$usr = $uquery->rowCount();

$uarray = $uquery->fetch();
	
	
if( $uarray[city_status] == 'capital city'){
 $user_place = $uarray[usercity].', '.$uarray[countryname];
    }else{   $user_place = $uarray[usercity].', '.$uarray[countryname].' ( '.$uarray[region].' )';  }
	
	
	if( ( $_COOKIE['user_name'] == $uarray[usermail] ) AND ( $_COOKIE['session'] == $uarray[userpass] )  ){  $home = true ; }
		
	if($uarray[avafile]!=''){
	
	$avatar_image = '/photos/avatars/'.$uarray[avafile];  }else{
		
	$avatar_image = '/img/noavatar.png'; 
		
	}
		
	if($uarray[username] !=''){ $full2name = $uarray[surname].' '.$uarray[username]; }else{  $full2name = $uarray[username]; }
	
	clearstatcache();

	if( !file_exists($_SERVER['DOCUMENT_ROOT'].$avatar_image)){ $avatar_image = '/img/noavatar.png'; }
	
	
	$post_query = $link->query("SELECT post_id FROM postbase WHERE user_id='$uarray[clid]' ");

    $post_num = $post_query->rowCount();
	
	
	$tag_array = explode(",", $barray[post_tags]);

?>

<!doctype html>
<html itemscope itemtype="http://schema.org/BlogPosting">
<head>
<meta charset="utf-8" />
<meta name="keywords" itemprop="keywords" content="<?echo($barray[post_tags]);?>" />
<meta name="description" itemprop="description" content="<?echo($altdesc);?>" />

<title><?echo($barray[header]);?> | COPTERTEAM.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/blog.css" type="text/css" media="screen">


</head>
<body>



<?include("../header.php"); ?>


<div class="main_content">


<div class="profile_face">
 
 <div class="userpic">
	 <a  href="../users/<?echo($uarray[usernick]);?>" ><img class="avatar_prev" src="<? echo($avatar_image); ?>"></a>
		</div>


	<div class="personal_info" itemprop="author"  itemscope itemtype="http://schema.org/Person">	
		  <a class="nickname" href="../users/<?echo($uarray[usernick]);?>"><span itemprop="additionalName"><?echo($uarray[usernick]);?></span></a>
			<div class="sub_info"><span class="firstname" itemprop="name"><?echo($full2name);?></span><span class="userage"><?echo get_age($uarray[birthdate]);?></span><br/>
              <span class="usercity"  itemprop="homeLocation"><?echo($user_place);?> <?if($uarray[mobile]){?> &nbsp <? echo($uarray[mobile]);?> <?}?></span>			
				</div>	
		</div>			
		
</div>

    <ul class="crumbls">
    <li><a href="/">Главная</a></li>
	      <li><a href="/users/<?echo($uarray[usernick]);?>"><?echo($uarray[usernick]);?></a></li>
		     <li><?echo($barray[header]);?></li>
  </ul>
  
  
<h1 itemprop="headline"><?echo($barray[header]);?></h1>

<div class="postbody" itemprop="articleBody">
<?echo($posting_body);?>
</div>
  <div class="post_panel">
  
  <?if($home){?><a class="but edit" href="/editpost/<?echo($postid);?>">Редактировать</a><?}?>
  
   <?if( $barray[post_tags] !='' ){?><div class="tag_links"><strong>Теги:</strong> <?foreach( $tag_array as $taglink){ echo('<a>#'.trim($taglink).'</a>&nbsp'); }?></div><?}?>
  
  <span class="post_date"><?echo(date('d.m.Y',$barray[post_time]));?></span>
  <meta itemprop="datePublished" content="<?echo(date('Y-m-d H:i:s+04:00',$barray[post_time]));?>">
  <meta itemprop="dateModified" content="<?echo(date('Y-m-d H:i:s+04:00',$barray[mod_time]));?>">
  
  
  <?if( $vote_sr == 0 ){?>
  <div class="add_vote">
  Оценить публикацию
  <div class="vote_space">
  <div id="rating"></div>
  </div></div>
  <? }else{?>  
  <div class="add_vote" style="cursor:default;">
  Ваша оценка: <?echo($mark[stars]);?>
  </div>
  <?}  $rating = 16*$barray[rating];  ?>
  
  <div class="stars" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" >
     	 <meta itemprop="bestRating" content="5">
		  <meta itemprop="worstRating" content="0">
           <meta itemprop="ratingValue" content="<?echo($barray[rating]);?>">
		    <meta itemprop="ratingCount" content="<?echo($votes_sr);?>">
	  <div class="starcover" style="width:<?echo($rating);?>px;"></div>
  </div>
  
  </div>
    

	<div id="vk_comments" style="margin-left:40px; margin-bottom:80px"></div>
	
	
</div>

<?include("../footer.php"); ?>
	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/jquery.rating.min.js"></script>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>


		<script src="/_js/main.js"></script>
		<script src="/_js/blog_page.js"></script>	
		
		
<script type="text/javascript">
  VK.init({apiId: 5521271, onlyWidgets: true});

    VK.Widgets.Comments("vk_comments", {limit: 10, width: "550", attach: "*",autoPublish : 0, mini : 1 });
</script>



</body>
</html>
