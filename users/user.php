<?
include_once("../admin/func.php");
include_once("../admin/pdo_connect.php");

$usernick = substr($_SERVER['REQUEST_URI'],7);

$uquery = $link->query("SELECT clid,usercity,city_status,region,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified FROM club_users WHERE usernick='$usernick' and active='1' ");

$usr = $uquery->rowCount();

if( $usr == 0  OR  $usernick=='' ){  header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); /* Выдаем страницу 404 */  ?>
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
Запрашиваемая страница пользователя не найдена.<br>Возможно, никнейм участника был изменен.
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
	
	
	$post_query = $link->query("SELECT postbase.post_id,postbase.user_id,postbase.post_time,postbase.header,postbase.body,postbase.mod_time,postbase.rating FROM postbase  WHERE postbase.user_id='$uarray[clid]'  ORDER BY postbase.post_time DESC");

    $post_num = $post_query->rowCount();

	$postarray = $post_query->fetchAll();

 
	
	$img_query = $link->query("SELECT post_id,file_name,file_path,height,width,filesize,src FROM imgbase WHERE usermail='$uarray[usermail]'  ORDER BY post_id ");

    $img_num = $img_query->rowCount();

	$imgarray = $img_query->fetchAll();
	
	
	$img_data = array();
	
	
	foreach( $imgarray as $img){	$img_data[$img[post_id]][$img[src]] = $img;	}
	
	if( $welcome ){
	
	$fol_query = $link->query("SELECT line_num,Rx,Tx,add_time FROM followers WHERE Rx ='$parray[clid]' AND Tx='$uarray[clid]' ");

    $follower = $fol_query->rowCount();
	
	}
?>

<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage">
<head>
<meta charset="utf-8" />
<meta name="description" content="<?echo($uarray[usernick]);?>, <?echo($full2name);?> - зарегистрированный пользователь сообщества любителей коптеров COPTERTEAM.club . Блоги участников, реальный опыт использования беспилотных коптерных систем." />

<title><?echo($uarray[usernick]);?>, <?echo($full2name);?> профиль пользователя | COPTERTEAM.club </title>

<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/profile.css" type="text/css" media="screen">

</head>
<body>
<?include("../header.php");?>



<div class="main_content"> 

 
<div class="profile_face">
 
 <div class="userpic">
	 <img class="avatar_prev" src="<? echo($avatar_image); ?>" >
		</div>


	<div class="personal_info">	
		  <strong class="nickname"><?echo($uarray[usernick]);?></strong>
			<div class="sub_info"><span class="firstname"><?echo($full2name);?></span><span class="userage"><?echo get_age($uarray[birthdate]);?></span><br/>
              <span class="usercity"><?echo($user_place);?></span>			
				</div>	
		</div>			
		<?if($home){?>
		   <a class="button post_but" href="../new_post" title="Написать в блог">Написать</a>
		       <a class="button change_but" href="../edit_profile" title="Внести изменения в профиль">Изменить</a>
		 		  	  <?}else{ 
					  
					    if( ( $welcome )  AND ( $follower == 1 ) ){?>
						
						<form id="follow"> 
						<input type="hidden" name="Rx" value="<?echo($parray[clid]);?>">
						<input type="hidden" name="Tx" value="<?echo($uarray[clid]);?>">
						<input type="hidden" name="Rx_name" value="<?echo($parray[usernick]);?>">

     					<button type="submit" title="Подписаться на обновления" style="display:none;">Подписаться</button>
						<label title="Отписаться от обновлений?"> Вы подписаны на обновления </label>
								
						</form>
						
						<?}else{?>
						
					    <form id="follow"> 
						<input type="hidden" name="Rx" value="<?echo($parray[clid]);?>">
						<input type="hidden" name="Tx" value="<?echo($uarray[clid]);?>">
   						<input type="hidden" name="Rx_name" value="<?echo($parray[usernick]);?>">

						<button type="submit" title="Подписаться на обновления">Подписаться</button>
						<label title="Отписаться от обновлений?" style="display:none;"> Вы подписаны на обновления </label>	
						</form>
					  						  
					  <?}}?>			
