<?php
class ModelCatalogUrlAlias extends Model {

				public function getUrlAliasByLanguage($keyword, $language_id = 0) {
					$query = $this->db->query("SELECT 
						* 
					FROM 
						" . DB_PREFIX . "url_alias 
					WHERE
						language_id = '" . (int)$language_id . "' AND
						keyword = '" . $this->db->escape($keyword) . "'
					LIMIT 1
					");

					return $query->row;
				}

				public function getAllUrlAlias($field_name='blank', $id = 0) {
					$query = $this->db->query("SELECT 
						`keyword`, 
						`language_id`
					FROM 
						" . DB_PREFIX . "url_alias 
					WHERE 
						query = '".$field_name."=" . (int)$id . "'
					");

					$urls_alias = array();
					if($query->num_rows){
						foreach($query->rows as $row){
							$urls_alias[$row['language_id']] = $row['keyword'];
						}
					}
					
					return $urls_alias;
				}
			
	public function getUrlAlias($keyword) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "'");

		return $query->row;
	}
}