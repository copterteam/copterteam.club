jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      var sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  });
}
});

$(document).ready(function(){
	
	
	
	
	   	var postdata=
		 {
		 mailval:$('.main_content form#upd_post').find('input[name="mail"]').val(),
 		 nickval:$('.main_content form#upd_post').find('input[name="nickval"]').val(),
 		 idval:$('.main_content form#upd_post').find('input[name="idval"]').val(),
		 post_id:$('.main_content form#upd_post').find('input[name="postid"]').val(),
		 images:[],
		 post_header:'',
		 post_body:'',
		 post_tags:'',
 		 date_time:'',
		 act:'update_post'
		 };
		 
		 
		 
	function thumbClick(){
		
		var leftPos = $(this).offset().left;
		var topPos = $(this).offset().top;
		var leftRel = $(this).position().left;
		var imgHeight = $(this).find('img').height() +8;
		
				
		$('.main_content  form.poster .thumbnails span.thumb_item').css({'border-color':'rgba(0,0,0,.0)'});
				
		
		if( leftRel<400 ){        $('form#attachment').css({'top':topPos,'left':leftPos+168,'min-height':imgHeight });        }
		else{           $('form#attachment').css({'top':topPos,'left':leftPos-372,'min-height':imgHeight });              }
		
		$(this).css({'border-color':'rgba(0,0,0,.8)'});  
		
		
		$('form#attachment').fadeIn(300);
		
		$('form#attachment input[name="src"]').val( $(this).find('img').attr('alt') );
				
		
	  }	 
	
   function updateImages(){
	   
	   
	   
	     imgdata = {
					usermail: postdata.mailval,
					act: 'thumblist'
				}
	
				
				 $.getJSON('../upl/fileManager.php?callback=?',imgdata,function(podbor){
					 
					var imgArray = [] ;
					
					$('.main_content  form.poster .thumbnails').text('');
					
					 $.each(podbor.img,function(i,img){  
	   
	                 imgArray[i] = {
						 file_id: img.file_id,
						 file_name: img.file_name,
                         file_path: img.file_path,
                         src: img.src,
                         thumb_path: img.thumb_path,
                         thumb_src: img.thumb_src,
						 rel_src: i+1,
                         usermail: img.usermail
						            } ;  
	   
	                 $('.main_content  form.poster .thumbnails').append('<span class="thumb_item"><img src="'+img.thumb_src+'" alt="'+(i+1)+'" title="'+img.file_name+'"><strong>'+(i+1)+'</strong><div class="coat" title="Прикрепить изображение '+(i+1)+'"></div></span>');
	   
	   
	                 });
	   
	   
	                postdata.images = imgArray;
	   
	   	$('.main_content  form.poster .thumbnails span.thumb_item').hover(function(){	$(this).find('.coat').animate({'opacity':'.6'},300);
						
	    },function(){	$(this).find('.coat').animate({'opacity':'0'},300);   });
	
	
	$('.main_content  form.poster .thumbnails span.thumb_item').click(thumbClick);
	   
	   });
   }
   
updateImages();
   
   
   	$('.main_content  form.poster textarea').focus(function(){
		$('.main_content  form.poster .thumbnails span.thumb_item').css({'border-color':'rgba(0,0,0,.0)'});
	    $('form#attachment').fadeOut(300);

    });	
	$(window).resize(function(){
		$('.main_content  form.poster .thumbnails span.thumb_item').css({'border-color':'rgba(0,0,0,.0)'});
	    $('form#attachment').fadeOut(300);

    });	
	
	$(' form#attachment').submit(function(evt){                // Добавление картинки
	
	evt.preventDefault();
	
	var src = $(this).find('input[name="src"]').val();
	var alt = $(this).find('input[name="alt"]').val();
	
				$('.main_content  form.poster textarea').insertAtCaret('<img src="'+src+'" alt="'+alt+'">');
     
	    $(this).fadeOut(300).find('input').val('');
      		$('.main_content  form.poster .thumbnails span.thumb_item').css({'border-color':'rgba(0,0,0,.0)'});

	  });

	  
	
  $('.main_content  form#upd_post input#date_time').datetimepicker({
	  timepicker:true,
      format:'d.m.Y H:i',
      lang:'ru',
	  maxDate:new Date(),
	  fixed:false
    });
    $.datetimepicker.setLocale('ru');
	
	   
	 $('.main_content form#upd_post button#submit_form').click(function(evt){             // Сохранение записи
	
      
   		if( $(this).parent('form').find('input[name="post_header"]').val() != '' ){

	  
		   postdata.post_header = $(this).parent('form').find('input[name="post_header"]').val();
		   postdata.post_body = $(this).parent('form').find('textarea[name="post_body"]').val();
  		   postdata.post_tags = $(this).parent('form').find('input[name="post_tags"]').val();
 		   postdata.date_time = $(this).parent('form').find('input[name="date_time"]').val();
		
		 
		 $.post('../posterHandler.php',postdata,function(answer){ 
		
			  if( answer == 'OK' ){
			 
			        window.location.href='/post/'+postdata.post_id;
			  		
		      }
	     }); 
	   }else{ $(this).parent('form').find('input[name="post_header"]').addClass('error').focus(); }
	 });
	 
	 	$('.main_content form#upd_post input[name="post_header"]').change(function(){ $(this).removeClass('error'); } );  

	 
	$('.main_content  form .tools label.attachment').click(function(){
		
		$('div#cover').fadeIn(300,function(){
			
			$('body,html').animate({ scrollTop: 0 }, 10); 
			
			$('form#attachment').fadeOut(300).find('input').val('');
			
			$('.main_content .img_uploader').slideDown(500,function(){ $('.main_content .img_uploader .container').animate({'opacity':1},300);  });
			
				
		}); 
				
	});	
	 
	 	$('.main_content  form label.tags').click(function(){  $('.main_content  form.poster input#tags').slideToggle(100);   });

	
	
    $('.main_content  form.poster .tools label.hyper_link').click(function(){  $('.main_content  form.poster .tools div#link_tab').fadeIn(200);   });
	$('.main_content  form.poster textarea').focus(function(){  $('.main_content  form.poster .tools div#link_tab').fadeOut(200);    });

    
	$('.main_content  form.poster .tools div#link_tab i').hover(function(){	$(this).animate({'opacity':'1'},300);
						
	    },function(){	$(this).animate({'opacity':'.7'},300);   });
	
	$('.main_content  form.poster .tools div#link_tab i').click(function(){  $(this).parent('div').fadeOut(200).find('input').val('');   });

	
	$('.main_content  form.poster .tools div#link_tab button').click(function(){  
	
	var l_url = $('.main_content  form.poster .tools div#link_tab input[name="link_url"]').val();
	var l_text = $('.main_content  form.poster .tools div#link_tab input[name="link_text"]').val();
	
	var input_tag = '<a href="'+l_url+'">'+l_text+'</a>';
	
	if( (  (l_url.substring(0,6) =='ftp://') || ( l_url.substring(0,7) =='http://' ) || (l_url.substring(0,8) =='https://')  ) && ( l_text !='' )  ){
	
	$('.main_content  form.poster textarea').insertAtCaret(input_tag);
	
	$(this).parent('div').fadeOut(200).find('input').val('');  
    	}else{
			
			if(  (l_url =='')  || ( ( l_url.substring(0,6) !='ftp://' ) && ( l_url.substring(0,7) !='http://' ) && (l_url.substring(0,8) !='https://') ) ){   $('.main_content  form.poster .tools div#link_tab input[name="link_url"]').addClass('error');  }
			
				if(  l_text =='' ){   $('.main_content  form.poster .tools div#link_tab input[name="link_text"]').addClass('error');  }
			
			
		}
	 });
	 
	 	$('.main_content  form.poster .tools div#link_tab input').keyup(function(){   $(this).removeClass('error');    });

		
		
     $('.main_content .img_uploader .upload_tools button').click(function(){
		 
		 var self = this;
			
		$('.main_content .img_uploader .container').animate({'opacity':0},300,function(){
			
						$('.main_content .img_uploader .container form#fileupload table tr.template-upload').remove();

	     	$('.main_content .img_uploader').slideUp(500,function(){    
			
			  $('body,html').animate({ scrollTop: 0 }, 10); 
			   
			  $('div#cover').fadeOut(300);   
			  
     	      if( $(self).attr('id') == 'save_files' ){  updateImages(); }
		       if( $(self).attr('id') == 'cancel_upload' ){  updateImages(); }
    		});
		}); 	
			
						
			
			
				});
				
				
		
	 
	   			});