<?php

namespace Inheritor;

use Aws\Common\Aws;
use Aws\Common\Enum\Region;
use Aws\DynamoDb\Exception\DynamoDbException;

class DynamoDbWrapper {
  private $table_prefix; 
  private $client; 
  private $write_items;

  public function __construct($config)
  {
    $this->table_prefix = $config['table_prefix'];

    $aws = Aws::factory($config);
    $this->client = $aws->get('DynamoDb');
  }

  public function find($query)
  {
    $result = $this->client->getItem(array(
      'TableName' => $this->table_prefix . $query['table_name'],
      'Key' => array(
        $query['item_key'] => array('S' => $query['item_value']),
      ),
      'ConsistentRead' => false
    ));
    $item_array = null;
    $item = $result['Item'];
    if(count($item)) {
      foreach ($item as $key => $value) {
        $item_array[$key] = array_shift($value);
      };
    }
    return $item_array;
  }

  public function persist($table_name, $item)
  {
    $this->write_items[$table_name][] = $item;
  }

  public function flush()
  {
    $request_items = array();
    if(is_array($this->write_items)) {
      foreach ($this->write_items as $table_name => $items) {
        foreach ($items as $item) {
          $request_items[$this->table_prefix . $table_name][] = array(
            'PutRequest' => array(
              'Item' => $this->client->formatAttributes($item->getProperties())
            )
          );
        }
      }
      $this->client->batchWriteItem(array(
        'RequestItems' => $request_items
      )); 
    }
  }
}
