<?
include_once("../admin/func.php");
include_once("../admin/pdo_connect.php");

$uquery = $link->query("SELECT clid,usercity,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified FROM club_users WHERE active='1' AND usernick <>'' ORDER BY usernick ");

$usr = $uquery->rowCount();

$uarray = $uquery->fetchAll();
?>
<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage"">
<head>
<meta charset="utf-8" />
<meta name="description"  content="Все участники сообщества COPTERTEAM. Имена пользователей в системе, ссылки на страницы блогов." />

<title>Все участники сообщества | COPTERTEAM.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/blog.css" type="text/css" media="screen">

<style>
.main_content .profile_face{
	
	box-sizing:border-box;
	width:50%;
	min-height:150px;
	border-color:#f7f7f7;
	float:left;
}

</style>
</head>
<body>



<?include("../header.php"); ?>


<div class="main_content">


    <ul class="crumbls" style="margin-top:20px;">
    <li><a href="/">Главная</a></li>
       <li>Пользователи</li>	
	      <li><?echo($uarray[usernick]);?></li>
  </ul>
  
    <h1>Все пользователи <span class="count">(<?echo($usr);?>)</span></h1>
  	<div class="clearfix"></div>

<?foreach($uarray as $uarray){
	
	
	if($uarray[avafile]!=''){
	
	$avatar_image = '/photos/avatars/'.$uarray[avafile];  }else{
		
	$avatar_image = '/img/noavatar.png'; 
		
	}
		
	if($uarray[username] !=''){ $full2name = $uarray[surname].' '.$uarray[username]; }else{  $full2name = $uarray[username]; }
	
	clearstatcache();

	if( !file_exists($_SERVER['DOCUMENT_ROOT'].$avatar_image)){ $avatar_image = '/img/noavatar.png'; }
	
	
	
	?>
<div class="profile_face">
 
 <div class="userpic">
	 <a  href="<?echo($uarray[usernick]);?>" ><img class="avatar_prev" src="<? echo($avatar_image); ?>"></a>
		</div>


	<div class="personal_info"  itemscope itemtype="http://schema.org/Person">	
		  <a class="nickname" href="<?echo($uarray[usernick]);?>"><span itemprop="additionalName"><?echo($uarray[usernick]);?></span></a>
			<div class="sub_info"><span class="firstname" itemprop="name"><?echo($full2name);?></span><span class="userage"><?echo get_age($uarray[birthdate]);?></span><br/>
              <span class="usercity"  itemprop="homeLocation"><?echo($uarray[usercity].', '.$uarray[countryname]);?></span>			
				</div>	
		</div>			
		
</div>

<?}?>


  	<div class="clearfix"></div>

	<div style="margin:100px 30px" id="vkComments"></div>
	
</div>

<?include("../footer.php"); ?>
	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>

		<script src="/_js/main.js"></script>
	
			
<script type="text/javascript">
  VK.init({apiId: 5521271, onlyWidgets: true});

  VK.Widgets.CommentsBrowse('vkComments',{limit: 10, width: "500", mini : 1 });
   
</script>


</body>
</html>
