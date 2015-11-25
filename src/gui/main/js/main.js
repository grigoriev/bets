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