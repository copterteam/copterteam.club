<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");


$act = $_GET['act'];


if($act=='get_region'){
	
	$country = $_GET['country'];
	
	$country_query = $link->query("SELECT country_id,name FROM country WHERE name='$country'");

	$country_array = $country_query->fetch();
	
	
	$region_query = $link->query("SELECT region_id,name,status FROM region WHERE country_id='$country_array[country_id]'  ORDER BY name ");

    $region_num = $region_query->rowCount();

	$region_array = $region_query->fetchAll();
	
	
	$jsonanswer='({"region_num":"'.$region_num.'","item":[';
	
	foreach($region_array as $array){
		 

$resarray=array(

"name"=>$array[name],
"region_id"=>$array[region_id],
"status"=>$array[status]

);



$jsonanswer.=json_encode($resarray).",";

		 

}
	
	
if($fsr>0){$jsonanswer=substr($jsonanswer,0,-1);}



$jsonanswer.=']})';


	
	
	
	
	 echo $_GET['callback'].$jsonanswer; 
		  
	  
	  
	  
	
}



if($act=='get_city'){
	
	$region_id = $_GET['region_id'];
		
	
	$city_query = $link->query("SELECT city_id,name,status FROM city WHERE region_id='$region_id'  ORDER BY name ");

    $city_num = $city_query->rowCount();

	$city_array = $city_query->fetchAll();
	
	
	$jsonanswer='({"city_num":"'.$city_num.'","item":[';
	
	foreach($city_array as $array){
		 

$resarray=array(

"name"=>$array[name],
"city_id"=>$array[city_id],
"status"=>$array[status]
);



$jsonanswer.=json_encode($resarray).",";

		 

}
	
	
if($fsr>0){$jsonanswer=substr($jsonanswer,0,-1);}



$jsonanswer.=']})';


	
	
	
	
	 echo $_GET['callback'].$jsonanswer; 
		  
	  
	  
	  
	
}

?>