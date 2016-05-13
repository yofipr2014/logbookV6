<?php

function art_rowdata($row, $index){
    return (isset($row[$index]) && (trim($row[$index]) != "")) ? trim($row[$index]) : "";
}

function art_rowdata_byname($row, $field_names, $field_name){
    $index = array_search($field_name, $field_names);
    if ($index === false){
        return "";
    } else {
        return (isset($row[$index]) && (trim($row[$index]) != "")) ? trim($row[$index]) : "";
    }
}

function art_db_connection_close(){
    global $dblink;
    if (isset($dblink)) { mysql_close($dblink); }
}

function art_check_request($param){
    return (isset($_REQUEST[$param]));
}

function art_request($param, $default){
    return (isset($_REQUEST[$param]) && (trim($_REQUEST[$param]) != "")) ? trim($_REQUEST[$param]) : $default;
}

function art_set_request($param, $value){
    if(isset($_REQUEST[$param])){
        $_REQUEST[$param] = $value;
    }
}

function art_request_checkbox($param, $checked_value, $unchecked_value){
    $value = ((isset($_REQUEST[$param]) && (trim($_REQUEST[$param]) != "")) ? trim($_REQUEST[$param]) : false);
    if ($value){
	       return $checked_value;
    } else {
        return $unchecked_value;
    }
}

function art_request_file($param, $type, $default){
    return (isset($_FILES[$param][$type]) && (trim($_FILES[$param][$type]) != "")) ? trim($_FILES[$param][$type]) : $default;
}

function art_session($param, $default){
    return (isset($_SESSION[$param]) && (trim($_SESSION[$param]) != "")) ? trim($_SESSION[$param]) : $default;
}

function art_set_session($param, $value){
   	$_SESSION[$param] = $value;
}

function art_setdefault_session($param, $default){
    $_SESSION[$param]  = isset($_SESSION[$param]) ? $_SESSION[$param] : $default;
}

function art_check_session($param){
    return (isset($_SESSION[$param]) && (trim($_SESSION[$param]) != ""));
}

function art_assign_session($param, $default){
    if (art_check_request($param)){
  	     $_SESSION[$param] = art_request($param, $default);
    }
}

function art_clear_session($param){
    $_SESSION[$param] = "";
}

function art_server($param, $default){
    return (isset($_SERVER[$param]) && (trim($_SERVER[$param]) != "")) ? trim($_SERVER[$param]) : $default;
}

function art_delete_file($filename){
    @unlink($filename);
}

function art_file_extension($filename){
    return end(explode(".", $filename));
}

function art_remove_extension($filename){
    return preg_replace('/(.+)\..*$/', '$1', $filename); 
}

function art_remove_comma($value){
    return str_replace(',', '', $value); 
}

function art_gen_url($url, $use_ajax=0){
    $result = "";
    if ($use_ajax == 0){
		     $result = $url;
    } else {
		     $result = "javascript:art_call_ajax('" . $url . "');";
    }
    return $result;
}

function art_format_date($rawdate, $format){
    if ($rawdate == null){
        return "null";
    } else if ($format == "") {
        return $rawdate;
    } else {
        $dateTime = strtotime($rawdate);
        $formatted_date = date($format, $dateTime);
        return $formatted_date; 
    }
}

function art_check_null($value)
{
    if (($value == null) || ($value == "")){
        return "&nbsp;"; 
    } else {
        return $value; 
    }
}

function art_doubleqoute($value){
    return str_replace("'", "''", $value); 
}

function art_escape_sqlval($value){
    if (get_magic_quotes_gpc()){
        return mysql_real_escape_string(stripslashes($value));
    } else {
        return mysql_real_escape_string($value);
    }
}

function art_quote_strval($value){
    if ($value == null) {
        return "null";
    } else {
        if (get_magic_quotes_gpc()){
            return "'" . mysql_real_escape_string(stripslashes($value)) . "'";
        } else {
            return "'" . mysql_real_escape_string($value) . "'";
        }
    }
}

