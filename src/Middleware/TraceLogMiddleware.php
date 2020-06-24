<?php

namespace boscowu\TraceLog\Middleware;

use Closure;
use Illuminate\Http\Request;
use boscowu\TraceLog\Facades\TraceLog;

class TraceLogMiddleware
{
    /**
     * @var TraceLog
     */
    protected $tracer;

    /**
     * TraceRequests constructor.
     * @param TraceLog $tracer
     */
    public function __construct(TraceLog $tracer)
    {
        $this->tracer = $tracer;
    }
    /** 数据记录中间件 */
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $traceId = $this->tracer::log('Trace Request Start', [
            'request' => $request->all(),
            'method'  => $request->method(),
            'path'    => $request->path(),
        ])->getTraceId();
        $response = $next($request);
        $this->tracer::log('Trace Response End', ['response' => $response]);
        $response->header('Trace-id', $traceId);
        return $response;
    }
}
