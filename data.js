function calculate() {
    var input = document.getElementById('calc').value;
    document.getElementById('inputPanel').value = input;
    var calc = input;
    if (calc.includes('x')) {
        var solve = nerdamer.solve(calc, 'x');
        var result = eval(solve);
    } else if (calc.includes('?')) {
        var expdel = calc.split('?');
        var leftpart = eval(expdel[0]);
        var rightpart = eval(expdel[1]);
        if (leftpart > rightpart) {
            var result = leftpart + '>' + rightpart;
        } else if (leftpart < rightpart) {
            var result = leftpart + '<' + rightpart;
        } else if (leftpart == rightpart) {
            var result = leftpart + '==' + rightpart;
        }
    } else {
        var result = eval(calc);
    }
    var output = result;
    document.getElementById('calc').value = output;
    document.getElementById('outputPanel').value = output;
    return output;
}

function replaceText(stri)
{
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replace(stri, stro);
    document.getElementById('content').value = strp;
}
function replaceTextAll(stri)
{
    var str = document.getElementById('content').value;
    var stro = document.getElementById('replacebox').value;
    var strp = str.toString().replaceAll(stri, stro);
    document.getElementById('content').value = strp;
}
function countText()
{
    var sourceText = document.getElementById('content').value;
    var charsCount = sourceText.length;
    document.getElementById('statusBar').innerHTML = 'CHARS = ' + charsCount;
}
function bin2hex(s)
{
    let i;
    let l;
    let o = '';
    let n;
    s += '';
    for (i = 0, l = s.length; i < l; i++) {
        n = s.charCodeAt(i).toString(16);
        o += n.length < 2 ? '0' + n : n;
    }
    return o;
}