function art_quote_intval($value){
    if ($value == null){
        return "null";
    } else {
        return art_remove_comma($value);
    }
}

function art_quote_dateval($value){
    if ($value == null){
        return "null";
    } else {
        if (get_magic_quotes_gpc()){
            return "'" . mysql_real_escape_string(stripslashes($value)) . "'";
        } else {
            return "'" . mysql_real_escape_string($value) . "'";
        }
    }
}

function art_leading_zero($value) {
    return  str_replace("0.", ".", $value);
}

function art_check_negative($value, $display_value){
    $result = "";
    if ($value < 0){
        $result = "(".$display_value.")";
    } else {
        $result = $display_value;
    }
    return $result;
}

function art_remove_qrystring($qry_strings, $search){
    $result = array();
    $key = "";
    $total_match= 0;
    $search = explode(', ', $search);
    if ((count($search) > 1) && (count($qry_strings) > 1)){
        foreach($qry_strings as $k => $v){
            $total_match = 0;
            foreach($search as $sk){
						     $key = strtolower(substr($sk, 0));
						     if ($k == $key){
								     $key = "";
								     $total_match += 1;
						     }
            }
				     if ($total_match == 0){
						     $result[] = $k.'='.$v;
				     }
        }
        return join('&', $result);
    } else {
		     return $qry_strings;
    }
}

function art_shownav_text($pagename, $totalrec, $page_size, $current_page, $ret_page, $showtotalrec=0, $showpagesize=0, $use_ajax=0){
    global $current_row,  $numrows;
    $pagingtext = "";
		 $numrecfound = "";
		 $str_pagesize = "";

    if ($totalrec > 0){
		     $page_count = ceil($totalrec/$page_size);
    } else {
		     $page_count = 1;
		 }
    if ($current_page > $page_count) { $current_page = 1; }
		 if ($current_page < 1) { $current_page = 1; }
		 if ($page_count < 1) { $page_count = 1; }

		 if (($current_page%10) == 0) {
			   $startpage = $current_page - 9;
		 } else {
			   $startpage = ($current_page - ($current_page%10)) + 1;
		 }
		 if ($showtotalrec != 0) {
			   $current_row = (($current_page-1) * $page_size);
		     $max_page_size = $current_row + $page_size;
		     if ($max_page_size > $totalrec) {
            $max_page_size = $totalrec;
		     }
			   $numrecfound .=  CAP_GRID_TOTALTXT1 . " <b>" . ($current_row + 1) . " - " . ($max_page_size) . "</b> " . CAP_GRID_TOTALTXT2 . " <b>" . $totalrec  . "</b>";
    }
		 if ($current_page == 1){
		     $pagingtext.=  "<font class=\"gridPaging\">" .CAP_NAV_FIRST . " | </font>\n";
		     $pagingtext.=  "<font class=\"gridPaging\">" . CAP_NAV_PREVIOUS . " | </font>\n";
		 } else {
		     $pagingtext.=  "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=1&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">" . CAP_NAV_FIRST . "</a> | ";
		     $pagingtext.=  "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . ($current_page - 1) . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">" . CAP_NAV_PREVIOUS . "</a> | ";
		 }

		 for ($i = 0; $i <= 9; $i++){
			   if (($startpage + $i) <= $page_count) {
				     if (($startpage + $i) == $current_page) {
					       $pagingtext.=  "<font class=\"gridPagingSelected\">" . ($startpage + $i) . "</font> | ";
				     } else {
						     $pagingtext.= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=".($startpage + $i)."&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">".($startpage + $i)."</a> | ";
				     }
			   }
		 }

		 if ($current_page == $page_count){
			   $pagingtext .= "<font class=\"gridPaging\">" . CAP_NAV_NEXT . " | </font>\n";
			   $pagingtext .= "<font class=\"gridPaging\">" . CAP_NAV_LAST . "</font>\n";
		 } else {
		     $pagingtext .= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . ($current_page + 1) . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">" . CAP_NAV_NEXT . "</a> | ";
		     $pagingtext .= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . $page_count . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">" . CAP_NAV_LAST . "</a>";
		 }
		 $pagingtext.= "<br />\n";
		 print "<table width=\"100%\" height=\"100%\" border=\"0\"  align=\"center\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">" ;
		 print "<tr>\n";
		 print "<td class=\"gridPagingText\" align=\"left\">" . $numrecfound . "</td>\n";
		 print "<td class=\"gridPagingText\" align=\"right\">" . $pagingtext;
		 print "</td>\n";
		 print "</tr>\n";
		 print "</table>\n";
}

