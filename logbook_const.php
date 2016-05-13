<?php
$field_names = array (
    "logbook.id"
    ,"logbook.no_rm"
    ,"logbook.tgl"
    ,"logbook.ket"
    ,"logbook.id_pel"
    ,"logbook.uid"
);

$current_page = "";
$page_size = art_session("logbook_page_size", "20");
$page = art_session("logbook_page", "1");
$quick_search = art_session("logbook_quick_search", "");
$old_category = art_session("logbook_category", "");
art_assign_session("logbook_category", "");
if ($old_category != art_session("logbook_category", "")){
    art_set_session("logbook_page", "1");
    $page = art_session("logbook_page", "1");
}
$category = art_session("logbook_category", "");
art_assign_session("artsys_pagerecords", "");
$artsv_pagerecords = art_session("artsys_pagerecords", "");
$artsv_postback = art_request("artsys_postback", "");
$err_string = art_request("logbook_err_string", "");
$pagestyle = art_request("logbook_pagestyle", "");
$navtype = "text";
$artsv_act_search = trim(art_request("btn_search", ""));
$artsv_quick_search = art_request("artsys_quick_search", "");
?>
