<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './logbook_func.php';
require_once "./user_login_func.php";
art_check_permission(1, "./logbook.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Logbook</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="./images/favicon.ico" type="image/x-icon">
<link href="./css/globalcss.css" rel="stylesheet" type="text/css">
<link href="./css/logbook_th.css" rel="stylesheet" type="text/css">
<link href="./css/loadingmsg.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="./js/prototype.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_ajax.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_msg.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_general.js"></script>
</head>
<body>
<?php
if (($artsv_postback == "1") && ($artsv_act_search != "")){
    art_set_session('sql', "");
    $quick_search = $artsv_quick_search;
    if ($quick_search != art_session("logbook_quick_search", "")){
        art_set_session("logbook_quick_search", $quick_search);
        art_set_session("logbook_page", "1");
    }
}
?>
<iframe id="ifrmSearch" frameborder="0" style="position: absolute; filter: progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0);
display: none; width: 100%; height: 100%; z-index: 999;" scrolling="no"></iframe>
<div id="mainAreaLoading" style="display: None;">
<?php
art_waitingmsg_display();
?>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td>
            <form name="art_form" id="art_form" method="post" action="logbook.php" style="margin: 0px; padding: 0px;">
            <div id="art_ajaxpanel1">
                <?php art_groupdatagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category);?>
            </div>
            </form>
        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
</table>

</body>
</html>
<?php	art_db_connection_close(); ?>
