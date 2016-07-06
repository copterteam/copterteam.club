<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");


$act = $_POST['action'];


function azzrael_resize( $imgname, $outfile ){
    
    $neww = 200;
    $newh = 200; 
    $quality = 85;
    
    $size = getimagesize( $imgname );

    switch($size["mime"]){
    
        case "image/jpeg":
            $im = imagecreatefromjpeg($imgname); 
        break;
        
        case "image/gif":
            $im = imagecreatefromgif($imgname); 
        break;
        
        case "image/png":
            $im = imagecreatefrompng($imgname); 
        break;
        
        default:
            $im=false;
        break;
    }
    
    if( !$im ) return false; 
    
    $width_orig = $size[0];
    $height_orig = $size[1];

    $ratio_orig = $width_orig/$height_orig;
   
    if ( $neww/$newh > $ratio_orig ) {
       $new_height = $neww/$ratio_orig;
       $new_width = $neww;
    } else {
       $new_width = $newh*$ratio_orig;
       $new_height = $newh;
    }
   
      $ky = 0.5;
    $kx = 0.5;
    $x_mid = $new_width*$kx;  
    $y_mid = $new_height*$ky;
   
    $process    = imagecreatetruecolor(round($new_width), round($new_height));
    $thumb      = imagecreatetruecolor($neww, $newh);
    
    imagecopyresampled($process, $im, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($neww*$kx)), ($y_mid-($newh*$ky)), $neww, $newh, $neww, $newh);
    
    imagejpeg($thumb, $outfile, $quality);
    
    imagedestroy($process);
    imagedestroy($im);
    
    return true;
}




if($act == 'upload'){
	
	$usermail = $_POST['usermail'];
	
		
$query = $link->query("SELECT clid,username,usermail,actcode,active,avafile FROM club_users WHERE usermail='$usermail' ");

$sr = $query->rowCount();

$array = $query->fetch();
	
	
	if($_FILES['filedata']['tmp_name']<>""){
		
	  $filename = $array[avafile];
	  
	  $ext = get_ext($_FILES['filedata']['name']);
	  
	  $imgname= $array[clid].".".$ext;
	  $imgpath="photos/avatars/".$imgname;
	  $oldpath="photos/avatars/".$filename;
		
	if( $array[avafile] !='' ){ unlink($oldpath); }
			
			 if(azzrael_resize($_FILES['filedata']['tmp_name'],$imgpath)  ){  
			 
			 
			 $upd= $link->prepare("UPDATE club_users SET avafile=? WHERE usermail=? ");

             if( $upd ->execute(array($imgname,$usermail)) )  { print("OK"); }
            
			}
			
		
		
	}
	
		
	
}


?>