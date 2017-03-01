<?



function updateIndexmap(){
	
	 $xml2 = new DomDocument('1.0','utf-8');
	
	
	$sitemapindex = $xml2->appendChild($xml2->createElement('sitemapindex'));
	
	$attr2 = $xml2->createAttribute('xmlns');
	
	$attr2->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	
	$sitemapindex->appendChild($attr2);
	
	  	$sitemap = $sitemapindex->appendChild($xml2->createElement('sitemap'));

		  $loc = $sitemap->appendChild($xml2->createElement('loc'));
		  $lastmod = $sitemap->appendChild($xml2->createElement('lastmod'));
	
	
		  $loc->appendChild($xml2->createTextNode('http://www.copterteam.ru/basemap.xml'));
		     $lastmod->appendChild($xml2->createTextNode(date( 'Y-m-d',time() )));
	
	
	    $sitemap = $sitemapindex->appendChild($xml2->createElement('sitemap'));

		  $loc = $sitemap->appendChild($xml2->createElement('loc'));
		  $lastmod = $sitemap->appendChild($xml2->createElement('lastmod'));
	
	
		  $loc->appendChild($xml2->createTextNode('http://www.copterteam.ru/extramap.xml'));
		     $lastmod->appendChild($xml2->createTextNode(date( 'Y-m-d',time() )));
			 
			 
		 $sitemap = $sitemapindex->appendChild($xml2->createElement('sitemap'));

		  $loc = $sitemap->appendChild($xml2->createElement('loc'));
		  $lastmod = $sitemap->appendChild($xml2->createElement('lastmod'));
	
	
		  $loc->appendChild($xml2->createTextNode('http://www.copterteam.ru/imagemap.xml'));
		     $lastmod->appendChild($xml2->createTextNode(date( 'Y-m-d',time() )));
			 
	
	$xml2->formatOutput = true; #-> устанавливаем выходной формат документа в true
     $xml2->save($_SERVER['DOCUMENT_ROOT'].'/sitemap.xml');   #-> сохраняем файл
	
}



function updateImagemap($link){
	
   $query="SELECT file_id,file_name,file_path,post_id,src,post_time,width,height,filesize,usermail FROM imgbase WHERE post_id<>'0' ORDER BY post_id";
   $result=$link->query($query);
   $array=$result->fetchAll();
	
	
	$xml = new DomDocument('1.0','utf-8');
	
	
	$urlset = $xml->appendChild($xml->createElement('urlset'));
	
	$attr = $xml->createAttribute('xmlns');
		$attr2 = $xml->createAttribute('xmlns:image');

	$attr->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	    $attr2->value = 'http://www.google.com/schemas/sitemap-image/1.1';
	
	$urlset->appendChild($attr);
	   $urlset->appendChild($attr2);
	   
	$last_post = 0;
	
	foreach( $array as $image){
		
		if( $last_post != $image[post_id] ){
			
		$url = $urlset->appendChild($xml->createElement('url'));
          
		   $loc = $url->appendChild($xml->createElement('loc'));
		   
		     $loc->appendChild($xml->createTextNode('http://www.copterteam.ru/post/'.$image[post_id]));
		 
		 $last_post = $image[post_id];
		
		}
		  $img = $url->appendChild($xml->createElement('image:image'));
  		  $imgloc = $img->appendChild($xml->createElement('image:loc'));
		 
		  		       $imgloc->appendChild($xml->createTextNode('http://www.copterteam.ru'.$image[file_path].$image[file_name]));

						   
	}
	
	
	
	
	$xml->formatOutput = true; #-> устанавливаем выходной формат документа в true
     $xml->save($_SERVER['DOCUMENT_ROOT'].'/imagemap.xml');   #-> сохраняем файл
	
	
	updateIndexmap();
		
}



