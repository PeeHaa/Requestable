<?php

namespace Requestable\Data;

use Requestable\Network\Http\RequestData;

class Request
{
    private $request;

    public function __construct(RequestData $request)
    {
        $this->request = $request;
    }

    public function getUri()
    {
        return $this->request->post('uri');
    }

    public function getMethod()
    {
        if ($this->request->post('custommethod')) {
            return $this->request->post('custommethod');
        }

        return $this->request->post('method');
    }

    public function redirectsEnabled()
    {
        if ($this->request->post('follow')) {
            return true;
        }

        return false;
    }

    public function getHeaders()
    {
        if (!$this->request->post('headers')) {
            return [];
        }

        $headers = [];
        foreach (preg_split('/\r?\n(?![ \t])/', $this->request->post('headers'), -1, PREG_SPLIT_NO_EMPTY) as $header) {
            list($key, $val) = preg_split('/\s*:\s*/', $header, 2);
            $headers[strtolower($key)][] = $val;
        }
        $headers['connection'] = ['close'];

        return $headers;
    }

    public function getBody()
    {
        return $this->request->post('body');
    }
}
