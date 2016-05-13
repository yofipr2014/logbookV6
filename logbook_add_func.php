<?php
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function art_form_insertdata_display($form, $message){
    $artv_id = art_request("id", "");
    $artv_no_rm = art_request("no_rm", "");
    $artv_tgl_year = art_request("tgl_year", "");
    $artv_tgl_month = art_request("tgl_month", "");
    $artv_tgl_day = art_request("tgl_day", "");
    if (($artv_tgl_year != "")
     && ($artv_tgl_month != "")
     && ($artv_tgl_day != "")) {
        $artv_tgl = $artv_tgl_year."-".$artv_tgl_month."-".$artv_tgl_day;
    } else {
        $artv_tgl = "";
    }
    $artv_id_pel = art_request("id_pel", "");
    $artv_ket = art_request("ket", "");
    $artv_uid = art_request("uid", "");
    $disabled = "";
    art_set_session('art_form_loaded', 0);
    $check = "";
    $gridtitle = "Logbook Add";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"900\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_logbook_add_th\">\n";
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
    art_sitemenu_display("logbook_add", "logbook_add_th");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";
    $value = $artv_id;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    print "<input id=\"id\" name=\"id\" type=\"hidden\" value=\"" . $value . "\" >\n";




    $value = $artv_uid;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    print "<input id=\"uid\" name=\"uid\" type=\"hidden\" value=\"" . $value . "\" >\n";
    print "<div id=\"logbook_add_th\">";
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

    $value = $artv_no_rm;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_no_rm = $value;
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_no_rm = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">NO. RM*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<input class=\"textbox\" id=\"no_rm\" name=\"no_rm\" type=\"text\" value=\"" . $value . "\"  size=\"10\" maxlength=\"10\" >\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_tgl;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_tgl = $value;
    }
    $v_year = "";
    $v_month = "";
    $v_day = "";
    $v_hour = "";
    $v_minute = "";
    $v_second = "";
    if ($value != "") {
      $datevalue = getdate(strtotime($value));
      if (is_array($datevalue)) {
        $v_year = $datevalue['year'];
        $v_month = str_pad($datevalue['mon'], 2, '0', STR_PAD_LEFT);
        $v_day = str_pad($datevalue['mday'], 2, '0', STR_PAD_LEFT);
        $v_hour = str_pad($datevalue['hours'], 2, '0', STR_PAD_LEFT);
        $v_minute = str_pad($datevalue['minutes'], 2, '0', STR_PAD_LEFT);
        $v_second = str_pad($datevalue['seconds'], 2, '0', STR_PAD_LEFT);
      }
    }

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">TANGGAL*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>\n";
    print "<td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<select class=\"combobox\" name=\"tgl_day\" id=\"tgl_day\" style=\"width: 50px\">";
    print "<option value=\"\"></option>";
    if ($v_day == "01") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"01\" $selected >01</option>";
    if ($v_day == "02") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"02\" $selected >02</option>";
    if ($v_day == "03") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"03\" $selected >03</option>";
    if ($v_day == "04") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"04\" $selected >04</option>";
    if ($v_day == "05") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"05\" $selected >05</option>";
    if ($v_day == "06") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"06\" $selected >06</option>";
    if ($v_day == "07") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"07\" $selected >07</option>";
    if ($v_day == "08") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"08\" $selected >08</option>";
    if ($v_day == "09") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"09\" $selected >09</option>";
    if ($v_day == "10") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"10\" $selected >10</option>";
    if ($v_day == "11") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"11\" $selected >11</option>";
    if ($v_day == "12") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"12\" $selected >12</option>";
    if ($v_day == "13") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"13\" $selected >13</option>";
    if ($v_day == "14") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"14\" $selected >14</option>";
    if ($v_day == "15") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"15\" $selected >15</option>";
    if ($v_day == "16") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"16\" $selected >16</option>";
    if ($v_day == "17") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"17\" $selected >17</option>";
    if ($v_day == "18") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"18\" $selected >18</option>";
    if ($v_day == "19") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"19\" $selected >19</option>";
    if ($v_day == "20") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"20\" $selected >20</option>";
    if ($v_day == "21") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"21\" $selected >21</option>";
    if ($v_day == "22") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"22\" $selected >22</option>";
    if ($v_day == "23") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"23\" $selected >23</option>";
    if ($v_day == "24") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"24\" $selected >24</option>";
    if ($v_day == "25") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"25\" $selected >25</option>";
    if ($v_day == "26") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"26\" $selected >26</option>";
    if ($v_day == "27") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"27\" $selected >27</option>";
    if ($v_day == "28") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"28\" $selected >28</option>";
    if ($v_day == "29") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"29\" $selected >29</option>";
    if ($v_day == "30") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"30\" $selected >30</option>";
    if ($v_day == "31") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"31\" $selected >31</option>";
    print "</select>&nbsp;";
    print "</td><td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<select class=\"combobox\" name=\"tgl_month\" id=\"tgl_month\" style=\"width: 50px\">";
    print "<option value=\"\"></option>";
    if ($v_month == "01") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"01\" $selected >Jan</option>";
    if ($v_month == "02") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"02\" $selected >Feb</option>";
    if ($v_month == "03") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"03\" $selected >Mar</option>";
    if ($v_month == "04") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"04\" $selected >Apr</option>";
    if ($v_month == "05") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"05\" $selected >May</option>";
    if ($v_month == "06") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"06\" $selected >Jun</option>";
    if ($v_month == "07") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"07\" $selected >Jul</option>";
    if ($v_month == "08") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"08\" $selected >Aug</option>";
    if ($v_month == "09") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"09\" $selected >Sep</option>";
    if ($v_month == "10") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"10\" $selected >Oct</option>";
    if ($v_month == "11") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"11\" $selected >Nov</option>";
    if ($v_month == "12") {$selected = "selected";} else {$selected = "";}
    print "<option value=\"12\" $selected >Dec</option>";
    print "</select>&nbsp;";
    print "</td><td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<input class=\"textbox\" name=\"tgl_year\" type=\"text\" value=\"$v_year\" id=\"tgl_year\" size=\"4\"/>";
    print "</td>\n";
    print "<td valign=\"top\" style=\"padding-left:2px\">\n";
    print "<input type=\"image\" name=\"tgl_btn\" id=\"tgl_btn\" src=\"components/calendar/basicgray/images/img_calendar.gif\" onclick =\"displayCalendarSelectBox('tgl_year','tgl_month','tgl_day',false,false,this); return false;\"style=\"border-width:0px;cursor: hand\" />";
    print "</td></tr></table>\n";
    print "</td>\n";
    print "</tr>\n";
    $value = $artv_id_pel;
    if (($value == "") || ($value == null)) {
        $value = "";
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_id_pel = $value;
    }

    $control_name = "id_pel";
    $control_caption = "PELAYANAN";
    $sql = " SELECT * FROM `pelayanan`";
    $mastervalue = "";
    $keyfield = "";
    $css = '';
    $disabled = "true";
    $fieldvalue = "id_pel";
    $fieldlabel = "nm_pelayanan";
    $url = "logbook_add_ajax.php?rv=1";
    $ismaster = false;
            print "<tr>\n";
        print "<td class=\"formColumnCaption\">PELAYANAN*</td>\n";
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
    $value = $artv_ket;
    if (($value == "") || ($value == null)) {
        $value = "";
        $artv_ket = $value;
    }
    $artsv_postback = art_request("artsys_postback", "");
    if (($artsv_postback == null) || ($artsv_postback == "")){
        $value = "";
        $artv_ket = $value;
    }
    $value = htmlspecialchars($value);

    print "<tr>\n";
    print "<td class=\"formColumnCaption\">KETERANGAN*</td>\n";
    print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
    print "<textarea class=\"textarea\" id=\"ket\" name=\"ket\"  cols=\"50\" rows=\"5\">" . $value . "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "	              <tr>\n";
    print "	                  <td class=\"formColumnCaption\"></td>\n";
    print "	                  <td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "	                  <td class=\"formColumnData\" align=\"left\"></br>\n";
    print "		                      <input name=\"btn_save\" id=\"btn_save\" type=\"submit\" value=\"" . CAP_BUTTON_SAVE . "\" class=\"button\" >\n";
    $urldatapage = "href='" . "./logbook.php" . "'";
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
    $artv_id = art_request("id", "");
    $artv_no_rm = art_request("no_rm", "");
    $artv_tgl_year = art_request("tgl_year", "");
    $artv_tgl_month = art_request("tgl_month", "");
    $artv_tgl_day = art_request("tgl_day", "");
    if (($artv_tgl_year != "")
     && ($artv_tgl_month != "")
     && ($artv_tgl_day != "")) {
        $artv_tgl = $artv_tgl_year."-".$artv_tgl_month."-".$artv_tgl_day;
    } else {
        $artv_tgl = "";
    }
    $artv_id_pel = art_request("id_pel", "");
    $artv_ket = art_request("ket", "");
    $artv_uid = art_request("uid", "");
    $err_require = "";
    if ($artv_no_rm == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_tgl == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_id_pel == "") {
	      $err_require = MSG_REQUIRE_FIELD;
    }
    if ($artv_ket == "") {
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
        $sql = "INSERT INTO `logbook`";
        $sql .= " (";
        $sql .= "logbook.id"; 
        $sql .= ",logbook.no_rm"; 
        $sql .= ",logbook.tgl"; 
        $sql .= ",logbook.id_pel"; 
        $sql .= ",logbook.ket"; 
        $sql .= ",logbook.uid"; 
        $sql .= ") ";
        $sql .= " VALUES "; 
        $sql .= " (";
        $sql .=  art_quote_intval($artv_id); 
        $sql .= " , " .  art_quote_strval($artv_no_rm); 
        $sql .= " , " .  art_quote_dateval($artv_tgl); 
        $sql .= " , " .  art_quote_intval($artv_id_pel); 
        $sql .= " , " .  art_quote_strval($artv_ket); 
        $sql .= " , " .  art_quote_strval($_SESSION['art_user_name']); 
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
