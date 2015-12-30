
'use strict';
$(document).ready(function () {
    var api = new Datto.API.Client('api.php');
    var loggedIn = document.cookie.indexOf('token=') !== -1;

    var $devices = $('#devices');
    var $login = $('#login');
    var $logout = $('#logout');

    // Show/hide login panel
    if (loggedIn) {
        $login.hide();
    } else {
        $logout.hide();
    }

    // Set "super secure" login cookie
    $login.find('button').click(function () {
        document.cookie = 'token=secret; expires=Thu, 01 Jan 2099 00:00:00 GMT';
        $login.hide(); $logout.show();
    });

    // Remove "super secure" login cookie
    $logout.find('button').click(function () {
        document.cookie = 'token=secret; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        $login.show(); $logout.hide();
    });

    // Refresh device list every second
    window.setInterval(function() {
        var params = {};

        api.call('devices/listAll', params, function (data) {
            $devices.empty();

            $(data).each(function (idx, device) {
                $devices.append(
                    $('<li>')
                        .addClass(device.type)
                        .text(device.name)
                );
            });
        }, function (data) {
            $devices
                .empty()
                .append(
                    $('<li>')
                        .addClass('error')
                        .text('ERROR: ' + data.error.message)
                );
        });
    }, 1000);
});
