<?php
require_once './includes/art_functions.php';
require_once './Report_const.php';

function art_simplesearch_display($search_value){
    $searchbox_caption = "Search";
    print "<div id=\"sch_report_th\">";
    print "<br />\n";
    print "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"300\"  align=\"left\">\n";
    print "    <tr>\n";
    print "        <td class=\"schHeaderBGLeft\">&nbsp;</td>\n";
    print "        <td class=\"schHeaderBG\"><span class=\"schHeaderText\">" . $searchbox_caption . "</span>&nbsp;</td>\n";
    print "        <td class=\"schHeaderBGRight\">&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr class=\"schBody\">\n";
    print "        <td class=\"schColumnBGLeft\">&nbsp;</td>\n";
    print "        <td valign=\"middle\" height=\"50\" align=\"center\">\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "                <tr>\n";
    print "                    <td><input class=\"textbox\" type=\"text\" name=\"artsys_quick_search\" id=\"artsys_quick_search\" value=\"" . $search_value . "\"></td>\n";
    print "                    <td width=\"5\">&nbsp;</td>\n";
    print "                    <td><input class=\"button\" name=\"btn_search\" id=\"btn_search\" type=\"submit\" value=\"" . CAP_BUTTON_SEARCH . "\"></td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "        <td class=\"schColumnBGRight\" >&nbsp;</td>\n";
    print "    </tr>\n";
    print "    <tr class=\"schFooter\">\n";
    print "        <td></td>\n";
    print "        <td></td>\n";
    print "        <td></td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>";
}

function art_simplesearch_sql($start_sql, $search_value) {
    $sql = "";
  /* if (!strpos(strtoupper($start_sql), "WHERE")) {
        $sql = " WHERE (";
    } else {
        $sql = " AND (";
    }
    $sql .= "pelayanan.nm_pelayanan LIKE '" . $search_value . "%' ";
    $sql .= ")";*/
    return $sql;
}

function art_append_sqlcondition($sql, $condition){
    if (!strpos(strtoupper($sql), "WHERE")) {
        $sql .= " WHERE (";
    } else {
        $sql .= " AND (";
    }
    $sql .= $condition;
    return $sql .= ")";
}

function art_split_sql($sql) {
    $ipos = strpos(  strtoupper($sql) , "ORDER BY") ;
    if ($ipos > 0) {
        $sql_array[0] = substr($sql, 1, $ipos - 1);
        $sql_array[1] = substr($sql, $ipos - 1, strlen($sql));
    } else {
        $sql_array[0] = $sql;
        $sql_array[1] = "";
    }
    return $sql_array;
}

function art_append_orderby($sql, $field) {
    $result = "";
    $str_orderby = " ORDER BY " . $field;
    $ipos = strpos(strtoupper($sql), "ORDER BY");
    if ($ipos > 0){
        $ipos = strpos(strtoupper($sql), strtoupper($field));
        if ($ipos > 0){
            $result = $sql;
        } else {
            $result = str_replace("ORDER BY", $str_orderby . ",", strtoupper($sql));
        }
    } else {
        $result = $str_orderby;
    }
    return $result;
}

function art_gridtoolbar_display($category){
    print "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\">\n";
    print "    <tr>\n";
    
    print "        <td>\n";
    $hostname  = $_SERVER['HTTP_HOST'];
    $currentpath = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $exportscript = "Report_dialog_pdf.php";
    $exporturl = "http://$hostname$currentpath/$exportscript";
    print "<a href=\"javascript:art_export_pdf( '" . $exporturl . "' );\" title=\"" . CAP_EXPORT_PDF . "\"><img src=\"images/defaultbutton/pdf.gif\" border=\"0\" align=\"absmiddle\" ></a>\n";
    $exportscript  = "Report_export_xls.php";
    $exporturl = "http://$hostname$currentpath/$exportscript";
    print "<a href=\"javascript:art_export_xls( '" . $exporturl . "' );\" title=\"" . CAP_EXPORT_XLS . "\"><img src=\"images/defaultbutton/xls.gif\" border=\"0\" align=\"absmiddle\" ></a>\n";
    print "        </td>\n";
    print "    </tr>\n";
    print "</table>\n";
}

