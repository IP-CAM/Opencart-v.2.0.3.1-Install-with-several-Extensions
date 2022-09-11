<?php
class ModelSeoPowerPackSettings extends Model {

	public function updateProductName($product_id, $names = array()) {
		foreach ($names as $language_id => $name) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET name='" . $this->db->escape($name) . "' WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateProductMetaTitle($product_id, $titles = array()) {
		foreach ($titles as $language_id => $lang_title) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_title='" . $this->db->escape($lang_title) . "' WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateProductMetaDescription($product_id, $meta_descs = array()) {
		foreach ($meta_descs as $language_id => $meta_desc) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description='" . $this->db->escape($meta_desc) . "' WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateProductMetaKeyword($product_id, $meta_keys = array()) {
		foreach ($meta_keys as $language_id => $meta_key) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword='" . $this->db->escape($meta_key) . "' WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateProductTags($product_id, $tags = array()) {
		foreach ($tags as $language_id => $tag) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag='" . $this->db->escape($tag) . "' WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function renameProductImageName($product_id, $old_name, $new_name) {
                if(!file_exists(DIR_IMAGE . 'webby_pi/product_' . $product_id))
		@mkdir(DIR_IMAGE . 'webby_pi/product_' . $product_id, 0755, TRUE);

		$keep_files = array();

		if (file_exists(DIR_IMAGE . $old_name) && is_file(DIR_IMAGE . $old_name)) {
			$path_info = pathinfo(DIR_IMAGE . $old_name);
			//$directory_name = str_replace(DIR_IMAGE, '', $path_info['dirname']);
			$new_file_name = $this->db->escape('webby_pi/product_' . $product_id . '/' . $new_name . '.' . $path_info['extension']);

			if ($new_file_name != $old_name && !strstr($old_name, 'no_image')) {
				@copy(DIR_IMAGE . $old_name, DIR_IMAGE . $new_file_name);
				$this->__updateProductImageName($product_id, $new_file_name);
			}

			$keep_files[] = DIR_IMAGE . $new_file_name;
		}

		$keep_files = array_merge($keep_files, $this->__renameProductImagesImages($product_id, $new_name));

		$files = glob(DIR_IMAGE . 'webby_pi/product_' . $product_id . '/*'); // get all file names

		if (is_array($files)) {
			foreach ($files as $file) {
				// iterate files
				if (is_file($file) && !in_array($file, $keep_files)) {
					unlink($file);
				}
				// delete file
			}
		}

	}
/*
[dirname] => /Users/apple/Documents/websites/opencart_new/image/catalog/demo
[basename] => htc_touch_hd_1.jpg
[extension] => jpg
[filename] => htc_touch_hd_1
 */
	private function __renameProductImagesImages($product_id, $new_name) {
		$result = $this->db->query("SELECT product_image_id,image FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");

		$keep_files = array();

		if ($result->num_rows) {
			foreach ($result->rows as $key => $row) {
				if (file_exists(DIR_IMAGE . $row['image']) && is_file(DIR_IMAGE . $row['image'])) {
					$path_info = pathinfo(DIR_IMAGE . $row['image']);
					//$directory_name = str_replace(DIR_IMAGE, '', $path_info['dirname']);
					$new_file_name = $this->db->escape('webby_pi/product_' . $product_id . '/' . $new_name . '-' . $row['product_image_id'] . '.' . $path_info['extension']);

					if ($new_file_name != $row['image'] && !strstr($row['image'], 'no_image')) {
						@copy(DIR_IMAGE . $row['image'], DIR_IMAGE . $new_file_name);

						$this->updateProductImagesImageName($row['product_image_id'], $new_file_name);
					}

					$keep_files[] = DIR_IMAGE . $new_file_name;

				}
			}
		}

		return $keep_files;
	}

	public function removeProductImagePattern() {

		$products_total = $this->db->query("SELECT count(*) as total FROM " . DB_PREFIX . "product");

		if ($products_total->num_rows) {
			if (intval($products_total->row['total']) > 100) {
				$total_records = $products_total->row['total'];
				if ($total_records % 100 == 0) {
					$total_pages = $total_records / 100;
				} else {
					$total_pages = ($total_records / 100) + 1;
				}

				for ($page = 0; $page < $total_pages;) {
					$products = $this->db->query(sprintf("SELECT product_id,image FROM " . DB_PREFIX . "product LIMIT %d, %d", $page, 100));

					if ($products->num_rows) {
						foreach ($products->rows as $product) {
							$new_name = 'p_' . $product['product_id'];
							if (file_exists(DIR_IMAGE . $product['image']) && is_file(DIR_IMAGE . $product['image'])) {
								$path_info      = pathinfo(DIR_IMAGE . $product['image']);
								$directory_name = str_replace(DIR_IMAGE, '', $path_info['dirname']);
								$new_file_name  = $this->db->escape($directory_name . '/' . $new_name . '.' . $path_info['extension']);

								if ($new_file_name != $product['image'] && !strstr($product['image'], 'no_image')) {
									if (rename(DIR_IMAGE . $product['image'], DIR_IMAGE . $new_file_name)) {
										$this->__updateProductImageName($product['product_id'], $new_file_name);
									}
								}
							}

							$this->__renameProductImagesImages($product['product_id'], $new_name);
						}
					}

					$page += 100;
					unset($products);
				}
			} else {
				$products = $this->db->query("SELECT product_id,image FROM " . DB_PREFIX . "product");

				if ($products->num_rows) {
					foreach ($products->rows as $product) {
						$new_name = 'p_' . $product['product_id'];
						if (file_exists(DIR_IMAGE . $product['image']) && is_file(DIR_IMAGE . $product['image'])) {
							$path_info      = pathinfo(DIR_IMAGE . $product['image']);
							$directory_name = str_replace(DIR_IMAGE, '', $path_info['dirname']);
							$new_file_name  = $this->db->escape($directory_name . '/' . $new_name . '.' . $path_info['extension']);

							if ($new_file_name != $product['image'] && !strstr($product['image'], 'no_image')) {
								if (rename(DIR_IMAGE . $product['image'], DIR_IMAGE . $new_file_name)) {
									$this->__updateProductImageName($product['product_id'], $new_file_name);
								}
							}
						}

						$this->__renameProductImagesImages($product['product_id'], $new_name);
					}
				}
			}
		}
	}

	private function __updateProductImageName($product_id, $new_name) {
		$this->db->query("UPDATE  " . DB_PREFIX . "product SET image='" . $new_name . "' WHERE product_id = '" . (int) $product_id . "' LIMIT 1");

	}

	private function updateProductImagesImageName($product_image_id, $new_name) {
		$this->db->query("UPDATE  " . DB_PREFIX . "product_image SET image='" . $new_name . "' WHERE product_image_id = '" . (int) $product_image_id . "' LIMIT 1");
	}

	public function removeProductMetaTitle() {
		return $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_title=''");
	}

	public function removeProductMetaDescription() {
		return $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_description=''");
	}

	public function removeProductMetaKeyword() {
		return $this->db->query("UPDATE " . DB_PREFIX . "product_description SET meta_keyword=''");
	}

	public function removeProductTags() {
		return $this->db->query("UPDATE " . DB_PREFIX . "product_description SET tag=''");
	}

	public function addCategorySEOUrlByLanguage($category_id, $seo_keyword = '', $language_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int) $category_id . "' AND language_id=" . $language_id);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='category_id=" . (int) $category_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
	}

	public function addProductSEOUrlByLanguage($product_id, $seo_keyword = '', $language_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "' AND language_id=" . $language_id);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='product_id=" . (int) $product_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
	}

	public function addProductSEOUrl($product_id, $seo_keywords = array()) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "'");
		foreach ($seo_keywords as $language_id => $seo_keyword) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='product_id=" . (int) $product_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
		}
	}

	public function removeProductSEOUrl() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'product_id=%'");
	}

	public function getActiveLanguages() {
		$result = $this->db->query("SELECT language_id,name,image FROM " . DB_PREFIX . "language WHERE status = 1");
		if ($result->num_rows) {
			return $result->rows;
		} else {
			return array();
		}
	}

	public function getLanguageIdByCode($code = '') {
		$result = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $code . "' LIMIT 1");
		if ($result->num_rows) {
			return $result->row['language_id'];
		} else {
			return 0;
		}
	}

	public function getAllProductIds() {
		$result = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product");

		if ($result->num_rows) {
			return $result->rows;
		} else {
			return array();
		}
	}

	public function getCategory($category_id, $language_id) {
		$query = $this->db->query("SELECT
				DISTINCT *,
				(SELECT
					GROUP_CONCAT(cd1.name ORDER BY level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;')
				FROM
					" . DB_PREFIX . "category_path cp
					LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id AND cp.category_id != cp.path_id)
				WHERE
					cp.category_id = c.category_id AND
					cd1.language_id = '" . (int) $language_id . "'
				GROUP BY
					cp.category_id) AS path
					FROM
						" . DB_PREFIX . "category c
						LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (c.category_id = cd2.category_id)
					WHERE
						c.category_id = '" . (int) $category_id . "' AND cd2.language_id = '" . (int) $language_id . "'");

		return $query->row;
	}

	public function getAllCategoryIds() {
		$result = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category");

		if ($result->num_rows) {
			return $result->rows;
		} else {
			return array();
		}
	}

	public function getAllManufacturers() {
		$result = $this->db->query("SELECT manufacturer_id,name FROM " . DB_PREFIX . "manufacturer");

		if ($result->num_rows) {
			return $result->rows;
		} else {
			return array();
		}
	}

	public function getManufacturer($manufacturer_id) {
		$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");

		return $query->row;
	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT
			product_id,
			model,
			price,
			sku,
			upc,
			ean,
			jan,
			isbn,
			mpn,
			location,
			image,
			manufacturer_id
		FROM
			" . DB_PREFIX . "product
		WHERE
			product_id = '" . (int) $product_id . "' LIMIT 1");

		return $query->row;
	}

	public function getProductDescriptions($product_id, $language_id = 0) {
		$product_description_data = array();

		if ($language_id == 0) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");

			foreach ($query->rows as $result) {
				$product_description_data[$result['language_id']] = array(
					'name'        => trim($result['name']),
					'description' => trim(strip_tags($result['description'])),
				);
			}

		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE language_id=" . $language_id . " AND product_id = '" . (int) $product_id . "'");

			if ($query->num_rows) {
				foreach ($query->rows as $result) {
					$product_description_data[$result['language_id']] = array(
						'name'        => trim($result['name']),
						'description' => trim(strip_tags($result['description'])),
					);
				}

			}

		}

		return $product_description_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getCategoryDescriptions($category_id, $include_subcat = false) {
		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $category_id . "'");

		if ($include_subcat) {
			foreach ($query->rows as $result) {
				$category_description_data[$result['language_id']] = array(
					'name'        => trim($result['name']),
					'description' => $this->strip_intelligent($result['description']),
					'sub_cats'    => $this->getSubCategoryNames($category_id, $result['language_id']),
				);
			}
		} else {
			foreach ($query->rows as $result) {
				$category_description_data[$result['language_id']] = array(
					'name'        => trim($result['name']),
					'description' => $this->strip_intelligent($result['description']),
				);
			}

		}

		return $category_description_data;
	}

	private function strip_intelligent($html = '') {
		return trim(preg_replace('#<[^>]+>#', ' ', html_entity_decode($html)));
	}

	public function getSubCategoryNames($category_id, $language_id) {
		$category_name = array();
		$result        = $this->db->query("SELECT cd.name as cname FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON(c.category_id = cd.category_id AND language_id=" . (int) $language_id . ") WHERE parent_id = '" . (int) $category_id . "'");

		if ($result->num_rows) {
			foreach ($result->rows as $row) {
				$category_name[] = $row['cname'];
			}

		}

		return implode(',', $category_name);
	}

	public function addCategorySEOUrl($category_id, $seo_keywords = array()) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'category_id=" . (int) $category_id . "'");
		foreach ($seo_keywords as $language_id => $seo_keyword) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='category_id=" . (int) $category_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
		}
	}

	public function removeCategorySEOUrl() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'category_id=%'");
	}

	public function updateCategoryName($category_id, $names = array()) {
		foreach ($names as $language_id => $name) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET name='" . $this->db->escape($name) . "' WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateCategoryMetaTitle($category_id, $titles = array()) {
		foreach ($titles as $language_id => $lang_title) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_title='" . $this->db->escape($lang_title) . "' WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateCategoryMetaDescription($category_id, $meta_descs = array()) {
		foreach ($meta_descs as $language_id => $meta_desc) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_description='" . $this->db->escape($meta_desc) . "' WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function updateCategoryMetaKeyword($category_id, $meta_keys = array()) {
		foreach ($meta_keys as $language_id => $meta_key) {
			$this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keyword='" . $this->db->escape($meta_key) . "' WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
		}
	}

	public function removeCategoryMetaTitle() {
		return $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_title=''");
	}

	public function removeCategoryMetaDescription() {
		return $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_description=''");
	}

	public function removeCategoryMetaKeyword() {
		return $this->db->query("UPDATE " . DB_PREFIX . "category_description SET meta_keyword=''");
	}

	public function addManufacturerSEOUrl($manufacturer_id, $seo_keyword = '') {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'manufacturer_id=" . (int) $manufacturer_id . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,query='manufacturer_id=" . (int) $manufacturer_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
	}

	public function updateManufacturerName($manufacturer_id, $name = '') {
		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET name='" . $this->db->escape($name) . "' WHERE manufacturer_id = '" . (int) $manufacturer_id . "' LIMIT 1");
	}

	public function removeManufacturerSEOUrl() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'manufacturer_id=%'");
	}

	public function getAllInformation() {
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_description");

		if ($result->num_rows) {
			return $result->rows;
		} else {
			return array();
		}
	}

	public function updateInformationMetaTitle($information_id, $title = '', $language_id = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_title='" . $this->db->escape($title) . "' WHERE information_id = '" . (int) $information_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
	}

	public function updateInformationMetaDescription($information_id, $meta_desc = '', $language_id = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_description='" . $this->db->escape($meta_desc) . "' WHERE information_id = '" . (int) $information_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
	}

	public function updateInformationMetaKeyword($information_id, $meta_keyword = '', $language_id = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_keyword='" . $this->db->escape($meta_keyword) . "' WHERE information_id = '" . (int) $information_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
	}

	public function updateInformationTitle($information_id, $title = '', $language_id = 0) {
		$this->db->query("UPDATE " . DB_PREFIX . "information_description SET title='" . $this->db->escape($title) . "' WHERE information_id = '" . (int) $information_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");
	}

	public function addInformationSEOUrlByLanguage($information_id, $seo_keyword = '', $language_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'information_id=" . (int) $information_id . "' AND language_id=" . $language_id);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='information_id=" . (int) $information_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
	}

	public function removeInformationMetaTitle() {
		return $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_title=''");
	}

	public function removeInformationMetaDescription() {
		return $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_description=''");
	}

	public function removeInformationMetaKeyword() {
		return $this->db->query("UPDATE " . DB_PREFIX . "information_description SET meta_keyword=''");
	}

	public function addInformationSEOUrl($information_id, $seo_keyword = '', $language_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE language_id=" . (int) $language_id . " AND query = 'information_id=" . (int) $information_id . "' LIMIT 1");
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET url_alias_id=NULL,language_id=" . (int) $language_id . ",query='information_id=" . (int) $information_id . "',keyword = '" . $this->db->escape($seo_keyword) . "'");
	}

	public function removeInformationSEOUrl() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query LIKE 'information_id=%'");
	}

	/* Product Related Products */
	public function removeProductRelatedProducts() {

		$this->db->query('TRUNCATE TABLE `' . DB_PREFIX . 'product_related`');
	}

	public function createProductRelatedProducts($no_of_rel_prods = 0) {

		if ($no_of_rel_prods > 25) {
			$no_of_rel_prods = 25;
		}

		$this->removeProductRelatedProducts();

		$products_total = $this->db->query("SELECT count(*) as total FROM " . DB_PREFIX . "product");

		if ($products_total->num_rows) {
			if (intval($products_total->row['total']) > 100) {

				$total_records = $products_total->row['total'];
				if ($total_records % 100 == 0) {
					$total_pages = $total_records / 100;
				} else {
					$total_pages = ($total_records / 100) + 1;
				}

				for ($page = 0; $page < $total_pages;) {
					$products = $this->db->query(sprintf("SELECT product_id,manufacturer_id FROM " . DB_PREFIX . "product LIMIT %d, %d", $page, 100));

					if ($products->num_rows) {
						foreach ($products->rows as $product) {
							$related_product_ids = $this->__getRelatedProductIds($product['product_id'], $product['manufacturer_id'], $no_of_rel_prods, $products_total->row['total']);
							$this->__addRelatedProduct($product['product_id'], $related_product_ids);
						}
					}

					$page += 100;
					unset($products);
				}
			} else {
				$products = $this->db->query("SELECT product_id,manufacturer_id FROM " . DB_PREFIX . "product");

				if ($products->num_rows) {
					foreach ($products->rows as $product) {
						$related_product_ids = $this->__getRelatedProductIds($product['product_id'], $product['manufacturer_id'], $no_of_rel_prods, $products_total->row['total']);
						$this->__addRelatedProduct($product['product_id'], $related_product_ids);
					}
				}
			}
		}
	}

	public function getNewImageName($value, $data, $cat_names, $patterns) {
		$data['manufacturer'] = '';
		if (intval($data['manufacturer_id']) > 0) {
			$manufacturer_info = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id=" . $data['manufacturer_id']);
			if ($manufacturer_info->num_rows) {
				$data['manufacturer'] = $manufacturer_info->row['name'];

			}
		}

		$new_image_name = str_replace(array(
			'[ name ]',
			'[ model ]',
			'[ price ]',
			'[ sku ]',
			'[ upc ]',
			'[ ean ]',
			'[ jan ]',
			'[ isbn ]',
			'[ mpn ]',
			'[ location ]',
			'[ manufacturer ]',
			'[ category ]',
		), array(
			strlen($value['name']) == 0 ? '' : $value['name'] . '-',
			strlen($data['model']) == 0 ? '' : $data['model'] . '-',
			strlen($data['price']) == 0 ? '' : $data['price'] . '-',
			strlen($data['sku']) == 0 ? '' : $data['sku'] . '-',
			strlen($data['upc']) == 0 ? '' : $data['upc'] . '-',
			strlen($data['ean']) == 0 ? '' : $data['ean'] . '-',
			strlen($data['jan']) == 0 ? '' : $data['jan'] . '-',
			strlen($data['isbn']) == 0 ? '' : $data['isbn'] . '-',
			strlen($data['mpn']) == 0 ? '' : $data['mpn'] . '-',
			strlen($data['location']) == 0 ? '' : $data['location'] . '-',
			strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . '-',
			strlen($cat_names) == 0 ? '' : $cat_names . '-',
		),
			$this->config->get('seo_pp_product_image_name_pattern')
		);

		return $new_image_name;
	}

	public function generateRelatedProduct($product_id = 0, $manufacturer_id = 0, $no_of_rel_prods = 0) {
		$products_total      = $this->db->query("SELECT count(*) as total FROM " . DB_PREFIX . "product");
		$related_product_ids = $this->__getRelatedProductIds($product_id, $manufacturer_id, $no_of_rel_prods, $products_total->row['total']);
		$this->__addRelatedProduct($product_id, $related_product_ids);
	}

	private function __addRelatedProduct($product_id = 0, $related_product_ids = 0) {
		$this->db->query('DELETE FROM `' . DB_PREFIX . 'product_related` WHERE product_id=' . (int) $product_id);
		if (count($related_product_ids) > 0) {
			$sql = array();
			foreach ($related_product_ids as $related_product_id) {
				$sql[] = '(' . $product_id . ', ' . $related_product_id . ')';
			}
			$this->db->query('INSERT INTO `' . DB_PREFIX . 'product_related` (product_id, related_id) VALUES ' . implode(',', $sql));
		}

	}

	private function __getRelatedProductIds($product_id = 0, $manufacturer_id = 0, $count = 0, $products_total = 0) {
		$result = $this->db->query('SELECT
			category_id,
			product_id
		FROM
			' . DB_PREFIX . 'product_to_category
		WHERE
			category_id IN (
				SELECT
					category_id
				FROM
					' . DB_PREFIX . 'product_to_category
				WHERE
					product_id=' . (int) $product_id . ') AND
			product_id<>' . (int) $product_id . '
		GROUP BY
			product_id
		LIMIT ' . $count);

		if ($result->num_rows) {
			$product_ids  = array();
			$category_ids = array();
			foreach ($result->rows as $rec) {
				$product_ids[$rec['product_id']]   = $rec['product_id'];
				$category_ids[$rec['category_id']] = $rec['category_id'];
			}

			if (count($product_ids) < $count && $products_total > $count) {
				$child_cat_ids = $this->__getChildCategories($category_ids);

				if (count($child_cat_ids) > 0) {
					$result_childs = $this->db->query('SELECT
						category_id,
						product_id
					FROM
						' . DB_PREFIX . 'product_to_category
					WHERE
						category_id IN (' . implode(',', $child_cat_ids) . ') AND
						product_id<>' . (int) $product_id . '
					GROUP BY
						product_id
					LIMIT ' . ($count - count($product_ids)));

					if ($result_childs->num_rows) {
						foreach ($result_childs->rows as $rec2) {
							$product_ids[$rec2['product_id']] = $rec2['product_id'];
						}
					}
				}

				if (count($product_ids) < $count) {
					$result_manufacturers_products = $this->db->query('SELECT
						product_id
					FROM
						' . DB_PREFIX . 'product
					WHERE
						manufacturer_id =' . (int) $manufacturer_id . '
					LIMIT ' . ($count - count($product_ids)));

					if ($result_manufacturers_products->num_rows) {
						foreach ($result_manufacturers_products->rows as $rec3) {
							$product_ids[$rec3['product_id']] = $rec3['product_id'];
						}
					}
				}
			}

			return $product_ids;
		}

		return array();
	}

	private function __getChildCategories($category_ids) {

		if (count($category_ids) > 0) {
			$result = $this->db->query('SELECT
				category_id
			FROM
				' . DB_PREFIX . 'category
			WHERE
				parent_id IN (' . implode(',', $category_ids) . ')');

			if ($result->num_rows) {
				$category_ids = array();
				foreach ($result->rows as $rec) {
					$category_ids[$rec['category_id']] = $rec['category_id'];
				}

				return $category_ids;
			}
		}

		return array();
	}

	function url_slug($str, $options = array()) {

		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());

		$defaults = array(
			'delimiter'     => '-',
			'limit'         => null,
			'lowercase'     => true,
			'replacements'  => array(),
			'transliterate' => (intval($this->config->get('seo_pp_auto_translate_seo_url')) == 1 ? true : false),
		);

		// Merge options
		$options = array_merge($defaults, $options);

		$char_map = array(
			// Latin
			'À' => 'A', 'Á'  => 'A', 'Â'  => 'A', 'Ã'  => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',

			'È' => 'E', 'É'  => 'E', 'Ê'  => 'E', 'Ë'  => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï'  => 'I',

			'Ð' => 'D', 'Ñ'  => 'N', 'Ò'  => 'O', 'Ó'  => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő'  => 'O',

			'Ø' => 'O', 'Ù'  => 'U', 'Ú'  => 'U', 'Û'  => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ'  => 'TH',

			'ß' => 'ss',

			'à' => 'a', 'á'  => 'a', 'â'  => 'a', 'ã'  => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',

			'è' => 'e', 'é'  => 'e', 'ê'  => 'e', 'ë'  => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï'  => 'i',

			'ð' => 'd', 'ñ'  => 'n', 'ò'  => 'o', 'ó'  => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő'  => 'o',

			'ø' => 'o', 'ù'  => 'u', 'ú'  => 'u', 'û'  => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ'  => 'th',

			'ÿ' => 'y',

			// Latin symbols
			'©' => '(c)',

			// Greek
			'Α' => 'A', 'Β'  => 'B', 'Γ'  => 'G', 'Δ'  => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ'  => '8',
			'Ι' => 'I', 'Κ'  => 'K', 'Λ'  => 'L', 'Μ'  => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π'  => 'P',
			'Ρ' => 'R', 'Σ'  => 'S', 'Τ'  => 'T', 'Υ'  => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ'  => 'E', 'Ί'  => 'I', 'Ό'  => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ'  => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β'  => 'b', 'γ'  => 'g', 'δ'  => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ'  => '8',
			'ι' => 'i', 'κ'  => 'k', 'λ'  => 'l', 'μ'  => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π'  => 'p',
			'ρ' => 'r', 'σ'  => 's', 'τ'  => 't', 'υ'  => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ'  => 'e', 'ί'  => 'i', 'ό'  => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς'  => 's',
			'ϊ' => 'i', 'ΰ'  => 'y', 'ϋ'  => 'y', 'ΐ'  => 'i',

			// Turkish
			'Ş' => 'S', 'İ'  => 'I', 'Ç'  => 'C', 'Ü'  => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı'  => 'i', 'ç'  => 'c', 'ü'  => 'u', 'ö' => 'o', 'ğ' => 'g',

			// Russian
			'А' => 'A', 'Б'  => 'B', 'В'  => 'V', 'Г'  => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И'  => 'I', 'Й'  => 'J', 'К'  => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О'  => 'O',
			'П' => 'P', 'Р'  => 'R', 'С'  => 'S', 'Т'  => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц'  => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы'  => 'Y', 'Ь' => '', 'Э'  => 'E', 'Ю'  => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б'  => 'b', 'в'  => 'v', 'г'  => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и'  => 'i', 'й'  => 'j', 'к'  => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о'  => 'o',
			'п' => 'p', 'р'  => 'r', 'с'  => 's', 'т'  => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц'  => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы'  => 'y', 'ь' => '', 'э'  => 'e', 'ю'  => 'yu',
			'я' => 'ya',

			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї'  => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї'  => 'yi', 'ґ' => 'g',

			// Czech
			'Č' => 'C', 'Ď'  => 'D', 'Ě'  => 'E', 'Ň'  => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů'  => 'U',

			'Ž' => 'Z',

			'č' => 'c', 'ď'  => 'd', 'ě'  => 'e', 'ň'  => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů'  => 'u',
			'ž' => 'z',

			// Polish
			'Ą' => 'A', 'Ć'  => 'C', 'Ę'  => 'e', 'Ł'  => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź'  => 'Z',

			'Ż' => 'Z',

			'ą' => 'a', 'ć'  => 'c', 'ę'  => 'e', 'ł'  => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź'  => 'z',
			'ż' => 'z',

			// Latvian
			'Ā' => 'A', 'Č'  => 'C', 'Ē'  => 'E', 'Ģ'  => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ'  => 'N',

			'Š' => 'S', 'Ū'  => 'u', 'Ž'  => 'Z',
			'ā' => 'a', 'č'  => 'c', 'ē'  => 'e', 'ģ'  => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ'  => 'n',
			'š' => 's', 'ū'  => 'u', 'ž'  => 'z',
		);

		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

		// Transliterate characters to ASCII
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}

		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Truncate slug to max. characters
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}

	public function clean_string($html = '') {

		/* Strip HTML tags and invisible text */
		$utf8_text = $this->strip_html_tags(html_entity_decode($html));

		/* Decode HTML entities */
		$utf8_text = html_entity_decode($utf8_text, ENT_QUOTES, "UTF-8");

		return preg_replace('!\s+!', ' ', trim($utf8_text));
	}

	/**
	 * Remove HTML tags, including invisible text such as style and
	 * script code, and embedded objects.  Add line breaks around
	 * block-level tags to prevent word joining after tag removal.
	 */
	function strip_html_tags($text) {
		$text = preg_replace(
			array(
				// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
				// Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(center)|(del))@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
				'@</?((table)|(th)|(td)|(caption))@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
				'@</?((frameset)|(frame)|(iframe))@iu',
			),
			array(
				' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
				"\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
				"\n\$0", "\n\$0",
			),
			$text);

		return strip_tags($text);
	}

	/*
	Usage
	============================================
	$text = "This is some text. This is some text. Vending Machines are great.";
	$words = extractCommonWords($text);
	echo implode(',', array_keys($words));
	 */
	function extractCommonWords($string) {
		$stopWords = array('a', 'about', 'above', 'above', 'across', 'after', 'afterwards', 'again', 'against', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'am', 'among', 'amongst', 'amoungst', 'amount', 'an', 'and', 'another', 'any', 'anyhow', 'anyone', 'anything', 'anyway', 'anywhere', 'are', 'around', 'as', 'at', 'back', 'be', 'became', 'because', 'become', 'becomes', 'becoming', 'been', 'before', 'beforehand', 'behind', 'being', 'below', 'beside', 'besides', 'between', 'beyond', 'bill', 'both', 'bottom', 'but', 'by', 'call', 'can', 'cannot', 'cant', 'co', 'con', 'could', 'couldnt', 'cry', 'de', 'describe', 'detail', 'do', 'done', 'down', 'due', 'during', 'each', 'eg', 'eight', 'either', 'eleven', 'else', 'elsewhere', 'empty', 'enough', 'etc', 'even', 'ever', 'every', 'everyone', 'everything', 'everywhere', 'except', 'few', 'fifteen', 'fify', 'fill', 'find', 'fire', 'first', 'five', 'for', 'former', 'formerly', 'forty', 'found', 'four', 'from', 'front', 'full', 'further', 'get', 'give', 'go', 'had', 'has', 'hasnt', 'have', 'he', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'hereupon', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'however', 'hundred', 'i', 'ie', 'if', 'in', 'inc', 'indeed', 'interest', 'into', 'is', 'it', 'its', 'itself', 'keep', 'last', 'latter', 'latterly', 'least', 'less', 'ltd', 'made', 'many', 'may', 'me', 'meanwhile', 'might', 'mill', 'mine', 'more', 'moreover', 'most', 'mostly', 'move', 'much', 'must', 'my', 'myself', 'name', 'namely', 'neither', 'never', 'nevertheless', 'next', 'nine', 'no', 'nobody', 'none', 'noone', 'nor', 'not', 'nothing', 'now', 'nowhere', 'of', 'off', 'often', 'on', 'once', 'one', 'only', 'onto', 'or', 'other', 'others', 'otherwise', 'our', 'ours', 'ourselves', 'out', 'over', 'own', 'part', 'per', 'perhaps', 'please', 'put', 'rather', 're', 'same', 'see', 'seem', 'seemed', 'seeming', 'seems', 'serious', 'several', 'she', 'should', 'show', 'side', 'since', 'sincere', 'six', 'sixty', 'so', 'some', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhere', 'still', 'such', 'system', 'take', 'ten', 'than', 'that', 'the', 'their', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'therefore', 'therein', 'thereupon', 'these', 'they', 'thickv', 'thin', 'third', 'this', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'to', 'together', 'too', 'top', 'toward', 'towards', 'twelve', 'twenty', 'two', 'un', 'under', 'until', 'up', 'upon', 'us', 'very', 'via', 'was', 'we', 'well', 'were', 'what', 'whatever', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'whereupon', 'wherever', 'whether', 'which', 'while', 'whither', 'who', 'whoever', 'whole', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'www', 'yet', 'you', 'your', 'yours', 'yourself', 'yourselves', 'the');

		$string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
		$string = trim($string); // trim the string
		$string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
		$string = strtolower($string); // make it lowercase

		preg_match_all('/\b.*?\b/i', $string, $matchWords);
		$matchWords = $matchWords[0];

		foreach ($matchWords as $key => $item) {
			if ($item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3) {
				unset($matchWords[$key]);
			}
		}

		$wordCountArr = array();
		if (is_array($matchWords)) {
			foreach ($matchWords as $key => $val) {
				$val = strtolower($val);
				if (isset($wordCountArr[$val])) {
					$wordCountArr[$val]++;
				} else {
					$wordCountArr[$val] = 1;
				}
			}
		}
		arsort($wordCountArr);
		$wordCountArr = array_slice($wordCountArr, 0, 10);
		return $wordCountArr;
	}

	/* Modification Support Functions */

	public function addProductModifier($data, $product_id = 0) {

		$data['manufacturer'] = '';
		if (intval($data['manufacturer_id']) > 0) {
			$manufacturer_info = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id=" . $data['manufacturer_id']);
			if ($manufacturer_info->num_rows) {
				$data['manufacturer'] = $manufacturer_info->row['name'];

			}
		}

		foreach ($data['product_description'] as $language_id => $value) {

			$categories = array();
			if (isset($data['product_category'])) {
				foreach ($data['product_category'] as $category_id) {
					$cat_result = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");

					if ($cat_result->num_rows) {
						$categories[] = $cat_result->row['name'];
					}
				}
			}

			if (intval($this->config->get('seo_pp_auto_product_tags')) == 1) {

				$cat_names = implode(',', $categories);

				$tag = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ',',
					strlen($data['model']) == 0 ? '' : $data['model'] . ',',
					strlen($data['price']) == 0 ? '' : $data['price'] . ',',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ',',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ',',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ',',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ',',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ',',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ',',
					strlen($data['location']) == 0 ? '' : $data['location'] . ',',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ',',
					strlen($cat_names) == 0 ? '' : $cat_names . ',',
				),
					$this->config->get('seo_pp_product_tags'));

				$data['product_description'][$language_id]['tag'] = rtrim($tag, ',');
			}

			if (intval($this->config->get('seo_pp_auto_product_seo_url')) == 1) {

				$cat_names = implode('-', $categories);

				$seo_keyword = str_replace(array(
					'[ id ]',
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					$product_id,
					strlen($value['name']) == 0 ? '' : $value['name'] . '-',
					strlen($data['model']) == 0 ? '' : $data['model'] . '-',
					strlen($data['price']) == 0 ? '' : $data['price'] . '-',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . '-',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . '-',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . '-',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . '-',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . '-',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . '-',
					strlen($data['location']) == 0 ? '' : $data['location'] . '-',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . '-',
					strlen($cat_names) == 0 ? '' : $cat_names . '-',
				),
					$this->config->get('seo_pp_product_seo_url'));

				$data['keyword'] = $this->url_slug(rtrim($seo_keyword, '-'));

				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "', language_id=" . (int) $language_id);
			}

			if (intval($this->config->get('seo_pp_auto_product_meta_title')) == 1) {

				$cat_names = implode(',', $categories);

				$meta_title = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ' ',
					strlen($data['model']) == 0 ? '' : $data['model'] . ' ',
					strlen($data['price']) == 0 ? '' : $data['price'] . ' ',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ' ',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ' ',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ' ',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ' ',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ' ',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ' ',
					strlen($data['location']) == 0 ? '' : $data['location'] . ' ',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ' ',
					strlen($cat_names) == 0 ? '' : $cat_names . ' ',
				),
					$this->config->get('seo_pp_product_meta_title'));

				$data['product_description'][$language_id]['meta_title'] = trim($meta_title);

			}

			if (intval($this->config->get('seo_pp_auto_product_meta_description')) == 1) {

				//$description = $this->model_seo_power_pack_settings->clean_string($value['description']);
				$cat_names = implode(',', $categories);

				$metadesc = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ' ',
					strlen($data['model']) == 0 ? '' : $data['model'] . ' ',
					strlen($data['price']) == 0 ? '' : $data['price'] . ' ',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ' ',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ' ',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ' ',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ' ',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ' ',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ' ',
					strlen($data['location']) == 0 ? '' : $data['location'] . ' ',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ' ',
					strlen($cat_names) == 0 ? '' : $cat_names . ' ',
				),
					$this->config->get('seo_pp_product_meta_description'));

				$data['product_description'][$language_id]['meta_description'] = trim($metadesc);

			}

			if (intval($this->config->get('seo_pp_auto_product_meta_keyword')) == 1) {

				$cat_names = implode(',', $categories);

				$meta_key = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ',',
					strlen($data['model']) == 0 ? '' : $data['model'] . ',',
					strlen($data['price']) == 0 ? '' : $data['price'] . ',',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ',',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ',',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ',',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ',',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ',',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ',',
					strlen($data['location']) == 0 ? '' : $data['location'] . ',',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ',',
					strlen($cat_names) == 0 ? '' : $cat_names . ',',
				),
					$this->config->get('seo_pp_product_meta_keyword'));

				$data['product_description'][$language_id]['meta_keyword'] = rtrim($meta_key, ',');
			}
		}

		return $data;
	}

	public function editProductModifier($data, $product_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "'");
		foreach ($data['product_description'] as $language_id => $value) {

			$categories = array();
			if (isset($data['product_category'])) {
				foreach ($data['product_category'] as $category_id) {
					$cat_result = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "' LIMIT 1");

					if ($cat_result->num_rows) {
						$categories[] = $cat_result->row['name'];
					}
				}
			}

			if (intval($this->config->get('seo_pp_auto_product_tags')) == 1) {

				$cat_names = implode(',', $categories);

				$tag = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ',',
					strlen($data['model']) == 0 ? '' : $data['model'] . ',',
					strlen($data['price']) == 0 ? '' : $data['price'] . ',',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ',',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ',',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ',',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ',',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ',',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ',',
					strlen($data['location']) == 0 ? '' : $data['location'] . ',',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ',',
					strlen($cat_names) == 0 ? '' : $cat_names . ',',
				),
					$this->config->get('seo_pp_product_tags'));

				$data['product_description'][$language_id]['tag'] = rtrim($tag, ',');
			}

			if (intval($this->config->get('seo_pp_auto_product_seo_url')) == 1) {

				$cat_names = implode('-', $categories);

				$seo_keyword = str_replace(array(
					'[ id ]',
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					$product_id,
					strlen($value['name']) == 0 ? '' : $value['name'] . '-',
					strlen($data['model']) == 0 ? '' : $data['model'] . '-',
					strlen($data['price']) == 0 ? '' : $data['price'] . '-',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . '-',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . '-',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . '-',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . '-',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . '-',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . '-',
					strlen($data['location']) == 0 ? '' : $data['location'] . '-',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . '-',
					strlen($cat_names) == 0 ? '' : $cat_names . '-',
				),
					$this->config->get('seo_pp_product_seo_url'));

				$data['keyword'] = $this->url_slug(rtrim($seo_keyword, '-'));

				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "', language_id=" . (int) $language_id);
			}

			if (intval($this->config->get('seo_pp_auto_product_meta_title')) == 1) {

				$cat_names = implode(',', $categories);

				$meta_title = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ' ',
					strlen($data['model']) == 0 ? '' : $data['model'] . ' ',
					strlen($data['price']) == 0 ? '' : $data['price'] . ' ',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ' ',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ' ',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ' ',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ' ',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ' ',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ' ',
					strlen($data['location']) == 0 ? '' : $data['location'] . ' ',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ' ',
					strlen($cat_names) == 0 ? '' : $cat_names . ' ',
				),
					$this->config->get('seo_pp_product_meta_title'));

				$data['product_description'][$language_id]['meta_title'] = trim($meta_title);

			}

			if (intval($this->config->get('seo_pp_auto_product_meta_description')) == 1) {

				//$description = $this->model_seo_power_pack_settings->clean_string($value['description']);
				$cat_names = implode(',', $categories);

				$metadesc = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ' ',
					strlen($data['model']) == 0 ? '' : $data['model'] . ' ',
					strlen($data['price']) == 0 ? '' : $data['price'] . ' ',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ' ',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ' ',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ' ',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ' ',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ' ',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ' ',
					strlen($data['location']) == 0 ? '' : $data['location'] . ' ',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ' ',
					strlen($cat_names) == 0 ? '' : $cat_names . ' ',
				),
					$this->config->get('seo_pp_product_meta_description'));

				$data['product_description'][$language_id]['meta_description'] = trim($metadesc);

			}

			if (intval($this->config->get('seo_pp_auto_product_meta_keyword')) == 1) {

				$cat_names = implode(',', $categories);

				$meta_key = str_replace(array(
					'[ name ]',
					'[ model ]',
					'[ price ]',
					'[ sku ]',
					'[ upc ]',
					'[ ean ]',
					'[ jan ]',
					'[ isbn ]',
					'[ mpn ]',
					'[ location ]',
					'[ manufacturer ]',
					'[ category ]',
				), array(
					strlen($value['name']) == 0 ? '' : $value['name'] . ',',
					strlen($data['model']) == 0 ? '' : $data['model'] . ',',
					strlen($data['price']) == 0 ? '' : $data['price'] . ',',
					strlen($data['sku']) == 0 ? '' : $data['sku'] . ',',
					strlen($data['upc']) == 0 ? '' : $data['upc'] . ',',
					strlen($data['ean']) == 0 ? '' : $data['ean'] . ',',
					strlen($data['jan']) == 0 ? '' : $data['jan'] . ',',
					strlen($data['isbn']) == 0 ? '' : $data['isbn'] . ',',
					strlen($data['mpn']) == 0 ? '' : $data['mpn'] . ',',
					strlen($data['location']) == 0 ? '' : $data['location'] . ',',
					strlen($data['manufacturer']) == 0 ? '' : $data['manufacturer'] . ',',
					strlen($cat_names) == 0 ? '' : $cat_names . ',',
				),
					$this->config->get('seo_pp_product_meta_keyword'));

				$data['product_description'][$language_id]['meta_keyword'] = rtrim($meta_key, ',');
			}
		}

		return $data;
	}
}