		
	
$(document).ready(function(){
	
		$('button#act-button').click(function(cl){ cl.preventDefault(); 
		
		
		
		$("html, body").delay(100).animate({ scrollTop: '1500px' }, 700);

		});		
	
	
	
	
	
	
	var loginform=$('.contacts form#contact_form').validate({  //   Проверка формы обратной связи
		rules: {	username: {  required:true },userphone: {  required:true },usermail: {  required:false,email:true  } },
		submitHandler: function(){  $('.contacts form#contact_form').attr('name','submitted'); }
	
	                                          	}); // Конец Validate
	
			 $('.contacts form#contact_form').submit(function(sbmt){  // Отправка формы обратной связи
		        sbmt.preventDefault();
			    var self = this;
				
			 if(  $(this).attr('name')=='submitted'  ){   //Запуск формы после успешной проверки
		
		
		
		   var logdata=
		 {
		 username:$(this).find('input[name="username"]').val(),
		 usermail:$(this).find('input[name="usermail"]').val(),
		 userphone:$(this).find('input[name="userphone"]').val(),
		 usertext:$(this).find('textarea[name="usertext"]').val(),
		 act:'submitform'
		 };	
			
		$(this).find('input,textarea,button').prop('disabled',true);
            $('.contacts form#contact_form img.loading').show();
							
		  $.post('/feedback.php',logdata,function(answer){
	
	
     	if( answer != 'OK' ){
			 
			 $(self).attr('name','').find('input,textarea,button').prop('disabled',false);
			       $('.contacts form#contact_form img.loading').hide();
				
		 }else{
			 
			$(self).find('textarea').slideUp(300);
			$(self).find('button').css('width','60%').text('Спасибо! Ваша заявка принята')
			 $('.contacts form#contact_form img.loading').hide();
		 }
	     
		  });
		  
			 }
			 });
});