ready(function() {
    var cc = document.querySelector('#cookieConsent');
    var button = document.querySelector('#cookieConsent button');

    button.addEventListener('click', function() {
        cookieSet('cookieConsent', '1');
        cc.classList.remove('visible');
    });

    if (cookieGet('cookieConsent') != '1') {
        cc.classList.add('visible');
    }
});
