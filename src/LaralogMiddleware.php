<?php
namespace Laralog\Laralog;

use Whitelist\Check;

use Closure;

class LaralogMiddleware
{
    /**
    * Checks the authorization token and the inbound IP address
    */
    public function handle($request, Closure $next)
    {
        // check the header is present and at least something is set
        // this stops logs being available if someone installs the package
        // but forgets to set a key
        if (!$request->header('Laralog-Authorization')) {
            return abort(404);
        }

        //Check the token matches
        if ($request->header('Laralog-Authorization') != config('laralog.auth_token')) {
            return abort(404);
        }
        
        //check the inbound IP is allowed to access laralog
        $whitelistChecker = new Check();

        $ipWhitelist = config('laralog.ip_white_list');

        $whitelistChecker->whitelist($ipWhitelist);

        $isWhitelisted = empty($ipWhitelist)
            ? true
            : $whitelistChecker->check($request->ip());
        
        if (!$isWhitelisted) {
            return abort(404);
        }
        
        return $next($request);
    }
}
