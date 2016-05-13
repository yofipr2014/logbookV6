<?php
function art_check_userpw($username, $password) {
$username = art_escape_sqlval($username);
if ($username == 'admin'){
    $password = art_escape_sqlval($password);
}
else{
    $password = md5(art_escape_sqlval($password));   
}

	  $sql = " select `userlevel`, `password`,`nm_dokter`  from `useraccounts` ";
	  $sql .= " where `username` = '" . strtolower(trim($username)) . "'";
	  $query = mysql_query($sql);	
	  if(!$query || (mysql_num_rows($query) < 1)) {
        return -1000;
    }
    $row = mysql_fetch_array($query);
    $dbpassword = stripslashes(art_rowdata($row, 1));
    $dbuserlevel = stripslashes(art_rowdata($row, 0));
    $nm_dokter = stripslashes(art_rowdata($row, 2));
    $password = stripslashes($password);
    if ($password == $dbpassword) {
        art_set_userinfo($username, $dbuserlevel,$nm_dokter);
        return $dbuserlevel;
    } else {
        return -1000;
    }
  }

function art_set_userinfo($username, $userlevel,$nm_dokter) {
	  art_set_session('art_user_name', $username);
	  art_set_session('art_user_level', $userlevel);
      art_set_session('art_nm_dokter',$nm_dokter);
}

function art_check_permission($pagelevel, $pageurl) {
    if ($pagelevel <= art_session('art_user_level', -1)) {
        return true;
    } else {
        art_set_session('art_page_level', $pagelevel);
	      header("location: index.php");
        return false;
    }
}
?>
