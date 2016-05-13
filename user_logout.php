<?php
if (session_id() == ""){
    session_start();
}
$cookie_params = session_get_cookie_params();
if ((empty($cookie_params["domain"])) && (empty($cookie_params["secure"])) ) {
    setcookie(session_name(), "", time()-3600, $cookie_params["path"]);
} elseif (empty($cookie_params["secure"])) {
    setcookie(session_name(), "", time()-3600, $cookie_params["path"], $cookie_params["domain"]);
} else {
    setcookie(session_name(), "", time()-3600, $cookie_params["path"], $cookie_params["domain"], $cookie_params["secure"]);
}
unset($_COOKIE[session_name()]);
session_destroy();
header("location: index.php");	
?>
