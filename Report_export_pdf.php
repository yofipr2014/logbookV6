<?php
require_once './includes/art_config.php';
require_once './includes/art_db.php';
require_once './includes/art_functions.php';
require_once './languages/art_lang.php';
require_once './components/fpdf/fpdf.php';

class PDF extends FPDF {
    var $headerset = array();
    var $footerset = array();
    var $resultset;
    var $field_indexs;
    var $col_titles;
    var $col_widths;
    var $col_align;
    var $col_count;
    var $hcolor_rgb;
    var $hfcolor_rgb;
    var $bgfcolor_rgb;
    var $bgcolor1_rgb;
    var $bgcolor2_rgb;
    var $show_border;
    var $row_height;

    function _beginpage($orientation){
        $this->page++;
        if((!array_key_exists($this->page, $this->pages)) || (!$this->pages[$this->page]))
            $this->pages[$this->page]='';
        $this->state=2;
        $this->x=$this->lMargin;
        $this->y=$this->tMargin;
        $this->lasth=0;
        $this->FontFamily='';
        if(!$orientation)
            $orientation=$this->DefOrientation;
        else
        {
            $orientation=strtoupper($orientation{0});
            if($orientation!=$this->DefOrientation)
                $this->OrientationChanges[$this->page]=true;
        }
        if($orientation!=$this->CurOrientation){
            if($orientation=='P'){
                $this->wPt=$this->fwPt;
                $this->hPt=$this->fhPt;
                $this->w=$this->fw;
                $this->h=$this->fh;
            }else{
                $this->wPt=$this->fhPt;
                $this->hPt=$this->fwPt;
                $this->w=$this->fh;
                $this->h=$this->fw;
            }
            $this->PageBreakTrigger=$this->h-$this->bMargin;
            $this->CurOrientation=$orientation;
        }
    }

    function Header(){
        global $maxY;
        $fullwidth = 0;
        if((!array_key_exists($this->page, $this->headerset)) || (!$this->headerset[$this->page])){
            foreach($this->col_widths as $width){
                $fullwidth += $width;
            }
            $this->SetY(($this->tMargin) - ($this->FontSizePt/$this->k)*2);
            $l = ($this->lMargin);
            foreach($this->col_titles as $col => $txt){
                $this->SetXY($l,($this->tMargin));
                $this->MultiCell($this->col_widths[$col], $this->FontSizePt,$txt);
                $l += $this->col_widths[$col];
                $maxY = ($maxY < $this->getY()) ? $this->getY() : $maxY;
            }
            $this->SetXY($this->lMargin,$this->tMargin);
            $this->SetTextColor($this->hfcolor_rgb['R'],$this->hfcolor_rgb['G'],$this->hfcolor_rgb['B']);
            $this->SetFillColor($this->hcolor_rgb['R'],$this->hcolor_rgb['G'],$this->hcolor_rgb['B']);
            $this->SetFont('','B');
            $l = ($this->lMargin);
            foreach($this->col_titles as $col => $txt){
                $this->SetXY($l,$this->tMargin);
                $this->Cell($this->col_widths[$col],$maxY-($this->tMargin),'',$this->show_border,0,'L',1);
                $this->SetXY($l,$this->tMargin);
                $this->MultiCell($this->col_widths[$col],$this->FontSizePt,$txt,0,'C');
                $l += $this->col_widths[$col];
            }
            $this->SetFillColor(255,255,255);
            $this->headerset[$this->page] = 1;
        }
        $this->SetY($maxY);
    }

    function Footer(){
        if((!array_key_exists($this->page, $this->footerset))  || (!$this->footerset[$this->page])){
            $this->SetY(-15);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            $this->footerset[$this->page] = 1;
        }
    }

