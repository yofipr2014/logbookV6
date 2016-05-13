function art_toggle_groupdetail(divName,bt1,bt2){											
    if(document.getElementById(divName).style.display !='none'){
	    document.getElementById(divName).style.display = 'none';
		document.getElementById(bt1).style.display = 'none';	
		document.getElementById(bt2).style.display = '';	
	} else {
	    document.getElementById(divName).style.display = '';
		document.getElementById(bt1).style.display = '';	
		document.getElementById(bt2).style.display = 'none';								
	}			
}
		
function art_export_xls(AUrl) {			
    window.open(AUrl,"art_export_xls","location=1,status=1,scrollbars=1,width=500,height=400");
}
		
function art_export_pdf(AUrl) {			
    window.open(AUrl,"art_export_pdf","location=0,status=1,scrollbars=1,width=800,height=450");	
}	
		
function art_print_html(AUrl) {			
    window.open(AUrl,"art_print_html","location=0,status=1,scrollbars=1");	
}