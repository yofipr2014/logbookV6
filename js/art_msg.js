function startLoading() {   
	SetMessageDlgPos();	
	SetIframe();
    Element.show('ifrmSearch');
	Element.show('mainAreaLoading');
}

function finishLoading() {  	
	Element.hide('mainAreaLoading');
	Element.hide('ifrmSearch');
}

function getViewportHeight() {
	if (window.innerHeight!=window.undefined) return window.innerHeight;
	if (document.compatMode=='CSS1Compat') return document.documentElement.clientHeight;
	if (document.body) return document.body.clientHeight; 

	return window.undefined; 
}
function getViewportWidth() {
	var offset = 17;
	var width = null;
	if (window.innerWidth!=window.undefined) return window.innerWidth; 
	if (document.compatMode=='CSS1Compat') return document.documentElement.clientWidth; 
	if (document.body) return document.body.clientWidth; 
}

function getScrollTop() {
	if (self.pageYOffset) // all except Explorer
	{
		return self.pageYOffset;
	}
	else if (document.documentElement && document.documentElement.scrollTop)
		// Explorer 6 Strict
	{
		return document.documentElement.scrollTop;
	}
	else if (document.body) // all other Explorers
	{
		return document.body.scrollTop;
	}
}
function getScrollLeft() {
	if (self.pageXOffset) // all except Explorer
	{
		return self.pageXOffset;
	}
	else if (document.documentElement && document.documentElement.scrollLeft)
		// Explorer 6 Strict
	{
		return document.documentElement.scrollLeft;
	}
	else if (document.body) // all other Explorers
	{
		return document.body.scrollLeft;
	}
}

//Set iframe
function SetIframe() 
{
	 var W = 0, H = 0;
	 var objIfrm = document.getElementById("ifrmSearch");
	 W = getViewportWidth();
     H = getViewportHeight();
	 
	 objIfrm.style.width = (W - 20) + 'px';
	 objIfrm.style.height = (H - 20) + 'px';
}

// MessageDialog
function SetMessageDlgPos()
{ 
    var X = 0, Y = 0, W = 0, H = 0 , leftpos=0; 
	var blockstyleheight, blockstylewidth ;
	var blockheight =0, blockwidth =0 ;
    var objdiv = document.getElementById("loadingbg");
	var objloadingblock = document.getElementById("loadingblock"); 	
	var defaultBlockHeight = "450";
	var defaultBlockWidth   = "150";
	
    X = getScrollLeft();
    Y = getScrollTop();
    W = getViewportWidth();
    H = getViewportHeight();	

	blockstyleheight = getAttributeValue(objloadingblock, 'height');	
	blockstylewidth = getAttributeValue(objloadingblock, 'width');	

	// Check Height	
	if((blockstyleheight =="auto") || (blockstyleheight  == null ) ||
      (blockstyleheight =="inherit") || (blockstyleheight=="0px"))
	{		
		blockstyleheight = defaultBlockHeight;
	}
	
	// Check Width 
	if((blockstylewidth =="auto") || (blockstylewidth == null ) ||
      (blockstylewidth =="inherit") || (blockstylewidth =="0px"))
	{	
		blockstylewidth = defaultBlockWidth;			
	}	
	
	blockheight = parseInt(blockstyleheight);
	blockwidth = parseInt(blockstylewidth);
	
	if (blockstyleheight.match("%") == "%")
	{
		blockheight =    (H *  blockheight) / 100;
	}
	
	if (blockstylewidth.match("%") == "%")
	{
		blockwidth =    (W *  blockwidth) / 100;
	}
		
    objdiv.style.width = W + X + 'px';
	objdiv.style.height = Y + H + 'px';	
	leftpos = (W/2 + X) - (blockwidth/2);		

	objloadingblock.style.top = (Y + H/2 - 20) - (blockheight/2) + 'px';	
	objloadingblock.style.left = leftpos + 'px';	
	
	objloadingblock.style.height = blockheight + 'px';
	objloadingblock.style.width  = blockwidth + 'px';
}

function getAttributeValue(obj, property)
{
	var properyValue;
	if(document.defaultView && document.defaultView.getComputedStyle)
	{ 
		// If agent is Opera
		if(navigator.userAgent.indexOf("Opera") != -1 ){			
		properyValue = document.defaultView.getComputedStyle(obj, "").getPropertyValue(property); 						
			if(parseInt(properyValue) ==0){	properyValue = obj.currentStyle[property]; 	}			
		}else{
			properyValue = document.defaultView.getComputedStyle(obj, "").getPropertyValue(property); 
		}
	} 
	else if(obj.currentStyle)
	{  
		property = property.replace(/\-(\w)/g, function (strMatch, value){ 
		return value.toUpperCase();}); 
		properyValue = obj.currentStyle[property]; 
	} 
	return properyValue; 
}