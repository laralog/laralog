<?php

namespace Laralog\Laralog\Tests\Unit;

use Laralog\Laralog\LogParser;
use Illuminate\Http\Request;
use Laralog\Laralog\LaralogMiddleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LaralogMiddlewareTest extends Testcase
{
    public function setUp()
    {
        parent::setUp();
        config(['laralog.auth_token' => 'secret_token']);
        config(['laralog.ip_white_list' => ['173.136.1.1']]);
    }
    
    public function testARequestGetsRejectedWhenTheTokenDoesNotMatch()
    {
        $this->expectException(NotFoundHttpException::class);

        $middleware  = new LaralogMiddleware;

        $request = $this->createRequest('incorrect_token', '173.136.1.1');

        $middleware->handle($request, function ($response) {
        });
    }

    public function testARequestGetsRejectWhenTheIpAddressIsNotInTheWhiteListButTheTokenIsCorrect()
    {
        $this->expectException(NotFoundHttpException::class);

        $middleware  = new LaralogMiddleware;

        $request = $this->createRequest('secret_token', '192.168.10.10');

        $middleware->handle($request, function ($response) {
        });
    }

    public function testARequestCanPassThroughWhenTheTokenIsCorrectAndTheresNoWhiteList()
    {
        //clear the whitelist
        config(['laralog.ip_white_list' => []]);

        $middleware  = new LaralogMiddleware;

        $request = $this->createRequest('secret_token', '192.168.10.10');

        $response = $middleware->handle($request, function ($response) {
            return $response;
        });

        $this->assertTrue($response instanceof Request);
    }

    public function testARequestCanPassThroughWhenTheTokenIsCorrectAndTheIPAddressIsInTheWhitelist()
    {
        $middleware  = new LaralogMiddleware;

        $request = $this->createRequest('secret_token', '173.136.1.1');

        $response = $middleware->handle($request, function ($response) {
            return $response;
        });

        $this->assertTrue($response instanceof Request);
    }

    private function createRequest(string $token, string $remoteAddr)
    {
        return Request::create('laralog/get/log', 'GET', [], [], [], [
            'REMOTE_ADDR' => $remoteAddr,
            'HTTP_LARALOG_AUTHORIZATION' => $token
        ]);
    }
}
