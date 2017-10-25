<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Config_Model extends CI_Model {
	
	public function get($code) {
		$setting_data = array();
		$query = $this->db->query("SELECT * FROM " .$this->db->dbprefix('config'). " WHERE `grupo` = '" .$code."'");
	
		foreach ($query->result_array() as $result) {
				$setting_data[$result['name']] = $result['value'];
		}
		return $setting_data;
    }
	
}

