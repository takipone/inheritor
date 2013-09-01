<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/setting.php';

use Aws\Silex\AwsServiceProvider;
use Silex\Application;

$app = new Application();

$app->register(new AwsServiceProvider(), array(
  'aws.config' => $aws_config
));

$app['ddb'] = $app['aws']->get('DynamoDb');

