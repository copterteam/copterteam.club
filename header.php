<div id="cover"></div>

<?if($welcome){ ?>

<header>
<div class="header-content"  itemprop="publisher"  itemscope itemtype="http://schema.org/Organization">

<a itemprop="url" href="http://www.copterteam.ru">
<figure class="logo" itemprop="logo" itemscope itemtype="http://schema.org/ImageObject" >
<img itemprop="contentUrl" itemprop="url" src="/img/r3logo.png">
</figure>
<span class="logoname" itemprop="name">Copterteam<em>.club</em></span>
</a>

<div class="log_info">
<span><?echo($parray[username]);?></span>
<span class="light"><?echo($parray[usermail]);?></span>
<img id="log_out" src="/img/logout.png" title="Выйти"/>
</div>

<div class="search_tab">
<form id="top_search" method="post" action="/">
<input type="hidden" name="refer" value="<?echo($_SERVER['REQUEST_URI']);?>" />
<input type="text" name="keywords" placeholder="Поиск..." />
<button></button>
</form>
</div>

<?if($parray[usernick]==''){ ?> <a href="/edit_profile" class="empty" id="user_profile">  <? } else {  ?> 
<a href="/users/<?echo($parray[usernick]);?>" id="user_profile"> 
<?}?>
<div class="profile_info" >
<span>Мой профиль</span><br>
<span class="nick light"><?echo($parray[usernick]);?></span>
<img id="avatar" src="<? echo($avatar_file); ?>" />
</div>
</a>

</div>
</header>



<?}else{?>

<header>
<div class="header-content" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">

<a itemprop="url" href="http://www.copterteam.ru">
<figure class="logo" itemprop="logo" itemscope itemtype="http://schema.org/ImageObject" >
<img itemprop="url" itemprop="contentUrl" src="/img/r3logo.png">
</figure>
<span class="logoname" itemprop="name">Copterteam<em>.club</em></span>
</a>

<div id="login_but">Вход в систему</div>

<div class="search_tab">
<form id="top_search" method="post" action="/">
<input type="hidden" name="refer" value="<?echo($_SERVER['REQUEST_URI']);?>" />
<input type="text" name="keywords" placeholder="Поиск..." />
<button></button>
</form>
</div>


</div>
<div class="clearfix"></div>
<div class="login_space">

 <form id="loginform" >
  <input class="lines" type="text" name="usermail" placeholder="E-mail" />
  <input class="lines" type="password" name="userpass"  placeholder="Пароль" />
  
  <input type="hidden" name="url_string" value="<?echo($_SERVER['REQUEST_URI']);?>" />
    <input type="hidden" name="act" value="login" />

  <button type="submit">Вход в систему</button>
  <img src="/img/loading.gif"/>
 </form>
 
 
 <div class="form_links">
  <a href="/" id="remind">Забыли пароль?</a>
  <a href="/">Регистрация</a>
  
   <div class="form_desc">
    <span class="begin">Для входа в систему укажите e-mail адрес и пароль. Если Вы не помните пароль, нажмите на ссылку сверху.</span>
	<span class="stop">Неверное сочетание электронной почты и пароля! Пожалуйста, повторите попытку или воспользуйтесь функцией сброса пароля.</span>
	<span class="retry">Укажите в первом поле E-mail, для которого требуется восстановить пароль. На этот адрес электронной почты будет выслан новый пароль.</span>
	<span class="404">Указанный адрес электронной почты не был зарегистрирован на сайте! Перейдите к форме регистрации по ссылке сверху.</span>
	<span class="reset">На указанный адрес электронной почты был выслан новый пароль для сайта. Проверьте почту и используйте его для входа.</span>

	</div>
   </div>

 
</div>
</header>

<?}?>