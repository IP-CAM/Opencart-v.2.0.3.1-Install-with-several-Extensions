<?php
class ControllerSeoPowerPackSitemap extends Controller {

	public function get_all() {
		$feeds_dir = DIR_IMAGE . '../feeds';

		$site_url = intval($this->config->get('config_secure')) == 1 ? HTTPS_SERVER : HTTP_SERVER;

		$sitemap_files = array();
		if (is_dir($feeds_dir)) {
			if ($dh = opendir($feeds_dir)) {
				$index = 0;
				while (($file = readdir($dh)) !== false) {
					if ($file != '.' && $file != '..' && $file != '.DS_Store') {
						$sitemap_files[$index]['url'] = $site_url . 'feeds/' . $file;
						$index++;
					}

				}
				closedir($dh);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($sitemap_files));
	}

	public function generate_sitemaps() {
		if ($this->__hasPermission('modify','seo_power_pack/advanced')) {
			@mkdir(DIR_IMAGE . '../feeds');

			$config_language_id   = $this->config->get('config_language_id');
			$config_language_code = $this->config->get('config_language');

			$stores    = $this->getStores();
			$languages = $this->getLanguages();

			$site_url = intval($this->config->get('config_secure')) == 1 ? HTTPS_SERVER : HTTP_SERVER;

			foreach ($stores as $store) {
				foreach ($languages as $language) {

					$this->config->set('config_language_id', $language['language_id']);
					$this->config->set('config_language', $language['code']);

					/* Categories Sitemap */

					if ($store['store_id'] == 0) {
						$cfilename = $language['code'] . '.sitemap.categories.xml';
					} else {
						$cfilename = $this->model_seo_power_pack_setting->url_slug($store['name']) . '.' . $language['code'] . '.sitemap.categories.xml';
					}

					$this->create_sitemap_file($cfilename, $this->generate_categories_sitemaps(0, $store['store_id'], $language['language_id']));

					/* Categories Sitemap */

					/* Pages Sitemap */

					if ($store['store_id'] == 0) {
						$ifilename = $language['code'] . '.sitemap.pages.xml';
					} else {
						$ifilename = $this->model_seo_power_pack_setting->url_slug($store['name']) . '.' . $language['code'] . '.sitemap.pages.xml';
					}

					$this->create_sitemap_file($ifilename, $this->generate_pages_sitemaps($store['store_id'], $language['language_id']));

					/* Pages Sitemap */

					/* Product Sitemap */

					if ($store['store_id'] == 0) {
						$pfilename = $language['code'] . '.sitemap.products.xml';
					} else {
						$pfilename = $this->model_seo_power_pack_setting->url_slug($store['name']) . '.' . $language['code'] . '.sitemap.products.xml';
					}

					$this->create_sitemap_file($pfilename, $this->generate_product_sitemaps($store['store_id'], $language['language_id']));

					/* Product Sitemap */

					/* Sitemap Index */

					if ($store['store_id'] == 0) {
						$si_filename = $language['code'] . '.sitemap.index.xml';
					} else {
						$si_filename = $this->model_seo_power_pack_setting->url_slug($store['name']) . '.' . $language['code'] . '.sitemap.index.xml';
					}

					$sitemaps_indexes = array(
						array(
							'loc'     => $site_url . 'feeds/' . $cfilename,
							'lastmod' => date('Y-m-d'),
						),
						array(
							'loc'     => $site_url . 'feeds/' . $ifilename,
							'lastmod' => date('Y-m-d'),
						),
						array(
							'loc'     => $site_url . 'feeds/' . $pfilename,
							'lastmod' => date('Y-m-d'),
						),
					);

					$this->create_sitemap_index($si_filename, $sitemaps_indexes);

					/* Sitemap Index */

				}
			}

			$this->config->set('config_language_id', $config_language_id);
			$this->config->set('config_language', $config_language_code);

			$result = array('success' => 1);

			header('Content-Type: application/json');
			echo json_encode($result);
			exit;
		}

	}

	public function create_sitemap_index($filename, $sitemaps_arr) {
		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL, FILE_APPEND);

		foreach ($sitemaps_arr as $data_item) {
			$file_data = '    <sitemap>' . PHP_EOL;
			$file_data .= '        <loc>' . $data_item['loc'] . '</loc>' . PHP_EOL;
			$file_data .= '        <lastmod>' . $data_item['lastmod'] . '</lastmod>' . PHP_EOL;
			$file_data .= '    </sitemap>' . PHP_EOL;

			file_put_contents(DIR_IMAGE . '../feeds/' . $filename, $file_data, FILE_APPEND);
		}

		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '</sitemapindex>' . PHP_EOL, FILE_APPEND);
	}

	public function create_sitemap_file($filename, $data_arr) {
		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL, FILE_APPEND);

		foreach ($data_arr as $data_item) {
			$file_data = '    <url>' . PHP_EOL;
			$file_data .= '        <loc>' . $data_item['loc'] . '</loc>' . PHP_EOL;
			$file_data .= '        <lastmod>' . $data_item['lastmod'] . '</lastmod>' . PHP_EOL;
			$file_data .= '        <changefreq>yearly</changefreq>' . PHP_EOL;
			$file_data .= '        <priority>1.0</priority>' . PHP_EOL;
			$file_data .= '    </url>' . PHP_EOL;

			file_put_contents(DIR_IMAGE . '../feeds/' . $filename, $file_data, FILE_APPEND);
		}

		file_put_contents(DIR_IMAGE . '../feeds/' . $filename, '</urlset>' . PHP_EOL, FILE_APPEND);
	}

	public function generate_product_sitemaps($store_id = 0, $language_id = 0) {
		$sql = "SELECT
			p.product_id,
			p.date_modified
		FROM
			" . DB_PREFIX . "product p
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
		WHERE
			p.status = '1' AND
			p.date_available <= NOW() AND
			pd.language_id = '" . (int) $language_id . "' AND
			p2s.store_id = '" . (int) $store_id . "'
		ORDER BY
			p.sort_order,
			LCASE(pd.name) ASC
		";

		$products = $this->db->query($sql);

		$products_array = array();
		if ($products->num_rows) {
			foreach ($products->rows as $product) {

				$date_modified = explode(' ', $product['date_modified']);

				$products_array[] = array(
					'lastmod' => $date_modified[0],
					'loc'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
				);
			}
		}

		return $products_array;
	}

	public function generate_pages_sitemaps($store_id = 0, $language_id = 0) {
		$pages = $this->getInformations($store_id, $language_id);

		$page_array = array();
		foreach ($pages as $page) {
			$page_array[] = array(
				'lastmod' => date('Y-m-d'),
				'loc'     => $this->url->link('information/information', 'information_id=' . $page['information_id']),
			);
		}

		return $page_array;
	}

	public function getInformations($store_id = 0, $language_id = 0) {
		$query = $this->db->query("SELECT *
		FROM
			" . DB_PREFIX . "information i
			LEFT JOIN " . DB_PREFIX . "information_description id ON (id.information_id = i.information_id)
			LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id)
		WHERE
			i2s.store_id = '" . (int) $store_id . "' AND
			id.language_id = '" . (int) $language_id . "' AND
			i.status = '1'
		ORDER BY
			i.sort_order,
			LCASE(id.title) ASC
		");

		return $query->rows;
	}

	public function generate_categories_sitemaps($category_id = 0, $store_id = 0, $language_id = 0, $path = null) {
		$categories = $this->getCategories($category_id, $store_id, $language_id);

		$cat_array = array();
		foreach ($categories as $category) {
			if ($category_id > 0 || $category['top']) {

				$new_path = '';

				if ($path) {
					$new_path = $path . '_' . $category['category_id'];
				} else {
					$new_path = $category['category_id'];
				}

				$date_modified = explode(' ', $category['date_modified']);
				// Level 1
				$cat_array[] = array(
					'lastmod' => $date_modified[0],
					'loc'     => $this->url->link('product/category', 'path=' . $new_path),
				);

				$children = $this->generate_categories_sitemaps($category['category_id'], $store_id, $language_id, $new_path);

				$cat_array = array_merge($cat_array, $children);
			}
		}

		return $cat_array;
	}

	public function getCategories($parent_id = 0, $store_id = 0, $language_id = 0) {
		$query = $this->db->query("SELECT *
		FROM
			" . DB_PREFIX . "category c
			LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id)
			LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id)
		WHERE
			c.parent_id = '" . (int) $parent_id . "' AND
			c2s.store_id = '" . (int) $store_id . "'  AND
			cd.language_id = '" . (int) $language_id . "'  AND
			c.status = '1'
		ORDER BY
			c.sort_order,
			LCASE(cd.name)
		");

		return $query->rows;
	}

	public function getStores($data = array()) {

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store");

		if ($query->num_rows) {
			$store_data = $query->rows;
		} else {
			$store_data = array(
				0 => array(
					'store_id' => 0,
					'name'     => 'Default',
				),
			);
		}

		return $store_data;
	}

	public function getLanguages() {

		$language_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE status = 1");

		foreach ($query->rows as $result) {
			$language_data[$result['code']] = array(
				'language_id' => $result['language_id'],
				'name'        => $result['name'],
				'code'        => $result['code'],
			);
		}

		return $language_data;

	}

	private function __hasPermission($action, $path) {

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int) $this->session->data['user_id'] . "' AND status = '1'");

			$permission = array();
			if ($user_query->num_rows) {

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int) $this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int) $user_query->row['user_group_id'] . "'");

				$permissions = unserialize($user_group_query->row['permission']);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$permission[$key] = $value;
					}
				}
			}

			if (isset($permission[$action])) {
				return in_array($path, $permission[$action]);
			}
		}

		return false;
	}
}