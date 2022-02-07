<?php
ini_set('memory_limit', '124M');
#set_time_limit(0);
class ControllerSeoPowerPackCategories extends Controller {

	public function index() {
		$this->load->language('seo_power_pack/settings');
		$this->load->model('setting/setting');
		$this->load->model('seo_power_pack/categories');

		$filter_fields = array(
			'page'                    => 1,
			'limit'                   => $this->config->get('config_limit_admin'),
			'language_id'             => $this->config->get('config_language_id'),
			'sort'                    => 'cd.name',
			'order'                   => 'ASC',
			'filter_name'             => '',
			'filter_meta_title'       => '',
			'filter_meta_description' => '',
			'filter_meta_keyword'     => '',
			'tab_container'           => '',
		);

		$url    = array();
		$ob_url = array();
		foreach ($filter_fields as $field_name => $field_default) {
			if (isset($this->request->get[$field_name])) {
				$data[$field_name] = $this->request->get[$field_name];
			} else {
				$data[$field_name] = $field_default;
			}

			if (!empty($data[$field_name])) {
				if ($field_name != 'page') {
					$url[] = $field_name . '=' . $data[$field_name];

					if ($field_name != 'sort' && $field_name != 'order') {
						$ob_url[] = $field_name . '=' . $data[$field_name];
					}
				}
			}
		}

		$url[]    = 'token=' . $this->session->data['token'];
		$ob_url[] = 'token=' . $this->session->data['token'];

		$data['paging_url'] = 'index.php?route=seo_power_pack/categories&' . implode('&', $url);
		$data['ob_url']     = 'index.php?route=seo_power_pack/categories&' . implode('&', $ob_url);

		$filter_data = array(
			'filter_name'             => $data['filter_name'],
			'filter_meta_title'       => $data['filter_meta_title'],
			'filter_meta_description' => $data['filter_meta_description'],
			'filter_meta_keyword'     => $data['filter_meta_keyword'],
			'sort'                    => $data['sort'],
			'order'                   => $data['order'],
			'start'                   => ($data['page'] - 1) * $data['limit'],
			'limit'                   => $data['limit'],
		);

		$data['total'] = $this->model_seo_power_pack_categories->getTotalCategories($filter_data, $data['language_id']);

		$results = $this->model_seo_power_pack_categories->getCategories($filter_data, $data['language_id']);

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id'      => $result['category_id'],
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'seo_keyword'      => $this->model_seo_power_pack_categories->getUrlAlias($result['category_id'], $data['language_id']),
			);
		}

		$data['token'] = $this->session->data['token'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	function update() {
		if (!$this->__hasPermission()) {
			exit;
		}
		$this->load->model('seo_power_pack/settings');

		if (isset($this->request->get['fn'])) {
			$value_arr[$this->request->get['language_id']] = trim($this->request->get['fv']);
			switch ($this->request->get['fn']) {
				case 'cat_name':
					$this->model_seo_power_pack_settings->updateCategoryName(
						$this->request->get['category_id'],
						$value_arr
					);
					break;
				case 'cat_mt':
					$this->model_seo_power_pack_settings->updateCategoryMetaTitle(
						$this->request->get['category_id'],
						$value_arr
					);
					break;
				case 'cat_mk':
					$this->model_seo_power_pack_settings->updateCategoryMetaKeyword(
						$this->request->get['category_id'],
						$value_arr
					);
					break;
				case 'cat_md':
					$this->model_seo_power_pack_settings->updateCategoryMetaDescription(
						$this->request->get['category_id'],
						$value_arr
					);
					break;
				case 'cat_seo':
					$this->model_seo_power_pack_settings->addCategorySEOUrlByLanguage(
						$this->request->get['category_id'],
						$this->request->get['fv'],
						$this->request->get['language_id']
					);
					break;
				default:
					# code...
					break;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode(array('success' => 1)));
	}

	private function __hasPermission() {
		if (!$this->user->hasPermission('modify', 'seo_power_pack/categories')) {
			return false;
		}
		return true;
	}
}