<?php
class Help extends Action {

  private $outputter;

  private $structure ;

  private $texts;

  public function __construct(){
    $this->outputter = Outputter::get_instance();
    $this->texts = $this->parse_xml();
    $user = User::get_instance();
    if($user->is_logged_in()){
      // Tools::debug(User::get_instance()->is_logged_in());
      switch($user->get_user_type()){
        case User::MAILBOX:
          $this->structure = [
          'service_portal' =>  ['common_service_portal', 'login'],
          'mailboxes' => ['common_mailbox',  'edit_mailbox']
          ];
          break;
        case User::USER:
          $this->structure = [
          'service_portal' =>  ['common_service_portal', 'login', 'forgotten_password'],
          'mailboxes' => ['common_mailbox', 'display_mailboxes', 'create_mailbox', 'edit_mailbox', 'delete_mailbox', 'change_password_mailbox'],
          'forwards' => ['common_forward', 'display_forwards', 'create_forward', 'delete_forward'],
          'distributors' => ['common_distributor', 'display_distributors', 'create_distributor', 'delete_member']
          ];
          if(count($user->get_mailman_lists()) > 0 ) {
            $this->structure['mailman_lists'] = ['common_mailman_lists','display_mailman_lists'];
          }
          $this->structure['account'] = ['edit_account'];
          break;
      }
    } else {
      $this->structure = [
      'service_portal' =>  ['common_service_portal', 'login', 'forgotten_password'],
      'mailboxes' => ['common_mailbox', 'change_password_mailbox' ]

      ];
    }

  }

  private function parse_xml(){
    $result = array();

    $language = $this->outputter->get_language();

    $xml = new XMLReader();

    $xml->open('lib/ml-support/help/'.$language.'.xml');
    $this->xml_next_element($xml);

    if( $xml->name === 'help') {
      $continue = true;
      $a = 0;
      while($a < 100 && $continue) {
        $continue &= $this->xml_next_element($xml) !== false;
        $node = $xml->name;
        $continue &= $this->xml_next_element($xml) !== false;
        $this->extract_texts($node, $xml, $result);
        $a++;
      }
    }
    return $result;
  }

  private function extract_texts($node, &$xml, &$result) {
    do{
      $type = $xml->name;
      $text = $xml->readInnerXML();
      $text = preg_replace('/(<!--&)(.+)(;-->)/', '&\2;', $text);
      $result[$type][$node] = $text;
    } while( $this->xml_next_sister_element($xml));
  }

  private function xml_next_element(&$xml){
    while($xml->read()){
      //echo $xml->nodetype;
      if($xml->nodeType === XMLReader::ELEMENT) {
        return $xml;
      }
    }
    return false;
  }

  private function xml_next_sister_element(&$xml){
    while($xml->next()){
      //echo $xml->nodetype;
      if($xml->nodeType === XMLReader::ELEMENT) {
        return $xml;
      }
      if($xml->nodeType === XMLReader::END_ELEMENT) {
        return false;
      }
    }
    return false;
  }

  public function run(){
    // Tools::debug(User::get_instance()->is_logged_in());
    $this->outputter->register('structure', $this->structure);
    $this->outputter->register('texts', $this->texts);
    // Tools::debug($this->texts);
    $this->outputter->show('help');
     
  }





}


?>
