<?php
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function art_form_insertdata_display($form, $message){
    $artv_username = art_request("username", "");
    $artv_password = art_request("password", "");
    $artv_nm_dokter = art_request("nm_dokter", "");
    $artv_ksm = art_request("ksm", "");
    $disabled = "";
    art_set_session('art_form_loaded', 0);
    $check = "";
    $gridtitle = "Add User";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"900\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_defaulttheme\">\n";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"100%\">\n";
    print "    <tr>\n";
    print "    <td colspan=\"3\" valign=\"top\" class=\"mainMenuBG\" >\n";
    print "        <table align=\"right\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    print "            <tr>\n";
    $sessionlevel = art_session('art_user_level', -1);
    $menuprint = false;
    if ($sessionlevel < 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Login\" class=\"mainMenuLink\"><div><p>Login</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    if ($sessionlevel > 0) {
        if ($menuprint) {
          print "                <td>\n";
          print "                    <span class=\"mainMenuText\">\n";
          print "                        &nbsp;|&nbsp;\n";
          print "                    </span>\n";
          print "                </td>\n";
          $menuprint = false;
        }
        print "                <td>\n";
        print "<a href=\"" . "./user_logout.php". "\"" . " title=\"Logout\" class=\"mainMenuLink\"><div><p>Logout</p></div></a>";
        print "                </td>\n";
        $menuprint = true;
    }
    print "            </tr>\n";
    print "        </table>\n";
    print "    </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
    print "<tr>\n";
    print "<td width=\"1\" align=\"left\" valign=\"top\">\n";
    art_sitemenu_display("Add_User", "defaulttheme");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";

    print "<div id=\"defaulttheme\">";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"90%\" >\n";
    print "    <tr>\n";
    print "        <td class=\"formHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "        <td class=\"formHeaderBG\"><span class=\"formHeaderText\">" . $gridtitle . "</span>&nbsp;</td>\n";
    print "        <td class=\"formHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr>\n";
    print "        <td class=\"formColumnBGLeft\" align=\"left\">&nbsp;</td>\n";
    print "        <td>\n";
    print "            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"formBody\" >\n";
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
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_username = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">USERNAME*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"username\" name=\"username\" type=\"text\" value=\"" . $value . "\"  size=\"50\" maxlength=\"50\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_password;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_password = $value;
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_password = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">PASSWORD*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"Left\">\n";
    print "<input class=\"textbox\" id=\"password\" name=\"password\" type=\"password\" value=\"" . $value . "\"  size=\"45\" maxlength=\"35\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_nm_dokter;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_nm_dokter = $value;
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_nm_dokter = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">NAMA*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"nm_dokter\" name=\"nm_dokter\" type=\"text\" value=\"" . $value . "\"  size=\"45\" maxlength=\"45\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_ksm;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_ksm = $value;
    }

    $control_name = "ksm";
    $control_caption = "KSM";
    $sql = "SELECT * FROM `ksm`";
    $mastervalue = "";
    $keyfield = "";
    $css = '';
    $disabled = "true";
    $fieldvalue = "id_ksm";
    $fieldlabel = "nm_ksm";
    $url = "Add_User_ajax.php?rv=1";
    $ismaster = false;
            print "<tr>\n";
        print "<td class=\"formColumnCaption\">KSM*</td>\n";
            print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
            print "<td class=\"formColumnData\" align=\"Left\">\n";
            $multiline = false;
            $size = "1";
            $width = "";
            $firstitem_label = "";
            $firstitem_value = "";
            art_combobox_display($control_name, $control_caption, $sql, $mastervalue, $keyfield, $css, $disabled, $fieldvalue, $fieldlabel, $value, $url, $ismaster, $multiline, $size, $width, $firstitem_label, $firstitem_value);
            print "</td>\n";
            print "</tr>\n";
    print "	              <tr>\n";
    print "	                  <td class=\"formColumnCaption\"></td>\n";
    print "	                  <td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "	                  <td class=\"formColumnData\" align=\"left\"></br>\n";
    print "		                      <input name=\"btn_save\" id=\"btn_save\" type=\"submit\" value=\"" . CAP_BUTTON_SAVE . "\" class=\"button\" >\n";
    $urldatapage = "href='" . "./User.php" . "'";
    print "		                      <input name=\"btn_cancel\" id=\"btn_cancel\" type=\"reset\" value=\"" . CAP_BUTTON_CANCEL . "\" class=\"button\" onClick=\"javascript:window.location." . $urldatapage . " \">\n";
    print "                       <input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "	                  </br></br>\n";
    print "	                  </td>\n";
    print "	              </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "        <td class=\"formColumnBGRight\">&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr>\n";
    print "        <td class=\"formFooterLeft\" nowrap >&nbsp;</td>\n";
    print "        <td class=\"formFooter\" align=\"center\" valign=\"middle\">&nbsp;</td>\n";
    print "        <td class=\"formFooterRight\" nowrap >&nbsp;</td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

}

function art_insert_data() {
    $msg = "";
    $report = "";
    $err_require = "";
    $artv_message = art_request("message", "");
    $artv_username = art_request("username", "");
    $artv_password = md5(art_request("password", ""));
    $artv_nm_dokter = art_request("nm_dokter", "");
    $artv_ksm = art_request("ksm", "");
    $err_require = "";
    if ($artv_username == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_password == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_nm_dokter == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_ksm == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }

    if ($err_require != "") {
	      return $err_require;
    }

    $result = "";
    if ($result != ""){
        return $result;
    }

    if (($result == "") && (art_session('art_form_loaded', 0) != 1)){
        $sql = "INSERT INTO `useraccounts`";
        $sql .= " (";
        $sql .= "useraccounts.username"; 
        $sql .= ",useraccounts.password"; 
        $sql .= ",useraccounts.nm_dokter"; 
        $sql .= ",useraccounts.id_ksm"; 
        $sql .= ") ";
        $sql .= " VALUES "; 
        $sql .= " (";
        $sql .=  art_quote_strval($artv_username); 
        $sql .= " , " .  art_quote_strval($artv_password); 
        $sql .= " , " .  art_quote_strval($artv_nm_dokter); 
        $sql .= " , " .  art_quote_intval($artv_ksm); 
       $sql .= ") ";
    }

    if ($result == "") {
		    $query = mysql_query($sql);
			  if (!$query) {
				    $result .= MSG_INSERT_RECORD_FAIL;
				    $result .= "</br>Error: " . mysql_error();
			  } else {

            $result = "SUCCESS";
            art_set_session('art_form_loaded', 1);
        }
    }
    return $result;
}
?>
