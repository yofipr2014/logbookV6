<?php
$field_names = array (
    "useraccounts.username"
    ,"useraccounts.password"
    ,"useraccounts.nm_dokter"
    ,"ksm.nm_ksm"
);

$current_page = "";
$page_size = art_session("User_page_size", "20");
$page = art_session("User_page", "1");
$quick_search = art_session("User_quick_search", "");
$category = "";
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("User_err_string", "");
$pagestyle = art_request("User_pagestyle", "");
$navtype = "text";
?>
