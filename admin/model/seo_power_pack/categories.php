<?php
class ModelSeoPowerPackCategories extends Model {

	public function getCategories($data = array(), $language_id = 0) {
		$sql = 'SELECT
			cd.category_id,
			cd.name,
			cd.meta_title ,
			cd.meta_keyword ,
			cd.meta_description
		FROM ' . DB_PREFIX . 'category_description cd';

		$cond = array(
			'cd.language_id=' . (int) $language_id,
		);

		if (!empty($data['filter_name'])) {
			$cond[] = "cd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "cd.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "cd.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "cd.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'cd.name',
			'cd.meta_title',
			'cd.meta_description',
			'cd.meta_keyword',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY cd.name";
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

	public function getTotalCategories($data = array(), $language_id = 0) {
		$sql = 'SELECT COUNT(DISTINCT cd.category_id) AS total FROM ' . DB_PREFIX . 'category_description cd';

		$cond = array(
			'cd.language_id=' . (int) $language_id,
		);

		if (!empty($data['filter_name'])) {
			$cond[] = "cd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "cd.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "cd.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "cd.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUrlAlias($category_id, $language_id) {
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query='category_id=" . $category_id . "' AND language_id = " . (int) $language_id . " LIMIT 1";

		$query = $this->db->query($sql);

		if (isset($query->row['keyword'])) {
			return $query->row['keyword'];
		} else {
			return '';
		}

	}
}