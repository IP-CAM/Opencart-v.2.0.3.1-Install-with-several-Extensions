<?php
class ModelSeoPowerPackSeoUrls extends Model {

	public function getDuplicates($data = array(), $language_id = 0) {
		$sql = sprintf('SELECT
			ua.url_alias_id,
			ua.query,
			ua.keyword ,
			ua.language_id
		FROM
			(SELECT
				`keyword`,
				`language_id`
			FROM
				`' . DB_PREFIX . 'url_alias`
			WHERE
				`language_id`=%d
			GROUP BY
				`keyword` HAVING count(*)>1
			) dkey
			LEFT JOIN `' . DB_PREFIX . 'url_alias` ua ON(dkey.`language_id`=%d AND dkey.`keyword`=ua.`keyword`)',
			$language_id,
			$language_id
		);

		$cond = array();

		if (!empty($data['filter_params'])) {
			$cond[] = "ua.query LIKE '" . $this->db->escape($data['filter_params']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$cond[] = "ua.keyword LIKE '" . $this->db->escape($data['filter_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'ua.keyword',
			'ua.query',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ua.keyword";
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

	public function getTotalDuplicates($data = array(), $language_id = 0) {
		$sql = sprintf('SELECT
			COUNT(DISTINCT ua.url_alias_id) AS total
		FROM
			(SELECT
				`keyword`,
				`language_id`
			FROM
				`' . DB_PREFIX . 'url_alias`
			WHERE
				`language_id`=%d
			GROUP BY
				`keyword` HAVING count(*)>1
			) dkey
			LEFT JOIN `' . DB_PREFIX . 'url_alias` ua ON(dkey.`language_id`=%d AND dkey.`keyword`=ua.`keyword`)',
			$language_id,
			$language_id
		);

		$cond = array();

		if (!empty($data['filter_params'])) {
			$cond[] = "ua.query LIKE '" . $this->db->escape($data['filter_params']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$cond[] = "ua.keyword LIKE '" . $this->db->escape($data['filter_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function updateUrlAlias($url_alias_id = 0, $keyword = '') {
		if (intval($url_alias_id) > 0 && strlen(trim($keyword)) > 0) {
			$this->db->query(sprintf('UPDATE ' . DB_PREFIX . "url_alias
			SET
				keyword='%s'
			WHERE
				url_alias_id=%d
			LIMIT 1", $this->db->escape($keyword), $url_alias_id));
		}
	}

	public function deleteUrlAlias($url_alias_id = 0) {
		if (intval($url_alias_id) > 0) {
			$this->db->query(sprintf('DELETE FROM ' . DB_PREFIX . "url_alias
			WHERE
				url_alias_id=%d
			LIMIT 1", $url_alias_id));
		}
	}

	public function getCustomUrls($data = array(), $language_id = 0) {
		$sql = 'SELECT
			ua.url_alias_id,
			ua.query,
			ua.keyword ,
			ua.language_id
		FROM
			`' . DB_PREFIX . 'url_alias` ua';

		$cond = array(
			'ua.language_id=' . $language_id,
			'(ua.query NOT LIKE \'product_id=%\' AND ua.query NOT LIKE \'category_id=%\'AND ua.query NOT LIKE \'information_id=%\' AND ua.query NOT LIKE \'manufacturer_id=%\')',
		);

		if (!empty($data['filter_params'])) {
			$cond[] = "ua.query LIKE '" . $this->db->escape($data['filter_params']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$cond[] = "ua.keyword LIKE '" . $this->db->escape($data['filter_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$sort_data = array(
			'ua.keyword',
			'ua.query',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ua.keyword";
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

	public function getTotalCustomUrls($data = array(), $language_id = 0) {
		$sql = 'SELECT
			COUNT(DISTINCT ua.url_alias_id) AS total
		FROM
			`' . DB_PREFIX . 'url_alias` ua';

		$cond = array(
			'ua.language_id=' . $language_id,
			'(ua.query NOT LIKE \'product_id=%\' AND ua.query NOT LIKE \'category_id=%\'AND ua.query NOT LIKE \'information_id=%\' AND ua.query NOT LIKE \'manufacturer_id=%\')',
		);

		if (!empty($data['filter_params'])) {
			$cond[] = "ua.query LIKE '" . $this->db->escape($data['filter_params']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$cond[] = "ua.keyword LIKE '" . $this->db->escape($data['filter_keyword']) . "%'";
		}

		if (isset($cond[0])) {
			$sql .= ' WHERE ' . implode(' AND ', $cond);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getUrlAliasById($url_alias_id) {
		$sql = 'SELECT
			ua.url_alias_id,
			ua.query,
			ua.keyword ,
			ua.language_id
		FROM
			`' . DB_PREFIX . 'url_alias` ua
		WHERE
			url_alias_id=' . (int) $url_alias_id . '
		LIMIT 1';

		$result = $this->db->query($sql);

		if ($result->num_rows) {
			return $result->row;
		} else {
			return array();
		}
	}

	public function getUrlAliasByQuery($query, $language_id) {
		$sql = 'SELECT
			ua.url_alias_id,
			ua.query,
			ua.keyword ,
			ua.language_id
		FROM
			`' . DB_PREFIX . 'url_alias` ua
		WHERE
			`language_id`=' . (int) $language_id . '
			AND `query` = \'' . $this->db->escape($query) . '\'
		LIMIT 1';

		$result = $this->db->query($sql);

		if ($result->num_rows) {
			return $result->row;
		} else {
			return array('keyword' => '');
		}
	}

	public function deleteUrlAliasByQuery($query) {
		$sql = 'DELETE FROM `' . DB_PREFIX . 'url_alias`
		WHERE
			`query` = \'' . $this->db->escape($query) . '\'';

		$result = $this->db->query($sql);
	}

	public function addNewUrlAlias($query = '', $keyword = '', $language_id = 0) {

		$result = 0;
		if (strlen(trim($query)) > 0 && strlen(trim($query)) > 0 && intval($language_id) > 0) {

			$sql = 'DELETE FROM `' . DB_PREFIX . 'url_alias` WHERE
			language_id=\''.$language_id.'\' AND query=\'' . $this->db->escape($query) . '\'';
			$result = $this->db->query($sql);

			$sql = 'INSERT INTO `' . DB_PREFIX . 'url_alias` SET
			query=\'' . $this->db->escape($query) . '\',
			keyword=\'' . $this->db->escape($keyword) . '\',
			language_id=' . $language_id;
			$result = $this->db->query($sql);
		}

		return $result;
	}
}