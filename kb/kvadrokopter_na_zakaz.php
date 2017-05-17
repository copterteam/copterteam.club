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

<title>Квадрокоптер на заказ | Конструкторское бюро Copterteam.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/blog.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/landing.css" type="text/css" media="screen">

</head>
<body>



<?include("../header.php"); ?>


<div class="main_content">


    <ul class="crumbls" style="margin-top:20px;">
    <li><a href="/">Главная</a></li>
	 <li><a href="">Конструкторское бюро</a></li>
       <li>Квадрокоптер на заказ</li>	
    </ul>
  
    <h1>Квадрокоптер на заказ</h1>
      <h2>Разработаем проект. Изготовим квадрокоптер из современных материалов. Подключим и настроим электронику и софт.</h2>
  	
	
		<img class="img-topoffer" src="../img/img_topoffer.png">

		
		<ul class="profits">
		  <li>Ключевые принципы работы:</li>
		   <li>Разработка на базе типовых платформ под конкретные задачи</li>
		   <li>Проектирование с учетом индивидуальных требований</li>
		   <li>Производство узлов и компонентов на новом оборудовании</li>
		   <li>Сборка и монтаж электроники на борту</li>
		   <li>Полетные испытания и проверка всех систем в действии</li>
		   <li>Поддержка и обслуживание в течении всего срока эксплуатации</li>

		   <button type="button" id="act-button">Оставить заявку на просчет</button>
		</ul>
		
		
		<div class="clearfix"></div>
		
		<div class="pline"></div>

	<div class="contacts">
	  <h2>Обратная связь</h2>
	  
	  <p class="label">Телефон в Санкт-Петербурге:</p>
	  <div class="phone">(812) 350-10-22</div>
	  
	  <p class="label">Адрес электронной почты:</p>
	  <div class="email">kb@copterteam.ru</div>
	  
	  <form id="contact_form">
	   <label class="header">Форма обратной связи</label>
	   <label>Ваше имя<strong>*</strong>:</label><input type="text" />
	    <label>Номер телефона<strong>*</strong>:</label><input type="text"  />
		 <label>E-mail:</label><input type="text" />
		 <textarea placeholder="Напишите Ваше сообщение"></textarea> 
	    <button type="submit" >Оставить заявку</button>
	  </form>
	
			<div class="clearfix"></div>

	</div>
</div>

<?include("../footer.php"); ?>
	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/main.js"></script>
	


</body>
</html>
