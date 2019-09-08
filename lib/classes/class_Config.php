<?php
class Config extends _Config{

  public static function get_instance() {
    if(!isset(self::$instance)){
      self::$instance = new Config();
    }
    return self::$instance;
  }

  protected function init() {
	 
     $this->db = new Medoo([
       	'database_type' => 'sqlite',
				'database_file' => $this->get_db_filename()]);
 }
  
  public function get_db_filename(){
		return 'database/bazaardatabase.sqlite';
	}
		
  
  public function get_accesses(){
		 $accesses= array();
		 $accesses['wlan']['password'] = "******"; 
		 $accesses['wlan']['ssid'] = "baszar"; 
		 $accesses['ssh']['user'] = "user"; 
		 $accesses['ssh']['password'] = "******"; 
		 $accesses['databaseAdminTool']['password'] = "******"; 
  
		return $accesses;
	}
}

?>
