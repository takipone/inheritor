<?php

date_default_timezone_set('Asia/Tokyo');

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function(Silex\Application $app) {
  return $app['twig']->render('index.twig', array(
    'year' => date('Y')
  ));
});

/*
 * APIs
 */
$app->get('/api/v1/{ami_id}', function(Silex\Application $app, $ami_id) {
  try {
    $item = $app['ddb']->find(array(
      'table_name' => 'ami',
      'item_key' => 'ami-id',
      'item_value' => $ami_id
    ));
    if (count($item)) {
      return $app->json($item);
    } else {
      return $app->json(array('message' => 'not found'));
    }
  }
  catch (DynamoDbException $e) {
    return $app->json($e);
  }
});

$app->post('/api/v1/{ami_id}', function(Silex\Application $app, Request $request, $ami_id) {
});

$app->run();
