ready(function() {
    document.querySelectorAll('.shooo').forEach(function (mail) {
        mail.textContent = mail.textContent.replace(
            /[a-zA-Z]/g,
            function(c) {
                return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);
            }
        ).replace(/\+/g, "@")
        .replace(/\,/g, ".");

        var a = document.createElement('a');
        a.textContent = mail.textContent;
        a.setAttribute('href', 'mailto:' + mail.textContent);

        mail.parentNode.insertBefore(a, mail);
        mail.parentNode.removeChild(mail);
    })
});
