var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPod/i);
    },
		 iPad: function() {
        return navigator.userAgent.match(/iPad/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    mini: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
    };
		
		
	
$(document).ready(function(){
	
		
	function toggleLogin(){
		
		var self=this;
		
		if($('header .login_space').css('height')=='0px'){ 
		
		
		$('header .login_space').animate({'height':'200px'},500,function(){
			
		
		$('header .login_space div.form_links .form_desc').css({'color':'rgb(139,139,159)'}).find('span.begin').fadeIn(300);
		
		$(self).text('Отменить');
		
		});
		
		}else{
			
		$('header .login_space').animate({'height':'0px'},500,function(){
		
        $('header .login_space form#loginform input.lines').prop('disabled',false).val(''); 
        $('header .login_space form#loginform input[name="act"]').val('login');		
		$('header .login_space form#loginform button').text('Вход в систему');
		$('header .login_space div.form_links .form_desc span').hide();
		
        $(self).text('Вход в систему');
		
		
		
		});
		}
		
		
		
	}	

	
$('header .login_space div.form_links a#remind').click(function(evt){
	 evt.preventDefault();
	 $('header .login_space form#loginform input[name="userpass"]').val('').prop('disabled',true);
	 $('header .login_space form#loginform button').text('Сбросить пароль');
	 $('header .login_space div.form_links .form_desc span').hide();
	 $('header .login_space div.form_links .form_desc').css({'color':'rgb(139,139,159)'}).find('span.retry').fadeIn(300);
	 $('header .login_space form#loginform input[name="act"]').val('remind');
	

});
	
	var loginform=$('header .login_space form#loginform').validate({  //   Проверка формы входа в систему
		rules: {	usermail: {  required:true,	email:true  },userpass: {  required:true} },
	    messages: {		usermail: {   required:"Укажите Ваш E-mail!",	email:"Некорректный адрес E-mail!"  },userpass: {  required:"Введите пароль!" }  },
		submitHandler: function(){  $('header .login_space form#loginform').attr('name','submitted'); }
	
	                                          	}); // Конец Validate
	
			 $('header .login_space form#loginform').submit(function(sbmt){  // Отправка формы  входа в систему
		        sbmt.preventDefault();
			    var self = this;
				
			 if(  $(this).attr('name')=='submitted'  ){   //Запуск формы после успешной проверки
		
		        	$(this).find('input.lines,button').prop('disabled',true);
			        $('header .login_space form#loginform img').show();
		
		
		   var logdata=
		 {
		 usermail:$(this).find('input[name="usermail"]').val(),
		 userpass:$(this).find('input[name="userpass"]').val(),
         url:$(this).find('input[name="url_string"]').val(),
		 act:$(this).find('input[name="act"]').val()
		 };	
			
							
		  $.post('/feedback.php',logdata,function(answer){
	
	if(logdata.act == 'login'){
	
     	if( answer != 'OK' ){
			 
			 $(self).attr('name','').find('input.lines,button').prop('disabled',false);
			        $('header .login_space form#loginform img').hide();
					
		        $('header .login_space div.form_links .form_desc span').hide();
					$('header .login_space div.form_links .form_desc').css({'color':'rgb(255,81,0)'}).find('span.stop').fadeIn(300);    
			 
		 }else{
			 
			 logdata.act = 'profile_check';
			 
			 $.post('/profileHandler.php',logdata,function(answer){
			 
			    switch (answer){
					
					case 'EMPTY':   window.location.href = '/edit_profile' ;

					break;
					
					case 'DONE':   window.location.href = logdata.url ;

					break;
				}
			 });
		 }
	     
		  }else if (logdata.act == 'remind'){

		  
		$(self).attr('name','').find('input.lines,button').prop('disabled',false); 
        $(self).find('input[name="act"]').val('login');	
        $(self).find('button').text('Вход в систему');	 		
		  	  			        $('header .login_space form#loginform img').hide();

		  
		  if( answer != 'OK' ){
			  			  
			   $('header .login_space div.form_links .form_desc span').hide();
					$('header .login_space div.form_links .form_desc').css({'color':'rgb(255,81,0)'}).find('span.404').fadeIn(300);    
			  			  
		  }else{
			  
			   $('header .login_space div.form_links .form_desc span').hide();
					$('header .login_space div.form_links .form_desc').css({'color':'rgb(139,139,159)'}).find('span.reset').fadeIn(300);    
					
		  }
		       
		  
		  }
    	 });
		
			}});
			
			
			
		 
                $('header .login_space form#loginform button').hover(function(){
					
					$(this).animate({'background-color':'rgba(255,81,0,.1)'},300);
					
				},function(){  $(this).animate({'background-color':'rgba(255,81,0,0)'}); });
		   
		
		         $('header .header-content div#login_but').hover(function(){
					
					$(this).animate({'background-color':'rgba(141,182,186,.2)'},300);
					
				},function(){  $(this).animate({'background-color':'rgba(141,182,186,0)'},300);});
		   
		
			$('footer img#scroll_top').hover(function(){
 	
		 $(this).animate({'opacity':'0.9'},300);
		
	},function(){		 $(this).animate({'opacity':'0.5'},300);		});
	
	$('footer img#scroll_top').click(function(){ 		$("html, body").delay(100).animate({ scrollTop: '0px' }, 700); 	});
						
		
	$(window).scroll(function(evt){  

	var posTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
	
     if(posTop < 500){ $('footer img#scroll_top').fadeOut(200);   }else{ 	 $('footer img#scroll_top').fadeIn(200); 	 }


	});
	
		 $('header .header-content .log_info img#log_out').click(function(){
			 
		 var logdata= {	 act:"logout"	 };	
		 
		 		  $.post('/feedback.php',logdata,function(answer){
					  
					  if( answer == 'OK' ){
			 
			        window.location.href = $('header .header-content .search_tab form#top_search input[name="refer"]').val();
			 
				  }});
			 
		 });	

       $('header .header-content div#login_but').click( toggleLogin );
			
		$('footer a#getlink').click(function(cl){ cl.preventDefault();  prompt('Ссылка на текущую страницу для вставки на сайт:','<a target="_blank" href="'+$(this).attr('href')+'">'+$(this).attr('href')+'</a>' ) });					
		
		});