function art_shownav_image($pagename, $totalrec, $page_size, $current_page, $ret_page, $showtotalrec=0, $showpagesize=0, $use_ajax=0, $folder_button_images){
		 global $current_row,  $numrows;
		 $pagingtext = "";
		 $numrecfound = "";
		 $str_pagesize = "";

    if ($totalrec > 0) {
		     $page_count = ceil($totalrec/$page_size);
    } else {
		     $page_count = 1;
		 }

		 if ($current_page > $page_count) { $current_page = 1; }
		 if ($current_page < 1) { $current_page = 1; }
		 if ($page_count < 1) { $page_count = 1; }

		 if (($current_page%10) == 0) {
		     $startpage = $current_page - 9;
		 } else {
			   $startpage = ($current_page - ($current_page%10)) + 1;
		 }

		 if ($showtotalrec !=0){
			   $current_row = (($current_page-1)*$page_size);
		     $max_page_size = $current_row + $page_size;
		     if ($max_page_size > $totalrec) {
            $max_page_size = $totalrec;
		     }
			   $numrecfound .=  CAP_GRID_TOTALTXT1 . " <b>" . ($current_row + 1) . " - " . ($max_page_size) . "</b> " . CAP_GRID_TOTALTXT2 . " <b>" . $totalrec  . "</b>";
    }

		 if ($current_page == 1){
        $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_first_dis.gif\" alt=\"" . CAP_NAV_FIRST . "\" border=\"0\" align=\"absmiddle\" />\n";
		     $pagingtext .= " <img src=\""."./images/" . $folder_button_images . "/nav_back_dis.gif\" alt=\"" . CAP_NAV_PREVIOUS . "\" border=\"0\" align=\"absmiddle\" /> | ";
    } else {
        $pagingtext .= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=1&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">\n";
				 $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_first.gif\" alt=\"" . CAP_NAV_FIRST . "\" border=\"0\" align=\"absmiddle\" /></a>\n";
				 $pagingtext .= " <a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . ($current_page - 1) . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">\n";
        $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_back.gif\" alt=\"" . CAP_NAV_PREVIOUS . "\" border=\"0\" align=\"absmiddle\" /></a> | ";
    }

		 for ($i = 0; $i <= 9; $i++){
		     if (($startpage + $i) <= $page_count){
				     if (($startpage + $i) == $current_page){
					       $pagingtext .=  "<b><font class=\"gridPagingSelected\">" . ($startpage + $i) . "</font></b> | ";
				     }else {
                $pagingtext .= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=".($startpage + $i)."&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">".($startpage + $i)."</a> | ";
				     }
        }
    }

    if ($current_page == $page_count){
		     $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_next_dis.gif\" alt=\"" . CAP_NAV_NEXT . "\" border=\"0\" align=\"absmiddle\" />\n";
        $pagingtext .= " <img src=\""."./images/" . $folder_button_images . "/nav_last_dis.gif\" alt=\"" . CAP_NAV_LAST . "\" border=\"0\" align=\"absmiddle\" />\n";
    } else {
			   $pagingtext .= "<a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . ($current_page + 1) . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">\n";
			   $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_next.gif\" alt=\"" . CAP_NAV_NEXT . "\" border=\"0\" align=\"absmiddle\" /></a>\n";
			   $pagingtext .= " <a HREF=\"".art_gen_url($ret_page."?".$pagename."_page=" . $page_count . "&".$pagename."_page_size=".$page_size, 1)."\" class=\"gridPaging\">\n";
			   $pagingtext .= "<img src=\""."./images/" . $folder_button_images . "/nav_last.gif\" alt=\"". CAP_NAV_LAST . "\" border=\"0\" align=\"absmiddle\" /></a>\n";
    }
		 $pagingtext .= "<br />\n";
		 print "<table width=\"100%\" height=\"100%\" border=\"0\"  align=\"center\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">" ;
		 print "<tr>\n";
		 print "<td class=\"gridPagingText\" align=\"left\" ><div align=\"left\">".$str_pagesize."</div></td>\n";
		 print "<td class=\"gridPagingText\" align=\"left\">".$numrecfound."</td>\n";
		 print "<td class=\"gridPagingText\" align=\"right\">".$pagingtext."</td>\n";
		 print "</tr>\n";
		 print "</table>\n";
}

