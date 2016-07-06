		$(document).ready(function(){
		

		
		
		var beginform=$('.slide1 .rightcolumn form#beginform').validate({  //   Проверка формы быстрой регистрации
		rules: {	usermail: {  required:true,	email:true  },username: {  required:true} },
	    messages: {		usermail: {   required:"Укажите Ваш E-mail!",	email:"Некорректный адрес E-mail!"  },username: {  required:"Сообщите нам свое имя!" }  },
		submitHandler: function(){$('.slide1 .rightcolumn form#beginform').attr('name','submitted');}
	
	                                          	}); // Конец Validate
												
				var regform=$('.slide1 .rightcolumn form#regform').validate({  //   Проверка формы регистрации
		rules: {	userpass: {  required:true },userpass2: {  equalTo:'#userpass'}  },
	    messages: {		userpass: {   required:"1"  },userpass2: {  equalTo:"2" }  },
		submitHandler: function(){$('.slide1 .rightcolumn form#regform').attr('name','submitted');}
	
	                                          	}); // Конец Validate																				

	                                         																					
																												
				
		 $('.slide1 .rightcolumn form#beginform').submit(function(sbmt){  // Отправка формы быстрой регистрации
		 sbmt.preventDefault();
			
			 if($(this).attr('name')=='submitted'){   //Запуск формы после успешной проверки
     
		 var begindata=
		 {
		 username:$(this).find('input[name="username"]').val(),
		 usermail:$(this).find('input[name="usermail"]').val(),
		 act:"begin"
		 };	
			
			$(this).find('input,button').prop('disabled',true);
			$('.slide1 .rightcolumn .beginform .cover').show();
				
				
		  $.post('feedback.php',begindata,function(answer){
			
			$('.slide1 .rightcolumn .beginform .cover').hide();
			
			if(answer=='DOUBLE'){  			$('.slide1 .rightcolumn form#beginform button').text('Повторная регистрация');   }
			
			else if (answer=='OK'){
			
				$('.slide1 .rightcolumn form#beginform button').hide();
					$('.slide1 .rightcolumn form#regform input[name="usermail"]').val(begindata.usermail);
               	$('.slide1 .rightcolumn form#regform').slideDown(300); 
									

			}
			});
		
		
		
		}});
		
		
		$('.slide1 .rightcolumn form#regform input[name="actcode"]').keypress(function(){
			
		if( $(this).val().length <6 ){ 		$(this).attr('id','wrong').css({'background-image':'url("")'});    }
	 
	 
	 
 });
		
$('.slide1 .rightcolumn form#regform input[name="actcode"]').blur(function(){
	 
	 var finstring = $(this).val().replace(/(^\s+|\s+$)/g,'');
	 
	 var self = this;
	 
	$(this).val(finstring);
	
		if( finstring.length == 6 ){
			
		 	 var regdata=
		 {
		 usermail:$('.slide1 .rightcolumn form#beginform').find('input[name="usermail"]').val(),
		 val:finstring,
		 act:"validate"
		 };	
		 
		 		  $.post('feedback.php',regdata,function(answer){

		 
		 if( answer != 'OK' ){
			 
		 		$(self).attr('id','wrong').css({'background-image':'url("../img/error.png")'}); 

			 
		 }else{ 	$(self).attr('id','right').css({'background-image':'url("../img/checkmark.png")'});   }
		 
				  });
				  
		}else{ 		$(this).attr('id','wrong').css({'background-image':'url("../img/error.png")'});    }
		 	
	 
 });	
		
		 $('.slide1 .rightcolumn form#regform').submit(function(sbmt){  // Отправка формы  регистрации
		 sbmt.preventDefault();
			
			 if(  ($(this).attr('name')=='submitted') && ( $(this).find('input[name="actcode"]').attr('id')=='right')  ){   //Запуск формы после успешной проверки
		
		        	$(this).find('input,select,button').prop('disabled',true);
					$('.slide1 .rightcolumn .beginform .cover img').css('margin-top','100px');
			        $('.slide1 .rightcolumn .beginform .cover').show();
		
		
		   var regdata=
		 {
		 usermail:$(this).find('input[name="usermail"]').val(),
		 userpass:$(this).find('input[name="userpass"]').val(),
		 act:"registr"
		 };	
			
							
		  $.post('feedback.php',regdata,function(answer){
		
		 if( answer != 'OK' ){
			 
			 alert('Произошла ошибка при регистрации! Пожалуйста, повторите попытку');
			 
		 }else{
			 
			 
			 window.location.href='/edit_profile';
			 
		 }
	     


    	 });
		
			}});
		
																				
	
		
		});