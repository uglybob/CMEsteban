ready(function() {
    document.querySelectorAll('.cmoe').forEach(function (email) {
        email.textContent = email.textContent.replace(
            /[a-zA-Z]/g,
            function(c) {
                return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);
            }
        ).replace(/\+/g, "@")
        .replace(/\,/g, ".");

        var a = document.createElement('a');
        a.textContent = email.textContent;
        a.setAttribute('href', 'mailto:' + email.textContent);

        email.parentNode.insertBefore(a, email);
        email.parentNode.removeChild(email);
        email.style.display = "block";
    });

    document.querySelectorAll('.cmom').forEach(function(message) {
        message.style.display = "none";
    });
});
