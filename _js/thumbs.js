			
			$(document).ready(function(){
			
			
			
			
			$('.prev a.iframe').fancybox({
			type:'iframe',
		  padding:5,
			width:640,
			height:360		
	    });
			
			$('.prev').hover(function(){
			
			$(this).find('a .shadow').fadeIn(200);
			
			},function(){
			
			$(this).find('a .shadow').fadeOut(200);
			
			});
			
			
			
			
			
			
			
			
			
			
			});