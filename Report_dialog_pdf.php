<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Export to PDF</title>
<meta name="generator" content="ScriptArtist v3">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="./css/report_th.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="components/yui/utilities/utilities.js" ></script> 
<script type="text/javascript" src="components/yui/slider/slider-min.js" ></script> 
<script type="text/javascript" src="components/yui/colorpicker/colorpicker-min.js" ></script>
<script type="text/javascript" src="js/ddcolorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="components/yui/colorpicker/assets/skins/sam/colorpicker.css"> 
<script type="text/javascript" src="components/windowfiles/dhtmlwindow.js"></script>
<link rel="stylesheet" type="text/css" href="components/windowfiles/dhtmlwindow.css" />
<script language="javascript" type="text/javascript">
    function disabled_dialog(divName, act){										
		    document.getElementById(divName).style.display = '' + act;
		}

    function init() {
		    document.getElementById('style1').checked = true;
		    document.getElementById('coloredTable').style.display = 'none';
		}
</script>
<style type="text/css">
* html .yui-picker-bg{ /*Requires CSS. Do not edit/ remove*/
filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='components/yui/colorpicker/assets/skins/sam/picker_mask.png',sizingMethod='scale');
}

.colorpreview{
border: 1px solid black;
padding: 1px 10px;
cursor: hand;
cursor: pointer;
}

.gridRowPDF td{
text-decoration: none;
background-color: #FFFFFF;
height: 25px;
border-bottom: 1px solid #CCCCCC;
}

form div{
margin-bottom: 5px;
}

</style>

</head>
<body onLoad="init();">
<br>
	<form action="Report_export_pdf.php" method="post" name="frm" target="_blank" style="margin: 0px; padding: 0px;">
        <div id="report_th">
        <table cellspacing="0" cellpadding="0" border="0" class="gridTable" align="center">
          <tr>
            <td>
            <table cellspacing="0" cellpadding="0" border="0" class="gridHeader">
                <tr>
                    <td class="gridHeaderBGLeft">&nbsp;</td>
                    <td class="gridHeaderBG"><span class="gridHeaderText">Set PDF Table</span></td>
                    <td class="gridHeaderBGRight">&nbsp;</td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="0" border="0" class="gridMain" align="center">
                <tr class="gridRowPDF">
                    <td width="25%" align="right">&nbsp;Select Table Style: </td>
                    <td><label><input type="radio" name="style" id="style1" value="0" onClick="javascript:disabled_dialog('coloredTable','none');" >              
        GrayScale
                    </label></td>
                </tr>
                <tr class="gridRowPDF">
                    <td width="25%">&nbsp;</td>
                    <td><label><input type="radio" name="style" id="style2" value="1" onClick="javascript:disabled_dialog('coloredTable','');">
                      Color
                    </label></td>
                </tr> 
            </table>
                                  
            <table cellspacing="0" cellpadding="0" border="0" class="gridMain" align="center">                       
            <tbody id="coloredTable" style="display:'none'">                
                <tr>				
                        <td colspan="2" align="left">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                  <td width="25%" align="right">Header Background Color:</td>
                                  <td>
                                  &nbsp;&nbsp;<input type="text" id="hcolor" name="hcolor" value="#FFCC00" size="10" maxlength="7" >
                                  <span id="control1" class="colorpreview">&nbsp;</span></td>
                              </tr>
                              <tr>
                                  <td width="25%" align="right">Header Font Color: </td>
                                  <td>
                                  	&nbsp;&nbsp;<input type="text" id="hfcolor" name="hfcolor" value="#333333" size="10" maxlength="7">
                                  	<span id="control2" class="colorpreview">&nbsp;</span>
                                  </td>
                              </tr>
                                <tr>
                                    <td align="right">Odd Row Color: </td>
                                    <td>
                                    	&nbsp;&nbsp;<input type="text" id="bgcolor1" name="bgcolor1" value="#FEF8E0" size="10" maxlength="7">
                                    	<span id="control3" class="colorpreview">&nbsp;</span>    
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Even Row Color: </td>
                                    <td>
                                    	&nbsp;&nbsp;<input type="text" id="bgcolor2" name="bgcolor2" value="#FEE996" size="10" maxlength="7">
                                    	<span id="control4" class="colorpreview">&nbsp;</span>    
                                    </td>
                                </tr>
                                <tr>
                                    <td width="30%" align="right">Data Font Color: </td>
                                    <td>
                                    	&nbsp;&nbsp;<input type="text" id="bgfcolor" name="bgfcolor" value="#333333" size="10" maxlength="7">
                                    	<span id="control5" class="colorpreview">&nbsp;</span>
                                    </td>
                              </tr>
                                <tr>
                                    <td align="right">Show Border: </td>
                                    <td>
                                        &nbsp;&nbsp;<input type="radio" id="border" name="border" value="1" checked>Yes
                                        <input type="radio" id="border" name="border" value="0">No                            </td>
                                </tr>
                            </table>                </td>
                 </tr> 
                </tbody> 
                <tr class="gridRowPDF">
                    <td colspan="2">&nbsp;</td>
                </tr>   
                <tr class="gridRowPDF">
                    <td width="38%">&nbsp;</td>
                    <td width="62%" >
                      <input type="submit" name="submit" value="Save" class="button">
                      <input type="reset" name="cancel" value="Cancel" class="button" onClick="window.close();" >            
                    </td>
                </tr>
            </table>
            </td>
          </tr>
        </table>
        </div>
        <div id="ddcolorwidget">
        Please choose a color:
        <div id="ddcolorpicker" style="position:relative; height:205px"></div>
        </div>
    </form>
<script type="text/javascript">
ddcolorpicker.init({
	colorcontainer: ['ddcolorwidget', 'ddcolorpicker'],
	displaymode: 'float',
	floatattributes: ['Color Picker', 'width=390px,height=250px,resize=1,scrolling=1,center=1'],
	fields: ['hcolor:control1','hfcolor:control2','bgcolor1:control3','bgcolor2:control4','bgfcolor:control5']
})
</script>
</body>
</html>
