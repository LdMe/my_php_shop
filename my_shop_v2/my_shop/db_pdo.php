<?php

define("ERROR_LOG_FILE","error.log");

function connect_db($host,$username,$passwd,$port,$db)
{
	try {
		$db = new PDO("mysql:host=$host;port=$port;dbname=$db",$username,$passwd);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "connection succesful!\n";
		return $db;
	} catch (Exception $e) {
		//echo "PDO ERROR: <$e> storage in ". ERROR_LOG_FILE . "\n";
		error_log($e,3,ERROR_LOG_FILE);
		return null;
	}
}
//---------TEST-(comment after check)---------------
/*
$db=connect_db("localhost","ussr","123",3306,"gecko");
if($db){
	$sth=$db->query("SELECT * from users;");
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	print_r($result);
}
else{
	echo "There was an error connecting to the db\n";
}
*/