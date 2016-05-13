<?php
if (session_id() == ""){
    session_start();
}
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './User_func.php';
require_once "./user_login_func.php";
art_check_permission(1, "./report.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Report</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="icon" href="./images/favicon.ico" type="image/x-icon">
<link href="./css/globalcss.css" rel="stylesheet" type="text/css">
<link href="./css/report_th.css" rel="stylesheet" type="text/css">
<link href="./css/loadingmsg.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="./js/prototype.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_ajax.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_msg.js"></script>
<script language="javascript" type="text/javascript" src="./js/art_general.js"></script>
</head>
<body>
   
<iframe id="ifrmSearch" frameborder="0" style="position: absolute; filter: progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0);
display: none; width: 100%; height: 100%; z-index: 999;" scrolling="no"></iframe>
<div id="mainAreaLoading" style="display: None;">
<div id="loadingbg" class="MaskLoadingBG">
</div>
<div style="z-index: 99;  position: absolute;" id="invisiblediv";>
    <table width="100%">
        <tr>
            <td valign="top" align="center" valign="middle" >
                <div class="LoadingBlock" id="loadingblock">
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td valign="middle" align="center" >
                                <img src="images/ajaxloading.gif" align="absmiddle" border="0" />
                                <font class="LoadingBlockText">Sedang Proses...</font>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td>
            <form name="art_form" id="art_form" method="post" action="report_admin.php" style="margin: 0px; padding: 0px;">
            <div id="art_ajaxpanel1">
                <table cellpadding="0" cellspacing="0" border="0"  width="800" align="center">
<tr>
<td>
<div id="mainmenu_report_th">
<table cellpadding="0" cellspacing="0" border="0"  width="100%">
    <tr>
    <td colspan="3" valign="top" class="mainMenuBG" >
        <table align="right"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
<a href="./user_logout.php" title="Logout" class="mainMenuLink"><div><p>Logout</p></div></a>                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
</div>
<table width="100%" cellpadding="0" cellspacing="1" border="0">
<tr>
<td width="1" rowspan="2" align="left" valign="top">
<div id="sitemenu_report_th"><br /><table border="0" cellspacing="0" cellpadding="0"  width="150px">
    <tr>
        <td class="siteMenuHeaderBGLeft" nowrap >&nbsp;</td>
        <td class="siteMenuHeaderBG"><span class="siteMenuHeaderText">Site Menu</span></td>
        <td class="siteMenuHeaderBGRight" nowrap >&nbsp;</td>
    </tr>
    <tr>
        <td class="siteMenuColumnBGLeft">&nbsp;</td>
        <td valign="middle" class="siteMenuBody">
             <div class="siteMenu">
             <ul>
                 <li><a href="./user.php?clr_user=t&clr_user_adv_session=y" title="user">user</a></li>
                 <li class="siteMenuSelected">report</li>
             </ul>
             </div>
        </td>
        <td class="siteMenuColumnBGRight">&nbsp;</td>
    </tr>
    <tr>
        <td class="siteMenuFooter"></td>
        <td class="siteMenuFooter"></td>
        <td class="siteMenuFooter"></td>
    </tr>
</table>
</div></td>
<td align="left" class="siteMenuGap">&nbsp;</td>
<td align="center" valign="top" class="siteMenuGap"></td>
</tr>
<tr>
<td align="left">&nbsp;</td>
<td align="left">
<div id="report_th"><table border="1" cellpadding="0" cellspacing="0" class="gridTable"  width="100%">
    <tr>
        <td align="center">
		   <form id="form1" name="form1" method="post" action="?proses=cetak">
Periode :

<select name="bln1" id="bln1">
 
<?php 
   //require_once './includes/art_config.php';
   //require_once './includes/art_db.php';
   //session_start();
   $nm_dokter=$_SESSION['art_nm_dokter'];
   $bln1=$_POST['bln1'];
   $thn1=$_POST['thn1'];
   $tgl=$thn1."-".$bln1;
   if($bln1=="01"){   
    echo "<option value='01' selected >Januari</option>";
   }
   else{
    echo "<option value='01'>Januari</option>";
   }
   if($bln1=="02"){   
    echo "<option value='02' selected >Februari</option>";
   }
   else{
    echo "<option value='02'>Februari</option>";
   }
   if($bln1=="03"){   
    echo "<option value='03' selected >Maret</option>";
   }
   else{
    echo "<option value='03'>Maret</option>";
   }
   if($bln1=="04"){   
    echo "<option value='04' selected >April</option>";
   }
   else{
    echo "<option value='04'>April</option>";
   }
   if($bln1=="05"){   
    echo "<option value='05' selected >Mei</option>";
   }
   else{
    echo "<option value='05'>Mei</option>";
   }
   if($bln1=="06"){   
    echo "<option value='06' selected >Juni</option>";
   }
   else{
    echo "<option value='06'>Juni</option>";
   }
   if($bln1=="07"){   
    echo "<option value='07' selected >Juli</option>";
   }
   else{
    echo "<option value='07'>Juli</option>";
   }
   if($bln1=="08"){   
    echo "<option value='08' selected >Agustus</option>";
   }
   else{
    echo "<option value='08'>Agustus</option>";
   }
   if($bln1=="09"){   
    echo "<option value='09' selected >September</option>";
   }
   else{
    echo "<option value='09'>September</option>";
   }
   if($bln1=="10"){   
    echo "<option value='10' selected >Oktober</option>";
   }
   else{
    echo "<option value='10'>Oktober</option>";
   }
   if($bln1=="11"){   
    echo "<option value='11' selected >November</option>";
   }
   else{
    echo "<option value='11'>November</option>";
   }
   if($bln1=="12"){   
    echo "<option value='12' selected >Desember</option>";
   }
   else{
    echo "<option value='12'>Desember</option>";
   }
?>

</select>
<select name="thn1" id="thn1">
<?php for($i=2016;$i<=date("Y");$i++){ ?>
<option><?php echo $i;?></option>
<?php } ?>
</select>

<input type="submit" name="Submit" value="Tampilkan" />
</form>
</td></tr>
</table>
		
		
		
            <table border="0" cellpadding="0" cellspacing="0" class="gridHeader" >
                <tr>
                    <td class="gridHeaderBGLeft" nowrap >&nbsp;</td>
                    <td class="gridHeaderBG" colspan="2">
                        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align = "center" valign="baseline" ><span class="gridHeaderText"><?php echo $nm_dokter;?></span></td>
                            </tr>
                        </table>
                    </td>
                    <td class="gridHeaderBGRight" nowrap >&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="gridToolBar" >
                <tr>
                    <td colspan="2">
                        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td valign="baseline" ><table border="1" cellpadding="0" cellspacing="0">
    <!--<tr>
        <td>
<a href="javascript:art_export_pdf( 'http://localhost/logbookv6/Report_dialog_pdf.php' );" title="Export to PDF"><img src="images/defaultbutton/pdf.gif" border="0" align="absmiddle" ></a>
<a href="javascript:art_export_xls( 'http://localhost/logbookv6/Report_export_xls.php' );" title="Export to XLS"><img src="images/defaultbutton/xls.gif" border="0" align="absmiddle" ></a>
        </td>
    </tr>-->
</table>
                                </td>
                                <td align="right">
&nbsp;                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="gridMain" >
                <tr>
				    <td class="gridColumn"  NOWRAP >
                        <div class="gridColumnText">
                            <a class="gridColumnText">NO.</a>
                        </div>
                    </td>
                    <td class="gridColumn"  NOWRAP >
                        <div class="gridColumnText">
                            <a class="gridColumnText">DOKTER</a>
                        </div>
                    </td>
					<td class="gridColumn"  NOWRAP >
                        <div class="gridColumnText">
                            <a class="gridColumnText">PELAYANAN</a>
                        </div>
                    </td>
                    <td class="gridColumn"  NOWRAP >
                        <div class="gridColumnText">
                            <a class="gridColumnText">JUMLAH</a>
                        </div>
                    </td>
                </tr>
<?php

$uid=$_SESSION['art_user_name'];
$ambildata=mysql_query("SELECT DISTINCT
(useraccounts.nm_dokter) AS `NAMA DOKTER`,
pelayanan.nm_pelayanan AS PELAYANAN, 
  
  COUNT(logbook.id) AS JUMLAH
FROM
  logbook
  LEFT JOIN pelayanan ON (logbook.id_pel = pelayanan.id_pel)
  LEFT JOIN useraccounts ON (logbook.uid = useraccounts.username)
WHERE TGL LIKE '$tgl%'
  GROUP BY
  `NAMA DOKTER`,
  pelayanan.nm_pelayanan");
$cekdata=mysql_num_rows($ambildata);
if(!isset($proses)){
	if ($cekdata==0){
      echo "<h5 align='center'>No Record Found";
	}
}
$i=1;
$prev_nm_dokter=false;
while($cetakdata=mysql_fetch_array($ambildata)){
?>
<tr class='gridRow' >
<td align="center" ><?php echo $i;?></td>
<?php 

   if ($prev_nm_dokter == $cetakdata['NAMA DOKTER']){
	 echo "<td align='center'></td>";
	 $prev_nm_dokter='';
   }
   else{?>
	  <td align="center"><b><?php echo $cetakdata['NAMA DOKTER'];?></b></td>
	  <?php //$prev_nm_dokter = $cetakdata['NAMA DOKTER'];
   }
?>

<td align="center" ><?php echo $cetakdata['PELAYANAN'];?></td>
<td align="center" ><?php echo $cetakdata['JUMLAH'];?></td>

<?php 
  $prev_nm_dokter = $cetakdata['NAMA DOKTER'];
  $i++;
?>
</tr>
<?php } ?>				
            </table>
            <table  border="0" cellpadding="0" cellspacing="0" class="gridFooter" >
                <tr>
                    <td class="gridFooterLeft" nowrap >&nbsp;</td>
                    <td class="gridFooterBG" colspan="2">
<table width="100%" height="100%" border="0"  align="center" cellpadding="2" cellspacing="0" class="inside"><tr>
<td class="gridPagingText" align="left"></td>
<td class="gridPagingText" align="right"><font class="gridPaging"></font>
<font class="gridPaging"></font>
<font class="gridPagingSelected"></font><font class="gridPaging"></font>
<font class="gridPaging"></font>
<br />
</td>
</tr>
</table>
                    </td>
                    <td class="gridFooterRight" nowrap >&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<input type="hidden" name="artsys_pagerecords" value="5" >
<input type="hidden" name="artsys_postback" value="1" >
<br />
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