function doLogin() {
    var username = $('#username').val();
    var password = $('#password').val();

    if (username && password) {
        syncGet(
            '/bets/api/user/authenticate/' + username + '/' + password,
            function (json) {
                var uuid = json.uuid;
                var username = json.username;
                var ipAddress = json.ip_address;
                if (uuid && username && ipAddress) {
                    $.cookie('session-uuid', uuid);
                    $.cookie('session-username', username);
                    $.cookie('session-ip-address', json.ip_address);
                    window.location.replace('/');
                } else {
                    alert('Login failed!');
                }
            }
        );
    }
}

$(document).ready(function () {
    $('#password').keypress(function (e) {
        if (e.keyCode == 13)
            $('#login').click();
    });
});