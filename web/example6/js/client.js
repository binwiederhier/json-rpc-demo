var Datto = Datto || {};
Datto.API = Datto.API || {};

Datto.API.Client = (new function() {
    endpoint = '';

    function Client(endpoint)
    {
        this.endpoint = endpoint;
    }

    Client.prototype = {
        call: function (method, params, success, fail) {
            var self = this;
            var data = (success) ? { id: new Date().getTime() } : { }; // Notifications have no 'id'.

            success = success || function () { };
            fail = fail || function () { };

            return $.ajax({
                url: self.endpoint,
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: JSON.stringify($.extend({}, data, {
                    jsonrpc: '2.0',
                    method: method,
                    params: params
                })),
                success: function (data) {
                    if (data === undefined) {
                        success.apply(this, []);
                    } else if (data !== undefined && data !== null && data.result !== undefined) {
                        success.apply(this, [data.result]);
                    } else {
                        fail.apply(this, [data]);
                    }
                },
                error: function (data) {
                    fail.apply(this, [data]);
                }
            });
        }
    };

    return Client;
}());