function art_datagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category, $showtotalrec=0, $showpagesize=0) {	
    $artsv_postback = art_request("artsys_postback", "");
    $sql = "";
    $sql_start = " ";
    $sql_condition = "";
    $sql_ext = "";
    $cssrow = "";
    $query_array = "";
    $querystr = ""; 
    $pagerecords = 0; 

    $field_columns = array (
        'pelayanan.nm_pelayanan'
        ,'JUMLAH'
	  );

    $qrystr = array_fill(0, 2, "");
    $clr = art_request("clr_Report", "");
    $clr_adv_session = art_request("clr_Report_adv_session", "");

    if (strtolower($clr) == "t"){
        art_clear_session("Report_sort1");	
        art_clear_session("Report_sort2");	
        $clr = "";
	  }

    if (strtolower($clr_adv_session) == "y") {
        $clr_adv_session = "";
        art_clear_session("Report_search");
        art_clear_session("Report_page");
        art_clear_session("Report_quick_search");
        art_clear_session("Report_category");
        $quick_search = "";
        $category = "";
	  }

    art_assign_session("Report_page_size", 20);
    art_assign_session("Report_page", "1");
    $uid=$_SESSION['art_user_name'];
    $sql_array  = art_split_sql(" SELECT 
  pelayanan.nm_pelayanan AS PELAYANAN,
  COUNT(logbook.id) AS JUMLAH
FROM
  logbook
  RIGHT JOIN pelayanan ON (logbook.id_pel = pelayanan.id_pel)
  where uid = '$uid'
GROUP BY
  pelayanan.nm_pelayanan"); 
    $sql_start = $sql_array[0]; 
    $sql_orderby = $sql_array[1]; 
    $sort1 = art_session("Report_sort1", "");
    $sort2 = art_session("Report_sort2", "");
    $page_size = art_session("Report_page_size", "20");
    $page = art_session("Report_page", "1");
    $current_page = $page;
    $search = "";
    $sql_condition = $sql_start . art_simplesearch_sql($sql_start, $quick_search);
    for ($i=1; $i<=2; $i++){
        $sorting = "";
        $sort_order = "";
        if (art_session("Report_sort".$i, "") == "1"){
            $sorting = "&Report_sort". $i . "=" . "2";
            $sort_order = "ASC";
        } else if (art_session("Report_sort".$i, "") == "2"){
            $sorting = "&Report_sort". $i . "=" . "1";
            $sort_order = "DESC";
        } else {
            $sorting = "&Report_sort". $i . "=" . "1";
            $sort_order = "";
        }
        $qrystr[$i] = "Report_ajax.php?clr_Report=t".$sorting;

        if ($sort_order != ""){
            if ($sql_orderby == ""){
                $sql_orderby .= " ORDER BY " . $field_columns[$i - 1] . " " . $sort_order;
            } else {
                $sql_orderby .= ", " . $field_columns[$i - 1] . " " . $sort_order;
            }
        }
    }
    $advsearch_sql = art_session("Report_search","");
    if ($advsearch_sql != "") {
      $sql_condition = art_append_sqlcondition($sql_condition, $advsearch_sql);
    }
    $sql_condition .= $sql_orderby;	
    $current_row = ($current_page - 1) * $page_size;
    $sql = $sql_condition;
    $result = mysql_query($sql);
    $numrows = 0;
    if ($result != null) { $numrows = mysql_num_rows($result); }
    $sql_ext = "";
    if ($numrows < $current_row) {
       $current_row =  $numrows - 1;
    }
    $sql_ext = " LIMIT " . $current_row . ", " . $page_size;
    $sql = $sql . " " . $sql_ext;
    $result = mysql_query($sql);

    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"900\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_report_th\">\n";
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

    print "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\">\n";
    print "<tr>\n";
    print "<td width=\"1\" rowspan=\"2\" align=\"left\" valign=\"top\">\n";
    art_sitemenu_display("Report", "report_th");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td align=\"center\" valign=\"top\" class=\"siteMenuGap\">";
    //art_simplesearch_display($quick_search);
    /*print "<form class=\"formHeaderBG\" name=\"form1\" method=\"post\" action=\"?proses=cetak\">";?>
    Periode : <select name="bln1" id="bln1">   
    <option value="01" > Januari </option>
    <option value="02" > Februari </option>
    <option value="03" > Maret </option>
    <option value="04" > April </option>
    <option value="05" > Mei </option>
    <option value="06" > Juni </option>
    <option value="07" > Juli </option>
    <option value="08" > Agustus </option>
    <option value="09" > September </option>
    <option value="10" > Oktober </option>
    <option value="11" > Nopember </option>
    <option value="12" > Desember </option>
</select>
<select name="thn2" id="select3">
<?php for($i=2016;$i<=date("Y");$i++){ ?>
         <option><?php echo $i;?></option>
<?php } ?>
</select>
<input type="submit" name="Submit" value="Cari"/>
</form>*/  
    print "</td>\n";
    print "</tr>\n";
    print "<tr>\n";
    print "<td align=\"left\">&nbsp;</td>\n";
    print "<td align=\"left\">\n";
    //print "<br />\n";
    print "<div id=\"report_th\">";
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridTable\"  width=\"90%\">\n";
    print "    <tr>\n";
    print "        <td>\n";
    //$gridtitle = "Report Log Book";
    $nm_dokter = $_SESSION['art_nm_dokter'];
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridHeader\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridHeaderBG\" colspan=\"2\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td align = \"center\" valign=\"baseline\" ><span class=\"gridHeaderText\">" . $nm_dokter . "</span></td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridToolBar\" >\n";
    print "                <tr>\n";
    print "                    <td colspan=\"2\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" >";
    art_gridtoolbar_display($category);
    print "                                </td>\n";
    print "                                <td align=\"right\">\n";
    print "&nbsp;";
    print "                                </td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridMain\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a class=\"gridColumnText\">PELAYANAN</a>\n";
    print "                        </div>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridColumn\"  NOWRAP >\n";
    print "                        <div class=\"gridColumnText\">\n";
    print "                            <a class=\"gridColumnText\">JUMLAH</a>\n";
    print "                        </div>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    $emptydatatext = "No Record Found.";

    $layoutcolumn = 1;
    $icolumn = 0;
    $csscurrrow = "";
    $haveselectrow = false;
    $group = "";
    $currgroup = "";
    if ( ($numrows > 0) && ($result) ) {
        $i = 1;
        while ($row = mysql_fetch_array($result)){ 
            $pagerecords = $i;
            if (strtolower($csscurrrow) == "gridrow"){
                $csscurrrow = "gridRowAlternate";
            }else{
                $csscurrrow = "gridRow";
            }
            $cssrowover = "";
            $isrecmaster = false;
            if ($isrecmaster) {
                $haveselectrow = true;
                $cssrowover = "gridRowOver";
            }
            $cssrow = $csscurrrow;
            if ($cssrowover != "") {
                $cssrow = $cssrowover;
            }

            print "<tr class='".$cssrow."' >\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 0) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"center\" >";
            $svalue = art_check_null( number_format( art_rowdata($row, 1) , 0, '', ',' ) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "</tr>\n";

            $i++;
        }
    } else {
        print "                <tr class=\"gridRow\">\n";
        print "                    <td colspan=\"2\" ><div class=\"gridErrMsg\">" . $emptydatatext . "</div></td>\n";
        print "                </tr>\n";
    }
    print "            </table>\n";
    print "            <table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridFooter\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridFooterLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridFooterBG\" colspan=\"2\">\n";
    if ( ($numrows > 0) && ($result) ){
        if (isset($_SERVER["QUERY_STRING"])){
            parse_str($_SERVER["QUERY_STRING"], $query_array);
            parse_str($_SERVER["QUERY_STRING"]."&page=1", $query_array);
            $querystr = art_remove_qrystring($query_array, "page, page_size, order1, order2, order3, sort1, sort2, sort3, clr");
        }
        $use_ajax = 1;
        $folder_button_images = "defaultbutton";
        if ($navtype != ""){
            $pagename = "Report";
            art_show_navigator($pagename, $navtype, $numrows, $page_size, $current_page, "Report_ajax.php", 1, 0, $use_ajax, $folder_button_images);
        }
    } else {
        print "                <table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">\n";
        print "                    <tr>\n";
        print "                        <td class=\"gridFooterText\" align=\"right\"></td>\n";
        print "                    </tr>\n";
        print "                </table>\n";
    }
    print "                    </td>\n";
    print "                    <td class=\"gridFooterRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

    print "<input type=\"hidden\" name=\"artsys_pagerecords\" value=\"".$pagerecords."\" >\n";
    print "<input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "<br />\n"; 
}

function del_selected_items($pagerecords) {
    $j = 0;
    $k = 0;
    $msg = "";
    for ($i=1; $i <= $pagerecords; $i++){
        $del_id = art_request("chk_delfile".$i, "");
        if ($del_id != ""){
            if ($j==0){

                $sqlDel = "DELETE FROM `` WHERE ";
                $qryDel = mysql_query($sqlDel);
                if($qryDel){
                    art_set_request("chk_delfile".$i, "");
                } else {
                    $j++;
                }
            } else {
                $j++;
            }
        } else {
            $k++;
		    }
    }
    if ($k == $pagerecords){
        $msg = MSG_MULTIDEL_NO_SELECTED;
    }
    if($j > 0){
        $msg = MSG_MULTIDEL_FAIL;
    }
    return $msg;
}

function art_groupdatagrid_display($field_names, $page_size, $current_page, $quick_search, $navtype, $category, $showtotalrec=0, $showpagesize=0) {	
    $artsv_postback = art_request("artsys_postback", "");
    $sql = "";
    $sql_start = " ";
    $sql_condition = "";
    $sql_ext = "";
    $cssrow = "";
    $query_array = "";
    $querystr = ""; 
    $pagerecords = 0; 
    $field_columns = array (
        'pelayanan.nm_pelayanan'
        ,'JUMLAH'
	  );

    $qrystr = array_fill(0, 2, "");

    $clr = art_request("clr_Report", "");
    $clr_adv_session = art_request("clr_Report_adv_session", "");

    if (strtolower($clr) == "t") {
        art_clear_session("Report_sort1");	
        art_clear_session("Report_sort2");	
        $clr = "";
	  }

    if (strtolower($clr_adv_session) == "y") {
        $clr_adv_session = "";
        art_clear_session("Report_search");
        art_clear_session("Report_page");
        art_clear_session("Report_quick_search");
        art_clear_session("Report_category");
        $quick_search = "";
        $category = "";
	  }
    art_assign_session("Report_page_size", 20);
    art_assign_session("Report_page", "1");
    $sql_array  = art_split_sql(" SELECT 
  pelayanan.nm_pelayanan AS PELAYANAN,
  COUNT(logbook.id) AS JUMLAH
FROM
  logbook
  RIGHT JOIN pelayanan ON (logbook.id_pel = pelayanan.id_pel)
GROUP BY
  pelayanan.nm_pelayanan"); 
    $sql_start = $sql_array[0]; 
    $sql_orderby = $sql_array[1]; 

    $sort1 = art_session("Report_sort1", "");
    $sort2 = art_session("Report_sort2", "");
    $page_size = art_session("Report_page_size", "20");
    $page = art_session("Report_page", "1");
    $current_page = $page;
    $search = "";
    $sql_condition = $sql_start;
    for ($i=1; $i<=2; $i++){
        $sorting = "";
        $sort_order = "";
		    if (art_session("Report_sort".$i, "") == "1"){
		    	  $sorting = "&Report_sort". $i . "=" . "2";
            $sort_order = "ASC";
		    } else if (art_session("Report_sort".$i, "") == "2"){
		        $sorting = "&Report_sort". $i . "=" . "1";
            $sort_order = "DESC";
		    } else {
		        $sorting = "&Report_sort". $i . "=" . "1";
            $sort_order = "";
		    }
        $qrystr[$i] = "Report_ajax.php?clr_Report=t".$sorting;

		    if ($sort_order != ""){
            if ($sql_orderby == ""){
	  	          $sql_orderby .= " ORDER BY " . $field_columns[$i - 1] . " " . $sort_order;
	          } else {
	  	          $sql_orderby .= ", " . $field_columns[$i - 1] . " " . $sort_order;
	          }
        }
    }
    $advsearch_sql = art_session("Report_search","");
    if ($advsearch_sql != "") {
        $sql_condition = art_append_sqlcondition($sql_condition, $advsearch_sql);
    }
    $current_row = ($current_page - 1) * $page_size;
    $sql_condition .= $sql_orderby;	
    $sql = $sql_condition;
    $result = mysql_query($sql);
    $numrows = 0;
    if ($result != null) { $numrows = mysql_num_rows($result); }
    $sql_ext = "";
    if ($numrows < $current_row) {
       $current_row =  $numrows - 1;
    }
    $sql_ext = " LIMIT " . $current_row . ", " . $page_size;
    $sql = $sql  . " " . $sql_ext;
    $result = mysql_query($sql);
    $numrow1 = mysql_num_rows($result);

    print "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  width=\"700\" align=\"center\">\n";
    print "<tr>\n";
    print "<td>\n";
    print "<div id=\"mainmenu_report_th\">\n";
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
    art_sitemenu_display("Report", "report_th");
    print "</td>\n";
    print "<td align=\"left\" class=\"siteMenuGap\">&nbsp;</td>\n";
    print "<td valign=\"top\">\n";
    print "<br />\n";
    print "<div id=\"report_th\">";
    print "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridTable\"  width=\"90%\">\n";
    print "    <tr>\n";
    print "        <td>\n";
    $gridtitle = "Report Log Book";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridHeader\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridHeaderBGLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridHeaderBG\" colspan=\"2\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" ><span class=\"gridHeaderText\">" . $gridtitle . "</span></td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                    <td class=\"gridHeaderBGRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridToolBar\" >\n";
    print "                <tr>\n";
    print "                    <td colspan=\"2\">\n";
    print "                        <table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
    print "                            <tr>\n";
    print "                                <td valign=\"baseline\" >";
    art_gridtoolbar_display($category);
    print "                                </td>\n";
    print "                                <td align=\"right\">\n";
    print "&nbsp;";
    print "                                </td>\n";
    print "                            </tr>\n";
    print "                        </table>\n";
    print "                    </td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridMain\" >\n";
    print "            <tbody>\n";
    print "                <tr>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">PELAYANAN</div></td>\n";
    print "                    <td class=\"gridColumn\" ><div class=\"gridColumnText\">JUMLAH</div></td>\n";
    print "                </tr>\n";
    print "            </tbody>\n";
    $emptydatatext = "No Record Found.";
    $layoutcolumn = 1;
    $icolumn = 0;
    $csscurrrow = "";
    $haveselectrow = false;
    $group = "";
    $currgroup = "no_group_selected";
    $gr_1 = 0;
    $gr_2 = 1;
    if ( ($numrows > 0) && ($result) ){
        $i = 1;
        while ($row = mysql_fetch_array($result)){ 
            $pagerecords = $i;
            $group = art_rowdata($row, -1);
            if (strcmp($group, $currgroup) != 0){
                $currgroup = $group;
                $gr_1++;
                if ($gr_1 != $gr_2){
                    print "            </tbody>\n";
                }
                print "            <tbody id=\"header_gr_". $gr_1 ."\">\n"; 
                print "                <tr>\n"; 
                print "                    <td colspan=\"2\" class=\"groupCaption\">\n"; 
                print "                    <div class=\"gridToolBarText\" align=\"left\">";
                print "<a href=\"javascript:art_toggle_groupdetail('"."gr_".$gr_1."','"."bt_collapse_".$gr_1."','"."bt_expand_".$gr_1."');\" title=\"" . CAP_CLOSE_GROUP . "\">";
                print "<img type=\"image\" id=\"bt_collapse_".$gr_1."\" src=\"images/defaultbutton/ic_collapse.gif\" style=\"display:'\" border=\"0\" align=\"absmiddle\" alt=\"" . CAP_CLOSE_GROUP . "\" ></a>\n";
                print "<a href=\"javascript:art_toggle_groupdetail('"."gr_".$gr_1."','"."bt_collapse_".$gr_1."','"."bt_expand_".$gr_1."');\" title=\"" . CAP_EXPAND_GROUP . "\">";
                print "<img type=\"image\" id=\"bt_expand_".$gr_1."\" src=\"images/defaultbutton/ic_expand.gif\" style=\"display:none\" border=\"0\" align=\"absmiddle\" alt=\"" . CAP_EXPAND_GROUP . "\" ></a>\n";
                print "&nbsp;" . $currgroup . "\n";
                print "                    </div>\n";
                print "                    </td>\n";
                print "                </tr>\n";
                print "            </tbody>\n";
                print "            <tbody id=\""."gr_".$gr_1."\" style=\"display:'';\">";
            }
            if (strtolower($csscurrrow) == "gridrow"){
                $csscurrrow = "gridRowAlternate";
            }else{
                $csscurrrow = "gridRow";
            }
            $cssrowover = "";
            $isrecmaster = false;
            if ($isrecmaster) {
                $haveselectrow = true;
                $cssrowover = "gridRowOver";
            }
            $cssrow = $csscurrrow;
            if ($cssrowover != "") {
                $cssrow = $cssrowover;
            }
            print "<tr class='".$cssrow."' >\n";
            print "<td align=\"left\" >";
            $svalue = art_check_null( art_rowdata($row, 0) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "<td align=\"center\" >";
            $svalue = art_check_null( number_format( art_rowdata($row, 1) , 0, '', ',' ) );
            if ($svalue != "&nbsp;"){
                $svalue = htmlspecialchars($svalue);
            }
            print $svalue;
            print "</td>\n";
            print "</tr>\n";

            $i++;
        }
    }else {
        print "                <tr class=\"gridRow\">\n";
        print "                    <td colspan=\"2\" ><div class=\"gridErrMsg\">" . $emptydatatext . "</div></td>\n";
        print "                </tr>\n";
    }
    print "            </table>\n";
    print "            <table  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"gridFooter\" >\n";
    print "                <tr>\n";
    print "                    <td class=\"gridFooterLeft\" nowrap >&nbsp;</td>\n";
    print "                    <td class=\"gridFooterBG\" colspan=\"2\">\n";
    if ( ($numrows > 0) && ($result) ) {
        if (isset($_SERVER["QUERY_STRING"])) {
            parse_str($_SERVER["QUERY_STRING"], $query_array);
            parse_str($_SERVER["QUERY_STRING"]."&page=1", $query_array);
            $querystr = art_remove_qrystring($query_array, "page, page_size, order1, order2, order3, sort1, sort2, sort3, clr");
        }
        $use_ajax = 1;
        $folder_button_images = "defaultbutton";
        if ($navtype != ""){
            $pagename = "Report";
            art_show_navigator($pagename, $navtype, $numrows, $page_size, $current_page, "Report_ajax.php", 1, 0, $use_ajax, $folder_button_images);
        }
    } else {
        print "                <table align=\"center\" width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"inside\">\n";
        print "                    <tr>\n";
        print "                        <td class=\"gridFooterText\" align=\"right\"></td>\n";
        print "                    </tr>\n";
        print "                </table>\n";
    }
    print "                    </td>\n";
    print "                    <td class=\"gridFooterRight\" nowrap >&nbsp;</td>\n";
    print "                </tr>\n";
    print "            </table>\n";
    print "        </td>\n";
    print "    </tr>\n";
    print "</table>\n";
    print "</div>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

    print "<input type=\"hidden\" name=\"artsys_pagerecords\" value=\"" . $pagerecords . "\" >\n";
    print "<input type=\"hidden\" name=\"artsys_postback\" value=\"1\" >\n";
    print "<br />\n"; 
}
?>
