<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './Report_func.php';
require_once "./user_login_func.php";
art_check_permission(1, "./Report.php");

header("Content-Type: text/html; charset=iso-8859-1");
art_datagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category);
art_db_connection_close();
?>
