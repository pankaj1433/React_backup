<?php
use Drupal\node\Entity\Node;
/**
 *Delete IP and FM nodes in fetv database.
 */
class DeleteFmIpNodes{
  
  var $start  = 0;
  var $limit  = 1;
  
  /**
   * Delete IP and FM nodes on teacher vision.
   */
  public function deleteIpFmNodes(){
    $query = "select data.entity_id from (select * from node__field_domain_access) as data left join (select * from node__field_domain_access where field_domain_access_target_id not in ('dev_ip_family_education_qa6_tothenew_net', 'dev_fm_family_education_qa6_tothenew_net')) new_data on data.entity_id = new_data.entity_id where new_data.entity_id is NULL group by data.entity_id LIMIT $this->limit OFFSET $this->start";
    $nids = \Drupal::database()->query($query)->fetchAll();
    $count = 0;
    foreach ($nids as $nid) {
      $node =  Node::load($nid->entity_id);
      $domains = explode(',',str_replace(' ', '', $node->get('field_domain_access')->getString()));
      if(in_array('dev_tv_family_education_qa6_tothenew_net', $domains) || in_array('dev_fe_family_education_qa6_tothenew_net', $domains) || in_array('dev_family_education_qa6_tothenew_net', $domains)){
        continue;
      }
      else {
        $type[$node->getType()]++; echo ++$count."\n";
//        print_r($node->getType());
//        echo $node->id()." ".++$count."\n";
//        if ($node->getTitle() == "Top Ten Archive"){
//          $node->set('title', 'unpublished ip and fm nodes');            
//        }
//        $node->set('status', 0)->save();
      }
    }print_r($type);
//    drush_print("$count nodes unpublished");
  }
  
  /**
   * show limit and offset as choice.
   */  
  function showChoices(){
    $start        = drush_prompt("Enter Offset", '0', false);
    $limit        = drush_prompt("Enter Limit", '1000', false);
    $this->start  = $start;
    $this->limit  = $limit;
    $this->deleteIpFmNodes();
    drush_print("Start:$start, Limit:$limit");
  }
}


$DeleteObject = new DeleteFmIpNodes();
$DeleteObject->showChoices();