<?php
use Drupal\Core\Database\Database;
/**
 * Update old url and save it after urldecode function
 */
class ReplaceInBodyTV {
  var $start  = 0;
  var $limit  = 1;
  var $updateCount  = 0;
  var $database;
  var $count = 0;
  var $arrayProceed = [];
  var $sourceTable;
  //var $searchDomain = ['https://www.infoplease.com','https://www.factmonster.com'];
  
  function __construct($sourceTable) {
    $this->database = Database::getConnection();
    $this->sourceTable = $sourceTable;
  }
  
  /**
   * search url in body content and replace it with node/redirect url
   * @return type
   */
  function updateURLinBody() { $count=0;
    $dataObject = $this->database->select($this->sourceTable, 'n')
          ->fields('n',['source','search_url','replace_url']);
      $dataObject->range($this->start,  $this->limit);
      try {
        $result = $dataObject->execute();
        $result->allowRowCount = true;
        if ($result->rowCount()>0)
        {
          echo "\n Start Loop \n";
          foreach ($result as $res) {
            $search_url     = $res->search_url;
            $replaceWith    = $res->replace_url;
            if (!empty($replaceWith))
            { 
              $sourceUrl    = $res->source;
              $path = \Drupal::service('path.alias_manager')->getPathByAlias($sourceUrl);
                if(preg_match('/node\/(\d+)/', $path, $matches)) {
                  $node       = \Drupal\node\Entity\Node::load($matches[1]);
                  if ($node && (!empty($search_url)))
                  {
                  	if (!empty($matches[1]))
                  	{	if (strpos($search_url, '&') !== false) 
                  			{$search_url=str_replace('&','&amp;',$search_url);}
                    	$node_id = $matches[1];
			            $search_url = '"'.$search_url.'"';
			            $replaceWith = '"'.$replaceWith.'"';

			            $sql_select=$this->database->query("SELECT body_value from node__body WHERE  entity_id=".$node_id)->fetchAssoc();
			            if(strpos($sql_select[body_value],$search_url) === false)
			            	echo $sourceUrl."\n".$search_url."\n\n";


			            //update in body revision
			            $sql = "UPDATE  node_revision__body SET body_value = REPLACE( body_value,  :search, :replaceWith) WHERE  entity_id=$node_id";
			            $this->database->query($sql,['search'=>$search_url,'replaceWith'=>$replaceWith]);
			              //update in Body
			            $sql = "Update node__body set body_value=replace(body_value,:search, :replaceWith) WHERE  entity_id=$node_id";
			            $count = $this->database->query($sql,['search'=>$search_url,'replaceWith'=>$replaceWith],array('return' => Database::RETURN_AFFECTED));
          			}
              //if($count!=1){echo $res->replace_url;}
              //echo "Updated = $count, Page ID = $node_id, $search_url => $replaceWith \n";
            }
          }
            }
          }
          echo "\n End Loop \n ";
        }
      }
      catch (\Exception $e) {
        echo $e->getMessage();
      }
  }
}


$args = $_SERVER['argc'];
//For the Drush Arguments
$_REQUEST['limit'] = 100;
$_REQUEST['start'] = 0;

if (isset($_SERVER['argv'][$args-3]))
$_REQUEST['start'] = $_SERVER['argv'][$args-3];

if (isset($_SERVER['argv'][$args-2]))
$_REQUEST['limit'] = $_SERVER['argv'][$args-2];

if (isset($_SERVER['argv'][$args-1]))
$_REQUEST['sourceTable'] = $_SERVER['argv'][$args-1];

$start = (isset($_REQUEST['start'])) ? $_REQUEST['start'] : 0;
$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : 1;
$sourceTable = (isset($_REQUEST['sourceTable'])) ? $_REQUEST['sourceTable'] : '';

$object = new ReplaceInBodyTV($sourceTable);
$object->limit = $limit;
$object->start = $start;
$object->updateURLinBody();

/**
 * Table structure required:
 * Column : search_url,replace_url
 * Table name : seo_123 [you can use your table name, Line : 24]
 * 
 * Command:
 * drush @fensite.dev -l infoplease.com php-script replaceInBodyTV.php 0 100 sourceTable
 * 0 : start value
 * 100 : Limit
 */

