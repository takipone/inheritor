<?php

namespace Inheritor;

class Ami
{
  private $ami_id = '';
  private $parents = array();  
  private $children = array();  
  private $brothers = array();  

  public function setAmiId($ami_id)
  {
    $this->ami_id = $ami_id;
  }
  public function setParents($parents)
  {
    $this->parents = $parents;
  }
  public function setChildren($children)
  {
    $this->children = $children;
  }
  public function setBrothers($brothers)
  {
    $this->brothers = $brothers;
  }

  public function getProperties()
  {
    return array(
      'ami-id' => $this->ami_id,
      'parents' => $this->parents,
      'children' => $this->children,
      'brothers' => $this->brothers
    );
  }

}
