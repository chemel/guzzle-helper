<?php

require __DIR__.'/../vendor/autoload.php';

use Alc\Guzzle\Guzzle;

$client = new Guzzle();

$content = $client->get('http://httpbin.org/get');
var_dump($content);

$client->useFirefox();
$content = $client->get('http://httpbin.org/get');
var_dump($content);

$content = $client->post('http://httpbin.org/post', array('foo' => 'bar'));
var_dump($content);
