<?php
class ModelSeoPowerPackManufacturers extends Model {

	public function getManufacturers($data = array()) {
		$sql = 'SELECT
			m.manufacturer_id,
			m.name
		FROM ' . DB_PREFIX . 'manufacturer m';

		$cond = array();
		if (!empty($data['filter_name'])) {
			$cond[] = "m.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'm.name',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY m.name";
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

	public function getTotalManufacturers($data = array()) {
		$sql = 'SELECT COUNT(m.manufacturer_id) AS total FROM ' . DB_PREFIX . 'manufacturer m';

		$cond = array();
		if (!empty($data['filter_name'])) {
			$cond[] = "m.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUrlAlias($manufacturer_id) {
		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query='manufacturer_id=" . $manufacturer_id . "' LIMIT 1";

		$query = $this->db->query($sql);

		if (isset($query->row['keyword'])) {
			return $query->row['keyword'];
		} else {
			return '';
		}

	}
}