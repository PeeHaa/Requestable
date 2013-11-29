Requestable
===========

Webservice to easily send HTTP requests.

This service is useful when testing or debugging other webservice. It supports all HTTP verbs and other HTTP options. It currently uses cURL, but I *might* switch to [Artax][artax] at some point. To see the thing in action click [here][demo]. To see a demo of the API click [here][api-demo]

Build status
------------

[![Build Status](https://travis-ci.org/PeeHaa/Requestable.png?branch=master)](https://travis-ci.org/PeeHaa/Requestable) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/PeeHaa/Requestable/badges/quality-score.png?s=bc65c4a6a698cb399eacae4160e8dbc970ffcf34)](https://scrutinizer-ci.com/g/PeeHaa/Requestable/) [![Code Coverage](https://scrutinizer-ci.com/g/PeeHaa/Requestable/badges/coverage.png?s=c8455a69d302e104080ea4fc0d8b37c514a124d8)](https://scrutinizer-ci.com/g/PeeHaa/Requestable/)

API
---

This services also provides a public API to make requests. The API is based on simple `GET` or `POST` requests and the response is in the JSON format. An example of a API request is:

    https://requestable.pieterhordijk.com/api?uri=http%3A%2F%2Fpieterhordijk.com&method=GET

An example response looks like:

    {
        "headers": [
            "HTTP\/1.1 301 Moved Permanently\r\nServer: nginx\r\nDate: Sun, 27 Oct 2013 20:09:27 GMT\r\nContent-Type: text\/html\r\nContent-Length: 178\r\nConnection: keep-alive\r\nLocation: https:\/\/pieterhordijk.com\/"
        ],
        "body":"<html>\r\n<head><title>301 Moved Permanently<\/title><\/head>\r\n<body bgcolor=\"white\">\r\n<center><h1>301 Moved Permanently<\/h1><\/center>\r\n<hr><center>nginx<\/center>\r\n<\/body>\r\n<\/html>\r\n",
        "error":null,
        "hash":"Hg7R5T"
    }

The API supports CORS so you can easily make requests using Javascript in your applications to the Requestable service.

Installation
------------

1. Clone that shit
2. Setup the environment file (copy `init.example.com`) and point `init.deployment.php` to it.
3. Setup the database (run the import file in `/install/postgres.sql`)
4. ?
5. Profit!

Contributors
------------

- [Chris Wright (DaveRandom)][daverandom]
- [Pieter Hordijk (PeeHaa)][peehaa]

[artax]: https://github.com/rdlowrey/Artax
[demo]: https://requestable.pieterhordijk.com
[api-demo]: https://requestable.pieterhordijk.com/api?uri=http%3A%2F%2Fpieterhordijk.com&method=GET
[peehaa]: https://github.com/PeeHaa
[daverandom]: https://github.com/DaveRandom