function updateSitemap($link){
	
    $user_query="SELECT clid,usernick,avafile,modified FROM club_users WHERE active='1' ";
    $user_result = $link -> query($user_query);
    $user_array=$user_result->fetchAll();
	
	$post_query="SELECT post_id,user_id,post_time,header,body,mod_time,rating,post_tags FROM postbase WHERE user_id=? ";
    $post_result = $link -> prepare($post_query);
	
	
	$xml = new DomDocument('1.0','utf-8');
	
	
	$urlset = $xml->appendChild($xml->createElement('urlset'));
	
	$attr = $xml->createAttribute('xmlns');
	
	$attr->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	
	$urlset->appendChild($attr);
	
	   
			 
	foreach( $user_array as $user){
		

	$post_result->execute(array($user[clid])); 
	$post_array = $post_result->fetchAll();
		
				
		
		$url = $urlset->appendChild($xml->createElement('url'));

		  $loc = $url->appendChild($xml->createElement('loc'));
		  $lastmod = $url->appendChild($xml->createElement('lastmod'));
  		  $changefreq = $url->appendChild($xml->createElement('changefreq'));
  		  $priority = $url->appendChild($xml->createElement('priority'));

		  $loc->appendChild($xml->createTextNode('http://www.copterteam.ru/users/'.$user[usernick]));
		     $lastmod->appendChild($xml->createTextNode(date('Y-m-d',$user[modified])));
		  		  $changefreq->appendChild($xml->createTextNode('weekly'));
		  		       $priority->appendChild($xml->createTextNode('0.7'));

		  
		 foreach( $post_array as $post){ 
		  
		  $url = $urlset->appendChild($xml->createElement('url'));

		  $loc = $url->appendChild($xml->createElement('loc'));
		  $lastmod = $url->appendChild($xml->createElement('lastmod'));
  		  $changefreq = $url->appendChild($xml->createElement('changefreq'));
  		  $priority = $url->appendChild($xml->createElement('priority'));

		  $loc->appendChild($xml->createTextNode('http://www.copterteam.ru/post/'.$post[post_id]));
		    $lastmod->appendChild($xml->createTextNode(date('Y-m-d',$post[mod_time])));
		  		  $changefreq->appendChild($xml->createTextNode('weekly'));
		  		       $priority->appendChild($xml->createTextNode('0.8'));
		 }
					   
	}
	
	
	
	
	$xml->formatOutput = true; #-> устанавливаем выходной формат документа в true
     $xml->save($_SERVER['DOCUMENT_ROOT'].'/extramap.xml');   #-> сохраняем файл
	
	
	updateImagemap($link);
		
}





function urlRedirect($url){

if ( !headers_sent() ) {
header('Location: '.$url);
exit;
}

echo '<script type="text/javascript">window.location.href="'.$url.'";</script>' .
'<noscript><meta http-equiv="refresh" content="0;url='.$url.'" /></noscript>';
exit;
}



function get_id($link)
{
	$linkfile=$link.".txt";
	
	if($file = fopen($linkfile,"r")){ 	
	
	  $curid=fread($file,5);
    
    	fclose($file);
	}
	
     	$newid=$curid+1;
	
	if($file = fopen($linkfile,"w")){ 	
	
	  fwrite($file,$newid);
    
    	fclose($file);
	}	
				
		
	return($curid);	
	
}

function get_ext($filename){
	
	$filename = substr($filename,-5);
	
	$start=strrpos($filename,".")+1;
	
	$ext=substr($filename,$start);
	
	return($ext);	
}

function YearTextArg($year) {
    $m = substr($year,-1,1);
    $l = substr($year,-2,2);
    return $year. ' ' .((($m==1)&&($l!=11))?'год':((($m==2)&&($l!=12)||($m==3)&&($l!=13)||($m==4)&&($l!=14))?'года':'лет'));
}
function get_age($birthdate){
	
	if($birthdate==''){ return('');}else{

	date_default_timezone_set('UTC');
	
	$age = DateTime::createFromFormat('d.m.Y', $birthdate)
     ->diff(new DateTime('now'))
     ->y;


return (', '.YearTextArg($age) );

	}
}

function myscandir($dir)
{
    $list = scandir($dir);
    unset($list[0],$list[1]);
    return array_values($list);
}

// функция очищения папки
function clear_dir($dir)
{
    $list = myscandir($dir);
    
    foreach ($list as $file)
    {
        if (is_dir($dir.$file))
        {
            clear_dir($dir.$file.'/');
            rmdir($dir.$file);
        }
        else
        {
            unlink($dir.$file);
        }
    }
}






function generate_password($number)

  {

    $arr = array('a','b','c','d','e','f',

                 'g','h','i','j','k','l',

                 'm','n','o','p','r','s',

                 't','u','v','x','y','z',

                 'A','B','C','D','E','F',

                 'G','H','I','J','K','L',

                 'M','N','O','P','R','S',

                 'T','U','V','X','Y','Z',

                 '1','2','3','4','5','6',

                 '7','8','9','0');

    
    $pass = "";

    for($i = 0; $i < $number; $i++)

    {

    
      $index = rand(0, count($arr) - 1);

      $pass .= $arr[$index];

    }

    return $pass;

  }




?>