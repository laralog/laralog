<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth token
    |--------------------------------------------------------------------------
    |
    | This token is responsible for authenticating entities to access your log
    | data. You may set this to anything you like. https://laralog.app will
    | create a random key when adding and application if you don't wish to use
    | a custom key.
    */
    'auth_token' => '',

    /*
    |--------------------------------------------------------------------------
    | Max File Size (MB)
    |--------------------------------------------------------------------------
    |
    | The maximum size in megabytes of a log the package will return in a
    | response. This is helpful to stop large log files being downloaded over
    | HTTP. A small default of 5MB is set, to prevent slow internet connections
    | from taking ages to load logs and to stop unneccessary data usage on
    | 3g/4g/metered connections.
    */
    'max_file_size' => 5,

    /*
    |--------------------------------------------------------------------------
    | IP White List
    |--------------------------------------------------------------------------
    |
    | This contains a list of ips allowed to receive log information. To allow
    | any ips leave this empty. This isn't required, it's just an extra
    | security step you may wish to take :).
    | Check https://github.com/Jalle19/php-whitelist-check to see what formats
    | one can use.
    |
    */
    'ip_white_list' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Trucated Logs
    |--------------------------------------------------------------------------
    |
    | If log is bigger than the maximum allowed size enabling this
    | will fetch the end of the log up to the maximum allowed size. e.g.
    | A log is 50mMB, the maximum allowed log size is 5MB, if truncated logs is
    | enabled, the last 5MB of the log will be returned.
    */
    'truncated_logs' => false

    /*
    |--------------------------------------------------------------------------
    | Log Directory
    |--------------------------------------------------------------------------
    |
    | Laralog will search for logs in the app's storage/logs directory by default but
    | if you store your logs in a different place you can customise the path.
    | e.g. /home/forge/mywebsite.com/app/logs/
    */
    // 'directory' => ''
];
