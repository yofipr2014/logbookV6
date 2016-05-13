<?php
$field_names = array (
    "pelayanan.nm_pelayanan"
    ,"JUMLAH"
);

$current_page = "";
$page_size = art_session("Report_page_size", "20");
$page = art_session("Report_page", "1");
$quick_search = art_session("Report_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("Report_err_string", "");
$pagestyle = art_request("Report_pagestyle", "");
$navtype = "text";
$artsv_act_search = trim(art_request("btn_search", ""));
$artsv_quick_search = art_request("artsys_quick_search", "");
?>
