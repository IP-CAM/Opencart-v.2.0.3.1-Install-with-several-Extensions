<?php
class ModelSeoPowerPackProducts extends Model {

	public function getProducts($data = array(), $language_id = 0) {
		$sql = "SELECT
			p.product_id,
			pd.name,
			pd.meta_title ,
			pd.meta_keyword ,
			pd.meta_description,
			p.image,
			pd.tag
		FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id=" . (int) $language_id . ") ";

		$cond = array();

		if (!empty($data['filter_name'])) {
			$cond[] = "pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "pd.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "pd.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "pd.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (!empty($data['filter_tag'])) {
			$cond[] = "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'pd.name',
			'pd.meta_title',
			'pd.meta_description',
			'pd.meta_keyword',
			'pd.tag',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY pd.name";
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

	public function getTotalProducts($data = array(), $language_id = 0) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = " . (int) $language_id . ")";

		$cond = array();

		if (!empty($data['filter_name'])) {
			$cond[] = "pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_meta_title'])) {
			$cond[] = "pd.meta_title LIKE '%" . $this->db->escape($data['filter_meta_title']) . "%'";
		}

		if (!empty($data['filter_meta_description'])) {
			$cond[] = "pd.meta_description LIKE '%" . $this->db->escape($data['filter_meta_description']) . "%'";
		}

		if (!empty($data['filter_meta_keyword'])) {
			$cond[] = "pd.meta_keyword LIKE '%" . $this->db->escape($data['filter_meta_keyword']) . "%'";
		}

		if (!empty($data['filter_tag'])) {
			$cond[] = "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUrlAlias($product_id, $language_id) {
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query='product_id=" . $product_id . "' AND language_id = " . (int) $language_id . " LIMIT 1";

		$query = $this->db->query($sql);

		if (isset($query->row['keyword'])) {
			return $query->row['keyword'];
		} else {
			return '';
		}

	}
}