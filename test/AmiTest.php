<?php
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Inheritor', __DIR__ . '/../src/Inheritor');

use Aws\Common\Enum\Region;
use Aws\DynamoDb\Exception\DynamoDbException;
use Inheritor\DynamoDbWrapper;
use Inheritor\Ami;

class AmiTest extends PHPUnit_Framework_TestCase
{
  protected static $ddb;

  public static function setUpBeforeClass()
  {
    $config = array(
      'key'    => getenv('AWS_ACCESS_KEY_ID'),
      'secret' => getenv('AWS_SECRET_ACCESS_KEY'),
      'region' => Region::TOKYO,
      'table_prefix' => 'inheritor_'
    );
    self::$ddb = new DynamoDbWrapper($config);
  }

  public function testCreateAmiCorrectly()
  {
    $ami = new Ami();
    $ami->setAmiId('ami-12345678');
    $ami->setParents(array('ami-11111111', 'ami-22222222'));
    $ami->setChildren(array('ami-33333333', 'ami-44444444'));
    $ami->setBrothers(array('ami-55555555', 'ami-66666666'));
    self::$ddb->persist('ami', $ami);
    try {
      self::$ddb->flush();
    }
    catch (DynamoDbException $e) {
      print $e;
      $this->fail();
    }

    return true;
  }

  public function testGetAmiCorrectly()
  {
    try {
      $item = self::$ddb->find(array(
        'table_name' => 'ami',
        'item_key' => 'ami-id',
        'item_value' => 'ami-12345678'
      ));
      var_dump($item);
    }
    catch (DynamoDbException $e) {
      print $e;
      $this->fail();
    }

    return true;
  }


}
