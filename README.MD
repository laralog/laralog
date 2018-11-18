# https://laralog.app

This package is can be used in conjunction with https://laralog.app to enable free, simple and central remote viewing for Laravel logs.

The idea of this package is to provide a central interface where you can view your logs for all of your Laravel applications in an easy to read, responsive format.

It's not meant to replace services such as papertrail. https://laralog.app never stores log data, it accesses your log data (how much is up to you) over HTTP protocol and provides an interface to read, search and filter your Laravel logs for as many Laravel applications as you need. 

## Installation

Require laralogapp/laralog package and update your dependencies.

```$ composer require laralogapp/laralog```

If you're using Laravel 5.4 and below you need to add the service provider to your ```config/app.php``` providers array otherwise autodiscovery is used. 

```Laralog\Laralog\LaralogServiceProvider::class```

Publish the package's configuration

```$ php artisan vendor:publish --provider="Laralog\Laralog\LaralogServiceProvider"```


## Configuration

*[REQUIRED]* ```auth_token``` - **This is a shared secret between your application and https://laralog.app's interface. You need to set this to either a custom key or to the one generated when creating a new application at https://laralog.app**.

```max_file_size``` - The maximum log file size allowed

```truncated_logs``` - Truncate the log to the maximum file size if log exceeds the maximum file size, the data will be fetched from the end of the file (meaning the log data will be the most recent enteries).

```ip_whitelist``` - IPs allowed to access log data, by default this is empty, meaning all IPs can access data. But if you wish to limit the IPs which can access your data you can do so using this option. (Good to use if you're worried about the security of your tokens). 



### Notes

Laralog accesses your log data through the client, so your log data will never touch Laralog's server. The exception to this rule is for HTTP connections. HTTP connections are proxied through Laralog's server to prevent browsers throwing mixed content errors.

* Completely Free
* Supports Laravel 5.1+
* Connect with HTTP or HTTPS
* Limit who can view logs by whitelisting IPs
* Connect to local applications

### Write your own interface

*This package doesn't have to be used with https://laralog.app. Feel welcome to use this package's json endpoints to write your own front end to view and manage logs.*


#### Endpoint

```GET /laralog/available/logs```

#### Example Successful Response - 200

size is in bytes

```json
{
    "files": [
        {
            "size": 293316, 
            "basename": "laravel-2018-10-10.log"
        },
        {
            "size": 1665518042,
            "basename": "laravel-big-log.log"
        },
        {
            "size": 267207,
            "basename": "laravel.log"
        }
    ]
}
```

#### Endpoint

```GET /laralog/get/log```

#### Parameters

```log_basename``` - the basename of the log to fetch data for 

#### Example Successful Response - 200

Note - each line of the stacktrace is separated by a new line. 

```json
{
    "log_entries": [
        {
            "date": "2018-11-04 15:58:56", 
            "environment": "local",
            "level": "ERROR",
            "message": "fread(): Length parameter must be greater than 0 {\"exception\":\"[object] (ErrorException(code: 0): fread(): Length parameter must be greater than 0 at LaraLog/src/LogParser.php:81)\n",
            "stacktrace": "\n#0 [internal function]: Illuminate\\\\Foundation\\\\Bootstrap\\\\HandleExceptions->handleError(2, 'fread(): Length...', '...', 81, Array)\n#1 LaraLog/src/LogParser.php(81): fread(Resource id #252, 0)\n#2 LaraLog/src/LogController.php(51): Laralog\\\\Laralog\\\\LogParser->truncatedLogContents('...')\n#3 [internal function]: Laralog\\\\Laralog\\\\LogController->getLog()\n#4 vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): call_user_func_array(Array, Array)\n#\n..."
        },
        ...
    ]
}
```
