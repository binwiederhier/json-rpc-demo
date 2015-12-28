JSON-RPC Example Project
========================

To test, start a webserver
--------------------------
```
php -S localhost:8888
```

Example 1: Using `JsonRpc\Simple` mapper
----------------------------------------
HTTP-only endpoint without authentication, logging or validation.

```
# Adding a device
curl -d '{"jsonrpc":"2.0","id":1,"method":"devices/add","params":{"name":"Philipp PC","type":"pc"}}' http://localhost:8888/example1/api.php; echo
{"jsonrpc":"2.0","id":1,"result":{"id":0,"name":"Philipp PC","type":"pc"}}

# Listing all devices
curl -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' http://localhost:8888/example1/api.php; echo
{"jsonrpc":"2.0","id":1,"result":[{"id":0,"name":"Philipp PC","type":"pc"}]}
```

Example 2: Adding parameter validation with `JsonRpc\Validator`
---------------------------------------------------------------
```
curl -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll","params":{"sortBy":"INVALID"}}' http://localhost:8888/example2/api.php; echo
{"jsonrpc":"2.0","id":1,"error":{"code":-32602,"message":"Invalid params"}}
```

Example 3: Adding HTTP Basic authentication with `JsonRpc\Auth`
---------------------------------------------------------------
Trying to access API without authentication:
```
curl -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' http://localhost:8888/example3/api.php; echo
{"jsonrpc":"2.0","id":1,"error":{"code":-32651,"message":"Missing auth."}}
```

Trying to access API with invalid Basic Auth credentials:
```
curl -u invaliduser:pass -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' http://localhost:8888/example3/api.php; echo
{"jsonrpc":"2.0","id":1,"error":{"code":-32652,"message":"Invalid auth."}}
```

Access API via HTTP (authenticated via HTTP Basic Auth):
```
curl -u user:pass -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' http://localhost:8888/api.php; echo
{"jsonrpc":"2.0","id":1,"result":[{"name":"a","age":51,"posts":1881},{"name":"aaron","age":31,"posts":111},{"name":"chris","age":51,"posts":1881},{"name":"phil","age":29,"posts":999}]}
```

Example 4: Adding logging  with `JsonRpc\Logged`
------------------------------------------------
Requests and responses are logged to syslog (usually at `/var/log/syslog`):
```
# Do a request first
$ curl -u user:pass -d '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' http://localhost:8888/example4/api.php; echo
{"jsonrpc":"2.0","id":1,"result":[{"id":0,"name":"Philipp PC","type":"pc"}]}

# Then check syslog (on the server)
tail /var/log/syslog | grep demo.api
Dec 28 22:54:19 platop api[13012]: demo.api.INFO: Message received: {"jsonrpc":"2.0","id":1,"method":"devices/listAll"} [] []
Dec 28 22:54:19 platop api[13012]: demo.api.INFO: Sending reply: {"jsonrpc":"2.0","id":1,"result":[{"id":0,"name":"Philipp PC","type":"pc"}]} [] []
```

Example 5: Adding CLI-support with 'root'-only access
-----------------------------------------------------
Trying to access the API via the CLI as non-root user:
```
echo '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' | php web/example5/api.php; echo
{"jsonrpc":"2.0","id":1,"error":{"code":-32652,"message":"Invalid auth."}}
```

Access API via CLI as root user:
```
echo '{"jsonrpc":"2.0","id":1,"method":"devices/listAll"}' | sudo php web/example5/api.php; echo
{"jsonrpc":"2.0","id":1,"result":[{"id":0,"name":"Philipp PC","type":"pc"}]}
```
