


$(document).ready(function(){
	
	
		function  uploadAva(){
						$('#userpic').fileapi({
							url: 'ava_handler.php',
							multiple: false,
							accept: 'image/*',
							maxSize:2048000,
							imageSize: { minWidth: 200, minHeight: 200 },
							elements: {
								active: { show: '.js-upload', hide: '.js-browse' },
								preview: {
									el: '.js-preview',
									width: 200,
									height: 200
								},
								progress: '.js-progress'
							},
							data: {
							action:'upload',
							usermail:$('.main_content .edit_win form#edit_prof input#mailval').val()						
							},
							onSelect: function (evt, ui){
								
							  $('.main_content .profile_face .userpic .cover').hide();  	
                             ui.all; // All files
                             ui.files; // Correct files
                             
							 if( ui.other.length ){            // errors
		
                             var errors = ui.other[0].errors;
                             
							 if( errors.minWidth || errors.minHeight){							 				  
								 	statusAlert(6000,'Файл не был загружен. Минимальные размеры изображения: 200 х 200 px');
								 }
							   if( errors.maxSize ){							 				  
								statusAlert(6000,'Файл не был загружен. Максимальный объем файла 2 048 Кбайт');
								 }
									
								 
								 
                            }
    
								
								
								var file = ui.files[0];

								if( !FileAPI.support.transform ) {
									alert('Your browser does not support Flash :(');
								}
								else if( file ){
									$('#popup').modal({
										closeOnEsc: true,
										closeOnOverlayClick: false,
										onOpen: function (overlay){
											$(overlay).on('click', '.js-upload', function (){
												$.modal().close();
												$('#userpic').fileapi('upload');
											});

											$('.js-img', overlay).cropper({
												file: file,
												bgColor: '#fff',
												maxSize: [$(window).width()-100, $(window).height()-100],
												minSize: [200, 200],
												selection: '90%',
												onSelect: function (coords){
													$('#userpic').fileapi('crop', file, coords);
												}
											});
										}
									}).open();
								}
							},
							onComplete: function(evt,uiEvt){
								
							 var filename = uiEvt.file.name;
								
                              var oldImage =  $('.main_content .profile_face .userpic img.avatar_prev').attr('id');
							  		
								oldImage ='/photos/avatars/'+oldImage+'.';
								
								 var newExt = filename.substr( (filename.lastIndexOf('.') +1) );
								
								$('header .header-content .profile_info img#avatar').attr('src',oldImage+newExt+'?'+Math.random() );
								
								
							}
						});
					}

					
					
					
					
					
		jQuery(function ($){
			var $blind = $('.splash__blind');

			$('.splash')
				.mouseenter(function (){
					$('.splash__blind', this)
						.animate({ top: -10 }, 'fast', 'easeInQuad')
						.animate({ top: 0 }, 'slow', 'easeOutBounce')
					;
				})
				.click(function (){
					if( !FileAPI.support.media ){
						$blind.animate({ top: -$(this).height() }, 'slow', 'easeOutQuart');
					}

					FileAPI.Camera.publish($('.splash__cam'), function (err, cam){
						if( err ){
							alert("Unfortunately, your browser does not support webcam.");
						} else {
							$('.splash').off();
							$blind.animate({ top: -$(this).height() }, 'slow', 'easeOutQuart');
						}
					});
				})
			;


		  uploadAva();
		
		});
		
		$('#userpic input[type="file"]').click(function(){   $('.main_content .profile_face .userpic .cover').show();   });
	
});