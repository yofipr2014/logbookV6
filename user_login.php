<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './user_login_func.php';

$artv_login = art_request("btn_login", "");
$artv_username  = art_request("username", "");
$artv_password = art_request("password", "");
$message = "";
$artv_userlevel = "";

if ($artv_login  != ""){
    if (($artv_username == "") || ($artv_password == "")){
        $message = MSG_INVALID_USERPW;
    }

    if ($message == ""){
        $userlevel = art_check_userpw($artv_username, $artv_password);
        if ($userlevel == -1000){
            $message = MSG_LOGIN_FAIL;
        } else {
            $redirect_url = 'logbook.php';
            header("location: " . $redirect_url);
		    }
		}
} else {
    if (art_check_session('art_page_level')){
        $message = MSG_NO_PERMISSION;
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sitem Informasi Log Book Dokter</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="./images/favicon.ico" type="image/x-icon">
<link href="./css/template.css" rel="stylesheet" type="text/css">
<link href="./css/globalcss.css" rel="stylesheet" type="text/css">
<!--<link href="./css/style.css" rel="stylesheet" type="text/css">-->
<link href="./css/user_login_th.css" rel="stylesheet" type="text/css">
</head>

<body class="fixed-left login-page">
 <div id="webSuggest" style="border : 1px solid #000; background : #fff; display : block; float : left;z-index:100;position:absolute;top: 1px; left: 1px"></div>
<!--<script language="JavaScript1.2">mmLoadMenus();</script>-->
	<div id="pagehandler">
		<div class="navpost">
			<div id="navigate">
				<ul>
					<!--<li class="first"><a href="index.php">Home</a></li>
					<li class="first"><a href="index.php">Masuk</a></li>-->
				</ul>
			</div>
		</div>
		<div class="rbox01"></div>
		<div class="rbox02">
		<div class="container">
		  <div class="full-content-center">
        
			<div class="login-wrap">
                <!--<div class="text-center logo-login"></div>-->
                <div id="user_login_th">
                
				<br />
<form name="art_form" id="art_form" method="post" action="user_login.php"  style="margin: 0px; padding: 0px;">
    <table cellpadding="0" cellspacing="0" border="0"  width="400" align="center" >
           
        <tr>
            <td class="formHeaderBGLeft" nowrap >&nbsp;</td>
            <td class="formHeaderBG"><span class="formHeaderText">User Login</span>&nbsp;</td>
            <td class="formHeaderBGRight" nowrap >&nbsp;</td>
        </tr>
        <tr>
            <td class="formColumnBGLeft" align="left">&nbsp;</td>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="formBody" >
                 <tr>
                    <!--<td>&nbsp</td>
                    <td>&nbsp</td>-->
                    <td align="center" colspan="3"><img src="./images/logo.png"></td>
                </tr> 
<?php

    if ($message != "" ){
        print "<tr>\n";
        print "<td class=\"formColumnCaption\">Message</td>\n";
        print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
        print "<td class=\"formColumnData\" align=\"left\">\n";
        print "<label class=\"errMsg\" >" . $message . "</label>\n";
        print "</td>\n";
        print "</tr>\n";
    }
    $value = $artv_username;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_username = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\"><b>Username<b></td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"username\" name=\"username\" type=\"text\" value=\"" . $value . "\"  size=\"45\" maxlength=\"35\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_password;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_password = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\"><b>Password<b></td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"password\" name=\"password\" type=\"password\" value=\"" . $value . "\"  size=\"45\" maxlength=\"35\" >\n";
    print "</td>\n";
    print "</tr>\n";
?>
	                  <tr>
	                      <td class="formColumnCaption"></td>
	                      <td width="3" class="formColumnData">&nbsp;</td>
	                      <td class="formColumnData" align="left"><br/>
	                          <input name="btn_login" id="btn_login" type="submit" value="Login" class="button" />
	                          <input name="btn_cancel"  id="btn_cancel" type="reset" value="Cancel" class="button" />
	                          <br/><br/>
	                      </td>
	                  </tr>
                </table>
            </td>
            <td class="formColumnBGRight">&nbsp;</td>
        </tr>
        <tr>
            <td class="formFooterLeft" nowrap >&nbsp;</td>
            <td class="formFooter" align="center" valign="middle">&nbsp;</td>
            <td class="formFooterRight" nowrap >&nbsp;</td>
        </tr>
    </table>
</form>

</div>				
					
			 </div>  
		   </div>
        </div>
        </div>
		<div class="rbox03">&nbsp;</div>
		<div id="footer">
			PMN RS. Mata Cicendo Bandung 2016.<br />
			Tim Remunerasi
		</div>
	</div>
    
</body>
</html>
<?php art_db_connection_close(); ?>
