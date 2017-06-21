		
	
$(document).ready(function(){
	
		$('button#act-button').click(function(cl){ cl.preventDefault(); 
		
		$(document).scroll('1500');

		});		
	
	
	
	
	
	
	var loginform=$('.contacts form#contact_form').validate({  //   Проверка формы обратной связи
		rules: {	username: {  required:true },userphone: {  required:true },usermail: {  required:false,email:true  } },
		submitHandler: function(){  $('header .login_space form#loginform').attr('name','submitted'); }
	
	                                          	}); // Конец Validate
	
			 $('.contacts form#contact_form').submit(function(sbmt){  // Отправка формы обратной связи
		        sbmt.preventDefault();
			    var self = this;
				
			 if(  $(this).attr('name')=='submitted'  ){   //Запуск формы после успешной проверки
		
		        	$(this).find('input,textarea,button').prop('disabled',true);
		
		
		   var logdata=
		 {
		 username:$(this).find('input[name="username"]').val(),
		 usermail:$(this).find('input[name="usermail"]').val(),
		 userphone:$(this).find('input[name="userphone"]').val(),
		 usertext:$(this).find('input[name="usertext"]').val(),
		 act:'submitform'
		 };	
			
							
		  $.post('/feedback.php',logdata,function(answer){
	
	
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
	     
		  });
		  
			 }
			 });
});