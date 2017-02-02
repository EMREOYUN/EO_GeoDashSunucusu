<?php
//error_reporting(0);
include "connection.php";
if($_POST["levelID"]){
	$levelID =  htmlspecialchars($_POST["levelID"],ENT_QUOTES);
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$query = "SELECT * FROM reports WHERE levelID = :levelID AND hostname = :hostname";
	$query = $db->prepare($query);
	$query->execute([':levelID' => $levelID, ':hostname' => $ip]);

	if($query->rowCount() == 0){
		$query = $db->prepare("INSERT INTO reports (levelID, hostname) VALUES (:levelID, :hostname)");	
		$query->execute([':levelID' => $levelID, ':hostname' => $ip]);
		echo $db->lastInsertId();
	}else{
		echo -1;
	}	
}
?>