<?php
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';

function xlsBOF(){
    print pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return; 
}

function xlsEOF() { 
    print pack("ss", 0x0A, 0x00);
    return; 
}

function xlsWriteNumber($Row, $Col, $Value){
    print pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
    print pack("d", $Value); 
    return; 
}

function xlsWriteLabel($Row, $Col, $Value ){
    $L = strlen($Value); 
    print pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
    print $Value; 
    return;
}

$dbname = $config_db;
$sqlexport = "select * from `logbook`";
$resultexport = mysql_query($sqlexport);

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=exportdata.xls "); 
header("Content-Transfer-Encoding: binary ");

xlsBOF(); 
xlsWriteLabel(1,0,"Logbook");
xlsWriteLabel(2, 0, "NO. RM");
xlsWriteLabel(2, 1, "KETERANGAN");

$i = 0;
$xlsRow = 3;
while($rowexport = mysql_fetch_array($resultexport)){
    $i++;
    xlsWriteLabel($xlsRow, 0, art_rowdata($rowexport, 1));
    xlsWriteLabel($xlsRow, 1, art_rowdata($rowexport, 3));
    $xlsRow++;
}

xlsEOF();
exit();
?>