</div>

    <ul class="crumbls">
    <li><a href="/">Главная</a></li>
       <li><a href="/users/">Пользователи</a></li>	
	      <li><?echo($uarray[usernick]);?></li>
  </ul>
  
  <div class="left_column">

  <h1>Блог пользователя <span class="count">(<?echo($post_num);?>)</span></h1>
    <div class="post_list">

	
	<?if($post_num == 0){?>
<div class="noposts">
В блоге пока нет ни одной записи
</div>
<?}else{
	
	foreach($postarray as $postitem){
		
	$rating = 16*$postitem[rating];
	
	$img_list = $img_data[$postitem[post_id]];		$post_date = date("d.m.Y",$postitem[post_time]); 
		
    preg_match_all('/<img[^>]+>/i',$postitem[body], $img_array);

    $img2 = array();
 
    foreach( $img_array[0] as $img_tag){     preg_match_all('/(alt|src)=("[^"]*")/i',$img_tag, $img2[$img_tag]);   }
	
	foreach( $img2 as $img_alt){	  $img_list[substr($img_alt[2][0],1,-1)][alt] = substr($img_alt[2][1],1,-1);   }	
	
	?>

	<div class="post_item">
	
	<?if(count($img_list) > 0 ){
		
	foreach( $img_list as $num=>$img_list ){  if($num>1){?>
	
	<a class="blueimp" href="<?echo($img_list[file_path].$img_list[file_name]);?>" style="display:none;"><img alt="<?echo($img_list[alt]);?>" class="post_image"></a>
	<?	}else{
	if( ($img_list[width]/4 ) >= ($img_list[height]/3) ){ $style='style="width:120px;"'; }else{	$style='style="height:90px;"';	}
	?>
	<a class="blueimp" href="<?echo($img_list[file_path].$img_list[file_name]);?>"><img <?echo($style);?> src="<?echo($img_list[file_path].'thumbnail/'.$img_list[file_name]);?>" alt="<?echo($img_list[alt]);?>" class="post_image"></a>
	<?}}}?>
	
	<a class="post_header" href="../post/<?echo($postitem[post_id]);?>"><?echo($postitem[header]);?></a>
	<span class="post_date"><?echo($post_date);?></span>
	
	  <div class="stars"><div class="starcover" style="width:<?echo($rating);?>px;"></div></div>
	</div>

    <?}}?>
 
 
    </div> 
  </div> 
  
  	<div class="clearfix"></div>

	
</div>


<?include("../footer.php"); ?>
	

	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/blueimp-gallery.min.js"></script>

	<script src="/_js/main.js"></script>
	
	
	<script>
		
	$('a.blueimp').click(function(clc){
		clc.preventDefault();
	
	$('#blueimp_container div.info_div').html('<a href="'+$(this).parent('div.post_item').find('a.post_header').attr('href')+'"class="header">'+$(this).parent('div.post_item').find('a.post_header').text()+'</a>').fadeIn(200);
	
	
		var imglist = [];

		$(this).parent('div.post_item').find('a.blueimp').each(function(i){

         imglist[i] = {
			href: $(this).attr('href'), 
			title: $(this).find('img').attr('alt')			
			  }; 
		});
		
		var gallery = blueimp.Gallery( imglist,
		      {   
			  container: '#blueimp-gallery-carousel', 
			  carousel: true, 
			  startSlideshow: false, 
			  hidePageScrollbars: true, 
			  closeOnSlideClick: true,
			  thumbnailIndicators: false, 
			  onclose: function () {
                 $('#blueimp_container div.info_div').fadeOut(500,function(){ $(this).text(''); }); 
			  }});
		
	});
	
	
	$('.main_content .profile_face form#follow').submit(function(flw){
		
		flw.preventDefault();
		
		var followers = { act:'follow_user', Rx : $(this).find('input[name="Rx"]').val(), Rx_name : $(this).find('input[name="Rx_name"]').val(),Tx : $(this).find('input[name="Tx"]').val() }
		
		var form = this;
		
		$.post('../followme.php',followers,function(ans){
			
			if( ans == 'ok' ){
				
				$(form).find('button').fadeOut(300,function(){
				$(form).find('label').fadeIn(300);
				});
			}
			
			
		});
		
		
	});
	
	</script>
	

	<div id="blueimp_container">
	<div class="carousel_div">
	<div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
	<div class="slides"></div>
	 <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
	</div>
	</div>
	<div class="info_div">
	
	</div>
	</div>
	
	<link rel="stylesheet" href="/_css/blueimp-gallery.min.css" type="text/css" media="screen">

</body>
</html>

