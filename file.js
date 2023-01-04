function write(name, content, bulk)
{
    var dataString = 'name=' + name + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "write.php",
        data: dataString,
        cache: false,
        success: function(html) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    });
    return false;
}
function del(name, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","delete.php?name="+name,false);
    xmlhttp.send();
}
function mkdir(name, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","mkdir.php?name="+name,false);
    xmlhttp.send();
}
function move(name, to, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","move.php?name="+name+"&to="+to,false);
    xmlhttp.send();
}
function copy(name, to, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","copy.php?name="+name+"&to="+to,false);
    xmlhttp.send();
}

function hash(key, name, data = '', bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","hash.php?key="+key+"&name="+name+"&data="+data,false);
    xmlhttp.send();
}
function base64(key, input, output, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    }
    xmlhttp.open("GET","base64.php?key="+key+"&input="+input+"&output="+output,false);
    xmlhttp.send();
}

function save()
{
    var name = filename.value;
    var content = encodeURIComponent(document.getElementById('content').value);
    var dataString = 'name=' + name + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "write.php",
        data: dataString,
        cache: false,
        success: function(html) {
            document.location.reload();
        }
    });
    return false;
}

function levelUp(dir)
{
    if (dir.toString('').includes('/')) {
        var split = dir.toString('').split('/');
        var count = split.length;
        var last = count - 1;
        var link = dir.toString('').replace('/' + split[last], '');
    } else {
        var link = dir;
    }
    window.location.href = '?dir=' + link;
}
function fileSearch()
{
    var dir = search.name;
    var q = search.value;
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            window.location.href = "?dir="+dir+"&q="+q;
        }
    }
    xmlhttp.open("GET","?dir="+dir+"&q="+q,false);
    xmlhttp.send();
}

function operate(action, path, className, objName, input, bulk)
{
    var dataString = 'action=' + action + '&path=' + path + '&class=' + className + '&name=' + objName + '&input=' + input;
    $.ajax({
        type: "POST",
        url: "object.php",
        data: dataString,
        cache: false,
        success: function(html) {
            if (bulk !== true) {
                window.location.reload();
            }
        }
    });
    return false;
}
