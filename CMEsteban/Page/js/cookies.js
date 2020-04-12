function cookieSet(name, value, days) {
    var date = new Date();

    days = days || 365;
    date.setTime(+ date + (days * 86400000));

    document.cookie = name + '=' + value + "; expires=" + date.toGMTString() + ';path=/';
}

function cookieGet(cname) {
    var result = '';
    var name = cname + '=';
    var ca = document.cookie.split(';');

    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            result = c.substring(name.length, c.length);
        }
    }

    return result;
}
