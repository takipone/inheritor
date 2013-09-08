<?php

use Aws\Common\Enum\Region;

$config = array(
  'key'    => getenv('AWS_ACCESS_KEY_ID'),
  'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
  'region' => Region::TOKYO,
  'table_prefix' => 'inheritor_'
);

