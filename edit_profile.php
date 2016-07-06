<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

if($welcome){
	
	
	$country_query = $link->query("SELECT country_id,name FROM country WHERE onsite>'0'  ORDER BY onsite ");

	$country_array = $country_query->fetchAll();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">


<title>Редактировать профиль пользователя | COPTERTEAM.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="_css/profile.css" type="text/css" media="screen">
<link rel="stylesheet" href="_css/file_api.css" type="text/css" media="screen">
<link href="_js/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css"/>

		
</head>
<body>
<?include("header.php"); ?>


<div class="main_content">

<div class="profile_face">
 
 	<div id="userpic" class="userpic">
	 <img class="avatar_prev" id="<?echo($parray[clid]);?>" src="<? echo($avatar_file); ?>" >
	   <?if($parray[avafile]!=''){?><div class="deltab"><a href="#" id="delpic">Удалить <strong>Х</strong></a><span id="yes">Удалить</span><span id="no">Отмена</span></div><?}?>
						<div class="js-preview userpic__preview"></div>
						<div class="btn btn-success js-fileapi-wrapper">
							<div class="js-browse">
								<span class="btn-txt">Заменить</span>
								<input type="file" name="filedata"/>
							</div>
							<div class="js-upload" style="display: none;">
								<div class="progress progress-success"><div class="js-progress bar"></div></div>
								<span class="btn-txt">Идет загрузка</span>
							</div>
						</div>
						<div class="cover"><img src="/img/loading.gif"/></div>
					</div>
		<?if($parray[usernick]!=''){?>
		<div class="personal_info">	
		  <strong class="nickname"><?echo($parray[usernick]);?></strong>
			<div class="sub_info"><span class="firstname"><?echo($fullname);?></span><span class="userage"><?echo get_age($parray[birthdate]);?></span><br/>
              <span class="usercity"><?echo($user_place);?></span>			
				</div>	
		</div>	<?}?>		
					


</div>

<div id="popup" class="popup" style="display: none;">
		<div class="popup__body"><div class="js-img"></div></div>
		<div style="margin: 0 0 5px; text-align: center;">
			<div class="js-upload btn btn_browse btn_browse_small">Загрузить</div>
		</div>
	</div>
	
	
<div class="city_select">
<div id="win_close"></div>
<div class="country_select">
<?foreach($country_array as $country){?><a class="countries" name="<?echo($country[name]);?>"><?echo($country[name]);?></a><?}?>
</div>
<span class="adviser">Выберите регион:</span>


    	
</div>


<div class="edit_win" >

<div class="status_alert" id="<?echo( time() - $parray[modified] );?>" >Данные профиля сохранены</div>

 <div class="half_width">
 <strong class="half_header">Обязательные поля:</strong>
 
 </div>

  <div class="half_width">
 <strong class="half_header">Дополнительные поля:</strong>

 </div>

 
  <div class="half_width">
    <span class="moreinfo">Пожалуйста, придумайте никнейм участника сообщества.<span id="notify"> Можно использовать только латинские буквы и цифры без пробелов, а также символы '-' и '_'. Длина от 2 до 20 знаков, первый символ - буква.</span> Выбрав подходящий никнейм, проверьте свободно ли имя, нажав кнопку справа от поля. Смена никнейма возможна не чаще 1 раза в месяц. </span>
     </div>

  <div class="half_width">
     <span class="moreinfo">Кроме основной информации Вы можете указать дополнительные данные о себе. В случае заполнения, Ваши фамилия, возраст и мобильный телефон будут доступны другим частникам сообщества и незарегистрированным посетителям сайта. Эти поля также можно оставить пустыми.</span>
       </div>

 	<div class="clearfix"></div>


 <form id="edit_prof" method="post" action="edit_profile">
 <input type="hidden" id="mailval" value="<?echo($parray[usermail]);?>" />
  <input type="hidden" name="countryname" value="<?echo($parray[countryname]);?>" />
   <input type="hidden" name="region" value="<?echo($parray[region]);?>" />
    <input type="hidden" name="citystatus" value="<?echo($parray[city_status]);?>" />
     <input type="hidden" name="lastnick" value="<?echo($parray[usernick]);?>" />
      <input type="hidden" name="nick_mod" value="<?echo($parray[nick_mod]);?>" />


  <label for="nickname">Никнейм в клубе * :<span class="chresult vacant">свободно</span><span class="chresult occupied">занято</span></label>
 <?
 if( ( time() - $parray[nick_mod] ) > 2592000  ){?>
 <input id="nick_string" type="text" <?if($parray[usernick] != ''){?>class="valid"<?}?> name="nickname" placeholder="Придумайте никнейм" value="<?echo($parray[usernick]);?>" />
  <button type="button" id="checkfree" title="Убедиться, что имя свободно"></button>
 <?}else{
	  $next_mod = date('d.m.Y',$parray[nick_mod]+2592000);	 ?>
 <input id="nick_string" type="hidden" name="usernick" class="valid" value="<?echo($parray[usernick]);?>" />
 <input id="nick_cover" type="text" value="<?echo($parray[usernick]);?>" disabled  />
 <button type="button" id="locked" title="Изменить ник можно будет с <?echo($next_mod);?>" disabled ></button>
 <?}?>
 
 <label for="">Дата рождения:</label>
 <input type="text" name="birthdate" placeholder="В формате дд.мм.гггг" value="<?echo($parray[birthdate]);?>" />
 
  	<div class="clearfix"></div>


 <label for="firstname">Ваше имя * :</label>
 <input type="text" name="firstname" placeholder="Как Вас зовут?" value="<?echo($parray[username]);?>" />
 
 
  <label for="">Ваша фамилия:</label>
 <input type="text" name="surname" placeholder="Ваша фамилия" value="<?echo($parray[surname]);?>"/>
 
  	<div class="clearfix"></div>

 <label for="usercity">Город проживания * :</label>
 <input type="text" name="usercity" placeholder="Выберите город" value="<?echo($parray[usercity]);?>" readonly />


 <label for="">Мобильный телефон:</label>
 <input type="text" name="mobile" placeholder="Номер в формате +7(999)123-4567" value="<?echo($parray[mobile]);?>"/>

  	<div class="clearfix"></div>

 <button type="submit" >Сохранить</button>
 
 </form>	

</div>

</div>


<?  include("footer.php"); ?>
	 
	 	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/jquery.inputmask.js"></script>

    <script>
		var FileAPI = {
			  debug: true
			, media: true
			, staticPath: './FileAPI/'
		};
	</script>
	
	<script src="FileAPI/FileAPI.min.js"></script>
	<script src="FileAPI/FileAPI.exif.js"></script>
	<script src="_js/jquery.fileapi.js"></script>
	<script src="_js/jcrop/jquery.Jcrop.min.js"></script>
	<script src="_js/jquery.modal.js"></script>


	
	
<script>
	function statusAlert(pause,message){
		$('.main_content .edit_win  .status_alert').html(message).fadeIn(500);	
		setTimeout( function(){ $('.main_content .edit_win  .status_alert').fadeOut(500); },pause  );
			}
</script>
	
    	<script src="_js/main.js"></script>
		<script src="_js/profile.js"></script>
		<script src="_js/file_api.js"></script>
		
		
</body>
</html>
<?}else{ header('Location: /');  exit(); }?>