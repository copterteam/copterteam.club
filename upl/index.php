<?

error_reporting(E_ALL | E_STRICT);

require('UploadHandler.php');


if( $_COOKIE['user_name']  ) {
	
$mail_string=$_COOKIE['user_name'];

$mail_string = str_replace('@',':', $mail_string);


$upload_handler = new UploadHandler(array(
	'custom_user_dir' => $mail_string,
	'accept_file_types' => '/\.(gif|jpe?g|png)$/i'
));


}

?>