function art_shownav_combobox($pagename, $totalrec, $page_size, $current_page, $ret_page, $showtotalrec=0, $showpagesize=0, $use_ajax=0){
		 global $current_row,  $numrows;
		 $pagingtext = "";
		 $numrecfound = "";
		 $str_pagesize ="";
    if ($totalrec > 0) {
		     $page_count = ceil($totalrec/$page_size);
		 } else {
		     $page_count = 1;
		 }

		 if ($current_page > $page_count) { $current_page = 1; }
		 if ($current_page < 1) { $current_page = 1; }
		 if ($page_count < 1) { $page_count = 1; }

		 if ($showtotalrec !=0) {
		     $current_row = ( ($current_page-1) * $page_size);
		     $max_page_size = $current_row + $page_size;
		     if ($max_page_size > $totalrec) {
            $max_page_size = $totalrec;
		     }
			   $numrecfound .=  CAP_GRID_TOTALTXT1 . " <b>" . ($current_row + 1) . " - " . ($max_page_size) . "</b> " . CAP_GRID_TOTALTXT2 . " <b>" . $totalrec  . "</b>";
    }

		 $page = art_request("page", "1");
		 $pagingtext .= "<table align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		 $pagingtext .= "<tr>\n";
		 $pagingtext .= "<td class=\"gridPagingText\"  align=\"right\">\n";
		 $pagingtext .= "Page:&nbsp;&nbsp;";
		 $pagingtext .= "</td>\n";
		 $pagingtext .= "<td class=\"gridPagingText\"  align=\"right\">\n";
		 $pagingtext .= "<select name=\"".$pagename."_page\" id=\"".$pagename."_page\" class=\"combo\" style=\"width:70px\" onChange=\"art_form_submit(this, 1, '" . $ret_page . "');\">\n";
		 for ($i = 1; $i <= $page_count; $i++){
			   $pagingtext .= "<option " . (($current_page == $i)? "selected" : "" ) . ">" . $i . "</option>\n";
    }
		 $pagingtext .= "</select>\n";
		 $pagingtext .= "</td>\n";
		 $pagingtext .= "</tr>\n";
    $pagingtext .= "</table>\n";

		 print "<table width=\"100%\" height=\"100%\" border=\"0\"  align=\"center\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">" ;
		 print "<tr>\n";
		 print "<td class=\"gridPagingText\" align=\"left\" ><div align=\"left\">".$str_pagesize."</div></td>\n";
		 print "<td class=\"gridPagingText\" align=\"left\">".$numrecfound."</td>\n";
		 print "<td class=\"gridPagingText\" align=\"right\">".$pagingtext;
		 print "</td>\n";
		 print "</tr>\n";
		 print "</table>\n";
}

