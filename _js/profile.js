$(document).ready(function(){
	

	
	if(  $('.main_content .edit_win  .status_alert').attr('id') < 3  ) { 
	
	statusAlert(6000,'Данные профиля были сохранены. Вернуться в <a href="'+$('a#user_profile').attr('href')+'">Мой профиль</a> ');   }
	
	function nickVal(){
		
	$('.main_content .edit_win form#edit_prof label span.chresult').hide();
		
	if(  $(this).val().length > 2 ){
		
		if(  /^[a-zA-Z][a-zA-Z0-9-_\.]{2,20}$/.test( $(this).val() )   ){
			
		$(this).css({'background-size':'0'});
		
		$(this).addClass('valid');
			
		}else{
			
		$(this).css({'background-size':'20px 20px'});
		
		$('.edit_win .half_width .moreinfo span#notify').css('color','rgb(255,81,0)');
;		
		$(this).removeClass('valid');
			
		}
		
	}else{ $(this).css({'background-size':'0'}); $(this).removeClass('valid'); }
		
	}
	
	$('.main_content .edit_win form#edit_prof input#nick_string').keyup(nickVal);
	$('.main_content .edit_win form#edit_prof input#nick_string').blur(nickVal);

	
		
	function nickCheck(type){              // Проверка ника в системе
		
	  if( $('.main_content .edit_win form#edit_prof input#nick_string').attr('class') == 'valid' ){
		  
		  $('.main_content .edit_win form#edit_prof label span.chresult').hide();
		  
			   var checkdata=
		 {
		 usermail:$('.main_content .edit_win form#edit_prof input#mailval').val(),
		 usernick:$('.main_content .edit_win form#edit_prof input#nick_string').val(),
		 act:'check_nick'
		 };	
			
		
	$.post('profileHandler.php',checkdata,function(answer){    

		if(answer == 'OK'){                   // Имя свободно
		
		
		if(type == 'submit'){                // В случае сохранения профиля
			
			var editdata=
		 {
		 usermail:$('.main_content .edit_win form#edit_prof input#mailval').val(),
		 firstname:$('.main_content .edit_win form#edit_prof input[name="firstname"]').val(),
 		 surname:$('.main_content .edit_win form#edit_prof input[name="surname"]').val(),
		 usernick:$('.main_content .edit_win form#edit_prof input#nick_string').val(),
 		 lastnick:$('.main_content .edit_win form#edit_prof input[name="lastnick"]').val(),
		 nick_mod:$('.main_content .edit_win form#edit_prof input[name="nick_mod"]').val(),
		 usercity:$('.main_content .edit_win form#edit_prof input[name="usercity"]').val(),
 		 citystatus:$('.main_content .edit_win form#edit_prof input[name="citystatus"]').val(),
 		 region:$('.main_content .edit_win form#edit_prof input[name="region"]').val(),
 		 countryname:$('.main_content .edit_win form#edit_prof input[name="countryname"]').val(),
		 birthdate:$('.main_content .edit_win form#edit_prof input[name="birthdate"]').val(),
 		 mobile:$('.main_content .edit_win form#edit_prof input[name="mobile"]').val(),
		 act:'update_profile'
		 };	
		
		 $.post('profileHandler.php',editdata,function(answer){ 
		
			  if( answer == 'OK' ){
			 
/* 			        window.location.href='/users/'+editdata.usernick;
 */				   location.reload();
		
		      }
	     });
			
			
		}else{                                         // В случае проверки по нажатию кнопки
			
		$('.main_content .edit_win form#edit_prof label span.vacant').show();  
				
		
		}}else{ $('.main_content .edit_win form#edit_prof label span.occupied').show();    }	

		}); 
		
		
		   
		 		   
	  }else{  $('.main_content .edit_win form#edit_prof input#nick_string').css({'background-size':'20px 20px'});   }}

	
	$('.main_content .profile_face .userpic .deltab a#delpic').click(function(clc){                // Сохранение профиля
	
	clc.preventDefault();
	    
		$(this).parent('div').animate({'top':'0px'},500);
		
		}); 
	$('.main_content .profile_face .userpic .deltab span#no').click(function(clc){     
	
	$(this).parent('div').animate({'top':'-40px'},500);
		
		}); 
	
	
		$('.main_content .profile_face .userpic .deltab span#yes').click(function(clc){     
	
	    	var deldata=
		 {
		 usermail:$('.main_content .edit_win form#edit_prof input#mailval').val(),
 		 lastnick:$('.main_content .edit_win form#edit_prof input[name="lastnick"]').val(),
		 filename:$('.main_content .profile_face .userpic img.avatar_prev').attr('src'),
		 act:'del_ava'
		 };	
		
		 $.post('profileHandler.php',deldata,function(answer){ 
		
			  if( answer == 'OK' ){
	
	    $('	.main_content .profile_face .userpic img.avatar_prev,header .header-content .profile_info img#avatar').attr('src','/img/noavatar.png') 
	
	    $('.main_content .profile_face .userpic .deltab').animate({'top':'-75px'},300);
		
		 }  }); 
		}); 
		
	
	$('.main_content .edit_win form#edit_prof').submit(function(evt){                // Сохранение профиля
	
	evt.preventDefault();
    
	var flag = true;
	
	if ( $(this).find('input[name="firstname"]').val() == '' ){  flag = false;	$(this).find('input[name="firstname"]').css({'background-color':'rgba(244,166,173,.5)'});   }
	
	if ( $(this).find('input[name="usercity"]').val() == '' ){  flag = false;	$(this).find('input[name="usercity"]').css({'background-color':'rgba(244,166,173,.5)'});    }
	
	
	
	if( flag ){   nickCheck('submit');  }		
	   					
				});
				
				
		
   jQuery(function($){   $('.main_content .edit_win form#edit_prof input[name="birthdate"]').mask("99.99.9999",{placeholder:"__.__.____"});  });
   
      jQuery(function($){   $('.main_content .edit_win form#edit_prof input[name="mobile"]').mask("+7(999)999-9999",{placeholder:"+7(___)___-____"});  }); 

	
	$('.main_content .edit_win form#edit_prof button#checkfree').click(nickCheck);
	
	$('.main_content .edit_win form#edit_prof input[type="text"]').click(function(){  $(this).css({'background-color':'rgb(255,255,255)'});   });
	
	
	var usercity = {
		
		countryname:$('.main_content .edit_win form#edit_prof input[name="countryname"]').val(),
		region_id:0,
		region_name:'',
		city_id:0,
		city_status:'',
		city_name:''
	};
	
	
			
	function regionSelect(){
		
		
	 $.getJSON('/get_city.php?callback=?',{act:'get_city',region_id:usercity.region_id},function(result){
		 		 
			var brows = result.city_num / 5 ;
			var count = 1;
			
			$('.main_content .city_select span.adviser').text('Выберите город:');
			
			$('.main_content .city_select .bcolumn').remove();
			
			$('.main_content .city_select').append('<div class="bcolumn"></div>');
			
		            $.each(result.item,function(i,city){  
	
	                $('.main_content .city_select .bcolumn:last-of-type').append('<span class="'+city.status+' city" id="'+city.city_id+'">'+city.name+'</span><br>');
	                 if( count>=brows){
						
						$('.main_content .city_select').append('<div class="bcolumn"></div>');

						 count = 0;
					 } 
					  count++;
					});
			$('.main_content .city_select').append('<div class="clearfix"></div>');		
			
			
	$('.main_content .city_select .bcolumn span.city').click(function(){  
	
	usercity.city_name = $(this).text();
	usercity.city_id = $(this).attr('id');
	usercity.city_status = $(this).attr('class');
	
	$('.main_content .edit_win form#edit_prof input[name="countryname"]').val(usercity.countryname);
	$('.main_content .edit_win form#edit_prof input[name="region"]').val(usercity.region_name);
	$('.main_content .edit_win form#edit_prof input[name="usercity"]').val( usercity.city_name ); 
	$('.main_content .edit_win form#edit_prof input[name="citystatus"]').val( usercity.city_status ); 

		
	$('.main_content .city_select').fadeOut(300);   });

	 });
		
		
	}
	
	
	
	function coutrySelect(){
		
		
	$('.main_content .country_select a.countries').css({'border-color':'rgba(255,255,255,.4)'});
	
	$('.main_content .country_select a.countries[name="'+usercity.countryname+'"]').css({'border-color':'rgba(39,39,39,.4)'});
	
	
	
	 $.getJSON('/get_city.php?callback=?',{act:'get_region',country:usercity.countryname},function(result){
		 		 
			var brows = result.region_num / 5 ;
			var count = 1;
			
			$('.main_content .city_select span.adviser').text('Выберите регион:');
			
			$('.main_content .city_select .bcolumn').remove();
			
			$('.main_content .city_select').append('<div class="bcolumn"></div>');
			
		            $.each(result.item,function(i,region){  
	
	                $('.main_content .city_select .bcolumn:last-of-type').append('<span class="region '+region.status+'" id="'+region.region_id+'">'+region.name+'</span><br>');
	                 if( count>=brows){
						
						$('.main_content .city_select').append('<div class="bcolumn"></div>');

						 count = 0;
					 } 
					  count++;
					});
			$('.main_content .city_select').append('<div class="clearfix"></div>');		
	 
	 
	 
	 	$('.main_content .city_select .bcolumn span.region').click(function(){  
	
	     usercity.region_id = $(this).attr('id');

		 usercity.region_name = $(this).text();
		 
	     regionSelect();
	
		});
		
		
	 });
		
			
		
	}
	

	
	$('.main_content .edit_win form#edit_prof input[name="usercity"]').click(function(){  
		
	if( usercity.countryname == '' ){ usercity.countryname = 'Россия'; }

    coutrySelect();
	
	$('.main_content .city_select').fadeIn(300);    
	

	});
	
		
	
		$('.main_content .country_select a.countries').click(function(){  
	
	     usercity.countryname = $(this).attr('name');
		 
	     coutrySelect();
		 		
	
		});

		

    $('.main_content .city_select #win_close').click(function(){  $('.main_content .city_select').fadeOut(300);    });		
				
				
	
	});
	
	