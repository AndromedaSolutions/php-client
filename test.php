<?php

require ('popeye.php');

/*
In order to know the correct urls and your credentials, please, contact with support@andromedant.com
*/

$client = new PopeyeClient('url', 'user', 'password', 1, 'GuzzleHTTP', True, Psr\Log\LogLevel::WARNING);

// var_dump($client->authenticate());