function art_shownav_goto($pagename, $totalrec, $page_size, $current_page, $ret_page, $showtotalrec=0, $showpagesize=0, $use_ajax=0){
		 global $current_row, $numrows;
		 $pagingtext = "";
		 $numrecfound = "";
		 $str_pagesize ="";

    if ($totalrec > 0) {
		     $page_count = ceil($totalrec/$page_size);
		 } else {
		     $page_count = 1;
		 }

		 if ($current_page > $page_count) { $current_page = 1; }
		 if ($current_page < 1) { $current_page = 1; }
		 if ($page_count < 1) { $page_count = 1; }				

		 if ($showtotalrec !=0){
		     $current_row = (($current_page-1)*$page_size);
		     $max_page_size = $current_row + $page_size;
		     if ($max_page_size > $totalrec){
            $max_page_size = $totalrec;
		     }
			   $numrecfound .=  CAP_GRID_TOTALTXT1 . " <b>" . ($current_row + 1) . " - " . ($max_page_size) . "</b> " . CAP_GRID_TOTALTXT2 . " <b>" . $totalrec  . "</b>";
    }
		 $page = art_request("page", "1");
		 $pagingtext .= "<table align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		 $pagingtext .= "<tr>\n";
		 $pagingtext .= "<td class=\"gridPagingText\"  align=\"right\">\n";
		 $pagingtext .= "Go to page:&nbsp;&nbsp;";
		 $pagingtext .= "</td>\n";
		 $pagingtext .= "<td class=\"gridPagingText\"  align=\"right\">\n";
		 $pagingtext .= "<input type=\"text\" name=\"".$pagename."_page\" id=\"".$pagename."_page\" value=\"".$current_page."\" size=\"1\">&nbsp;";
		 $pagingtext .= "</td>\n";
		 $pagingtext .= "<td class=\"gridPagingText\"  align=\"right\">\n";
		 $pagingtext .= "<input class=\"button\" type=\"submit\" name=\"".$pagename."_goto\" id=\"".$pagename."_goto\" value=\"Go\" Onclick=\"art_form_submit(this, 1, '" . $ret_page . "');\" >\n";
		 $pagingtext .= "</td>\n";
		 $pagingtext .= "</tr>\n";
		 $pagingtext .= "</table>\n";

		 print "<table width=\"100%\" height=\"100%\"  border=\"0\"  align=\"center\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">\n";
		 print "<tr>\n";
		 print "<td class=\"gridPagingText\" align=\"left\" ><div align=\"left\">" . $str_pagesize . "</div></td>\n";
		 print "<td class=\"gridPagingText\" align=\"left\">" . $numrecfound . "</td>\n";
		 print "<td class=\"gridPagingText\" align=\"right\"> " . $pagingtext . "</td>\n";
		 print "</tr>\n";
		 print "</table>\n";
}

function art_show_navigator($pagename, $type, $totalrec, $page_size, $current_page, $ret_page, $showtotalrec=0, $showpagesize=0, $use_ajax=0, $folder_button_images) {
    if (strtolower($type)=="text"){
		     art_shownav_text($pagename, $totalrec, $page_size, $current_page, $ret_page, 1, 1);
	   } else if (strtolower($type)=="image"){
		     art_shownav_image($pagename, $totalrec, $page_size, $current_page, $ret_page, 1, 1, $use_ajax, $folder_button_images);
    } else if (strtolower($type)=="cmb"){
		     art_shownav_combobox($pagename, $totalrec, $page_size, $current_page, $ret_page, 1, 1);
    } else if (strtolower($type)=="goto"){
		     art_shownav_goto($pagename, $totalrec, $page_size, $current_page, $ret_page, 1, 1);
    }
}

function art_show_errormsg($str ,$ret_page){
    print "<table width=\"98%\" height=\"50\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\" bgcolor=\"#FF0000\" align=\"center\" id=\"gridTable\" >\n";
    print "<tr>\n";
    print "<td bgcolor=\"#FFFFFF\" class=\"stdFont\"><center><font color=\"red\">\n";
    print "$str";
    print "<br /><br /><a href=\"".$ret_page."\" class=\"stdLink\">Back</a>\n";
    print "</font></center>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
}

