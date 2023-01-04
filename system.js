function get(key, host = '', pkg, repo, branch = '', user, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                document.location.reload();
            }
        }
    }
    xmlhttp.open("GET","get.php?key="+key+"&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false);
    xmlhttp.send();
}

function getdir(key, host = '', pkg, repo, branch = '', user, bulk)
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if (bulk !== true) {
                document.location.reload();
            }
        }
    }
    xmlhttp.open("GET","getdir.php?key="+key+"&host="+host+"&pkg="+pkg+"&repo="+repo+"&branch="+branch+"&user="+user,false);
    xmlhttp.send();
}

function flip(x)
{
    return 1 - x;
}

function find()
{
    var q = search.value;
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            window.location.href = "?q="+q;
        }
    }
    xmlhttp.open("GET","?q="+q,false);
    xmlhttp.send();
}

function set(name, content, bulk)
{
    var dataString = 'name=' + name + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "set.php",
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
function change(name, to, bulk)
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
    xmlhttp.open("GET","change.php?name="+name+"&to="+to,false);
    xmlhttp.send();
}
function unset(name, bulk)
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
    xmlhttp.open("GET","unset.php?name="+name,false);
    xmlhttp.send();
}

function exch(i, o) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            window.location.reload();
        }
    }
    xmlhttp.open("GET","exch.php?i="+i+"&o="+o,false);
    xmlhttp.send();
}

function gen(ext, content, bulk)
{
    var dataString = 'ext=' + ext + '&content=' + content;
    $.ajax({
        type: "POST",
        url: "gen.php",
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
function wipe(part, from, sep, bulk)
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
    };
    xmlhttp.open("GET","wipe.php?part="+part+"&from="+from+"&sep="+sep,false);
    xmlhttp.send();
}
function spread()
{
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            window.location.reload();
        }
    };
    xmlhttp.open("GET","spread.php",false);
    xmlhttp.send();
}
