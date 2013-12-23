<?php

// @todo Find a fix to generate the pem file in a secure manner
file_put_contents(__DIR__ . '/../data/default.pem', file_get_contents('http://curl.haxx.se/ca/cacert.pem'));
