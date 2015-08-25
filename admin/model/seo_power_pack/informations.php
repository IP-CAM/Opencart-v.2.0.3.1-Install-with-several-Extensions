<?php
class ModelSeoPowerPackInformations extends Model {

	public function getInformations($data = array(), $language_id = 0) {
		$sql = 'SELECT
			info.information_id,
			info.title,
			info.meta_title ,
			info.meta_keyword ,
			info.meta_description
		FROM ' . DB_PREFIX . 'information_description info';

		$cond = array(
			'info.language_id=' . (int) $language_id,
		);

		if (!empty($data['filter_name'])) {
			$cond[] = "info.title LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "info.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "info.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "info.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'info.title',
			'info.meta_title',
			'info.meta_description',
			'info.meta_keyword',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY info.title";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$result = $this->db->query($sql);

		return $result->rows;
	}

	public function getTotalInformations($data = array(), $language_id = 0) {
		$sql = 'SELECT COUNT(DISTINCT info.information_id) AS total FROM ' . DB_PREFIX . 'information_description info';

		$cond = array(
			'info.language_id=' . (int) $language_id,
		);

		if (!empty($data['filter_name'])) {
			$cond[] = "info.title LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "info.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "info.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "info.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUrlAlias($information_id, $language_id) {
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query='information_id=" . $information_id . "' AND language_id = " . (int) $language_id . " LIMIT 1";

		$query = $this->db->query($sql);

		if (isset($query->row['keyword'])) {
			return $query->row['keyword'];
		} else {
			return '';
		}

	}
}