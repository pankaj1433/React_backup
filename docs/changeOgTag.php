<?php
use Drupal\Core\Database\Database;
/**
 * Update og:image tags for nodes
 */
class changeOgTag {
  var $database;
  function __construct() {
    $this->database = Database::getConnection();
  }
  
  /*
   * Search nodes and change meta information for that node
   */
  function updateNodes(){
    $types = \Drupal::entityManager()->getStorage('node')->loadMultiple();    
  }
  
}
$object = new changeOgTag();
$object->updateNodes();
