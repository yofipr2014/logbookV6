<?php
$filepath = dirname( __FILE__ );
include $filepath. '/art_config.php';
$dblink = mysql_connect("$config_host","$config_user","$config_password");
if(!$dblink){
    echo "Could not connect to mysql server.";
    exit();
}
$db = mysql_select_db("$config_db");
if(!$db){
    echo "Could not select database.";
    exit();
}
?>
