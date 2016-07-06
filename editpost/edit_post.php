<?
include_once("../admin/func.php");
include_once("../admin/pdo_connect.php");


function deleteImages ($usermail,$link){
	
	
	
$imgquery = $link->query("SELECT file_id,file_name,file_path,post_id,src,post_time,width,height,filesize,usermail FROM imgbase WHERE usermail='$usermail' AND post_id='0' ");

$imgsr = $imgquery->rowCount();

$imgarray = $imgquery->fetchAll();

   $del= $link->prepare("DELETE FROM imgbase WHERE file_id=? AND usermail=?");


foreach( $imgarray as $num=>$imginfo){

   unlink($imginfo[file_path].$imginfo[file_name]);
   unlink($imginfo[file_path].'/thumbnail/'.$imginfo[file_name]);

   $del ->execute(array($imginfo[file_id],$imginfo[usermail]));

}
	
}

function refreshImages ($postid,$usermail,$link){
	
	
	
$imgquery = $link->query("SELECT file_id,file_name,file_path,post_id,src,post_time,width,height,filesize,usermail FROM imgbase WHERE usermail='$usermail' AND post_id='$postid' ORDER BY src");

$imgsr = $imgquery->rowCount();

$imgarray = $imgquery->fetchAll();

    $ins = $link->prepare("INSERT INTO imgbase ( file_name,file_path,width,height,filesize,post_time,usermail) VALUES (?,?,?,?,?,?,?)");

	$mail_string = str_replace('@',':', $usermail);

	$div_content = '';
	
foreach( $imgarray as $num=>$imginfo){
   
   $charnum = strlen($imginfo[post_id]) + 1;
   
   $new_name = substr($imginfo[file_name],$charnum);
   
   $abs_path = $_SERVER['DOCUMENT_ROOT'].$imginfo[file_path];
   $abs_path2 = str_replace("/upl/img/","/upl/new/".$mail_string."/", $abs_path);
   
   copy($abs_path.$imginfo[file_name],$abs_path2.$new_name);
   copy($abs_path.'/thumbnail/'.$imginfo[file_name],$abs_path2.'thumbnail/'.$new_name);
       
   $ins->execute(array( $new_name,$abs_path2,$imginfo[width],$imginfo[height],$imginfo[filesize],$imginfo[post_time],$imginfo[usermail]));
   
   
   $div_content .='
   <span class="thumb_item">
   <img src="'.$imginfo[file_path].'thumbnail/'.$imginfo[file_name].'" alt="'.$imginfo[src].'" title="'.$new_name.'">
   <strong>'.$imginfo[src].'</strong>
   <div class="coat" title="Прикрепить изображение '.$imginfo[src].'"></div>
   </span>
   ';
}


print($div_content);	
}


