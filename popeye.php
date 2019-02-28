<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

if (!class_exists('PopeyeException'))
{
	class PopeyeException extends Exception {}
}

if (!class_exists('PopeyeClient'))
{
    class PopeyeClient
	{
        private $url;
        private $userid;
        private $password;
        private $api_version;
        private $site;
        private $assoc;
        public $client;

        public function __construct($url, $user, $password, $api_version=1, $site, $assoc = True, $log_level = Psr\Log\LogLevel::WARNING) {
            $hostname = parse_url($url, PHP_URL_HOST);
            $this->url = $url;
            $this->user = $user;
            $this->password = $password;
            $this->api_version = $api_version;
            $this->site = $site;
            $this->assoc = $assoc;

            $this->_check_version();
            
            $this->logger = new Katzgrau\KLogger\Logger('logs', $log_level, array (
                'logFormat' => '{date} - {level} - {message}',
                'filename'  => 'popeye'
            ));
        }

        private function _check_version() {
            if (version_compare(PHP_VERSION, '5.5.0', '<')) {
                echo 'I am still PHP 4, my version: ' . PHP_VERSION . "\n";
                exit(-1);
            }

        }

        private function _get_client() {
            return new Client([
                'base_uri' => $this->url,
                'timeout' => 3.0,
                'headers'=> [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-WS-API-Version' => $this->api_version,
                    'X-WS-API-Site' => $this->site,
                ],
                'auth' => [
                    $this->user,
                    $this->password,
                ]
            ]);
        }

        public function __call($method, $arguments) {
            if (!isset($this->client) || is_null($this->client)) {
                $this->client = $this->_get_client();
            }
            try {
                $post = $this->client->post(
                    $method,
                    ['body' => json_encode(
                        $arguments
                    )]
                );
                if ($post->getStatusCode() == 200) {
                    $response = json_decode($post->getBody(), $this->assoc);
                    $this->logger->debug(var_export($response, True));
                    return $response;
                }

            } catch (RequestExcetion $e) {
                echo $e;
                if ($e->hasResponse()) {
                    $err = Psr7\str($e->getResponse());
                    throw new PopeyeException($err);
                } else {
                    throw new PopeyeException($err->getMessage());
                }
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                throw new PopeyeException($e->getMessage());
            }
        }
    }
}