function art_show_msg($str ,$ret_page){
    print "<table width=\"98%\" height=\"50\"  border=\"0\" cellpadding=\"2\" cellspacing=\"1\" bgcolor=\"#68B5D9\" align=\"center\" id=\"gridTable\" >\n";
    print "<tr>\n";
    print "<td bgcolor=\"#FFFFFF\"  class=\"stdFont\"><center><font color=\"blue\">\n";
    print "$str";
    print "<br /><br /><a href=\"".$ret_page."\" class=\"stdLink\">Back</a>\n";
    print "</font></center></td></tr>\n";
	   print "</tr>\n";
	   print "</table>\n";
}

function art_combobox_display($control_name, $control_caption, $sql, $master_value, $key_field, $css, $disabled, $field_value, $field_label, $value, $url, $ismaster, $multiline, $size, $width, $firstitem_label, $firstitem_value){
    if ($key_field == "") {
		     $sql_cmb = $sql;
    } else {
        if (!strpos(strtoupper($sql), "WHERE")) {
		         $sql_cmb = $sql . " WHERE " .  $key_field . " = " . art_quote_strval($master_value) . "";
        } else {
		         $sql_cmb = $sql . " AND " .  $key_field . " = " . art_quote_strval($master_value) . "";
        }
    }
    $multiline_text = "";
    $size_text = "";
    if ($multiline) {
        $multiline_text = " multiline=\"multiline\"";
        $size_text = " size=\"" . $size . "\"";
    }

    $width_text = "";
    if ($width != "") {
        $width_text = " style=\"width:" . $width . "\"";
    }

		 $qry_cmb = mysql_query($sql_cmb);
		 $numrow_cmb = 0;
		 if ($qry_cmb != null) {
		     $numrow_cmb = mysql_num_rows($qry_cmb);
		 }
		 if ($numrow_cmb > 0) {
        if ($ismaster) {
            print "<select class=\"combobox\" id=\"" . $control_name . "\" name=\"" . $control_name . "\"" . $multiline_text . $size_text . $width_text . " onChange=\"art_form_submit(this, 1, '". $url ."')\" >\n";
        }
        else
        {
            print "<select class=\"combobox\" id=\"" . $control_name . "\" name=\"" . $control_name . "\"" . $multiline_text . $size_text . $width_text . " >\n";
        }

        if ($firstitem_label != ""){
            $selected = "";
	           if ($value == $firstitem_value)
	           {
	               $selected = "selected";
	           }
            print "<option value=\"" . $firstitem_value . "\" " . $selected . ">" . $firstitem_label . "</option>\n";
        }
        while ($row_cmb = mysql_fetch_array($qry_cmb)){
            $selected = "";
	           if ($value == $row_cmb[$field_value])
	           {
	               $selected = "selected";
	           }
	           print "<option value=\"" . htmlspecialchars($row_cmb[$field_value],ENT_COMPAT) . "\" " . $selected . ">" .  htmlspecialchars($row_cmb[$field_label]) . "</option>\n";
        }
        print "</select>\n";
		 }
}

