<?php

require __DIR__.'/../vendor/autoload.php';

use Alc\Guzzle\GuzzleHelper;

$client = new GuzzleHelper();

$response = $client->get('http://httpbin.org/get');
var_dump($response->getStatusCode());
var_dump($response->getBody()->getContents());

$client->useFirefox();
$response = $client->get('http://httpbin.org/get');
var_dump($response->getBody()->getContents());

$response = $client->post('http://httpbin.org/post', array('foo' => 'bar'));
var_dump($response->getBody()->getContents());