if($welcome){
	
	
$postid = substr($_SERVER['REQUEST_URI'],10);



$bquery = $link->query("SELECT post_id,user_id,post_time,header,body,mod_time,rating,post_tags FROM postbase WHERE post_id='$postid' ");

$bsr = $bquery->rowCount();

$barray = $bquery->fetch();



$uquery = $link->query("SELECT clid,usercity,countryname,birthdate,mobile,username,surname,usermail,userpass,usernick,avafile,modified FROM club_users WHERE clid='$barray[user_id]' ");

$usr = $uquery->rowCount();

$uarray = $uquery->fetch();


if( ( $_COOKIE['user_name'] == $uarray[usermail] ) AND ( $_COOKIE['session'] == $uarray[userpass] )  ){  $home = true ; }


if( ($bsr > 0) AND ($home) ) {
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">


<title>Редактировать запись в блоге пользователя | COPTERTEAM.club </title>


<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/_css/jquery.datetimepicker.css" type="text/css" media="screen">


<link rel="stylesheet" href="/_css/bootstrap.css">
<link rel="stylesheet" href="/_css/blueimp-gallery.css">
<link rel="stylesheet" href="/_css/jquery.fileupload.css">
<link rel="stylesheet" href="/_css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" href="/_css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="/_css/jquery.fileupload-ui-noscript.css"></noscript>

<link rel="stylesheet" href="/_css/main.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="/_css/poster.css" type="text/css" media="screen">
	
		
</head>
<body>
<form id="attachment">
<label>Рекомендуем добавлять подписи к изображениям. Это значительно повысит позиции ваших материалов в поиске и добавит им заинтересованных читателей.</label>
<input type="text" name="alt" placeholder="Укажите подпись к картинке">
<input type="hidden" name="src">
<button type="submit">OK</button>
</form>


<?include("../header.php");?>


<div class="main_content">

<form action="add_post" method="post" id="upd_post" class="poster" onsubmit="return false;">
 <input type="hidden" name="mailval" value="<?echo($parray[usermail]);?>" />
  <input type="hidden" name="nickval" value="<?echo($parray[usernick]);?>" />
   <input type="hidden" name="idval" value="<?echo($parray[clid]);?>" />
      <input type="hidden" name="postid" value="<?echo($barray[post_id]);?>" />

   
<input type="text" name="post_header" placeholder="Основной заголовок записи" value="<?echo($barray[header]);?>"/>

<div class="thumbnails">

<?  deleteImages($parray[usermail],$link);  refreshImages($postid,$parray[usermail],$link);  ?>

</div>

<div class="tools">
<label class="long" for="post_body">Текст записи:</label>

<label class="hyper_link">Добавить ссылку</label>

<label class="attachment">Загрузить изображения</label>


<div id="link_tab">
<label>Для добавления ссылки укажите URL адрес ресурса, на который она будет вести, а также текст внутри ссылки для отображения на сайте.</label>
<input type="text" name="link_url" placeholder="http://">
<input type="text" name="link_text" placeholder="Текст ссылки">

<button type="button">OK</button>
<i class="glyphicon glyphicon-remove"></i>
</div>

</div>

<textarea name="post_body"><?echo($barray[body]);?></textarea>

<div class="tools under">
<label class="tags" for="post_tags">Изменить ключевые слова</label><br>
<input type="text" name="post_tags" id="tags" placeholder="Ключевые слова через запятую" value="<?echo($barray[post_tags]);?>"/>
</div>

<label for="post_body">Дата и время:</label>
<input type="text" name="date_time" id="date_time" value="<?echo(date('d.m.Y H:i',$barray[post_time]));?>" readonly />

	<div class="clearfix"></div>

<button type="button" id="submit_form">Сохранить</button>

</form>


<div class="img_uploader">



<div class="container">

    <form id="fileupload" action="../upl/" method="POST" enctype="multipart/form-data">
         <div class="row fileupload-buttonbar" >
            <div class="col-lg-7">
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Добавить файлы</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Загрузить</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Отменить</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Удалить</span>
                </button>
                <input type="checkbox" class="toggle">
                <span class="fileupload-process"></span>
            </div>
            <div class="col-lg-5 fileupload-progress fade">
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>

	
</div>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>


<script src="/_js/jquery-1.11.3.min.js"></script>
<script src="/_js/jquery.color-2.1.2.min.js"></script>
<script src="/_js/jquery.validate.min.js"></script>
<script src="/_js/jquery.datetimepicker.min.js"></script>

<script src="/_js/upl/vendor/jquery.ui.widget.js"></script>


<script src="/_js/upl/tmpl.min.js"></script>
<script src="/_js/upl/load-image.all.min.js"></script>
<script src="/_js/upl/canvas-to-blob.min.js"></script>
<script src="/_js/upl/jquery.blueimp-gallery.min.js"></script>
<script src="/_js/upl/jquery.iframe-transport.js"></script>
<script src="/_js/upl/jquery.fileupload.js"></script>
<script src="/_js/upl/jquery.fileupload-process.js"></script>
<script src="/_js/upl/jquery.fileupload-image.js"></script>
<script src="/_js/upl/jquery.fileupload-audio.js"></script>
<script src="/_js/upl/jquery.fileupload-video.js"></script>
<script src="/_js/upl/jquery.fileupload-validate.js"></script>
<script src="/_js/upl/jquery.fileupload-ui.js"></script>
<script src="/_js/upl/main_edit.js"></script>


		<script src="/_js/main.js"></script>
		<script src="/_js/editor.js"></script>
		
		
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="image">
            <span class="preview"></span>
        </td>
        <td class="filename">
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td class="filesize">
            <p class="size">Загрузка...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td class="actions">
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Загрузить</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Отменить</span>
                </button>
            {% } %}
        </td>
		<td class="select"></td>
    </tr>
{% } %}
</script>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td class="image">
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td class="filename">
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td class="filesize">
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td class="actions">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Удалить</span>
                </button>
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Отменить</span>
                </button>
            {% } %}
        </td>

		<td class="select">   {% if (file.deleteUrl) { %}   <input type="checkbox" name="delete" value="1" class="toggle"> {% } %}</td>

    </tr>
{% } %}
</script>



  <div class="upload_tools">
  
    <div class="desc">
	Для загрузки фотографий выберите необходимые файлы на диске, нажав кнопку "Добавить файлы". После появления изображений в списке загрузите их на сервер, нажав кнопку "Загрузить".  Загруженные изображения можно просмотреть в галлерее. При необходимости файл удаляется с сервера кнопкой "Удалить".  После загрузки всех фотографий следует вернуться к добавлению новой записи, нажав кнопку "Сохранить".
	</div>
   
            <button class="btn btn-primary" id="save_files">
                    <i class="glyphicon glyphicon-check"></i>
                    <span>Сохранить</span>
                </button>
            
          
                <button class="btn btn-warning"  id="cancel_upload">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Отменить</span>
                </button>
   
	<div class="clearfix"></div>

  </div>

  </div>

</div>


<?  include("../footer.php"); ?>
	 
</body>
</html>
<?
}else{ header('Location: /users/'.$parray[usernick]);  exit(); }
}else{ header('Location: /');  exit(); }?>