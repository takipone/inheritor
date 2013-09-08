<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add('Inheritor', __DIR__ . '/../src/Inheritor');
require __DIR__ . '/setting.php';

use Silex\Application;
use Aws\Common\Aws;
use Aws\DynamoDb\Exception\DynamoDbException;
use Inheritor\DynamoDbWrapper;
use Inheritor\Ami;

$app = new Application();

// to use IAM profile in authentication, unset config 
// if not enter AWS api key or secret key.
array_walk($config, function($value, $key) {
  if($value == '') {
    unset($config[$key]);
  }
});

$app['ddb'] = new DynamoDbWrapper($config);

