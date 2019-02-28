# PopeyeClient

## Overview

### Requirements

1. At least PHP 5.5 (7.3 recommended )
2. To use the PHP Stream Handler, allow_url_fopen, must be enabled on your system's php.ini.
3. To use instead, the cURL handler, you must have a recent version of cURL >= 7.19.4 compiled with OpenSSL and zlib.

***
Note: In this version of the PHP Client, we make a hard use of Guzzle (for requests) and Katzgrau (for loggin), which are well known libraries with a great community behind.

We strongly recommend you to read Guzzle documentation as it have data of how to do async calls, which can be of your benefit.
***

## Installation

The recommended way of installing our dependencies is with Composer.

Composer is a dependency management tool for PHP that allows you to reclare the dependencies your project needs and installs them into your project.

Install composer with:

+ curl -sS https://getcomposer.org/installer | php

Navigate to the popeye-php folder, and execute the installation:

+ composer.phar install