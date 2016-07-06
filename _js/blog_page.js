$(document).ready(function(){

$('.main_content .postbody').find('b,i,u,a').each(function(index, element) {
    $.each(element.attributes, function() {
        if(  (this.name != 'href') && (this.name != 'rel') ){   

			$(element).attr(this.name,'');
		}
	});
});


$('.main_content .postbody').find('a').each(function(i, elem) {
	
	if(  ( $(elem).attr('href').substring(0,25) != 'http://www.copterteam.ru/' ) && ( $(elem).attr('href').substring(0,9) != '/upl/img/' ) ){
		
	$(elem).attr('target','_blank');
	
	}
	});
	
	
  $('.main_content .post_panel  .add_vote .vote_space #rating').rating({
		fx: 'full',
        image: '../img/stars.png',
        loader: '../img/ajax-loader.gif',
        width: 32,
		minimal: 1,
		url: 'rating.php'
	});
	
	
$('.main_content .post_panel  .add_vote').click(function(){  $(this).find('.vote_space').slideDown(500); })
	
});

