<?php // Rememeber to change the username,password and database name to acutal values
define('DB_HOST','db.schtg.com');
define('DB_USER','schtgcom_d06372');
define('DB_PASS','4q80ojrnk1');
define('DB_NAME','schtgcom_d06372');

//Create Connection
$link = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//Check COnnection
if($link->connect_error){ //if not Connection
die('Connection Failed'.$link->connect_error);//kills the Connection OR terminate execution
}
?>
