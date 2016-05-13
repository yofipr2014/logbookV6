function art_call_ajax(url){
    var pars = '';
    var target = 'art_ajaxpanel1';
    if (url.indexOf("?") == -1)
    {
	       url = url + '?no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else if (url.indexOf("?") == (url.length - 1))
    {
	       url = url + 'no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else
    {
	       url = url.replace("?", '?no-cache=' + Math.floor( Math.random() * 1000 ) + '&');
    }
    startLoading();
    var updater = new Ajax.Updater(target, url, {evalScripts:true, method: 'get',	parameters: pars});
    setTimeout('finishLoading();', 1000);
}

function art_form_submit(sender, use_ajax, url){
    if (use_ajax == 0) {
        sender.form.submit();
    }
    else
    {
    var pars = Form.serialize(sender.form);
    var target = 'art_ajaxpanel1';
    if (url.indexOf("?") == -1)
    {
	       url = url + '?aj=1&no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else if (url.indexOf("?") == (url.length - 1))
    {
	       url = url + 'aj=1&no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else
    {
	       url = url.replace("?", '?aj=1&no-cache=' + Math.floor( Math.random() * 1000 ) + '&');
    }
    startLoading();
    var updater = new Ajax.Updater(target, url, {evalScripts:true, method: 'get', parameters: pars});
    setTimeout('finishLoading();', 1000);
	}
}

function art_confirm_delete(){
    return confirm("Do you want to delete the selected item(s)?");
}

var highlightbehavior = "TR";
var ns6 = document.getElementById&&!document.all;
var ie = document.all;
var nums;
function art_rowover(e, highlightcolor ,selectedColor){
    source=ie? event.srcElement : e.target
    if (source.tagName == "TABLE"){return;}
    while(source.tagName != highlightbehavior && source.tagName != "HTML")
    {
        source=ns6? source.parentNode : source.parentElement;
    }
    if(source.className == selectedColor)
    {
        source.className = selectedColor;
    }
    else
    {
        source.className = highlightcolor;
    }
}

function contains_ns6(master, slave) {
    while (slave.parentNode)
        if ((slave = slave.parentNode) == master)
            return true;
    return false;
}

function art_rowout(e, originalcolor ,selectedColor){
    if (ie&&(event.fromElement.contains(event.toElement)||source.contains(event.toElement)||source.id=="ignore")||source.tagName=="TABLE")
        return
    else if (ns6&&(contains_ns6(source, e.relatedTarget)||source.id=="ignore"))
        return
    if (ie&&event.toElement!=source||ns6&&e.relatedTarget!=source)
    {
        if(source.className == selectedColor)
        {
            source.className = selectedColor;
        }
        else
        {
            source.className = originalcolor
        }
    }
}

function art_selected_row(e,originalColor, selectedColor){
    source=ie? event.srcElement : e.target;
    if (source.tagName=="TABLE")
        return
    while(source.tagName!=highlightbehavior && source.tagName!="HTML")
        source=ns6? source.parentNode : source.parentElement

    if(source.className == selectedColor){
        source.className = originalColor;
    }
    else
    {
        source.className = selectedColor;
    }
}

function art_change_mastervalue(e, originalColor, selectedColor, masterID, masterValue, formID , url, target){
    source=ie? event.srcElement : e.target;
    if(source.className == selectedColor)
    {
        source.className = originalColor;
    }
    else
    {
        source.className = selectedColor;
    }
    len = masterID.length;
    for (var i=0;  i<len ; ++i){
        var masterObj = document.getElementById(masterID[i]);
        masterObj.value = masterValue[i];
    }
    if (url.indexOf("?") == -1)
    {
	       url = url + '?no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else if (url.indexOf("?") == (url.length - 1))
    {
	       url = url + 'no-cache=' + Math.floor( Math.random() * 1000 );
    }
    else
    {
	       url = url.replace("?", '?no-cache=' + Math.floor( Math.random() * 1000 ) + '&');
    }
    var pars = Form.serialize(formID);
    var updater = new Ajax.Updater(target, url, {evalScripts:true, method: 'get', parameters: pars});
}

