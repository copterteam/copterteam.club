<?
include_once("../admin/func.php");
include_once("../admin/pdo_connect.php");

$uquery = $link->query("SELECT clid,usercity,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified FROM club_users WHERE active='1' ORDER BY usernick ");

$usr = $uquery->rowCount();

$uarray = $uquery->fetchAll();
?>
<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage"">
<head>
<meta charset="utf-8" />
<meta name="description"  content="Все участники сообщества COPTERTEAM. Имена пользователей в системе, ссылки на страницы блогов." />

<title>Квадрокоптер на заказ | COPTERTEAM.club </title>


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
	 <li><a href="/">Конструкторское бюро</a></li>
       <li>Квадрокоптер на заказ</li>	
    </ul>
  
    <h1>Квадрокоптер на заказ</h1>

  	<div class="clearfix"></div>

	
</div>

<?include("../footer.php"); ?>
	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/main.js"></script>
	


</body>
</html>
