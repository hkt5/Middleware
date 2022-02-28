<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Modules\Logs\Services\CreateLogService;

class LogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->getQueryString() === null) {
            $query_string = "/";
        } else {
            $query_string = $request->getQueryString();
        }
        $data = [
            'user_id' => -1,
            'site' => config('app.name'),
            'query_string' => $query_string,
            'method' => $request->getMethod(),
            'attributes' => json_encode($request->all(), JSON_THROW_ON_ERROR),
            'headers' => json_encode($request->headers->all(), JSON_THROW_ON_ERROR),
            'cookies' => json_encode($request->cookies->all(), JSON_THROW_ON_ERROR),
            'client_ips' => json_encode($request->getClientIps(), JSON_THROW_ON_ERROR),
            'client_ip' => $request->getClientIp(),
            'fingerprinting' => $request->fingerprint(),
            'http_host' => $request->getHttpHost(),
            'host' => $request->getHost(),
            'message' => 'Request.',
        ];

        $service = new CreateLogService();
        $service->create($data);
        return $next($request);
    }
}
