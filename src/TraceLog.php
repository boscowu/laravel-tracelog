<?php

namespace boscowu\TraceLog;

use Illuminate\Support\Facades\Log;

class TraceLog
{
    private $traceId = null;

    public $request;

    public function __construct()
    {
        $this->traceId = $this->traceId ?: $this->makeId();
    }

    /**
     * @param $message 描述信息或tag信息
     * @param array|string|object $context 需打印的数据内容
     * @return $this
     */
    public function log($message, $context = [])
    {
        $traces      = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $trace       = array_pop($traces);
        $logContext = [
            'trace_id'      => $this->traceId,
            'self_trace_id' => $this->makeId(),
            'timestamp'     => $this->msecTime(),
            'callFile'      => $trace['file'],
            'callLine'      => $trace['line'],
            'param_data'    => $context,
        ];
        Log::channel(config('tracelog.channel', null))->info($message, $logContext);
        return $this;
    }

    private function msecTime()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (int)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

    private function makeId()
    {
        return uniqid(config('tracelog.prefix', ''));
    }

    public function getTraceId()
    {
        return $this->traceId;
    }
}