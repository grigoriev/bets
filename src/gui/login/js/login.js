function doLogin() {
    syncGet(
        '/bets/api/user/authenticate/grigoriev/KremlIn9',
        function (json) {
            $.cookie('session-uuid', json.uuid);
            $.cookie('session-username', json.username);
            $.cookie('session-ip-address', json.ip_address);
        }
    );
    window.location.replace('/');
}