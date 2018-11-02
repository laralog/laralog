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
    | Log Directory
    |--------------------------------------------------------------------------
    |
    | Laralog will search for logs in the app's storage/logs directory by default but
    | if you store your logs in a different place you can customise the path.
    | e.g. /home/forge/mywebsite.com/app/logs/
    */
    // 'directory' => ''
];
