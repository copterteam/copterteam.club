<?
include_once("admin/func.php");
include_once("admin/pdo_connect.php");

$act=$_POST['act'];


if($act=='follow_user'){
	
	$Rx=$_POST['Rx'];
		$Tx=$_POST['Tx'];
		   $Rx_name=$_POST['Rx_name'];


   $ins= $link->prepare("INSERT INTO followers(Rx,Tx,add_time) VALUES (?,?,?)");

   if( $ins ->execute(array($Rx,$Tx,time()))  ){
	   

    $ins2= $link->prepare("INSERT INTO notifications(Rx,Tx,Tx_name,line_type,time_point,status) VALUES (?,?,?,?,?,?)");

    $ins2 ->execute(array($Tx,$Rx,$Rx_name,'follow',time(),'new'));
	   
	   
    print('ok');

  }
}

?>