function art_radiobutton_display($control_name, $control_caption, $sql, $master_value, $key_field, $css, $disabled, $field_value, $field_label, $value, $url, $ismaster, $col, $firstitem_label, $firstitem_value){
    if (($key_field == "") || ($master_value != "")){
        if ($key_field == "") {
		         $sql_rdo = $sql;
        } else {
            if (!strpos(strtoupper($sql), "WHERE")) {
		             $sql_rdo = $sql . " WHERE " .  $key_field . " = " . art_quote_strval($master_value) . "";
            } else {
		             $sql_rdo = $sql . " AND " .  $key_field . " = " . art_quote_strval($master_value) . "";
            }
        }
    		 $qry_rdo = mysql_query($sql_rdo);
	    	 $numrow_rdo = mysql_num_rows($qry_rdo);
        $icol = 0;
        $control_idx = 1;
        if ($firstitem_label != ""){
            print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: none;background-image: none;\">\n";
            print "<tr>\n";
            $checked = "";
            if ($value == $firstitem_value){
	               $checked = "checked";
	           }
            if ($ismaster){
                print "<td><input type=\"radio\" id=\"" . $control_name . $control_idx . "\" name=\"" . $control_name . "\" value=\"". $firstitem_value ."\" ".$checked." onChange=\"art_form_submit(this, 1, '". $url ."')\" >\n";
            } else {
                print "<td><input type=\"radio\" id=\"" . $control_name . $control_idx . "\" name=\"" . $control_name . "\" value=\"". $firstitem_value ."\" ".$checked.">\n";
            }
            $icol++;
            $control_idx++;
            print $firstitem_label . "</td>\n";
            if ($icol == $col) {
                $icol = 0;
                print "</tr>\n";
            }
        }
        if ($numrow_rdo > 0) {
            if ($firstitem_label == ""){
                print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border: none;background-image: none;\">\n";
            }
            while ($row_rdo = mysql_fetch_array($qry_rdo)){
                $checked = "";
                if ($value == $row_rdo[$field_value]){
	                   $checked = "checked";
	               }
                if ($icol == 0){
                   print "<tr>\n";
                }
                if ($ismaster){
                    print "<td><input type=\"radio\" id=\"" . $control_name . $control_idx . "\" name=\"" . $control_name . "\" value=\"". htmlspecialchars($row_rdo[$field_value]) ."\" ".$checked." onChange=\"art_form_submit(this, 1, '". $url ."')\" >\n";
                } else {
                    print "<td><input type=\"radio\" id=\"" . $control_name . $control_idx . "\" name=\"" . $control_name . "\" value=\"". htmlspecialchars($row_rdo[$field_value]) ."\" ".$checked.">\n";
                }
                $control_idx++;
                $icol++;
                print htmlspecialchars($row_rdo[$field_label]) . "</td>\n";
                if ($icol == $col) {
                    $icol = 0;
                    print "</tr>\n";
                }
            }
            if ($icol != 0){
                print "</tr>\n";
            }
            print "</table>\n";
        } else {
            if ($firstitem_label != ""){
                if ($icol != 0){
                    print "</tr>\n";
                }
                print "</table>\n";
            }
        }
    }
}

function art_random_filename(){
    $str_lenght = 8;		
    $new_filename = "";		
		 for($i = 0; $i < $str_lenght; $i++){
		     $new_filename .= art_random_char(); 
		 } 							 		 	
 	 return $new_filename;
}

function art_create_verification_code(){
    $str_lenght = 5;		
    $verification_code = "";		
		 for($i = 0; $i < $str_lenght; $i++){
		     $verification_code .= art_random_char(); 
		 } 							 		 	
 	 $_SESSION['captcha_code'] = $verification_code; 
		 $_SESSION['captcha_encrypted'] = md5($verification_code); 	
 	 return $verification_code;
}

function art_random_char(){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr($chars, (rand() % strlen($chars)), 1);
}
function art_captcha_display($control_name, $control_caption, $required_type){
    $css = "";
    print "<tr>\n";
	   if ($required_type == 0) {
	       print "<td class=\"formColumnCaption\"><b>" . $control_caption . "</b></td>\n";
	   } else if ($required_type == 1) {
	       print "<td class=\"formColumnCaption\"><u>" . $control_caption . "</u></td>\n";
	   } else if ($required_type == 2) {
	       print "<td class=\"formColumnCaption\">" . $control_caption . "*</td>\n";
	   }
	   print "<td width=\"3\" class=\"formColumnData\">&nbsp;</td>\n";
    print "<td class=\"formColumnData\" align=\"left\">\n";
	   print "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
	   print "<tr><td>\n";
	   print "<img src=\"./includes/art_captcha_image.php\" alt=\"Verification Code\" /><br /><input name=\"".$control_name."\" id=\"".$control_name."\" class=\"textbox\" type=\"text\" size=\"10\">\n";
	   print "</td></tr>\n";
	   print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
}