    function genAllPages($row_height){
        $pageheight = array();
        $fullwidth = 0;
        $maxpage = 0;
        $this->row_height = $row_height;
        $l = $this->lMargin;
        $startheight = $h = $this->GetY();
        $startpage = $currpage = $this->page;
        foreach($this->col_widths as $width){
            $fullwidth += $width;
        }
        $this->SetTextColor($this->bgfcolor_rgb['R'],$this->bgfcolor_rgb['G'],$this->bgfcolor_rgb['B']);
        $this->SetFont('');
        $bg = 0;
        $row = 0;
        $old_x = 0;
        $old_y = 0;
        $old_w = 0;
        $rowh = 0;
        while($data=mysql_fetch_array($this->resultset)){
            $this->page = $currpage;
            $old_y = $h;
            $old_w = $fullwidth;
            if($bg==0){
                $bg=1;
                $this->SetFillColor($this->bgcolor1_rgb['R'],$this->bgcolor1_rgb['G'],$this->bgcolor1_rgb['B']);
            }else {
                $bg=0;
                $this->SetFillColor($this->bgcolor2_rgb['R'],$this->bgcolor2_rgb['G'],$this->bgcolor2_rgb['B']);
            }
            for ($col = 0; $col < $this->col_count; $col++){
                $txt = art_rowdata($data, $this->field_indexs[$col]);
                $this->page = $currpage;
                $this->SetXY($l,$h);
                $this->MultiCell($this->col_widths[$col],$row_height,$txt,0,$this->col_align[$col]);
                $l += $this->col_widths[$col];
                if (!array_key_exists($this->page,$pageheight)){
                    $pageheight[$this->page] = 0;
                }
                if($pageheight[$this->page] < $this->GetY()){
                    $pageheight[$this->page] = $this->GetY();
                }
                if ($this->page > $currpage){
                    if ($pageheight[$currpage] < ($this->h - $this->bMargin - $this->row_height))
                        $pageheight[$currpage] =  $this->h - $this->bMargin;
                }
                if($this->page > $maxpage)
                    $maxpage = $this->page;
            }
            $l = $this->lMargin;
            if ($maxpage != $currpage){
                $this->page = $currpage;
                $rowh = $pageheight[$currpage];
                $old_yy = $old_y;
                if ($old_y > $rowh){
                    $old_yy = $startheight;
                }
                $this->Rect($l, $old_yy, $old_w, $rowh -  $old_yy, "F");
                if ($this->show_border)
                    $this->Line($l,$old_yy,$fullwidth+$l,$old_yy);
            }
            $this->page = $maxpage;
            $rowh = $pageheight[$maxpage];
            if  ($old_y > $rowh){
                $old_y = $startheight;
            }
            $this->Rect($l, $old_y, $old_w, $rowh -  $old_y, "F");
            if ($this->show_border)
                $this->Line($l,$old_y,$fullwidth+$l,$old_y);
            for ($col = 0; $col < $this->col_count; $col++){
                $txt = art_rowdata($data, $this->field_indexs[$col]);
                $this->page = $currpage;
                $this->SetXY($l,$h);
                $this->MultiCell($this->col_widths[$col],$row_height,$txt,0,$this->col_align[$col]);
                $l += $this->col_widths[$col];
            }
            $h = $rowh;
            $l = $this->lMargin;
            if ($this->show_border)
            $this->Line($l,$h,$fullwidth+$l,$h);
            $currpage = $maxpage;
            $row++ ;
        }
        $this->page = $maxpage;
        for($i = $startpage; $i <= $maxpage; $i++){
            $this->page = $i;
            $l = $this->lMargin;
            $t = ($i == $startpage) ? $startheight : $this->tMargin;
            $lh = $pageheight[$i];
            if ($this->show_border)
            $this->Line($l,$t,$l,$lh);
            foreach($this->col_widths as $width) {
                $l += $width;
                if ($this->show_border)
                $this->Line($l,$t,$l,$lh);
            }
        }
        $this->page = $maxpage;
    }

    function generateTable(){
        $totAlreadyFitted = 0;
        $this->col_count = count($this->col_titles);
        $this->Open();
        $this->setY($this->tMargin);
        $this->AddPage();
        $this->genAllPages($this->FontSizePt);
    }
}

function getRGB($htmlcolor){
    $color = array();
    $color['R']=255;
    $color['G']=255;
    $color['B']=255;
    if ($htmlcolor{0} == '#'){
        $R=hexdec(substr($htmlcolor,1,2));
        $G=hexdec(substr($htmlcolor,3,2));
        $B=hexdec(substr($htmlcolor,5,2));
        $color = array();
        $color['R']=$R;
        $color['G']=$G;
        $color['B']=$B;
    }
    return $color;
}

$style = art_request("style", "0");
$hcolor = art_request("hcolor", "");
$hfcolor = art_request("hfcolor", "");
$bgfcolor = art_request("bgfcolor", "");
$bgcolor1 = art_request("bgcolor1", "");
$bgcolor2 = art_request("bgcolor2", "");
$border = art_request("border", "");

if($style=="0"){
    $hcolor = "#C1C1C1";
    $hfcolor = "#000000";
    $bgfcolor = "#000000";
    $bgcolor1 = "#DADADA";
    $bgcolor2 = "#F6F6F6";
    $border = "1";
}

$pdf=new PDF('P','mm','A4');
$pdf->hcolor_rgb = getRGB($hcolor);
$pdf->hfcolor_rgb = getRGB($hfcolor);
$pdf->bgfcolor_rgb = getRGB($bgfcolor);
$pdf->bgcolor1_rgb = getRGB($bgcolor1);
$pdf->bgcolor2_rgb = getRGB($bgcolor2);
session_start();
$uid=$_SESSION['art_user_name'];
$sqlexport = "SELECT 
  pelayanan.nm_pelayanan AS PELAYANAN,
  COUNT(logbook.id) AS JUMLAH
FROM
  logbook
  RIGHT JOIN pelayanan ON (logbook.id_pel = pelayanan.id_pel)
WHERE uid = '$uid'
GROUP BY
  pelayanan.nm_pelayanan";
$pdf->resultset = mysql_query($sqlexport);
$pdf->field_indexs = array(0,1);
$pdf->col_titles = array('PELAYANAN','JUMLAH');
$pdf->col_widths = array('25','25');
$pdf->col_align = array('L','C');
$pdf->show_border = $border;
$pdf->SetFont('Arial','',8);
$pdf->AliasNbPages();
$pdf->generateTable();
$pdf->Output();
?>
