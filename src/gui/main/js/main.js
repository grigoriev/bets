function doLogout() {
    syncGet(
        '/bets/api/user/logout/' + $.cookie('session-uuid') + '/' + $.cookie('session-username'),
        function (json) {
        }
    );
    $.removeCookie('session-uuid');
    $.removeCookie('session-username');
    $.removeCookie('session-ip-address');
    window.location.replace('/login');
}

$(document).ready(function () {
    $('#cssmenu').find('li.has-sub>a').on('click', function () {
        $(this).removeAttr('href');
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp();
        } else {
            element.addClass('open');
            element.children('ul').slideDown();
            element.siblings('li').children('ul').slideUp();
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp();
        }
    });
});