function art_check_verification($code){
    $err = "";
    $code_encrypted = md5($code);
    if ($_SESSION['captcha_encrypted'] != $code_encrypted){
        $err .= MSG_VERIFICATION_FAIL;
    }
    return $err;
}

function art_waitingmsg_display(){
    print "<div id=\"loadingbg\" class=\"MaskLoadingBG\">\n";
    print "</div>\n";
    print "<div style=\"z-index: 99;  position: absolute;\" id=\"invisiblediv\";>\n";
    print "    <table width=\"100%\">\n";
    print "        <tr>\n";
    print "            <td valign=\"top\" align=\"center\" valign=\"middle\" >\n";
    print "                <div class=\"LoadingBlock\" id=\"loadingblock\">\n";
    print "                    <table width=\"100%\" height=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >\n";
    print "                        <tr>\n";
    print "                            <td valign=\"middle\" align=\"center\" >\n";
    print "                                <img src=\"images/ajaxloading.gif\" align=\"absmiddle\" border=\"0\" />\n";
    print "                                <font class=\"LoadingBlockText\">Sedang Proses...</font>\n";
    print "                            </td>\n";
    print "                        </tr>\n";
    print "                    </table>\n";
    print "                </div>\n";
    print "            </td>\n";
    print "        </tr>\n";
    print "    </table>\n";
    print "</div>\n";
}

function art_reload_script($artistform, $fckeditor){
    print "<script language=\"javascript\" type=\"text/javascript\">";
    if ($artistform){
        print "    loadArtistForm();";
    }
    if ($fckeditor){
        print "    loadFCKeditor();";
    }
    print "</script>";
}

function art_sitemenu_display($forpage, $cssname){
    print "<div id=\"sitemenu_" . $cssname . "\">";
    print "<br />";
    print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  width=\"150px\">\n";
    print "    <tr>\n";
    print "        <td class=\"siteMenuHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "        <td class=\"siteMenuHeaderBG\"><span class=\"siteMenuHeaderText\">Site Menu</span></td>\n";
    print "        <td class=\"siteMenuHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr>\n";
    print "        <td class=\"siteMenuColumnBGLeft\">&nbsp;</td>\n";
    print "        <td valign=\"middle\" class=\"siteMenuBody\">\n";
    print "             <div class=\"siteMenu\">\n";
    print "             <ul>\n";
    //$login = $_SESSION('art_user_name');
    //session_start();
    if ($_SESSION['art_user_name'] == "admin"){
         if ($forpage == "User" ){
            print "                 <li class=\"siteMenuSelected\">user</li>\n";
            print "                 <li class=\"siteMenu a:link\"><a href=\"report_admin.php\">report</a></li>\n";
         }
         else {
             print "                 <li><a href=\"" . "./user.php?clr_user=t&clr_user_adv_session=y". "\"" . " title=\"user\">user</a></li>\n";
             print "                 <li class=\"siteMenuSelected\">report</li>\n";
         }
    }
    else {
        if ($forpage == "logbook" ){
            print "                 <li class=\"siteMenuSelected\">logbook</li>\n";
            print "                 <li class=\"siteMenu a:link\"><a href=\"report.php\">report</a></li>\n";
         }
         else {
             print "                 <li><a href=\"" . "./logbook.php?clr_logbook=t&clr_logbook_adv_session=y". "\"" . " title=\"logbook\">logbook</a></li>\n";
             print "                 <li class=\"siteMenuSelected\">report</li>\n";
         }
    }
    print "             </ul>\n";
    print "             </div>\n";
    print "        </td>\n";
    print "        <td class=\"siteMenuColumnBGRight\">&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr>\n";
    print "        <td class=\"siteMenuFooter\"></td>\n";
    print "        <td class=\"siteMenuFooter\"></td>\n";
    print "        <td class=\"siteMenuFooter\"></td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>";
}


?>
