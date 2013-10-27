<?php

namespace Requestable\Network\Client;

use Requestable\Data\Request;

class Curl implements Client
{
    private $uri;

    private $method;

    private $redirects;

    private $headers = [];

    private $body;

    public function __construct(Request $request)
    {
        $this->uri       = $request->getUri();
        $this->method    = $request->getMethod();
        $this->redirects = $request->redirectsEnabled();
        $this->headers   = $request->getHeaders();
        $this->body      = $request->getBody();

        if ($this->body) {
            $this->headers['content-length'] = [strlen($this->body)];
        }
    }

    public function run()
    {
        if (!$client = curl_init($this->uri)) {
            throw new CurlException('Could not initialize cURL');
        }

        $this->setOptions($client);

        if (!$result = curl_exec($client)) {
            throw new CurlException('Making request failed: ' . curl_error($client));
        }

        $headerInfo = curl_getinfo($client, CURLINFO_HEADER_OUT);
        list($header, $body) = preg_split('/\r?\n\r?\n/', curl_exec($client), 2);

        if (!preg_match('#^HTTP/1\.[01] (\d{3}) ([^\r\n]+)#', $header)) {
            throw new CurlException('The HTTP response was invalid');
        }

        return [
            'header' => $header,
            'body'   => $body,
        ];
    }

    private function setOptions($client)
    {
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_FOLLOWLOCATION => $this->redirects,
            CURLOPT_CUSTOMREQUEST  => $this->method,
        ];

        if ($this->headers) {
            $options[CURLOPT_HTTPHEADER] = $this->getHeaders();
        }

        if ($this->body) {
            $options[CURLOPT_POSTFIELDS] = $this->body;
        }

        foreach ($options as $option => $value) {
            if (!curl_setopt($client, $option, $value)) {
                throw new CurlException('Could not set cURL option: ' . curl_error($client));
            }
        }
    }

    private function getHeaders()
    {
        $headers = [];
        foreach ($this->headers as $name => $vals) {
            $name = preg_replace_callback('/(?:^|-)[a-z]/', function($match) { return strtoupper($match[0]); }, $name);
            foreach ($vals as $val) {
                $headers[] = $name . ': ' . trim($val);
            }
        }

        return $headers;
    }
}
