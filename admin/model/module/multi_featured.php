<?php
/**
 * Multiple Featured Module Pro
 * 
 * @author  Kyo (AKA Yasuhiro Sota)
 * @version 3.2.2
 * @license Commercial License
 * @package admin
 * @subpackage  admin.model
 */
class ModelModuleMultiFeatured extends Model {
  
/**
 * Holds the current version of the module.
 *
 * @var string
 */
  private $version = '3.2.2';

/**
 * Constructor.
 *
 * @param object $registry
 * @return void
 */
	public function __construct($registry) {
		parent::__construct($registry);
	}
      
/**
 * Get the current settings of a module for OpenCart 2.0.1.0 or later.
 *
 * @param string $group
 * @param integer $store_id
 * @return array $data
 */   
	public function getSetting($code, $store_id = 0) {
    
		$setting_data = array(); 
		
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "' ORDER BY `module_id` ASC");
    
    $index = 1;
    
		foreach ($query->rows as $result) {
      
      if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
        $setting_data[$this->db->escape($code) . '_' . $index] = unserialize($result['setting']);
        $setting_data[$this->db->escape($code) . '_' . $index]['module_id'] = $result['module_id'];
        
      } else { // for OpenCart 2.1.0.0 or later.
        $setting_data[$this->db->escape($code) . '_' . $index] = json_decode($result['setting']);
        $setting_data[$this->db->escape($code) . '_' . $index]->module_id = $result['module_id'];
      }
      
      $index++;
		}
    
		return $setting_data;
	}
  
/**
 * editSetting method for OpenCart 2.0.1.0 or later.
 *
 * @param string $code
 * @return array $data
 * @param integer $store_id
 */  
	public function editSetting($code, $data, $store_id = 0) {
    // Delete removed modules..
    $modules_to_be_deleted = null;

    foreach ($data as $key => $value) {
      if (substr($key, 0, strlen($code)) == $code) {
        if (is_array($value)) {
          if (isset($value['module_id']) && $value['module_id']) {
            $modules_to_be_deleted[] = (int)$value['module_id'];
          }
        }
      }
    }
    if ($modules_to_be_deleted) {
      $modules_to_be_deleted = implode (", ", $modules_to_be_deleted);
      
      $query = $this->db->query(
        "DELETE FROM `" . DB_PREFIX . "module` WHERE `module_id` IN ("
        . " SELECT * FROM ("
        . " SELECT `module_id` FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "' AND `module_id` NOT IN(" . $modules_to_be_deleted . ")"
        . ") AS m"
        . ")"
      );    
    }
    
    
    // Delete all the rows related to this module from setting table.
    $this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "'");

    
    // Save modules
		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
        
        if (is_array($value)) {
          
          // Save modules
          if (isset($value['module_id'])) {
            
            if (isset($value['module_id']) && $value['module_id']) {
              
              if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
                $this->db->query(
                    "UPDATE `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($value['name']) 
                    . "', `setting` = '" . $this->db->escape(serialize($value)) . "' WHERE `module_id` = '" . (int)$value['module_id'] . "'"
                );
              } else { // for OpenCart 2.1.0.0 or later.
                $this->db->query(
                    "UPDATE `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($value['name']) 
                    . "', `setting` = '" . $this->db->escape(json_encode($value)) . "' WHERE `module_id` = '" . (int)$value['module_id'] . "'"
                );
              }
              
            } else {
              
              if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
                $this->db->query(
                    "INSERT INTO `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($value['name']) 
                    . "', `code` = '" . $this->db->escape($code) . "', `setting` = '" . $this->db->escape(serialize($value)) . "'"
                );
              } else { // for OpenCart 2.1.0.0 or later.
                $this->db->query(
                    "INSERT INTO `" . DB_PREFIX . "module` SET `name` = '" . $this->db->escape($value['name']) 
                    . "', `code` = '" . $this->db->escape($code) . "', `setting` = '" . $this->db->escape(json_encode($value)) . "'"
                );
              }
            }
            
          } elseif ($key == $code . '_config') {
            
            if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
              $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
            } else { // for OpenCart 2.1.0.0 or later.
              $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1'");
            }
            
          }
          
        } else {
          // Save settings
          if (!is_array($value)) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
          } else {
            
            if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
              $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
            } else { // for OpenCart 2.1.0.0 or later.
              $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1'");
            }
          }
        }
			}
		}

	}
  
/**
 * Get the value of a product option.
 * This function is copied from OpenCart 1.5.6 since there does not exist in OpenCart 1.5.4.x or earlier.
 *
 * @param integer $option_value_id
 * @return array Single result row or empty array if not found.
 */ 
	public function getOptionValue($option_value_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option_value` `ov` LEFT JOIN `" . DB_PREFIX . "option_value_description` `ovd` ON (`ov`.`option_value_id` = `ovd`.`option_value_id`) WHERE `ov`.`option_value_id` = '" . (int)$option_value_id . "' AND `ovd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'");
		return $query->row;
	}
  
/**
 * Checks if OpenCart 2.0.3.1 or earlier
 *
 * @param void
 * @return bool True or false
 */
  public function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }
  
/**
 * Get the current version of the module.
 *
 * @param void
 * @return string The current version of the module.
 */
  public function version() {
    return $this->version;
  }

/**
 * install method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function install() {
    return true;
	}

/**
 * uninstall method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function uninstall() {
    return true;
	}
  
/**
 * upgrade method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function upgrade() {
    return false;
  }

}
