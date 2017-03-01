<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");
?>

<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage">
<head>
<meta charset="utf-8" />
<meta name="description" content="Реальный опыт использования квадрокоптеров, гексакоптеров и других мультироторных БПЛА | COPTERTEAM.club " />

<title>Сообщество любителей квадрокоптеров и беспилотных дронов. Реальный опыт использования мультироторных систем. | COPTERTEAM.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="_css/index.css" type="text/css" media="screen">

</head>
<body>
<?include("header.php"); 


	if(!$_COOKIE['user_name']){  
?>

<div class="main_content">

<div class="slide1">

   <h1 class="utp">Сообщество любителей<br/>коптеров и беспилотных дронов</h1>
	 <span class="utp mini">Реальный опыт использования квадрокоптеров, гексакоптеров и других мультироторных БПЛА</span>
<div class="blacktab">  
	 <ul>
     <li>Регистрация в системе позволяет:</li>
     <li>Комментировать материалы сайта</li>
     <li>Делать публикации в персональном блоге</li>
     <li>Общаться с другими членами клуба</li>
     <li>Участвовать в конкурсах на сайте</li>

  </ul>



    <div class="rightcolumn">
      <div class="beginform">
        <form id="beginform">
	        <input type="text" name="username" placeholder="Ваше Имя">
		      <input type="text" name="usermail" placeholder="Ваш E-mail">
          <button type="submit">Быстрая регистрация</button>
	      </form>
		 <form id="regform">
	        <input type="text" name="actcode" placeholder="На почту отправлен код">
		      
			  <input id="userpass" type="password" name="userpass" placeholder="Придумайте пароль">
			  <input type="password" name="userpass2" placeholder="Повторите пароль">
 			  <input type="hidden" name="usermail">

          <button type="submit">Начать работу!</button>
	      </form>
		  <div class="cover"><img src="img/loading.gif"/></div>
      </div>
   </div>
  
  
    <div class="clearfix"></div>
  
 </div> 
  

</div>





 </div>
 
 
<?	}else{  if( $welcome ){ 


	
	$post_query = $link->query("SELECT postbase.post_id, postbase.user_id,postbase.post_time,postbase.header,postbase.body,postbase.mod_time,postbase.rating,imgbase.file_id,club_users.usernick FROM postbase LEFT JOIN imgbase ON (postbase.post_id = imgbase.post_id) LEFT JOIN club_users ON (postbase.user_id = club_users.clid)  WHERE imgbase.post_id IS NOT NULL AND imgbase.width > imgbase.height GROUP BY postbase.post_id ORDER BY postbase.post_time DESC LIMIT 3");

    $post_num = $post_query->rowCount();

	$postarray = $post_query->fetchAll();

    $range='IN ('.$postarray[0][post_id].','.$postarray[1][post_id].','.$postarray[2][post_id].')';
	
    
	
	$img_query = $link->query("SELECT post_id,file_name,file_path,height,width,filesize,src FROM imgbase WHERE  post_id $range AND width > height ORDER BY post_id ");

    $img_num = $img_query->rowCount();

	$imgarray = $img_query->fetchAll(PDO::FETCH_ASSOC);
	
	$images = array();
	
	foreach($imgarray as $key=>$imgarray){
		
		$images[$imgarray[post_id]][] =  $imgarray;
		
	}
	
	
	?>

	
	
	

<div class="main_content">




<?
foreach($postarray as $post){
	
	$post_image = $images[$post[post_id]];
		
	$rating = array();
	
	foreach($post_image as $num=>$image){
				
		$rating[$num] = $post_image[$num][ratio] = abs( ( $image[width]/4 ) - ( $image[height]/3 ) );
	}
	
	asort ($rating);
	reset ($rating);
	

	$best_image = $post_image[current($rating)];
	
	$post_date = date('d.m.Y',$post[post_time]);
?>


<div class="item_to_read">
<a href="/post/<?echo($post[post_id]);?>"><img src="<?echo($best_image[file_path].'thumbnail/'.$best_image[file_name]);?>"></a>
<a href="/post/<?echo($post[post_id]);?>"><?echo($post[header]);?></a>
<div class="author_date">
<span class="author" id="<?echo($post[user_id]);?>"><?echo($post[usernick]);?></span>
<span class="date"><?echo($post_date);?></span>
</div>
</div>

<?}?>


</div>


<? }} include("footer.php"); ?>
	

<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/jquery.inputmask.js"></script>
		
		<script src="_js/main.js"></script>
		<script src="_js/index.js"></script>
	
	 
</body>
</html>