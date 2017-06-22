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
<meta name="description"  content="Заказать квадрокоптер под индивидуальные задачи в конструкторском бюро. Разработаем и изготовим квадрокоптер на заказ из современных материалов на новом оборудовании." />

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
  	
	
		<img class="img-topoffer" src="../img/img_topoffer.png" alt="Квадрокоптер">

		
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
	
	    <div class="steptab">
	    <img class="tabimg">
	    <h3>1. Проектирование 3D</h3>
		<p>
		Разработка 3D моделей всех узлов летательного аппарата перед началом производства. 
		Только рациональные конструкторские решения с учетом всех пожеланий заказчика. Объемный эскиз на согласование.
		</p>
	    </div>
		
		 <div class="steptab">
	    <img class="tabimg">
	    <h3>2. Обработка материалов</h3>
		<p>
		Прецизионная обработка на станках с ручным управлением и ЧПУ. Лазерная резка и 3D печать.
		Прочные и легкие материалы в сочетании с современными технологиями производства. Прекрасное качество сборки.
		</p>
	    </div>
		
		 <div class="steptab">
	    <img class="tabimg">
	    <h3>3. Электроника и софт</h3>
		<p>
		Проверенные электронные компоненты. Надежный монтаж. Пыле- и влагозащита на борту. Настройка опытными специалистами.
		Разработка программных модулей под нетривиальные задачи заказчика.
		</p>
	    </div>
		
		<div class="clearfix"></div>
		
		<div class="pline"></div>

	<div class="contacts">
	  <h2>Обратная связь</h2>
	  
	  <p class="label">Телефон в Санкт-Петербурге:</p>
	  <div class="phone">(812) 309-74-15</div>
	  
	  <p class="label">Адрес электронной почты:</p>
	  <div class="email">kb@copterteam.ru</div>
	  
	  <form id="contact_form">
	   <label class="header">Форма обратной связи</label>
	   <label>Ваше имя<strong>*</strong>:</label><input name="username" type="text" />
	   <label>Номер телефона<strong>*</strong>:</label><input name="userphone" type="text"  />
	   <label>E-mail:</label><input name="usermail" type="text" />
	   <textarea placeholder="Напишите Ваше сообщение" name="usertext"></textarea> 
	   <button type="submit" >Оставить заявку</button>
		
	    <p class="label afterform">Вы можете оставить заявку в письменном виде, указав в комментариях ориентировочные параметры летательного аппарата и круг предполагаемых задач для него. Тогда мы заранее подготовим и просчитаем возможные варианты решения под различные бюджеты и сроки изготовления квадрокоптера на заказ.</p>
		  
		  <img src="/img/loading.gif" class="loading">
	  </form>
	
			<div class="clearfix"></div>

	</div>
</div>

<?include("../footer.php"); ?>
	
<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/main.js"></script>
<script src="/_js/landing.js"></script>



</body>
</html>
